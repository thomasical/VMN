<?php
/**
 * @link http://veteranmentornetwork.com
 * @copyright Copyright (c) 2016 Veteran Mentor Network
 * @license http://veteranmentornetwork.com/license
 */

namespace app\modules\custom_profile\models;

use Yii;

/**
 * This is the model class for table "custom_profile_page_field".
 *
 * @property integer $id
 * @property integer $custom_profile_page_id
 * @property integer $profile_field_id
 * @property integer $type
 * @property integer $created_at
 * @property integer $created_by
 */
class CustomProfilePageField extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'custom_profile_page_field';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['custom_profile_page_id', 'profile_field_id', 'created_at', 'created_by'], 'required'],
            [['custom_profile_page_id', 'profile_field_id', 'created_at', 'created_by'], 'integer'],
            [['custom_profile_page_id', 'profile_field_id', 'sort_order', 'created_at', 'created_by'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'custom_profile_page_id' => 'Custom Profile Page ID',
            'profile_field_id' => 'Profile Field ID',
            'sort_order' => 'Sort Order',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
        ];
    }
}
