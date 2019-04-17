<?php
/**
 * Template Name: Invetation Template
 */
get_header();
?>
<div class="">
    <div class="" style="position: relative">
        <img src="<?php echo get_template_directory_uri() . '/images/about-banner.jpg'; ?>" class="img-responsive respImageheading" />

        <h4 align="right" style="position:absolute" class="cust_head custom_header">Invetation List</h4>      
    </div>
</div>
<br/>
<br/>

		<div class="container">
			<div class="row">
				<div class="col-md-12">
<?php
$args = array(
'posts_per_page'   => 10,
'post_type' => 'invitation',
'post_status' => array( 'publish' ),
'meta_query' => array(
        array(
            'key' => 'eventdate', 
            'value' => date('ymd'),
            'compare' => '>=', 
            'type' => 'DATE',
        ),
    ),
);
$ad_data = get_posts($args);

if(!empty($ad_data))
{
		foreach($ad_data as $invetaion_data){
		$invetaion_data_meata = get_post_meta($invetaion_data->ID);
		// echo "<pre>";
		// print_r($invetaion_data_meata);
		// echo "</pre>";
		?>
			<table class="table">
				<tr>
					<td class='invetaion_table_heading'>
						<span>Title </span>
					</td>
					<td class='invetaion_table_content'>
						<span><?php echo $invetaion_data_meata['title'][0]; ?></span>
					</td>
				</tr>
				<tr>
					<td class='invetaion_table_heading'>
						<span>Descrption </span>
					</td>
					<td class='invetaion_table_content'>
						<span><?php echo $invetaion_data_meata['description'][0]; ?></span>
					</td>
				</tr>
				<tr>
					<td class='invetaion_table_heading'>
						<span>Active </span>
					</td>
					<td class='invetaion_table_content'>
						<span>
							<?php
							if($invetaion_data_meata['status'][0]=="false"){
								echo "<span style='color:red;font-weight:bold;'> <i class='fa fa-circle'></i></span>";
							}
							else
							{
								echo "<span style='color:Green;font-weight:bold;'> <i class='fa fa-circle'></i></span>";
							}
							?>
						</span>
					</td>
				</tr>
				<tr>
					<td class='invetaion_table_heading'>
						<span>Event Date </span>
					</td>
					<td class='invetaion_table_content'>
						<span><?php echo $invetaion_data_meata['eventdate'][0]; ?></span>
					</td>
				</tr>
			</table>
				
			<?php			
			}
			?>
		</div>
	</div>
</div>

<?php
}
else
{
	?>

	<br/><br/><span style="font-color:red;text-align: right;
    font-family: Aclonica;
    font-weight: 400;
    font-style: normal;
    font-size: 40px;
    line-height: 56px;
    letter-spacing: 0px;
    padding-left: 116.5px;
    padding-right: 116.5px;
    padding-top: 30px;">Sorry, Invetation list is not available at now...!</span>
	<img src="<?php bloginfo('template_url'); ?>/images/sad_emoji.gif" class="img-thumbnail" width="100px" />
<?php
}


get_footer();
?>