<?php

/***************************************** Display business advertisement start********************************/

add_shortcode('wp_business_advertisement','display_business_add_here');

function display_business_add_here()
{
?>
	<div class="business_add">
	<h4>Business Advertisement</h4>
	<div class="flexslider">
		
<?php
$args = array(
'posts_per_page'   => 10,
'post_type' => 'business_advertiseme',
'post_status' => array( 'publish' ),
'meta_query' => array(
        array(
            'key' => 'startdate', 
            'value' => date('ymd'),
            'compare' => '<=', 
            'type' => 'DATE',
        ),
		array(
            'key' => 'enddate', 
            'value' => date('ymd'),
            'compare' => '>=', 
            'type' => 'DATE',
        ),
    ),
	'orderby' => 'meta_value_num',
	'meta_key' => 'order' 
);
$ad_data = get_posts($args);
// echo "<pre>";
// print_r($ad_data);
// echo "</pre>";
?>
<div id="thumbnail-slider">
        <div class="inner">
            <ul>
				<?php
				foreach($ad_data as $get_banner){
					// echo "<pre>";
					// print_r($get_banner);
					// echo "</pre>";
				?>	
				 <li><img class="thumb" src="<?php echo wp_get_attachment_url( get_post_thumbnail_id($get_banner->ID)); ?>" style="height:auto;" /></li>
			<!--			 <li><a class="thumb" href="<?php echo wp_get_attachment_url( get_post_thumbnail_id($get_banner->ID)); ?>"></a></li>
					<li><a class="thumb" href="#"><img src='<?php //echo wp_get_attachment_url( get_post_thumbnail_id($get_banner->ID)); ?>' width='300px' height='200px' /></a></li>-->
				<?php
				}
				?>
			</ul>
        </div>
    </div>
	</div>
</div>
<?php
}

/***************************************** Display business advertisement end********************************/

/************************ Footer start ********************************/
function display_footer_of_alone()
{
?>
	<div class="contact-contain">
            <div class="container">

                <div class="row text-center">
                    <div class="col-md-12 wow fadeInUp animated" data-wow-delay="0.4s" style="visibility: visible; animation-delay: 0.4s; animation-name: fadeInUp;">
                        <div class="head-title">
                            <h2>Contact Us</h2>
                            <span>Have a question? Do not hesitate to contact us.</span>
                        </div>
                    </div>
                </div>

                <div class="row">

                    <!-- Office Location -->
                    <div data-animate="bounceIn" class="col-xs-12 col-sm-4 col-md-4 contact-info text-center triggerAnimation animated undefined visible">
                        <i class="fa fa-map-marker"></i>
                        <h4 class="contact_title">Office Location</h4>
                        <p class="contact_description"> 

                            9/1800, Pasandgi Center,Bhula Building,<br> Balaji Road,
                            Lalgate, Surat-395003, Gujarat.
                        </p>
                    </div>


                    <!-- Call Us -->
                    <div data-animate="bounceIn" class="col-xs-12 col-sm-4 col-md-4 contact-info text-center triggerAnimation animated undefined visible">
                        <i class="fa fa-phone"></i>
                        <h4 class="contact_title">Call Us</h4>
                        <p class="contact_description">+91-999 666 3333</p>
                    </div>


                    <!-- Email Address -->
                    <div data-animate="bounceIn" class="col-xs-12 col-sm-4 col-md-4 contact-info text-center triggerAnimation animated undefined visible">
                        <i class="fa fa-envelope-o"></i>
                        <h4 class="contact_title">Email Address</h4>
                        <a href="mailto:info@natrixsoftware.com">info@socialweb.com</a>
                    </div>


                    
                </div>

              </div>
        </div>
<?php
}

add_shortcode('display_footer','display_footer_of_alone');

/************************ Footer start ********************************/

/*********************** print pdf of member start ************************/
function print_pdf_of_member( $actions ) {
    // Add custom bulk action
    $actions['print_sticker_action_handle'] = __( 'Print sticker' );
    $actions['print_action_handle'] = __( 'Print' );
    return $actions;
}
add_action( 'bulk_actions-users', 'print_pdf_of_member' );
add_filter( 'handle_bulk_actions-users', 'my_bulk_action_handler1111', 10, 3 );

function my_bulk_action_handler1111($redirect_to, $action_name, $user_ids ){
	//echo $redirect_to." -> ". $action_name . " -> ". $post_ids;
	 if ( 'print_sticker_action_handle' === $action_name ) { 
		//echo "print_sticker_action_handle";
		//print_r($user_ids);
		?>
		<div style="background-color:whitesmoke;">
			<div style="width:732px;">
			<?php
				foreach($user_ids as $val)
				{	
					$term_data = get_term(get_user_meta($val, 'village_name', true));
					$village_name = preg_replace("/[a-zA-Z]/", "", $term_data->name);
					$village_name = substr($village_name, 1, -1);
					?>
						<div style="width:232px;height:76px;float:left;border:1px solid black;padding:5px;">
							<span style="font-weight:900;font-family:'Work Sans';font-size:12px;" ><?php echo get_user_meta($val,'gujname',true); ?></span><br/>
							<span style="font-family:'Work Sans';font-size:11px;"><?php echo get_user_meta($val,'gujaddress',true); ?></span><br/>
							<span style="font-family:'Work Sans';font-size:12px;"><?php echo get_user_meta($val,'contact_num',true); ?></span>
							<span style="font-family:'Work Sans';font-size:12px;font-weight:900;float:right;"><?php echo $village_name; ?><span>
						</div>
					<?php
				}
			?>
			</div>
		</div>
	<script>
		myFunction();
		function myFunction() {
			//alert();
		window.print();
	}
	</script>
	<?php
	 }
	 else
	return $redirect_to;
}

add_filter( 'handle_bulk_actions-users', 'my_bulk_action_of_print_list', 10, 3 );

function my_bulk_action_of_print_list($redirect_to, $action_name, $user_ids ){
	//echo $redirect_to." -> ". $action_name . " -> ". $post_ids;
	 if ( 'print_action_handle' === $action_name ) { 
		//echo "print_action_handle";
		//print_r($user_ids);
		?>
		<div style="background-color:whitesmoke;">
			<div style="width:732px;">
			<?php
				foreach($user_ids as $val)
				{	
					$term_data = get_term(get_user_meta($val, 'village_name', true));
					$village_name = preg_replace("/[a-zA-Z]/", "", $term_data->name);
					$village_name = substr($village_name, 1, -1);
					?>
						<div style="height:14.28px;border:1px solid black;padding:5px;">
							<div style="width:110px;float:left;"><span style="font-weight:900;font-family:'Work Sans';font-size:12px;" ><?php echo get_user_meta($val,'gujname',true); ?></span></div>
							<div style="width:453px;float:left;"><span style="font-family:'Work Sans';font-size:11px;"><?php echo get_user_meta($val,'gujaddress',true); ?></span></div>
							<div style="width:85px;float:left;"><span style="font-family:'Work Sans';font-size:12px;"><?php echo get_user_meta($val,'contact_num',true); ?></span></div>
							<div style="width:70px;float:left;"><span style="font-family:'Work Sans';font-size:12px;font-weight:900;float:right;"><?php echo $village_name; ?><span></div>
							<div style="clear:both;"></div>
						</div>
					<?php
				}
			
			?>
			</div>
		</div>
	<script>
		myFunctionPrint();
		function myFunctionPrint() {
			//alert();
		window.print();
	}
	</script>
	<?php
	 }
	 else
	return $redirect_to;
}

/*********************** print pdf of member end ************************/

/**************************** Custom login start **************************/

function pippin_login_form_shortcode( $atts, $content = null ) {
 
	extract( shortcode_atts( array(
      'redirect' => ''
      ), $atts ) );
 
	if (!is_user_logged_in()) {
		if($redirect) {
			$redirect_url = $redirect;
		} else {
			$redirect_url = get_permalink();
		}
		$form = wp_login_form(array('echo' => false, 'redirect' => $redirect_url ));
	}else{
		$form = "<span style='color:red;'><center>User is already Log In...!</center></span>";
	}
	$err_msg='';
	if( isset( $_GET['login'] ) && $_GET['login'] == 'failed' || isset( $_GET['login'] ) && $_GET['login'] == 'empty' ) {
		$err_msg='<div id="login-error" class="err_msg"><p>Your login attempt was not successful. Please try again.</p></div>';
	}	
	return '<div class="login_tab"><h4>Login Details</h4>'.$err_msg.$form.'</div>';
}
add_shortcode('loginform', 'pippin_login_form_shortcode');

/* Where to go if a login failed */
function custom_login_failed() {
	$login_page  = home_url('/login/');
	wp_redirect($login_page . '?login=failed');
	exit;
}
add_action('wp_login_failed', 'custom_login_failed');

