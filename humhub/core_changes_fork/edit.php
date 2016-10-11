<?php $this->beginContent('@user/views/account/_userProfileLayout.php') ?>
    <div class="help-block">
        <?php echo Yii::t('UserModule.views_account_edit', 'Here you can edit your general profile data, which is visible in the about page of your profile.'); ?>
    </div>
    <?php $form = \yii\widgets\ActiveForm::begin(['enableClientValidation' => false, 'options' => ['data-ui-tabbed-form' => '']]); ?>
    <?php echo $hForm->render($form); ?>
    <?php \yii\widgets\ActiveForm::end(); ?>
<?php $this->endContent(); ?>


<?php $this->registerJs("
    $('.chkbx').change(function() {
    
        var chkbox_value = [];
        $.each($('input[name=field]:checked'), function(){            
            chkbox_value.push($(this).val())
        }); 		
    });
   
         $('.field-profile-multi_select').append(\"<div class='append-textbox'></div>\");
        var other='';
        $('#profile-multi_select option').each(function()
        {
      
            if($(this).text()=='other'){
            
                other=$(this).val();
            }
        });
        

        var labels = '<label>Text Box</label>';
        var textbox='<input type=\"text\"  class=\"item form-control\" name=\"Message_textbox\" placeholder=\"Text Box\">';
        $('#profile-multi_select').on('select2:select', function(e) {  
        states=$(this).val(); 
        console.log(states);
        console.log(other);
        if(jQuery.inArray(other, states) != -1) {
            
            $('.append-textbox').html(textbox);
        }
   })

   $('#profile-multi_select').on('select2:unselect', function(e) {
        states=$(this).val(); 
        if(jQuery.inArray(other, states) == -1) {
            $('.append-textbox').html('');
        }
    })
$('.hint-txt').parent('div').find('.control-label').after('<div class=\"child-div\">Limit selections to those that contain this text:</div>');


$('.hint-txt').parent('div').append('<div class=\"js-example-tags-container\"></div>');

  $('.select2-hidden-accessible').on('change', function() {
    var selected = $(this).find('option:selected');
    var container = $(this).siblings('.js-example-tags-container');

    var list = $('<ul>');
    selected.each(function(k, v) {
      var li = $('<li class=\"tag-selected\"><a class=\"destroy-tag-selected\">x</a>' + $(v).text() + '</li>');
      li.children('a.destroy-tag-selected')
        .off('click.select2-copy')
        .on('click.select2-copy', function(e) {
          var opt = $(this).data('select2-opt');
          opt.attr('selected', false);
          opt.parents('select').trigger('change');
        }).data('select2-opt', $(v));
      list.append(li);
    });
    container.html('').append(list);
  }).trigger('change');

$('.hint-txt').on('select2:select', function(e) {
      var ele = $(this);
    maxlength= $(this).attr('data-maxlength');
      if(ele.val().length==maxlength){
      ele.select2('close');
      }
    })
");
?>
<?php 
\humhub\assets\TagAsset::register($this);

?>
