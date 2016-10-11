<?php 
use humhub\modules\custom_profile\Assets;

Assets::register($this);
?>
<div class="container">
    <div class="row">
        <div class="col-md-1"></div>
        <div class="col-md-10">
            <?php
            foreach ($page as $page) {
                ?> 
                <div class="panel panel-default wall_humhubmodulespostmodelsPost_3">
                    <div class="panel-body">
                        <div class="media">
                            <div class="media-body">
                                <h4 class="media-heading"><a href="<?php echo 'directory/' . $page->id . '' ?>"><strong><?php echo "$page->name"; ?></strong></a>
                                    <small>
                                        <span class="time" title=""> <?php echo Yii::$app->formatter->asDatetime($page->created_at); ?></span>
                                    </small>
                                </h4>
                                <h5><?php echo "$page->title_line1"; ?></h5>
                                <h5><?php echo "$page->title_line2"; ?></h5>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
            }
            ?>

        </div> 
        <div class="col-md-1"></div>
    </div>
</div>

<script src="http://code.jquery.com/jquery-latest.min.js"
type="text/javascript"></script>
<script>
    $(document).ready(function() {
        if(!$('.vmn_pag').hasClass('active')){
            $('.vmn_pag').addClass('active');
        }
        $('.vmn_menu').removeClass('active');
        $('.vmn_my_pg').removeClass('active');
    });
</script>





