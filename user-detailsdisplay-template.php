<?php
/**
 * Template Name: User detail display
 */
get_header();

global $current_user;

if (isset($_POST['upsumbit'])) {
    //echo get_site_url()."/user-profile/";
    if (isset($_POST['userprofile']) && $_POST['userprofile'] != "") {
//        echo '*******************';
//        echo $_POST['userprofile'];
        $get_path = WP_get_custom_image_upload_path('user');
        $img = $_POST['imgdata'];
        $img = str_replace('data:image/png;base64,', '', $img);
        $img = str_replace(' ', '+', $img);
        $data = base64_decode($img);
        $file = USER . uniqid() . '.png';
        $fh = fopen($get_path . $file, 'w');
        fwrite($fh, $data);
        fclose($fh);
        $user_infoo = get_currentuserinfo();
        add_user_meta($user_infoo->ID, 'user_profile', $file);  //update user profile
    }

    if (empty($_POST['upengname']) || !preg_match("/^[a-zA-Z ]*$/", $_POST['upengname'])) {
        $engnameerror = 1;
    }
    if (empty($_POST['upgujname'])) {
        $gujnameerror = 1;
    }
    if (empty($_POST['upcontactnum']) || !preg_match("/^(?:(?:\+|0{0,2})91(\s*[\ -]\s*)?|[0]?)?[789]\d{9}|(\d[ -]?){10}\d$/", $_POST['upcontactnum'])) {
        $contactnoerror = 1;
    }
    if (empty($_POST['updob'])) {
        $doberror = 1;
    }
    if (empty($_POST['upemail']) || !preg_match("/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/", $_POST['upemail'])) {
        $emailerror = 1;
    }
    if (empty($_POST['upengadd'])) {
        $addresserror = 1;
    }
    if (empty($_POST['upgujadd'])) {
        $gujaddresserror = 1;
    }
    if (empty($_POST['upvillage'])) {
        $villageerror = 1;
    }
    if (empty($_POST['upgen'])) {
        $gendererror = 1;
    }
    if (empty($_POST['upmastatus'])) {
        $maritalstatuserror = 1;
    }

    if ((isset($engnameerror) && $engnameerror == 1) || (isset($gujnameerror) && $gujnameerror == 1) || (isset($contactnoerror) && $contactnoerror == 1) || (isset($doberror) && $doberror == 1) || (isset($emailerror) && $emailerror == 1) || (isset($addresserror) && $addresserror == 1) || (isset($gujaddresserror) && $gujaddresserror == 1) || (isset($villageerror) && $villageerror == 1) || (isset($gendererror) && $gendererror == 1) || (isset($maritalstatuserror) && $maritalstatuserror == 1)) {
        ?>
        <div class="alert alert-danger alert-dismissable">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
            <strong><?php echo "All field are mandatory"; ?>..!</strong>
        </div>
        <?php
    } else {
        $userinfo = get_currentuserinfo();
        update_user_meta($userinfo->ID, 'eng_name', $_POST['upengname']);
        update_user_meta($userinfo->ID, 'gujname', $_POST['upgujname']);
        update_user_meta($userinfo->ID, 'contact_num', $_POST['upcontactnum']);
        update_user_meta($userinfo->ID, 'dob', $_POST['updob']);
		wp_update_user( array( 'ID' => $userinfo->ID, 'user_email' => $_POST['upemail']) );
        //update_user_meta($userinfo->ID, 'eamil', $_POST['upemail']);
        update_user_meta($userinfo->ID, 'address', $_POST['upengadd']);
        update_user_meta($userinfo->ID, 'gujaddress', $_POST['upgujadd']);
        update_user_meta($userinfo->ID, 'village_name', $_POST['upvillage']);
        update_user_meta($userinfo->ID, 'gender', $_POST['upgen']);
        update_user_meta($userinfo->ID, 'maritalstatus', $_POST['upmastatus']);
        ?>
        <div class="alert alert-success alert-dismissable">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
            <strong>Your profile update Successful...!</strong>
        </div>
        <?php
    }
}

$user_info = get_currentuserinfo();
//print_r($user_info);

$user_profile_image = get_user_meta($user_info->ID, 'user_profile');
//print_r($user_profile_image);
$user_latest_profile_pic = max($user_profile_image);
//echo '<pre>';
//print_r($user_latest_profile_pic);
//echo '</pre>';
?>
<!-- user profile page design -->
<div class="">
    <div class="" style="position: relative">
        <img src="<?php echo get_template_directory_uri() . '/images/about-banner.jpg'; ?>" class="img-responsive respImageheading" />      
        <h4 align="right" style="position:absolute" class="cust_head custom_header">Your Profile</h4>      
    </div>
