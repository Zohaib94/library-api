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
}
