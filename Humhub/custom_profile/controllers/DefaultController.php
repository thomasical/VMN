<?php

namespace app\modules\custom_profile\controllers;

use Yii;
use yii\helpers\Url;
use yii\base\ErrorHandler;
use yii\filters\AccessControl;
use app\modules\custom_profile\models\ProfileFieldCategory;
use app\modules\custom_profile\models\CustomProfilePage;
use app\modules\custom_profile\models\CustomProfilePageSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use app\modules\custom_profile\models\ProfileField;
use app\modules\custom_profile\models\CustomProfilePageField;
use humhub\modules\user\models\Profile;
use humhub\modules\user\models\User;
use humhub\models\Setting;

/**
 * Default controller for the `custom_profile` module
 */
class DefaultController extends Controller {

    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index', 'custom-profile-setting', 'custom-profile-page', 'edit', 'delete', 'update', 'insert-field', 'delete-page', 'check-page', 'inlineedit', 'view', 'directory', 'home', 'myprofilepages', 'error', 'save-profile'],
                'rules' => [
                    [
                        'actions' => ['update', 'insert-field', 'delete-page', 'check-page', 'inlineedit', 'view', 'directory', 'home', 'myprofilepages', 'error', 'save-profile'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => ['index', 'custom-profile-setting', 'custom-profile-page', 'edit', 'delete'],
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
                    return Yii::$app->user->isAdmin();
                }
                    ],
                ],
            ],
        ];
    }

    public $enableCsrfValidation = false;

    public function init() {
        yii::$app->errorHandler->errorAction = 'custom_profile/default/error';
    }

    public function actions() {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex() {
        $model = new CustomProfilePage();
        $signin_id = Setting::find()->select(['value'])->where(['module_id' => 'custom_profile', 'name' => 'signin_url'])->one();
        $active_pages = CustomProfilePage::find()->all();
        return $this->render('index', ['model' => $model, 'signin_id' => $signin_id, 'active_pages' => $active_pages]);
    }

    /**
     * Renders the custom profile page for this module
     * @return string
     */
    public function actionCustomProfilePage() {
        $cppmodel = new CustomProfilePage();
        $pagename = Yii::$app->request->post('pagename');
        $active_pages = CustomProfilePage::find()->all();
        $pagecount = CustomProfilePage::find()->where(['name' => $pagename])->count();
        if ($pagecount == 0) {
            $ProfileFieldCategory = ProfileFieldCategory::find()->orderBy('sort_order')->all();
            $fieldname = ProfileField::find()->where(['editable' => 1])->orderBy(['sort_order' => SORT_ASC])->all();
            return $this->render('customprofilepage', ['cppmodel' => $cppmodel, 'active_pages' => $active_pages, 'fieldname' => $fieldname, 'ProfileFieldCategory' => $ProfileFieldCategory]);
        } else {
            $_SESSION['success_msg'] = "Page already exist";
            return $this->redirect('index');
        }
    }

    /**
     * Save datas from custom profile page to db
     * @redirect to index after success
     */
    public function actionCustomProfileSetting() {
        $model = new CustomProfilePage();
        $advsry = Yii::$app->request->post('advsry');
        $hint_field = Yii::$app->request->post('nam');
        $display_value2 = Yii::$app->request->post('disp2');
        if ($model->load(Yii::$app->request->post())) {
            if ($model->save(false)) { 
                if (!empty($hint_field)) {
                    foreach ($hint_field as $field_id => $input_value) {
                        if (!empty($input_value)) {
                            Yii::$app->db->createCommand()->update('profile_field', ['description' => $input_value], ['id' => $field_id])->execute();
                        }
                    }
                }
                $data = [];
                $data_advsry = [];
                $idvalue = CustomProfilePage::find()->select(['id'])->where(['name' => $model->name])->one();
                $custom_profile_page_id = $idvalue->id;
                if (!empty($advsry)) {
                    unset($order);
                    unset($display_value);
                    $order = 1;
                    foreach ($advsry as $key => $value) {
                        $display_value = $display_value2[$order - 1];
                        $title = ProfileField::find()->select(['internal_name', 'title'])->where(['id' => $value])->one();
                        if (empty($display_value)) {
                            $display_value = $title->title;
                        }
                        $data_advsry[] = ['custom_profile_page_id' => $custom_profile_page_id, 'profile_field_id' => $value, 'internal_name' => $title->internal_name, 'display_name' => $display_value, 'sort_order' => $order, 'created_at' => 1, 'created_by' => 1];
                        $order++;
                    }
                    Yii::$app->db->createCommand()->batchInsert('custom_profile_page_field', ['custom_profile_page_id', 'profile_field_id', 'internal_name', 'display_name', 'sort_order', 'created_at', 'created_by'], $data_advsry)->execute();
                }
            }
        }
        $_SESSION['success_msg'] = "Custom Profile Page Inserted Successfully";
        return $this->redirect('index');
    }

    /**
     * Renders the custom profile edit page for this module
     * @return string
     */
    public function actionEdit() {
        $cppmodel = new CustomProfilePage();
        $model = new ProfileField();
        $present_field = array();
        $display_name = array();
        $id = $_GET['id'];
        if (empty($id)) {
            throw new NotFoundHttpException('Id Misssing');
        }
        $page_detail = CustomProfilePage::find()->where(['id' => $id])->one();
        if (empty($page_detail)) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
        $ProfileFieldCategory = ProfileFieldCategory::find()->orderBy('sort_order')->all();
        $profilefieldname = ProfileField::find()->where(['editable' => 1])->orderBy(['sort_order' => SORT_ASC])->all();
        $fieldname = CustomProfilePageField::find()->where(['custom_profile_page_id' => $id])->orderBy(['sort_order' => SORT_ASC])->all();
        $active_pages = CustomProfilePage::find()->all();
        $i = 1;
        foreach ($fieldname as $fieldnames) {
            $present_field[$i] = $fieldnames->profile_field_id;
            $display_name[$i++] = $fieldnames->display_name;
        }
        return $this->render('customprofileedit', ['fieldname' => $fieldname,'display_name' => $display_name, 'ProfileFieldCategory' => $ProfileFieldCategory, 'active_pages' => $active_pages, 'cppmodel' => $cppmodel, 'present_field' => $present_field, 'profilefieldname' => $profilefieldname, 'page_detail' => $page_detail, 'model' => $model]);
    }

    /**
     * Deletes the profile field
     * @return string
     */
    public function actionDelete() {
        $prof_field_value = Yii::$app->request->post('id');
        $pg_id = Yii::$app->request->post('pg_id');
        $fielddelete = CustomProfilePageField::find()->where(['profile_field_id' => $prof_field_value, 'custom_profile_page_id' => $pg_id])->one();
        $fielddelete->delete();
    }

    /**
     * Updates the changes made at Custom profile edit page
     * @redirect to index page after success
     */
    public function actionUpdate() {
        $pageid = Yii::$app->request->post('pageid');
        $cpmodel = CustomProfilePage::findOne($pageid);
        $advsry = Yii::$app->request->post('advsry');
        $hint_field = Yii::$app->request->post('nam');
        $display_value2 = Yii::$app->request->post('disp2'); 
        if ($cpmodel->load(Yii::$app->request->post())) {
            if ($cpmodel->save()) {
                if (!empty($hint_field)) {
                    foreach ($hint_field as $field_id => $input_value) {
                        if (!empty($input_value)) {
                            Yii::$app->db->createCommand()->update('profile_field', ['description' => $input_value], ['id' => $field_id])->execute();
                        }
                    }
                }
                if (!empty($advsry)) {
                    unset($order);
                    unset($display_value);
                    $order = 1;
                    print_r($advsry); 
                    foreach ($advsry as $key => $value) {
                        $display_value = $display_value2[$order - 1];
                        $title = ProfileField::find()->select(['title'])->where(['id' => $value])->one();
                        if (empty($display_value)) {
                            $display_value = $title->title;
                        }
                        Yii::$app->db->createCommand()->update('custom_profile_page_field', ['display_name' => $display_value, 'sort_order' => $order], ['profile_field_id' => $value, 'custom_profile_page_id' => $pageid])->execute();
                        $order++;
                    }
                }
                $_SESSION['success_msg'] = "Custom Profile Page Updated Successfully";
                return $this->redirect('index');
            }
        } else {
            $_SESSION['success_msg'] = "Custom Profile Page Not Updated";
            return $this->redirect('index');
        }
    }

    /**
     * Insert new profile fields entered in custom profile edit page
     * @return string
     */
    public function actionInsertField() {
        $model_pagefield = new CustomProfilePageField();
        $prof_field_value = Yii::$app->request->post('id');
        $pg_id = Yii::$app->request->post('pg_id');
        $intername = ProfileField::find()->select(['internal_name'])->where(['id' => $prof_field_value])->one();
        $fieldcount = CustomProfilePageField::find()->where(['custom_profile_page_id' => $pg_id, 'profile_field_id' => $prof_field_value])->count();
        if ($fieldcount == 0) {
            $model_pagefield->custom_profile_page_id = $pg_id;
            $model_pagefield->profile_field_id = $prof_field_value;
            $model_pagefield->internal_name = $intername->internal_name;
            $model_pagefield->sort_order = 100;
            $model_pagefield->created_at = 1;
            $model_pagefield->created_by = 1;
            $model_pagefield->save();
        } else {
            echo "field exist";
        }
    }

    /**
     * Deletes the custom profile pages
     * @return string
     */
    public function actionDeletePage() {
        $id = Yii::$app->request->post('id');
        CustomProfilePageField::deleteAll(['custom_profile_page_id' => $id]);
        $page_delete = CustomProfilePage::find()->where(['id' => $id])->one();
        $page_delete->delete();
        $page = CustomProfilePage::find()->select(['name', 'id'])->all();
        return $this->renderAjax('page', ['page' => $page]);
    }

    /**
     * Check whether the page exist or not
     * @return boolean
     */
    public function actionCheckPage() {
        $pagename = Yii::$app->request->post('pagename');
        $id_value = Yii::$app->request->post('id');
        $pagecount = CustomProfilePage::find()->where(['name' => $pagename])->count();
        if ($pagecount > 0) {
            $page = CustomProfilePage::find()->where(['name' => $pagename])->one();
            if ($page->id == $id_value) {
                echo 0;
            } else {
                echo 1;
            }
        } else {
            echo 0;
        }
    }

    /**
     * Renders the View page for this module
     * @return string
     */
    public function actionView() {
        $page_id = $_GET['pid'];
        $user_id = $_GET['uid'];
        if (empty($page_id) || empty($user_id)) {
            throw new NotFoundHttpException('Id Missing');
        }
        $userdata = Profile::find()->where(['user_id' => $user_id])->one();
        $page_detail = CustomProfilePage::find()->where(['id' => $page_id])->one();
        if (empty($userdata) || empty($page_detail)) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
        $guid = User::find()->select(['guid'])->where(['id' => $userdata->user_id])->one();
        $typ2title = CustomProfilePageField::find()->where(['custom_profile_page_id' => $page_id])->orderBy(['sort_order' => SORT_ASC])->all();
        return $this->render('viewpage', ['profilefield' => $userdata, 'page_detail' => $page_detail, 'guid' => $guid, 'typ2title' => $typ2title]);
    }

    /**
     * Renders the Home page for this module
     * @return string
     */
    public function actionHome() {
        $page = CustomProfilePage::find()->orderBy(['updated_at' => SORT_ASC])->all();
        return $this->render('home', ['page' => $page]);
    }

    /**
     * Renders the Directory page for this module
     * @return string
     */
    public function actionDirectory() {
        $id = $_GET['pid'];
        if (empty($id)) {
            throw new NotFoundHttpException('Id Missing');
        }
        $page_detail = CustomProfilePage::find()->where(['id' => $id])->one();
        if (empty($page_detail)) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
        $title = CustomProfilePageField::find()->where(['custom_profile_page_id' => $id])->orderBy(['sort_order' => SORT_ASC])->all();
        $userdatas = Profile::find()->all();
        return $this->render('directory', ['title' => $title, 'userdatas' => $userdatas, 'page_id' => $id, 'page_detail' => $page_detail]);
    }

    /**
     * Renders the Error page for this module
     * @return string
     */
    public function actionError() {

        return $this->render('error');
    }

    /**
     * action to get the status, to display topmenu
     * @return string
     */
    public function actionTopmenuStatus() {

        $show_status = Setting::find()->select(['value'])->where(['module_id' => 'custom_profile', 'name' => 'show_on_top_menu'])->one();
        echo $show_status->value;
    }

    /**
     * action to change the status to display topmenu
     * @return string
     */
    public function actionChangeTopmenuStatus() {

        if (Yii::$app->request->post('status_val') == 'yes') {
            $status_val = 1;
        } else {
            $status_val = 0;
        }
        Yii::$app->db->createCommand()->update('setting', ['value' => $status_val], ['module_id' => 'custom_profile', 'name' => 'show_on_top_menu'])->execute();
    }

    public function actionLoadField() {
        $title = Yii::$app->request->post('title');
        $internl = Yii::$app->request->post('internl');
        return $this->renderAjax('loadfield', ['title' => $title, 'internl' => $internl]);
    }

    public function actionFirstLoadField() {
        $title = Yii::$app->request->post('title');
        $internl = Yii::$app->request->post('internl');
        return $this->renderAjax('firstloadfield', ['title' => $title, 'internl' => $internl]);
    }

    public function list_of_country() {

        $countryList = array(
            'AF' => 'Afghanistan',
            'AX' => 'Aland Islands',
            'AL' => 'Albania',
            'DZ' => 'Algeria',
            'AS' => 'American Samoa',
            'AD' => 'Andorra',
            'AO' => 'Angola',
            'AI' => 'Anguilla',
            'AQ' => 'Antarctica',
            'AG' => 'Antigua and Barbuda',
            'AR' => 'Argentina',
            'AM' => 'Armenia',
            'AW' => 'Aruba',
            'AU' => 'Australia',
            'AT' => 'Austria',
            'AZ' => 'Azerbaijan',
            'BS' => 'Bahamas',
            'BH' => 'Bahrain',
            'BD' => 'Bangladesh',
            'BB' => 'Barbados',
            'BY' => 'Belarus',
            'BE' => 'Belgium',
            'BZ' => 'Belize',
            'BJ' => 'Benin',
            'BM' => 'Bermuda',
            'BT' => 'Bhutan',
            'BO' => 'Bolivia',
            'BQ' => 'Bonaire, Saint Eustatius and Saba',
            'BA' => 'Bosnia and Herzegovina',
            'BW' => 'Botswana',
            'BV' => 'Bouvet Island',
            'BR' => 'Brazil',
            'IO' => 'British Indian Ocean Territory',
            'VG' => 'British Virgin Islands',
            'BN' => 'Brunei',
            'BG' => 'Bulgaria',
            'BF' => 'Burkina Faso',
            'BI' => 'Burundi',
            'KH' => 'Cambodia',
            'CM' => 'Cameroon',
            'CA' => 'Canada',
            'CV' => 'Cape Verde',
            'KY' => 'Cayman Islands',
            'CF' => 'Central African Republic',
            'TD' => 'Chad',
            'CL' => 'Chile',
            'CN' => 'China',
            'CX' => 'Christmas Island',
            'CC' => 'Cocos Islands',
            'CO' => 'Colombia',
            'KM' => 'Comoros',
            'CK' => 'Cook Islands',
            'CR' => 'Costa Rica',
            'HR' => 'Croatia',
            'CU' => 'Cuba',
            'CW' => 'Curacao',
            'CY' => 'Cyprus',
            'CZ' => 'Czech Republic',
            'CD' => 'Democratic Republic of the Congo',
            'DK' => 'Denmark',
            'DJ' => 'Djibouti',
            'DM' => 'Dominica',
            'DO' => 'Dominican Republic',
            'EC' => 'Ecuador',
            'EG' => 'Egypt',
            'SV' => 'El Salvador',
            'GQ' => 'Equatorial Guinea',
            'ER' => 'Eritrea',
            'EE' => 'Estonia',
            'ET' => 'Ethiopia',
            'FK' => 'Falkland Islands',
            'FO' => 'Faroe Islands',
            'FJ' => 'Fiji',
            'FI' => 'Finland',
            'FR' => 'France',
            'GF' => 'French Guiana',
            'PF' => 'French Polynesia',
            'TF' => 'French Southern Territories',
            'GA' => 'Gabon',
            'GM' => 'Gambia',
            'GE' => 'Georgia',
            'DE' => 'Germany',
            'GH' => 'Ghana',
            'GI' => 'Gibraltar',
            'GR' => 'Greece',
            'GL' => 'Greenland',
            'GD' => 'Grenada',
            'GP' => 'Guadeloupe',
            'GU' => 'Guam',
            'GT' => 'Guatemala',
            'GG' => 'Guernsey',
            'GN' => 'Guinea',
            'GW' => 'Guinea-Bissau',
            'GY' => 'Guyana',
            'HT' => 'Haiti',
            'HM' => 'Heard Island and McDonald Islands',
            'HN' => 'Honduras',
            'HK' => 'Hong Kong',
            'HU' => 'Hungary',
            'IS' => 'Iceland',
            'IN' => 'India',
            'ID' => 'Indonesia',
            'IR' => 'Iran',
            'IQ' => 'Iraq',
            'IE' => 'Ireland',
            'IM' => 'Isle of Man',
            'IL' => 'Israel',
            'IT' => 'Italy',
            'CI' => 'Ivory Coast',
            'JM' => 'Jamaica',
            'JP' => 'Japan',
            'JE' => 'Jersey',
            'JO' => 'Jordan',
            'KZ' => 'Kazakhstan',
            'KE' => 'Kenya',
            'KI' => 'Kiribati',
            'XK' => 'Kosovo',
            'KW' => 'Kuwait',
            'KG' => 'Kyrgyzstan',
            'LA' => 'Laos',
            'LV' => 'Latvia',
            'LB' => 'Lebanon',
            'LS' => 'Lesotho',
            'LR' => 'Liberia',
            'LY' => 'Libya',
            'LI' => 'Liechtenstein',
            'LT' => 'Lithuania',
            'LU' => 'Luxembourg',
            'MO' => 'Macao',
            'MK' => 'Macedonia',
            'MG' => 'Madagascar',
            'MW' => 'Malawi',
            'MY' => 'Malaysia',
            'MV' => 'Maldives',
            'ML' => 'Mali',
            'MT' => 'Malta',
            'MH' => 'Marshall Islands',
            'MQ' => 'Martinique',
            'MR' => 'Mauritania',
            'MU' => 'Mauritius',
            'YT' => 'Mayotte',
            'MX' => 'Mexico',
            'FM' => 'Micronesia',
            'MD' => 'Moldova',
            'MC' => 'Monaco',
            'MN' => 'Mongolia',
            'ME' => 'Montenegro',
            'MS' => 'Montserrat',
            'MA' => 'Morocco',
            'MZ' => 'Mozambique',
            'MM' => 'Myanmar',
            'NA' => 'Namibia',
            'NR' => 'Nauru',
            'NP' => 'Nepal',
            'NL' => 'Netherlands',
            'AN' => 'Netherlands Antilles',
            'NC' => 'New Caledonia',
            'NZ' => 'New Zealand',
            'NI' => 'Nicaragua',
            'NE' => 'Niger',
            'NG' => 'Nigeria',
            'NU' => 'Niue',
            'NF' => 'Norfolk Island',
            'KP' => 'North Korea',
            'MP' => 'Northern Mariana Islands',
            'NO' => 'Norway',
            'OM' => 'Oman',
            'PK' => 'Pakistan',
            'PW' => 'Palau',
            'PS' => 'Palestinian Territory',
            'PA' => 'Panama',
            'PG' => 'Papua New Guinea',
            'PY' => 'Paraguay',
            'PE' => 'Peru',
            'PH' => 'Philippines',
            'PN' => 'Pitcairn',
            'PL' => 'Poland',
            'PT' => 'Portugal',
            'PR' => 'Puerto Rico',
            'QA' => 'Qatar',
            'CG' => 'Republic of the Congo',
            'RE' => 'Reunion',
            'RO' => 'Romania',
            'RU' => 'Russia',
            'RW' => 'Rwanda',
            'BL' => 'Saint Barthelemy',
            'SH' => 'Saint Helena',
            'KN' => 'Saint Kitts and Nevis',
            'LC' => 'Saint Lucia',
            'MF' => 'Saint Martin',
            'PM' => 'Saint Pierre and Miquelon',
            'VC' => 'Saint Vincent and the Grenadines',
            'WS' => 'Samoa',
            'SM' => 'San Marino',
            'ST' => 'Sao Tome and Principe',
            'SA' => 'Saudi Arabia',
            'SN' => 'Senegal',
            'RS' => 'Serbia',
            'SC' => 'Seychelles',
            'SL' => 'Sierra Leone',
            'SG' => 'Singapore',
            'SX' => 'Sint Maarten',
            'SK' => 'Slovakia',
            'SI' => 'Slovenia',
            'SB' => 'Solomon Islands',
            'SO' => 'Somalia',
            'ZA' => 'South Africa',
            'GS' => 'South Georgia and the South Sandwich Islands',
            'KR' => 'South Korea',
            'SS' => 'South Sudan',
            'ES' => 'Spain',
            'LK' => 'Sri Lanka',
            'SD' => 'Sudan',
            'SR' => 'Suriname',
            'SJ' => 'Svalbard and Jan Mayen',
            'SZ' => 'Swaziland',
            'SE' => 'Sweden',
            'CH' => 'Switzerland',
            'SY' => 'Syria',
            'TW' => 'Taiwan',
            'TJ' => 'Tajikistan',
            'TZ' => 'Tanzania',
            'TH' => 'Thailand',
            'TL' => 'Timor-Leste',
            'TG' => 'Togo',
            'TK' => 'Tokelau',
            'TO' => 'Tonga',
            'TT' => 'Trinidad and Tobago',
            'TN' => 'Tunisia',
            'TR' => 'Turkey',
            'TM' => 'Turkmenistan',
            'TC' => 'Turks and Caicos Islands',
            'TV' => 'Tuvalu',
            'VI' => 'U.S. Virgin Islands',
            'UG' => 'Uganda',
            'UA' => 'Ukraine',
            'AE' => 'United Arab Emirates',
            'GB' => 'United Kingdom',
            'US' => 'United States',
            'UM' => 'United States Minor Outlying Islands',
            'UY' => 'Uruguay',
            'UZ' => 'Uzbekistan',
            'VU' => 'Vanuatu',
            'VA' => 'Vatican',
            'VE' => 'Venezuela',
            'VN' => 'Vietnam',
            'WF' => 'Wallis and Futuna',
            'EH' => 'Western Sahara',
            'YE' => 'Yemen',
            'ZM' => 'Zambia',
            'ZW' => 'Zimbabwe'
        );

        return $countryList;
    }

    public function actionEditProfile() {
        $page_id = $_GET['pid'];
        if (empty($page_id)) {
            throw new NotFoundHttpException('Id Missing');
        }
        $this->layout = 'main';
        $model = new Profile();
        $userid = Yii::$app->user->id;
        $page_detail = CustomProfilePage::find()->where(['id' => $page_id])->one();
        $profilefield = Profile::find()->where(['user_id' => $userid])->one();
        if (empty($page_detail) || empty($profilefield)) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
        $guid = User::find()->select(['guid'])->where(['id' => $profilefield->user_id])->one();
        $typ2title = CustomProfilePageField::find()->where(['custom_profile_page_id' => $page_detail->id])->orderBy(['sort_order' => SORT_ASC])->all();
        return $this->render('editprofile', ['model' => $model, 'profilefield' => $profilefield, 'page_detail' => $page_detail, 'typ2title' => $typ2title, 'page_id' => $page_id, 'guid' => $guid, 'current_userid' => $userid]);
    }

    public function actionSaveprofile() {
        $userid = Yii::$app->user->id;
        $modeldata = Yii::$app->request->post();
        $page_id = $modeldata['page_id'];
        if (!empty($modeldata['Profile'])) {
            foreach ($modeldata['Profile'] as $key => $value) {
                if (is_array($value)) {
                    $value = implode(',', $value);
                }
                Yii::$app->db->createCommand()->update('profile', [$key => $value], ['user_id' => $userid])->execute();
            }
        }
        $page_detail = CustomProfilePage::find()->where(['id' => $page_id])->one();
        return $this->redirect($page_detail->conclusion_text);
    }

    public function actionSignUrlSave() {
        $value = Yii::$app->request->post('value');
        Yii::$app->db->createCommand()->update('setting', ['value' => $value], ['module_id' => 'custom_profile', 'name' => 'signin_url'])->execute();
    }

}
