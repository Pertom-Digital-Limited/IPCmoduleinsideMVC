<?php
/** @var app\models\Athlete[] $athletes */
use yii\helpers\Html;
?>
<h1>International Paralympic Commitee Athletes</h1>

<p><?= Html::a('Register New Athlete', ['create'], ['class' => 'btn btn-primary']) ?></p>

<table class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>#</th>
            <th>Given Name</th>
            <th>Family Name</th>
            <th>Date of Birth</th>
            <th>Sport</th>
            <th>Personal Best (hh:mm:ss)</th>
            <th>Created At</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($athletes as $a): ?>
        <tr>
            <td><?= Html::encode($a->id) ?></td>
            <td><?= Html::encode($a->given_name) ?></td>
            <td><?= Html::encode($a->family_name) ?></td>
            <td><?= Html::encode($a->date_of_birth) ?></td>
            <td><?= Html::encode($a->sport->name ?? '') ?></td>
            <td><?= Html::encode($a->personal_best_time) ?></td>
            <td><?= Html::encode($a->created_at) ?></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
