<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model frontend\models\User */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'device_id',
            'name',
            'email:email',
            'password',
            'address:ntext',
            'city',
            'roles_id',
            'country_code',
            'mobile_no',
            'imei_no',
            'sim_no',
            'device_type',
            'otp_expiry',
            'email_key:email',
            'accessToken',
            'auth_key',
            'sos_smart_password',
            'active',
            'lat_lat',
            'last_long',
            'last_battery_status',
            'registration_datetime',
            'modified_dateime',
            'is_email_verified:email',
            'is_mobile_verified',
            'gcm_id',
            'email_link_date:email',
            'otp_code',
            'image',
        ],
    ]) ?>

</div>
