<?php
/*
Plugin Name: Yuzo  ̵ ̵ ̵  Related Post
Plugin URI: https://wordpress.org/plugins/yuzo-related-post/
Description: Gets the related post on your blog with any design characteristics.
Version: 3.4
Author: iLen
Author URI: http://es.ilentheme.com
*/
if ( !class_exists('yuzo_related_post') ) {
// get utils
require_once 'assets/ilenframework/assets/lib/utils.php';
require_once 'assets/functions/options.php';
class yuzo_related_post extends yuzo_related_post_make{

  var $plugin_options = null;

  function __construct(){

    parent::__construct(); // configuration general


    global $yuzo_options;

    // get option plugin ;)
    $yuzo_options = IF_get_option( $this->parameter['name_option'] );
    $this->plugin_options = $yuzo_options;

    // ajax nonce for count visits in cache
    if(  defined( 'WP_CACHE' ) && WP_CACHE ){
      add_action( 'wp_enqueue_scripts',  array( &$this, 'wp_yuzo_postview_cache_count_enqueue') );
      add_action( 'wp_ajax_nopriv_yuzo-plus-views', array( &$this, 'hits_ajax' ) );
      add_action( 'wp_ajax_yuzo-plus-views', array( &$this, 'hits_ajax' ) );
    }else{
      add_action('wp_head',array( &$this,'hits'), 12 );
    }

    if( is_admin() ){

      add_action( 'admin_enqueue_scripts', array( &$this,'script_and_style_admin' ) );

      if( isset($yuzo_options->show_columns_dashboard) && $yuzo_options->show_columns_dashboard ){
        //Hooks a function to a specific filter action.
        //applied to the list of columns to print on the manage posts screen.
        add_filter('manage_posts_columns', array( &$this,'yuzo_post_column_views') );
         
        //Hooks a function to a specific action. 
        //allows you to add custom columns to the list post/custom post type pages.
        //'10' default: specify the function's priority.
        //and '2' is the number of the functions' arguments.
        add_action('manage_posts_custom_column', array( &$this,'yuzo_post_custom_column_views'),10,2 );
      }

    }elseif( ! is_admin() ) {

      if( isset($yuzo_options->automatically_append) &&  $yuzo_options->automatically_append =='1' ){
        
        add_action('the_content',array( &$this,'create_post_related'),10 );


      }

      // add scripts & styles
      add_action( 'wp_enqueue_scripts', array( &$this,'script_and_style_front' ) );
 


      // count hit post
      /*if(  !defined( 'WP_CACHE' ) || !WP_CACHE ){
        add_action('wp_head',array( &$this,'hits'), 12 );
      }*/


    }




  }

 
 

  // MAKE HTML of PLUGIN
  function create_post_related( $content ){

      global $post,$yuzo_options,$wp_query;  
      $orig_post = $post;



      $style = "";
      $script = "";

      // if active Only home page
      if( (isset($yuzo_options->show_only_home) && $yuzo_options->show_only_home) && (!is_home() || !is_front_page() ) ) return $content;

      // get no categories
      $array_no_category=array();
      $string_no_category="";
      if( isset($yuzo_options->exclude_category) && is_array($yuzo_options->exclude_category) ){    

        if( ! in_array( '-1',$yuzo_options->exclude_category ) ){    
          foreach ($yuzo_options->exclude_category as $ce_key => $ce_value) {
            $array_no_category[]=$ce_value;
          }
        }

      }
        
      $_html = "";
      $_html .= "<div class='yuzo_related_post style-$yuzo_options->style'  data-version='{$this->parameter["version"]}'>";

     if( $wp_query->post_count != 0 ){ // if have result in loop post

         // verify type page
         $post_type = get_post_type( $post->ID );
         if( $post_type ){
           if( ! in_array($post_type, (array)$yuzo_options->post_type ) ){
            return $content;
           }
         }

             // is show home
            if( isset($yuzo_options->show_home) && !$yuzo_options->show_home  && is_home() ){

                return $content;

            }

      $array_categorias = $yuzo_options->categories;
      $categories =  get_the_category($post->ID);
      if($categories){
        foreach ($categories as $key_ => $value_) {
          $category_plugin[]=(string)$value_->cat_ID;
        }
      }

      if( is_array($array_categorias) && is_array($category_plugin) ){
        if( ! in_array( '-1',$array_categorias ) ){

          $bFound = (count(array_intersect($category_plugin, $array_categorias))) ? true : false; 

          if( $bFound == false ){
            return $content;
          }

        }
      }

      $tag_ids = array();
      $string_cate = "";
      $string_tags = "";
      if( $yuzo_options->related_to == '3' ){
        $tags = wp_get_post_tags($post->ID);
          if ($tags) {  
            $tag_ids = array();
            foreach($tags as $individual_tag) $tag_ids[] = $individual_tag->term_id;
          }
   
          $string_tags =  $tag_ids;
          $string_cate = $category_plugin;
      }elseif( $yuzo_options->related_to == '1' ){

        $tags = wp_get_post_tags($post->ID);
          if ($tags) {  
            $tag_ids = array();  
            foreach($tags as $individual_tag) $tag_ids[] = $individual_tag->term_id;
          }

          //$string_tags =  implode(",",$tag_ids);
          $string_tags =  $tag_ids;

      }elseif( $yuzo_options->related_to == '2' ){

        $string_cate = $category_plugin;

      }elseif( $yuzo_options->related_to == '4' ){

        $string_order_by = 'rand';

      }

      $string_order_by = $yuzo_options->order_by;
      $string_order    = $yuzo_options->order;

      $post__not_in[] = $post->ID;
      $args        = array('post__not_in' => $post__not_in,
                    'posts_per_page'      => (int)$yuzo_options->display_post,
                    //'tag__in'           => $string_tags,
                    'post_type'           => (array)$yuzo_options->post_type,
                    'post_status'         => 'publish',
                    'ignore_sticky_posts' => 1,
                    'orderby'             => $string_order_by,
                    'order'               => $string_order,
                    'tag__in'             => $tag_ids,
                    'category__in'        => $string_cate,
                    'category__not_in'    => $array_no_category
                    //'cat'               =>$string_no_category
                  );

      query_posts( $args );  

      }


      $my_array_views = array();
      if( have_posts() && $wp_query->post_count != 0 ){

        // set transitions
        $css_transitions = null;
        if(  isset($yuzo_options->bg_color_hover_transitions) && $yuzo_options->bg_color_hover_transitions ){
          $css_transitions = " -webkit-transition: background {$yuzo_options->bg_color_hover_transitions}s linear; -moz-transition: background {$yuzo_options->bg_color_hover_transitions}s linear; -o-transition: background {$yuzo_options->bg_color_hover_transitions}s linear; transition: background {$yuzo_options->bg_color_hover_transitions}s linear;";
        }

        // border radius
        $css_border = null;
        if( isset($yuzo_options->thumbnail_border_radius) && $yuzo_options->thumbnail_border_radius ){
          $css_border = " border-radius: {$yuzo_options->thumbnail_border_radius}% ";

          if(  $yuzo_options->thumbnail_border_radius == 50 ){
            $css_border = " border-radius: {$yuzo_options->thumbnail_border_radius}%; margin:0 auto; width:".((int)$yuzo_options->height_image - 20)."px";
          }
        }

        // margin related
        $css_margin = null;
        if( isset($yuzo_options->related_margin) && $yuzo_options->related_margin ){
          $css_margin = " margin: {$yuzo_options->related_margin->top}px  {$yuzo_options->related_margin->right}px  {$yuzo_options->related_margin->bottom}px  {$yuzo_options->related_margin->left}px; ";
        }

        // padding related
        $css_padding = null;
        if( isset($yuzo_options->related_padding) && $yuzo_options->related_padding ){
          $css_padding = " padding: {$yuzo_options->related_padding->top}px  {$yuzo_options->related_padding->right}px  {$yuzo_options->related_padding->bottom}px  {$yuzo_options->related_padding->left}px; ";
        }

        // effects visual
        $css_effects = self::effects();
        $css_shine_effect1="";
        $css_shine_effect2="";
        if( isset($yuzo_options->effect_related) && $yuzo_options->effect_related == 'shine' ){
          $css_shine_effect1=" ilen_shine ";
          $css_shine_effect2=" <span class='shine-effect'></span> ";
        }

 
        $count = 1;
        if( isset($yuzo_options->top_text) && $yuzo_options->top_text ){
          $_html .= "<div class='yuzo_clearfixed'>". IF_setHtml( $yuzo_options->top_text ) ."</div>";
        }

        while ( have_posts() ) : the_post();

          $my_array_views = self::getViewsPost_to_yuzo();
          $bold_title = "";
          $text2_extract = "";
          if( $yuzo_options->title_bold =='1'){
            $bold_title = "font-weight:bold";
          }
          if( (int)$yuzo_options->text2_length > 0 ){
            $text2_extract = '<span class="yuzo_text" style="font-size:'.((int)$yuzo_options->font_size - 4).'px;" >'.IF_setHtml( self::yuzo_extract_title( strip_tags( get_the_content() ), (int)$yuzo_options->text2_length ) ).'</span>';
          }
 
                if( $yuzo_options->style == 1 ){
                    $image = IF_get_image(  $yuzo_options->thumbnail_size, $yuzo_options->default_image );
              $_html .= '
              <div class="relatedthumb " style="width:'.((int)$yuzo_options->height_image + 15).'px;float:left;overflow:hidden;">  
                  
                  <a rel="external" href="'.get_permalink().'">
                          <div class="yuzo-img-wrap '.$css_shine_effect1.'" style="width: '.((int)$yuzo_options->height_image+15).'px;height:'.((int)$yuzo_options->height_image - 20).'px;">
                            '.$css_shine_effect2.'
                            <div class="yuzo-img" style="background:url('.$image['src'].') 50% 50% no-repeat;width: '.((int)$yuzo_options->height_image+15).'px;height:'.((int)$yuzo_options->height_image - 20).'px;margin-bottom: 5px;background-size: cover; '.$css_border.'"></div>
                          </div>
                            <div>'.$my_array_views['top'].'</div>
                       <span style="font-size:'.$yuzo_options->font_size.'px;'.$bold_title.';">'.IF_setHtml( self::yuzo_extract_title( get_the_title(), $yuzo_options->text_length ) ).'</span>
                  '.$text2_extract .'
                  <div>'.$my_array_views['bottom'].'</div>
                  </a>

              </div>';
              $style="<style>
                        .yuzo_related_post img{width:".((int)$yuzo_options->height_image + 10 )."px !important; height:{$yuzo_options->height_image}px !important;}
                        .yuzo_related_post .relatedthumb{line-height:".((int)$yuzo_options->font_size +2 )."px;background:{$yuzo_options->bg_color->color} !important;}
                        .yuzo_related_post .relatedthumb:hover{background:{$yuzo_options->bg_color->hover} !important;$css_transitions}
                        .yuzo_related_post .relatedthumb a{color:{$yuzo_options->title_color};}
                        .yuzo_related_post .yuzo_text {color:{$yuzo_options->text_color};}
                        .yuzo_related_post .relatedthumb{ $css_margin $css_padding }
                        $css_effects
                        </style>";

                    if ( ! isset($yuzo_options->yuzo_conflict) || ! $yuzo_options->yuzo_conflict ) {
                      $script="<script>
                      jQuery(function() {
                        jQuery('.yuzo_related_post').equalizer({ overflow : 'relatedthumb2' });
                      });
                      </script>";
                    }
                }elseif( $yuzo_options->style == 2 ){
                    $image = IF_get_image(  $yuzo_options->thumbnail_size, $yuzo_options->default_image );
                    $_html .= '
              <div class="relatedthumb yuzo-list"  >  
                  <a rel="external" href="'.get_permalink().'" class="image-list">
                  <div class="yuzo-img-wrap '.$css_shine_effect1.'" style="width: '.((int)$yuzo_options->height_image+15).'px;height:'.((int)$yuzo_options->height_image - 20).'px;">
                            '.$css_shine_effect2.'
                             <div class="yuzo-img" style="background:url('.$image['src'].') 50% 50% no-repeat;width: '.((int)$yuzo_options->height_image+20).'px;height:'.((int)$yuzo_options->height_image - 20).'px;margin-bottom: 5px;background-size: cover; '.$css_border.' "></div>
                  </div>
                  </a>
                  <a class="link-list" href="'.get_permalink().'" style="font-size:'.$yuzo_options->font_size.'px;'.$bold_title.';line-height:'.( (int)$yuzo_options->font_size + 8).'px;">'.$my_array_views['top'].' '.IF_setHtml( self::yuzo_extract_title( get_the_title(), $yuzo_options->text_length ) ).'  '.$my_array_views['bottom'].'</a></h3>
                        '.$text2_extract .'
                       
              </div>';
                    $style="<style>
                .yuzo_related_post .relatedthumb { background:{$yuzo_options->bg_color->color} !important;$css_transitions }
                .yuzo_related_post .relatedthumb:hover{background:{$yuzo_options->bg_color->hover} !important;}
                .yuzo_related_post .yuzo_text {color:{$yuzo_options->text_color};}
                .yuzo_related_post .relatedthumb a{color:{$yuzo_options->title_color};}
                .yuzo_related_post .relatedthumb{ $css_margin $css_padding }
                $css_effects
                </style>";
                    
                }elseif( $yuzo_options->style == 3 ){
                    //$image = IF_get_image(  $yuzo_options->thumbnail_size, $yuzo_options->default_image );
                    $_html .= '
                    <div class="relatedthumb yuzo-list"  >  
                        <a class="link-list" href="'.get_permalink().'" style="font-size:'.$yuzo_options->font_size.'px;'.$bold_title.';line-height:'.( (int)$yuzo_options->font_size + 8).'px;">'.$my_array_views['top'].' '.IF_setHtml( self::yuzo_extract_title( get_the_title(), $yuzo_options->text_length ) ).' '.$my_array_views['bottom'].'</a>  </h3>
                              '.$text2_extract .'
                    </div>';
                    $style="<style>
                .yuzo_related_post .relatedthumb{background:{$yuzo_options->bg_color->color} !important;$css_transitions}
                .yuzo_related_post .relatedthumb:hover{background:{$yuzo_options->bg_color->hover} !important;$css_transitions}
                .yuzo_related_post .yuzo_text {color:{$yuzo_options->text_color};}
                .yuzo_related_post .relatedthumb{ $css_margin $css_padding }
                </style>";
                    
                }elseif( $yuzo_options->style == 4 ){
                    //$image = IF_get_image(  $yuzo_options->thumbnail_size, $yuzo_options->default_image );
                    $_html .= '
                    <div class="relatedthumb yuzo-list-color color-'.$count.'"  >  
                        <a class="link-list" href="'.get_permalink().'" style="font-size:'.$yuzo_options->font_size.'px;'.$bold_title.';line-height:'.( (int)$yuzo_options->font_size + 8).'px;">'.$my_array_views['top'].' '.IF_setHtml( self::yuzo_extract_title( get_the_title(), $yuzo_options->text_length ) ).' '.$my_array_views['bottom'].'</a>  </h3>
                              '.$text2_extract .'
                    </div>';
                    $style="<style>
                    .yuzo_related_post .yuzo_text {color:{$yuzo_options->text_color};}
                    .yuzo_related_post .relatedthumb a{color:{$yuzo_options->title_color};}
                </style>";
                    
                }
                $count++;
        endwhile;

      }else{
      
        


        if( $yuzo_options->display_random  ){

        $args = array(
                'posts_per_page'   =>(int)$yuzo_options->display_post,
                'post_type'        => (array)$yuzo_options->post_type,
                'post_status'      => 'publish',
                'ignore_sticky_posts ' => 1,
                'orderby'          => 'rand'
               );
        query_posts( $args ); 


        // set transitions
        $css_transitions = null;
        if(  isset($yuzo_options->bg_color_hover_transitions) && $yuzo_options->bg_color_hover_transitions ){
          $css_transitions = " -webkit-transition: background {$yuzo_options->bg_color_hover_transitions}s linear; -moz-transition: background {$yuzo_options->bg_color_hover_transitions}s linear; -o-transition: background {$yuzo_options->bg_color_hover_transitions}s linear; transition: background {$yuzo_options->bg_color_hover_transitions}s linear;";
        }

        // border radius
        $css_border = null;
        if( isset($yuzo_options->thumbnail_border_radius) && $yuzo_options->thumbnail_border_radius ){
          $css_border = " border-radius: {$yuzo_options->thumbnail_border_radius}% ";

          if(  $yuzo_options->thumbnail_border_radius == 50 ){
            $css_border = " border-radius: {$yuzo_options->thumbnail_border_radius}%; margin:0 auto; width:".((int)$yuzo_options->height_image - 20)."px";
          }
        }

        // margin related
        $css_margin = null;
        if( isset($yuzo_options->related_margin) && $yuzo_options->related_margin ){
          $css_margin = " margin: {$yuzo_options->related_margin->top}px  {$yuzo_options->related_margin->right}px  {$yuzo_options->related_margin->bottom}px  {$yuzo_options->related_margin->left}px; ";
        }

        // padding related
        $css_padding = null;
        if( isset($yuzo_options->related_padding) && $yuzo_options->related_padding ){
          $css_padding = " padding: {$yuzo_options->related_padding->top}px  {$yuzo_options->related_padding->right}px  {$yuzo_options->related_padding->bottom}px  {$yuzo_options->related_padding->left}px; ";
        }

        // effects visual
        $css_effects = self::effects();
        $css_shine_effect1="";
        $css_shine_effect2="";
        if( isset($yuzo_options->effect_related) && $yuzo_options->effect_related == 'shine' ){
          $css_shine_effect1=" ilen_shine ";
          $css_shine_effect2=" <span class='shine-effect'></span> ";
        }

 
        $count = 1;
        if( isset($yuzo_options->top_text) && $yuzo_options->top_text ){
          $_html .= "<div class='yuzo_clearfixed'>". IF_setHtml( $yuzo_options->top_text ) ."</div>";
        }
        while ( have_posts() ) : the_post();

          $my_array_views = self::getViewsPost_to_yuzo();
          $bold_title = "";
          $text2_extract = "";
          if( $yuzo_options->title_bold =='1'){
            $bold_title = "font-weight:bold";
          }
          if( (int)$yuzo_options->text2_length > 0 ){
            $text2_extract = '<span class="yuzo_text" style="font-size:'.((int)$yuzo_options->font_size - 4).'px;" >'.IF_setHtml( self::yuzo_extract_title( strip_tags( get_the_content() ), (int)$yuzo_options->text2_length ) ).'</span>';
          }
 
                if( $yuzo_options->style == 1 ){
                    $image = IF_get_image(  $yuzo_options->thumbnail_size, $yuzo_options->default_image );
              $_html .= '
              <div class="relatedthumb " style="width:'.((int)$yuzo_options->height_image + 15).'px;float:left;overflow:hidden;">  
                  
                  <a rel="external" href="'.get_permalink().'">
                          <div class="yuzo-img-wrap '.$css_shine_effect1.'" style="width: '.((int)$yuzo_options->height_image+15).'px;height:'.((int)$yuzo_options->height_image - 20).'px;">
                            '.$css_shine_effect2.'
                            <div class="yuzo-img" style="background:url('.$image['src'].') 50% 50% no-repeat;width: '.((int)$yuzo_options->height_image+15).'px;height:'.((int)$yuzo_options->height_image - 20).'px;margin-bottom: 5px;background-size: cover; '.$css_border.'"></div>
                          </div>
                            <div>'.$my_array_views['top'].'</div>
                       <span style="font-size:'.$yuzo_options->font_size.'px;'.$bold_title.';">'.IF_setHtml( self::yuzo_extract_title( get_the_title(), $yuzo_options->text_length ) ).'</span>
                  '.$text2_extract .'
                  <div>'.$my_array_views['bottom'].'</div>
                  </a>

              </div>';
              $style="<style>
                        .yuzo_related_post img{width:".((int)$yuzo_options->height_image + 10 )."px !important; height:{$yuzo_options->height_image}px !important;}
                        .yuzo_related_post .relatedthumb{line-height:".((int)$yuzo_options->font_size +2 )."px;background:{$yuzo_options->bg_color->color} !important;}
                        .yuzo_related_post .relatedthumb:hover{background:{$yuzo_options->bg_color->hover} !important;$css_transitions}
                        .yuzo_related_post .relatedthumb a{color:{$yuzo_options->title_color};}
                        .yuzo_related_post .yuzo_text {color:{$yuzo_options->text_color};}
                        .yuzo_related_post .relatedthumb{ $css_margin $css_padding }
                        $css_effects
                        </style>";

                    if ( ! isset($yuzo_options->yuzo_conflict) || ! $yuzo_options->yuzo_conflict ) {
                      $script="<script>
                      jQuery(function() {
                        jQuery('.yuzo_related_post').equalizer({ overflow : 'relatedthumb2' });
                      });
                      </script>";
                    }
                }elseif( $yuzo_options->style == 2 ){
                    $image = IF_get_image(  $yuzo_options->thumbnail_size, $yuzo_options->default_image );
                    $_html .= '
              <div class="relatedthumb yuzo-list"  >  
                  <a rel="external" href="'.get_permalink().'" class="image-list">
                  <div class="yuzo-img-wrap '.$css_shine_effect1.'" style="width: '.((int)$yuzo_options->height_image+15).'px;height:'.((int)$yuzo_options->height_image - 20).'px;">
                            '.$css_shine_effect2.'
                             <div class="yuzo-img" style="background:url('.$image['src'].') 50% 50% no-repeat;width: '.((int)$yuzo_options->height_image+20).'px;height:'.((int)$yuzo_options->height_image - 20).'px;margin-bottom: 5px;background-size: cover; '.$css_border.' "></div>
                  </div>
                  </a>
                  <a class="link-list" href="'.get_permalink().'" style="font-size:'.$yuzo_options->font_size.'px;'.$bold_title.';line-height:'.( (int)$yuzo_options->font_size + 8).'px;">'.$my_array_views['top'].' '.IF_setHtml( self::yuzo_extract_title( get_the_title(), $yuzo_options->text_length ) ).'  '.$my_array_views['bottom'].'</a></h3>
                        '.$text2_extract .'
                       
              </div>';
                    $style="<style>
                .yuzo_related_post .relatedthumb { background:{$yuzo_options->bg_color->color} !important;$css_transitions }
                .yuzo_related_post .relatedthumb:hover{background:{$yuzo_options->bg_color->hover} !important;}
                .yuzo_related_post .yuzo_text {color:{$yuzo_options->text_color};}
                .yuzo_related_post .relatedthumb a{color:{$yuzo_options->title_color};}
                .yuzo_related_post .relatedthumb{ $css_margin $css_padding }
                $css_effects
                </style>";
                    
                }elseif( $yuzo_options->style == 3 ){
                    //$image = IF_get_image(  $yuzo_options->thumbnail_size, $yuzo_options->default_image );
                    $_html .= '
                    <div class="relatedthumb yuzo-list"  >  
                        <a class="link-list" href="'.get_permalink().'" style="font-size:'.$yuzo_options->font_size.'px;'.$bold_title.';line-height:'.( (int)$yuzo_options->font_size + 8).'px;">'.$my_array_views['top'].' '.IF_setHtml( self::yuzo_extract_title( get_the_title(), $yuzo_options->text_length ) ).' '.$my_array_views['bottom'].'</a>  </h3>
                              '.$text2_extract .'
                    </div>';
                    $style="<style>
                .yuzo_related_post .relatedthumb{background:{$yuzo_options->bg_color->color} !important;$css_transitions}
                .yuzo_related_post .relatedthumb:hover{background:{$yuzo_options->bg_color->hover} !important;$css_transitions}
                .yuzo_related_post .yuzo_text {color:{$yuzo_options->text_color};}
                .yuzo_related_post .relatedthumb{ $css_margin $css_padding }
                </style>";
                    
                }elseif( $yuzo_options->style == 4 ){
                    //$image = IF_get_image(  $yuzo_options->thumbnail_size, $yuzo_options->default_image );
                    $_html .= '
                    <div class="relatedthumb yuzo-list-color color-'.$count.'"  >  
                        <a class="link-list" href="'.get_permalink().'" style="font-size:'.$yuzo_options->font_size.'px;'.$bold_title.';line-height:'.( (int)$yuzo_options->font_size + 8).'px;">'.$my_array_views['top'].' '.IF_setHtml( self::yuzo_extract_title( get_the_title(), $yuzo_options->text_length ) ).' '.$my_array_views['bottom'].'</a>  </h3>
                              '.$text2_extract .'
                    </div>';
                    $style="<style>
                    .yuzo_related_post .yuzo_text {color:{$yuzo_options->text_color};}
                    .yuzo_related_post .relatedthumb a{color:{$yuzo_options->title_color};}
                </style>";
                    
                }
                $count++;
        endwhile;
 
          
        }
    }
      
    $_html .= "</div>$style $script";
      
    $post = $orig_post;  
    
    // Reset Query
    wp_reset_query(); 
  
    return $content.$_html;
  }

  
  function script_and_style_admin(){

    if( isset($_GET["page"]) &&  $_GET["page"] == $this->parameter["id_menu"] ){
        wp_enqueue_script( 'admin-js-'.$this->parameter["name_option"], plugins_url('/assets/js/admin.js',__FILE__), array( 'jquery' ), $this->parameter['version'], true );
        // Register styles
        wp_register_style( 'admin-css-'.$this->parameter["name_option"], plugins_url('/assets/css/admin.css',__FILE__),'all',$this->parameter['version'] );
        // Enqueue styles
        wp_enqueue_style( 'admin-css-'.$this->parameter["name_option"] );
    }

  }


  function script_and_style_front(){

    global $yuzo_options;

    // Register styles
    wp_register_style( 'front-css-'.$this->parameter["name_option"], plugins_url('/assets/css/style.css',__FILE__),'all',$this->parameter['version'] );
    // Enqueue styles
    wp_enqueue_style( 'front-css-'.$this->parameter["name_option"] );

    if ( ! isset($yuzo_options->yuzo_conflict) || ! $yuzo_options->yuzo_conflict ) {
      wp_enqueue_script( 'front-js-'.$this->parameter["name_option"], plugins_url('/assets/js/jquery.equalizer.js',__FILE__), array( 'jquery' ), '1.2.5', true );
    }

    // RTL!
    if( is_rtl() ){

      // Register styles
      wp_register_style( 'front-css-rtl-'.$this->parameter["name_option"], plugins_url('/assets/css/rtl.css',__FILE__),'all',$this->parameter['version'] );
      // Enqueue styles
      wp_enqueue_style( 'front-css-rtl-'.$this->parameter["name_option"] );

    }

  }


function yuzo_extract_title(  $text = "",  $length = 30 ){
  //code 
  $excert  = trim( $text );
  if( strlen( $excert  ) > (int)$length )
    $title = substr( $excert , 0 , (int)$length )."...";
  else
    $title = substr( $excert , 0 , (int)$length );
  
  return $title;

}


function effects(){

   global $yuzo_options;

   $css_effects = null;
   if( isset( $yuzo_options->effect_related ) ){

      if( $yuzo_options->effect_related == 'enlarge' ){
        /* link: http://santyweb.blogspot.com/2011/06/css-agrandar-imagenes-o-texto-al-pasar.html */
        $css_effects = ".yuzo_related_post .relatedthumb{
display:block!important;
-webkit-transition:-webkit-transform 0.3s ease-out!important;
-moz-transition:-moz-transform 0.3s ease-out!important;
-o-transition:-o-transform 0.3s ease-out!important;
-ms-transition:-ms-transform 0.3s ease-out!important;
transition:transform 0.3s ease-out!important;
}
.yuzo_related_post .relatedthumb:hover{
-moz-transform: scale(1.1);
-webkit-transform: scale(1.1);
-o-transform: scale(1.1);
-ms-transform: scale(1.1);
transform: scale(1.1)
}";
      }elseif( $yuzo_options->effect_related == 'zoom_icon_link' ){
        /* link: http://santyweb.blogspot.com/2011/06/css-agrandar-imagenes-o-texto-al-pasar.html */
        $css_effects = ".yuzo_related_post .relatedthumb .yuzo-img{
  -webkit-transition:all 0.3s ease-out;
  -moz-transition:all 0.3s ease-out;
  -o-transition:all 0.3s ease-out;
  -ms-transition:all 0.3s ease-out;
  transition:all 0.3s ease-out;
}
.yuzo_related_post .relatedthumb .yuzo-img-wrap{
  overflow:hidden;
  background: url(".$this->parameter['theme_imagen']."/link-overlay.png) no-repeat center;
}
.yuzo_related_post .relatedthumb:hover .yuzo-img {
  opacity: 0.7;
  -webkit-transform: scale(1.2);
  transform: scale(1.2);
}";
      }
      elseif( $yuzo_options->effect_related == 'shine' ){
        $css_effects = ".yuzo_related_post .relatedthumb{}";
      }


      
      
   }


   return $css_effects;


}

