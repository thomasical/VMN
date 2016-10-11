<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use humhub\modules\custom_profile\Assets;
use app\modules\custom_profile\models\ProfileField;

Assets::register($this);
?>
<div class="container">
    <div class="row">
        <div class="col-md-12"> 
            <div class="col-md-3">
                <?= \humhub\modules\admin\widgets\AdminMenu::widget(); ?>
            </div>
            <div class="col-md-9">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <strong>Custom Profile Page </strong> Settings
                    </div>
                    <?php $form = ActiveForm::begin([ 'action' => ['update'], 'method' => 'post',]); ?>
                    <div class="administration-outer">
                        <div class="form-group field-profile-firstname">
                            <label class="control-label">Custom Profile Page Name</label>
                            <?php echo $form->field($cppmodel, 'name')->textInput(['id' => $page_detail->id, 'class' => 'form-control profile-page-name', 'value' => $page_detail->name,])->label(false) ?>
                        </div>
                        <div class="form-group field-profile-firstname">
                            <label class="control-label" for="profile-firstname">Specify Custom Profile Page title line 1 text</label>
                            <?php
                            echo $form->field($cppmodel, 'title_line1')->textInput(['class' => 'form-control', 'value' => $page_detail->title_line1,])->label(false);
                            ?>
                            <div class="help-block">It is OK to leave this blank </div>
                        </div>
                        <div class="form-group field-profile-firstname">
                            <label class="control-label" for="profile-firstname">Specify Custom Profile Page title line 2 text </label>
                            <?php
                            echo $form->field($cppmodel, 'title_line2')->textInput(['class' => 'form-control', 'value' => $page_detail->title_line2,])->label(false);
                            ?>
                            <div class="help-block">It is OK to leave this blank</div>
                        </div>
                        <input type="hidden" name="pageid" value="<?php echo $page_detail->id; ?>">
                        <div class="form-group field-profile-firstname">
                            <label class="control-label" for="profile-firstname">Specify Custom Profile Page questions introductory text, that appears above the Custom Profile Page questions</label>
                            <?php
                            echo $form->field($cppmodel, 'introductory_text')->textInput(['class' => 'form-control', 'value' => $page_detail->introductory_text,])->label(false);
                            ?>
                            <div class="help-block">It is OK to leave this blank</div>
                        </div>
                        <div>Select and order Custom Profile Page fields, from profile fields, that will appear on this Custom Profile Page</div>                       
                        <div class="pfieldwith">
                            <ul class="administration-list  sub-administration-list">
                                <?php
                                $present_field = array();
                                $i = 1;
                                foreach ($fieldname as $fieldnames) {
                                    $fieldtyp = ProfileField::find()->where(['internal_name' => $fieldnames->internal_name])->one();
                                    $present_field[$i++] = $fieldnames->profile_field_id;
                                    ?>
                                    <li>
                                        <p>
                                            <input type="checkbox" name="chkbx2" class="customprofile_chkbx2" value="<?php echo $fieldnames->id; ?>" data-disp_name1="<?php echo $fieldnames->display_name; ?>" checked="checked" 
                                                   data-field_id="<?php echo $fieldnames->profile_field_id; ?>" data-titl="<?php echo "$fieldtyp->title"; ?>" 
                                                   data-pg_id="<?php echo $fieldnames->custom_profile_page_id; ?>">
                                                   <?php
                                                   echo "$fieldtyp->title";
                                                   ?> 

                                        </p> 
                                    </li> 
                                    <?php
                                }
                                foreach ($profilefieldname as $profilefieldnames) {
                                    if (array_search($profilefieldnames->id, $present_field) == false) {
                                        ?> 
                                        <li> 
                                            <p>
                                                <input type="checkbox" class="customprofile_chkbx2" value="<?php echo $profilefieldnames->id; ?>" data-disp_name1="" data-field_id="<?php echo $profilefieldnames->id; ?>"
                                                       data-titl="<?php echo "$profilefieldnames->title"; ?>" data-pg_id="<?php echo $page_detail->id; ?>">
                                                       <?php
                                                       echo "$profilefieldnames->title";
                                                       ?>

                                            </p>
                                        </li>
                                        <?php
                                    }
                                }
                                ?> 
                            </ul>
                        </div>  
                        <label class="control-label">Sort Selected profile fields / Add Question Text</label>
                        <ul class="pfield-show sort-icn"></ul>    
                        <div class="form-group field-profile-firstname">     
                            <label class="control-label" for="profile-firstname">Specify Custom Profile Page questions footer text, that appears below the Custom Profile Page questions</label> 
                            <?php
                            echo $form->field($cppmodel, 'footer_text')->textInput(['class' => 'form-control', 'value' => $page_detail->footer_text,])->label(false);
                            ?>
                            <div class="help-block">It is OK to leave this blank</div>    
                        </div>                   
                        <div class="help-block"></div> 
                        <div class="form-group anothr-url">
                            <label class="control-label">Re-direct to</label>
                            <?php
                            echo $form->field($cppmodel, 'conclusion_text')->textInput(['class' => 'form-control another_url', 'value' => $page_detail->conclusion_text,])->label(false);
                            ?>
                            <div class="help-block url-help-block" style="display: none">Url must start with https:// or http://</div>
                        </div>
                        <label class="control-label">Helper Text</label>
                        <div class="field-text-editor">

                        </div>
                        <div class="button-holder">    
                            <button class="btn btn-primary save-btn" data-ui-loader=""> Save </button>   
                            <a class="btn btn-default pull-right" href="<?php echo Yii::$app->request->baseUrl; ?>/index.php/custom_profile"> Back </a> 
                        </div>      
                        <?php
                        ActiveForm::end();
                        ?>  
                        <div style="clear: both;"></div>   
                    </div>     
                </div>       
            </div>     
        </div>   
    </div>
