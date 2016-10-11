<?php

use yii\web\View;
use yii\helpers\Html;
use kartik\select2\Select2;
use kartik\date\DatePicker;
use yii\widgets\ActiveForm;
use humhub\assets\TagAsset;
use humhub\modules\custom_profile\Assets;
use humhub\modules\user\models\ProfileField;

Assets::register($this);
TagAsset::register($this);
?>
<div class="container">
    <div class="row">
        <div class="col-md-1"></div>
        <div class="col-md-10">
            <div class="panel panel-default edit-profile-panel">
                <div class="panel-heading">        
                    <strong><?php echo $page_detail->title_line1; ?></strong>                     
                </div>
                <div class="panel-body">            
                    <h5 class="Custom-Profile-head"><?php echo $page_detail->title_line2; ?></h5>
                    <a href="#" alt="user image">

                    </a>
                    <div class="user_response-bg"> 
                        <?php
                        $form = ActiveForm::begin([
                                    'action' => ['saveprofile'],
                                    'method' => 'post',
                        ]);
                        echo Html::hiddenInput('page_id', $page_id);
                        $tag_indx = 1;
                        foreach ($typ2title as $titlevalue) {
                            $titlenam = $titlevalue->internal_name;
                            $fieldtyp = ProfileField::find()->select(['field_type_class', 'field_type_config', 'description'])->where(['internal_name' => $titlenam])->one();
                            $fieldtype = explode('\\', $fieldtyp->field_type_class);
                            $fieldtypes = $fieldtype[5];
                            ?>
                            <div class="edit-profile-form">
                                <label><?php echo $titlevalue->display_name; ?></label>
                                <div class="small-text"> <?php echo $fieldtyp->description; ?></div>
                                <?php
                                switch ($fieldtypes) {
                                    case 'Text':
                                        echo $form->field($model, $titlevalue->internal_name)->textInput(['id' => $tag_indx, 'class' => 'form-control enterSubmit', 'value' => $profilefield->$titlenam, 'tabindex' => $tag_indx++,])->label(false);
                                        break;
                                     case 'Number':
                                        echo $form->field($model, $titlevalue->internal_name)->textInput(['id' => $tag_indx, 'type' => 'number', 'class' => 'form-control enterSubmit', 'value' => $profilefield->$titlenam, 'tabindex' => $tag_indx++,])->label(false);
                                        break;

                                    case 'TextArea':
                                        echo $form->field($model, $titlevalue->internal_name)->textArea(['id' => $tag_indx, 'rows' => '6', 'class' => 'form-control', 'value' => $profilefield->$titlenam, 'tabindex' => $tag_indx++,])->label(false);
                                        break;
                                    case 'Select':
                                        $select_option = '';
                                        $select_item = '';
                                        $select_option = json_decode($fieldtyp->field_type_config, true);
                                        $select_option_data = $select_option['options'];
                                        if (!empty($select_option_data)) {
                                            foreach (explode("\n", $select_option_data) as $option) {
                                                if (strpos($option, "=>") !== false) {
                                                    $option = rtrim($option);
                                                    list($select_key, $select_value) = explode("=>", $option);
                                                    $select_item[$select_key] = $select_value;
                                                } else {
                                                    $select_item[] = $option;
                                                }
                                            }
                                        }
                                        $model->$titlenam = $profilefield->$titlenam;
                                        echo $form->field($model, $titlevalue->internal_name)->dropDownList($select_item, ['id' => $tag_indx, 'class' => 'form-control', 'tabindex' => $tag_indx++,'prompt' => '------------Please Select------------',])->label(false);
                                        break;
                                    case 'CountrySelect':
                                        $model->$titlenam = $profilefield->$titlenam;
                                        $country_name = \app\modules\custom_profile\controllers\DefaultController::list_of_country();
                                        echo $form->field($model, $titlevalue->internal_name)->dropDownList($country_name, ['class' => 'form-control', 'tabindex' => $tag_indx++,])->label(false);
                                        break;
                                    case 'Birthday':
                                        echo $form->field($model, $titlevalue->internal_name)->widget(DatePicker::classname(), [
                                            'value' => '',
                                            'id' => $tag_indx,
                                            'readonly' => true,
                                            'options' => [
                                                'value' => $profilefield->$titlenam,
                                            ],
                                            'pluginOptions' => [
                                                'autoclose' => true,
                                                'tabindex' => $tag_indx++,
                                                'format' => 'yyyy/mm/dd'
                                            ]
                                        ])->label(false);

                                        break;
                                    case 'Date':
                                        echo $form->field($model, $titlevalue->internal_name)->widget(DatePicker::classname(), [
                                            'id' => $tag_indx,
                                            'value' => '',
                                            'readonly' => true,
                                            'options' => [
                                                'value' => $profilefield->$titlenam,
                                            ],
                                            'pluginOptions' => [
                                                'autoclose' => true,
                                                'tabindex' => $tag_indx++,
                                                'format' => 'yyyy/mm/dd'
                                            ]
                                        ])->label(false);
                                        break;
                                }
                                ?>
                            </div>
                            <?php
                        }
                        ?>
                    </div> 
                    <h5><?php echo $page_detail->footer_text; ?></h5>
                    <?= Html::submitButton('Save', ['class' => 'btn btn-primary','data-ui-loader' => '']) ?>
                    <?php ActiveForm::end(); ?>
                </div>                
            </div>
        </div> 
    </div>
    <div class="col-md-1"></div>
</div>
<?php
$this->registerJs("
    $(document).ready(function() {
    $('#1').focus();
    
tag_index = $('.bootstrap-tagsinput').next('input:text').attr('tabindex');
        $('.bootstrap-tagsinput').find('input:text').attr('tabindex',tag_index);
        
$('.form-control').keyup(function (event) {
            if (event.keyCode == 13) {
                textboxes = $('.form-control');
                currentBoxNumber = textboxes.index(this);
                console.log(textboxes.index(this));
                if (textboxes[currentBoxNumber + 1] != null) {
                    nextBox = textboxes[currentBoxNumber + 1];
                    nextBox.focus();
                    nextBox.select();
                    event.preventDefault();
                    return false;
                }
            }
            
        });
        if(!$('.vmn_menu').hasClass('active')){
            $('.vmn_menu').addClass('active');
        }
        $('.vmn_pag').removeClass('active');
        $('.vmn_my_pg').removeClass('active');
        
    $('body').addClass('body-holder');

  });  
$('.enterSubmit').keypress(function(e) {
    if(e.which == 13) {
        return false;
    }
});
");
?>