/* Where to go if any of the fields were empty */
function verify_user_pass($user, $username, $password) {
	$login_page  = home_url('/login/');
	if($username == "" || $password == "") {
		wp_redirect($login_page . "?login=empty");
		exit;
	}
}
add_filter('authenticate', 'verify_user_pass', 1, 3);

/* What to do on logout */
function logout_redirect() {
	$login_page  = home_url('/login/');
	wp_redirect($login_page . "?login=false");
	exit;
}
add_action('wp_logout','logout_redirect');

// Add this to functions.php
add_shortcode( 'loginerror', 'myErrorShortcode' );

function myErrorShortcode() {

    if( isset( $_GET['login'] ) && $_GET['login'] == 'failed' || isset( $_GET['login'] ) && $_GET['login'] == 'empty' ) {

        // Start "recording"
        ob_start(); ?>

        <div id="login-error">
            <p>Your login attempt was not successful. Please try again.</p>
        </div> <?php

        // Return result
        return ob_get_clean();
    }
}


/**************************** Custom login end **************************/

/**************************** Display custom user profile start **************************/

add_filter('get_avatar', 'be_gravatar_filter', 10, 5);
function be_gravatar_filter($avatar, $id , $size, $default, $alt) {
	if(get_user_meta( $id , 'user_profile', true ) != "")
	{
		$path = wp_upload_dir();
		$upload_dir = $path['baseurl'] . "/user/";
		$user_profile_image = get_user_meta($id, 'user_profile');
		$user_latest_profile_pic = max($user_profile_image);
		return "<img src='$upload_dir$user_latest_profile_pic' style='width:32px;'/>";
	}else
	{	
		return $avatar;
	}
}

/**************************** Display custom user profile end **************************/


/* * *************************** Delete currunt user family member start  ********************************* */

function delete_user_member_action() {
if ($_POST) {
$curr_user_info = get_currentuserinfo();
if ($_POST['userid'] == $curr_user_info->ID) {
//            print_r($_POST);
$userid = $_POST['userid'];
$umetaid = $_POST['umetaid'];
global $wpdb;
$wpdb->query("delete from wp_usermeta WHERE user_id = $userid AND umeta_id = $umetaid");
}
}
die();
}

add_action("wp_ajax_delete_user_member_action", "delete_user_member_action");
add_action("wp_ajax_nopriv_delete_user_member_action", "delete_user_member_action");
/* * *************************** Delete currunt user family member finish  ********************************* */


/* * *************************** Delete currunt user family member by admin start  ********************************* */

function delete_user_member_by_admin_action() {
if ($_POST) {
$userid = $_POST['userid'];
$umetaid = $_POST['umetaid'];
global $wpdb;
$wpdb->query("delete from wp_usermeta WHERE user_id = $userid AND umeta_id = $umetaid");
}
die();
}

add_action("wp_ajax_delete_user_member_by_admin_action", "delete_user_member_by_admin_action");
add_action("wp_ajax_nopriv_delete_user_member_by_admin_action", "delete_user_member_by_admin_action");
/* * *************************** Delete currunt user family member finish  ********************************* */


/* * *************************** Update user family member details by admin start  ********************************* */

function update_member_action() {
if (isset($_POST)) {
if ($_POST['img_change']) {
$imgdata = substr($_POST['img_change'], -4);
if ($imgdata == ".png") {
//                echo "img already set";
	$file = $_POST['img_change'];
} else {
//                echo "new image";
	$get_path = WP_get_custom_image_upload_path('user');
	$img = $_POST['img_change'];
	$img = str_replace('data:image/png;base64,', '', $img);
	$img = str_replace(' ', '+', $img);
	$data = base64_decode($img);
	$file = USER . uniqid() . '.png';
	$fh = fopen($get_path . $file, 'w');
	fwrite($fh, $data);
	fclose($fh);
	echo $get_path . $file;
}
}
//        print_r($_POST);
$meta_id = $_POST['umetaid'];
parse_str($_POST['alldata'], $memberarray);
//        print_r($memberarray);
$modifiedarray = array();

foreach ($memberarray as $key => $newvalue) {
$newkey = ltrim($key, 'f');
$modifiedarray[$newkey] = $newvalue;
}
//        print_r($modifiedarray);
$modifiedarray[memimgdata] = $file;

$memberdtl = serialize($modifiedarray);

global $wpdb;
$user_info = get_currentuserinfo();
//        echo "UPDATE wp_usermeta SET meta_value = '$memberdtl' WHERE user_id = $user_info->ID AND umeta_id = $meta_id";
$wpdb->query("UPDATE wp_usermeta SET meta_value = '$memberdtl' WHERE user_id = $user_info->ID AND umeta_id = $meta_id");
}
die();
}

add_action("wp_ajax_update_member_action", "update_member_action");
add_action("wp_ajax_nopriv_update_member_action", "update_member_action");
/* * *************************** Update user family member details finish  ********************************* */



/* * *************************** Update user family member details by admin start  ********************************* */

function update_member_by_admin_action() {
	if (isset($_POST)) {
		print_r($_POST);
		if ($_POST['img_change']) {
		$imgdata = substr($_POST['img_change'], -4);
			if ($imgdata == ".png") {
							echo "img already set";
				$file = $_POST['img_change'];
			}
			else 
			{
							echo "new image";
				$get_path = WP_get_custom_image_upload_path('user');
				$img = $_POST['img_change'];
				$img = str_replace('data:image/png;base64,', '', $img);
				$img = str_replace(' ', '+', $img);
				$data = base64_decode($img);
				$file = USER . uniqid() . '.png';
				$fh = fopen($get_path . $file, 'w');
				fwrite($fh, $data);
				fclose($fh);
				echo $get_path . $file;
			}
		}
		$meta_id = $_POST['umetaid'];
		//parse_str($_POST['alldata'], $memberarray);
		//print_r($_POST['alldata']);
		$memberarray = $_POST['alldata'];
		//print_r($memberarray);
		$modifiedarray = array();

		foreach ($memberarray as $key => $newvalue)
		{
			$newkey = ltrim($key, 'f');
			$modifiedarray[$newkey] = $newvalue;
		}
		print_r($modifiedarray);
		$modifiedarray[memimgdata] = $file;
		print_r($modifiedarray);
		
		 $memberdtl = serialize($modifiedarray);
		// echo $memberdtl;
		
		global $wpdb;
		echo "UPDATE wp_usermeta SET meta_value = '$memberdtl' WHERE umeta_id = $meta_id";
		$wpdb->query("UPDATE wp_usermeta SET meta_value = '$memberdtl' WHERE umeta_id = $meta_id");

	}
die();
}

add_action("wp_ajax_update_member_by_admin_action", "update_member_by_admin_action");
add_action("wp_ajax_nopriv_update_member_by_admin_action", "update_member_by_admin_action");
/* * *************************** Update user family member details by admin finish  ********************************* */



/* * *************************** Display currunt user family member start  ********************************* */

function display_user_member_action() {
if ($_POST) {
$curr_user_info = get_currentuserinfo();
if ($_POST['userid'] == $curr_user_info->ID) {
global $wpdb;
$get_member_dtl = $wpdb->get_results("SELECT um.meta_value FROM wp_users as u,wp_usermeta as um where u.ID = um.user_id AND um.meta_key = 'user_member_details' AND um.user_id = " . $_POST['userid'] . " AND um.umeta_id = " . $_POST['umetaid']);
$get = unserialize($get_member_dtl[0]->meta_value);
echo json_encode($get);
}
}
die();
}

add_action("wp_ajax_display_user_member_action", "display_user_member_action");
add_action("wp_ajax_nopriv_display_user_member_action", "display_user_member_action");
/* * *************************** Display currunt user family member finish  ********************************* */


/* * *************************** Display currunt user family member by admin start  ********************************* */

function display_user_member_by_admin_action() {
if ($_POST) {
//$curr_user_info = get_currentuserinfo();
//if ($_POST['userid'] == $curr_user_info->ID) {
global $wpdb;
$get_member_dtl = $wpdb->get_results("SELECT um.meta_value FROM wp_users as u,wp_usermeta as um where u.ID = um.user_id AND um.meta_key = 'user_member_details' AND um.user_id = " . $_POST['userid'] . " AND um.umeta_id = " . $_POST['umetaid']);
$get = unserialize($get_member_dtl[0]->meta_value);
echo json_encode($get);
//}
}
die();
}

add_action("wp_ajax_display_user_member_by_admin_action", "display_user_member_by_admin_action");
add_action("wp_ajax_nopriv_display_user_member_by_admin_action", "display_user_member_by_admin_action");
/* * *************************** Display currunt user family member by admin finish  ********************************* */



/* * *********************** Get custom image upload path function strat **************************** */

function WP_get_custom_image_upload_path($param) {
$path = wp_upload_dir();
return $upload_dir = $path['basedir'] . "/$param/";
}

/* * *********************** Get custom image upload path function finish **************************** */

/* * *************************** Add member of user family start  ********************************* */

