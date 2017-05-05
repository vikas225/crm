<?php
namespace frontend\controllers;

use Yii;
use common\models\User;
use common\models\LoginForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\CompanyDetails;
use frontend\models\UserPackages;
use frontend\models\Packages;
use frontend\models\ContactForm;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use frontend\components\Common;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                   
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        Yii::$app->Common->getPaymentDetails(); //saving payment status if return success status
        return $this->render('index');
    }

    /**
     * Logs in a user.
     *
     * @return mixed
     */
    public function actionLogin()
    {
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        $step=1;
        $arr=[];
        $model = new LoginForm(); //creating object of LoginForm Model which is in common/model
        if ($model->load(Yii::$app->request->post())) {

          $user = $model->getUser();//getting User details by calling getUser() of LoginForm Model
          
          $post = Yii::$app->request->post(); //getting data from form

          if(isset($post['LoginForm']['username']) ) //if username is filled in form 
            {
                    $cookies = Yii::$app->response->cookies; //getting cookie refrence
                    $cookies->add(new \yii\web\Cookie([
                                'name' => 'suggested_email',
                                'value' => $post['LoginForm']['username'], //adding user email in cookie
                            ])); //adding cookie 
            }
            if( !isset($post['LoginForm']['password']) )
           {
            if( !$user ){ // if user email is not exist

                $model->addError('username', 'This email id is not registered'); //add error 

              }elseif($user && $user->is_email_verified!='Y') { //if user is  registered and email is not verified then 

                Yii::$app->session->setFlash('error', 'Please verify your email.');
                return $this->redirect(['site/verify-email/new']); //if user is  registered and email is not verified then redirect user to verify-mail action
              }else {
                $step = 2; //if user is exist and email is verify then setting $step =2
                $arr['email'] = $post['LoginForm']['username']; //adding user email in array
                $arr['user'] = $user; //adding user in array
              }
           }else{ //if password is set then it will execute
                  $step = 2;
                  
                  $loginS = $model->login(); // loggging in user if user is exist then return user Details and if user user email is not verified then return 2.
                  if($loginS > 1) //if user email is not verified then generate error and redirect user to verify-email action
               {
                  
                  Yii::$app->session->setFlash('error', 'Please verify your email.');
                  return $this->redirect(['site/verify-email/new']);   //for passing new as a link we have to write rule in frontend/config/main.php in urlManager 
               }else if($loginS)
               {
                  return $this->redirect(['users/dashboard']);
               }
               $arr['user'] = $user;
               $arr['email'] = $post['LoginForm']['username'];

           }


  } 

      $arr['model'] = $model;
            $arr['step'] = $step;
            return $this->render('login', $arr);
    }

    /**
     * Logs out the current user.
     *
     * @return mixed
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return mixed
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail(Yii::$app->params['adminEmail'])) {
                Yii::$app->session->setFlash('success', 'Thank you for contacting us. We will respond to you as soon as possible.');
            } else {
                Yii::$app->session->setFlash('error', 'There was an error sending email.');
            }

            return $this->refresh();
        } else {
            return $this->render('contact', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Displays about page.
     *
     * @return mixed
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

    /**
     * Signs user up.
     *
     * @return mixed
     */
    public function actionSignup()
    {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post())) {
            if ($user = $model->signup()) {
                if (Yii::$app->getUser()->login($user)) {
                    return $this->goHome();
                }
            }
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }

    /**
     * Requests password reset.
     *
     * @return mixed
     */
    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');

                return $this->goHome();
            } else {
                Yii::$app->session->setFlash('error', 'Sorry, we are unable to reset password for email provided.');
            }
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', 'New password was saved.');

            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }
    public function actionRegister(){


        if(!\Yii::$app->user->isGuest){
            return $this->goHome();

        }

        $modelCompany=new CompanyDetails(); //creating object of CompanyDetails Model
        $packageModel=new UserPackages(); //creating object of USerpackage Model
        $package=new Packages(); ////creating object of Package Model
        $modelUser=new User(); //creating object of User Model
        $modelUser->scenario='register'; //setting scenerio for validation
        $post=Yii::$app->request->post();//getting form data

        if($modelCompany->load(Yii::$app->request->post()) && $modelUser->load(Yii::$app->request->post()) && $package->load(Yii::$app->request->post()) && $modelCompany->validate() && $modelUser->validate()){ //loding form data on model 

            $modelUser->registration_datetime = date('Y-m-d H:i:s');

            if($modelUser->save()){ //saving user data

                //saving company data
                $modelCompany->user_id = $modelUser->id;
                $modelCompany->created_datetime= date('Y-m-d H:i:s');
                $modelCompany->save();

                //saving package details
                $arr['UserPackages'] = Packages::findOne($post['Packages']['package_id'])->toArray();
                $packageModel->load($arr);
                $packageModel->user_id=$modelUser->id;
                $packageModel->status=0;

                $packageModel->valid_till_date = date('Y-m-d H:i:s', strtotime("+".$arr['UserPackages']['valid_for_days']." days"));
                $packageModel->save();
                //making payment
                Yii::$app->Common->makePayment( $packageModel );
               

            Yii::$app->session->setFlash('success', 'You are successfully registered. Check your email for account verification link.');
            return $this->redirect(['login']);

            }else{
                
                  Yii::$app->session->setFlash('error', 'An unexpected error occured during registration.');
                  return $this->refresh();
                }
            }
                $modelUser->country_code = '91';
              $packageModel = new Packages;

      // Get all company packages
      $dropDownPackages = [];
      $packages = Packages::find()->where(['package_type' => 'package', 'group_type' => 'company', 'status' => '1'])->asArray()->all();
      foreach($packages as $key => $val){
        $dropDownPackages[ $val['package_id'] ] = $val['package_name'];
      

     }
      return $this->render('register', ['modelCompany' => $modelCompany,'modelUser' => $modelUser, 'packageModel' => $packageModel, 'dropDownPackages' => $dropDownPackages]);
        
    }


  public function actionVerifyEmail($link){

    $difV=1;//defining variable
    $link_expired=true;  
    $modelUser = new User();//creating object of User Model
     if($link!='new') //checking is $link is not new or email_key is available
        {
          $modelUser=User::find()->where(["email_key"=>$link])->One();  //getting user by link
          if(!empty($modelUser)){ //if user exist with the
            $today = new DateTime(); //getting date time
            $expDate = new DateTime($modelUser->email_link_date.'+1 day'); //adding 1 day in registration date
            $difV = $expDate->diff($today)->days; //getting diff expiry date and today date
             if($modelUser->is_email_verified=='Y' && $modelUser->is_mobile_verified=='N') //checking if user email is verify and mobile is not verify
            {
             
              Yii::$app->session->setFlash('success', 'Email has been already verified.'); 
              return $this->redirect(['users/verify-mobile']); // if user email is verify and mobile is not verify then redirect to verify-mobile
            }else if($modelUser->is_email_verified == 'Y' && $modelUser->is_mobile_verified == 'Y'){ // checking if user email is verify and mobile is  verify 
              Yii::$app->session->setFlash('error', 'Your Email already has been activated');  
            }
            else if($difV < -1){
               Yii::$app->session->setFlash('error', 'Activation link has been expired. Please try again.');
              $link_expired=true;
            }else{
              $modelUser->email_key='';
              $modelUser->is_email_verified='Y';
              $modelUser->save(false);
               if($modelUser->is_mobile_verified=='N')
                {
                Yii::$app->session->setFlash('success', 'Email has been verified.');
               // return $this->redirect(['site/verify-mobile']); 
                return $this->redirect(['site/login']); 
                }
            }

          } else
          {
            Yii::$app->session->setFlash('error', 'Activation link does not exist');
            $modelUser = new User();
           } 
          }   

          // if form is submitted
          if(Yii::$app->request->post() && $modelUser->load(Yii::$app->request->post())){
            $post=Yii::$app->request->post();
            $email=$post["User"]['email'];
            $modelUser=User::find()->where(['email'=>$email])->One();
            if(!empty($modelUser)){
              $link=md5(md5(time()));//generating activation key           
              $modelUser->email_key=$link;
              $modelUser->save();
              Yii::$app->session->setFlash('success', 'Account activation link has been sent to your email address.');
             //Common::sendRegisterEmail($modelUser);
              Yii::$app->Common->sendRegisterEmail($modelUser); //here Common is component
            }
            else{
           $modelUser = new User();
           Yii::$app->session->setFlash('error', 'Provided email does not exist. Please try again.');
           $link_expired=true;
          }
         }
        
        return $this->render('activation-link', ['model' => $modelUser,'link_expired'=>$link_expired]);
    }
  

  //function for sending OTP
    public function actionSendOtp(){
      if(Yii::$app->user->isGuest){
        $status=Yii::$app->user->loginUrl;
        $status=$status[0];

      }else{
       $id=  Yii::$app->user->identity->id;
       $model = User::findOne($id);
       $status=0;

       $code=Yii::$app->Common->generateOTP();
       $response= Yii::$app->Common->sendOTP($code,$model->mobile_no);
       if($response['status'] === "OK"){
         $model->otp_code=$code;
          $model->save();//saving OTP in database
          $status=1;
       }

      }
      echo $status;
      exit;

    }

}
