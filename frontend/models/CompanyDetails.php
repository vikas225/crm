<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "company_details".
 *
 * @property integer $id
 * @property string $name
 * @property integer $user_id
 * @property string $employee_count
 * @property string $address
 * @property string $email
 * @property string $phone_no
 * @property string $website
 * @property string $created_datetime
 * @property string $modified_datetime
 *
 * @property User $user
 */
class CompanyDetails extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'company_details';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'email', ], 'required'],
            [['user_id'], 'integer'],
            [['employee_count'], 'string'],
            [['email'],'email'],
            [['created_datetime', 'modified_datetime'], 'safe'],
            [['name'], 'string', 'max' => 50],
            [['email', 'website'], 'string', 'max' => 100]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'user_id' => 'User ID',
            'employee_count' => 'Employee Count',
            'address' => 'Address',
            'email' => 'Email',
            'phone_no' => 'Phone No',
            'website' => 'Website',
            'created_datetime' => 'Created Datetime',
            'modified_datetime' => 'Modified Datetime',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
