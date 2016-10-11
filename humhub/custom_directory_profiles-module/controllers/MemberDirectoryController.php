<?php

namespace app\modules\member_directory\controllers;

use Yii;
use yii\data\Pagination;
use yii\filters\AccessControl;
use humhub\modules\user\models\Profile;
use humhub\modules\user\models\ProfileField;
use humhub\modules\user\models\ProfileFieldCategory;

class MemberDirectoryController extends \yii\web\Controller {

    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index', 'mentee', 'profile'],
                'rules' => [
                    [
                        'actions' => ['index', 'mentee', 'profile'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Renders the mentor view for the module
     * @return string
     */
    public function actionIndex() {
        $this->layout = 'member';
        $userid = Yii::$app->user->id;
        $userdata = Profile::find()->where(['user_id' => $userid])->one();
        $query = Profile::find()->where(['!=', 'user_id', $userid]);
        $countQuery = clone $query;
        $pages = new Pagination(['defaultPageSize' => 10, 'totalCount' => $countQuery->count()]);
        $models = $query->offset($pages->offset)->limit($pages->limit)->all();
        return $this->render('index', ['userdata' => $userdata, 'models' => $models, 'pages' => $pages]);
    }

    /**
     * Renders the mentee view 
     * @return string
     */
    public function actionMentee() {
        $this->layout = 'member';
        $userid = Yii::$app->user->id;
        $userdata = Profile::find()->where(['user_id' => $userid])->one();
        $query = Profile::find()->where(['!=', 'user_id', $userid]);
        $countQuery = clone $query;
        $pages = new Pagination(['defaultPageSize' => 10, 'totalCount' => $countQuery->count()]);
        $models = $query->offset($pages->offset)->limit($pages->limit)->all();
        return $this->render('mentee', ['userdata' => $userdata, 'modelvalues' => $models, 'pages' => $pages]);
    }
    
    /**
     * Renders the profile view 
     * @return string
     */

    public function actionProfile() {
        $this->layout = 'member';
        $user_id = Yii::$app->request->get('id');
        if (empty($user_id)) {
            return $this->redirect(Yii::$app->request->baseUrl . '/index.php/custom_profile/default/error');
        }
        $userdata = Profile::find()->where(['user_id' => $user_id])->one();
        return $this->render('profile', ['userdata' => $userdata]);
    }

}
