<?php
namespace app\models;

use yii\db\ActiveRecord;
use Yii;
use app\models\Sport;

/**
 * Athlete ActiveRecord with manual validation.
 * Controller will call $model->manualValidate($data) and then $model->save(false).
 */
// Relation to Athelete's so that list view can show sport name
public function getSport()
{
    return $this->hasOne(Sport::class, ['id' => 'sport_id']);
}

class Athlete extends ActiveRecord
{
    public static function tableName() { return 'athletes'; }

    /** @var array<string, string[]> collected validation errors */
    private array $errorsBag = [];

    public function getErrorsBag(): array { return $this->errorsBag; }

    /**
     * Manual validation entry point.
     * @param array $
     * @return bool true if valid, false otherwise
     */
    public function manualValidate(array $data): bool
    {
        $this->errorsBag = [];

        // 1) Normalize & assign 
        $this->given_name = isset($data['given_name']) ? trim((string)$data['given_name']) : '';
        $this->family_name = isset($data['family_name']) ? trim((string)$data['family_name']) : '';
        $this->date_of_birth = isset($data['date_of_birth']) ? trim((string)$data['date_of_birth']) : '';
        $this->sport_id = isset($data['sport_id']) ? (int)$data['sport_id'] : 0;
        $this->personal_best_time = isset($data['personal_best_time']) ? trim((string)$data['personal_best_time']) : '';

        // 2) Field validations (custom)
        $this->validateName('given_name', $this->given_name);
        $this->validateName('family_name', $this->family_name);
        $this->validateDateOfBirth($this->date_of_birth);
        $this->validateSport($this->sport_id);
        $this->validateHHMMSS($this->personal_best_time);

        return empty($this->errorsBag);
    }

    private function addError(string $attr, string $message): void
    {
        if (!isset($this->errorsBag[$attr])) $this->errorsBag[$attr] = [];
        $this->errorsBag[$attr][] = $message;
    }

    private function validateName(string $attr, string $value): void
    {
        // Each part of the name must have at least 3 characters.
        if ($value === '') {
            $this->addError($attr, 'Required.');
            return;
        }
        // mb_strlen to respect multibyte; Did not use Inbuilt Validator::string().
        if (mb_strlen($value) < 3) {
            $this->addError($attr, 'Must be at least 3 characters.');
        }
    }

    private function validateDateOfBirth(string $value): void
    {
        // Expected YYYY-MM-DD (manual check, no use of DateTime Parser).
        if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $value)) {
            $this->addError('date_of_birth', 'Invalid format, expected YYYY-MM-DD.');
            return;
        }
        [$Y, $M, $D] = array_map('intval', explode('-', $value));
        if (!checkdate($M, $D, $Y)) {
            $this->addError('date_of_birth', 'Invalid calendar date.');
            return;
        }

        // Age ≥ 12 on registration day (today)
        $today = date('Y-m-d');
        [$y2, $m2, $d2] = array_map('intval', explode('-', $today));

        $age = $y2 - $Y;
        if ($m2 < $M || ($m2 === $M && $d2 < $D)) {
            $age -= 1;
        }
        if ($age < 12) {
            $this->addError('date_of_birth', 'Athlete must be at least 12 years old at registration.');
        }
    }

    private function validateSport(int $sportId): void
    {
        if ($sportId <= 0) {
            $this->addError('sport_id', 'Select a sport.');
            return;
        }
        // Ensure selected sport exists (manual DB check)
        if (!Sport::find()->where(['id' => $sportId])->exists()) {
            $this->addError('sport_id', 'Selected sport is invalid.');
        }
    }

    private function validateHHMMSS(string $value): void
    {
        // Strict hh:mm:ss without DateTime parsing.
        if (!preg_match('/^\d{2}:\d{2}:\d{2}$/', $value)) {
            $this->addError('personal_best_time', 'Time must be in hh:mm:ss.');
            return;
        }
        $h = (int)substr($value, 0, 2);
        $m = (int)substr($value, 3, 2);
        $s = (int)substr($value, 6, 2);

        if ($m < 0 || $m > 59 || $s < 0 || $s > 59) {
            $this->addError('personal_best_time', 'Minutes and seconds must be between 00 and 59.');
        }
       
}