</div>
<form method="post" >
    <div class="user_detail_container">
        <?php
        $path = wp_upload_dir();
        $get_path = $path['baseurl'] . "/user/" . $user_latest_profile_pic;
        ?>
        <div class="user_detail_img">
            <div class="form-group">
                <div class="container">
                    <div class="views_container profile_container">
                        <?php
                        if ($user_latest_profile_pic == "") {
                            ?>
                            <img id="views1" title="Click to change" src="<?php echo get_template_directory_uri() . '/images/blank_user.png'; ?>" width="100px">
                            <?php
                        } else {
                            ?>
                            <img id="views1" class="" title="User Profile" src="<?php echo $get_path; ?>" />
                            <?php
                        }
                        ?>
                        <span class="glyphicon glyphicon-edit" id="edit-span" data-toggle="modal" data-target="#myModal" ></span>
                    </div>
                    <!-- Modal -->
                    <div class="modal fade" id="myModal" role="dialog">
                        <div class="modal-dialog">

                            <!-- Modal content-->
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    <h5>Choose image</h5>
                                </div>
                                <div class="modal-body">
                                    <p>

                                    <div id="views"></div>
                                    <br>
                                    <input id="file" type="file" name="userprofile" />

                                    </p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-primary" id="cropbutton" type="button" class="ClassNameOfShouldBeHiddenElements">Crop</button>
                                    <button type="button" class="btn btn-primary" id="rotatebutton" type="button">Rotate</button>
                                    <button type="button" class="btn btn-primary" id="hflipbutton" type="button">H-flip</button>
                                    <button type="button" class="btn btn-primary" id="vflipbutton" type="button">V-flip</button> 
                                    <button type="button" class="btn btn-success" id="getdata" type="button" data-dismiss="modal">OK</button> 
                                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                </div>
                            </div>

                        </div>
                    </div>
                    <input type="hidden" id="viewsimg" name="imgdata" />
                </div>
                <div><?php
                    if (isset($fileuploaderror) && $fileuploaderror == 1) {
                        echo "<span style='color:red;font-size:14px;'>Please choose file</span>";
                    }
                    ?></div>
            </div>
        </div>

        <div class="container detail_user">
            <div class="user_content">
                <div class="row">
                    <div class="col-xs-12">
                        <p class="user_name"><?php echo get_user_meta($user_info->ID, 'eng_name', true); ?></p>
                    </div>
                </div>
            </div>
            <div class="row main_member_section">
                <div class="col-xs-12 col-xs-offset-0 col-sm-12 col-sm-offset-0 col-md-8 col-md-offset-2">
                    <div class="detail_form_section">
                        <div class="row">
                            <div class="col-xs-12">
                                <h3 class="user_detail">Your Details</h3>
                            </div>                
                        </div>

                        <div class="row form-group">
                            <div class="col-xs-12 col-sm-4 col-md-4 col-lg-3">
                                <label>Name(English) :</label>
                            </div>
                            <div class="col-xs-12 col-sm-8 col-md-8 col-lg-9">
                                <span class="usercommonfont"><input type="text" name="upengname" value="<?php echo get_user_meta($user_info->ID, 'eng_name', true); ?>" class="form-control" /></span>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-xs-12 col-sm-4 col-md-4 col-lg-3">
                                <label>Name(Gujarati) :</label>
                            </div>
                            <div class="col-xs-12 col-sm-8 col-md-8 col-lg-9">
                                <div style="position:relative">
                                    <span class="usercommonfont"><input type="text" name="upgujname" value="<?php echo get_user_meta($user_info->ID, 'gujname', true); ?>" onkeypress="return IsAlphaNumeric(event);" ondrop="return false;" class="keyboardInput form-control custom-input" /></span>
                                </div>
                                <div><center><span id="error" style="color: Red;font-size:14px;display: none;">Only use Virtual keyboard </span></center></div>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-xs-12 col-sm-4 col-md-4 col-lg-3">
                                <label>Contact Number :</label>
                            </div>
                            <div class="col-xs-12 col-sm-8 col-md-8 col-lg-9">
                                <span class="usercommonfont"><input type="text" name="upcontactnum" value="<?php echo get_user_meta($user_info->ID, 'contact_num', true); ?>" class="form-control" /></span>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-xs-12 col-sm-4 col-md-4 col-lg-3">
                                <label>DOB :</label>
                            </div>
                            <div class="col-xs-12 col-sm-8 col-md-8 col-lg-9">
                                <span class="usercommonfont"><input name="updob" placeholder="mm-dd-yyyy" class="form-control" type="Date" value="<?php echo get_user_meta($user_info->ID, 'dob', true); ?>" /></span>
                            </div>
                        </div>
                        <input type="hidden" name="upemail" value="<?php echo get_user_meta($user_info->ID, 'eamil', true); ?>" class="form-control" />
                        <div class="row form-group">
                            <div class="col-xs-12 col-sm-4 col-md-4 col-lg-3">
                                <label>Address(Eng.) :</label>
                            </div>
                            <div class="col-xs-12 col-sm-8 col-md-8 col-lg-9">
                                <span class="usercommonfont"><textarea class="form-control" name="upengadd" value="<?php echo get_user_meta($user_info->ID, 'address', true); ?>"><?php echo get_user_meta($user_info->ID, 'address', true); ?></textarea></span>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-xs-12 col-sm-4 col-md-4 col-lg-3">
                                <label>Address(Guj.) :</label>
                            </div>
                            <div class="col-xs-12 col-sm-8 col-md-8 col-lg-9">
                                <div style="position:relative">
                                    <span class="usercommonfont"><textarea onkeypress="return IsAlphaNumeric2(event);" ondrop="return false;" class="keyboardInput form-control custom-input" name="upgujadd" value="<?php echo get_user_meta($user_info->ID, 'gujaddress', true); ?>"><?php echo get_user_meta($user_info->ID, 'gujaddress', true); ?></textarea></span>
                                </div>
                                <div><center><span id="error1" style="color: Red;font-size:14px;display: none;">Only use Virtual keyboard </span></center></div>
                            </div>
                        </div>

                        <div class="row form-group">
                            <div class="col-xs-12 col-sm-4 col-md-4 col-lg-3">
                                <label>village :</label>
                            </div>
                            <div class="col-xs-12 col-sm-8 col-md-8 col-lg-9">
                                <select name="upvillage" class="form-control usercommonfont">
                                    <option value="" >Select village</option>
                                    <?php
                                    $category = get_terms(array('taxonomy' => 'village', 'hide_empty' => false));
                                    foreach ($category as $value) {
                                        ?>    
                                        <option <?php
                                        if (get_user_meta($user_info->ID, 'village_name', true) == $value->term_id) {
                                            echo'selected="selected"';
                                        }
                                        ?> value="<?php echo $value->term_id; ?>"><?php echo $value->name; ?></option>
                                            <?php
                                        }
                                        ?>
                                </select>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-xs-12 col-sm-4 col-md-4 col-lg-3">
                                <label>Gender :</label>
                            </div>
                            <div class="col-xs-12 col-sm-8 col-md-8 col-lg-9">
                                <select name="upgen" class="form-control usercommonfont">
                                    <option value="">Select gender</option>
                                    <option <?php
                                    if (get_user_meta($user_info->ID, 'gender', true) == "male") {
                                        echo'selected="selected"';
                                    }
                                    ?> value="male" >Male(પુરુષ)</option>
                                    <option <?php
                                    if (get_user_meta($user_info->ID, 'gender', true) == "female") {
                                        echo'selected="selected"';
                                    }
                                    ?>  value="female" >Female(સ્ત્રી)</option>
                                </select>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-xs-12 col-sm-4 col-md-4 col-lg-3">
                                <label>Marital Status :</label>
                            </div>
                            <div class="col-xs-12 col-sm-8 col-md-8 col-lg-9">
                                <select name="upmastatus" class="form-control usercommonfont">
                                    <option value="">Select marital status</option>
                                    <option <?php
                                    if (get_user_meta($user_info->ID, 'maritalstatus', true) == "married") {
                                        echo'selected="selected"';
                                    }
                                    ?> value="married">Married(પરણિત)</option>
                                    <option <?php
                                    if (get_user_meta($user_info->ID, 'maritalstatus', true) == "unmarried") {
                                        echo'selected="selected"';
                                    }
                                    ?> value="unmarried">Unmarried(અપરણિત)</option>
                                </select>
                            </div>
                        </div>
                        <?php
                        if (get_user_meta($user_info->ID, 'designation', true) != "") {
                            ?>
                            <div class="row form-group">
                                <div class="col-xs-12 col-sm-4 col-md-4 col-lg-3">
                                    <label>Designation :</label>
                                </div>
                                <div class="col-xs-12 col-sm-8 col-md-8 col-lg-9">
                                    <span class="usercommonfont"><input type="text" readonly="" value="<?php echo get_user_meta($user_info->ID, 'designation', true); ?>" class="form-control" /></span>
                                </div>
                            </div>  
                            <?php
                        }
                        if (get_user_meta($user_info->ID, 'fromyear', true) != "") {
                            ?>
                            <div class="row form-group">
                                <div class="col-xs-12 col-sm-4 col-md-4 col-lg-3">
                                    <label>From year :</label>
                                </div>
                                <div class="col-xs-12 col-sm-8 col-md-8 col-lg-9">
                                    <span class="usercommonfont"><input type="text" readonly="" value="<?php echo get_user_meta($user_info->ID, 'fromyear', true); ?>" class="form-control" /></span>
                                </div>
                            </div>                                                   
                            <?php
                        }
                        if (get_user_meta($user_info->ID, 'toyear', true) != "") {
                            ?>
                            <div class="row form-group">
                                <div class="col-xs-12 col-sm-4 col-md-4 col-lg-3">
                                    <label>To year :</label>
                                </div>
                                <div class="col-xs-12 col-sm-8 col-md-8 col-lg-9">
                                    <span class="usercommonfont"><input type="text" readonly="" value="<?php echo get_user_meta($user_info->ID, 'toyear', true); ?>" class="form-control" /></span>
                                </div>
                            </div> 
                            <?php
                        }
                        ?>
                    </div> 

                    <div>
                        <span class="usercommonfont"><button type="button" class="btn btn-primary update" id="secondModalDilogCancle" data-toggle="modal" data-target="#myModal1"><i class="fa fa-plus"></i> Add Member</button><button type="submit" name="upsumbit" value="Update" class="form-control btn btn-info update" ><i class="fa fa-pencil"></i> Update Profile</button></span>
                    </div>
                    </form>
                    <br/>
                    <div class="container">
                        <!-- Trigger the modal with a button -->

                        <!--Add new member Modal -->
                        <div class="modal fade" id="myModal1" role="dialog">
                            <div class="modal-dialog">

                                <!-- Modal content-->
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        <h5 class="modal-title">Member Entry</h5>
                                    </div>
                                    <div class="modal-body">
                                        <p>
                                        <form method="post" action="" name="memberform" id="memberform">
                                            <div class="row form-group">
                                                <div class="col-md-6 col-sm-12 col-xs-12">
                                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 form-group">
                                                        <label>Name(English) :</label>
                                                        <span class="usercommonfont"><input type="text" name="memberengname" id="memberengname" value="" class="form-control" placeholder="Enter name(Eng.)" /></span>
                                                        <span id="engnameerror" style="color: Red;font-size:14px;display: none;">Name is required</span>
                                                    </div>

                                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 form-group">
                                                        <label>Relation type :</label>
                                                        <select name="memberrelationtype" id="memberrelationtype" class="form-control usercommonfont">
                                                            <option value="">- Select Relationship Type -</option>
                                                            <option value="Father (પિતા)">Father (પિતા)</option>
                                                            <option value="Mother (માતા)">Mother (માતા)</option>
                                                            <option value="Husband (પતિ)">Husband (પતિ)</option>
                                                            <option value="Wife (પત્ની)">Wife (પત્ની)</option>
                                                            <option value="Son (પુત્ર)">Son (પુત્ર)</option>
                                                            <option value="Daughter (પુત્રી)">Daughter (પુત્રી)</option>
                                                            <option value="Brother (ભાઈ)">Brother (ભાઈ)</option>
                                                            <option value="Sister (બહેન)">Sister (બહેન)</option>
                                                            <option value="Uncle (કાકા)">Uncle (કાકા)</option>
                                                            <option value="Aunt (કાકી)">Aunt (કાકી)</option>
                                                            <option value="Cousin Brother (પિતરાઈ ભાઈ)">Cousin Brother (પિતરાઈ ભાઈ)</option>
                                                            <option value="Cousin Sister (પિતરાઈ બહેન)">Cousin Sister (પિતરાઈ બહેન)</option>
                                                            <option value="Nephew (ભત્રીજો)">Nephew (ભત્રીજો)</option>
                                                            <option value="Niece (ભત્રીજી)">Niece (ભત્રીજી)</option>
                                                            <option value="Daughter in Law (પુત્રવધૂ)">Daughter in Law (પુત્રવધૂ)</option>
                                                            <option value="Grandson (પૌત્ર)">Grandson (પૌત્ર)</option>
                                                            <option value="Granddaughter (પૌત્રી)">Granddaughter (પૌત્રી)</option>
                                                            <option value="Brother's Wife (ભાભી)">Brother's Wife (ભાભી)</option>
                                                            <option value="Nephew's Wife  (પિતરાઈ વધૂ)">Nephew's Wife  (પિતરાઈ વધૂ)</option>
                                                        </select>   
                                                        <span id="memberrelationtypeerror" style="color: Red;font-size:14px;display: none;">Choose Relation type</span>
                                                    </div>
                                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 form-group">
                                                        <label>Village :</label>
                                                        <select name="membervillage" id="membervillage" class="form-control">
                                                            <option value="" >--Select village--</option>
                                                            <?php
                                                            $category = get_terms(array('taxonomy' => 'village', 'hide_empty' => false));
                                                            foreach ($category as $value) {
                                                                ?>    
                                                                <option <?php
                                                                if (isset($_POST['membervillage']) && $_POST['membervillage'] == $value->term_id) {
                                                                    echo'selected="selected"';
                                                                }
                                                                ?> value="<?php echo $value->term_id; ?>"><?php echo $value->name; ?></option>
                                                                    <?php
                                                                }
                                                                ?>
                                                        </select>
                                                        <span id="membervillageerror" style="color: Red;font-size:14px;display: none;">Choose village</span>
                                                    </div>
                                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 form-group">
                                                        <label>Gender :</label>
                                                        <select name="membergender" id="membergender" class="form-control ">
                                                            <option value="">--Select gender--</option>
                                                            <option <?php
                                                            if (isset($_POST['membergender']) && $_POST['membergender'] == "male") {
                                                                echo'selected="selected"';
                                                            }
                                                            ?> value="male" >Male(પુરુષ)</option>
                                                            <option <?php
                                                            if (isset($_POST['membergender']) && $_POST['membergender'] == "female") {
                                                                echo'selected="selected"';
                                                            }
                                                            ?>  value="female" >Female(સ્ત્રી)</option>
                                                        </select>
                                                        <span id="membergendererror" style="color: Red;font-size:14px;display: none;">Choose gender</span>
                                                    </div>
                                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 form-group">
                                                        <label>Maritial Status :</label>
                                                        <select name="membermaritalstatus" id="membermaritalstatus" class="form-control">
                                                            <option value="">Select marital status</option>
                                                            <option <?php
                                                            if (isset($_POST['membermaritalstatus']) && $_POST['membermaritalstatus'] == "married") {
                                                                echo'selected="selected"';
                                                            }
                                                            ?> value="married">Married(પરણિત)</option>
                                                            <option <?php
                                                            if (isset($_POST['membermaritalstatus']) && $_POST['membermaritalstatus'] == "unmarried") {
                                                                echo'selected="selected"';
                                                            }
                                                            ?> value="unmarried">Unmarried(અપરણિત)</option>
                                                        </select>
                                                        <span id="membermaritalstatuserror" style="color: Red;font-size:14px;display: none;">Choose Marital status</span>
                                                    </div>
                                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 form-group">
                                                        <label>Contact No. :</label>  
                                                        <input name="membercontactno" id="membercontactno" onkeypress="phoneno()" maxlength="14" placeholder="+91-9377599404" class="form-control" type="text" value="" />
                                                        <span id="membercontactnoerror" style="color: Red;font-size:14px;display: none;">Contact no. is required(+91-8978457889)</span>
                                                    </div>
                                                </div>

                                                <div class="col-md-6 col-sm-12 col-xs-12">
                                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 form-group">
                                                        <label>Name(Gujarati) :</label>
                                                        <div style="position:relative;" class="custom_keyboard">
                                                            <input type="text" name="membergujname" id="membergujname" value="" onkeypress="return IsAlphaNumeric3(event);" ondrop="return false;" class="keyboardInput form-control custom-keyboard" placeholder="Enter Name(Guj.)" />
                                                            <span id="membergujnameerror" style="color: Red;font-size:14px;display: none;">Name is required(in Gujarati)</span>
                                                            <span id="error3" style="color: Red;font-size:14px;display: none;">Only use Virtual keyboard </span>
                                                        </div>
                                                    </div>
                                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 form-group">
                                                        <label>Date of Birth :</label>
                                                        <input  name="memberdob" id="memberdob" placeholder="mm-dd-yyyy" class="form-control" type="Date" value="" />
                                                        <span id="memberdoberror" style="color: Red;font-size:14px;display: none;">DOB is required</span>
                                                    </div>
                                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 form-group">
                                                        <label>Email :</label>
                                                        <input type="email" name="memberemail" id="memberemail" placeholder="Enter E-Mail Address" class="form-control" value="" title="Enter proper email address" required="" />
                                                        <span id="memberemailerror" style="color: Red;font-size:14px;display: none;">E-mail is required</span>
                                                    </div>
                                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 form-group">
                                                        <label>Profile :</label>
                                                        <div class="form-group">
                                                            <!--File upload in modal with in modalm start-->

                                                            <div class="inputGroupContainer">
                                                                <div class="container">
                                                                    <div class="views_container">
                                                                        <img id="viewsImgg" title="Click to change" data-toggle="modal" data-toggle="modal" data-target="#memberimageModal" src="<?php echo get_template_directory_uri() . '/images/user.png'; ?>" width="100px">
                                                                        <!--<span class="glyphicon glyphicon-remove close-spann"  id="close-span1"></span>-->
                                                                    </div>
                                                                    <!-- Modal -->
                                                                    <div class="modal fade" id="memberimageModal" role="dialog">
                                                                        <div class="modal-dialog">

                                                                            <!-- Modal content-->
                                                                            <div class="modal-content">
                                                                                <div class="modal-header">
                                                                                    <!--<button type="button" class="close" id="memberdialodclose">&times;</button>-->
                                                                                    <h5>Choose image</h5>
                                                                                </div>
                                                                                <div class="modal-body">
                                                                                    <p>

                                                                                    <div id="viewss"></div>
                                                                                    <br>
                                                                                    <input id="memfile" type="file" />

                                                                                    </p>
                                                                                </div>
                                                                                <div class="modal-footer">
                                                                                    <button type="button" class="btn btn-primary" id="membercropbutton" type="button" class="ClassNameOfShouldBeHiddenElements">Crop</button>
                                                                                    <button type="button" class="btn btn-primary" id="memberrotatebutton" type="button">Rotate</button>
                                                                                    <button type="button" class="btn btn-primary" id="memberhflipbutton" type="button">H-flip</button>
                                                                                    <button type="button" class="btn btn-primary" id="membervflipbutton" type="button">V-flip</button> 
                                                                                    <button type="button" class="btn btn-success" id="memgetdata" type="button">OK</button> 
                                                                                    <button type="button" class="btn btn-danger" id="membermodelclose">Close</button>
                                                                                </div>
                                                                            </div>

                                                                        </div>
                                                                    </div>
                                                                    <input type="hidden" id="memviewsimg" name="memimgdata" />
                                                                </div>
                                                                <!--                                                                <div><?php
                                                                if (isset($fileuploaderror) && $fileuploaderror == 1) {
                                                                    echo "<span style='color:red;font-size:14px;'>Please choose file</span>";
                                                                }
                                                                ?></div>-->
                                                            </div>
                                                            <!--File upload in modal with in modal start-->
                                                        </div>
                                                    </div>

                                                </div>

                                                </p>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-success" id="addMember">Add</button>
                                                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                            </div>
                                    </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <!--user member display-->
            <?php
            $user_info = get_currentuserinfo();

            global $wpdb;
            $all_member = $wpdb->get_results("SELECT um.* FROM wp_users as u,wp_usermeta as um where u.ID = um.user_id AND um.meta_key = 'user_member_details' AND um.user_id = $user_info->ID");
