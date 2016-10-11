<?php

use yii\web\View;
use humhub\modules\user\models\User;
use humhub\modules\custom_profile\Assets;
use app\modules\custom_profile\models\ProfileField;

Assets::register($this);
?>
<div class="container-fluid">
    <div class="row">
        <div class="left-col"></div>
        <div class="center-col">
            <div class="panel panel-default">
                <div class="panel-heading">        
                    <div class="panel-big-text"><?php echo $page_detail->title_line1; ?></div>  
                    <h2 class="Custom-Profile-head"><?php echo $page_detail->title_line2; ?></h2>
                </div>
                <div class="panel-body">
                    <ul class="Custom-Profile-list media-list">
                        <li>
                            <div class="media">
                                <div class="pull-right"></div>
                                <a href="#" class="pull-left" alt="user image">
                                    <?php  ?>
                                    <img id="user-account-image" class="img-rounded" src="<?php echo Yii::$app->request->baseUrl; ?>/uploads/profile_image/<?php echo $guid->guid; ?>.jpg" onerror="this.src='<?php echo Yii::$app->request->baseUrl; ?>/img/default_user.jpg'" height="50" width="50" alt="50x50" data-src="holder.js/50x50" style="width: 50px; height: 50px;">
                                </a>                                
                            </div>
                        </li>
                    </ul>
                    <div class="user_response-bg">
                        <?php
                        foreach ($typ2title as $titlevalue) {
                            $titlenam = $titlevalue->internal_name;
                            if ($profilefield->$titlenam):
                                $fieldtyp = ProfileField::find()->select(['field_type_class','editable'])->where(['internal_name' => $titlenam])->one();
                                $fieldtype = explode('\\', $fieldtyp->field_type_class);
                                $fieldtypes = $fieldtype[5];
                                if ($fieldtypes == 'Birthday' || $fieldtypes == 'Date') {
                                    $internal_value = Yii::$app->formatter->asDate($profilefield->$titlenam, 'MM-dd-yyyy');
                                } else {
                                    $internal_value = $profilefield->$titlenam;
                                }
                                ?>
                                <h5 class="media-heading media-heading-new">
                                    <label><strong>Q: <?php echo $titlevalue->display_name; ?></strong></label><br>
                                    <label><strong>A:</strong> <?php echo $internal_value; ?></label>
                                </h5>
                                <?php
                            endif;
                        }
                        ?>
                    </div>
                    <h5><?php echo $page_detail->footer_text; ?></h5>
                </div>
            </div> 
        </div>
        <div class="right-col"></div>
    </div>
</div>
<script src='https://cdn.jsdelivr.net/mousetrap/1.6.0/mousetrap.js'></script>
<?php
$this->registerJs("
    Mousetrap.bind(\"ctrl+d\", function(e) {
    var pageid = $('.get-data').attr('data-pageid');
    baseurl = location.href.split( '/' );
    ssss = 'http://'+baseurl[2]+'/'+baseurl[3]+'/index.php?r=custom_profile/default/directory&pid='+pageid;
	window.location.replace(ssss);
});
    ");
?>