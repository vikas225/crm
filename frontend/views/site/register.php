<?php
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */

$this->title = 'Register';
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
                      'fieldConfig' => [
                          'template' => '<div class="registeration-text">{label}</div><div class="registeration-input-space">{input}{error}</div>'
                        ],
                        'id' => 'register-form',
                    ]); ?>
            <div class="container">
                <div class="row intro-section">
                    <div class="col-lg-12">
                        <h3 class="text-center">Registration</h3>
                        <div class="row"></div>
                        <div class="col-lg-6 mt-30">
                            <div class="pull-left mb-20" style="width: 100%">
                                <span class="pull-left"><img src="<?= Yii::$app->request->baseUrl ?>/images/img-blue.png"></span>
                                <span class="blue-txt pd-l-2 fs-18 pull-left">Personal Details</span>
                            </div>
                            <div class="clearfix"></div>
                            <div class="mt-30 relative">
                              <?= $form->field($modelUser, 'country_code')->dropDownList($codes, ['prompt' => '---Select---', 'options' => [91 => ['selected'=>true]]]) ?>
                            </div>
                            <div class="mt-30 relative">
                              <?= $form->field($modelUser, 'mobile_no', ['template' => '<div class="registeration-text">{label}</div><div class="registeration-input-space">{input}{error}</div>'])->textInput(['class' => 'registeration-input numeric','maxlength' => 15,'placeholder'=>'Mobile Number']) ?>
                            </div>
                            <div class="mt-30 relative">
                              <?= $form->field($modelUser, 'email', ['template' => '<div class="registeration-text">{label}</div><div class="registeration-input-space">{input}{hint}{error}</div>'])->textInput(['class' => 'registeration-input','maxlength' => 100,'placeholder'=>'Email'])->hint('Verification email will be sent to this email id'); ?>
                            </div>
                            <div class="mt-30 relative">
                              <?= $form->field($modelUser, 'password', ['template' => '<div class="registeration-text">{label}</div><div class="registeration-input-space">{input}{error}</div>'])->passwordInput(['class' => 'registeration-input','maxlength' => 50,'placeholder'=>'Password']) ?>
                            </div>
                            <div class="mt-30 relative">
                              <?= $form->field($modelUser, 'confirm_password', ['template' => '<div class="registeration-text">{label}</div><div class="registeration-input-space">{input}{error}</div>'])->passwordInput(['class' => 'registeration-input','maxlength' => 50,'placeholder'=>'Confirm Password']) ?>
                            </div>
                            <div class="mt-30 relative">
                              <?= $form->field($modelUser, 'name', ['template' => '<div class="registeration-text">{label}</div><div class="registeration-input-space">{input}{error}</div>'])->textInput(['class' => 'registeration-input','maxlength' => 50,'placeholder'=>'Name']) ?>
                            </div>
                            <div class="mt-30 relative">
                              <?= $form->field($modelUser, 'address', ['template' => '<div class="registeration-text">{label}</div><div class="registeration-input-space">{input}{error}</div>'])->textarea(['class' => 'registeration-input','maxlength' => 500,'placeholder'=>'Address']) ?>
                            </div>
                            <div class="mt-30 relative">
                              <?= $form->field($modelUser, 'city', ['template' => '<div class="registeration-text">{label}</div><div class="registeration-input-space">{input}{error}</div>'])->textInput(['class' => 'registeration-input','maxlength' => 50,'placeholder'=>'City']) ?>
                            </div>
                        </div>
                        <div class="col-lg-6 mt-30">
                             <div class="pull-left mb-20" style="width: 100%">
                                <span class="pull-left"><img src="<?= Yii::$app->request->baseUrl ?>/images/img-blue.png"></span>
                                <span class="blue-txt pd-l-2 fs-18 pull-left">Company Details</span>
                            </div>
                            <div class="clearfix"></div>
                            <div class="mt-30 relative">
                              <?= $form->field($modelCompany, 'name', ['template' => '<div class="registeration-text">{label}</div><div class="registeration-input-space">{input}{error}</div>'])->textInput(['class' => 'registeration-input','maxlength' => 50,'placeholder'=>'Company Name']) ?>
                            </div>
                            <div class="mt-30 relative">
                              <?= $form->field($modelCompany, 'email', ['template' => '<div class="registeration-text">{label}</div><div class="registeration-input-space">{input}{error}</div>'])->textInput(['class' => 'registeration-input','maxlength' => 50,'placeholder'=>'Company Email']) ?>
                            </div>
                            <div class="mt-30 relative">
                              <?= $form->field($modelCompany, 'phone_no', ['template' => '<div class="registeration-text">{label}</div><div class="registeration-input-space">{input}{error}</div>'])->textInput(['class' => 'registeration-input numeric','maxlength' => 15,'placeholder'=>'Company Phone Number']) ?>
                            </div>
                            <div class="mt-30 relative">
                              <?= $form->field($modelCompany, 'employee_count', ['template' => '<div class="registeration-text">{label}</div><div class="registeration-input-space">{input}{error}</div>'])->dropDownList(['20' => 'Less than 20', '50' => '20-50', '100' => '50-100', '200' => '100-200', '201' => 'More than 200']) ?>
                            </div>
                            <div class="mt-30 relative">
                              <?= $form->field($modelCompany, 'website', ['template' => '<div class="registeration-text">{label}</div><div class="registeration-input-space">{input}{error}</div>'])->textInput(['class' => 'registeration-input','maxlength' => 30,'placeholder'=>'Company Website']) ?>
                            </div>
                            <div class="mt-30 relative">
                              <?= $form->field($modelCompany, 'address', ['template' => '<div class="registeration-text">{label}</div><div class="registeration-input-space">{input}{error}</div>'])->textarea(['class' => 'registeration-input','maxlength' => 500,'placeholder'=>'Company Address']) ?>
                            </div>
                            <div class="mt-30 relative">
                              <?php echo $form->field($packageModel, 'package_id')->dropDownList($dropDownPackages, ['prompt' =>'---Select Package---'])->label('Package'); ?>
                            </div>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="col-lg-12 mt-sm-elarge text-center mt-30">
                      <?= Html::submitButton('Register', ['class' =>'blue-btn w60']) ?>
                    </div>
                </div>
                </div><!--/.row-->
            </div>            
            <?php ActiveForm::end(); ?>
        </section><!--/.content-->
        <div class="clearfix"></div>