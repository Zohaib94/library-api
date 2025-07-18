<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\Reservation;
use app\models\ReservationSearch;
use yii\data\ActiveDataProvider;

class ReservationsController extends Controller
{
  public function actionGrid()
  {
    $query = Reservation::find();
    $searchModel = new ReservationSearch();

    if (isset($_GET['ReservationSearch'])) {
      $searchModel->load(Yii::$app->request->get());

      $query->joinWith(['customer']);
      $query->andFilterWhere([
        'LIKE', 'customer.surname', $searchModel->getAttribute('customer.surname')
      ]);
  
      $query->andFilterWhere([
        'id' => $searchModel->id,
        'room_id' => $searchModel->room_id,
        'price_per_day' => $searchModel->price_per_day,
        'customer_id' => $searchModel->customer_id,
      ]);
    }

    $resultQueryAveragePricePerDay = $query->average('price_per_day');

    $dataProvider = new ActiveDataProvider([
      'query' => $query,
      'pagination' => [
        'pageSize' => 10,
      ]
    ]);

    return $this->render('grid', [
      'dataProvider' => $dataProvider,
      'searchModel' => $searchModel,
      'resultQueryAveragePricePerDay' => $resultQueryAveragePricePerDay
    ]);
  }
}
