<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

$this->title = 'Dashboard';
?>

<section class="content">
    <div class="container">
        <div class="row intro-section">
            <div class="col-xs-12">
                <h4>Welcome <?php echo ucfirst($userM->name);?>!</h4>
			</div>
        </div>
    </div>
</section>
<div class="clearfix"></div>