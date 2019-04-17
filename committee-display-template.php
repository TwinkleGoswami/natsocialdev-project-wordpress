<?php
/*
 * Template Name: committee Display Template
 */
get_header();
?>

<div class="">
    <div class="" style="position: relative">
        <img src="<?php echo get_template_directory_uri() . '/images/commitee-banner.jpg'; ?>" class="img-responsive respImageheading" />

        <h4 align="right" style="position:absolute" class="cust_head custom_header">Committee</h4>      
    </div>
</div>
<br/>

<div class="">
    <div class="container">   
        
    </div>
</div>
</div>


<div class="">
    <div class="container">
		<article class="navbar-form navbar-left">
            <div class="form-group">
                <select name="chooseyear" class="text post_search_drop" style="padding: 5px 0px;">
                    <option value="2018-2017" selected="">2018-2017</option>
                    <option value="2017-2016">2017-2016</option>
                    <option value="2016-2015">2016-2015</option>
                    <option value="2015-2014">2015-2014</option>
                    <option value="2014-2013">2014-2013</option>
                </select>
            </div>
        </article>
        <ul class="nav nav-tabs tab_opt">
            <li class="active"><a data-toggle="tab" href="#englishmenutab">English</a></li>
            <li><a data-toggle="tab" href="#gujaratimenutab">Gujarati</a></li>
        </ul>
        <!-- get all subscriber(member) and display as below table -->
        <div class="tab-content">
            <!-- get user data with pagination (english) -->
            <div id="englishmenutab" class="tab-pane fade in active">
                <br/>
                <div class  ="col-md-12 content">
                    <div class = "content">
                        <form class = "post-list">
                            <input type = "hidden" value = "" />
                        </form>

                        <br class = "clear" />

                        <script type="text/javascript">
                            var ajaxurl = '<?php echo admin_url('admin-ajax.php'); ?>';
                            function cvf_load_all_posts() {
                                jQuery(".cvf_universal_container").html('<p><center><img src = "<?php bloginfo('template_url'); ?>/images/giphy.gif" class = "loader" /></center></p>');

                                var post_data = {
                                    dropsearch: jQuery('.post_search_drop').val()
                                };

                                jQuery('form.post-list input').val(JSON.stringify(post_data));

                                var data = {
                                    action: "demo_load_my_posts_committee",
                                    data: JSON.parse(jQuery('form.post-list input').val())
                                };
                                jQuery.post(ajaxurl, data, function (response) {
                                   jQuery(".cvf_universal_container").html(response);
                                });
                            }

                            jQuery(document).ready(function () {

                                // Check if our hidden form input is not empty, meaning it's not the first time viewing the page.
                                if (jQuery('form.post-list input').val()) {
                                    // Submit hidden form input value to load previous page number
                                    data = JSON.parse(jQuery('form.post-list input').val());
                                } else {
                                    cvf_load_all_posts(1, 'user_login', 'ASC');
                                }

                                // Search by dropdown
                                jQuery('body').on('change', '.post_search_drop', function () {
                                    cvf_load_all_posts();
                                });
                            });
                        </script>
                        <div class="responsive-table">
                            <div class = "cvf_pag_loading no-padding">
                                <div class = "cvf_universal_container">
                                    <div class="cvf-universal-content"></div>
                                </div>
                            </div>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            
            <div id="gujaratimenutab" class="tab-pane fade">
                <br/>

                <div class  ="col-md-12 content">
                    <div class = "content">
                        <form class = "post-list-guj">
                            <input type = "hidden" value = "" />
                        </form>
                      
                        <br class = "clear" />

                        <script type="text/javascript">
                            var ajaxurl1 = '<?php echo admin_url('admin-ajax.php'); ?>';
                            //            var myurl = '<?php echo bloginfo('template_url'); ?>';
                            //alert(myurl);
                            function cvf_load_all_posts_guj() {
                                //alert(page+"***"+th_name+"***"+th_sort);
                                jQuery(".cvf_universal_container_guj").html('<p><center><img src = "<?php bloginfo('template_url'); ?>/images/giphy.gif" class = "loader" /></center></p>');

                                var post_data = {
                                    dropsearch: jQuery('.post_search_drop').val(),
                                };

                                jQuery('form.post-list-guj input').val(JSON.stringify(post_data));

                                var data = {
                                    action: "demo_load_my_posts_committee_guj",
                                    data: JSON.parse(jQuery('form.post-list-guj input').val())
                                };
                                //alert(data);
                                jQuery.post(ajaxurl1, data, function (response) {
                                  jQuery(".cvf_universal_container_guj").html(response);
                                });
                            }

                            jQuery(document).ready(function () {

                                // Initialize default item to sort and it's sort order

                                // Check if our hidden form input is not empty, meaning it's not the first time viewing the page.
                                if (jQuery('form.post-list-guj input').val()) {
                                    // Submit hidden form input value to load previous page number
                                    data = JSON.parse(jQuery('form.post-list-guj input').val());
                                } else {
                                    // Load first page
                                    cvf_load_all_posts_guj(1, 'user_login', 'ASC');
                                }

                                // Search by dropdown
                                jQuery(document).on('change', '.post_search_drop', function () {
                                    cvf_load_all_posts_guj();
                                });
                            });
                        </script>
                        <div class="responsive-table">
                       
                        <div class = "cvf_pag_loading no-padding">
                            <div class = "cvf_universal_container_guj">
                                <div class="cvf-universal-content"></div>
                            </div>
                        </div>
                    </div>
                </div>
                </div>

            </div>

        </div>

    </div>
</div>
<br/><br/>
<?php
get_footer();
?>
