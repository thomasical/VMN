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
            <ul class="nav nav-tabs virtual-business-tab">
                <li><a href="<?php echo Yii::$app->request->baseUrl . '/index.php/member_directory/member-directory' ?>"><strong>Mentor view</strong></a></li>
                <li class="active"><a href="<?php echo Yii::$app->request->baseUrl . '/index.php/member_directory/member-directory/mentee' ?>"><strong>Mentee view</strong></a></li>
                <a href="#" class="member"><strong>Member Search (Coming Soon)</strong></a>                        
            </ul>
            <div class="tab-content">
                <div id="<?php echo Yii::$app->request->baseUrl . '/index.php/member_directory/member-directory/mentee' ?>" class="tab-pane active">
                    <div class="virtual-business-card-outer active">
                        <div class="user-info">
                            <?php
                            $guid = \humhub\modules\user\models\User::find()->select(['guid'])->where(['id' => $userdata->user_id])->one();
                            ?>
                            <a href="<?php echo Yii::$app->request->baseUrl . '/index.php/member_directory/member-directory/profile?id=' . $userdata->user_id ?>">
                                <img src="<?php echo Yii::$app->request->baseUrl; ?>/uploads/profile_image/<?php echo $guid->guid; ?>.jpg" onerror="this.src='<?php echo Yii::$app->request->baseUrl; ?>/img/default_user.jpg'" alt="user">  
                            </a>
                            <div class="but-group">
                                <a href="<?php echo Yii::$app->request->baseUrl . '/index.php/member_directory/member-directory/profile?id=' . $userdata->user_id ?>" class="view-profile"> View Profile</a>
                                <a href="#"><i class="fa fa-star" aria-hidden="true"></i></a>
                            </div>
                        </div>
                        <a href="<?php echo Yii::$app->request->baseUrl . '/index.php/member_directory/member-directory/profile?id=' . $userdata->user_id ?>" class="a-tag">
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
                        </a>
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
                                echo str_replace(",", ",  ", $userdata->current_occupation);
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
                                if (!empty($userdata->military_grade) || !empty($userdata->military_branch) || !empty($userdata->military_occupations)) {
                                    if (!empty($userdata->military_status)) {
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
                    </div>  
                    <?php
                    foreach ($modelvalues as $model) {
                        $userdatacity = '';
                        $userdatastate = '';
                        $userdatamilitary_status = '';
                        $userdatamilitary_branch = '';
                        $userdatamilitary_occupations = '';
                        $userdatamilitary_grade = '';
                        $guid = \humhub\modules\user\models\User::find()->select(['guid'])->where(['id' => $model->user_id])->one();
                        ?>
                        <div class="virtual-business-card-outer active">
                            <!--<div class="virtual-business-card-outer virtual-business-card-effect"> -->
                            <div class="user-info">
                                <a href="<?php echo Yii::$app->request->baseUrl . '/index.php/member_directory/member-directory/profile?id=' . $model->user_id ?>">
                                    <img src="<?php echo Yii::$app->request->baseUrl; ?>/uploads/profile_image/<?php echo $guid->guid; ?>.jpg" onerror="this.src='<?php echo Yii::$app->request->baseUrl; ?>/img/default_user.jpg'" alt="user">   
                                </a>
                                <div class="but-group">
                                    <a href="<?php echo Yii::$app->request->baseUrl . '/index.php/member_directory/member-directory/profile?id=' . $model->user_id ?>" class="view-profile"> View Profile</a>
                                    <a href="#"><i class="fa fa-star" aria-hidden="true"></i></a>
                                </div>
                            </div>

                            <a href="<?php echo Yii::$app->request->baseUrl . '/index.php/member_directory/member-directory/profile?id=' . $model->user_id ?>" class="a-tag">
                                <h4>
                                    <strong>
                                        <?php
                                        echo $model->firstname, " ", $model->lastname;
                                        if (!empty($model->positions)) {
                                            echo " , ", $model->positions;
                                        }
                                        if (!empty($model->company)) {
                                            echo " @ ", $model->company;
                                        }
                                        ?>
                                    </strong>
                                </h4>
                            </a>                           
                           <?php
                            if (!empty($model->industry)) {
                                ?>
                                <h5><span><strong>Industry: </strong></span><?php echo $model->industry ?></h5>
                                <?php
                            }
                            ?>
                            <?php
                            if (!empty($model->current_occupation)) {
                                ?>
                                <h5><span><strong>Current Occupation: </strong></span>
                                    <?php
                                    echo str_replace(",", " ,  ", $model->current_occupation);
                                    ?>
                                </h5>
                                <?php
                            }
                            ?>
                            <?php
                            if (!empty($model->professional_expertise)) {
                                ?>
                                <h5><span><strong>Professional Expertise: </strong></span>
                                    <?php
                                    echo str_replace(",", " ,  ", $model->professional_expertise);
                                    ?>
                                </h5>
                                <?php
                            }
                            ?>

                            <?php
                            if (!empty($model->certifications)) {
                                ?>
                                <h5><span><strong>Certifications: </strong></span>
                                    <?php
                                    echo str_replace(",", " ,  ", $model->certifications);
                                    ?>
                                </h5>
                                <?php
                            }
                            ?>

                            <?php
                            if (!empty($model->mentoring_specialties)) {
                                ?>
                                <h5><span><strong>Mentoring Specialties: </strong></span>
                                    <?php
                                    echo str_replace(",", " ,  ", $model->mentoring_specialties);
                                    ?>
                                </h5>
                                <?php
                            }
                            ?>



                            <h5>

                                <?php
                                if (!empty($model->military_status) || !empty($model->military_branch) || !empty($model->military_occupations) || !empty($model->military_grade)) {
                                    ?>
                                    <span><strong>Military Status: </strong></span>
                                    <?php
                                    if (!empty($model->military_status)) {
                                        echo str_replace(",", " ,  ", $model->military_status);
                                    }
                                    if (!empty($model->military_branch)) {
                                        if (!empty($model->military_status)) {
                                            echo " ; ", str_replace(",", " ,  ", $model->military_branch);
                                        } else {
                                            echo str_replace(",", " ,  ", $model->military_branch);
                                        }
                                    }
                                    if (!empty($model->military_occupations)) {
                                        if (!empty($model->military_status) || !empty($model->military_branch)) {
                                            echo " ; ", str_replace(",", " ,  ", $model->military_occupations);
                                        } else {
                                            echo str_replace(",", ",  ", $model->military_occupations);
                                        }
                                    }
                                    if (!empty($model->military_grade)) {
                                        if (!empty($model->military_status) || !empty($model->military_branch) || !empty($model->military_occupations)) {
                                            echo " ; ", str_replace(",", " ,  ", $model->military_grade);
                                        } else {
                                            echo str_replace(",", " ,  ", $model->military_grade);
                                        }
                                    }
                                }
                                ?>

                            </h5>
                            <h5>
                                
                                <?php
                                if (!empty($model->state) || !empty($model->city)) {
                                    ?>
                                    
                                    <?php
                                    if (!empty($model->city)) {
                                        echo $model->city;
                                    }
                                    if (!empty($model->state)) {
                                        if (!empty($model->city)) {
                                            echo " , ", $model->state;
                                        } else {
                                            echo $model->state;
                                        }
                                    }
                                }
                                ?>                              
                            </h5>


                            <!-- </div> -->
                        </div>
                        <?php
                    }
                    echo \yii\widgets\LinkPager::widget(['pagination' => $pages,]);
                    ?>
                </div> 
            </div>
        </div>
        <div class="virtual-business-card-right">

        </div>
    </div>
</div>