function add_new_member_action() {
if (isset($_POST)) {
//print_r($_POST['alldata']);
parse_str($_POST['alldata'], $searcharray);
//print_r(serialize($searcharray));
//        print_r($searcharray);
//        echo $searcharray['memimgdata'];

$get_path = WP_get_custom_image_upload_path('user');
$img = $searcharray['memimgdata'];
$img = str_replace('data:image/png;base64,', '', $img);
$img = str_replace(' ', '+', $img);
$data = base64_decode($img);
$file = USER . uniqid() . '.png';
$fh = fopen($get_path . $file, 'w');
fwrite($fh, $data);
fclose($fh);
//        add_user_meta($id, 'user_profile', $file);  //add user profile
////        echo $get_path.$file;
$searcharray['memimgdata'] = $file;
//        print_r($searcharray);
$user_info = get_currentuserinfo();
//        echo $user_info->ID;
add_user_meta($user_info->ID, 'user_member_details', $searcharray);
}
die();
}

add_action("wp_ajax_add_new_member_action", "add_new_member_action");
add_action("wp_ajax_nopriv_add_new_member_action", "add_new_member_action");
/* * *************************** Add member of user family finish  ********************************* */



/* * *************************** Add member of user family by admin start  ********************************* */

function add_new_member__by_admimn_action() {
	if (isset($_POST)) {
		//echo "************99999";
		//print_r($_POST['alldata']);
		//print_r(serialize($_POST['alldata']));
		$searcharray = $_POST['alldata'];

		$get_path = WP_get_custom_image_upload_path('user');
		$img = $searcharray['memimgdata'];
		$img = str_replace('data:image/png;base64,', '', $img);
		$img = str_replace(' ', '+', $img);
		$data = base64_decode($img);
		$file = USER . uniqid() . '.png';
		$fh = fopen($get_path . $file, 'w');
		fwrite($fh, $data);
		fclose($fh);

		$searcharray['memimgdata'] = $file;
			   echo $_POST['uid'];
			   
		//$s_searcharray = serialize($searcharray);
		print_r($searcharray);

		add_user_meta($_POST['uid'], 'user_member_details', $searcharray);
	}
	die();
}

add_action("wp_ajax_add_new_member__by_admimn_action", "add_new_member__by_admimn_action");
add_action("wp_ajax_nopriv_add_new_member__by_admimn_action", "add_new_member__by_admimn_action");
/* * *************************** Add member of user family by admin finish  ********************************* */



/* * *************************** Register File upload start  ********************************* */

function save_poem_image() {
if ($_POST) {
$get_path = WP_get_custom_image_upload_path('user');
$img = $_POST['img'];
$img = str_replace('data:image/png;base64,', '', $img);
$img = str_replace(' ', '+', $img);
$data = base64_decode($img);
$file = USER . uniqid() . '.png';
$fh = fopen($get_path . $file, 'w');
fwrite($fh, $data);
fclose($fh);
add_user_meta($id, 'user_profile', $file);  //add user profile
echo $get_path . $file;
}
die();
}

add_action("wp_ajax_save_poem_image", "save_poem_image");
add_action("wp_ajax_nopriv_save_poem_image", "save_poem_image");
/* * *************************** Register File upload finish  ********************************* */


//***************************Finish Committee member display in English source **************************
/* english */
add_action('wp_ajax_demo_load_my_posts_committee', 'demo_load_my_posts_committee');
add_action('wp_ajax_nopriv_demo_load_my_posts_committee', 'demo_load_my_posts_committee');

function demo_load_my_posts_committee() {
global $wpdb;

$msg = '';

if (!empty($_POST['data']['dropsearch'])) {
$min = substr($_POST['data']['dropsearch'], 0, 4) . "<br>";
$max = substr($_POST['data']['dropsearch'], 5, 9);
$args = array(
'orderby' => 'order_clause',
'meta_query' => array(
	array(
		'key' => 'pw_user_status',
		'value' => 'approved',
		'compare' => '==',
	),
	array(
		'key' => 'designation',
		'value' => array('president', 'secretary'),
		'compare' => 'IN',
	),
	array(
		'key' => 'fromyear',
		'value' => $max,
		'type' => 'NUMERIC',
		'compare' => '<='
	),
	array(
		'key' => 'toyear',
		'value' => $min,
		'type' => 'NUMERIC',
		'compare' => '>=',
	),
	'order_clause' => array(
		'key' => 'designation',
		'value' => array('president', 'secretary'),
	),
),
);
} else {
$args = array(
'orderby' => 'order_clause',
'meta_query' => array(
	array(
		'key' => 'pw_user_status',
		'value' => 'approved',
		'compare' => '=='
	),
	array(
		'key' => 'designation',
		'value' => array('president', 'secretary'),
	),
	'order_clause' => array(
		'key' => 'designation',
		'value' => array('president', 'secretary'),
	),
),
);
}
$query = get_users($args);
// Check if our query returns anything.
if ($query):
$msg .= '<div class="custom_img_container">';

foreach ($query as $user) { //get all user information using pagination arguument
$user_details = get_usermeta($user->ID);

$path = wp_upload_dir();
$get_path = $path['baseurl'] . "/user/";

$user_profile_image = get_user_meta($user->ID, 'user_profile');
$user_latest_profile_pic = max($user_profile_image);

$term_data = get_term(get_user_meta($user->ID, 'village_name', true));

$village_name = preg_replace("/[^a-zA-Z]/", "", $term_data->name);

$msg .= '<center><div class="commitymemberCustomRander">
	
			<div>
				<div class="commitymembercontent committy_member_container">
					 <img src="' . $get_path . $user_latest_profile_pic . '" class="img committeeimg" alt="Member image" />
				</div>
				<div class="commitymemberheadingcontent">
					<span>' . get_user_meta($user->ID, 'designation', true) . '</span>
				</div>
				<div class="commitymembercontent">
					<span>' . get_user_meta($user->ID, 'eng_name', true) . '</span>
				</div>
				<div class="commitymembercontent">
					<span>' . $village_name . '</span>
				</div>
				<div class="commitymembercontent">
					<span>' . get_user_meta($user->ID, 'contact_num', true) . '</span>
				</div>
			</div>
</div></center>';
}

$msg .= '</div>';

// If the query returns nothing, we throw an error message
else:
$msg .= '<center><img src="' . get_bloginfo('template_directory') . '/images/404.gif" class="custom_404"/></center>';
endif;

$msg = "<div class='cvf-universal-content'>" . $msg . "</div><br class = 'clear' />";

echo '<div class = "cvf-pagination-content">' . $msg . '</div>';


die();
}

//***************************Finish Committee member display in English source **************************
//***************************Finish Committee member display in English source **************************
/* english */
add_action('wp_ajax_demo_load_my_posts_committee_guj', 'demo_load_my_posts_committee_guj');
add_action('wp_ajax_nopriv_demo_load_my_posts_committee_guj', 'demo_load_my_posts_committee_guj');

function demo_load_my_posts_committee_guj() {
global $wpdb;

$msg = '';

if (!empty($_POST['data']['dropsearch'])) {
$min = substr($_POST['data']['dropsearch'], 0, 4) . "<br>";
$max = substr($_POST['data']['dropsearch'], 5, 9);
$args = array(
'orderby' => 'order_clause',
'meta_query' => array(
	array(
		'key' => 'pw_user_status',
		'value' => 'approved',
		'compare' => '==',
	),
	array(
		'key' => 'designation',
		'value' => array('president', 'secretary'),
		'compare' => 'IN',
	),
	array(
		'key' => 'fromyear',
		'value' => $max,
		'type' => 'NUMERIC',
		'compare' => '<='
	),
	array(
		'key' => 'toyear',
		'value' => $min,
		'type' => 'NUMERIC',
		'compare' => '>=',
	),
	'order_clause' => array(
		'key' => 'designation',
		'value' => array('president', 'secretary'),
	),
),
);
} else {
$args = array(
'orderby' => 'order_clause',
'meta_query' => array(
	array(
		'key' => 'pw_user_status',
		'value' => 'approved',
		'compare' => '=='
	),
	array(
		'key' => 'designation',
		'value' => array('president', 'secretary'),
	),
	'order_clause' => array(
		'key' => 'designation',
		'value' => array('president', 'secretary'),
	),
),
);
}
$query = get_users($args);

// Check if our query returns anything.
if ($query):
$msg .= '<div class="custom_img_container">';

foreach ($query as $user) { //get all user information using pagination arguument
$user_details = get_usermeta($user->ID);
$path = wp_upload_dir();
$get_path = $path['baseurl'] . "/user/";
$user_profile_image = get_user_meta($user->ID, 'user_profile');
$user_latest_profile_pic = max($user_profile_image);

$term_data = get_term(get_user_meta($user->ID, 'village_name', true));

$village_name = preg_replace("/[a-zA-Z]/", "", $term_data->name);
$village_name = substr($village_name, 1, -1);

if (get_user_meta($user->ID, 'designation', true) == "president") {
	$desig = "પ્રમુખ શ્રી";
} else {
	$desig = "મંત્રી શ્રી";
}

$msg .= '<center><div class="commitymemberCustomRander">
	
			<div>
				<div class="commitymembercontent committy_member_container">
					 <img src="' . $get_path . $user_latest_profile_pic . '" class="img committeeimg" alt="Member image" />
				</div>
				<div class="commitymemberheadingcontent">
					<span style="font-weight:bold;">' . $desig . '</span>
				</div>
				<div class="commitymembercontent">
					<span>' . get_user_meta($user->ID, 'gujname', true) . '</span>
				</div>
				<div class="commitymembercontent">
					<span>' . $village_name . '</span>
				</div>
				<div class="commitymembercontent">
					<span>' . get_user_meta($user->ID, 'contact_num', true) . '</span>
				</div>
			</div>
</div></center>';
}

$msg .= '</div>';

// If the query returns nothing, we throw an error message
else:
$msg .= '<center><img src="' . get_bloginfo('template_directory') . '/images/404.gif" class="custom_404"/></center>';
endif;

$msg = "<div class='cvf-universal-content'>" . $msg . "</div><br class = 'clear' />";

echo '<div class = "cvf-pagination-content">' . $msg . '</div>';


die();
}