function hits( $content ="" ){

  if(!is_singular()) return;

  //Set the name of the Posts Custom Field.
  $count_key = 'yuzo_views'; 
  $post_ID = get_the_ID();

  //Returns values of the custom field with the specified key from the specified post.
  $count = get_post_meta($post_ID, $count_key, true);
   
  //If the the Post Custom Field value is empty. 
  if($count == ''){
      $count = 1; // set the counter to zero.
       
      //Delete all custom fields with the specified key from the specified post. 
      delete_post_meta($post_ID, $count_key);
       
      //Add a custom (meta) field (Name/value)to the specified post.
      add_post_meta($post_ID, $count_key, '1');
      //return (int)$count;
   
  //If the the Post Custom Field value is NOT empty.
  }else{

      $count++; //increment the counter by 1.
      //Update the value of an existing meta key (custom field) for the specified post.
      update_post_meta($post_ID, $count_key, $count);
       
      //If statement, is just to have the singular form 'View' for the value '1'
      //if($count == '1'){
      //return (int)$count;
      //}
      //In all other cases return (count) Views
      //else {
      //return (int)$count . ' Views';
      //}
  }


  return $content;

}

function hits_ajax(){

  if(!$_GET['is_singular']) return;

  //Set the name of the Posts Custom Field.
  $count_key = 'yuzo_views'; 
  $post_ID = (int)$_GET["postviews_id"];

  //Returns values of the custom field with the specified key from the specified post.
  $count = get_post_meta($post_ID, $count_key, true);

  //If the the Post Custom Field value is empty. 
  if($count == ''){
      $count = 1; // set the counter to zero.
      //Delete all custom fields with the specified key from the specified post. 
      delete_post_meta($post_ID, $count_key);
       
      //Add a custom (meta) field (Name/value)to the specified post.
      add_post_meta($post_ID, $count_key, '1');
      //return (int)$count;
  }else{

      $count++; //increment the counter by 1.
      update_post_meta($post_ID, $count_key, $count);
 
  }

  exit;

}








