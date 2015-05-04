<?php 
global $IF_CONFIG;
?>
<!-- used for the media query -->
<meta name="viewport" content="width=device-width" />
<link rel="stylesheet" type="text/css" href="<?php echo $IF_CONFIG->parameter["url_framework"] ?>/assets/css/animate.css" />
<link rel="stylesheet" type="text/css" href="<?php echo $IF_CONFIG->parameter["url_framework"] ?>/assets/css/font-awesome.css" />
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<script type='text/javascript' src='<?php echo $IF_CONFIG->parameter["url_framework"] ?>/assets/js/wow.min.js' ></script>

<div class="page--yuzo__welcome">
    <div class="page--header wow fadeIn animated" data-wow-delay="0.2s">
        <div class="page--header__a">
            <i class="el-icon-fire"></i><span class="tlogo"><span class="ylogo">Y</span>uzo</span>
        </div>
        <div class="page--header__b">
            <p>Welcome to one of the best <strong>related post</strong> 
                plugin having Wordpress, with a number of features and 
                usability experience that make it unique. <a class="button-secondary" href="options-general.php?page=yuzo-related-post" target="_blank">Settings Page</a></p>
        </div>
    </div>
    <div class="page--body">
        <h2 class="nav-tab-wrapper">
            <a class='nav-tab <?php if( !isset($_GET['tab']) || !$_GET['tab'] ){ echo "nav-tab-active"; } ?>' href='<?php echo admin_url( 'options-general.php?page=yuzo-welcome' ); ?>'>Welcome</a>
            <a class='nav-tab <?php if( isset($_GET['tab']) && $_GET['tab'] == 'new' ){ echo "nav-tab-active"; } ?>' href='<?php echo admin_url( 'options-general.php?page=yuzo-welcome&tab=new' ); ?>'>New 4.8</a>
            <a class='nav-tab <?php if( isset($_GET['tab']) && $_GET['tab'] == 'compare' ){ echo "nav-tab-active"; } ?>' href='<?php echo admin_url( 'options-general.php?page=yuzo-welcome&tab=compare' ); ?>'>Compare (VS)</a>
            <a class='nav-tab  <?php if( isset($_GET['tab']) && $_GET['tab'] == 'ilenframework' ){ echo "nav-tab-active"; } ?>' href='<?php echo admin_url( 'options-general.php?page=yuzo-welcome&tab=ilenframework' ); ?>'>iLenFramework</a>
            <a class='nav-tab <?php if( isset($_GET['tab']) && $_GET['tab'] == 'support' ){ echo "nav-tab-active"; } ?>' href='<?php echo admin_url( 'options-general.php?page=yuzo-welcome&tab=support' ); ?>'>Happy Support</a>
        </h2>
        <!--<div id="poststuff" class="ui-sortable meta-box-sortables">
            <div class="postbox">
                <h3><?php //_e('Sample Settings', 'sample'); ?></h3>
                <div class="inside">
                    <p><?php // _e('Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 'sample'); ?></p>
                </div>
            </div>
        </div>-->


        <?php if( !isset($_GET['tab']) || !$_GET['tab'] ): ?>

        <h2 style="text-align:center;margin:30px 0;" class="">Tools increases your productivity in <strong>Metabox</strong></h2>

        <div class="image_content">
                
                <div id="welcome-screen" >
                    <div id="overlay"></div>
                    <div class="welcome-screen" >
                        <!-- Metabox -->
                        <div class="circle metabox-select"></div> 
                        <div class="feature metabox-select">
                                <div class="popover-welcome metabox-select">
                                    <h2><text rel="tutorial_welcome_user_title">Include / Exclude</text></h2> 
                                    <p> <text rel="tutorial_welcome_user_text">Add or remove manually for each post related post.</text> </p>
                                </div>
                        </div>

                        <!-- Views -->
                        <div class="circle views-flare"></div> 
                        <div class="feature views-flare">
                                <div class="popover-welcome views-flare">
                                    <h2><text rel="tutorial_welcome_user_title">Generate Traffic</text></h2> 
                                    <p> <text rel="tutorial_welcome_user_text">With Yuzo related post your page will have more time visits.</text> </p>
                                </div>
                        </div> 

                    </div>
                </div>
            <div class="wow fadeInUp animated">
                <img src="<?php echo $IF_CONFIG->parameter["theme_imagen"] ?>/metabox-1.png" />
            </div>
        </div>

        <h2 style="text-align:center;margin:30px 0;">Has a Super <strong>Widget</strong></h2>
        <div class="image_content">
                <div id="welcome-screen">
                    <div id="overlay" class=""></div>
                    <div class="welcome-screen">
 
                        <!-- style in widget -->
                        <div class="circle your-style"></div> 
                        <div class="feature your-style">
                                <div class="popover-welcome your-style">
                                    <h2><text rel="tutorial_welcome_user_title">Full Widget</text></h2> 
                                    <p> <text rel="tutorial_welcome_user_text">Yuzo also has many interesting features Widget.</text> </p>
                                </div>
                        </div> 

                    </div>
                </div>
            <div style="visibility:hidden" class="wow fadeInDown animated" data-wow-delay="0.2s">
                <img src="<?php echo $IF_CONFIG->parameter["theme_imagen"] ?>/widgets.png" />
            </div>
        </div>


        <h2 style="text-align:center;margin:30px 0;">Over <strong>+50 options</strong>  that will brighten life</h2>
        <div class="image_content">
                <div id="welcome-screen">
                    <div id="overlay" class=""></div>
                    <div class="welcome-screen">
 
                        <!-- plugin options 1 -->
                        <div class="circle plugin-options-1"></div> 
                        <div class="feature plugin-options-1">
                                <div class="popover-welcome plugin-options-1">
                                    <h2><text rel="tutorial_welcome_user_title">Defaults</text></h2> 
                                    <p> <text rel="tutorial_welcome_user_text">Yuzo has defaults options with which you can work without much customization.</text> </p>
                                </div>
                        </div> 

                        <!-- plugin options 2 -->
                        <div class="circle plugin-options-2"></div> 
                        <div class="feature plugin-options-2">
                                <div class="popover-welcome plugin-options-2">
                                    <h2><text rel="tutorial_welcome_user_title">Exclude by tag</text></h2> 
                                    <p> <text rel="tutorial_welcome_user_text">You can exclude post by tag do not want to include.</text> </p>
                                </div>
                        </div> 

                        <!-- plugin options 3 -->
                        <div class="circle plugin-options-3"></div> 
                        <div class="feature plugin-options-3">
                                <div class="popover-welcome plugin-options-3">
                                    <h2><text rel="tutorial_welcome_user_title">EASY!</text></h2> 
                                    <p> <text rel="tutorial_welcome_user_text">Yuzo has very intuitive options than any can understand.</text> </p>
                                </div>
                        </div> 

                    </div>
                </div>
            <div class="wow fadeInUp animated" data-wow-delay="0.2s">
                <img src="<?php echo $IF_CONFIG->parameter["theme_imagen"] ?>/plugin-options.png" />
            </div>
        </div>

        <?php elseif( isset($_GET['tab']) && $_GET['tab']=='new' ): ?>
        <div class="page--yuzo__new">
            <div class="changelog">
                <article>
                    <strong>CHANGELOG</strong>
                    <h4>V4.8 - 04. April 2015</h4>
                    <ul class="changelog_list">
                        <li class="add"><div class="two">Add</div>Add Theme based in css!</li>
                        <li class="add"><div class="two">Add</div>Add class in elements html of Yuzo for manipulate css</li>
                        <li class="fixed"><div class="two">Fix</div>Fixed <code>admin.css</code> in class</li>
                        <li class="fixed"><div class="two">Fix</div>Modify css in core framework</li>
                        <li class="fixed"><div class="two">Fix</div>Modify core class in editor</li>
                        <li class="fixed"><div class="two">Fix</div>Code js in yuzo functions</li>
                    </ul>
                    <!--<h4>V4.5 - 31. Mar 2015</h4>
                    <ul class="changelog_list">
                        <li class="add"><div class="two">Add</div>The 'shortcode' is added to display related that way</li>
                        <li class="add"><div class="two">Add</div>The 'Clear transient database' button was added to remove expired cache data in the database.</li>
                        <li class="add"><div class="two">Add</div>The option 'Use transient?' Added so that user can control if you want Yuzo either cache or not.</li>
                        <li class="add"><div class="two">Add</div>The 'Clear old Meta_Key' button was added to remove old meta.</li>
                        <li class="add"><div class="two">Add</div> Yuzo Widget: It was added to exclude post by tags.</li>
                        <li class="fixed"><div class="two">Fix</div> Yuzo Widget: time interval was corrected for post 'most commented'.</li>
                        <li class="fixed"><div class="two">Fix</div> Corrections minimum code</li>
                    </ul>-->
                </article>
            </div>
            <div class="col-group wow flipInX animated" data-wow-duration="0.8s" data-wow-delay="0.2s" style="width:680px;float:left;">
                <div>
                    <h2>The fastest</h2>
                    <p>Yuzo is considered one of the faster and less load on the PC.</p>
                </div>
                <div>
                    <h2>Cache</h2>
                    <p>Now Yuzo cache uses the images and sql to make your site faster.</p>
                </div>
                <div>
                    <h2>Minimalist</h2>
                    <p>It has a minimalist design with interesting effects.</p>
                </div>
                <div>
                    <h2>New Metabox</h2>
                    <p>The new metabox is something you want to know.</p>
                </div>
                <div>
                    <h2>Yuzo Widget</h2>
                    <p>You can see it in the widget and is a super widget.</p>
                </div>
                <div>
                    <h2>Customizing text</h2>
                    <p>Allows you to customize the text in many ways, colors, etc ...</p>
                </div>
                <div>
                    <h2>Counter</h2>
                    <p>Check the amounts of visits to your post have by Yuzo.</p>
                </div>
                <div>
                    <h2>Dashboard (Post)</h2>
                    <p>Display visits in the list of post in administration.</p>
                </div>
                <div>
                    <h2>Productivity</h2>
                    <p>All tools and options needed to take advantage of the plugin.</p>
                </div>


            </div>
        </div>
        <?php elseif( isset($_GET['tab']) && $_GET['tab']=='compare' ): ?>
        <div class="page--yuzo__compare">
            <table cellpadding="0" cellspacing="0" class="wow fadeInLeft animated">

                <tr>
                    <th></th>
                    <th class="xtheader">Yuzo</th>
                    <th class="xtheader">Zemanta</th>
                    <th class="xtheader">Yet Another</th>
                    <th class="xtheader">Contextual</th>
                </tr>
                
                <tr>
                    <td class="feature_plugin">Widget</td>
                    <td><i class="fa fa-check"></i></td>
                    <td><i class="fa fa-check"></i></td>
                    <td><i class="fa fa-check"></i></td>
                    <td><i class="fa fa-check"></i></td>
                </tr>
                <tr>
                    <td class="feature_plugin">PHP function</td>
                    <td><i class="fa fa-check"></i></td>
                    <td><i class="fa fa-check"></i></td>
                    <td><i class="fa fa-check"></i></td>
                    <td><i class="fa fa-check"></i></td>
                </tr>
                <tr>
                    <td class="feature_plugin">Several Layout</td>
                    <td><i class="fa fa-check"></i></td>
                    <td><i class="fa fa-check"></i></td>
                    <td><i class="fa fa-check"></i></td>
                    <td><i class="fa fa-times"></i></td>
                </tr>
                <tr>
                    <td class="feature_plugin">Completely free</td>
                    <td><i class="fa fa-check"></i></td>
                    <td><i class="fa fa-check"></i></td>
                    <td><i class="fa fa-times"></i></td>
                    <td><i class="fa fa-check"></i></td>
                </tr>
                <tr>
                    <td class="feature_plugin">Metabox</td>
                    <td><i class="fa fa-check"></i></td>
                    <td><i class="fa fa-times"></i></td>
                    <td><i class="fa fa-check"></i></td>
                    <td><i class="fa fa-check"></i></td>
                </tr>
                <tr>
                    <td class="feature_plugin">Disabled by tags</td>
                    <td><i class="fa fa-check"></i></td>
                    <td><i class="fa fa-times"></i></td>
                    <td><i class="fa fa-check"></i></td>
                    <td><i class="fa fa-times"></i></td>
                </tr>
                <tr>
                    <td class="feature_plugin">Fast</td>
                    <td><i class="fa fa-check"></i></td>
                    <td><i class="fa fa-times"></i></td>
                    <td><i class="fa fa-times"></i></td>
                    <td><i class="fa fa-check"></i></td>
                </tr>
                <tr>
                    <td class="feature_plugin">Disabled in archive page</td>
                    <td><i class="fa fa-check"></i></td>
                    <td><i class="fa fa-times"></i></td>
                    <td><i class="fa fa-times"></i></td>
                    <td><i class="fa fa-check"></i></td>
                </tr>

                <tr>
                    <td class="feature_plugin">Cache query sql</td>
                    <td><i class="fa fa-check"></i></td>
                    <td><i class="fa fa-times"></i></td>
                    <td><i class="fa fa-times"></i></td>
                    <td><i class="fa fa-check"></i></td>
                </tr>
                <tr>
                    <td class="feature_plugin">Advanced Options</td>
                    <td><i class="fa fa-check"></i></td>
                    <td><i class="fa fa-times"></i></td>
                    <td><i class="fa fa-times"></i></td>
                    <td><i class="fa fa-check"></i></td>
                </tr>


                <tr>
                    <td class="feature_plugin">Super Widget</td>
                    <td><i class="fa fa-check"></i></td>
                    <td><i class="fa fa-times"></i></td>
                    <td><i class="fa fa-times"></i></td>
                    <td><i class="fa fa-times"></i></td>
                </tr>
                <tr>
                    <td class="feature_plugin">Super Metabox</td>
                    <td><i class="fa fa-check"></i></td>
                    <td><i class="fa fa-times"></i></td>
                    <td><i class="fa fa-times"></i></td>
                    <td><i class="fa fa-times"></i></td>
                </tr>

                <tr>
                    <td class="feature_plugin">Include/Exclude per post</td>
                    <td><i class="fa fa-check"></i></td>
                    <td><i class="fa fa-times"></i></td>
                    <td><i class="fa fa-times"></i></td>
                    <td><i class="fa fa-times"></i></td>
                </tr>
                <tr>
                    <td class="feature_plugin">Counter visits</td>
                    <td><i class="fa fa-check"></i></td>
                    <td><i class="fa fa-times"></i></td>
                    <td><i class="fa fa-times"></i></td>
                    <td><i class="fa fa-times"></i></td>
                </tr>
                <tr>
                    <td class="feature_plugin">Visits in admin post</td>
                    <td><i class="fa fa-check"></i></td>
                    <td><i class="fa fa-times"></i></td>
                    <td><i class="fa fa-times"></i></td>
                    <td><i class="fa fa-times"></i></td>
                </tr>
                <tr>
                    <td class="feature_plugin">Disabled in specific post</td>
                    <td><i class="fa fa-check"></i></td>
                    <td><i class="fa fa-times"></i></td>
                    <td><i class="fa fa-times"></i></td>
                    <td><i class="fa fa-times"></i></td>
                </tr>
                <tr>
                    <td class="feature_plugin">Cache image</td>
                    <td><i class="fa fa-check"></i></td>
                    <td><i class="fa fa-times"></i></td>
                    <td><i class="fa fa-times"></i></td>
                    <td><i class="fa fa-times"></i></td>
                </tr>

                <tr>
                    <td class="feature_plugin">Visual Effects</td>
                    <td><i class="fa fa-check"></i></td>
                    <td><i class="fa fa-times"></i></td>
                    <td><i class="fa fa-times"></i></td>
                    <td><i class="fa fa-times"></i></td>
                </tr>
                <tr>
                    <td class="feature_plugin">Customizing text</td>
                    <td><i class="fa fa-check"></i></td>
                    <td><i class="fa fa-times"></i></td>
                    <td><i class="fa fa-times"></i></td>
                    <td><i class="fa fa-times"></i></td>
                </tr>
                <tr>
                    <td class="feature_plugin">Customizing image</td>
                    <td><i class="fa fa-check"></i></td>
                    <td><i class="fa fa-times"></i></td>
                    <td><i class="fa fa-times"></i></td>
                    <td><i class="fa fa-times"></i></td>
                </tr>
                <tr>
                    <td class="feature_plugin">Margin/Padding per related</td>
                    <td><i class="fa fa-check"></i></td>
                    <td><i class="fa fa-times"></i></td>
                    <td><i class="fa fa-times"></i></td>
                    <td><i class="fa fa-times"></i></td>
                </tr>

            </table>
        </div>
        <?php elseif( isset($_GET['tab']) && $_GET['tab']=='ilenframework' ): ?>
        <div class="page--yuzo__ilenframework">
            
            <div class="side_a wow fadeInLeft animated" data-wow-delay="0.3s" data-wow-duration="0.8s">
                <img src="<?php echo $IF_CONFIG->parameter["theme_imagen"] ?>/ilenframework_code.png" />
            </div>
            <div class="side_b wow fadeInRight animated" data-wow-delay="1s" data-wow-duration="1s">
                <h3>After a long work, time, training  and find the best practices to program wordpress, I created a core which helps me to create cool plugin as it is Yuzo.</h3>
            </div>

        </div>

        <?php elseif( isset($_GET['tab']) && $_GET['tab']=='support' ): ?>

        <div class="page--yuzo__support">
            
            <div class="side_a wow fadeInUp animated" data-wow-delay="0.5s">
                <img style="margin-top: 13px;" src="<?php echo $IF_CONFIG->parameter["theme_imagen"] ?>/free.jpg" />
            </div>
            <div class="side_b">
                <h3 class="wow fadeInUp animated" data-wow-delay="0.5s">Yuzo related post attend only support directly from <a href="http://support.ilentheme.com" target="_blank">support.ilentheme.com</a> since that is the official website of the plugin.</h3>
                  <blockquote class="groucho wow fadeInUp animated" data-wow-delay="0.8s">
                    Work like you don't need the money, love like you've never been hurt and dance like no one is watching.
                    <footer>Randall G Leighton</footer>
                  </blockquote>
            </div>

        </div>

        <?php endif; ?>


        <hr />
        <div style="clear:both;width:100%;"><p  style="text-align:center"><strong style="font-weight:bold;">Possibly the best WordPress Related Post ;)</strong></p><p style="text-align:center;maring:0 auto;"><span class="ilen_shine" style="display:inline-block;width:114px;height:51px;"><span class="shine-effect"></span><img  src="<?php echo $IF_CONFIG->parameter["theme_imagen"] ?>/wordpress-and-love.png" /></span> <BR /><a target="_blank" href="https://wordpress.org/support/view/plugin-reviews/yuzo-related-post?filter=5">Vote for this plugin</a></p></div>


    </div>
</div>
<script>

jQuery(document).ready(function($){

    $(".feature").on("mouseover mouseout",function(){
        if (event.type == 'mouseover') {
            $("#overlay").addClass("visible");
        } else {
            $("#overlay").removeClass("visible");
        }
    });

   


});
 new WOW().init();
</script>