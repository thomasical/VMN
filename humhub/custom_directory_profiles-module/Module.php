<?php

namespace humhub\modules\member_directory;

use Yii;
use yii\helpers\Url;
use humhub\modules\space\models\Space;
use humhub\modules\user\models\User;
use humhub\modules\content\components\ContentContainerActiveRecord;
use humhub\models\Setting;

/**
 * member_directory module definition class
 */
class Module extends \humhub\modules\content\components\ContentContainerModule {

    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'app\modules\member_directory\controllers';

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
        

        parent::disable();
    }

    /**

     * @inheritdoc

     */
    public function enable() {

        parent::enable();
    }

    public function getConfigUrl() {
        
    }


}
