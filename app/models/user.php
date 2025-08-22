<?php
namespace app\models;

use yii\db\ActiveRecord;

class User extends ActiveRecord
{
    public static function tableName() { return 'users'; }

    // Simple role-based helpers
    public function canView(): bool   { return in_array($this->role, ['admin','editor','viewer'], true); }
    public function canCreate(): bool { return in_array($this->role, ['admin','editor'], true); }
    public function canUpdate(): bool { return in_array($this->role, ['admin','editor'], true); }
    public function canDelete(): bool { return $this->role === 'admin'; }

    // Basic password check 
    public function verifyPassword(string $plain): bool
    {
        return password_verify($plain, $this->password_hash);
    }
}
