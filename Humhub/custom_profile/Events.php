<?php

namespace humhub\modules\custom_profile;

use Yii;
use yii\helpers\Url;
use humhub\models\Setting;
use app\modules\custom_profile\models\CustomProfilePage;

/**
 * CustomPagesEvents
 *
 * @author luke
 */
class Events extends \yii\base\Object {

    public static function onAdminMenuInit($event) {
        if (Yii::$app->user->isAdmin()) {
            $event->sender->addItem(array(
                'label' => Yii::t('CustomProfileModule.base', 'Custom Profile Pages'),
                'url' => Url::to(['/custom_profile/default']),
                'group' => 'manage',
                'icon' => '<i class="fa fa-file-o"></i>',
                'isActive' => (Yii::$app->controller->module && Yii::$app->controller->module->id == 'custom_profile'),
                'sortOrder' => 300,
            ));
        }
    }


    public static function showPageonTopMenu($event) {

        $show_status = Setting::find()->select(['value'])->where(['module_id' => 'custom_profile', 'name' => 'show_on_top_menu'])->one();
        if ($show_status->value == 1) {
            $event->sender->addItem(array(
                'label' => Yii::t('CustomProfileModule.base', 'Custom Profile Pages'),
                'url' => Url::to(['/custom_profile/default/home']),
                'id' => 'vmn_pag',
                'icon' => '<i class="fa fa-file-o"></i>',
                'isActive' => (Yii::$app->controller->module && Yii::$app->controller->module->id == 'custom_profile'),
                'sortOrder' => 998,
            ));
        }
    }

}