</div>
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<?php
$this->registerJs("
    base_url = window.location.pathname.split( '/' )[1];
    $('.pfield-show').sortable();
    
    $(document).on('change','.another_url', function() {
        data = $(this).val();
        value = data.search( 'http://' );
        value_with_s = data.search( 'https://' );
        if(value == -1 && value_with_s == -1) {
           $('.url-help-block').show();
           $('.anothr-url').addClass('has-error');
        } else {
            $('.url-help-block').hide();
            $('.anothr-url').removeClass('has-error');
        }
    });
    
    $(document).on('click','.save-btn', function(e) {
    e.preventDefault();    
    flag = 'true';
        data = $('.another_url').val();
        value = data.search( 'http://' );
        value_with_s = data.search( 'https://' );
        if(value == -1 && value_with_s == -1) {
           $('.url-help-block').show();
           $('.anothr-url').addClass('has-error');
           flag = 'false'; 
        }
    if(flag == 'true'){
        $('.save-btn').submit();
    } else {
        $(this).find('span').remove();
        $(this).removeClass('disabled');
        $(this).removeAttr('style');
        $(this).text('Save');
        return false; 
    }
    });
    
    $(document).on('change','.profile-page-name', function() {
        pagenam = $(this).val();
        idvalue = $(this).attr('id');
        $.ajax({
            url: '/'+base_url+'/index.php/custom_profile/default/check-page',
            type: 'post',
            data: {pagename: pagenam,id: idvalue},
            success: function(data) {
                if(data==1){ 
                    alert('page already exist'); 
                }   
            } 
        });
    });
    $(document).on('click','.customprofile_chkbx2', function() {
        prof_field_value = $(this).attr('data-field_id');
        disp_val = $(this).attr('data-disp_name1');
        titl = $(this).attr('data-titl');
        pg_id = $(this).attr('data-pg_id');
        if($(this).is(':checked')== true) {
            $.ajax({
                url: '/'+base_url+'/index.php/custom_profile/default/load-field',
                type: 'post', 
                data: {title: titl, internl: prof_field_value },
                success: function(data) {
                    $('.field-text-editor').append(data);
                }
            });
            $.ajax({
                url: '/'+base_url+'/index.php/custom_profile/default/insert-field',
                type: 'post',
                data: {id: +prof_field_value, pg_id: pg_id },
                success: function(data) {
               if(data=='field exist'){
                    alert('Field already added');
                } else {
                    $('.pfield-show').append('<li id='+prof_field_value+'><input type=checkbox name=advsry[] value='+prof_field_value+' checked=checked style=display:none><div><a class=srt-btn-new href=\"#\" title=\"Drag to rearrange profile fields\"><i class=\"fa fa-arrows-v\" aria-hidden=\"true\"></i></a>'+titl+'<input type=text class=dispfield name=disp2[] value=\"'+disp_val+'\"></div></li>');
                }
                }
            });
        }
        if($(this).is(':checked')== false) { 
            $.ajax({
            url: '/'+base_url+'/index.php/custom_profile/default/delete',
            type: 'post',
            data: {id: +prof_field_value, pg_id: pg_id},
            success: function(data) {
                field_id_val = 'a'+prof_field_value;
                $('.pfield-show').find('#'+prof_field_value).remove();
                $('.field-text-editor').find('#'+field_id_val).remove();
            }
        });
        }

    });
    
    $(document).ready(function(){
        var ids=[]; 
        var titl =[];
        $('input[type=checkbox]:checked').each(function(){
            prof_fval = $(this).attr('data-field_id');
            titl_val = $(this).attr('data-titl');
            disp_value = $(this).attr('data-disp_name1');
            $('.pfield-show').append('<li id='+prof_fval+'><input type=checkbox name=advsry[] value='+prof_fval+' checked=checked style=display:none><div><a class=srt-btn-new href=\"#\" title=\"Drag to rearrange profile fields\"><i class=\"fa fa-arrows-v\" aria-hidden=\"true\"></i></a>'+titl_val+'<input type=text class=dispfield name=disp2[] value=\"'+disp_value+'\"></div></li>');   
            ids.push($(this).attr('data-field_id'));
            titl.push($(this).attr('data-titl'));
        });
        $.ajax({
                url: '/'+base_url+'/index.php/custom_profile/default/first-load-field',
                type: 'post', 
                //dataType: 'json',
                data: {title: titl, internl: ids },
                success: function(data) {
                    $('.field-text-editor').html(data);
                    
                }
            });
    radio_value = $('input:radio:checked').val();  
        if(radio_value == 1) {
            $('.thankyou-redctr').show();
            $('.anothr-page').hide();
            $('.anothr-url').hide();
        }
        if(radio_value == 2) {
            $('.anothr-page').show();
            $('.thankyou-redctr').hide();
            $('.anothr-url').hide();
        }
        if(radio_value == 3) {
            $('.anothr-url').show();
            $('.thankyou-redctr').hide();
            $('.anothr-page').hide();
        }
    });
    
    $(document).on('click','.regular-radio', function() { 
        value = $(this).val();
        if(value == 1) { 
            $('.thankyou-redctr').show();
            $('.anothr-page').hide();
            $('.anothr-url').hide();
        }
        if(value == 2) {
            $('.anothr-page').show();
            $('.thankyou-redctr').hide();
            $('.anothr-url').hide();
        }
        if(value == 3) {
            $('.anothr-url').show();
            $('.thankyou-redctr').hide();
            $('.anothr-page').hide();
        }
    });


");
?>