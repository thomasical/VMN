<?php

use yii\helpers\Html;
use yii\helpers\Url;
?>
<div class="container">
    <div class="panel panel-danger">
        <div class="panel-heading">
            <?php echo Yii::t('error', "<strong>Login</strong> required"); ?>
        </div>
        <div class="panel-body">
            <strong><?php echo Html::encode($message); ?></strong>
            <br />
            <hr>
            <a href="<?php echo Yii::$app->request->baseUrl; ?>/index.php/llinkedin/llinkedin" class="nw-linkedin">
                    <div class="btn btn-primary llinkedin-new" style="background: #07b;">
                        <div style="text-align: left; float: left;"><strong>In|</strong></div>
                        Sign in with LinkedIn
                    </div>
                </a>
            <a href="javascript:history.back();" class="btn btn-primary  pull-right"><?php echo Yii::t('base', 'Back'); ?></a>
        </div>
    </div>
</div>
