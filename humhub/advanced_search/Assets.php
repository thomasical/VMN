<?php/** * @link https://www.humhub.org/ * @copyright Copyright (c) 2015 HumHub GmbH & Co. KG * @license https://www.humhub.com/licences */namespace humhub\modules\advanced_search;use yii\web\AssetBundle;use yii;class Assets extends AssetBundle {    //public $dir= dirname __FILE__;    public $sourcePath;    public $css = [        'advance_search_theme.css',            ];    public $js = [            ];    public function init() {        $baseurl = Yii::$app->request->baseUrl;        $this->sourcePath = 'protected/modules/advanced_search/assets';        parent::init();    }    public $depends = ['humhub\\assets\\AppAsset',];    public $publishOptions = [        'forceCopy' => false,    ];}