<?php
/**
 * Template Name: Registration form Template
 */
get_header();

/* Check the form button is click or not  */

if (isset($_POST['submit'])) {
//    echo "Click";
    //validation

    if (empty($_POST['engname']) || !preg_match("/^[a-zA-Z ]*$/", $_POST['engname'])) {
        $engnameerror = 1;
    }
    if (empty($_POST['gujname'])) {
        $gujnameerror = 1;
    }
    if (empty($_POST['contactno']) || !preg_match("/^(?:(?:\+|0{0,2})91(\s*[\ -]\s*)?|[0]?)?[789]\d{9}|(\d[ -]?){10}\d$/", $_POST['contactno'])) {
        $contactnoerror = 1;
    }
    if (empty($_POST['dob'])) {
        $doberror = 1;
    }
    if (empty($_POST['email']) || !preg_match("/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/", $_POST['email'])) {
        $emailerror = 1;
    }
    if (empty($_POST['address'])) {
        $addresserror = 1;
    }
    if (empty($_POST['gujaddress'])) {
        $gujaddresserror = 1;
    }
    if (empty($_POST['village'])) {
        $villageerror = 1;
    }
    if (empty($_POST['gender'])) {
        $gendererror = 1;
    }
    if (empty($_POST['maritalstatus'])) {
        $maritalstatuserror = 1;
    }
    if (empty($_POST['imgdata'])) {
        $fileuploaderror = 1;
    }
    
    $engname = $_POST['engname'];
    //echo $engname . "<br>";
    $gujname = $_POST['gujname'];
    //echo $gujname . "<br>";
    $contactno = $_POST['contactno'];
    //echo $contactno . "<br>";
    $dob = $_POST['dob'];
    //echo $dob . "<br>";
    $email = $_POST['email'];
    //echo $email . "<br>";
    $address = $_POST['address'];
    //echo $address . "<br>";
    $gujaddress = $_POST['gujaddress'];
    //echo $gujaddress . "<br>";
    $village = $_POST['village'];
    //echo $village . "<br>";
    $gender = $_POST['gender'];
    //echo $gender ."<br>";
    $maritalstatus = $_POST['maritalstatus'];
    //echo $maritalstatus . "<br>";

    $pass = wp_generate_password(15, true, true);
    //echo $pass;


    global $wpdb;

    $user_data = array(
        'user_pass' => $pass,
        'user_login' => $engname,
        'user_nicename' => $gujname,
        'user_email' => $email,
        'display_name' => $gujname
    );

    //print_r($user_data);

    if ((isset($engnameerror) && $engnameerror == 1) || (isset($gujnameerror) && $gujnameerror == 1) || (isset($contactnoerror) && $contactnoerror == 1) || (isset($doberror) && $doberror == 1) || (isset($emailerror) && $emailerror == 1) || (isset($addresserror) && $addresserror == 1) || (isset($gujaddresserror) && $gujaddresserror == 1) || (isset($villageerror) && $villageerror == 1) || (isset($gendererror) && $gendererror == 1) || (isset($maritalstatuserror) && $maritalstatuserror == 1) || (isset($fileuploaderror) && $fileuploaderror == 1)) {
        ?>
        <div class="alert alert-danger alert-dismissable">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
            <strong><?php echo "All field are mandatory"; ?>..!</strong>
        </div>
        <?php
    } else {
        
        
        $id = wp_insert_user($user_data);

        if (!is_wp_error($id)) {
//        echo 'ID:';
//    echo $id;

            /* User image uploading start */

            $get_path = WP_get_custom_image_upload_path('user');
            $img = $_POST['imgdata'];
            $img = str_replace('data:image/png;base64,', '', $img);
            $img = str_replace(' ', '+', $img);
            $data = base64_decode($img);
//            echo $data;
            $file = USER . uniqid() . '.png';
            $fh = fopen($get_path . $file, 'w');
            fwrite($fh, $data);
            fclose($fh);
       
            /* User image uploading end */

            /* Start adding data in user_meta table */

            add_user_meta($id, 'eng_name', $engname);  //name enter in English 
            add_user_meta($id, 'gujname', $gujname);  //name enter in gujarati
            add_user_meta($id, 'contact_num', $contactno);  //add contact number
            add_user_meta($id, 'dob', $dob);  //add birthdate
            //add_user_meta($id, 'eamil', $email);  //add email
            add_user_meta($id, 'address', $address);  //add address
            add_user_meta($id, 'gujaddress', $gujaddress);  //add address
            add_user_meta($id, 'village_name', $village);  //add village name
            add_user_meta($id, 'gender', $gender);  //add gender
            add_user_meta($id, 'maritalstatus', $maritalstatus);  //add maritalstatus
            add_user_meta($id, 'user_profile', $file);  //add user profile
			
			/* Password send using E-mail, after registration start */
			
			$to = $email;
			$subject = "Your Registarion is successfully and We send your Password";
			$message = "<html><body><center><img src='http://natsocialdev.natrixsoftware.com/wp-content/uploads/2018/05/logo_white.png'alt='SHREE UTTAR GUJARAT PATIDAR SAMAJ'style='width:15%'></center><br/><h6 style='color: #c03;text-shadow: 1px 1px black;font-size: 18px;'>Welcome,You are successfully registered in SHREE UTTAR GUJARAT PATIDAR SAMAJ</h6><hr/><table><tr><td><p style='color: #c03;font-size: 14px;'>Your Password is&nbsp;:&nbsp;</td></p><td><p style='color: black;font-size: 14px;font-weight:bold;'>".$pass."</p></td></tr></table><hr/><p style='color:red;font-size:12px;'>Note&nbsp;:&nbsp;</p><span>You are register sucessfully in SHREE UTTAR GUJARAT PATIDAR SAMAJ,but your request is still pending.Once admin can approved you after you have member,and do login using above password.</span></body></html>";
			$headers = array('Content-Type: text/html; charset=UTF-8');

						
			$sentmail = wp_mail($to, $subject, $message,$headers);
			if(is_wp_error($sentmail))
			{
				//print_r($sent);
				echo "Sorry, some technical issue occure, so we can not send error, we will solve it earlyer...";
			}
						
			/* Password send using E-mail, after registration start */
			
            ?>
            <div class="alert alert-success alert-dismissable">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
                <strong>Registration Successful...!, Check your email account, we send you Login password, Once admin approved you after you can Login in system. </strong>
            </div>
            <?php
        } else {
            ?>
            <div class="alert alert-danger alert-dismissable">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
                <strong><?php print_r($id->get_error_message()); ?>..!</strong>
            </div>
            <?php
        }
    }
}
?>

