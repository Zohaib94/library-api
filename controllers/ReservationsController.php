<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\Reservation;
use app\models\ReservationSearch;
use app\models\Room;
use yii\data\ActiveDataProvider;
use yii\helpers\Html;

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
        'LIKE',
        'customer.surname',
        $searchModel->getAttribute('customer.surname')
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

  public function actionMultipleGrid()
  {
    $reservationsQuery = Reservation::find();
    $reservationSearchModel = new ReservationSearch();

    if (isset($_GET['ReservationSearch'])) {
      $reservationSearchModel->load(Yii::$app->request->get());

      $reservationsQuery->joinWith(['customer']);
      $reservationsQuery->andFilterWhere([
        'LIKE',
        'customer.surname',
        $reservationSearchModel->getAttribute('customer.surname')
      ]);

      $reservationsQuery->andFilterWhere([
        'id' => $reservationSearchModel->id,
        'room_id' => $reservationSearchModel->room_id,
        'price_per_day' => $reservationSearchModel->price_per_day,
        'customer_id' => $reservationSearchModel->customer_id,
      ]);
    }

    $reservationsDataProvider = new ActiveDataProvider([
      'query' => $reservationsQuery,
      'pagination' => [
        'pageSize' => 10,
        'pageParam' => 'reservations-page-param'
      ],
      'sort' => [
        'sortParam' => 'reservations-sort-param'
      ],
    ]);

    $roomsQuery = Room::find();
    $roomsSearchModel = new Room();

    if (isset($_GET['Room'])) {
      $roomsSearchModel->load(\Yii::$app->request->get());

      $roomsQuery->andFilterWhere([
        'id' => $roomsSearchModel->id,
        'floor' => $roomsSearchModel->floor,
        'room_number' => $roomsSearchModel->room_number,
        'has_conditioner' => $roomsSearchModel->has_conditioner,
        'has_phone' => $roomsSearchModel->has_conditioner,
        'has_tv' => $roomsSearchModel->has_conditioner,
        'available_from' => $roomsSearchModel->has_conditioner,
      ]);
    }

    $roomsDataProvider = new \yii\data\ActiveDataProvider([
      'query' => $roomsQuery,
      'sort' => [
        'sortParam' => 'rooms-sort-param',
      ],
      'pagination' => [
        'pageSize' => 10,
        'pageParam' => 'rooms-page-param'
      ],
    ]);

    return $this->render('multipleGrid', [
      'reservationsDataProvider' => $reservationsDataProvider,
      'reservationsSearchModel' => $reservationSearchModel,
      'roomsDataProvider' => $roomsDataProvider,
      'roomsSearchModel' => $roomsSearchModel,
    ]);
  }

  public function actionDetailDependentDropdown()
  {
    $showDetail = false;
    $model = new Reservation();

    if (isset($_POST['Reservation'])) {
      $model->load(Yii::$app->request->post());

      if (isset($_POST['Reservation']['id']) && $_POST['Reservation']['id'] != null) {
        $model = Reservation::findOne($_POST['Reservation']['id']);
        $showDetail = true;
      }
    }

    return $this->render('detailDependentDropdown', [
      'model' => $model,
      'showDetail' => $showDetail
    ]);
  }

  public function actionAjaxDropDownListByCustomerId($customer_id)
  {
    $output = '';
    $items = Reservation::findAll([
      'customer_id' => $customer_id,
    ]);

    foreach ($items as $item) {
      $content = sprintf('reservation #%s at %s', $item->id, date('Y-m-d H:i:s', strtotime($item->reservation_date)));
      $output .= Html::tag('option', $content, ['value' => $item->id]);
    }

    return $output;
  }
}
