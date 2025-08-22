<?php
namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\Athlete;
use app\models\Sport;

class AthleteController extends Controller
{
    // LIST all athletes
    public function actionIndex()
    {
        $athletes = Athlete::find()
            ->orderBy(['created_at' => SORT_DESC])
            ->all();

        return $this->render('index', [
            'athletes' => $athletes,
        ]);
    }

    // REGISTER a new athlete (create)
    public function actionCreate()
    {
        $model = new Athlete();
        $sports = Sport::find()->orderBy(['name' => SORT_ASC])->all();
        $errors = [];

        if (Yii::$app->request->isPost) {
            $data = Yii::$app->request->post('Athlete', []);

            if ($model->manualValidate($data)) {
                if (isset($GLOBALS['USER']) && isset($GLOBALS['USER']->id)) {
                    $model->created_by = (int)$GLOBALS['USER']->id;
                }
                // Persist without built-in validation
                if ($model->save(false)) {
                    Yii::$app->session->setFlash('success', 'Athlete registered.');
                    return $this->redirect(['index']);
                } else {
                    $errors['general'][] = 'Failed to save athlete due to a database error.';
                }
            } else {
                $errors = $model->getErrorsBag();
            }
        }

        return $this->render('create', [
            'model' => $model,
            'sports' => $sports,
            'errors' => $errors,
        ]);
    }
}
