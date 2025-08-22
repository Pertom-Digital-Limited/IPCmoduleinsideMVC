<?php
namespace app\models;

use yii\db\ActiveRecord;

class Sport extends ActiveRecord
{
    public static function tableName() { return 'sports'; }
}
