<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Reservation $model */

$this->title = Yii::t('app', 'Create Reservation');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Reservations'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="reservation-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
