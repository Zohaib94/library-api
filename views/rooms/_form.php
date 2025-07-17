<?php
    use yii\widgets\ActiveForm;
    use yii\helpers\Html;
?>

<div class="row">
    <div class="col-lg-6">
        <h2>Create a new room</h2>
        <?php $form = ActiveForm::begin(['id' => 'room-form']) ?>
        <?php echo $form->field($model, 'floor')->textInput(); ?>
        <?php echo $form->field($model, 'room_number')->textInput(); ?>
        <?php echo $form->field($model, 'has_conditioner')->checkbox(); ?>
        <?php echo $form->field($model, 'has_tv')->checkbox(); ?>
        <?php echo $form->field($model, 'has_phone')->checkbox();
        ?>
        <?php echo $form->field($model, 'available_from')->textInput(); ?>
        <?php echo $form->field($model, 'price_per_day')->textInput(); ?>
        <?php echo $form->field($model, 'description')->textArea(); ?>
        <?php echo Html::submitButton('Save', ['class' => 'btn
 btn-primary']); ?>
        <?php ActiveForm::end() ?>
    </div>
</div>