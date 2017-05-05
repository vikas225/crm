<?php
namespace frontend\components;
use Yii;
use yii\base\Component;
use yii\web\Response;
use frontend\models\UserPackages;
use common\models\User;

class Common extends Component{

	public function sendRegisterEmail($model){
		Yii::$app->mailer->compose(['html'=>'@common/mail/register'],['model'=>$model])->setFrom(Yii::$app->params['adminEmail'])->setTo($model->email)->setSubject('Confirm Your Account')->send();
	}


	// function for payment


	 public function makePayment($packageModel)
  {
    // Live keys
    $working_key='F21EF21D9B837A619A8525287D2FAE41';
    $access_code='AVXM63DB99AY55MXYA';
    
    // Test keys
    if( self::is_localhost() )
    {
      /*$working_key = 'B130EC66274A938523CA09EEEA361AB8';
      $access_code = 'AVXH00DC36AB20HXBA';
      $url = "http://localhost/eye/frontend/web/";*/
      $working_key = 'F21EF21D9B837A619A8525287D2FAE41';
      $access_code = 'AVXM63DB99AY55MXYA';
      $url = "http://www.eagle4ss.com";
    } else {
      $working_key = 'A7617BF81A59C8BF72B39F88843872F2';
      $access_code = 'AVWH00DC36AB19HWBA';
      $url = "http://angel.yiipro.com";
    }
    
    $merchant_data='';
    $arr = array (
      'merchant_id' => '90547',
      'currency' => 'INR',
      'language' => 'en',
      'redirect_url' => $url,
      'cancel_url' => $url,
      'amount' => $packageModel->package_cost.'.00',
      'order_id' => $packageModel->id,
      //'integration_type' => 'iframe_normal'
    );
    
    foreach ($arr as $key => $value){
      $merchant_data.=$key.'='.$value.'&';
    }
    
    $encrypted_data = self::encrypt($merchant_data,$working_key); // Method for encrypting the data.
    
    $production_url='https://test.ccavenue.com/transaction/transaction.do?command=initiateTransaction&encRequest='.$encrypted_data.'&access_code='.$access_code;
    header('Location: '.$production_url);
    exit;
  } 

   // Checks current server is localhost or not
  public function is_localhost()
  {
    $whitelist = array('127.0.0.1', '::1');
    return in_array($_SERVER['REMOTE_ADDR'], $whitelist) ? true : false;
  }


   function encrypt($plainText,$key)
  {
    $secretKey = self::hextobin(md5($key));
    $initVector = pack("C*", 0x00, 0x01, 0x02, 0x03, 0x04, 0x05, 0x06, 0x07, 0x08, 0x09, 0x0a, 0x0b, 0x0c, 0x0d, 0x0e, 0x0f);
    $openMode = mcrypt_module_open(MCRYPT_RIJNDAEL_128, '','cbc', '');
    $blockSize = mcrypt_get_block_size(MCRYPT_RIJNDAEL_128, 'cbc');
    $plainPad = self::pkcs5_pad($plainText, $blockSize);
      if (mcrypt_generic_init($openMode, $secretKey, $initVector) != -1) 
    {
          $encryptedText = mcrypt_generic($openMode, $plainPad);
                mcrypt_generic_deinit($openMode);
                
    } 
    return bin2hex($encryptedText);
  }

  function decrypt($encryptedText,$key)
  {
    $secretKey = self::hextobin(md5($key));
    $initVector = pack("C*", 0x00, 0x01, 0x02, 0x03, 0x04, 0x05, 0x06, 0x07, 0x08, 0x09, 0x0a, 0x0b, 0x0c, 0x0d, 0x0e, 0x0f);
    $encryptedText=self::hextobin($encryptedText);
      $openMode = mcrypt_module_open(MCRYPT_RIJNDAEL_128, '','cbc', '');
    mcrypt_generic_init($openMode, $secretKey, $initVector);
    $decryptedText = mdecrypt_generic($openMode, $encryptedText);
    $decryptedText = rtrim($decryptedText, "\0");
    mcrypt_generic_deinit($openMode);
    return $decryptedText;
    
  }
  //*********** Padding Function *********************

