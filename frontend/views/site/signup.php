<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\SignupForm */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;

$this->title = 'Signup';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="clearfix"></div>
<section class="content">
    <div class="container">
        <div class="row intro-section">
            <div class="col-lg-12">
              <h3 class="text-center">
                Let's get started!<br/>
                First, tell us how you want to Register yourself ?
              </h3>
              <div class="row relative">
                <div class="col-lg-6 mt-30">
                    <div class="clearfix"></div>
                    <div><img src="<?= Yii::$app->request->baseUrl ?>/images/login-user-img.png" class="center-block"></div>
                    <div class="mt-40 text-center fs-20 ">
                        Individual User
                    </div>
                    <div class="mt-60 text-center"><button class="blue-btn w60">Go</button></div>
                </div>
                <div class="col-lg-6 mt-30 registration-option-line">
                    <div class="registration-or">OR</div>
                    <div class="clearfix"></div>
                    <div><img src="<?= Yii::$app->request->baseUrl ?>/images/login-option-img.png" class="center-block"></div>
                    <div class="mt-40 text-center fs-20 ">
                        Company User
                    </div>
                    
                    <div class="mt-60 text-center registration-btn">
                      <a href="<?= Url::toRoute('/site/register', true)?>">Go</a>
                    </div>
                    
                </div>
            </div>
            </div>
        </div>
      </div>
    </div>
</section>