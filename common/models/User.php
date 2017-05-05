<?php
namespace common\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
use frontend\components\Common;
use frontend\models\Packages;
use frontend\models\UserPackages;
use frontend\models\CompanyDetails;
use yii\helpers\Security;

/**
 * User model
 *
 * @property integer $id
 * @property string $username
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property string $auth_key
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $password write-only password
 */
class User extends ActiveRecord implements IdentityInterface
{
    //const STATUS_DELETED = 0;
    //const STATUS_ACTIVE = 10;
public $current_password;
    public $new_password;
    public $confirm_password;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user}}';
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
         return [
            [[ 'country_code', 'mobile_no'], 'required'],
            [['name','email'],'required','on'=>'webinvite'],
            [['roles_id', 'country_code','mobile_no','active'],'integer'],
            [['device_type','is_email_verified','is_mobile_verified'],'string'],
            [['image'],'file','extensions' => 'jpg, jpeg, gif, png'],
            [['address', 'device_type', 'is_email_verified', 'is_mobile_verified'], 'string'],
            [['roles_id', 'country_code', 'active'], 'integer'],
            [['otp_expiry', 'registration_datetime', 'modified_dateime', 'confirm_password','email_link_date'], 'safe'],
            [['lat_lat', 'last_long'], 'number'],
            [['device_id', 'name', 'password', 'city', 'email_key', 'accessToken', 'auth_key', 'sos_smart_password'], 'string', 'max' => 50],
            [['email'], 'string', 'max' => 100],
            [['email'],'email'],

            //[['mobile_no'], 'string', 'max' => 15],
            [['imei_no'], 'string', 'max' => 16],
            [['sim_no'], 'string', 'max' => 20],
            //[['last_battery_status'], 'string', 'max' => 10],
            [['gcm_id', 'image'], 'string', 'max' => 255],
            [['otp_code'], 'string', 'max' => 25],
            [['email'],'unique'],
            [['mobile_no'],'unique'],
            [['mobile_no'],'checkValidNumber','on'=>['register','webinvite']], //calling checkValidNumber 
            [['image'],'required','on'=>['profileImage']],
            [['email'],'required','on'=>['register']],
            [['name'],'required','on'=>['edit-profile']],
            [['password','confirm_password'],'required','on'=>['register','resetpassword']],
            [['confirm_password'],'compare','compareAttribute'=>'password','on'=>['register','resetpassword']],
            [['password','new_password','confirm_password'],'string','min'=>6],
            [['new_password','confirm_password','current_password'],'required','on'=>['changepassword']],
            [['confirm_password'], 'compare', 'compareAttribute'=>'new_password','on'=>['changepassword']],
            [['current_password'],'passwordValidation','on'=>['changepassword']],//calling password validation

        ];
    }

     public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'device_id' => 'Device ID',
            'name' => 'Name',
            'email' => 'Email',
            'password' => 'Password',
            'address' => 'Address',
            'city' => 'City',
            'roles_id' => 'Roles ID',
            'country_code' => 'Country Code',
            'mobile_no' => 'Mobile No',
            'imei_no' => 'Imei No',
            'sim_no' => 'Sim No',
            'device_type' => 'Device Type',
            'otp_expiry' => 'Otp Expiry',
            'email_key' => 'Email Key',
            'accessToken' => 'Access Token',
            'auth_key' => 'Auth Key',
            'sos_smart_password' => 'Sos Smart Password',
            'active' => 'Active',
            'lat_lat' => 'Lat Lat',
            'last_long' => 'Last Long',
            'last_battery_status' => 'Last Battery Status',
            'registration_datetime' => 'Registration Datetime',
            'modified_dateime' => 'Modified Dateime',
            'is_email_verified' => 'Is Email Verified',
            'is_mobile_verified' => 'Is Mobile Verified',
            'gcm_id' => 'Gcm ID',
            'email_link_date' => 'Email Link Date',
            'otp_code' => 'Otp Code',
            'image' => 'Image',
        ];
    }

    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id]);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        
        //return static::findOne(['username' => $username, 'status' => self::STATUS_ACTIVE]); //original
        return static::findOne(['email' => $username]); //changed
    }

    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
   
    public static function findByPasswordResetToken($token)
    {
        $expire = \Yii::$app->params['user.passwordResetTokenExpire'];
        $parts = explode('_', $token);
        $timestamp = (int) end($parts);
        if ($timestamp + $expire < time()) {
            // token expired
            return null;
        }

        return static::findOne([
            'accessToken' => $token
        ]);
    }
    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return boolean
     */
    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }

        $timestamp = (int) substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        return $timestamp + $expire >= time();
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        //return Yii::$app->security->validatePassword($password, $this->password_hash);
        return $this->password === sha1($password);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }

     /**
     * @return \yii\db\ActiveQuery
     */
    public function getCompanyDetails()
    {
        return $this->hasMany(CompanyDetails::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserPackages()
    {
        return $this->hasMany(UserPackages::className(), ['user_id' => 'id']);
    }

    public function checkValidNumber($attribute){
        $country_code=$this->country_code;
        $mobile_num =$this->mobile_no;
        $countryCodes=Yii::$app->params['phoneCodes'];
        $codeD=(isset($countryCodes[$country_code])?$countryCodes[$country_code]:array());
        if(count($codeD)==0){
            $this->addError('mobile_no','Please Provide Valid Country Code');
        } elseif(strlen($mobile_num) < $codeD['min']){
            $this->addError('mobile_no','Phone Number Should be Minimum '.$codeD['min'].' digits for '.$codeD['name']);
        }elseif(strlen($mobile_num) > $codeD['max']){
            $this->addError('mobile_no','Phone Number Should be Maximum '.$codeD['max'].' digits for '.$codeD['name']);
        }
    }

    public function passwordValidation($attribute){
        if(sha1($this->$attribute) != $this->password){
            $this->addError($attribute,'Invalid Current Password');
        }else{
            $this->password = sha1($this->new_password);
        }
    }

 public function beforeSave($insert) 
    {
         if(isset($this->password) && isset($this->confirm_password) && $this->confirm_password!="" && $this->scenario!='changepassword')
         {
          $this->password =sha1($this->password); 
         }
         elseif($this->isNewRecord)
         {   
            // $link=md5(md5(time()));
            // $this->email_key=$link;
            // Common::sendRegisterEmail($this);
            $this->password =sha1($this->password);
         }
         
        if($this->isNewRecord)
        {
           $this->registration_datetime=date('Y-m-d H:i');
           $this->email_link_date=date('Y-m-d');
           $this->is_email_verified='N';
           $this->is_mobile_verified='N';
           //$this->auth_key=md5(md5(time()));

           $link=md5(md5(time()));
           $this->email_key=$link;
        }
        if( $this->isNewRecord && $this->email && strpos($this->email, '@dummy.com')==false )
           // Common::sendRegisterEmail($this);
            Yii::$app->Common->sendRegisterEmail($this);

        return true;
     }
     public function beforeValidate()
    {  
        if($this->isNewRecord) {
           $this->registration_datetime = date('Y-m-d H:i:s');                   
        }
        
        $this->modified_dateime = date('Y-m-d H:i:s');  
        
        return true;
    }
     public function getPackage($group_type = 'company')
    {
        $package = UserPackages::find()->where(['user_id' => $this->id, 'group_type' => $group_type, 'status' => '1'])->one();
        
        return $package;
    }
    
    public function addFreePackages()
    {
        // Add family package
        $packageModel = new UserPackages();
        $arr['UserPackages'] = Packages::findOne(1)->toArray();
        $packageModel->load($arr);
        $packageModel->user_id = $this->id;
        $packageModel->status = 1;
        $packageModel->valid_till_date = date('Y-m-d H:i:s', strtotime("+".$arr['UserPackages']['valid_for_days']." days"));
        $packageModel->save();
        
        // Add friends package
        $packageModel = new UserPackages();
        $arr['UserPackages'] = Packages::findOne(2)->toArray();
        $packageModel->load($arr);
        $packageModel->user_id = $this->id;
        $packageModel->status = 1;
        $packageModel->valid_till_date = date('Y-m-d H:i:s', strtotime("+".$arr['UserPackages']['valid_for_days']." days"));
        $packageModel->save();
    }

}
