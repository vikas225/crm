<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */

$this->title = 'Email Activation Link';
//$this->params['breadcrumbs'][] = $this->title;
//$readonly = false;
?>

        <section class="content">
        <?php $form = ActiveForm::begin([
                        'id' => 'login-form',
                    ]); ?>
            <div class="container">
                <div class="row intro-section">
                    <div class="login-page">
                        <h3 class="text-center"><?= $this->title; ?></h3>
                        <p class="text-center">Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
                        <?php if ($link_expired): ?>
                        <div class="container-fluid">
                            <div class="login-bg">
                                <div class="text-center"><img src="<?= Yii::$app->request->baseUrl ?>/images/login-user-img.png"/></div>
                                <div class="mt-20">
                                    <?= $form->field($model, 'email', ['template' => "{input}{error}"])->textInput(['class' => 'login-input','placeholder'=>'Email']) ?>
                                
                                <div class="mt-30 text-center">
                                    <?= Html::submitButton('Send Activation Link', ['class' =>'blue-btn w100']) ?>
                                </div>
                                <div class="mt-20"><h3 class="text-center">OR</h3></div>
                                <div class="mt-20 text-center fs-20 ">New Users ? <span><a href="<?php echo Url::toRoute('site/register'); ?>">REGISTER</a> </span></div>
                            </div>
                        </div>                        
                        <?php endif; ?>
                    </div>
                </div>
                </div><!--/.row-->
            </div>  
            <?php ActiveForm::end(); ?>
           </section><!--/.content-->
        <div class="clearfix"></div>