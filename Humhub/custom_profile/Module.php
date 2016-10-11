<?php

namespace humhub\modules\custom_profile;

use Yii;
use yii\helpers\Url;
use app\modules\custom_profile\models\CustomProfilePage;
use app\modules\custom_profile\models\CustomProfilePageField;
use humhub\modules\space\models\Space;
use humhub\modules\user\models\User;
use humhub\modules\content\components\ContentContainerActiveRecord;
use humhub\models\Setting;

/**
 * custom_profile module definition class
 */
class Module extends \humhub\modules\content\components\ContentContainerModule {

    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'app\modules\custom_profile\controllers';

    public function getContentContainerTypes() {
        return [
            Space::className(),
        ];
    }

    /**
     * @inheritdoc
     */
    public function init() {
        parent::init();
    }

    public function disable() {
        foreach (CustomProfilePage::find()->all() as $custom) {
            $custom->delete();
        }
        foreach (CustomProfilePageField::find()->all() as $customfields) {
            $customfields->delete();
        }

        parent::disable();
    }

    /**

     * @inheritdoc

     */
    public function enable() {

        parent::enable();

        Setting::Set('show_on_top_menu', 1, 'custom_profile');
        Setting::Set('signin_url', 'custom_profile/default/edit-profile/1', 'custom_profile');
        
    }

    public function getConfigUrl() {
        return Url::to([
                    '/custom_profile/default/'
        ]);
    }

    public function getContentContainerName(ContentContainerActiveRecord $container) {
        return Yii::t('CustomProfileModule.base', 'Custom Profile');
    }

    public function getContentContainerDescription(ContentContainerActiveRecord $container) {
        if ($container instanceof Space) {
            return Yii::t('CustomProfileModule.base', 'Allows to add page');
        }
    }

    public function disableContentContainer(ContentContainerActiveRecord $container) {
        parent::disableContentContainer($container);

        foreach (CustomProfilePage::find()->all() as $custom) {
            $custom->delete();
        }
        foreach (CustomProfilePageField::find()->all() as $customfields) {
            $customfields->delete();
        }
    }

}