<!-- registration form design -->
<div class="">
    <div class="" style="position: relative">
        <img src="<?php echo get_template_directory_uri() . '/images/about-banner.jpg'; ?>" class="img-responsive respImageheading" />

        <h4 align="right" style="position:absolute" class="cust_head custom_header">Register here...</h4>      
    </div>
</div>

<br/><br/>
<div class="container">
    <div class="">       
        <form class="form-horizontal" id="form" action="" method="post" enctype="multipart/form-data">
            <fieldset>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="col-md-4 control-label customheadingrander">Full Name</label>  
                            <div class="col-md-8 inputGroupContainer">
                                <div class="input-group">
                                    <span class="input-group-addon custominputboxrander"><i class="glyphicon glyphicon-user"></i></span>
                                    <input name="engname" placeholder="Enter Name" class="form-control custominputboxrander" type="text" value="<?php if (isset($_POST['engname'])) {
    echo $_POST['engname'];
} ?>" />
                                </div>
                                <div><?php if (isset($engnameerror) && $engnameerror == 1) {
    echo "<span style='color:red;font-size:14px;'>Please enter name(in English)</span>";
} ?></div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label customheadingrander" >Address</label> 
                            <div class="col-md-8 inputGroupContainer">
                                <div class="input-group">
                                    <span class="input-group-addon custominputboxrander"><i class="glyphicon glyphicon-home"></i></span>
                                    <textarea name="address" placeholder="Enter Address" class="form-control custominputboxrander" value="<?php if (isset($_POST['address'])) {
    echo $_POST['address'];
} ?>" style="resize:vertical;Width:100%;" ><?php if (isset($_POST['address'])) {
    echo $_POST['address'];
} ?></textarea>
                                </div>
                                <div><?php if (isset($addresserror) && $addresserror == 1) {
    echo "<span style='color:red;font-size:14px;'>Please enter address</span>";
} ?></div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label customheadingrander">Contact No.</label>  
                            <div class="col-md-8 inputGroupContainer">
                                <div class="input-group">
                                    <span class="input-group-addon custominputboxrander"><i class="glyphicon glyphicon-earphone"></i></span>
                                    <input name="contactno" placeholder="+91-9377599404" class="form-control custominputboxrander" type="text" value="<?php if (isset($_POST['contactno'])) {
    echo $_POST['contactno'];
} ?>" />
                                </div>
                                <div><?php if (isset($contactnoerror) && $contactnoerror == 1) {
    echo "<span style='color:red;font-size:14px;'>Please enter contact(+91-9377599404)</span>";
} ?></div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label customheadingrander">E-Mail</label>  
                            <div class="col-md-8 inputGroupContainer">
                                <div class="input-group">
                                    <span class="input-group-addon custominputboxrander"><i class="glyphicon glyphicon-envelope"></i></span>
                                    <input name="email" placeholder="Enter E-Mail Address" class="form-control custominputboxrander"  type="email" value="<?php if (isset($_POST['email'])) {
    echo $_POST['email'];
} ?>" />
                                </div>
                                <div><?php if (isset($emailerror) && $emailerror == 1) {
    echo "<span style='color:red;font-size:14px;'>Please enter email</span>";
} ?></div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label customheadingrander">Birth of Date</label>  
                            <div class="col-md-8 inputGroupContainer">
                                <div class="input-group">
                                    <span class="input-group-addon custominputboxrander"><i class="glyphicon glyphicon-calendar"></i></span>
                                    <input  name="dob" placeholder="mm-dd-yyyy" class="form-control custominputboxrander" type="Date" value="<?php if (isset($_POST['dob'])) {
    echo $_POST['dob'];
} ?>" />
                                </div>
                                <div><?php if (isset($doberror) && $doberror == 1) {
    echo "<span style='color:red;font-size:14px;'>Please enter date</span>";
} ?></div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label customheadingrander" >Image</label> 
                            <div class="col-md-8 inputGroupContainer">
                                <div class="container">
                                    <div class="views_container">
                                    <img id="views1" class="" title="Click to change" data-toggle="modal" data-toggle="modal" data-target="#myModal" src="<?php echo get_template_directory_uri() . '/images/user.png'; ?>" width="100px">
                                    <span class="glyphicon glyphicon-remove" id="close-span"></span>
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
                                                    <input id="file" type="file" />

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
                                <div><?php if (isset($fileuploaderror) && $fileuploaderror == 1) {
    echo "<span style='color:red;font-size:14px;'>Please choose file</span>";
} ?></div>
                            </div>
                        </div>

                    </div>

                    <div class="col-md-6">

                        <div class="form-group">
                            <label class="col-md-3 control-label customheadingrander">પૂરું નામ</label>  
                            <div class="col-md-8 inputGroupContainer">
                                <div class="input-group">
                                    <span class="input-group-addon custominputboxrander"><i class="glyphicon glyphicon-user"></i></span>
                                    <input  name="gujname" placeholder="તમારું નામ દાખલ કરો (ગુજરાતીમાં)" onkeypress="return IsAlphaNumeric(event);" ondrop="return false;" class="keyboardInput form-control custominputboxrander custom-input" type="text" autocomplete="off" value="<?php if (isset($_POST['gujname'])) {
    echo $_POST['gujname'];
} ?>" />

                                </div>
                                <div><span id="error" style="color: Red;font-size:14px;display: none">Only use Virtual keyboard </span></div>
                                <div><?php if (isset($gujnameerror) && $gujnameerror == 1) {
    echo "<span style='color:red;font-size:14px;'>Please enter name(in gujarati)</span>";
} ?></div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label customheadingrander" >સરનામું</label> 
                            <div class="col-md-8 inputGroupContainer">
                                <div class="input-group">
                                    <span class="input-group-addon custominputboxrander"><i class="glyphicon glyphicon-home"></i></span>
                                    <textarea name="gujaddress" placeholder="તમારું સરનામું દાખલ કરો(ગુજરાતીમાં)" onkeypress="return IsAlphaNumeric2(event);" ondrop="return false;" class="keyboardInput form-control custominputboxrander custom-input" value="<?php if (isset($_POST['gujaddress'])) {
    echo $_POST['gujaddress'];
} ?>" style="resize:vertical;Width:100%;" ><?php if (isset($_POST['gujaddress'])) {
                                            echo $_POST['gujaddress'];
                                        } ?></textarea>

                                </div>
                                <div><span id="error1" style="color: Red;font-size:14px;display: none">Only use Virtual keyboard </span></div>
                                <div><?php if (isset($gujaddresserror) && $gujaddresserror == 1) {
                                            echo "<span style='color:red;font-size:14px;'>Please enter address(in gujarati)</span>";
                                        } ?></div>
                            </div>
                        </div>

                        <div class="form-group"> 
                            <label class="col-md-3 control-label customheadingrander">Village</label>
                            <div class="col-md-8 selectContainer">
                                <div class="input-group">
                                    <span class="input-group-addon custominputboxrander"><i class="glyphicon glyphicon-th-large"></i></span>
                                    <select name="village" class="form-control selectpicker custominputboxrander">
                                        <option value="" >Select village</option>
