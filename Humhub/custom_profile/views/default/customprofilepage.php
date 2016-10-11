<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use humhub\modules\custom_profile\Assets;


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

                    <?php
                    $form = ActiveForm::begin([
                                'action' => ['custom-profile-setting'],
                                'method' => 'post',
                    ]);
                    ?>  
                    <div class="administration-outer">
                        <div><?php
                            $pagename = Yii::$app->request->post('pagename');
                            echo $pagename;
                            $_SESSION['pageno'] = $pagename;
                            ?> Custom Profile Page </div>
                        <?php
                        echo $form->field($cppmodel, 'name')->hiddenInput(['value'=> $pagename])->label(false);
                        ?>
                        <div class="form-group">
                            <label class="control-label" for="profile-firstname">Specify Custom Profile Page title line 1 text</label>
                            <?php
                            echo $form->field($cppmodel, 'title_line1')->textInput(['class' => 'form-control'])->label(false);
                            ?>
                            <div class="help-block">It is OK to leave this blank </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="profile-firstname">Specify Custom Profile Page title line 2 text </label>
                            <?php
                            echo $form->field($cppmodel, 'title_line2')->textInput(['class' => 'form-control'])->label(false);
                            ?>
                            <div class="help-block">It is OK to leave this blank</div>
                        </div>
                        <div class="form-group field-profile-firstname">
                            <label class="control-label" for="profile-firstname">Specify Custom Profile Page questions introductory text, that appears above the Custom Profile Page questions</label>
                            <?php
                            echo $form->field($cppmodel, 'introductory_text')->textInput(['class' => 'form-control',])->label(false);
                            ?>
                            <div class="help-block">It is OK to leave this blank</div>
                        </div>
                        <div>Select and order Custom Profile Page fields, from profile fields, that will appear on this Custom Profile Page</div>
                        <div class="form-group field-profile-firstname">
                            <label class="control-label" for="profile-firstname">Select a profile field</label>
                        </div>
                        <ul>
                            <?php
                            foreach ($ProfileFieldCategory as $category):
                                ?>
                                <li>
                                    <strong><?php echo $category->title; ?></strong>
                                    <ul class="administration-list sub-administration-list">
                                        <?php
                                        foreach ($fieldname as $fieldnames) {
                                            if ($category->id == $fieldnames->profile_field_category_id) {
                                                ?> 

                                                <li>
                                                    <p>
                                                        <input type="checkbox" class="chkbx-text2" value="<?php echo $fieldnames->id; ?>"
                                                               data-title="<?php echo "$fieldnames->title"; ?>" data-internl="<?php echo "$fieldnames->id"; ?>">
                                                               <?php echo "$fieldnames->title"; ?>

                                                    </p>         
                                                </li>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </ul> 
                                </li>
                            <?php endforeach; ?>
                        </ul>
                        <label class="control-label">Sort Selected profile fields / Add Question Text</label>
                        <ul class="sort-field sort-icn"></ul>
                        <div class="form-group field-profile-firstname">
                            <label class="control-label" for="profile-firstname">Specify Custom Profile Page questions footer text, that appears below the Custom Profile Page questions</label>
                            <?php
                            echo $form->field($cppmodel, 'footer_text')->textInput(['class' => 'form-control',])->label(false);
                            ?>
                            <div class="help-block">It is OK to leave this blank</div>
                        </div>
                        <div class="help-block"></div>
                        <div class="form-group anothr-url">
                            <label class="control-label">Re-direct to</label>
                            <?php
                            echo $form->field($cppmodel, 'conclusion_text')->textInput(['class' => 'form-control another_url'])->label(false);
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
                        <?php ActiveForm::end(); ?>
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
    $('.sort-field').sortable();
    
   $(document).on('click','.chkbx-text2', function() { 
        id_val = $(this).val();
        title = $(this).attr('data-title');
        internl = $(this).attr('data-internl'); 
        if($(this).is(':checked')== true) {
            $('.sort-field').append('<li id='+internl+'><input type=checkbox name=advsry[] value='+id_val+' checked=checked style=display:none><div class=control-label><a class=srt-btn-new href=\"#\" title=\"Drag to rearrange profile fields\"><i class=\"fa fa-arrows-v\" aria-hidden=\"true\"></i></a>'+title+' <input type=text class=dispfield name=disp2[]></div></li>');
            $.ajax({
                url: '/'+base_url+'/index.php/custom_profile/default/load-field',
                type: 'post',
                data: {title: title, internl: internl },
                success: function(data) {
                    $('.field-text-editor').append(data);
                    //var tmp= $(data).find('#response-ajax').html();
                    //$('.field-text-editor').append(tmp);
                }
            });
        }
        if($(this).is(':checked')== false) {
            $('.sort-field').find('#'+internl).remove();
            $('.field-text-editor').find('#a'+internl).remove();
        }
    });
    
     
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
   
");
?>