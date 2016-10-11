
<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use app\modules\custom_profile\models\CustomProfilePage;
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
                        <strong>Custom Profile Page</strong> Administration
                    </div>
                    <div class="administration-outer administration-admin-btn">
                        <div class="help-block">
                            Select an existing Custom Profile Page to edit, or create a new Custom Profile Page.     
                        </div>
                        <a href="#"><strong>Select an existing Custom Profile Page:</strong></a>
                        <ul class="admin-userprofiles-fields index-page-list">
                            <div class="index-show">
                                <?php
                                foreach ($active_pages as $page) {
                                    ?> 
                                    <li class="admin-userprofiles-field" data-id="1">
                                        <a href="<?php echo Yii::$app->request->baseUrl . '/index.php/survey_page/edit/' . $page->id . '' ?>"><?php echo "$page->name"; ?></a>
                                        <a class="btn btn-danger btn-xs index-btn page-delete" id="<?php echo $page->id; ?>" href="#"><i class="fa fa-times"></i></a>
                                    </li>

                                    <?php
                                }
                                ?>
                            </div>
                            <div class="ajx-show"></div>
                        </ul>
                        <?php
                        $form = ActiveForm::begin([
                                    'action' => ['custom-profile-page'],
                                    'method' => 'post',
                        ]);
                        ?>  
                        <div class="form-group field-profile-firstname">
                            <label class="control-label" for="profile-firstname">Or Create a new Custom Profile Page:</label>
                            <?php
                            if (!empty($_SESSION['pageno'])) {
                                $pageno = $_SESSION['pageno'];
                            } else {
                                $pageno = '';
                            }
                            ?>
                            <?= $form->field($model, 'name')->textInput(['maxlength' => true, 'name' => 'pagename', 'value' => $pageno, 'class' => 'form-control']); ?>

                            <?php
                            unset($_SESSION['pageno']);
                            ?>
                            <div class="help-block">Name of new Custom Profile Page </div>
                        </div>
                        <button class="btn btn-primary"> Next </button>
                        <?php ActiveForm::end(); ?>
                        <div>
                            <?php
                            if (isset($_SESSION['success_msg'])) {
                                echo $_SESSION['success_msg'];
                                unset($_SESSION['success_msg']);
                            }
                            ?>
                        </div>
                        <div class="form-divider"></div>
                        <div class="panel-heading">
                            <strong>Custom Profile Page</strong> Settings
                        </div>
                        <div>
                            Show Profile Pages on Menu : 
                            <div class="btn-group btn-toggle"> 
                                <button class="btn btn-xs btn-default btn-yes" id="yes">YES</button>
                                <button class="btn btn-xs btn-primary btn-no active" id="no">NO</button>
                            </div>

                        </div>
                        <br><br>
                        <div class="form-divider"></div>
                        <div class="panel-heading">
                            <strong>Signin page</strong> URL
                        </div>
                        <div>
                            <?php
                            echo Html::input('text', 'signin_url', $signin_id->value, ['class' => 'form-control signin_url']);
                            echo Html::submitButton('Save', ['class' => 'btn btn-primary signin_url_save']);
                            ?>
                            <div class="signin_save_success" style="display:none; color:#345b1b; font-weight: bold;"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
$this->registerJs("
    base_url = window.location.pathname.split( '/' )[1];
    $(document).on('click','.page-delete', function() {
        id = $(this).attr('id');
        $.ajax({
            url: '/'+base_url+'/index.php/custom_profile/default/delete-page',
            type: 'post',
            data: {id: +id },
            success: function(data) {
            $('.index-show').hide();
            $('.ajx-show').html(data);
            }
        });
    });
    
    $(document).ready(function() { 
        $.ajax({
            url: '/'+base_url+'/index.php/custom_profile/default/topmenu-status',
            type: 'post',
            success: function(data) {
                $('.btn-toggle').find('.btn').toggleClass('active');
                if(data==1){
                    $('.btn-toggle').find('.btn-yes').addClass('active');
                    $('.btn-toggle').find('.btn-no').removeClass('active');
                    $('.btn-toggle').find('.btn-no').removeClass('btn-primary');
                    $('.btn-toggle').find('.btn-yes').addClass('btn-primary');
                    //$(this).find('.btn').toggleClass('btn-primary');    
                } else {
                    //$('.btn-toggle').find('.btn').toggleClass('btn-default');
                    $('.btn-toggle').find('.btn-no').addClass('active');
                    $('.btn-toggle').find('.btn-yes').removeClass('active');
                    $('.btn-toggle').find('.btn-yes').removeClass('btn-primary');
                    $('.btn-toggle').find('.btn-no').addClass('btn-primary');
                }
            }
        });
    });
    
    $('.btn-toggle').click(function() {
        $(this).find('.btn').toggleClass('active');
        if ($(this).find('.btn-primary').size() > 0) {
            $(this).find('.btn').toggleClass('btn-primary');
        } else {
            $(this).find('.btn').toggleClass('btn-default');
        }
        var status_val = $(this).find('.active').attr('id');
        $.ajax({
            url: '/'+base_url+'/index.php/custom_profile/default/change-topmenu-status',
            type: 'post',
            data: {status_val: status_val },
            success: function(data) {
                location.reload();
            }
        });
    });
    

    $(document).on('click','.signin_url_save', function() {
        value = $('.signin_url').val();
        $.ajax({
            url: '/'+base_url+'/index.php/custom_profile/default/sign-url-save',
            type: 'post',
            data: {value: value },
            success: function(data) {
            $('.signin_save_success').show().html('URL Saved Successfully').fadeOut(7000);
            }
        });
    });
    
   
");
?>