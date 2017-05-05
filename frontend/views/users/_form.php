<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\User */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'device_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'password')->passwordInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'address')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'city')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'roles_id')->textInput() ?>

    <?= $form->field($model, 'country_code')->textInput() ?>

    <?= $form->field($model, 'mobile_no')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'imei_no')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'sim_no')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'device_type')->dropDownList([ 'android' => 'Android', 'ios' => 'Ios', 'windows' => 'Windows', 'rim' => 'Rim', 'other' => 'Other', ], ['prompt' => '']) ?>

    <?= $form->field($model, 'otp_expiry')->textInput() ?>

    <?= $form->field($model, 'email_key')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'accessToken')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'auth_key')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'sos_smart_password')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'active')->textInput() ?>

    <?= $form->field($model, 'lat_lat')->textInput() ?>

    <?= $form->field($model, 'last_long')->textInput() ?>

    <?= $form->field($model, 'last_battery_status')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'registration_datetime')->textInput() ?>

    <?= $form->field($model, 'modified_dateime')->textInput() ?>

    <?= $form->field($model, 'is_email_verified')->dropDownList([ 'Y' => 'Y', 'N' => 'N', ], ['prompt' => '']) ?>

    <?= $form->field($model, 'is_mobile_verified')->dropDownList([ 'Y' => 'Y', 'N' => 'N', ], ['prompt' => '']) ?>

    <?= $form->field($model, 'gcm_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'email_link_date')->textInput() ?>

    <?= $form->field($model, 'otp_code')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'image')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
