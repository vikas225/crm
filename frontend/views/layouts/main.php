<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use common\widgets\Alert;
use yii\helpers\Url;
AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="en">
    <head>
       <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
    </head>
    <body>
    <?php
// Check if current page is home page or not 
$controller = Yii::$app->controller;
$default_controller = Yii::$app->defaultRoute;
$isHome = (($controller->id === $default_controller) && ($controller->action->id === $controller->defaultAction)) ? true : false;
?>
        <header>
            <div class="top-head wrapper">
                <div class="container">
                    <ul class="pull-left list-inline">
                        <li class="pull-left"><span class="sprites ph-icon"></span> 91+ 9074731832</li>
                        <li class="pull-left hidden-xs"><span class="sprites email-icon"></span><a href="mailto:vikas@eagle4ss.com">vikas@eagle4ss.com</a></li>
                    </ul>
                    <ul class="pull-right list-inline">
                    <?php 
                    if(Yii::$app->user->isGuest){
                    ?>
                        <li><a href="<?= Url::toRoute('/site/login')?>">Login</a></li>
                        <span>|</span>
                         <li><a href="<?= Url::toRoute('/site/signup')?>">Sign Up</a></li>
                         <?php }else{
                            ?>
                            <div class="dropdown pull-right">
                            <button class="btn btn-default dropdown-toggle" type="button" id="menu1" data-toggle="dropdown">Account
                            <span class="caret"></span></button>
                            <ul class="dropdown-menu" role="menu" aria-labelledby="menu1">
                              <li role="presentation"><a role="menuitem" tabindex="-1" href="<?php echo Url::toRoute(['/users/dashboard'], true);?>">Dashboard</a></li>
                              <li role="presentation"><a role="menuitem" tabindex="-1" href="<?php echo Url::toRoute(['/users/my-account'], true);?>">My Account</a></li>
                              <li role="presentation"><?php echo Html::a('Logout ('.Yii::$app->user->identity->name.')',['/site/logout'],['data-method'=>'post','tabindex'=>'-1']) ?></li>
                            </ul>
                          </div>
                            <?php
                         }

                         ?>
                    </ul>
                </div>
            </div><!--/.top-head-->
            <div class="clearfix"></div>
            <nav class="navbar navbar-default navbar-static-top">
                <div class="la-anim-1"></div>       
                <div class="container">
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                        <a class="navbar-brand" href="#"><img src="<?= Yii::$app->request->baseUrl ?>/images/logo.png" alt=" " /></a>
                    </div>
                    <nav id="navbar" class="navbar-collapse collapse">
                        <ul class="nav navbar-nav navbar-right">
                            <li class="active"><a href="#">Home</a></li>
                            <li><a href="#">About Us</a></li>
                            <li><a href="#">Users</a></li>
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-delay="100" data-close-others="false">Services</a>
                                <ul class="dropdown-menu dropdown-menu-left" role="menu">
                                    <li><a href="#">Action</a></li>
                                    <li><a href="#">Another action</a></li>
                                    <li><a href="#">Something else here</a></li>
                                    <li><a href="#">Separated link</a></li>
                                    <li><a href="#">One more separated link</a></li>
                                </ul>
                            </li>
                            <li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-delay="100" data-close-others="false">Products</a>
                                <ul class="dropdown-menu dropdown-menu-left" role="menu">
                                    <li><a href="#">Action</a></li>
                                    <li><a href="#">Another action</a></li>
                                    <li><a href="#">Something else here</a></li>
                                    <li><a href="#">Separated link</a></li>
                                    <li><a href="#">One more separated link</a></li>
                                </ul>
                            </li>
                            <li><a href="#">Angle Eye</a></li>
                            <li><a href="#">Careers</a></li>
                            <li><a href="#">Contact Us</a></li>
                        </ul>
                    </nav><!--/.nav-collapse -->
                </div>
            </nav>
        </header>
         <?php if(Yii::$app->session->getFlash('success')) { ?>
            <div class="alert alert-success">
            <a href="#" class="close" data-dismiss="alert">&times;</a>
            <strong>Success! </strong> <?php echo Yii::$app->session->getFlash('success'); ?>
            </div>
            <?php } ?>
            <?php if(Yii::$app->session->getFlash('error')) { ?>
            <div class="alert bg-danger">
            <a href="#" class="close" data-dismiss="alert">&times;</a>
            <strong>Error! </strong> <?php echo Yii::$app->session->getFlash('error'); ?>
            </div>
            <?php } ?>
            <?php if(Yii::$app->session->getFlash('warning')) { ?>
            <div class="alert alert-warning">
            <a href="#" class="close" data-dismiss="alert">&times;</a>
            <strong>Warning! </strong><?php echo Yii::$app->session->getFlash('warning'); ?>
            </div>
            <?php } ?>
        <div class="clearfix"></div>
        <?= $content ?>

        <div class="clearfix"></div>
        <footer class="footer-bg">
            <div class="container text-center">
                <div class="row">
                </div><!--/.row-->
                <div class="copyright">
                    Copyright &COPY; 2015. All Right Reserved
                </div>
            </div>
            <a class="return-to-top" id="back-to-top" href="#"><i class="fa fa-angle-up"></i></a>
        </footer>
        
        

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
