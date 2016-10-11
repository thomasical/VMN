<?php

/**
 * @link https://www.humhub.org/
 * @copyright Copyright (c) 2015 HumHub GmbH & Co. KG
 * @license https://www.humhub.com/licences
 */

namespace humhub\modules\user\models\fieldtype;

use Yii;

/**
 * ProfileFieldTypeSelect handles numeric profile fields.
 *
 * @package humhub.modules_core.user.models
 * @since 0.5
 */
class MultiSelectDropdown extends BaseType {

    /**
     * All possible options.
     * One entry per line.
     * key=>value format
     *
     * @var String
     */
    public $options;
    public $Max_selection_length;

    /**
     * Rules for validating the Field Type Settings Form
     *
     * @return type
     */
    public function rules() {
        return array(
            //array(['options'], 'required'),
            array(['options', 'Max_selection_length'], 'safe'),
            array(['Max_selection_length'], 'integer'),
        );
    }

    /**
     * Returns Form Definition for edit/create this field.
     *
     * @return Array Form Definition
     */
    public function getFormDefinition($definition = array()) {
        return parent::getFormDefinition(array(
                    get_class($this) => array(
                        'type' => 'form',
                        'title' => Yii::t('UserModule.models_ProfileFieldTypeSelect', 'Select field options'),
                        'elements' => array(
                            'options' => array(
                                'type' => 'textarea',
                                'label' => Yii::t('UserModule.models_ProfileFieldTypeSelect', 'Possible values'),
                                'class' => 'form-control',
                                'hint' => Yii::t('UserModule.models_ProfileFieldTypeSelect', 'One option per line. Key=>Value Format (e.g. yes=>Yes)')
                            ),
                            'Max_selection_length' => array(
                                'type' => 'text',
                                'label' => Yii::t('UserModule.models_ProfileFieldTypeMultiSelect', 'maxselectnlength'),
                                'class' => 'form-control',
                                'hint' => Yii::t('UserModule.models_ProfileFieldTypeMultiSelect', 'use integer value.)')
                            ),
                        )
        )));
    }

    /**
     * Saves this Profile Field Type
     */
    public function save() {
        $columnName = $this->profileField->internal_name;
        if (!\humhub\modules\user\models\Profile::columnExists($columnName)) {
            $query = Yii::$app->db->getQueryBuilder()->addColumn(\humhub\modules\user\models\Profile::tableName(), $columnName, 'TEXT');
            Yii::$app->db->createCommand($query)->execute();
        }

        return parent::save();
    }

    /**
     * Returns the Field Rules, to validate users input
     *
     * @param type $rules
     * @return type
     */
    public function getFieldRules($rules = array()) {
        $rules[] = array($this->profileField->internal_name, 'safe');
        return parent::getFieldRules($rules);
    }

    /**
     * Return the Form Element to edit the value of the Field
     */
    public function getFieldFormDefinition() {
        return array($this->profileField->internal_name => array(
                'type' => 'multiselect',
                'class' => 'form-control',
                'readonly' => (!$this->profileField->editable),
                'items' => $this->getSelectItems(),
                'prompt' => Yii::t('UserModule.models_ProfileFieldTypeSelect', 'Please select:'),
        ));
    }

    /**
     * Returns a list of possible options
     *
     * @return Array
     */
    public function getSelectItems() {
        $item = array();
        $item_option = array();
        $key = 'Category';
        $special = ":;,.#$&@!^*?";

        foreach (explode("\n", $this->options) as $option) {

            /* if (strpos($option, "|") !== false) {
              list($key, $value) = explode("|", $option);
              if (strpos($value, ",") !== false) {
              $eachtitle = explode(",", $value);
              $eachtitle = array_filter($eachtitle);
              foreach ($eachtitle as $k => $v) {
              $tmp = $key . '_' . $v;
              $new_array[$tmp] = $v;
              }

              } else {
              $eachtitle = $value;
              }
              $item_option[trim($key)] = $new_array;
              unset($new_array);
              } else {
              $item_option[] = $option;
              } */

            if (strpos($option, "|") !== false) {
                $item[trim(trim(str_replace(',', '-', $key)), $special)] = $item_option;
                if (!empty(trim(trim(str_replace('|', '', $option)), $special))) {
                    $key = str_replace('|', '', $option);
                }
                unset($item_option);
                $item_option = array();
            } else {
                if (!empty(trim(trim(str_replace(',', '-', $option)), $special))) {
                    //$item_option[trim(trim(str_replace(',', '-', $key)), $special) . '_' . trim(trim(str_replace(',', '-', $option)), $special)] = trim($option);
                    $item_option[trim(trim(str_replace(',', '-', $option)), $special)] = trim($option);
                }
            }
        }
        $item[trim(trim(str_replace(',', '-', $key)), $special)] = $item_option;
        $item = array_filter($item);
        $item_maxlength = $this->Max_selection_length;
        if (empty($item_maxlength)) {
            $item_maxlength = 1000;
        }
        $items['option'] = $item;
        $items['maxselectnlength'] = $item_maxlength;

        return $items;
    }

    /**
     * Returns value of option
     *
     * @param User $user
     * @param Boolean $raw Output Key
     * @return String
     */
    public function getUserValue($user, $raw = true) {
        $internalName = $this->profileField->internal_name;
        $value = $user->profile->$internalName;

        if (!$raw) {
            $options = $this->getSelectItems();
            if (isset($options[$value])) {
                return \yii\helpers\Html::encode(Yii::t($this->profileField->getTranslationCategory(), $options[$value]));
            }
        }

        return $value;
    }

}

?>
