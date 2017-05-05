<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

$this->title = 'Login';
$cookies = Yii::$app->request->cookies;
$suggested_email = $cookies->getValue('suggested_email', '');
//$this->params['breadcrumbs'][] = $this->title;
?>
        <section class="content">
            <div class="container">
                <div class="row intro-section">
                    <div class="login-page">
                        <h3 class="text-center">Login</h3>
                        <p class="text-center">Sign in to continue to AngelEye</p>
                        
                        <div class="container-fluid">
                            <?php $form = ActiveForm::begin([
                                'id' => 'login-form',
                            ]); ?>
                                <div class="login-bg">
                                    <?php if($step != 1){ ?><span onClick="window.history.back();" class="glyphicon glyphicon-arrow-left" style="cursor:pointer;" title="Back" aria-hidden="true"></span><?php } ?>
                                    <div class="text-center">
                                        <?php if(isset($user['image']) && $user['image']){ ?>
                                            <img src="<?= Yii::$app->request->baseUrl .'/images/users/'. $user['image']; ?>" class='img-circle' width='125' height='125'/>
                                        <?php } else { ?>
                                            <img src="<?= Yii::$app->request->baseUrl ?>/images/login-user-img.png"/>
                                        <?php } ?>
                                    </div>
                                    <div class="mt-20">
                                        <?php if($step == 1){ ?>

                                            <?= $form->field($model, 'username', ['template' => "<span>{input}{error}</span>"])->textInput(['class' => 'login-input','autofocus'=>'true','placeholder'=>'Email', 'value' => $suggested_email]) ?>
                                        
                                            <div class="mt-10 text-center">
                                                <?= Html::submitButton('Next', ['class' =>'blue-btn w100']) ?>
                                            </div>
                                        <?php } else { ?>
                                            
                                            <div class="mt-7">
                                                <?= $form->field($model, 'password', ['template' => "{input}{error}"])->passwordInput(['class' => 'login-input','autofocus'=>'true', 'placeholder'=>'Password']) ?>
                                            </div>
                                            <div class='row mt-7'>
                                                <div class="col-lg-6">
                                                    <?= $form->field($model, 'rememberMe', ['template' => "<span>{input}{error}</span>\n<span class=\"fs-16 gray-text\">{label}</span>",])->checkbox() ?>
                                                </div>
                                                 <div class="col-lg-6 text-right">
                                                    <span class="fs-16 gray-text"><a href="<?php echo Url::toRoute('site/forgot-password'); ?>" tabindex='-1'>Forgot Password?</a></span>
                                                </div>
                                            </div>
                                            <input type='hidden' value="<?php echo $email;?>" name="LoginForm[username]">
                                            <div class="mt-10 text-center">
                                                <?= Html::submitButton('Login', ['class' =>'blue-btn w100']) ?>
                                            </div>
                                        <?php } ?>
                                        <div class="mt-20"><h3 class="text-center">OR</h3></div>
                                        <div class="mt-20 text-center fs-20 ">New Users ? <span><a href="<?php echo Url::toRoute('site/register'); ?>">REGISTER</a> </span></div>
                                    </div>
                                </div>
                            <?php ActiveForm::end(); ?>
                        </div>
                </div>
                </div><!--/.row-->
            </div>  
              </section><!--/.content-->
        <div class="clearfix"></div>