//            echo '<pre>';
//            print_r(unserialize($all_member[0]->meta_value));
//            echo '</pre>';

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
                                <span class="user_label">Name(Eng.) : </span>
                                <span class="user_property"><?php echo $unserial_member['memberengname']; ?></span>
                            </div>
                            <div>
                                <span class="user_label">Relation : </span>
                                <span class="user_property"><?php echo $unserial_member['memberrelationtype']; ?></span>
                            </div>
                            <div>
                                <span class="user_label">Village : </span>
                                <?php $termdata = get_term($unserial_member['membervillage']); ?>
                                <span class="user_property"><?php echo $termdata->name; ?></span>
                            </div>

                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-4 col-xs-12">
                            <div>
                                <span class="user_label">Gender : </span>
                                <span  class="user_property"><?php echo $unserial_member['membergender']; ?></span>
                            </div>
                            <div>
                                <span class="user_label">E-mail : </span>
                                <span class="user_property" style="text-transform: none;"><?php echo $unserial_member['memberemail']; ?></span>
                            </div>
                            <div>
                                <span class="user_label">Marital status : </span>
                                <span class="user_property"><?php echo $unserial_member['membermaritalstatus']; ?></span>
                            </div>

                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-4 col-xs-12">
                            <div>
                                <span class="user_label">contact : </span>
                                <span class="user_property"><?php echo $unserial_member['membercontactno']; ?></span>
                            </div>
                            <div>
                                <span class="user_label">Name(Guj.) : </span>
                                <span class="user_property"><?php echo $unserial_member['membergujname']; ?></span>
                            </div>
                            <div>
                                <span class="user_label">DOB : </span>
                                <span class="user_property"><?php echo $unserial_member['memberdob']; ?></span>
                            </div>
                        </div>

                        <span class="glyphicon glyphicon-pencil pencil_icon edit_icon" style="cursor:pointer;" onclick='displayMemberInfo(<?php echo $getmemberdata->user_id; ?>,<?php echo $getmemberdata->umeta_id; ?>)' data-toggle="modal" data-target="#fmemberModal" ></span>
                        <span class="glyphicon glyphicon-remove remove_icon edit_icon" style="cursor:pointer;" onclick='DeleteMemberInfo(<?php echo $getmemberdata->user_id; ?>,<?php echo $getmemberdata->umeta_id; ?>)'></span>
                    </div>
                </div>
                <?php
            }
            ?>
        </div>
    </div>

    <!--Update family member**********-->

    <div class="modal fade" id="fmemberModal" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h5 class="modal-title">Update Member Details</h5>
                </div>
                <div class="modal-body">
                    <p>
                    <form method="post" action="" name="updatefamilymemberform" id="updatefamilymemberform">
                        <div class="row form-group">
                            <div class="col-md-6 col-sm-12 col-xs-12">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 form-group">
                                    <label>Name(English) :</label>
                                    <span class="usercommonfont">
                                        <!--<input type="hidden" name="fmemberengid" id="fmemberengid" value="" />-->
                                        <input type="text" name="fmemberengname" id="fmemberengname" value="" class="form-control" placeholder="Enter name(Eng.)" /></span>
                                    <span id="fengnameerror" style="color: Red;font-size:14px;display: none;">Name is required</span>
                                </div>

                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 form-group">
                                    <label>Relation type :</label>
                                    <select name="fmemberrelationtype" id="fmemberrelationtype" class="form-control usercommonfont">
                                        <option value="">- Select Relationship Type -</option>
                                        <option value="Father (પિતા)">Father (પિતા)</option>
                                        <option value="Mother (માતા)">Mother (માતા)</option>
                                        <option value="Husband (પતિ)">Husband (પતિ)</option>
                                        <option value="Wife (પત્ની)">Wife (પત્ની)</option>
                                        <option value="Son (પુત્ર)">Son (પુત્ર)</option>
                                        <option value="Daughter (પુત્રી)">Daughter (પુત્રી)</option>
                                        <option value="Brother (ભાઈ)">Brother (ભાઈ)</option>
                                        <option value="Sister (બહેન)">Sister (બહેન)</option>
                                        <option value="Uncle (કાકા)">Uncle (કાકા)</option>
                                        <option value="Aunt (કાકી)">Aunt (કાકી)</option>
                                        <option value="Cousin Brother (પિતરાઈ ભાઈ)">Cousin Brother (પિતરાઈ ભાઈ)</option>
                                        <option value="Cousin Sister (પિતરાઈ બહેન)">Cousin Sister (પિતરાઈ બહેન)</option>
                                        <option value="Nephew (ભત્રીજો)">Nephew (ભત્રીજો)</option>
                                        <option value="Niece (ભત્રીજી)">Niece (ભત્રીજી)</option>
                                        <option value="Daughter in Law (પુત્રવધૂ)">Daughter in Law (પુત્રવધૂ)</option>
                                        <option value="Grandson (પૌત્ર)">Grandson (પૌત્ર)</option>
                                        <option value="Granddaughter (પૌત્રી)">Granddaughter (પૌત્રી)</option>
                                        <option value="Brother's Wife (ભાભી)">Brother's Wife (ભાભી)</option>
                                        <option value="Nephew's Wife  (પિતરાઈ વધૂ)">Nephew's Wife  (પિતરાઈ વધૂ)</option>
                                    </select>   
                                    <span id="fmemberrelationtypeerror" style="color: Red;font-size:14px;display: none;">Choose Relation type</span>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 form-group">
                                    <label>Village :</label>
                                    <select name="fmembervillage" id="fmembervillage" class="form-control">
                                        <option value="" >--Select village--</option>
                                        <?php
                                        $category = get_terms(array('taxonomy' => 'village', 'hide_empty' => false));
                                        foreach ($category as $value) {
                                            ?>    
                                            <option value="<?php echo $value->term_id; ?>"><?php echo $value->name; ?></option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                    <span id="fmembervillageerror" style="color: Red;font-size:14px;display: none;">Choose village</span>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 form-group">
                                    <label>Gender :</label>
                                    <select name="fmembergender" id="fmembergender" class="form-control ">
                                        <option value="">--Select gender--</option>
                                        <option value="male" >Male(પુરુષ)</option>
                                        <option value="female" >Female(સ્ત્રી)</option>
                                    </select>
                                    <span id="fmembergendererror" style="color: Red;font-size:14px;display: none;">Choose gender</span>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 form-group">
                                    <label>Maritial Status :</label>
                                    <select name="fmembermaritalstatus" id="fmembermaritalstatus" class="form-control">
                                        <option value="">Select marital status</option>
                                        <option value="married">Married(પરણિત)</option>
                                        <option value="unmarried">Unmarried(અપરણિત)</option>
                                    </select>
                                    <span id="fmembermaritalstatuserror" style="color: Red;font-size:14px;display: none;">Choose Marital status</span>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 form-group">
                                    <label>Contact No. :</label>  
                                    <input name="fmembercontactno" id="fmembercontactno" onkeypress="phoneno()" maxlength="14" placeholder="+91-9377599404" class="form-control" type="text" value="" />
                                    <span id="fmembercontactnoerror" style="color: Red;font-size:14px;display: none;">Contact no. is required(+91-8978457889)</span>
                                </div>
                            </div>

                            <div class="col-md-6 col-sm-12 col-xs-12">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 form-group">
                                    <label>Name(Gujarati) :</label>
                                    <div style="position:relative;">
                                        <input type="text" name="fmembergujname" id="fmembergujname" value="" onkeypress="return fIsAlphaNumeric3(event);" ondrop="return false;" class="keyboardInput form-control custom-keyboard" placeholder="Enter Name(Guj.)" />
                                        <span id="fmembergujnameerror" style="color: Red;font-size:14px;display: none;">Name is required(in Gujarati)</span>
                                        <span id="ferror3" style="color: Red;font-size:14px;display: none;">Only use Virtual keyboard </span>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 form-group">
                                    <label>Date of Birth :</label>
                                    <input  name="fmemberdob" id="fmemberdob" placeholder="mm-dd-yyyy" class="form-control" type="Date" value="" />
                                    <span id="fmemberdoberror" style="color: Red;font-size:14px;display: none;">DOB is required</span>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 form-group">
                                    <label>Email :</label>
                                    <input type="email" name="fmemberemail" id="fmemberemail" placeholder="Enter E-Mail Address" class="form-control" value="" title="Enter proper email address" required="" />
                                    <span id="fmemberemailerror" style="color: Red;font-size:14px;display: none;">E-mail is required</span>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 form-group">
                                    <label>Profile :</label>
                                    <div class="form-group">
                                        <!--File upload in modal with in modalm start-->

                                        <div class="inputGroupContainer">
                                            <div class="container">
                                                <div class="views_container">
                                                    <img id="viewsImgOfFamilymember" title="Click to change" data-toggle="modal" data-toggle="modal" data-target="#fmemberimageModal" src="<?php echo get_template_directory_uri() . '/images/user.png'; ?>" width="100px">
                                                </div>

                                                <div class="modal fade" id="fmemberimageModal" role="dialog">
                                                    <div class="modal-dialog">


                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5>Choose image</h5>
                                                            </div>
                                                            <div class="modal-body">
                                                                <p>

                                                                <div id="fviewss"></div>
                                                                <br>
                                                                <input id="fmemfile" type="file" />

                                                                </p>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-primary" id="fmembercropbutton" type="button" class="ClassNameOfShouldBeHiddenElements">Crop</button>
                                                                <button type="button" class="btn btn-primary" id="fmemberrotatebutton" type="button">Rotate</button>
                                                                <button type="button" class="btn btn-primary" id="fmemberhflipbutton" type="button">H-flip</button>
                                                                <button type="button" class="btn btn-primary" id="fmembervflipbutton" type="button">V-flip</button> 
                                                                <button type="button" class="btn btn-success" id="fmemgetdata" type="button">OK</button> 
                                                                <button type="button" class="btn btn-danger" id="fmembermodelclose">Close</button>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                                <input type="hidden" id="fmemviewsimg" name="fmemimgdata" />
                                            </div>
                                        </div>
                                        <!--File upload in modal with in modal start-->
                                    </div>
                                </div>

                            </div>

                            </p>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-success" id="faddMember">Update</button>
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                        </div>
                </div>
                </form>
            </div>
        </div>
    </div>

</div>


<script type="text/javascript">

    var metaid = 0;

    function DeleteMemberInfo(userid, data)
    {
//        alert(userid + "---" + data);
        var txt;
        var r = confirm("Are you sure want to delete this User ?");
        if (r == true) {
            metaid = data;
        var ajaxurl = '<?php echo admin_url('admin-ajax.php'); ?>';
        jQuery.ajax({
            url: ajaxurl,
            data: {action: 'delete_user_member_action', userid: userid, umetaid: data},
            type: "POST",
            success: function (data1) {
                location.reload();
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(jqXHR);
                console.log(textStatus);
                console.log(errorThrown);
            }});
        }
    }

    function displayMemberInfo(userid, data)
    {
        //            alert(userid + "---" + data);
        metaid = data;
        var ajaxurl = '<?php echo admin_url('admin-ajax.php'); ?>';
        jQuery.ajax({
            url: ajaxurl,
            data: {action: 'display_user_member_action', userid: userid, umetaid: data},
            type: "POST",
            dataType: "json",
            success: function (data1) {
                console.log(data1);
//                console.log(data1['membercontactno']);
                document.getElementById("fmemberengname").value = data1['memberengname'];
                document.getElementById("fmemberrelationtype").value = data1['memberrelationtype'];
                document.getElementById("fmembervillage").value = data1['membervillage'];
                document.getElementById("fmembergender").value = data1['membergender'];
                document.getElementById("fmembermaritalstatus").value = data1['membermaritalstatus'];
                document.getElementById("fmembercontactno").value = data1['membercontactno'];
                document.getElementById("fmembergujname").value = data1['membergujname'];
                document.getElementById("fmemberdob").value = data1['memberdob'];
                document.getElementById("fmemberemail").value = data1['memberemail'];
                document.getElementById("viewsImgOfFamilymember").src = "<?php
                                        $a = wp_upload_dir();
                                        echo $a['baseurl'];
                                        ?>/user/" + data1['memimgdata'];
                document.getElementById("fmemviewsimg").value = data1['memimgdata'];
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(jqXHR);
                console.log(textStatus);
                console.log(errorThrown);
            }});
    }

    jQuery(document).ready(function () {

        // update member
        jQuery('#faddMember').on('click', function () {
            //alert('ready');
            event.preventDefault();
            var error1, error2, error3, error4, error5, error6, error7, error8, error9;

            if (jQuery("#fmemberengname").val() == "") {
                document.getElementById("fengnameerror").style.display = "inline";
                error1 = 1;
            }
            else
            {
                document.getElementById("fengnameerror").style.display = "none";
                error1 = 0;
            }
            if (jQuery("#fmemberrelationtype").val() == "") {
                document.getElementById("fmemberrelationtypeerror").style.display = "inline";
                error2 = 1;
            }
            else
            {
                document.getElementById("fmemberrelationtypeerror").style.display = "none";
                error2 = 0;
            }
            if (jQuery("#fmembervillage").val( ) == "") {
                document.getElementById("fmembervillageerror").style.display = "inline";
                error3 = 1;
            }
            else {
                document.getElementById("fmembervillageerror").style.display = "none";
                error3 = 0;
            }

            if (jQuery("#fmembergender").val() == "") {
                document.getElementById("fmembergendererror").style.display = "inline";
                error4 = 1;
            }
            else
            {
                document.getElementById("fmembergendererror").style.display = "none";
                error4 = 0;
            }

            if (jQuery("#fmembermaritalstatus").val() == "") {
                document.getElementById("fmembermaritalstatuserror").style.display = "inline";
                error5 = 1;
            }
            else
            {
                document.getElementById("fmembermaritalstatuserror").style.display = "none";
                error5 = 0;
            }

            if (jQuery("#fmembercontactno").val() == "") {
                document.getElementById("fmembercontactnoerror").style.display = "inline";
                error6 = 1;
            }
            else
            {
                document.getElementById("fmembercontactnoerror").style.display = "none";
                error6 = 0;
            }

            if (jQuery("#fmembergujname").val() == "") {
                document.getElementById("fmembergujnameerror").style.display = "inline";
                error7 = 1;
            }
            else
            {
                document.getElementById("fmembergujnameerror").style.display = "none";
                error7 = 0;
            }

            if (jQuery("#fmemberdob").val() == "") {
                document.getElementById("fmemberdoberror").style.display = "inline";
                error8 = 1;
            }
            else
            {
                document.getElementById("fmemberdoberror").style.display = "none";
                error8 = 0;
            }

            if (jQuery("#fmemberemail").val() == "") {
                document.getElementById("fmemberemailerror").style.display = "inline";
                error9 = 1;
            }
            else
            {
                document.getElementById("fmemberemailerror").style.display = "inline";
                error9 = 1;
//                    alert(jQuery("#memberemail").val());
                var pattern = /^([a-zA-Z0-9_.-])+@([a-zA-Z0-9_.-])+\.([a-zA-Z])+([a-zA-Z])+/;
                if (pattern.test(jQuery("#fmemberemail").val())) {
                    document.getElementById("fmemberemailerror").style.display = "none";
                    error9 = 0;
                } else {
                    document.getElementById("fmemberemailerror").innerHTML = "Email address is not valid yet.";
                    error9 = 1;
                }

            }

            if (error1 != 1 && error2 != 1 && error3 != 1 && error4 != 1 && error5 != 1 && error6 != 1 && error7 != 1 && error8 != 1 && error9 != 1) {
                var data = jQuery('#updatefamilymemberform').serialize();
                //alert(jQuery('#updatefamilymemberform').serializeArray());
                var imgchange = document.getElementById('fmemviewsimg').value;
                //alert(imgchange);
                console.log(data);
                var ajaxurl = '<?php echo admin_url('admin-ajax.php'); ?>';
                jQuery.ajax({
                    url: ajaxurl,
                    data: {action: 'update_member_action', alldata: data, umetaid: metaid, img_change: imgchange},
                    type: "POST",
                    success: function (data) {
                        alert("updated...");
                        location.reload();
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        console.log(jqXHR);
                        console.log(textStatus);
                        console.log(errorThrown);
                    }
                });
            }
        });

//            Form data of add new member
        jQuery('#addMember').on('click', function () {
            event.preventDefault();
            var error1, error2, error3, error4, error5, error6, error7, error8, error9;

            if (jQuery("#memberengname").val() == "") {
                document.getElementById("engnameerror").style.display = "inline";
                error1 = 1;
            } else
            {
                document.getElementById("engnameerror").style.display = "none";
                error1 = 0;
            }

            if (jQuery("#memberrelationtype").val() == "") {
                document.getElementById("memberrelationtypeerror").style.display = "inline";
                error2 = 1;
            }
            else
            {
                document.getElementById("memberrelationtypeerror").style.display = "none";
                error2 = 0;
            }

            if (jQuery("#membervillage").val() == "") {
                document.getElementById("membervillageerror").style.display = "inline";
                error3 = 1;
            }
            else {
                document.getElementById("membervillageerror").style.display = "none";
                error3 = 0;
            }

            if (jQuery("#membergender").val() == "") {
                document.getElementById("membergendererror").style.display = "inline";
                error4 = 1;
            }
            else
            {
                document.getElementById("membergendererror").style.display = "none";
                error4 = 0;
            }

            if (jQuery("#membermaritalstatus").val() == "") {
                document.getElementById("membermaritalstatuserror").style.display = "inline";
                error5 = 1;
            }
            else
            {
                document.getElementById("membermaritalstatuserror").style.display = "none";
                error5 = 0;
            }
            if (jQuery("#membercontactno").val() == "") {
                document.getElementById("membercontactnoerror").style.display = "inline";
                error6 = 1;
            }
            else
            {
                document.getElementById("membercontactnoerror").style.display = "none";
                error6 = 0;
            }

            if (jQuery("#membergujname").val() == "") {
                document.getElementById("membergujnameerror").style.display = "inline";
                error7 = 1;
            }
            else
            {
                document.getElementById("membergujnameerror").style.display = "none";
                error7 = 0;
            }

            if (jQuery("#memberdob").val() == "") {
                document.getElementById("memberdoberror").style.display = "inline";
                error8 = 1;
            }
            else
            {
                document.getElementById("memberdoberror").style.display = "none";
                error8 = 0;
            }

            if (jQuery("#memberemail").val() == "") {
                document.getElementById("memberemailerror").style.display = "inline";
                error9 = 1;
            }
            else
            {
                document.getElementById("memberemailerror").style.display = "inline";
                error9 = 1;
                var pattern = /^([a-zA-Z0-9_.-])+@([a-zA-Z0-9_.-])+\.([a-zA-Z])+([a-zA-Z])+/;
                if (pattern.test(jQuery("#memberemail").val())) {
                    document.getElementById("memberemailerror").style.display = "none";
                    error9 = 0;
                } else {
                    document.getElementById("memberemailerror").innerHTML = "Email address is not valid yet.";
                    error9 = 1;
                }

            }

            if (error1 != 1 && error2 != 1 && error3 != 1 && error4 != 1 && error5 != 1 && error6 != 1 && error7 != 1 && error8 != 1 && error9 != 1) {
                var data = jQuery('#memberform').serialize();
                console.log(data);

                var ajaxurl = '<?php echo admin_url('admin-ajax.php'); ?>';
                jQuery.ajax({
                    url: ajaxurl,
                    data: {action: 'add_new_member_action', alldata: data},
                    type: "POST",
                    success: function (data) {
                        alert("Insert Sucessfully...!")
                        location.reload();
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        console.log(jqXHR);
                        console.log(textStatus);
                        console.log(errorThrown);
                    }
                });
            }
        });
    });

    function phoneno() {
        jQuery('#membercontactno').keypress(function (e) {
            var a = [];
            var k = e.which;

            for (i = 43; i < 58; i++)
                a.push(i);

            if (!(a.indexOf(k) >= 0))
                e.preventDefault();
        });
        jQuery('#fmembercontactno').keypress(function (e) {
            var a = [];
            var k = e.which;

            for (i = 43; i < 58; i++)
                a.push(i);

            if (!(a.indexOf(k) >= 0))
                e.preventDefault();
        });
    }

    var specialKeys = new Array();
    specialKeys.push(118); //v key
    function IsAlphaNumeric(e) {
        var keyCode = e.keyCode == 0 ? e.charCode : e.keyCode;
        var ret = (!(keyCode >= 0 && keyCode <= 127) || specialKeys.indexOf(keyCode) != -1);
        document.getElementById("error").style.display = ret ? "none" : "inline";
        return ret;
    }
    function IsAlphaNumeric2(e) {
        //        alert('');
        var keyCode = e.keyCode == 0 ? e.charCode : e.keyCode;
        var ret = (!(keyCode >= 0 && keyCode <= 127) || specialKeys.indexOf(keyCode) != -1);
        document.getElementById("error1").style.display = ret ? "none" : "inline";
        return ret;
    }
    function IsAlphaNumeric3(e) {
        //        alert('');
        var keyCode = e.keyCode == 0 ? e.charCode : e.keyCode;
        var ret = (!(keyCode >= 0 && keyCode <= 127) || specialKeys.indexOf(keyCode) != -1);
        document.getElementById("error3").style.display = ret ? "none" : "inline";
        return ret;
    }
    function fIsAlphaNumeric3(e) {
        //        alert('');
        var keyCode = e.keyCode == 0 ? e.charCode : e.keyCode;
        var ret = (!(keyCode >= 0 && keyCode <= 127) || specialKeys.indexOf(keyCode) != -1);
        document.getElementById("ferror3").style.display = ret ? "none" : "inline";
        return ret;
    }

    //    Crop Image source start
    var crop_max_width = 400;
    var crop_max_height = 400;
    var jcrop_api;
    var canvas;
    var context;
    var image;
    var prefsize;

    jQuery("#file").change(function () {
        loadImage(this);
    });
    jQuery("#memfile").change(function () {
        loadImage(this);
    });
    jQuery("#fmemfile").change(function () {
        loadImage(this);
    });

    function loadImage(input) {
        //alert(input.files[0]);
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            canvas = null;
            reader.onload = function (e) {
                image = new Image();
                image.onload = validateImage;
                image.src = e.target.result;
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
    function dataURLtoBlob(dataURL) {
        var BASE64_MARKER = ';base64,';
        if (dataURL.indexOf(BASE64_MARKER) == -1) {
            var parts = dataURL.split(',');
            var contentType = parts[0].split(':')[1];
            var raw = decodeURIComponent(parts[1]);
            return new Blob([raw], {
                type: contentType
            });
        }
        var parts = dataURL.split(BASE64_MARKER);
        var contentType = parts[0].split(':')[1];
        var raw = window.atob(parts[1]);
        var rawLength = raw.length;
        var uInt8Array = new Uint8Array(rawLength);
        for (var i = 0; i < rawLength; ++i) {
            uInt8Array[i] = raw.charCodeAt(i);
        }

        return new Blob([uInt8Array], {
            type: contentType
        });
    }

    function validateImage() {
        if (canvas != null) {
            image = new Image();
            image.onload = restartJcrop;
            image.src = canvas.toDataURL('image/png');
        } else
            restartJcrop();
    }

    function restartJcrop() {
        if (jcrop_api != null) {
            jcrop_api.destroy();
        }
        jQuery("#views").empty();
        jQuery("#views").append("<div class='dummy'><canvas id=\"canvas\" ></canvas></div>");
        jQuery("#viewss").empty();
        jQuery("#viewss").append("<div class='dummy'><canvas id=\"canvas1\" ></canvas></div>");
        jQuery("#fviewss").empty();
        jQuery("#fviewss").append("<div class='dummy'><canvas id=\"canvas2\" ></canvas></div>");
        canvas = jQuery("#canvas")[0];
        canvas1 = jQuery("#canvas1")[0];
        canvas2 = jQuery("#canvas2")[0];
        context = canvas.getContext("2d");
        context1 = canvas1.getContext("2d");
        context2 = canvas2.getContext("2d");
        canvas.width = image.width;
        canvas.height = image.height;
        canvas1.width = image.width;
        canvas1.height = image.height;
        canvas2.width = image.width;
        canvas2.height = image.height;
        context.drawImage(image, 0, 0);
        context1.drawImage(image, 0, 0);
        context2.drawImage(image, 0, 0);
        jQuery("#canvas").Jcrop({
            onSelect: selectcanvas,
            onRelease: clearcanvas,
            boxWidth: crop_max_width,
            boxHeight: crop_max_height,
            setSelect: [180, 180, 180, 180],
            allowResize: false,
            minSize: [180, 180],
            maxSize: [180, 180],
            aspectRatio: 1
        }, function () {
            jcrop_api = this;
        });
        jQuery("#canvas1").Jcrop({
            onSelect: selectcanvas,
            onRelease: clearcanvas,
            boxWidth: crop_max_width,
            boxHeight: crop_max_height,
            setSelect: [180, 180, 180, 180],
            allowResize: false,
            minSize: [180, 180],
            maxSize: [180, 180], aspectRatio: 1
        }, function () {
            jcrop_api = this;
        });
        jQuery("#canvas2").Jcrop({
            onSelect: selectcanvas, onRelease: clearcanvas,
            boxWidth: crop_max_width,
            boxHeight: crop_max_height,
            setSelect: [180, 180, 180, 180],
            allowResize: false,
            minSize: [180, 180],
            maxSize: [180, 180],
            aspectRatio: 1
        }, function () {
            jcrop_api = this;
        });
        clearcanvas();
    }

    function clearcanvas() {
        prefsize = {
            x: 0,
            y: 0,
            w: canvas.width,
            h: canvas.height,
        };
    }

    function selectcanvas(coords) {
        prefsize = {
            x: Math.round(coords.x),
            y: Math.round(coords.y),
            w: Math.round(coords.w),
            h: Math.round(coords.h)
        };
    }

    function applyCrop() {
        canvas.width = prefsize.w;
        canvas.height = prefsize.h;
        context.drawImage(image, prefsize.x, prefsize.y, prefsize.w, prefsize.h, 0, 0, canvas.width, canvas.height);
        validateImage();
    }

    function applyRotate() {
        canvas.width = image.height;
        canvas.height = image.width;
        context.clearRect(0, 0, canvas.width, canvas.height);
        context.translate(image.height / 2, image.width / 2);
        context.rotate(Math.PI / 2);
        context.drawImage(image, -image.width / 2, -image.height / 2);
        validateImage();
    }

    function applyHflip() {
        context.clearRect(0, 0, canvas.width, canvas.height);
        context.translate(image.width, 0);
        context.scale(-1, 1);
        context.drawImage(image, 0, 0);
        validateImage();
    }

    function applyVflip() {
        context.clearRect(0, 0, canvas.width, canvas.height);
        context.translate(0, image.height);
        context.scale(1, -1);
        context.drawImage(image, 0, 0);
        validateImage();
    }

    jQuery("#cropbutton").click(function (e) {
        if (jQuery("#file").val() == '') {
            alert('Please choose image');
        } else {
            applyCrop();
        }
    });
    jQuery("#membercropbutton").click(function (e) {
        if (jQuery('#file').val() != '') {
            alert('Please choose image');
        } else {
            applyCrop();
        }
    });
    jQuery("#fmembercropbutton").click(function (e) {
        if (jQuery('#file').val() != '') {
            alert('Please choose image');
        } else {
            applyCrop();
        }
    });

    jQuery("#rotatebutton").click(function (e) {
        if (jQuery("#file").val() == '') {
            alert('Please choose image');
        } else {
            applyRotate();
        }
    });
    jQuery("#memberrotatebutton").click(function (e) {
        if (jQuery("#memfile").val() == '') {
            alert('Please choose image');
        } else {
            applyRotate();
        }
    });
    jQuery("#fmemberrotatebutton").click(function (e) {
        if (jQuery("#fmemfile").val() == '') {
            alert('Please choose image');
        } else {
            applyRotate();
        }
    });

    jQuery("#hflipbutton").click(function (e) {
        if (jQuery("#file").val() == '') {
            alert('Please choose image');
        } else {
            applyHflip();
        }
    });
    jQuery("#memberhflipbutton").click(function (e) {
        if (jQuery("#memfile").val() == '') {
            alert('Please choose image');
        } else {
            applyHflip();
        }
    });
    jQuery("#fmemberhflipbutton").click(function (e) {
        if (jQuery("#fmemfile").val() == '') {
            alert('Please choose image');
        } else {
            applyHflip();
        }
    });

    jQuery("#vflipbutton").click(function (e) {
        if (jQuery("#file").val() == '') {
            alert('Please choose image');
        } else {
            applyVflip();
        }
    });
    jQuery("#membervflipbutton").click(function (e) {
        if (jQuery("#memfile").val() == '') {
            alert('Please choose image');
        } else {
            applyVflip();
        }
    });
    jQuery("#fmembervflipbutton").click(function (e) {
        if (jQuery("#fmemfile").val() == '') {
            alert('Please choose image');
        } else {
            applyVflip();
        }
    });

    jQuery("#getdata").click(function (e) {
        if (jQuery('#file').val() != '') {
            var c = document.getElementById("canvas");
            var d = c.toDataURL("image/png");
            jQuery('#views1').attr('src', d);
            document.getElementById("viewsimg").value = d;
            jQuery("#close-span").show();
        }
    });
    jQuery("#memgetdata").click(function () {
        jQuery('#memberimageModal').modal('hide');

        if (jQuery('#memfile').val() != '') {
            var c = document.getElementById("canvas1");
            var d = c.toDataURL("image/png");
            jQuery('#viewsImgg').attr('src', d);
            document.getElementById("memviewsimg").value = d;
//                    jQuery(".close-spann").show();
        }
    });
    jQuery("#fmemgetdata").click(function () {
        jQuery('#fmemberimageModal').modal('hide');

        if (jQuery('#fmemfile').val() != '') {
            var c = document.getElementById("canvas2");
            var d = c.toDataURL("image/png");
            jQuery('#viewsImgOfFamilymember').attr('src', d);
            document.getElementById("fmemviewsimg").value = d;
//                    jQuery(".close-spann").show();
        }
    });
    jQuery("#membermodelclose").click(function () {
        jQuery('#memberimageModal').modal('hide');
    });
    jQuery("#fmembermodelclose").click(function () {
        jQuery('#fmemberimageModal').modal('hide');
    });

    jQuery("#myModal1").on("show.bs.modal", function () {

        jQuery("body,html").animate({
            scrollTop: 0
        }, 500);
        if (jQuery(window).width() > 767) {
            jQuery(".custom_keyboard .keyboardInputInitiator").click(function () {
                jQuery('#keyboardInputMaster').addClass("pop-up-keyboard");
            });
        }

    });
jQuery("#fmemberModal").on("show.bs.modal", function () {

        jQuery("body,html").animate({
            scrollTop: 0
        }, 500);
    });
	
    jQuery("#memberimageModal").on("show.bs.modal", function () {
        jQuery("#myModal1").animate({
            scrollTop: 0
        }, 500);
    });
    jQuery("#fmemberimageModal").on("show.bs.modal", function () {
        jQuery("#fmemberModal").animate({
            scrollTop: 0
        }, 500);
    });

    jQuery("#memberimageModal").on("hide.bs.modal", function () {
        jQuery("#myModal1").animate({
            scrollTop: jQuery(document).height()
        }, 500);
        jQuery("#myModal1").css('overflow', 'auto');
    });
    jQuery("#fmemberimageModal").on("hide.bs.modal", function () {
        jQuery("#fmemberModal").animate({
            scrollTop: jQuery(document).height()
        }, 500);
        jQuery("#fmemberModal").css('overflow', 'auto');

    });
    jQuery("#myModal1").on("hide.bs.modal", function () {
        jQuery('#keyboardInputMaster').removeClass("pop-up-keyboard");
    });

</script>
<?php
get_footer();
?>