//***************************Finish Committee member display in English source **************************

//***************Add additional field in edit-user page(Admin side) start*********************

add_action('show_user_profile', 'extra_user_profile_fields');
add_action('edit_user_profile', 'extra_user_profile_fields');

function extra_user_profile_fields($user) {

?>
<h3><?php _e("Add User Designation", "blank"); ?></h3>

	<table class="form-table">
		<tr>
		<th><label for="Designation"><?php _e("Designation"); ?></label></th>
		<td>
			<select name="designation" id="designation" class="regular-text" >
				<option value="">--Select--</option>
				<option <?php
		if (esc_attr(get_the_author_meta('designation', $user->ID)) == "president") {
		echo'selected="selected"';
		}
		?> value="president">President</option>
				<option <?php
			if (esc_attr(get_the_author_meta('designation', $user->ID)) == "secretary") {
				echo'selected="selected"';
			}
		?> value="secretary">Secretary</option>
			</select><br />
			<span class="description"><?php _e("Please select user designation"); ?></span>
		</td>
		</tr>
		<tr>
		<th><label for="Fromyear"><?php _e("From year"); ?></label></th>
		<td>
			<input type="text" name="fromyear" id="fromyear" class="regular-text" value="<?php echo esc_attr(get_the_author_meta('fromyear', $user->ID)); ?>" /><br />
			<span class="description"><?php _e("Please enter from year"); ?></span>
		</td>
		</tr>
		<tr>
		<th><label for="To year"><?php _e("To year"); ?></label></th>
		<td>
			<input type="text" name="toyear" id="toyear" class="regular-text" value="<?php echo esc_attr(get_the_author_meta('toyear', $user->ID)); ?>" /><br />
			<span class="description"><?php _e("Please enter to year"); ?></span>
		</td>
		</tr>
		</table>

<!--***************Add additional field in edit-user page(Admin side) Finish*********************

******************Add profile and family member in edit-user.php(Admin side) start***********-->

<h3><?php _e("User Profile", "blank"); ?></h3>	
<table class="form-table" id="formDiv">
		<tr>
			<th><label for="Designation"><?php _e("Name(English)"); ?></label></th>
			<td>
				<input type="hidden" name="upuserid" id="upuserid" value="<?php echo $user->ID; ?>" />
				<input type="text" name="upengname" onblur="javascript: wp_user_validation();"  id="upengname" value="<?php echo get_user_meta($user->ID, 'eng_name', true); ?>" class="regular-text"  />
				<span id="engnameerror" style="color: Red;font-size:14px;display: none;">Name(Eng.) is required</span>
			</td>
		</tr>
		
		<tr>
			<th><label><?php _e("Name(Gujarati)"); ?></label></th>
			<td>
				<div style="position:relative;width:500px">
				<span class="usercommonfont" style="position:relative"><input type="text" name="upgujname" id="upgujname" value="<?php echo get_user_meta($user->ID, 'gujname', true); ?>" onkeypress="return IsAlphaNumeric(event);" ondrop="return false;" onblur="javascript: wp_user_validation();" class="keyboardInput custom-input" /></span>
				</div>
				<div>
				<span id="error" style="color: Red;font-size:14px;display: none;"> Only use Virtual keyboard </span>
				<span id="gujnameerror" style="color: Red;font-size:14px;display: none;"> Name(Guj.) is required</span>
				</div>
			</td>
		</tr>
		
		<tr>
			<th><label><?php _e("Contact Number"); ?></label></th>
			<td>
			<span class="usercommonfont"><input type="text" name="upcontactnum" id="upcontactnum" onkeypress="phoneno()" onblur="javascript: wp_user_validation();" maxlength="14" value="<?php echo get_user_meta($user->ID, 'contact_num', true); ?>" /></span>
			<span id="contactnumerror" style="color: Red;font-size:14px;display: none;">Contact number is required</span>
			</td>
		</tr>
		
		<tr>
			<th><label><?php _e("DOB"); ?></label></th>
			<td>
				<span class="usercommonfont"><input name="updob" id="updob" onblur="javascript: wp_user_validation();" placeholder="mm-dd-yyyy"  type="Date" value="<?php echo get_user_meta($user->ID, 'dob', true); ?>" /></span><span id="doberror" style="color: Red;font-size:14px;display: none;">Name is required</span>
			</td>
		</tr>
		
		<tr>
			<th><label><?php _e("Address(Eng.)"); ?></label></th>
			<td>
				<span class="usercommonfont"><textarea name="upengadd" id="upengadd" onblur="javascript: wp_user_validation();" value="<?php echo get_user_meta($user->ID, 'address', true); ?>"><?php echo get_user_meta($user->ID, 'address', true); ?></textarea></span><span id="engadderror" style="color: Red;font-size:14px;display: none;">Address(Eng.) is required</span>
			</td>
		</tr>

		<tr>
			<th><label><?php _e("Address(Guj.)"); ?></label></th>
			<td>
			<div style="position:relative">
			<span class="usercommonfont"><textarea onblur="javascript: wp_user_validation();" onkeypress="return IsAlphaNumeric2(event);" ondrop="return false;" class="keyboardInput custom-input" name="upgujadd" id="upgujadd" value="<?php echo get_user_meta($user->ID, 'gujaddress', true); ?>"><?php echo get_user_meta($user->ID, 'gujaddress', true); ?></textarea>
			</span>
			</div>
			<div><span id="error1" style="color: Red;font-size:14px;display: none;"> Only use Virtual keyboard </span></div><span id="gujadderror" style="color: Red;font-size:14px;display: none;">Address(Guj.) is required</span>
			</td>
		</tr>
		
		<tr>
			<th><label><?php _e("village"); ?></label></th>
			<td>
			<select name="upvillage" id="upvillage" class="usercommonfont" onchange="javascript: wp_user_validation();">
				<option value="" >Select village</option>
				<?php
				$category = get_terms(array('taxonomy' => 'village', 'hide_empty' => false));
				foreach ($category as $value) {
					?>    
					<option <?php
					if (get_user_meta($user->ID, 'village_name', true) == $value->term_id) {
						echo'selected="selected"';
					}
					?> value="<?php echo $value->term_id; ?>"><?php echo $value->name; ?></option>
						<?php
					}
					?>
			</select><span id="upvillageerror" style="color: Red;font-size:14px;display: none;">Please choose village</span>
			</td>
		</tr>

		<tr>
			<th><label><?php _e("Gender"); ?></label></th>
			<td>
			<select name="upgen" id="upgen" class="usercommonfont" onchange="javascript: wp_user_validation();">
				<option value="">Select gender</option>
				<option <?php
				if (get_user_meta($user->ID, 'gender', true) == "male") {
					echo'selected="selected"';
				}
				?> value="male" >Male(પુરૂષ)</option>
				<option <?php
				if (get_user_meta($user->ID, 'gender', true) == "female") {
					echo'selected="selected"';
				}
				?>  value="female" >Female(સ્ત્રી)</option>
			</select>
			<span id="upgenerror" style="color: Red;font-size:14px;display: none;">Please choose gender</span>
			</td>
		</tr>

		<tr>
			<th><label><?php _e("Marital Status"); ?></label></th>
			<td>
			<select name="upmastatus" id="upmastatus" class="usercommonfont" onchange="javascript: wp_user_validation();">
				<option value="">Select marital status</option>
				<option <?php
				if (get_user_meta($user->ID, 'maritalstatus', true) == "married") {
					echo'selected="selected"';
				}
				?> value="married">Married(પરણિત)</option>
				<option <?php
				if (get_user_meta($user->ID, 'maritalstatus', true) == "unmarried") {
					echo'selected="selected"';
				}
				?> value="unmarried">Unmarried(અપરિણિત)</option>
			</select><span id="mastatuserror" style="color: Red;font-size:14px;display: none;">Please choose Maritul status</span>
			</td>
		</tr>
		
		<tr>
			<th><label><?php _e("Profile"); ?></label></th>
			<td>
				<div class="">
                    <div class="views_container">
					<?php
						$user_profile_image = get_user_meta($user->ID, 'user_profile');
						//print_r($user_profile_image);
						$user_latest_profile_pic = max($user_profile_image);
						$path = wp_upload_dir();
						$get_path = $path['baseurl'] . "/user/" . $user_latest_profile_pic;
						//echo $get_path;
		
                        if ($user_latest_profile_pic == "") {
                            ?>
                            <img id="views1" title="Click to change" src="<?php echo get_template_directory_uri() . '/images/blank_user.png'; ?>" width="100px">
                            <?php
                        } else {
                            ?>
                            <img id="views1" class="" title="User Profile" src="<?php echo $get_path; ?>" width="100px" />
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
                    <input type="hidden" id="viewsimg" value="<?php echo $user_latest_profile_pic; ?>" name="imgdata" />
                </div>
			</td>
		</tr>
	</table>
	
<h3><?php _e("Add User Family Member", "blank"); ?></h3>	
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal1"><i class="fa fa-plus"></i> Add Member</button>
<div class="modal fade" id="myModal1" role="dialog">
                            <div class="modal-dialog">
<!-- Modal content-->
<div class="modal-content">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal">&times;</button>
		<h3 class="modal-title">Member Entry</h3>
	</div>
<div class="modal-body">
<p>

<div class="row form-group">
	<div class="col-md-6 col-sm-12 col-xs-12">
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 form-group">
			<label>Name(English) :</label>
			<span class="usercommonfont">
				<input type="text" name="memberengname" id="memberengname" value="" class="form-control" placeholder="Enter name(Eng.)" />
			</span><br/><br/><br/>
			<span id="aengnameerror" style="color: Red;font-size:14px;display: none;">Name is required</span>
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
			</select><br/><br/><br/>
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
	
</div>
</div>
</div>
</div>
</div>


<h3><?php _e("Display User Family Member", "blank"); ?></h3>

            <!--user member display-->
            <?php
            //echo $user->ID."****";
            global $wpdb;
            $all_member = $wpdb->get_results("SELECT um.* FROM wp_users as u,wp_usermeta as um where u.ID = um.user_id AND um.meta_key = 'user_member_details' AND um.user_id = $user->ID");
           // echo '<pre>';
           // print_r(unserialize($all_member[0]->meta_value));
           // echo '</pre>';

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
    
<!--Update family member**********-->

<div class="modal fade" id="fmemberModal" role="dialog">
	<div class="modal-dialog">

	<!-- Modal content-->
	<div class="modal-content">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal">&times;</button>
			<h4 class="modal-title">Update Member Details</h4>
		</div>
		<div class="modal-body">
				<div class="row form-group">
					<div class="col-md-6 col-sm-12 col-xs-12">
						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 form-group">
							<label>Name(English) :</label>
							<span class="usercommonfont">
								<input type="hidden" name="fmemberengid" id="fmemberengid" value="" />
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
								<input type="text" name="fmembergujname" id="fmembergujname" value="" onkeypress="return fIsAlphaNumeric4(event);" ondrop="return false;" class="keyboardInput form-control custom-keyboard" placeholder="Enter Name(Guj.)" />
								<span id="fmembergujnameerror" style="color: Red;font-size:14px;display: none;">Name is required(in Gujarati)</span>
								<span id="ferror4" style="color: Red;font-size:14px;display: none;">Only use Virtual keyboard </span>
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

					
				</div>
				<div class="modal-footer">
					<button type="submit" class="btn btn-success" id="faddMember">Update</button>
					<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
				</div>
		</div>
		
	</div>
	</div>
</div>


<style>
	#profile-page .usercommonfont img{ top: 9px;}
	#profile-page .usercommonfont{position:relative; float: left;}
</style>	

<script>

		//Delete Member by admin

		 function DeleteMemberInfo(userid, data)
    {
       //alert(userid + "---" + data);
        // var txt;
        var r = confirm("Are you sure want to delete this User ?");
        if (r == true) {
            metaid = data;
        var ajaxurl = '<?php echo admin_url('admin-ajax.php'); ?>';
        jQuery.ajax({
            url: ajaxurl,
            data: {action: 'delete_user_member_by_admin_action', userid: userid, umetaid: data},
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

		

        // update member by admin
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
                
				var um_id = document.getElementById('fmemberengid').value;
				//alert(um_id + "um_id id");
				var data =	{};
				data["fmemberengname"] = document.getElementById('fmemberengname').value;
				data["fmemberrelationtype"] = document.getElementById('fmemberrelationtype').value;
				data["fmembervillage"] = document.getElementById('fmembervillage').value;
				data["fmembergender"] = document.getElementById('fmembergender').value;
				data["fmembermaritalstatus"] = document.getElementById('fmembermaritalstatus').value;
				data["fmembercontactno"] = document.getElementById('fmembercontactno').value;
				data["fmembergujname"] = document.getElementById('fmembergujname').value;
				data["fmemberdob"] = document.getElementById('fmemberdob').value;
				data["fmemberemail"] = document.getElementById('fmemberemail').value;
								
                var imgchange = document.getElementById('fmemviewsimg').value;
                //alert(imgchange);
                console.log(data);
                var ajaxurl = '<?php echo admin_url('admin-ajax.php'); ?>';
                jQuery.ajax({
                    url: ajaxurl,
                    data: {action: 'update_member_by_admin_action', alldata: data, umetaid: um_id, img_change: imgchange},
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



//Display Member 
    function displayMemberInfo(userid, data)
    {
        //alert(userid + "---" + data);
        metaid = data;
		//alert(metaid);
        var ajaxurl = '<?php echo admin_url('admin-ajax.php'); ?>';
        jQuery.ajax({
            url: ajaxurl,
            data: {action: 'display_user_member_by_admin_action', userid: userid, umetaid: data},
            type: "POST",
            dataType: "json",
            success: function (data1) {
                console.log(data1);
               // console.log(data1['membercontactno']);
                document.getElementById("fmemberengid").value = metaid;
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


//            Form data of add new member
        jQuery('#addMember').on('click', function () {
            event.preventDefault();
            var error1, error2, error3, error4, error5, error6, error7, error8, error9;

            if (jQuery("#memberengname").val() == "") {
                document.getElementById("aengnameerror").style.display = "inline";
                error1 = 1;
            } else
            {
                document.getElementById("aengnameerror").style.display = "none";
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
			// alert(document.getElementById('memberengname').value );
			
			var data =	{};
			data["memberengname"] = document.getElementById('memberengname').value;
			data["memberrelationtype"] = document.getElementById('memberrelationtype').value;
			data["membervillage"] = document.getElementById('membervillage').value;
			data["membergender"] = document.getElementById('membergender').value;
			data["membermaritalstatus"] = document.getElementById('membermaritalstatus').value;
			data["membercontactno"] = document.getElementById('membercontactno').value;
			data["membergujname"] = document.getElementById('membergujname').value;
			data["memberdob"] = document.getElementById('memberdob').value;
			data["memberemail"] = document.getElementById('memberemail').value;
			data["memimgdata"] = document.getElementById('memviewsimg').value;
			
			uid = document.getElementById('upuserid').value;
			//alert(uid);
			
			//console.log(data.serialize());
			console.log(data);
                var ajaxurl = '<?php echo admin_url('admin-ajax.php'); ?>';
                jQuery.ajax({
                    url: ajaxurl,
                    data: {action: 'add_new_member__by_admimn_action', alldata: data, uid : uid},
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
			else{
				alert('error');
			}
        });
   

jQuery('#your-profile').submit(function(e){
	if(! wp_user_validation()){
		e.preventDefault();
	}
});
function wp_user_validation()
{
	var flag=true;

	if (jQuery("#upengname").val() == "") {
		document.getElementById("engnameerror").style.display = "inline";
		flag=false;
		$("#upengname").focus();
	} else
	{
		document.getElementById("engnameerror").style.display = "none";
	}
	
	if (jQuery("#upgujname").val() == "") {
		document.getElementById("gujnameerror").style.display = "inline";
		flag=false;
		$("#upgujname").focus();
	}
	else
	{
		document.getElementById("gujnameerror").style.display = "none";
	}
	
	if (jQuery("#upcontactnum").val() == "") {
		document.getElementById("contactnumerror").style.display = "inline";
		flag=false;
		$("#upcontactnum").focus();
	}
	else
	{
		document.getElementById("contactnumerror").style.display = "none";
	}
	
	if (jQuery("#updob").val() == "") {
		document.getElementById("doberror").style.display = "inline";
		flag=false;
		$("#updob").focus();
	}
	else
	{
		document.getElementById("doberror").style.display = "none";
	}
	
	if (jQuery("#upengadd").val() == "") {
		document.getElementById("engadderror").style.display = "inline";
		flag=false;
		$("#upengadd").focus();
	}
	else
	{
		document.getElementById("engadderror").style.display = "none";
	}
	
	if (jQuery("#upgujadd").val() == "") {
		document.getElementById("gujadderror").style.display = "inline";
		flag=false;
		$("#upgujadd").focus();
	}
	else
	{
		document.getElementById("gujadderror").style.display = "none";
	}
	
	if (jQuery("#upvillage").val() == "") {
		document.getElementById("upvillageerror").style.display = "inline";
		flag=false;
		$("#upvillage").focus();
	}
	else
	{
		document.getElementById("upvillageerror").style.display = "none";
	}
	if (jQuery("#upgen").val() == "") {
		document.getElementById("upgenerror").style.display = "inline";
		flag=false;
		$("#upgen").focus();
	}
	else
	{
		document.getElementById("upgenerror").style.display = "none";
	}
	
	if (jQuery("#upmastatus").val() == "") {
		document.getElementById("mastatuserror").style.display = "inline";
		flag=false;
		$("#upmastatus").focus();
	}
	else
	{
		document.getElementById("mastatuserror").style.display = "none";
	}
	
	return flag;
	
}

function phoneno() {
        jQuery('#upcontactnum').keypress(function (e) {
            var a = [];
            var k = e.which;

            for (i = 43; i < 58; i++)
                a.push(i);

            if (!(a.indexOf(k) >= 0))
                e.preventDefault();
        });
		
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
	
	function fIsAlphaNumeric4(e) {
               // alert('');
        var keyCode = e.keyCode == 0 ? e.charCode : e.keyCode;
        var ret = (!(keyCode >= 0 && keyCode <= 127) || specialKeys.indexOf(keyCode) != -1);
        document.getElementById("ferror4").style.display = ret ? "none" : "inline";
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
                   // jQuery(".close-spann").show();
        }
    });
    jQuery("#fmemgetdata").click(function () {
        jQuery('#fmemberimageModal').modal('hide');

        if (jQuery('#fmemfile').val() != '') {
            var c = document.getElementById("canvas2");
            var d = c.toDataURL("image/png");
            jQuery('#viewsImgOfFamilymember').attr('src', d);
            document.getElementById("fmemviewsimg").value = d;
                   // jQuery(".close-spann").show();
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
	
	//alert(document.getElementById('imgdata').value );

</script>
<?php
}

add_action('personal_options_update', 'save_extra_user_profile_fields');
add_action('edit_user_profile_update', 'save_extra_user_profile_fields');

function save_extra_user_profile_fields($user_id) {
	if (!current_user_can('edit_user', $user_id)) {
		return false;
	}
	update_user_meta($user_id, 'designation', $_POST['designation']);
	update_user_meta($user_id, 'fromyear', $_POST['fromyear']);
	update_user_meta($user_id, 'toyear', $_POST['toyear']);
	
	update_user_meta($user_id, 'eng_name', $_POST['upengname']);
	update_user_meta($user_id, 'gujname', $_POST['upgujname']);
	update_user_meta($user_id, 'contact_num', $_POST['upcontactnum']);
	update_user_meta($user_id, 'dob', $_POST['updob']);
	//update_user_meta($user_id, 'eamil', $_POST['upemail']);
	update_user_meta($user_id, 'address', $_POST['upengadd']);
	update_user_meta($user_id, 'gujaddress', $_POST['upgujadd']);
	update_user_meta($user_id, 'village_name', $_POST['upvillage']);
	update_user_meta($user_id, 'gender', $_POST['upgen']);
	update_user_meta($user_id, 'maritalstatus', $_POST['upmastatus']);
	
	if ($_POST['imgdata']) 
	{
		$imgdata = substr($_POST['imgdata'], -4);
		if ($imgdata == ".png") {
			$file = $_POST['imgdata'];
		}
		else
		{
			$get_path = WP_get_custom_image_upload_path('user');
			$img = $_POST['imgdata'];
			$img = str_replace('data:image/png;base64,', '', $img);
			$img = str_replace(' ', '+', $img);
			$data = base64_decode($img);
			$file = USER . uniqid() . '.png';
			$fh = fopen($get_path . $file, 'w');
			fwrite($fh, $data);
			fclose($fh);
			add_user_meta($user_id, 'user_profile', $file);
		}
	}
}

//***************Add profile and family member in edit-user.php page(Admin side) Finish*********************




//***************************Start member display source **************************
/* english */
add_action('wp_ajax_demo_load_my_posts', 'demo_load_my_posts');
add_action('wp_ajax_nopriv_demo_load_my_posts', 'demo_load_my_posts');

function demo_load_my_posts() {
//echo "******";
//die();
global $wpdb;
$msg = '';

if (isset($_POST['data']['page'])) {
	//print_r($_POST);
	//die();
	// Always sanitize the posted fields to avoid SQL injections
	$page = sanitize_text_field($_POST['data']['page']); // The page we are currently at
	//echo $page;
	$name = sanitize_text_field($_POST['data']['th_name']); // The name of the column name we want to sort
	//echo $name;
	$sort = sanitize_text_field($_POST['data']['th_sort']); // The order of our sort (DESC or ASC)
	$cur_page = $page;
	$page -= 1;
	$per_page = 3; // Number of items to display per page
	$previous_btn = true;
	$next_btn = true;
	$first_btn = true;
	$last_btn = true;
	$start = $page * $per_page;

	// The table we are querying from   
	$posts = $wpdb->prefix . "users";
	$posts_meta = $wpdb->prefix . "usermeta";
	//echo $posts;

	$where_search = '';
	//echo "hi00000000000000000";
	//echo $_POST['data']['search'];
	
	// Check if there is a string inputted on the search box
	if (!empty($_POST['data']['search'])) {
	// If a string is inputted, include an additional query logic to our main query to filter the results
	$search = $_POST['data']['search'];
	$custom_id = "SELECT wp_users.ID FROM wp_users JOIN wp_usermeta ON wp_users.ID = wp_usermeta.user_id WHERE wp_usermeta.meta_key = 'address' AND (wp_usermeta.meta_value LIKE '%%$search%%') OR wp_usermeta.meta_key = 'gujaddress' AND (wp_usermeta.meta_value LIKE '%%$search%%') OR wp_usermeta.meta_key = 'contact_num' AND (wp_usermeta.meta_value LIKE '%%$search%%') OR wp_usermeta.meta_key = 'eng_name' AND (wp_usermeta.meta_value LIKE '%%$search%%') OR wp_usermeta.meta_key = 'gujname' AND (wp_usermeta.meta_value LIKE '%%$search%%') AND user_status = 0 ORDER BY user_login ASC";
	$pageposts = $wpdb->get_results($custom_id, ARRAY_A);
		foreach ($pageposts as $key => $value) {
			$array_find[] = $value['ID'];
		}
	$all_custom_search_ids = implode(", ", $array_find);
	$where_search = ' AND (user_login LIKE "%%' . $_POST['data']['search'] . '%%" OR display_name LIKE "%%' . $_POST['data']['search'] . '%%")';
	//$where_search = ' AND (user_login LIKE "%%' . $_POST['data']['search'] . '%%" OR display_name LIKE "%%' . $_POST['data']['search'] . '%%" OR ID IN (' . $all_custom_search_ids . '))';
	//echo $where_search;
	}

	if (!empty($_POST['data']['dropsearch'])) {
	$dropsearch = $_POST['data']['dropsearch'];
	//echo $dropsearch;
	$custom_idd = "SELECT wp_users.ID FROM wp_users JOIN wp_usermeta ON wp_users.ID = wp_usermeta.user_id WHERE wp_usermeta.meta_key = 'village_name' AND (wp_usermeta.meta_value LIKE '%%$dropsearch%%') AND user_status = 0 ORDER BY user_login ASC";
	$pagepostss = $wpdb->get_results($custom_idd, ARRAY_A);
		foreach ($pagepostss as $key => $value) {
			$array_findd[] = $value['ID'];
		}
	$all_custom_search_idss = implode(", ", $array_findd);
	if($all_custom_search_idss!="")
	{
		$where_searchh = ' AND (ID IN (' . $all_custom_search_idss . '))';
	}else{
		$where_searchh = ' AND (ID IN (1))';
	}	
	//echo $where_searchh;
	}
//die();
	// Retrieve all the posts
	$all_posts = $wpdb->get_results($wpdb->prepare("
	SELECT wp_users.* FROM wp_users JOIN wp_usermeta ON wp_users.ID = wp_usermeta.user_id WHERE wp_usermeta.meta_key = 'pw_user_status' AND (wp_usermeta.meta_value LIKE '%%approved%%') AND ID != 1 $where_search $where_searchh ORDER BY $name $sort LIMIT %d, %d", $start, $per_page));

  //  echo "SELECT wp_users.* FROM wp_users JOIN wp_usermeta ON wp_users.ID = wp_usermeta.user_id WHERE wp_usermeta.meta_key = 'pw_user_status' AND (wp_usermeta.meta_value LIKE '%%approved%%') AND ID != 1 $where_search $where_searchh ORDER BY $name $sort";
	//die();
	//        print_r($all_posts);
	$count = $wpdb->get_var($wpdb->prepare("
	SELECT COUNT(wp_users.ID) FROM wp_users JOIN wp_usermeta ON wp_users.ID = wp_usermeta.user_id WHERE wp_usermeta.meta_key = 'pw_user_status' AND (wp_usermeta.meta_value LIKE '%%approved%%') AND ID != 1 $where_search $where_searchh ", array()));
	//        echo $count;
	//        echo "SELECT COUNT(wp_users.ID) FROM wp_users JOIN wp_usermeta ON wp_users.ID = wp_usermeta.user_id WHERE wp_usermeta.meta_key = 'pw_user_status' AND (wp_usermeta.meta_value LIKE '%%approved%%') AND ID != 1 $where_search $where_searchh";
	// set for member detail in english
	if (isset($_POST['data']['eng_col'])) {

	// Check if our query returns anything.

	$member_path = get_site_url() . "/display-user-member-info";

		if ($all_posts){
			$msg .= '<div class="row"><table class = "table custom-table-body table-responsive table-striped table-hover table-file-list">';

			foreach ($all_posts as $user) { //get all user information using pagination arguument
				$user_details = get_usermeta($user->ID);
				//print_r($user_details);
				//echo get_user_meta($user->ID,'eng_name',true);

				$term_data = get_term(get_user_meta($user->ID, 'village_name', true));

				$path = wp_upload_dir();
				$get_path = $path['baseurl'] . "/user/";

				$user_profile_image = get_user_meta($user->ID, 'user_profile');
				$user_latest_profile_pic = max($user_profile_image);

				$msg .= '
			<tr class="memberCustomRander memberdispalycenter">
				<td  class="memberdispalycenter"><img src="' . $get_path.$user_latest_profile_pic . '" class="img img-responsiv" alt="Member Image" width="80" height="80" /></td>
				<td  class="memberdispalycenter">' . get_user_meta($user->ID, 'eng_name', true) . '</td>
				<td  class="memberdispalycenter">' . get_user_meta($user->ID, 'address', true) . '</td>
				<td  class="memberdispalycenter">' . get_user_meta($user->ID, 'gender', true) . '</td>
				<td  class="memberdispalycenter">' . get_user_meta($user->ID, 'maritalstatus', true) . '</td>
				<td  class="memberdispalycenter">' . get_user_meta($user->ID, 'contact_num', true) . '</td>
				<td  class="memberdispalycenter">' . $term_data->name . '</td>
				<td class="memberdispalycenter"><a href="' . add_query_arg(array("id" => "$user->ID", "lang" => "eng",), "$member_path") . '"><i class="fa fa-users" aria-hidden="true" style="color: #1a5080;" ></i></a></td>
			</tr>';
			}

			$msg .= '</table></div>';
		//echo"@@@@@@";
		// If the query returns nothing, we throw an error message
		}
		else
		{
			$msg .= '<center><img src="' . get_bloginfo('template_directory') . '/images/404.gif" class="custom_404"/></center>';

		}
	}

//Set for member detail in gujarati
if (isset($_POST['data']['guj_col'])) {
$member_path = get_site_url() . "/display-user-member-info";

if ($all_posts):
	$msg .= '<div class="row"><table class = "table custom-table-body table-responsive table-striped table-hover table-file-list">';

	foreach ($all_posts as $user) { //get all user information using pagination arguument
		$user_details = get_usermeta($user->ID);
		//print_r($user_details);

		$path = wp_upload_dir();
		$get_path = $path['baseurl'] . "/user/";
		
		$user_profile_image = get_user_meta($user->ID, 'user_profile');
		$user_latest_profile_pic = max($user_profile_image);

		$term_data = get_term(get_user_meta($user->ID, 'village_name', true));

		if (get_user_meta($user->ID, 'gender', true) == "male") {
			$gen = "પુરૂષ";
		} else {
			$gen = "સ્ત્રી";
		}
		if (get_user_meta($user->ID, 'maritalstatus', true) == "married") {
			$ms = "પરણીત";
		} else {
			$ms = "અપરણીત";
		}

		$msg .= '
	<tr class="memberCustomRander memberdispalycenter">
		<td  class="memberdispalycenter"><img src="' . $get_path.$user_latest_profile_pic . '" class="img img-responsiv" alt="Member Image" width="80" height="80" /></td>
		<td  class="memberdispalycenter">' . get_user_meta($user->ID, 'gujname', true) . '</td>
		<td  class="memberdispalycenter" width="30%" >' . get_user_meta($user->ID, 'gujaddress', true) . '</td>
		<td  class="memberdispalycenter">' . $gen . '</td>
		<td  class="memberdispalycenter">' . $ms . '</td>
		<td  class="memberdispalycenter">' . get_user_meta($user->ID, 'contact_num', true) . '</td>
		<td  class="memberdispalycenter">' . $term_data->name . '</td>
		<td class="memberdispalycenter"><a href="' . add_query_arg(array("id" => "$user->ID", "lang" => "guj",), "$member_path") . '"><i class="fa fa-users" aria-hidden="true" style="color: #1a5080;" ></i></a></td>
	</tr>';
	}

	$msg .= '</table></div>';

// If the query returns nothing, we throw an error message
else:
	$msg .= '<center><img src="' . get_bloginfo('template_directory') . '/images/404.gif" class="custom_404"/></center>';
endif;
}



$msg = "<div class='cvf-universal-content'>" . $msg . "</div><br class = 'clear' />";

$no_of_paginations = ceil($count / $per_page);

if ($cur_page >= 7) {
$start_loop = $cur_page - 3;
if ($no_of_paginations > $cur_page + 3)
	$end_loop = $cur_page + 3;
else if ($cur_page <= $no_of_paginations && $cur_page > $no_of_paginations - 6) {
	$start_loop = $no_of_paginations - 6;
	$end_loop = $no_of_paginations;
} else {
	$end_loop = $no_of_paginations;
}
} else {
$start_loop = 1;
if ($no_of_paginations > 7)
	$end_loop = 7;
else
	$end_loop = $no_of_paginations;
}

$pag_container .= "
<div class='cvf-universal-pagination'>
<ul>";

if ($first_btn && $cur_page > 1) {
$pag_container .= "<li p='1' class='active'>First</li>";
} else if ($first_btn) {
$pag_container .= "<li p='1' class='inactive'>First</li>";
}

if ($previous_btn && $cur_page > 1) {
$pre = $cur_page - 1;
$pag_container .= "<li p='$pre' class='active'>Previous</li>";
} else if ($previous_btn) {
$pag_container .= "<li class='inactive'>Previous</li>";
}
for ($i = $start_loop; $i <= $end_loop; $i++) {

if ($cur_page == $i)
	$pag_container .= "<li p='$i' class = 'selected' >{$i}</li>";
else
	$pag_container .= "<li p='$i' class='active'>{$i}</li>";
}

if ($next_btn && $cur_page < $no_of_paginations) {
$nex = $cur_page + 1;
$pag_container .= "<li p='$nex' class='active'>Next</li>";
} else if ($next_btn) {
$pag_container .= "<li class='inactive'>Next</li>";
}

if ($last_btn && $cur_page < $no_of_paginations) {
$pag_container .= "<li p='$no_of_paginations' class='active'>Last</li>";
} else if ($last_btn) {
$pag_container .= "<li p='$no_of_paginations' class='inactive'>Last</li>";
}

$pag_container = $pag_container . "
</ul>
</div>";

echo
'<div class = "cvf-pagination-content">' . $msg . '</div>' .
'<div class = "cvf-pagination-nav">' . $pag_container . '</div>';
}

die();
}

//***************************Finish member display source **************************

/* Disable Admin Bar for All Users Except for Administrators start */

add_action('after_setup_theme', 'remove_admin_bar');

function remove_admin_bar() {
if (!current_user_can('administrator') && !is_admin()) {
show_admin_bar(false);
}
}

/* Disable Admin Bar for All Users Except for Administrators start */


/* redirect custom user to home page start */

function my_login_redirect($url, $request, $user) {
if ($user && is_object($user) && is_a($user, 'WP_User')) {
if ($user->has_cap('administrator')) {
$url = admin_url();
} else {
$url = home_url();
}
}
return $url;
}

add_filter('login_redirect', 'my_login_redirect', 10, 3);

/* redirect custom user to home page end */


/* create registration link on login page start */

add_filter('register', 'sjaved_register_link');

function sjaved_register_link($link) {
/* Required: Replace Register_URL with the URL of registration */
$custom_register_link = get_site_url() . "/register/";
/* Optional: You can optionally change the register text e.g. Signup */
$register_text = 'Register';
$link = '<a href="' . $custom_register_link . '">' . $register_text . '</a>';
return $link;
}

/* create registration link on login page end */


/* Change wordpress log in page logo start */

function my_login_logo_one() {
?> 
<style type="text/css"> 
body.login div#login h1 a {
background-image: url(<?php echo get_template_directory_uri() . '/images/logo.png'; ?>);  //Add your own logo image in this url 
padding-bottom: 30px; 
} 
</style>
<?php
}

add_action('login_enqueue_scripts', 'my_login_logo_one');

/* Change wordpress log in page logo end */


/* sfamily_footer_village_name_get() this function is get custom post taxonomy(village category) and print it's name with count
use sfamily_village_name shortcode */

add_shortcode('sfamily_village_name', 'sfamily_footer_village_name_get');

function sfamily_footer_village_name_get() {
$sfamily_get_terms = get_terms(['taxonomy' => 'village', 'hide_empty' => false,]);
//print_r($sfamily_get_terms);
?>
<div>
<font style="font-size: 16px;color: white;">Villages</font><hr/>

<?php
global $wpdb;        
foreach ($sfamily_get_terms as $data):
$all_count = "SELECT count(*) as cnt FROM wp_usermeta WHERE meta_key LIKE '%village_name%' and meta_value = $data->term_id";
$all_count1 = $wpdb->get_results($all_count, ARRAY_A);
//            print_r($all_count1[0]['cnt']);
//                echo "SELECT count(*) FROM wp_usermeta WHERE meta_key LIKE '%village_name%' and meta_value = $data->term_id";
?>
<span class="badge" style="font-size: 14px;"><?php echo $data->name . "&nbsp;<span style='padding:4px;color:coral;border-radius:10px;font-size:14px;'> ( " . $all_count1[0]['cnt'] . " ) </span>"; ?></span>
<?php
endforeach;

?>
</div>
<?php
}

/* Add Custom metabox for events */

function wpt_add_event_metaboxes() {

add_meta_box(
'image_uploader_metabox', // Unique ID of metabox
'Image upload', //Title of metabox
'image_uploader_metaboxes', // Callback function
'fw-event', //name of your custom post type (here post is for wordpress posts.)
'side', //Context
'default' //Priority
);
}

add_action('add_meta_boxes', 'wpt_add_event_metaboxes');

function image_uploader_metaboxes() {
wp_nonce_field(basename(__FILE__), 'image_uploader_metaboxes');

global $post;

// Get WordPress' media upload URL
$upload_link = esc_url(get_upload_iframe_src());

// See if there's a media id already saved as post meta
$your_img_id = get_post_meta(get_the_ID(), '_your_img_id', true);

// Get the image src
$your_img_src = wp_get_attachment_image_src($your_img_id, 'full');

// For convenience, see if the array is valid
$you_have_img = is_array($your_img_src);
?>
<div id="custom-images">

<div class="custom-img-container">

<?php
$meta_values = get_post_meta(get_the_ID(), 'image_src', false);

foreach ($meta_values as $value) {
	?>


	<div class="image-wrapper">
		<input type="hidden" name="image_src[]" value="<?php echo $value; ?>"><img src="<?php echo $value; ?>" style="max-width:95%;display:block;" />
		<a class="delete-custom-img" href="#">Remove this image</a>
	</div>

<?php } ?>

</div>

</div>

<p>

<i class="fa fa-plus"><a class="upload-custom-img <?php
if ($you_have_img) {
	echo 'hidden';
}
?>" href="<?php echo $upload_link; ?>" style="font-size:16px;font-weight:bold;">
					 <?php _e('Add custom image'); ?>
</a></i>

</p>
<?php
}

//Save Metadata

function save_image_uploader_metadata($post_id, $post) {

/* Verify the nonce before proceeding. */
if (!isset($_POST['image_uploader_metaboxes']) || !wp_verify_nonce($_POST['image_uploader_metaboxes'], basename(__FILE__)))
return $post_id;

/* Get the post type object. */
$post_type = get_post_type_object($post->post_type);

/* Check if the current user has permission to edit the post. */
if (!current_user_can($post_type->cap->edit_post, $post_id))
return $post_id;

/* Get the meta key. */
$meta_key = 'image_src';

/* Get the meta value of the custom field key. */
$meta_value = get_post_meta($post_id, $meta_key, false);

/* For looping all meta values */
foreach ($meta_value as $value) {
delete_post_meta($post_id, $meta_key, $value);
}

/* Get the posted data and sanitize it for use as an HTML class. */
foreach ($_POST['image_src'] as $value) {
add_post_meta($post_id, $meta_key, $value, false);
}
}

function enqueue_media() {
wp_enqueue_media();
}

function include_js_code_for_uploader() {
?>

<!-- ****** JS CODE ******  -->
<script>
jQuery(function ($) {

// Set all variables to be used in scope
var frame,
		metaBox = $('#image_uploader_metabox.postbox'); // Your meta box id here
addImgLink = metaBox.find('.upload-custom-img');
imgContainer = metaBox.find('.custom-img-container');
imgIdInput = metaBox.find('.custom-img-id');
customImgDiv = metaBox.find('#custom-images');



// ADD IMAGE LINK
addImgLink.on('click', function (event) {

	event.preventDefault();

	// If the media frame already exists, reopen it.
	if (frame) {
		frame.open();
		return;
	}

	// Create a new media frame
	frame = wp.media({
		title: 'Select or Upload Media Of Your Chosen Persuasion',
		button: {
			text: 'Use this media'
		},
		multiple: false  // Set to true to allow multiple files to be selected
	});


	// When an image is selected in the media frame...
	frame.on('select', function () {

		// Get media attachment details from the frame state
		var attachment = frame.state().get('selection').first().toJSON();

		// Send the attachment URL to our custom image input field.
		imgContainer.append('<div class="image-wrapper"><input type="hidden" name="image_src[]" value="' + attachment.url + '"><img src="' + attachment.url + '" style="max-width:95%;display:block;" /><a class="delete-custom-img" href="#">Remove this image</a></div>');

	});

	// Finally, open the modal on click
	frame.open();
});


customImgDiv.on('click', '.delete-custom-img', function (event) {
	event.preventDefault();
	jQuery(event.target).parent().remove();

});


});

</script>

<?php
}

add_action('admin_enqueue_scripts', 'enqueue_media');

add_action('admin_head', 'include_js_code_for_uploader');

add_action('save_post', 'save_image_uploader_metadata', 10, 2);

/* End Add Custom metabox for events */

/* css js for event slider */

function load_custom_wp_admin_style($hook) {
wp_enqueue_style('event_slider_css', get_stylesheet_directory_uri() . '/assets/css/w3.css');
wp_enqueue_style('custom_css_head', get_stylesheet_directory_uri() . '/assets/css/custom_css.css');
wp_enqueue_style('keyboard_css', get_stylesheet_directory_uri() . '/assets/css/keyboard.css');
wp_enqueue_style('crop_imggg_css', get_stylesheet_directory_uri() . '/assets/css/jquery.Jcrop.min.css');
wp_enqueue_style('ba_css', get_stylesheet_directory_uri() . '/assets/css/thumbnail-slider.css');
wp_enqueue_style('aclonomica_font',  'https://fonts.googleapis.com/css?family=Aclonica');

/* start custom added js */
wp_enqueue_script('event_slider_js', get_stylesheet_directory_uri() . '/assets/js/event-slider.js', array('jquery'), '1.0.0', true);
wp_enqueue_script('ba_slider_js', get_stylesheet_directory_uri() . '/assets/js/thumbnail-slider.js', array('jquery'), '1.0.0', true);

wp_enqueue_script('keyboard_js', get_stylesheet_directory_uri() . '/assets/js/keyboard.js', array('jquery'), '1.0.0', true);
wp_enqueue_script('img_crop_js', get_stylesheet_directory_uri() . '/assets/js/jquery.Jcrop.min.js', array('jquery'), '1.0.0', true);
wp_enqueue_script('validation_js_for_jquery', get_stylesheet_directory_uri() . '/assets/js/jquery.validate.min.js', array('jquery'), '1.0.0', true);
//echo $hook.'7777777777777777777777';
/* us CDN link */
if($hook=='user-edit.php' ){
     wp_enqueue_style('event_slider_css111100', 'https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css');
}
wp_enqueue_script('translate_modal_js11100', 'https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js', array('jquery'));
wp_enqueue_style('event_slider_css111111', 'https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.1/jquery-ui.css');
wp_enqueue_script('translate_modal_js11111', 'https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.1/jquery-ui.js', array('jquery'));
}

add_action('wp_enqueue_scripts', 'load_custom_wp_admin_style');
add_action('admin_enqueue_scripts', 'load_custom_wp_admin_style');
?>
