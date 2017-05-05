<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "packages".
 *
 * @property integer $package_id
 * @property string $package_name
 * @property string $group_type
 * @property string $package_type
 * @property integer $valid_for_days
 * @property integer $total_member_count
 * @property integer $per_group_member_count
 * @property integer $track_count
 * @property integer $fence_count
 * @property integer $package_cost
 * @property integer $status
 */
class Packages extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'packages';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['package_id','package_name', 'group_type', 'package_type', 'valid_for_days', 'total_member_count', 'per_group_member_count', 'track_count', 'fence_count', 'package_cost'], 'required'],
            [['group_type', 'package_type'], 'string'],
            [['valid_for_days', 'total_member_count', 'per_group_member_count', 'track_count', 'fence_count', 'package_cost', 'status'], 'integer'],
            [['package_name'], 'string', 'max' => 200]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'package_id' => 'Package ID',
            'package_name' => 'Package Name',
            'group_type' => 'Group Type',
            'package_type' => 'Package Type',
            'valid_for_days' => 'Valid For Days',
            'total_member_count' => 'Total Member Count',
            'per_group_member_count' => 'Per Group Member Count',
            'track_count' => 'Track Count',
            'fence_count' => 'Fence Count',
            'package_cost' => 'Package Cost',
            'status' => 'Status',
        ];
    }
}
