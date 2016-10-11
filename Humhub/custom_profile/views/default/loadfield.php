<?php

use humhub\modules\user\models\ProfileField;

Yii::$app->setModule('redactor', ['class' => 'yii\redactor\RedactorModule']);

$idvalue = "a" . $internl;
if (!empty($internl)) {
    $fieldtyp = ProfileField::find()->select(['description'])->where(['id' => $internl])->one();
    ?>
    <div id="<?php echo $idvalue; ?>" class="response-ajax">
        <label class="control-label"><?php echo $title ?></label>
        <?=
        \yii\redactor\widgets\Redactor::widget([
            'name' => 'nam[' . $internl . ']',
            'value' => $fieldtyp->description,
            'clientOptions' => [
                'plugins' => ['clips', 'fontcolor', 'imagemanager', 'fontsize'],
            ]
        ])
        ?>
    </div>
    <?php
}
?>