/*********************************CODE-3********************************************
* @Author: Boutros AbiChedid 
* @Date:   January 16, 2012
* @Websites: http://bacsoftwareconsulting.com/ ; http://blueoliveonline.com/
* @Description: Adds a Non-Sortable 'Views' Columnn to the Post Tab in WP dashboard.
* This code requires CODE-1(and CODE-2) as a prerequesite.
* Code is browser and JavaScript independent.
* @Tested on: WordPress version 3.2.1
***********************************************************************************/

//Gets the  number of Post Views to be used later.
function yuzo_get_PostViews($post_ID, $count_key = 'yuzo_views'){

    global $yuzo_options; 


    if( isset($yuzo_options->meta_views) && $yuzo_options->meta_views == 'other' ){
      $count_key = isset($yuzo_options->meta_views_custom)? $yuzo_options->meta_views_custom:'';
    }
    //Returns values of the custom field with the specified key from the specified post.
    if( $count_key ){
      $count = get_post_meta($post_ID, $count_key, true);
    }
 
    return (int)$count;
}
   
//Function that Adds a 'Views' Column to your Posts tab in WordPress Dashboard.
function yuzo_post_column_views($newcolumn){
    //Retrieves the translated string, if translation exists, and assign it to the 'default' array.
    $newcolumn['yuzo_post_views'] = __('Views',$this->parameter['name_option']);
    return $newcolumn;
}
 
