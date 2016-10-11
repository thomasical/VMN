<?php

use humhub\modules\user\models\ProfileField;

Yii::$app->setModule('redactor', ['class' => 'yii\redactor\RedactorModule']);

$array_count = count($internl);
if ($array_count > 0) {
    $internl = array_unique($internl);
    $title = array_unique($title);

    for ($i = 0; $i < $array_count; $i++) {
        if (!empty($internl[$i])) {
            $idvalue = "a" . $internl[$i];

            $fieldtyp = ProfileField::find()->select(['description'])->where(['id' => $internl[$i]])->one();
            ?>
            <div id="<?php echo $idvalue; ?>" class="response-ajax">
                <label class="control-label"><?php echo $title[$i]; ?></label>

                <?=
                \yii\redactor\widgets\Redactor::widget([
                    'name' => 'nam[' . $internl[$i] . ']',
                    'value' => $fieldtyp->description,
                    'clientOptions' => [
                                'plugins' => ['clips', 'fontcolor','imagemanager','fontsize'],
                                    ]
                ])
                ?>
            </div>
            <?php
        }
    }
}
?>