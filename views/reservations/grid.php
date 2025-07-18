<?php

use \yii\helpers\Html;
use app\components\GridViewReservation;
?>

<?php
$roomsFilterData = yii\helpers\ArrayHelper::map(app\models\Room::find()->all(), 'id', function ($model, $defaultValue) {
  return sprintf('Floor: %d - Number: %d', $model->floor, $model->room_number);
});
?>

<?= GridViewReservation::widget([
  'dataProvider' => $dataProvider,
  'filterModel' => $searchModel,
  'showFooter' => true,
  'columns' => [
    'id',
    [
      'header' => 'Room',
      'filter' => Html::activeDropDownList(
        $searchModel,
        'room_id',
        $roomsFilterData,
        ['prompt' => '--- all']
      ),
      'content' => function ($model) {
        return $model->room->floor;
      }
    ],
    [
      'attribute' => 'price_per_day',
      'footer' => Yii::$app->formatter->asCurrency($resultQueryAveragePricePerDay, 'EUR')
    ],
    [
      'header' => 'Customer',
      'attribute' => 'customer.surname',
    ],
    'date_from',
    'date_to',
    [
      'class' => 'yii\grid\ActionColumn',
      'template' => '{delete}',
      'header' => 'Actions',
    ],
  ],
]) ?>
