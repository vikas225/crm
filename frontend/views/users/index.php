<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Users';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create User', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'device_id',
            'name',
            'email:email',
            'password',
            // 'address:ntext',
            // 'city',
            // 'roles_id',
            // 'country_code',
            // 'mobile_no',
            // 'imei_no',
            // 'sim_no',
            // 'device_type',
            // 'otp_expiry',
            // 'email_key:email',
            // 'accessToken',
            // 'auth_key',
            // 'sos_smart_password',
            // 'active',
            // 'lat_lat',
            // 'last_long',
            // 'last_battery_status',
            // 'registration_datetime',
            // 'modified_dateime',
            // 'is_email_verified:email',
            // 'is_mobile_verified',
            // 'gcm_id',
            // 'email_link_date:email',
            // 'otp_code',
            // 'image',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