//Function that Populates the 'Views' Column with the number of views count.
function yuzo_post_custom_column_views($column_name, $id){
     
    if($column_name === 'yuzo_post_views'){
        // Display the Post View Count of the current post.
        // get_the_ID() - Returns the numeric ID of the current post.
        echo self::yuzo_get_PostViews(get_the_ID());
    }

}


function getViewsPost_to_yuzo(){

  global $yuzo_options;

  // Display Views
  $counts = 0;
  $meta_views_top = "";
  $meta_views_bottom = "";
  if( isset($yuzo_options->meta_views) && $yuzo_options->meta_views && isset($yuzo_options->show_in_related_post) && $yuzo_options->show_in_related_post ){

    // get count
    if( $yuzo_options->meta_views == 'yuzo-views' ){

      $counts = self::yuzo_get_PostViews( get_the_ID() );

    }elseif( $yuzo_options->meta_views == 'other' ){

      $meta_views_custom = isset( $yuzo_options->meta_views_custom )?$yuzo_options->meta_views_custom:'';
      $counts = self::yuzo_get_PostViews( get_the_ID(), $meta_views_custom  );

    }

    //get postition
    if( isset( $yuzo_options->show_in_related_post_position ) && $yuzo_options->show_in_related_post_position ){

      $text_views = "";
      $class_views= "";
      if( isset(  $yuzo_options->show_in_related_post_text ) && $yuzo_options->show_in_related_post_text ){
        $text_views = $yuzo_options->show_in_related_post_text;
      }

      /*if( isset(  $yuzo_options->show_in_related_post_text ) && !$yuzo_options->show_in_related_post_text ){
        $class_views = 'yuzo_icon_views';
      }*/

      if( $yuzo_options->show_in_related_post_position == 'show-views-top' ){
        $meta_views_top = "<div class='yuzo_views_post yuzo_icon_views yuzo_icon_views__top' style='font-size:".((int)$yuzo_options->font_size - 2)."px;'>$text_views $counts</div>";
      }elseif( $yuzo_options->show_in_related_post_position == 'show-views-bottom' ){
        $meta_views_bottom = "<div class='yuzo_views_post yuzo_icon_views yuzo_icon_views__bottom' style='font-size:".((int)$yuzo_options->font_size - 2)."px;'>$text_views $counts</div>";
      }

    }


  }

  $array_views_yuzo_post = array();

  $array_views_yuzo_post['top'] = $meta_views_top;
  $array_views_yuzo_post['bottom'] = $meta_views_bottom;

  return $array_views_yuzo_post;

}



