<?php
/**
 * @link http://veteranmentornetwork.com
 * @copyright Copyright (c) 2016 Veteran Mentor Network
 * @license http://veteranmentornetwork.com/license
 */

namespace app\modules\custom_profile\models;

use Yii;

/**
 * This is the model class for table "profile_field".
 *
 * @property integer $id
 * @property integer $profile_field_category_id
 * @property string $module_id
 * @property string $field_type_class
 * @property string $field_type_config
 * @property string $internal_name
 * @property string $title
 * @property string $description
 * @property integer $sort_order
 * @property integer $required
 * @property integer $show_at_registration
 * @property integer $editable
 * @property integer $visible
 * @property string $created_at
 * @property integer $created_by
 * @property string $updated_at
 * @property integer $updated_by
 * @property string $ldap_attribute
 * @property string $translation_category
 * @property integer $is_system
 * @property integer $searchable
 */
class ProfileField extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'profile_field';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['profile_field_category_id', 'field_type_class', 'internal_name', 'title'], 'required'],
            [['profile_field_category_id', 'sort_order', 'required', 'show_at_registration', 'editable', 'visible', 'created_by', 'updated_by', 'is_system', 'searchable'], 'integer'],
            [['field_type_config', 'description'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['module_id', 'field_type_class', 'title', 'ldap_attribute', 'translation_category'], 'string', 'max' => 255],
            [['internal_name'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'profile_field_category_id' => 'Profile Field Category ID',
            'module_id' => 'Module ID',
            'field_type_class' => 'Field Type Class',
            'field_type_config' => 'Field Type Config',
            'internal_name' => 'Internal Name',
            'title' => 'Title',
            'description' => 'Description',
            'sort_order' => 'Sort Order',
            'required' => 'Required',
            'show_at_registration' => 'Show At Registration',
            'editable' => 'Editable',
            'visible' => 'Visible',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
            'ldap_attribute' => 'Ldap Attribute',
            'translation_category' => 'Translation Category',
            'is_system' => 'Is System',
            'searchable' => 'Searchable',
        ];
    }
}
