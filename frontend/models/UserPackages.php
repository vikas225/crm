<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "user_packages".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $parent_id
 * @property string $package_name
 * @property string $group_type
 * @property string $package_type
 * @property integer $total_member_count
 * @property integer $per_group_member_count
 * @property integer $track_count
 * @property integer $fence_count
 * @property integer $member_used
 * @property integer $track_used
 * @property integer $fence_used
 * @property integer $package_cost
 * @property string $valid_till_date
 * @property integer $status
 * @property string $date_added
 * @property string $date_modified
 */
class UserPackages extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user_packages';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'package_name', 'group_type', 'package_type', 'total_member_count', 'per_group_member_count', 'track_count', 'fence_count', 'package_cost', 'valid_till_date', 'status'], 'required'],
            [['user_id', 'parent_id', 'total_member_count', 'per_group_member_count', 'track_count', 'fence_count', 'member_used', 'track_used', 'fence_used', 'package_cost', 'status'], 'integer'],
            [['group_type', 'package_type'], 'string'],
            [['valid_till_date', 'date_added', 'date_modified'], 'safe'],
            [['package_name'], 'string', 'max' => 100]
        ];
    }
    
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'parent_id' => 'Parent ID',
            'package_name' => 'Package Name',
            'group_type' => 'Group Type',
            'package_type' => 'Package Type',
            'total_member_count' => 'Total Member Count',
            'per_group_member_count' => 'Per Group Member Count',
            'track_count' => 'Track Count',
            'fence_count' => 'Fence Count',
            'member_used' => 'Member Used',
            'track_used' => 'Track Used',
            'fence_used' => 'Fence Used',
            'package_cost' => 'Package Cost',
            'valid_till_date' => 'Valid Till Date',
            'status' => 'Status',
            'date_added' => 'Date Added',
            'date_modified' => 'Date Modified',
        ];
    }
    
    public function beforeSave($insert) 
    {    
        if($this->isNewRecord) {
           $this->date_added = date('Y-m-d H:i:s');                   
        }
        
        $this->date_modified=date('Y-m-d H:i:s');  
        return true;
    }
    // checks if package is expired or not
    public function is_expired()
    {
        return strtotime($this->valid_till_date) < time() ? true : false;
    }

   }