### Function: Calculate Post Views With WP_CACHE Enabled
function wp_yuzo_postview_cache_count_enqueue() {

  global $post;
  
  if( !defined( 'WP_CACHE' ) || !WP_CACHE )
    return;
  
  if ( !wp_is_post_revision( $post ) && ( is_single() || is_page() ) ) {

      wp_enqueue_script( 'wp-yuzo-postviews-cache', plugin_dir_url( __FILE__ ) . 'assets/js/yuzo-postviews-cache.js' , array( 'jquery' ), $this->parameter['version'] , true );
      wp_localize_script( 'wp-yuzo-postviews-cache', 'viewsCacheL10n', array( 'admin_ajax_url' => admin_url( 'admin-ajax.php' ), 'post_id' => intval( $post->ID ), 'is_singular' => is_singular()?'1':''  ) );
    
  }
}
 


} // end class
} // end if

 
global $IF_CONFIG;
unset($IF_CONFIG);
$IF_CONFIG = null;
$IF_CONFIG = new yuzo_related_post;

require_once "assets/ilenframework/core.php";



function get_yuzo_related_posts($content=""){
  
  global $IF_CONFIG;

  echo $IF_CONFIG->create_post_related($content);
  
}


function get_Yuzo_Views(){

  global $IF_CONFIG;

  if( isset($IF_CONFIG->plugin_options->meta_views) && $IF_CONFIG->plugin_options->meta_views ){

    // get count
    if( $IF_CONFIG->plugin_options->meta_views == 'yuzo-views' ){

      $counts = $IF_CONFIG->yuzo_get_PostViews( get_the_ID() );

    }elseif( $IF_CONFIG->plugin_options->meta_views == 'other' ){

      $meta_views_custom = isset( $IF_CONFIG->plugin_options->meta_views_custom )?$IF_CONFIG->plugin_options->meta_views_custom:'';
      $counts = $IF_CONFIG->yuzo_get_PostViews( get_the_ID(), $meta_views_custom  );

    }
  }

  return (int)($counts);

}
?>