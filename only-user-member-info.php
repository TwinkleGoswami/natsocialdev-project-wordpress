<?php
/**
 * Template Name: Only display user member info
 */
get_header();
?>

<script>
    var tab = "<?php echo $_GET['lang']; ?>";
//    alert(tab);
if(tab != "eng" && tab != "guj")
{
    tab = "eng";
}
    jQuery(document).ready(function(){
        if(tab == "eng"){
//            console.log('english');
            jQuery("#engrander" ).addClass( "active" );
            jQuery("#englishmenutab" ).addClass( "in active" );
        }
        if(tab == "guj"){
//            console.log('gujarati');
            jQuery("#gujrander" ).addClass( "active" );
            jQuery("#gujaratimenutab" ).addClass( "in active" );
        }
    });
</script>

<div class="">
    <div class="" style="position: relative">
        <img src="<?php echo get_template_directory_uri() . '/images/about-banner.jpg'; ?>" class="img-responsive respImageheading" />      
        <h4 align="right" style="position:absolute" class="cust_head custom_header">Member Information</h4>      
    </div>
</div>
<br/><br/>
<!--Display tabbing start-->

<!--user member display-->
<?php
//echo $_GET['id'];
if (isset($_GET['id'])) {
    $user_info = $_GET['id'];
//    echo $_GET['lang'];

    global $wpdb;
    $path = wp_upload_dir();
    $get_path = $path['baseurl'] . "/user/";
    
    $chk_member = $wpdb->get_results("SELECT count(*) as cnt FROM wp_users where ID = $user_info");
    //print_r($chk_member[0]->cnt);
    if ($chk_member[0]->cnt != 0){
    ?>

    <div class="">
        <div class="container">
            <ul class="nav nav-tabs">
                <li id="engrander"><a data-toggle="tab" href="#englishmenutab">English</a></li>
                <li id="gujrander"><a data-toggle="tab" href="#gujaratimenutab">Gujarati</a></li>
            </ul>
            <!-- get all subscriber(member) and display as below table -->
            <div class="tab-content">
                <!-- get user data with pagination (english) -->
                <div id="englishmenutab" class="tab-pane fade">
                    <br/>
                    <div class="person_detail">
                        <div class="row">
                            <div class="profile_user">
                                <img src="<?php
								$user_profile_image = get_user_meta($user_info, 'user_profile');
								//print_r($user_profile_image);
								$user_latest_profile_pic = max($user_profile_image);
								echo $get_path . $user_latest_profile_pic; 
								?>" class="img img-responsive" height="100px" width="100px" />
                            </div>
                            <div class="col-lg-3 col-md-3 col-sm-4 col-xs-12">
                                <div>
                                    <span class="user_label">Name : </span>
                                    <span class="user_property"><?php echo get_user_meta($user_info, 'eng_name', true); ?></span>
                                </div>
                                <div>
                                    <span class="user_label">Village : </span>
                                    <?php
                                    $termdata = get_user_meta($user_info, 'village_name', true);
                                    $village_name = get_term($termdata);
                                    $village_name = preg_replace("/[^a-zA-Z]/", "", $village_name->name);
                                    ?>
                                    <span class="user_property"><?php echo $village_name; ?></span>
                                </div>
                                <div>
                                    <span class="user_label">DOB : </span>
                                    <span class="user_property"><?php echo get_user_meta($user_info, 'dob', true); ?></span>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-3 col-sm-4 col-xs-12">
                                <div>
                                    <span class="user_label">Gender : </span>
                                    <span  class="user_property"><?php echo get_user_meta($user_info, 'gender', true); ?></span>
                                </div>
                                <div>
                                    <span class="user_label">E-mail : </span>
                                    <span class="user_property" style="text-transform: none;"><?php echo get_user_meta($user_info, 'eamil', true); ?></span>
                                </div>
                                <div>
                                    <span class="user_label">Marital status : </span>
                                    <span class="user_property"><?php echo get_user_meta($user_info, 'maritalstatus', true); ?></span>
                                </div>

                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                <div>
                                    <span class="user_label">contact : </span>
                                    <span class="user_property"><?php echo get_user_meta($user_info, 'contact_num', true); ?></span>
                                </div>
                                <div>
                                    <span class="user_label">Address : </span>
                                    <span class="user_property"><?php echo get_user_meta($user_info, 'address', true); ?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                    $all_member = $wpdb->get_results("SELECT um.* FROM wp_users as u,wp_usermeta as um where u.ID = um.user_id AND um.meta_key = 'user_member_details' AND um.user_id = $user_info");
                    if ($all_member) {

                        foreach ($all_member as $getmemberdata) {
//                            echo '<pre>';
//                            print_r(unserialize($getmemberdata->meta_value));
//                            echo '</pre>';
                            $unserial_member = unserialize($getmemberdata->meta_value);
                            ?>
                            <div class="person_detail">
                                <div class="row">
                                    <div class="profile_user">
                                        <img src="<?php echo $get_path . $unserial_member['memimgdata']; ?>" class="img img-responsive" height="100px" width="100px" />
                                    </div>
                                    <div class="col-lg-3 col-md-3 col-sm-4 col-xs-12">
                                        <div>
                                            <span class="user_label">Name : </span>
                                            <span class="user_property"><?php echo $unserial_member['memberengname']; ?></span>
                                        </div>
                                        <div>
                                            <span class="user_label">Relation : </span>
                                            <span class="user_property"><?php
                                                $relation = preg_replace("/[^a-zA-Z]/", "", $unserial_member['memberrelationtype']);
                                                echo $relation;
                                                ?></span>
                                        </div>
                                        <div>
                                            <span class="user_label">Village : </span>
                                            <?php
                                            $termdata = get_term($unserial_member['membervillage']);
                                            $village_name = preg_replace("/[^a-zA-Z]/", "", $termdata->name);
                                            ?>
                                            <span class="user_property"><?php echo $village_name; ?></span>
                                        </div>

                                    </div>
                                    <div class="col-lg-3 col-md-3 col-sm-4 col-xs-12">
                                        <div>
                                            <span class="user_label">Gender : </span>
                                            <span  class="user_property"><?php echo $unserial_member['membergender']; ?></span>
                                        </div>
                                        <div>
                                            <span class="user_label">Marital status : </span>
                                            <span class="user_property"><?php echo $unserial_member['membermaritalstatus']; ?></span>
                                        </div>
                                        <div>
                                            <span class="user_label">E-mail : </span>
                                            <span class="user_property" style="text-transform: none;"><?php echo $unserial_member['memberemail']; ?></span>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-3 col-sm-4 col-xs-12">
                                        <div>
                                            <span class="user_label">contact : </span>
                                            <span class="user_property"><?php echo $unserial_member['membercontactno']; ?></span>
                                        </div>
                                        <div>
                                            <span class="user_label">DOB : </span>
                                            <span class="user_property"><?php echo $unserial_member['memberdob']; ?></span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <?php
                        }
                    } else {
        echo '<hr/><div><center><font style="font-family:aclonica;margin:1% 0px;">Sorry no family members are available</font></center></div><br/><br/>';
    }
                    ?>
                </div>

                <div id="gujaratimenutab" class="tab-pane fade">
                    <br/>
                    <div class="person_detail">
                        <div class="row">
                            <div class="profile_user">
                                <img src="<?php
								$user_profile_image = get_user_meta($user_info, 'user_profile');
								$user_latest_profile_pic = max($user_profile_image);
								echo $get_path . $user_latest_profile_pic; 
								?>" class="img img-responsive" height="100px" width="100px" />
                            </div>
                            <div class="col-lg-3 col-md-3 col-sm-4 col-xs-12">
                                <div>
                                    <span class="user_label">Name : </span>
                                    <span class="user_property"><?php echo get_user_meta($user_info, 'gujname', true); ?></span>
                                </div>
                                <div>
                                    <span class="user_label">Village : </span>
                                    <?php
                                    $termdata = get_term(get_user_meta($user_info, 'village_name', true));
                                    $village_name = preg_replace("/[a-zA-Z]/", "", $termdata->name);
                                    $village_name = substr($village_name, 1, -1);
                                    ?>
                                    <span class="user_property"><?php echo $village_name; ?></span>
                                </div>
                                <div>
                                    <span class="user_label">DOB : </span>
                                    <span class="user_property"><?php echo get_user_meta($user_info, 'dob', true); ?></span>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-3 col-sm-4 col-xs-12">
                                <div>
                                    <span class="user_label">Gender : </span>
                                    <span  class="user_property"><?php
                                        if (get_user_meta($user_info, 'gender', true) == "male") {
                                            $gen = "પુરૂષ";
                                        } else {
                                            $gen = "સ્ત્રી";
                                        }
                                        echo $gen;
                                        ?></span>
                                </div>
                                <div>
                                    <span class="user_label">E-mail : </span>
                                    <span class="user_property" style="text-transform: none;"><?php echo get_user_meta($user_info, 'eamil', true); ?></span>
                                </div>
                                <div>
                                    <span class="user_label">Marital status : </span>
                                    <span class="user_property"><?php
                                        if (get_user_meta($user_info, 'maritalstatus', true) == "married") {
                                            $ms = "પરણીત";
                                        } else {
                                            $ms = "અપરણીત";
                                        }
                                        echo $ms;
                                        ?></span>
                                </div>

                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                <div>
                                    <span class="user_label">contact : </span>
                                    <span class="user_property"><?php echo get_user_meta($user_info, 'contact_num', true); ?></span>
                                </div>
                                <div>
                                    <span class="user_label">Address : </span>
                                    <span class="user_property"><?php echo get_user_meta($user_info, 'gujaddress', true); ?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                    $all_member = $wpdb->get_results("SELECT um.* FROM wp_users as u,wp_usermeta as um where u.ID = um.user_id AND um.meta_key = 'user_member_details' AND um.user_id = $user_info");
                    if ($all_member) {
                        $path = wp_upload_dir();
                        $get_path = $path['baseurl'] . "/user/";
                        foreach ($all_member as $getmemberdata) {
//                echo '<pre>';
//                print_r(unserialize($getmemberdata->meta_value));
//                echo '</pre>';
                            $unserial_member = unserialize($getmemberdata->meta_value);
                            ?>

                            <div class="person_detail">
                                <div class="row">
                                    <div class="profile_user">
                                        <img src="<?php echo $get_path . $unserial_member['memimgdata']; ?>" class="img img-responsive" height="100px" width="100px" />
                                    </div>
                                    <div class="col-lg-3 col-md-3 col-sm-4 col-xs-12">
                                        <div>
                                            <span class="user_label">Name : </span>
                                            <span class="user_property"><?php echo $unserial_member['membergujname']; ?></span>
                                        </div>
                                        <div>
                                            <span class="user_label">Relation : </span>
                                            <span class="user_property"><?php
                                                $relation = preg_replace("/[a-zA-Z]/", "", $unserial_member['memberrelationtype']);
                                                $relation_type = substr($relation, 2, -1);
                                                echo $relation_type;
                                                ?></span>
                                        </div>
                                        <div>
                                            <span class="user_label">Village : </span>
                                            <?php
                                            $termdata = get_term($unserial_member['membervillage']);
                                            $village_name = preg_replace("/[a-zA-Z]/", "", $termdata->name);
                                            $village_name = substr($village_name, 1, -1);
                                            ?>
                                            <span class="user_property"><?php echo $village_name; ?></span>
                                        </div>

                                    </div>
                                    <div class="col-lg-3 col-md-3 col-sm-4 col-xs-12">
                                        <div>
                                            <span class="user_label">Gender : </span>
                                            <span  class="user_property"><?php
                                                if ($unserial_member['membergender'] == "male") {
                                                    $gen = "પુરૂષ";
                                                } else {
                                                    $gen = "સ્ત્રી";
                                                }
                                                echo $gen;
                                                ?></span>
                                        </div>
                                        <div>
                                            <span class="user_label">Marital status : </span>
                                            <span class="user_property"><?php
                                                if ($unserial_member['membermaritalstatus'] == "married") {
                                                    $ms = "પરણીત";
                                                } else {
                                                    $ms = "અપરણીત";
                                                }
                                                echo $ms;
                                                ?></span>
                                        </div>
                                        <div>
                                            <span class="user_label">E-mail : </span>
                                            <span class="user_property" style="text-transform: none;"><?php echo $unserial_member['memberemail']; ?></span>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-3 col-sm-4 col-xs-12">
                                        <div>
                                            <span class="user_label">contact : </span>
                                            <span class="user_property"><?php echo $unserial_member['membercontactno']; ?></span>
                                        </div>
                                        <div>
                                            <span class="user_label">DOB : </span>
                                            <span class="user_property"><?php echo $unserial_member['memberdob']; ?></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php
                        }
                        ?>
                    </div>

                </div>

            </div>
        </div>
        <br/><br/>
        <!--Display tabbing send-->
        <?php
    } else {
        echo '<hr/><div><center><font style="font-family:aclonica;margin:1% 0px;">Sorry no family members are available</font></center></div><br/><br/>';
    }
    }  else {
        echo '<center><img src="' . get_bloginfo('template_directory') . '/images/404.gif" class="custom_404"/></center>';
    }
} else {
    echo '<center><img src="' . get_bloginfo('template_directory') . '/images/404.gif" class="custom_404"/></center>';
}
?>
</div>
</div>

<?php
get_footer();
?>