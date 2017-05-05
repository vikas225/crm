<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "user".
 *
 * @property integer $id
 * @property string $device_id
 * @property string $name
 * @property string $email
 * @property string $password
 * @property string $address
 * @property string $city
 * @property integer $roles_id
 * @property integer $country_code
 * @property string $mobile_no
 * @property string $imei_no
 * @property string $sim_no
 * @property string $device_type
 * @property string $otp_expiry
 * @property string $email_key
 * @property string $accessToken
 * @property string $auth_key
 * @property string $sos_smart_password
 * @property integer $active
 * @property double $lat_lat
 * @property double $last_long
 * @property string $last_battery_status
 * @property string $registration_datetime
 * @property string $modified_dateime
 * @property string $is_email_verified
 * @property string $is_mobile_verified
 * @property string $gcm_id
 * @property string $email_link_date
 * @property string $otp_code
 * @property string $image
 *
 * @property CompanyDetails[] $companyDetails
 */
class User extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['device_id', 'name', 'email', 'password', 'address', 'city', 'roles_id', 'country_code', 'mobile_no', 'imei_no', 'sim_no', 'device_type', 'otp_expiry', 'email_key', 'accessToken', 'auth_key', 'sos_smart_password', 'lat_lat', 'last_long', 'last_battery_status', 'registration_datetime', 'modified_dateime', 'is_email_verified', 'is_mobile_verified', 'gcm_id', 'email_link_date', 'otp_code', 'image'], 'required'],
            [['address', 'device_type', 'is_email_verified', 'is_mobile_verified'], 'string'],
            [['roles_id', 'country_code', 'active'], 'integer'],
            [['otp_expiry', 'registration_datetime', 'modified_dateime', 'email_link_date'], 'safe'],
            [['lat_lat', 'last_long'], 'number'],
            [['device_id', 'name', 'password', 'city', 'email_key', 'accessToken', 'auth_key', 'sos_smart_password'], 'string', 'max' => 50],
            [['email'], 'string', 'max' => 100],
            [['mobile_no'], 'string', 'max' => 15],
            [['imei_no'], 'string', 'max' => 16],
            [['sim_no'], 'string', 'max' => 20],
            [['last_battery_status'], 'string', 'max' => 10],
            [['gcm_id', 'image'], 'string', 'max' => 255],
            [['otp_code'], 'string', 'max' => 25]
        ];
    }

    /**
     * @inheritdoc
     */
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
     * @return \yii\db\ActiveQuery
     */
    public function getCompanyDetails()
    {
        return $this->hasMany(CompanyDetails::className(), ['user_id' => 'id']);
    }
}