<?php
$category = get_terms(array('taxonomy' => 'village', 'hide_empty' => false));
foreach ($category as $value) {
    ?>    
                                            <option <?php if (isset($_POST['village']) && $_POST['village'] == $value->term_id) {
        echo'selected="selected"';
    } ?> value="<?php echo $value->term_id; ?>"><?php echo $value->name; ?></option>
    <?php
}
?>
                                    </select>
                                </div>
                                <div><?php if (isset($villageerror) && $villageerror == 1) {
    echo "<span style='color:red;font-size:14px;'>Please enter village</span>";
} ?></div>
                            </div>
                        </div>

                        <div class="form-group"> 
                            <label class="col-md-3 control-label customheadingrander">Gender</label>
                            <div class="col-md-8 selectContainer">
                                <div class="input-group">
                                    <span class="input-group-addon custominputboxrander"><i class="glyphicon glyphicon-heart"></i></span>
                                    <select name="gender" class="form-control selectpicker custominputboxrander" style="max-width:100%;">
                                        <option value="">Select gender</option>
                                        <option <?php if (isset($_POST['gender']) && $_POST['gender'] == "male") {
    echo'selected="selected"';
} ?> value="male" >Male(પુરુષ)</option>
                                        <option <?php if (isset($_POST['gender']) && $_POST['gender'] == "female") {
    echo'selected="selected"';
} ?>  value="female" >Female(સ્ત્રી)</option>
                                    </select>
                                </div>
                                <div><?php if (isset($gendererror) && $gendererror == 1) {
    echo "<span style='color:red;font-size:14px;'>Please enter gender</span>";
} ?></div>
                            </div>
                        </div>

                        <div class="form-group"> 
                            <label class="col-md-3 control-label customheadingrander">Maritial Status</label>
                            <div class="col-md-8 selectContainer">
                                <div class="input-group">
                                    <span class="input-group-addon custominputboxrander"><i class="glyphicon glyphicon-grain"></i></span>
                                    <select name="maritalstatus" class="form-control selectpicker custominputboxrander" style="max-width:100%;">
                                        <option value="">Select marital status</option>
                                        <option <?php if (isset($_POST['maritalstatus']) && $_POST['maritalstatus'] == "married") {
    echo'selected="selected"';
} ?> value="married">Married(પરણિત)</option>
                                        <option <?php if (isset($_POST['maritalstatus']) && $_POST['maritalstatus'] == "unmarried") {
    echo'selected="selected"';
} ?> value="unmarried">Unmarried(અપરણિત)</option>
                                    </select>
                                </div>
                                <div><?php if (isset($maritalstatuserror) && $maritalstatuserror == 1) {
    echo "<span style='color:red;font-size:14px;'>Please enter marital status</span>";
} ?></div>
                            </div>
                        </div>
                        <br/>
                        <div class="form-group">
                            <label class="col-md-3 control-label"></label>
                            <div class="col-md-8"><button type="submit" id="allDatasub" name="submit" class="btn btn-block inpurButtonRander" >Register</button>
                            </div>
                        </div>

                    </div>

                </div>
            </fieldset>
        </form>
    </div>