   function pkcs5_pad ($plainText, $blockSize)
  {
      $pad = $blockSize - (strlen($plainText) % $blockSize);
      return $plainText . str_repeat(chr($pad), $pad);
  }

  //********** Hexadecimal to Binary function for php 4.0 version ********

  function hextobin($hexString) 
     { 
      $length = strlen($hexString); 
      $binString="";   
      $count=0; 
      while($count<$length) 
      {       
          $subString =substr($hexString,$count,2);           
          $packedString = pack("H*",$subString); 
          if ($count==0)
      {
      $binString=$packedString;
      } 
          
      else 
      {
      $binString.=$packedString;
      } 
          
      $count+=2; 
      } 
          return $binString; 
  }


//getting payment details

public function getPaymentDetails()
  {
    /*print_r($post["encResp"]);
   die();*/
    $post = Yii::$app->request->post();
    if(isset($post['encResp']) && $post['encResp'])
    {
      // Live keys
      $working_key='F21EF21D9B837A619A8525287D2FAE41';
      $access_code='AVXM63DB99AY55MXYA';
      
      // Test keys
      if( self::is_localhost() )
      {
        /*$working_key = 'B130EC66274A938523CA09EEEA361AB8';
        $access_code = 'AVXH00DC36AB20HXBA';*/

        $working_key = 'F21EF21D9B837A619A8525287D2FAE41';
        $access_code = 'AVXM63DB99AY55MXYA';

      } else {
        $working_key = 'A7617BF81A59C8BF72B39F88843872F2';
        $access_code = 'AVWH00DC36AB19HWBA';
      }

      $encResponse = $post["encResp"];
      $rcvdString = self::decrypt($encResponse, $working_key);
      $decryptValues = explode('&', $rcvdString);
      
      foreach($decryptValues as $key => $val)
      {
        list($key1, $val1) = explode('=', $val);
        $data[$key1] = $val1;
      }
      
      if(isset($data['order_status']) && $data['order_status']== 'Success') 
      {
        // Get user package details 
        $package = UserPackages::findOne($data['order_id']);
        $package->status = 1;
        $package->payment_details = json_encode($data);
        $package->tracking_id = $data['tracking_id'];
        $package->order_status = $data['order_status'];
        $package->save();
        
        // Get user details
        $user = User::findOne( $package->user_id );
        
        // Send email to user
        Yii::$app->mailer->compose(['html' =>'@common/mail/succesful-package-payment'], ['user'=>$user, 'package' => $package])->setFrom(Yii::$app->params['adminEmail'])->setTo($user->email)->setSubject('Successful Payment')->send();

        Yii::$app->session->setFlash('success', 'You are successfully registered. Check your email for account verification link.');
      }
      elseif(isset($data['order_status']) && $data['order_status']== 'Failure') 
      {
        Yii::$app->session->setFlash('error', trim($data['failure_message'], '.').'. Your account is created with us. Please contact administrator at '.Yii::$app->params['adminEmail'].' and report about this error.');
      }
      //return $this->render('login');
    }
  }


  //SEND OTP Function


   public static function generateOTP()
   {
      $str = '';
      for($i=8;$i>0;$i--)
         {
          $str = $str.rand(0,100); 
         }
      $str = substr($str, 0, 8);
      return $str;
   }
   
   public static function sendOTP( $otp, $mobile )
   {
    
      //$str = "One Time Password is $otp. Please use this OTP to activate your account.";
    $str = "Dear user your OTP is $otp";
      $message=urlencode($str);
     /* $username="demo";
      $password="demo12";*/
      //$senderid="PDTIPS";
      $senderid = "EAGLES";
     $url = "http://alerts.solutionsinfini.com/api/v3/index.php?method=sms&api_key=A9f213d6d024802552af27e63bc57ff6e&to=$mobile&sender=$senderid&message=$message&format=php&custom=1,2&flash=0";
      
    $ch=curl_init();    
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $output=curl_exec($ch);
   return unserialize($output);
      
      
   }


   public function getError( $model )
  {
    $errors = [];
    if( $model->getErrors() )
    {
      foreach($model->getErrors() as $key => $val)
      {
        $errors[] = implode(' and ', $val);
      }

      $error = implode(' and ', $errors);
      return $error;
    }
    
    return null;
  }

}
?>