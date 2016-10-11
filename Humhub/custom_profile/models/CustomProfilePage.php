<?php
/**
 * @link http://veteranmentornetwork.com
 * @copyright Copyright (c) 2016 Veteran Mentor Network
 * @license http://veteranmentornetwork.com/license
 */

namespace app\modules\custom_profile\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;

/**
 * This is the model class for table "custom_profile_page".
 *
 * @property integer $id
 * @property string $name
 * @property string $title_line1
 * @property string $title_line2
 * @property string $introductory_text
 * @property string $footer_text
 * @property integer $created_at
 * @property integer $created_by
 * @property integer $updated_at
 * @property integer $updated_by
 */
class CustomProfilePage extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'custom_profile_page';
    }
    
    public function behaviors() {
        return [
            TimestampBehavior::className(),
            BlameableBehavior::className(),
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'required'],
            [['created_at', 'created_by', 'updated_at', 'updated_by'], 'integer'],
            [['name', 'title_line1', 'title_line2', 'introductory_text', 'footer_text'], 'string', 'max' => 255],
            [['name', 'title_line1', 'title_line2', 'introductory_text', 'footer_text','conclusion_text', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Page Name',
            'title_line1' => 'Title Line1',
            'title_line2' => 'Title Line2',
            'introductory_text' => 'Introductory Text',
            'footer_text' => 'Footer Text',
            'conclusion_text' => 'Conclusion Text',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
        ];
    }
}
