<?php
/**
 * Template Name: Member Display Template
 */
get_header();
?>

<div class="">
    <div class="" style="position: relative">
        <img src="<?php echo get_template_directory_uri() . '/images/members-banner.jpg'; ?>" class="img-responsive respImageheading" />

        <h4 align="right" style="position:absolute" class="cust_head custom_header">Members list</h4>      
    </div>
</div>
<br/>

<div class="">
    <div class="container">   
        <article class="navbar-form navbar-left">
            <div class="form-group">
                <select name="membervillagesname" class="text post_search_drop" style="padding: 5px 0px;">
                    <option value="">--Select village--</option>
                    <?php
                    $sfamily_get_villages = get_terms(['taxonomy' => 'village', 'hide_empty' => false,]);
                    foreach ($sfamily_get_villages as $data):
                        ?>
                        <option value="<?php echo $data->term_id; ?>" ><?php echo $data->name; ?></option>
                        <?php
                    endforeach;
                    ?>
                </select>
            </div>
        </article>

        <article class="navbar-form display_inline">
            <div class="form-group">
                <input type="text" class="form-control post_search_text" placeholder="Enter a keyword">
            </div>
            <input type = "submit" value = "Search" class = "btn btn-success post_search_submit" style="padding: 9px 12px;" />
        </article>
		
		<ul class="nav nav-tabs tab_opt">
            <li class="active"><a data-toggle="tab" href="#englishmenutab">English</a></li>
            <li><a data-toggle="tab" href="#gujaratimenutab">Gujarati</a></li>
        </ul>
		
		 <div class="tab-content">
            <!-- get user data with pagination (english) -->
            <div id="englishmenutab" class="tab-pane fade in active">                
                <div class  ="col-md-12 content">
                    <div class = "content">
                        <form class = "post-list">
                            <input type = "hidden" value = "" />
                        </form>


                        <br class = "clear" />

                        <script type="text/javascript">
                            var ajaxurl = '<?php echo admin_url('admin-ajax.php'); ?>';
                            //            var myurl = '<?php echo bloginfo('template_url'); ?>';
                            //alert(myurl);
                            function cvf_load_all_posts(page, th_name, th_sort) {
                                //alert(page+"***"+th_name+"***"+th_sort);
                                jQuery(".cvf_universal_container").html('<p><center><img src = "<?php bloginfo('template_url'); ?>/images/giphy.gif" class = "loader" /></center></p>');

                                var post_data = {
                                    page: page,
                                    search: jQuery('.post_search_text').val(),
                                    dropsearch: jQuery('.post_search_drop').val(),
                                    th_name: th_name,
                                    th_sort: th_sort,
                                    eng_col: "yes"
                                };

                                //alert(jQuery('.post_search_drop').val());

                                jQuery('form.post-list input').val(JSON.stringify(post_data));

                                var data = {
                                    action: "demo_load_my_posts",
                                    data: JSON.parse(jQuery('form.post-list input').val())
                                };
                                //alert(jQuery('form.post-list input').val());
								//alert(data['data']);
                                jQuery.post(ajaxurl, data, function (response) {
                                    if (jQuery(".cvf_universal_container").html(response)) {
                                        jQuery('.table-post-list th').each(function () {
                                            // Append the button indicator
                                            jQuery(this).find('span.glyphicon').remove();
                                            if (jQuery(this).hasClass('active')) {
                                                if (JSON.parse(jQuery('form.post-list input').val()).th_sort == 'DESC') {
                                                    jQuery(this).append(' <span class="glyphicon glyphicon-chevron-down"></span>');
                                                } else {
                                                    jQuery(this).append(' <span class="glyphicon glyphicon-chevron-up"></span>');
                                                }
                                            }
                                        });
                                    }
                                });
                            }

                            jQuery(document).ready(function () {

                                // Initialize default item to sort and it's sort order

                                // Check if our hidden form input is not empty, meaning it's not the first time viewing the page.
                                if (jQuery('form.post-list input').val()) {
                                    // Submit hidden form input value to load previous page number
                                    data = JSON.parse(jQuery('form.post-list input').val());
                                    //alert(data);
                                    cvf_load_all_posts(data.page, data.th_name, data.th_sort);
                                } else {
                                    // Load first page
                                    cvf_load_all_posts(1, 'user_login', 'ASC');
                                }

                                var th_active = jQuery('.table-post-list th.active');
                                var th_name = jQuery(th_active).attr('id');
                                var th_sort = jQuery(th_active).hasClass('DESC') ? 'ASC' : 'DESC';

                                // Search
                                jQuery('body').on('click', '.post_search_submit', function () {
                                    //alert(1+"---"+th_name+"---"+th_sort);
                                    cvf_load_all_posts(1, th_name, th_sort);
                                });

                                // Search by dropdown
                                jQuery('body').on('change', '.post_search_drop', function () {
                                    cvf_load_all_posts(1, th_name, th_sort);
                                });

                                // Search when Enter Key is triggered
                                jQuery(".post_search_text").keyup(function (e) {
                                    if (e.keyCode == 13) {
                                        cvf_load_all_posts(1, th_name, th_sort);
                                    }
                                });

                                // Pagination Clicks                    
                                jQuery('.cvf_universal_container .cvf-universal-pagination li.active').live('click', function () {
                                    var page = jQuery(this).attr('p');
                                    var current_sort = jQuery(th_active).hasClass('DESC') ? 'DESC' : 'ASC';
                                    cvf_load_all_posts(page, th_name, current_sort);
                                    cvf_load_all_posts_guj(page, th_name, current_sort);
                                });

                                // Sorting Clicks
                                jQuery('body').on('click', '.table-post-list th', function (e) {
                                    e.preventDefault();
                                    var th_name = jQuery(this).attr('id');

                                    if (th_name) {
                                        // Remove all TH tags with an "active" class
                                        if (jQuery('.table-post-list th').removeClass('active')) {
                                            // Set "active" class to the clicked TH tag
                                            jQuery(this).addClass('active');
                                        }
                                        if (!jQuery(this).hasClass('DESC')) {
                                            cvf_load_all_posts(1, th_name, 'DESC');
                                            jQuery(this).addClass('DESC');
                                        } else {
                                            cvf_load_all_posts(1, th_name, 'ASC');
                                            jQuery(this).removeClass('DESC');
                                        }
                                    }
                                })
                            });
                        </script>
                        <div class="responsive-table">
                            <table class = "table table-responsive table-striped custom-table-header table-post-list no-margin">
                                <thead class="memberCustomHeadingRander">
                                    <tr>
                                        <th><u>Profile</u></th>
                                <th class = "active" id = "user_login"><u><a href = "#">Name</a></u></th>
                                <th>Address</th>
                                <th>Gender</th>
                                <th>Marital Status</th>
                                <th>Contact</th>
                                <th>Village</th>
                                <th>Family Details</th>
                                </tr>
                                </thead>    
                            </table>
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
            <!-- get user data with pagination (gujarati) -->
            <div id="gujaratimenutab" class="tab-pane fade">                
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
                            function cvf_load_all_posts_guj(page, th_name, th_sort) {
                                //alert(page+"***"+th_name+"***"+th_sort);
                                jQuery(".cvf_universal_container_guj").html('<p><center><img src = "<?php bloginfo('template_url'); ?>/images/giphy.gif" class = "loader" /></center></p>');

                                var post_data = {
                                    page: page,
                                    search: jQuery('.post_search_text').val(),
                                    dropsearch: jQuery('.post_search_drop').val(),
                                    th_name: th_name,
                                    th_sort: th_sort,
                                     guj_col: "yes"
                                };
//                                alert(jQuery('.post_search_drop').val());

                                jQuery('form.post-list-guj input').val(JSON.stringify(post_data));

                                var data = {
                                    action: "demo_load_my_posts",
                                    data: JSON.parse(jQuery('form.post-list-guj input').val())
                                };
                                //alert(data);
                                jQuery.post(ajaxurl1, data, function (response) {
                                    if (jQuery(".cvf_universal_container_guj").html(response)) {
                                        jQuery('.table-post-list-guj th').each(function () {
                                            // Append the button indicator
                                            jQuery(this).find('span.glyphicon').remove();
                                            if (jQuery(this).hasClass('active')) {
                                                if (JSON.parse(jQuery('form.post-list-guj input').val()).th_sort == 'DESC') {
                                                    jQuery(this).append(' <span class="glyphicon glyphicon-chevron-down"></span>');
                                                } else {
                                                    jQuery(this).append(' <span class="glyphicon glyphicon-chevron-up"></span>');
                                                }
                                            }
                                        });
                                    }
                                });
                            }

                            jQuery(document).ready(function () {

                                // Initialize default item to sort and it's sort order

                                // Check if our hidden form input is not empty, meaning it's not the first time viewing the page.
                                if (jQuery('form.post-list-guj input').val()) {
                                    // Submit hidden form input value to load previous page number
                                    data = JSON.parse(jQuery('form.post-list-guj input').val());
                                    cvf_load_all_posts_guj(data.page, data.th_name, data.th_sort);
                                } else {
                                    // Load first page
                                    cvf_load_all_posts_guj(1, 'user_login', 'ASC');
                                }

                                var th_active = jQuery('.table-post-list-guj th.active');
                                var th_name = jQuery(th_active).attr('id');
                                var th_sort = jQuery(th_active).hasClass('DESC') ? 'ASC' : 'DESC';

                                // Search
                                jQuery('body').on('click', '.post_search_submit', function () {
                                    cvf_load_all_posts_guj(1, th_name, th_sort);
                                });
                                
                                // Search by dropdown
                                jQuery(document).on('change', '.post_search_drop', function () {
                                    //alert(1+"****"+th_name+"****"+th_sort);
//                                    alert(jQuery('.post_search_drop').val());
                                    cvf_load_all_posts_guj(1, th_name, th_sort);
                                });
                                
                                // Search when Enter Key is triggered
                                jQuery(".post_search_text").keyup(function (e) {
                                    if (e.keyCode == 13) {
                                        cvf_load_all_posts_guj(1, th_name, th_sort);
                                    }
                                });

                                // Pagination Clicks                    
                                jQuery('.cvf_universal_container_guj .cvf-universal-pagination li.active').live('click', function () {
                                    var page = jQuery(this).attr('p');
                                    var current_sort = jQuery(th_active).hasClass('DESC') ? 'DESC' : 'ASC';
                                    cvf_load_all_posts_guj(page, th_name, current_sort);
                                    cvf_load_all_posts(page, th_name, current_sort);
                                });

                                // Sorting Clicks
                                jQuery('body').on('click', '.table-post-list-guj th', function (e) {
                                    e.preventDefault();
                                    var th_name = jQuery(this).attr('id');

                                    if (th_name) {
                                        // Remove all TH tags with an "active" class
                                        if (jQuery('.table-post-list-guj th').removeClass('active')) {
                                            // Set "active" class to the clicked TH tag
                                            jQuery(this).addClass('active');
                                        }
                                        if (!jQuery(this).hasClass('DESC')) {
                                            cvf_load_all_posts_guj(1, th_name, 'DESC');
                                            jQuery(this).addClass('DESC');
                                        } else {
                                            cvf_load_all_posts_guj(1, th_name, 'ASC');
                                            jQuery(this).removeClass('DESC');
                                        }
                                    }
                                })
                            });
                        </script>
                        <div class="responsive-table">
                        <table class = "table table-responsive table-striped custom-table-header table-post-list-guj no-margin">
                            <thead class="memberCustomHeadingRander">
                                <tr>
                                    <th><u>Profile</u></th>
                            <th class = "active" id = "user_login"><u><a href = "#">Name</a></u></th>
                            <th>Address</th>
                            <th>Gender</th>
                            <th>Marital Status</th>
                            <th>Contact</th>
                            <th>Village</th>
                            <th>Family Details</th>
                            </tr>
                            </thead>    
                        </table>
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
</div>

<?php
get_footer();
?>
