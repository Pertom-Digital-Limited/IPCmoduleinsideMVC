<?php
/** @var app\models\Athlete $model */
/** @var app\models\Sport[] $sports */
/** @var array $errors */
use yii\helpers\Html;
use yii\helpers\Url;

function fieldErrors(array $errors, string $attr): string {
    if (!isset($errors[$attr])) return '';
    return '<ul class="text-danger" style="margin:4px 0 0 0;">'
        . implode('', array_map(fn($e) => '<li>'.Html::encode($e).'</li>', $errors[$attr]))
        . '</ul>';
}
?>
<h1>Register IPC Athlete</h1>

<?php if (!empty($errors['general'])): ?>
<div class="alert alert-danger">
    <?php foreach ($errors['general'] as $e): ?>
        <div><?= Html::encode($e) ?></div>
    <?php endforeach; ?>
</div>
<?php endif; ?>

<form method="post" action="<?= Url::to(['athlete/create']) ?>">
    <?= Html::hiddenInput(Yii::$app->request->csrfParam, Yii::$app->request->getCsrfToken()) ?>

    <div class="mb-3">
        <label class="form-label">Given Name</label>
        <input type="text" name="Athlete[given_name]" class="form-control"
               value="<?= Html::encode($model->given_name) ?>" />
        <?= fieldErrors($errors, 'given_name') ?>
    </div>

    <div class="mb-3">
        <label class="form-label">Family Name</label>
        <input type="text" name="Athlete[family_name]" class="form-control"
               value="<?= Html::encode($model->family_name) ?>" />
        <?= fieldErrors($errors, 'family_name') ?>
    </div>

    <div class="mb-3">
        <label class="form-label">Date of Birth (YYYY-MM-DD)</label>
        <input type="text" name="Athlete[date_of_birth]" class="form-control"
               placeholder="YYYY-MM-DD"
               value="<?= Html::encode($model->date_of_birth) ?>" />
        <?= fieldErrors($errors, 'date_of_birth') ?>
    </div>

    <div class="mb-3">
        <label class="form-label">Sport</label>
        <select name="Athlete[sport_id]" class="form-select">
            <option value="">-- Select --</option>
            <?php foreach ($sports as $s): ?>
                <option value="<?= (int)$s->id ?>"
                    <?= (int)$model->sport_id === (int)$s->id ? 'selected' : '' ?>>
                    <?= Html::encode($s->name) ?>
                </option>
            <?php endforeach; ?>
        </select>
        <?= fieldErrors($errors, 'sport_id') ?>
    </div>

    <div class="mb-3">
        <label class="form-label">Personal Best Time (hh:mm:ss)</label>
        <input type="text" name="Athlete[personal_best_time]" class="form-control"
               placeholder="hh:mm:ss"
               value="<?= Html::encode($model->personal_best_time) ?>" />
        <?= fieldErrors($errors, 'personal_best_time') ?>
    </div>

    <button type="submit" class="btn btn-success">Register</button>
    <a href="<?= Url::to(['athlete/index']) ?>" class="btn btn-secondary">Cancel</a>
</form>
