<?php

namespace app\controllers;

use Yii;
use yii\data\ActiveDataProvider;
use \yii\web\Controller;
use \app\models\Customer;

class CustomerController extends Controller
{
  public function actionGrid()
  {
    $query = Customer::find();

    $dataProvider = new ActiveDataProvider([
      'query' => $query,
      'pagination' => [
        'pageSize' => 10
      ]
    ]);

    return $this->render('grid', ['dataProvider' => $dataProvider]);
  }

  public function actionCreateMultipleModels()
  {
    $models = [];

    if (isset($_POST['Customer'])) {
      $validateOK = true;

      foreach ($_POST['Customer'] as $postObj) {
        $model = new Customer();
        $model->attributes = $postObj;
        $models[] = $model;

        $validateOK = ($validateOK && $model->validate());
      }

      if ($validateOK) {
        foreach ($models as $model) {
          $model->save();
        }

        return $this->redirect(['grid']);
      }
    } else {
      for ($k = 0; $k < 3; $k++) {
        $models[] = new Customer();
      }
    }

    return $this->render('createMultipleModels', ['models' => $models]);
  }
}
