<?php
foreach ($page as $page) {
    ?> 
    <li class="admin-userprofiles-field" data-id="1">
        <a href="<?php echo Yii::$app->request->baseUrl . '/index.php/survey_page/edit/' . $page->id . '' ?>"><?php echo "$page->name"; ?></a>
        <a class="btn btn-danger btn-xs index-btn page-delete" id="<?php echo $page->id; ?>" href="#"><i class="fa fa-times"></i></a>
    </li>
    <?php
}
?>