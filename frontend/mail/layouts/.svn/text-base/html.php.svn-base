<?php
use yii\helpers\Html;

/* @var $this \yii\web\View view component instance */
/* @var $message \yii\mail\MessageInterface the message being composed */
/* @var $content string main view render result */
?>
<?php $this->beginPage() ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=<?= Yii::$app->charset ?>" />
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
 <body style="margin: 0; padding: 0 0px; width: 99%; max-width: 800px; margin: auto; border: 1px solid #ddd; font-family: arial; font-size: 14px; line-height: 1.5; color: #333">
    <?php $this->beginBody() ?>
	<table border="0" cellpadding="0" cellspacing="0" width="100%" />
            <tbody>
                <tr>
                    <td
                     style="padding: 10px 15px ;border-bottom: 1px solid #ddd;"><a href=""><img src="<?= Yii::$app->urlManager->createAbsoluteUrl(""); ?>/images/logo.png" height="45" width="auto"></td>
                </tr>
                <?= $content ?>
				<tr>
				<td>
				<div style="margin-bottom: 0%"><strong>Thank you,</strong><br />Angel Eye<br /><br /><br /></div>
				</td>
				</tr>
                <tr>
                    <td align="center" style="padding: 15px 15px ;border-top: 1px solid #ddd; font-size: 12px; color: #999;">Powered by Eagle 4 Security</td>
                </tr>
            </tbody>
        </table>
   
    <?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
