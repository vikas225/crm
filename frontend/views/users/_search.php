<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\UserSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'device_id') ?>

    <?= $form->field($model, 'name') ?>

    <?= $form->field($model, 'email') ?>

    <?= $form->field($model, 'password') ?>

    <?php // echo $form->field($model, 'address') ?>

    <?php // echo $form->field($model, 'city') ?>

    <?php // echo $form->field($model, 'roles_id') ?>

    <?php // echo $form->field($model, 'country_code') ?>

    <?php // echo $form->field($model, 'mobile_no') ?>

    <?php // echo $form->field($model, 'imei_no') ?>

    <?php // echo $form->field($model, 'sim_no') ?>

    <?php // echo $form->field($model, 'device_type') ?>

    <?php // echo $form->field($model, 'otp_expiry') ?>

    <?php // echo $form->field($model, 'email_key') ?>

    <?php // echo $form->field($model, 'accessToken') ?>

    <?php // echo $form->field($model, 'auth_key') ?>

    <?php // echo $form->field($model, 'sos_smart_password') ?>

    <?php // echo $form->field($model, 'active') ?>

    <?php // echo $form->field($model, 'lat_lat') ?>

    <?php // echo $form->field($model, 'last_long') ?>

    <?php // echo $form->field($model, 'last_battery_status') ?>

    <?php // echo $form->field($model, 'registration_datetime') ?>

    <?php // echo $form->field($model, 'modified_dateime') ?>

    <?php // echo $form->field($model, 'is_email_verified') ?>

    <?php // echo $form->field($model, 'is_mobile_verified') ?>

    <?php // echo $form->field($model, 'gcm_id') ?>

    <?php // echo $form->field($model, 'email_link_date') ?>

    <?php // echo $form->field($model, 'otp_code') ?>

    <?php // echo $form->field($model, 'image') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