</div>
<br/><br/><br/>
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
            setSelect: [180,180,180,180],
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
        if(jQuery("#file").val() == ''){
            alert('Please choose image');
        }else{
            applyCrop();
        }
    });
    jQuery("#rotatebutton").click(function (e) {
        if(jQuery("#file").val() == ''){
            alert('Please choose image');
        }else{
            applyRotate();
        }
    });
    jQuery("#hflipbutton").click(function (e) {
        if(jQuery("#file").val() == ''){
            alert('Please choose image');
        }else{
            applyHflip();
        }
    });
    jQuery("#vflipbutton").click(function (e) {
        if(jQuery("#file").val() == ''){
            alert('Please choose image');
        }else{
            applyVflip();
        }
    });
    
    jQuery("#getdata").click(function (e) {
        if(jQuery('#file').val()!=''){
            var c=document.getElementById("canvas");
            var d=c.toDataURL("image/png");
            jQuery('#views1').attr('src',d);
//            alert(d);
            document.getElementById("viewsimg").value = d;
            jQuery("#close-span").show();
        }
    });
    jQuery("#close-span").click(function (e) {
        jQuery("#views1").attr("src", "<?php echo get_template_directory_uri() . '/images/user.png'; ?>");
       jQuery("#close-span").hide();
    });
</script>
<?php
/* Registration form design finish */

get_footer();
?>
