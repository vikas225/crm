<?php
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */

$this->title = 'Mobile Verification';
//$this->params['breadcrumbs'][] = $this->title;
//$readonly = false;
$isdCode=Yii::$app->params['phoneCodes'];
// $codes = array_map(function ($ar,$k) {
//         return array($k=>$ar['name'].' '.'(+'.$k.')');
//     }, $isdCode,array_keys($isdCode));
foreach ($isdCode as $key => $value) {
    $codes[$key]= $value['name'].' '.'(+'.$key.')';
}
?>
<div class="clearfix"></div>
        <section class="content">
        <?php $form = ActiveForm::begin([
                        'action' => ['users/verify-mobile'],
                        'id' => 'verify-mobile',
                    ]); ?>
            <div class="container">
                <div class="row intro-section">
                    <div class="col-lg-12">
                        <h3 class="text-center"><?= $this->title; ?></h3>
                        <div class="row" id="sentotp" style="display:none;">Verification message sent to your mobile.</div>
                        <div class="col-lg-6 mt-30">
                            <div class="mt-30 relative">
                              <?= $form->field($model, 'country_code', ['template' => '<div class="registeration-text">{label}</div><div class="registeration-input-space">{input}{error}</div>'])->dropDownList($codes) ?>
                            </div>
                            <div class="mt-30 relative">
                              <?= $form->field($model, 'mobile_no', ['template' => '<div class="registeration-text">{label}</div><div class="registeration-input-space">{input}{error}</div>'])->textInput(['class' => 'registeration-input','maxlength' => 15,'placeholder'=>'Mobile Number']) ?>
                            </div>  
                            <div class="mt-30 relative">
                              <?= $form->field($model, 'otp_code', ['template' => '<div class="registeration-text">{label}</div><div class="registeration-input-space">{input}{error}</div>'])->textInput(['class' => 'registeration-input','maxlength' => 15,'placeholder'=>'OTP Code', 'disabled'=>'disabled' , 'value'=>'']) ?>
                            </div>                            
                        </div>  
                    </div>
                    <div class="clearfix"></div>
                    <div class="col-lg-12 mt-sm-elarge text-center mt-30">
                   <a href="javascript:void(0)" onclick="sendOTP();" id="otp-button">Send OTP</a>
                  </div>
                    <div class="col-lg-12 mt-sm-elarge text-center mt-30">
                      <?= Html::submitButton('Register', ['class' =>'blue-btn w60']) ?>
                    </div>
                </div>
                </div><!--/.row-->
            </div>            
            <?php ActiveForm::end(); ?>
        </section><!--/.content-->
        <div class="clearfix"></div>