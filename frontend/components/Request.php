<?php
 
namespace app\components;
 
use Yii;
use yii\base\Component;
 
class Request extends \yii\web\Request
{
    public $noCsrfRoutes = [];
     
    public function validateCsrfToken()
    {
        if(
            $this->enableCsrfValidation && 
            in_array(Yii::$app->getUrlManager()->parseRequest($this)[0], $this->noCsrfRoutes)
        ){
            return true;
        }
        return parent::validateCsrfToken();
    }
}
