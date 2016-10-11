<?php

use humhub\modules\user\widgets\AccountMenu;
use humhub\modules\admin\widgets\AdminMenu;
use humhub\widgets\BaseMenu;
use humhub\widgets\TopMenu;

return [
    'id' => 'custom_profile',
    'class' => 'humhub\modules\custom_profile\Module',
    'namespace' => 'humhub\modules\custom_profile',
    'events' => [
        ['class' => AdminMenu::className(), 'event' => AdminMenu::EVENT_INIT, 'callback' => ['humhub\modules\custom_profile\Events', 'onAdminMenuInit']],
        ['class' => TopMenu::className(), 'event' => TopMenu::EVENT_INIT, 'callback' => ['humhub\modules\custom_profile\Events', 'showPageonTopMenu']],
    ],
];
?>