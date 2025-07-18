<?php

use \yii\helpers\Html;
use \yii\grid\GridView;

$roomsFilterData = yii\helpers\ArrayHelper::map(app\models\Room::find()->all(), 'id', function ($model, $defaultValue) {
  return sprintf('Floor: %d - Number: %d', $model->floor, $model->room_number);
});

?>
<?= GridView::widget([
  'dataProvider' => $dataProvider,
  'filterModel' => $searchModel,
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
    'price_per_day',
    [
      'class' => 'yii\grid\ActionColumn',
      'template' => '{delete}',
      'header' => 'Actions',
    ],
  ],
]) ?>