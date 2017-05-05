<?php

namespace frontend\controllers;

use Yii;
use common\models\User;
use frontend\models\UserSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\web\UploadedFile;
/**
 * UsersController implements the CRUD actions for User model.
 */
class UsersController extends Controller
{
    public $enableCsrfValidation = false;
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
             'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['verify-mobile', 'dashboard', 'my-account','edit-profile','profile-image','change-password'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => ['album'],
                        'allow' => true,     
                         'roles' => ['?'],
                    ]
                ],
            ],
        ];
    }

    /**
     * Lists all User models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single User model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new User();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing User model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }


    public function actionDashboard(){
        $userM=User::findOne(Yii::$app->user->identity->id); //getting logged in user details

        $package = $userM->getPackage(); //getting logged in userpackage 

    if( $package->is_expired() ) { //is expired function is written in UserPackages Controller
      Yii::$app->session->setFlash('error', 'Please renew your package to continue enjoying the benefits of Angel Eye.');
    }
    return $this->render('dashboard', ['userM' => $userM]);
  }

  //verify Mobile Action

      public function actionVerifyMobile(){
        $id=Yii::$app->user->identity->id; //getting Logged in User id
        $model = User::findOne($id); //Getting User Details from Database
        if($model->is_mobile_verified=='Y') //if user mobile is verified
        {
        Yii::$app->session->setFlash('success', 'Mobile no. has been alredy verified.');            
        }
        $mobile_no=$model->mobile_no; //getting mobile no from database
        $otp_code=$model->otp_code;//getting OTP Code from database
         if(Yii::$app->request->post() && $model->load(Yii::$app->request->post())) //if form is submitted it will execute
        {     
                
          if($mobile_no!=$model->mobile_no)
          {
           Yii::$app->session->setFlash('error', 'Mobile no. has been changed.'); 
          }
          else if($otp_code!=$model->otp_code)
          {
             Yii::$app->session->setFlash('error', 'Wrong OTP entered.'); 
          }
          else
          {            
             $model->is_mobile_verified='Y';
             $model->save(false);
             Yii::$app->session->setFlash('success', 'Your mobile no. has been verified, now.');  
             return $this->redirect('dashboard');           
          }         
        }
        return $this->render('mobile-verification',['model'=>$model]);

      }

    //user account 
      public function actionMyAccount(){
        $id = Yii::$app->user->identity->id;
        $userM = User::findOne($id);
        $image = $userM->image ? $userM->image : 'login-user-img.png';
        if( $userM->image ) {
        $image = '<a href="'.Url::toRoute(['/images/users/'.$image], true).'" data-lightbox="true">'.HTML::img(Yii::$app->request->baseUrl.'/images/users/'.$image, ['width'=>'100', 'height' => '100']).'</a>';
    } else {
        $image = HTML::img(Yii::$app->request->baseUrl.'/images/users/'.$image, ['width'=>'100', 'height' => '100']);   
    }
    return $this->render('my-account', ['userM' => $userM, 'image' => $image]);
       
      }


      //Edit Profile Function
      public function actionEditProfile(){
        $id = Yii::$app->user->identity->id;
        $userM = User::findOne($id);
        $userM->scenario ='edit-profile';
        if(Yii::$app->request->isPost){
            $post = Yii::$app->request->post();
             unset($post['User']['email'], $post['User']['mobile_no']);
              $userM->load( $post );
               if( $userM->save() ) 
                  {
                    Yii::$app->session->setFlash('success', 'Profile updated successfully.');
                    return $this->refresh();
                  }else {
                    Yii::$app->session->setFlash('error', Yii::$app->Common->getError($userM));
              }
        }
         return $this->render('edit-profile', ['userM' => $userM]);

      }

      //Profile Image upload
      public function actionProfileImage(){
         $id = Yii::$app->user->identity->id;
        $userM = User::findOne($id);
        $userM->scenario = 'profileImage';
        if(Yii::$app->request->isPost){
            $image = UploadedFile::getInstance($userM,'image');
            $userM->image =  'user_'.$userM->id.'_'.$image->name;
            $path = Yii::$app->basePath . '/web/images/users/'.$userM->image;
            if($userM->save()) 
      {
        $image->saveAs($path);
        Yii::$app->session->setFlash('success', 'Profile image changed successfully.');
      }
      else{
        Yii::$app->session->setFlash('error', 'An error occured while changing Profile Image..'); 
      }
      return $this->refresh();
    }
     $image = $userM->image ? $userM->image : 'login-user-img.png';
    if( $userM->image ) {
        $image = '<a href="'.Url::toRoute(['/images/users/'.$image], true).'" data-lightbox="true">'.HTML::img(Yii::$app->request->baseUrl.'/images/users/'.$image, ['width'=>'100', 'height' => '100']).'</a>';
    } else {
        $image = HTML::img(Yii::$app->request->baseUrl.'/images/users/'.$image, ['width'=>'100', 'height' => '100']);   
    }
    
    return $this->render('profile-image', ['userM' => $userM, 'image' => $image]);
       
     }

     //change Password
     public function actionChangePassword(){
        $userM = User::findOne(Yii::$app->user->identity->id);
        $userM->scenario = 'changepassword';
        if( \Yii::$app->request->isPost )
        {
          $post = Yii::$app->request->post();
          $userM->load( $post );
          if( $userM->save() ) 
          {
            Yii::$app->session->setFlash('success', 'Password changed successfully.');
            return $this->refresh();
          }
          else {
            $userM->current_password = '';
          }                
        }
        return $this->render('change-password', ['userM' => $userM]);
     }

      

    
}
