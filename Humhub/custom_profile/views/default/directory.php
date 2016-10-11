<?php

use humhub\modules\user\models\User;
use humhub\modules\custom_profile\Assets;
use app\modules\custom_profile\models\ProfileField;

Assets::register($this);
?>
<div class="container">
    <div class="row">
        <div class="col-md-1"></div>
        <div class="col-md-10">
            <div class="panel panel-default">
                <div class="panel-heading">        
                    <strong><?php echo $page_detail->title_line1; ?></strong>  
                    <h5 class="Custom-Profile-head"><?php echo $page_detail->title_line2; ?></h5>
                </div>
                <div class="panel-body">            
                    <div class="Custom-Profile-btn-right">
                        <a class="btn btn-success" href="<?php echo Yii::$app->request->baseUrl . '/index.php/custom_profile/default/edit-profile/' . $page_id . '' ?>" alt="Edit Your Page">View and Edit Your Page</a>
                    </div>
                    <ul class="Custom-Profile-list media-list">
                        <?php                        
                        foreach ($userdatas as $userdata) {
                            if ($userdata == null) {
                                continue;
                            }
                            $flag = 0;
                            foreach ($title as $typ2titles) {
                                $typ2internal = $typ2titles->internal_name;
                                if ($userdata->$typ2internal):
                                    $flag = 1;
                                endif;
                            }
                            if ($flag == 1):
                            ?>
                            <li>
                                <div class="media">
                                    <div class="pull-right"></div>
                                    <a href="<?php echo Yii::$app->request->baseUrl . '/index.php/custom_profile/default/view/' . $userdata->user_id . '/' . $page_id . '/1' ?>" class="pull-left" alt="profile pic">
                                        <?php
                                        $guid = User::find()->select(['guid'])->where(['id' => $userdata->user_id])->one();
                                        if ($guid == null) {
                                            continue;
                                        }
                                        ?>
                                        <img id="user-account-image" class="img-rounded" src="<?php echo Yii::$app->request->baseUrl; ?>/uploads/profile_image/<?php echo $guid->guid; ?>.jpg" onerror="this.src='<?php echo Yii::$app->request->baseUrl; ?>/img/default_user.jpg'" 
                                             height="50" width="50" alt="50x50" data-src="holder.js/50x50" style="width: 50px; height: 50px;">
                                    </a>
                                    <div class="media-body editable-outer">
                                        <?php
                                        $tit_value = array();
                                        foreach ($title as $titles) {
                                            $internal = $titles->internal_name;
                                            if ($userdata->$internal):
                                                $fieldtyp = ProfileField::find()->select(['field_type_class'])->where(['internal_name' => $internal])->one();
                                                $fieldtype = explode('\\', $fieldtyp->field_type_class);
                                                $fieldtypes = $fieldtype[5];
                                                if ($fieldtypes == 'Birthday' || $fieldtypes == 'Date') {
                                                    $internal_value = Yii::$app->formatter->asDate($userdata->$internal, 'MM-dd-yyyy');
                                                } else {
                                                    $internal_value = $userdata->$internal;
                                                }
                                                ?>
                                                <h5 class="media-heading">
                                                <?php echo $internal_value; ?>
                                                </h5>
                                                <?php
                                            endif;
                                        }
                                        ?>
                                        <div class="Custom-Profile-btn-right">
                                            <a class="btn btn-success" href="<?php echo Yii::$app->request->baseUrl . '/index.php/custom_profile/default/view/' . $userdata->user_id . '/' . $page_id . '/1' ?>" alt="View Page">View Profile Page</a>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <?php
                            endif;
                        }
                        ?>
                    </ul>

                </div>
            </div> 
        </div>
        <div class="col-md-1"></div>
    </div>
</div>





