<?php
/**
 * Template Name: Add new member Detail template
 */
get_header();

global $current_user;
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
        <h4 align="right" style="position:absolute" class="cust_head custom_header">Add Member</h4>
    </div>
</div>
<form method="post" >
    <div class="user_detail_container">
        <?php
        $path = wp_upload_dir();
        $get_path = $path['baseurl'] . "/user/" . $user_latest_profile_pic;
        ?>
           <div class="container detail_user">
            <div class="user_content">
                <div class="row">
                    <div class="col-xs-12">
                        <p class="user_name"><?php echo get_user_meta($user_info->ID, 'eng_name', true); ?></p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-xs-offset-0 col-sm-12 col-sm-offset-0 col-md-8 col-md-offset-2">
                    <div class="detail_form_section">
<!--                        <div class="row">
                            <div class="col-xs-12">
                                <h3 class="user_detail">Add New Member Details</h3>
                            </div>                
                        </div>-->

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
                                <span class="usercommonfont"><input type="text" name="upgujname" value="<?php echo get_user_meta($user_info->ID, 'gujname', true); ?>" onkeypress="return IsAlphaNumeric(event);" ondrop="return false;" class="keyboardInput form-control custom-input" /></span>
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
                        <div class="row form-group">
                            <div class="col-xs-12 col-sm-4 col-md-4 col-lg-3">
                                <label>E-mail :</label>
                            </div>
                            <div class="col-xs-12 col-sm-8 col-md-8 col-lg-9">
                                <span class="usercommonfont"><input type="text" name="upemail" value="<?php echo get_user_meta($user_info->ID, 'eamil', true); ?>" class="form-control" /></span>
                            </div>
                        </div>
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
                                <span class="usercommonfont"><textarea onkeypress="return IsAlphaNumeric2(event);" ondrop="return false;" class="keyboardInput form-control custom-input" name="upgujadd" value="<?php echo get_user_meta($user_info->ID, 'gujaddress', true); ?>"><?php echo get_user_meta($user_info->ID, 'gujaddress', true); ?></textarea></span>
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
                        <div class="row form-group">
                            <div class="col-xs-12 col-sm-4 col-md-4 col-lg-3">
                                <label>Profile :</label>
                            </div>
                            <div class="col-xs-12 col-sm-8 col-md-8 col-lg-9">
                                <div class="form-group">
                                    <div class="col-md-8 inputGroupContainer">
                                        <div class="container">
                                            <div class="views_container">
                                                <img id="views1" class="" title="Click to change" data-toggle="modal" data-toggle="modal" data-target="#myModal" src="<?php echo get_template_directory_uri() . '/images/user.png'; ?>" width="100px">
                                                <span class="glyphicon glyphicon-remove" id="close-span"></span>
                                            </div>
                                             Modal 
                                            <div class="modal fade" id="myModal" role="dialog">
                                                <div class="modal-dialog">

                                                     Modal content
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
                                                            <button type="button" class="btn btn-success" id="getdata" type="button" data-dismiss="modal"  name="upimg" value="yes">OK</button> 
                                                            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                            <input type="hidden" id="viewsimg" name="imgdata" value="" />
                                        </div>
                                    </div>
                                </div>
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
                        <span class="usercommonfont"><button type="submit" name="upsumbit" value="Update" class="form-control btn btn-info update" ><i class="fa fa-pencil"></i> Update Profile</button></span>
                        <span class="usercommonfont"><button type="submit" name="adddtl" value="Add" class="form-control btn btn-success update" ><i class="fa fa-plus"></i> Add Member</button></span>
                    </div>
                    
                </div>

            </div>

        </div>
    </div>
</form>
<script type="text/javascript">
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

    function loadImage(input) {
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
        canvas = jQuery("#canvas")[0];
        context = canvas.getContext("2d");
        canvas.width = image.width;
        canvas.height = image.height;
        context.drawImage(image, 0, 0);
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
    jQuery("#rotatebutton").click(function (e) {
        if (jQuery("#file").val() == '') {
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
    jQuery("#vflipbutton").click(function (e) {
        if (jQuery("#file").val() == '') {
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
</script>
<?php
get_footer();
?>

