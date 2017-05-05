<table>
	<tr>
		<td style="padding: 30px 15px 20px 15px; margin-bottom: 20%"><strong>Dear, </br /><?= ucfirst($model->name);  ?></strong><br />
		    Thank you for registration on Angel Eye.
		    <br />
			Please click <a href="<?= Yii::$app->urlManager->createAbsoluteUrl('site/verify-email/'.$model->email_key) ?>" target='_blank'>here </a> to verify your account.		
			<br />
			or
			<br />
			copy the following link and paste to browser.
			<br />
			"<?= Yii::$app->urlManager->createAbsoluteUrl('site/verify-email/'.$model->email_key) ?>"
			<br /><br /><br />		
		</td>
	</tr>
</table>