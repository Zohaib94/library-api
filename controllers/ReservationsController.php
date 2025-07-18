<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\Reservation;
use yii\data\ActiveDataProvider;

class ReservationsController extends Controller
{
  public function actionGrid()
  {
    $query = Reservation::find();
    $searchModel = new Reservation();

    if (isset($_GET['Reservation'])) {
      $searchModel->load(Yii::$app->request->get());
  
      $query->andFilterWhere([
        'id' => $searchModel->id,
        'room_id' => $searchModel->room_id,
        'price_per_day' => $searchModel->price_per_day,
        'customer_id' => $searchModel->customer_id,
      ]);
    }

    $dataProvider = new ActiveDataProvider([
      'query' => $query,
      'pagination' => [
        'pageSize' => 10,
      ]
    ]);

    return $this->render('grid', ['dataProvider' => $dataProvider, 'searchModel' => $searchModel]);
  }
}
