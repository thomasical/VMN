<?php

use humhub\modules\member_directory\Assets;

Assets::register($this);
?> 
<div class="container-fluid">
    <div class="member-directory-outer">
        <div class="virtual-business-card-left">
            <div class="virtual-business-card-outer" style="display: none;">
                <h4 class="virtual-business-head">Lorem Ipsum</h4>
                <p class="virtual-business-text">
                    Lorem Ipsum is simply dummy text of the printing and typesetting industry. 
                </p>
            </div>
        </div>
        <div class="virtual-business-card">
            <div class="virtual-business-card-outer active">
                <div class="user-info">
                    <?php
                    $guid = \humhub\modules\user\models\User::find()->select(['guid'])->where(['id' => $userdata->user_id])->one();
                    ?>
                    <a href="#">
                        <img src="<?php echo Yii::$app->request->baseUrl; ?>/uploads/profile_image/<?php echo $guid->guid; ?>.jpg" onerror="this.src='<?php echo Yii::$app->request->baseUrl; ?>/img/default_user.jpg'" alt="user">  
                    </a>
                    <div class="but-group">
                        <a href="#"><i class="fa fa-star" aria-hidden="true"></i></a>
                    </div>
                </div>                
                <h4>
                    <strong>
                        <?php
                        echo $userdata->firstname, " ", $userdata->lastname;
                        if (!empty($userdata->positions)) {
                            echo " , ", $userdata->positions;
                        }
                        if (!empty($userdata->company)) {
                            echo " @ ", $userdata->company;
                        }
                        ?>
                    </strong>
                </h4>
                <?php
                if (!empty($userdata->industry)) {
                    ?>
                    <h5><span><strong>Industry: </strong></span><?php echo $userdata->industry ?></h5>
                    <?php
                }
                ?>
                <?php
                if (!empty($userdata->current_occupation)) {
                    ?>
                    <h5><span><strong>Current Occupation: </strong></span>
                        <?php
                        echo str_replace(",", " ,  ", $userdata->current_occupation);
                        ?>
                    </h5>
                    <?php
                }
                ?>
                <?php
                if (!empty($userdata->professional_expertise)) {
                    ?>
                    <h5><span><strong>Professional Expertise: </strong></span>
                        <?php
                        echo str_replace(",", " ,  ", $userdata->professional_expertise);
                        ?>
                    </h5>
                    <?php
                }
                ?>

                <?php
                if (!empty($userdata->certifications)) {
                    ?>
                    <h5><span><strong>Certifications: </strong></span>
                        <?php
                        echo str_replace(",", " ,  ", $userdata->certifications);
                        ?>
                    </h5>
                    <?php
                }
                ?>

                <?php
                if (!empty($userdata->mentoring_specialties)) {
                    ?>
                    <h5><span><strong>Mentoring Specialties: </strong></span>
                        <?php
                        echo str_replace(",", " ,  ", $userdata->mentoring_specialties);
                        ?>
                    </h5>
                    <?php
                }
                ?>



                <h5>

                    <?php
                    if (!empty($userdata->military_status) || !empty($userdata->military_grade) || !empty($userdata->military_branch) || !empty($userdata->military_occupations)) {
                        ?>
                        <span><strong>Military Status: </strong></span>
                        <?php
                        if (!empty($userdata->military_status)) {
                            echo str_replace(",", " ,  ", $userdata->military_status);
                        }
                        if (!empty($userdata->military_branch)) {
                            if (!empty($userdata->military_status)) {
                                echo " ; ", str_replace(",", " ,  ", $userdata->military_branch);
                            } else {
                                echo str_replace(",", " ,  ", $userdata->military_branch);
                            }
                        }
                        if (!empty($userdata->military_occupations)) {
                            if (!empty($userdata->military_status) || !empty($userdata->military_branch)) {
                                echo " ; ", str_replace(",", " ,  ", $userdata->military_occupations);
                            } else {
                                echo str_replace(",", " ,  ", $userdata->military_occupations);
                            }
                        }
                        if (!empty($userdata->military_grade)) {
                            if (!empty($userdata->military_status) || !empty($userdata->military_branch) || !empty($userdata->military_occupations)) {
                                echo " ; ", str_replace(",", " ,  ", $userdata->military_grade);
                            } else {
                                echo str_replace(",", " ,  ", $userdata->military_grade);
                            }
                        }
                    }
                    ?>

                </h5>
                <h5>

                    <?php
                    if (!empty($userdata->city) || !empty($userdata->state)) {
                        ?>
                        
                        <?php
                        if (!empty($userdata->city)) {
                            echo $userdata->city;
                        }
                        if (!empty($userdata->state)) {
                            if (!empty($userdata->city)) {
                                echo " , ", $userdata->state;
                            } else {
                                echo $userdata->state;
                            }
                        }
                    }
                    ?>                              
                </h5>

                <?php
                if (!empty($userdata->url_linkedin)) {
                    ?>
                    <a class="linked" href="<?php echo $userdata->url_linkedin; ?>">LinkedIn Profile</a>

                <?php } ?>
                    <div class="pull-right">
                    <?php
                        if(Yii::$app->db->createCommand("SELECT * FROM `module_enabled` WHERE module_id = 'mail'")->execute()) {
                        ?>
                        <a class="btn btn-info" href="/humhub/index.php/mail/mail/create?ajax=1&amp;userGuid=<?php echo $guid->guid; ?>" data-target="#globalModal">Send message</a>
                        <?php
                        } else {
                            ?>
                        <a class="btn btn-info load-popup" href="#" >Send message</a>
                        <?php
                        }
                        ?>
            </div>  
        </div>
        <div class="virtual-business-card-right">

        </div>
    </div>
</div>

<script>
    $(document).on('click','.load-popup', function() { 
        alert("Enable Mail module");
     });
     
</script>