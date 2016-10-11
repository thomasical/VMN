<?php

use yii\bootstrap\Html;
use yii\helpers\Url;
?>

<div class="panel-body">
    <div class="pull-right">
        <?php echo Html::a('<i class="fa fa-arrow-left" aria-hidden="true"></i>&nbsp;&nbsp;' . Yii::t('AdminModule.user', 'Back to overview'), Url::to(['index']), array('class' => 'btn btn-default')); ?>
    </div>   


    <?php if (!$field->isNewRecord) : ?>
        <h4><?php echo Yii::t('AdminModule.views_userprofile_editField', 'Edit profile field'); ?></h4>
    <?php else: ?>
        <h4><?php echo Yii::t('AdminModule.views_userprofile_editField', 'Create new profile field'); ?></h4>
    <?php endif; ?>

    <br />

    <?php $form = \yii\widgets\ActiveForm::begin(); ?>
    <?php echo $hForm->render($form); ?>
    <?php \yii\widgets\ActiveForm::end(); ?>
</div>


<script>

    /**
     * Switcher for Sub Forms (FormField Type)
     */

    // Hide all Subforms for types
    $(".fieldTypeSettings").hide();

    showTypeSettings = $("#profilefield-field_type_class").val();
    showTypeSettings = showTypeSettings.replace(/[\\]/g, '_');


    // Display only the current selected type form
    $("." + showTypeSettings).show();

    $("#profilefield-field_type_class").on('change', function () {
        // Hide all Subforms for types
        $(".fieldTypeSettings").hide();

        // Show Current Selected
        showTypeSettings = $("#profilefield-field_type_class").val();
        showTypeSettings = showTypeSettings.replace(/[\\]/g, '_');
        console.log(showTypeSettings);
        $("." + showTypeSettings).show();
    });
    $('button[name="save"]').on('click', function (e) {
        e.preventDefault();

        field_value = $("#profilefield-field_type_class").val();
        if (field_value === 'humhub\\modules\\user\\models\\fieldtype\\MultiSelectDropdown')
        {
            multiselect_value = $("#multiselectdropdown-options").val();
            max_length = $("#multiselectdropdown-max_selection_length").val();
            flag = 'true';
            if(multiselect_value== "") {
                    $('#multiselectdropdown-options').parent('div').find('.help-block').before('<div class=\"child-help\">Field cannot be empty</div>');
                    flag = 'false';
                    return false;
                }
            if(max_length== "") {
                    $("#multiselectdropdown-max_selection_length").parent('div').find('.help-block').before('<div class=\"child-help\">Max selection length missing</div>');
                    flag = 'false';
                    return false;
                }
            if (flag !== 'false') {
                $('button[name="save"]').submit();
            }
        } else {
            $('button[name="save"]').submit();
        }
    });

    $('#multiselectdropdown-options').parent('div').find('.control-label').after('<div class=\"child-div\">Options are seperated by endline and category must be started with pipe(|) ex : |fruit \n orange \n apple</div>');



</script>


