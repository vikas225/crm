<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

$this->title = 'Change Profile Image';
?>

<input type="hidden" id='active_menu' value='menu_user'>
<section class="content">
    <div class="container">
        <div class="row intro-section">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-lg-3 mt-20">
                        <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                            <div class="panel panel-default redPaneltab">
                                <div class="panel-heading nav-radius" role="tab" id="headingOne">
                                    <h4 class="panel-title">
                                        <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne-2" aria-expanded="true" aria-controls="collapseOne-2" class="">
                                            <span class="">My Account</span><span class="pull-right gray-left-arrow"></span>
                                        </a>
                                    </h4>
                                </div>
                                <div id="collapseOne-2" class="panel-collapse" role="tabpanel" aria-labelledby="headingOne">
                                    <div class="panel-body">
                                        <ul class="side-sub-menu">
                                            <li><a href="<?php echo Url::toRoute(['/users/edit-profile'], true);?>">Edit Profile</a></li>
                                            <li><a href="<?php echo Url::toRoute(['/users/profile-image'], true);?>">Edit Picture</a></li>
                                            <li><a href="<?php echo Url::toRoute(['/users/change-password'], true);?>">Change Password</a></li>
                                            <li><?php echo Html::a('Logout?',['/site/logout'],['data-method'=>'post','tabindex'=>'-1']) ?></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-9 ">
                        <div class="relative mt-20">
                            <h3>Change Profile Image</h3>
                        </div>                                
                        <div class="row mt-20">
                            <?php $form = ActiveForm::begin([
                                'validateOnBlur' => false,
                                'options'=> ['enctype'=>'multipart/form-data']
                            ]); ?>
                                <div class="col-lg-12 col-xs-12 mt-20">
                                   <?php echo $image;?>
                                </div>
                                <div class="col-lg-12 col-xs-12 mt-20">
                                    <?= $form->field($userM, 'image')->fileInput()->label('Upload New'); ?>
                                </div>
                                <div class="clearfix"></div>
                                <div class="col-lg-6 mt-20">
                                    <?= Html::submitButton('Submit', ['class' =>'blue-btn ']) ?>
                                </div>
                            <?php ActiveForm::end(); ?>
                        </div>
                    </div>
                </div>
			</div>
        </div>
    </div>
</section>
<div class="clearfix"></div>