<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/site.css',
        'css/animate.min.css',
        'css/datepicker.css',
        'css/font-awesome.min.css',
        'css/global.css',
        'css/style.css'

    ];
    public $js = [
    'js/bootstrap.min.js',
    'js/html5shiv.js',
    'js/jquery.simplr.smoothscroll.js',
    'js/jquery.simplr.smoothscroll.min.js',
    'js/respond.js',
    'js/site.js'
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
