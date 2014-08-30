<?php
/*
Plugin Name: Yuzo Related Post
Plugin URI: https://wordpress.org/plugins/yuzo-related-post/
Description: Gets the related post on your blog with any design characteristics.
Version: 2.0.4
Author: iLen
Author URI: 
*/
if ( !class_exists('yuzo_related_post') ) {
require_once 'assets/functions/options.php';

class yuzo_related_post extends yuzo_related_post_make{

		public $parameter 		= array();
		public $options 		= array();
		public $components		= array();

	function __construct(){

		parent::__construct(); // configuration general

		if( is_admin() ){

			require_once( plugin_dir_path( __FILE__ )."assets/ilenframework/assets/lib/plugin.class.php" );

		}elseif( ! is_admin() ) {

			global $yuzo_options;

            // get utils: IF_get_option
            require_once plugin_dir_path( __FILE__ )."assets/ilenframework/assets/lib/utils.php";

 			// get option plugin ;)
            $yuzo_options = IF_get_option( $this->parameter['name_option'] );

			if(  $yuzo_options->automatically_append !='1' ){

				add_action('the_content',array( &$this,'create_post_related') );	

			}

			// add scripts & styles
			add_action( 'wp_enqueue_scripts', array( &$this,'script_and_style_front' ) );

		}




	}

 
 

	// MAKE HTML of PLUGIN
	function create_post_related( $content ){

    	global $post,$yuzo_options,$wp_query;  
        $orig_post = $post;

        
    	$_html = "";
	  	$_html .= "<div class='yuzo_related_post'>";

 		 if( $wp_query->post_count != 0 ){ // if have result in loop post

	    	 // verify type page
	    	 $post_type = get_post_type( $post->ID );
	    	 if( $post_type ){
		    	 if( ! in_array($post_type, (array)$yuzo_options->post_type ) ){
		    	 	return $content;
		    	 }
		     }

             // is show home
             var_dump($yuzo_options->show_home);
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
			$string_order 	 = $yuzo_options->order;

			$post__not_in[] = $post->ID;
			$args = array('post__not_in' => $post__not_in,
						  'posts_per_page'=>(int)$yuzo_options->display_post,
						  'tag__in' => $string_tags,
						  'post_type' => (array)$yuzo_options->post_type,
						  'post_status' => 'publish',
						  'ignore_sticky_posts'=> 1,
						  'category__in'=>$string_cate,
						  'orderby' => $string_order_by,
						  'order' =>$string_order
						 );

			query_posts( $args );  

 
  		}

  		if( have_posts() && $wp_query->post_count != 0 ){

  			$_html .= "<div class='clear'>".html_entity_decode($yuzo_options->top_text, ENT_QUOTES, 'UTF-8')."</div>";
		    while ( have_posts() ) : the_post();

                
	  			$bold_title = "";
	  			$text2_extract = "";
	  			if( $yuzo_options->title_bold =='1'){
	  				$bold_title = "font-weight:bold";
	  			}
	  			if( (int)$yuzo_options->text2_length > 0 ){
	  				$text2_extract = '<span style="font-size:'.((int)$yuzo_options->font_size - 4).'px;" >'.self::yuzo_extract_title( strip_tags( get_the_content() ), (int)$yuzo_options->text2_length ).'</span>';
	  			}
 
                if( $yuzo_options->style == 1 ){
                    $image = IF_get_image(  $yuzo_options->thumbnail_size, $yuzo_options->default_image );
    			    $_html .= '
    			    <div class="relatedthumb" style="width:'.((int)$yuzo_options->height_image +15).'px;float:left;overflow:hidden;">  
    			        <a rel="external" href="'.get_permalink().'">
                            <div style="background:url('.$image['src'].') 50% 50% no-repeat;width: '.((int)$yuzo_options->height_image+20).'px;height:'.((int)$yuzo_options->height_image - 20).'px;margin-bottom: 5px; "></div>
    			             <span style="font-size:'.$yuzo_options->font_size.'px;'.$bold_title.'">'.self::yuzo_extract_title( get_the_title(), $yuzo_options->text_length ).'</span>
    			        '.$text2_extract .'
    			        </a>  
    			    </div>';
    			    $style="<style>
            	    			.yuzo_related_post img{width:".((int)$yuzo_options->height_image + 10 )."px !important; height:{$yuzo_options->height_image}px !important;}
            	    			.yuzo_related_post .relatedthumb{line-height:".((int)$yuzo_options->font_size +2 )."px;background:{$yuzo_options->bg_color} !important;}
            	    			.yuzo_related_post .relatedthumb:hover{background:{$yuzo_options->bg_color_hover} !important}
            	    	    </style>";
            	   		$script="<script>
            				jQuery(function() {
            					jQuery('.yuzo_related_post').equalizer({ overflow : 'relatedthumb2' });
            				});
            				</script>";
                }elseif( $yuzo_options->style == 2 ){
                    $image = IF_get_image(  $yuzo_options->thumbnail_size, $yuzo_options->default_image );
                    $_html .= '
    			    <div class="relatedthumb yuzo-list"  >  
    			        <a rel="external" href="'.get_permalink().'" class="image-list">
                             <div style="background:url('.$image['src'].') 50% 50% no-repeat;width: '.((int)$yuzo_options->height_image+20).'px;height:'.((int)$yuzo_options->height_image - 20).'px;margin-bottom: 5px; "></div>
    			        </a>
                        <a class="link-list" href="'.get_permalink().'" style="font-size:'.$yuzo_options->font_size.'px;'.$bold_title.'">'.self::yuzo_extract_title( get_the_title(), $yuzo_options->text_length ).'</a></h3>
                        '.$text2_extract .'
    			    </div>';
                    $style="<style>
    	    			.yuzo_related_post .relatedthumb:hover{background:{$yuzo_options->bg_color_hover} !important}
    	    	    </style>";
                    
                }

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
				$_html .= "<div class='clear'>".html_entity_decode($yuzo_options->top_text, ENT_QUOTES, 'UTF-8')."</div>";
			    while ( have_posts() ) : the_post();


				    $bold_title = "";
		  			$text2_extract = "";
		  			if($yuzo_options->title_bold=='1'){
		  				$bold_title = "font-weight:bold";
		  			}
		  			if( (int)$yuzo_options->text2_length>0 ){
		  				$text2_extract = '<span style="font-size:'.((int)$yuzo_options->font_size-4).'px;" >'.self::yuzo_extract_title( strip_tags( get_the_content() ), (int)$yuzo_options->text2_length ).'</span>';
		  			}
                
                
                    if( $yuzo_options->style == 1 ){
                    $image = IF_get_image(  $yuzo_options->thumbnail_size, $yuzo_options->default_image );
                    $_html .= '
                    <div class="relatedthumb" style="width:'.((int)$yuzo_options->height_image +15).'px;float:left;overflow:hidden;">  
                        <a rel="external" href="'.get_permalink().'">
                            <div style="background:url('.$image['src'].') 50% 50% no-repeat;width: '.((int)$yuzo_options->height_image+20).'px;height:'.((int)$yuzo_options->height_image - 20).'px;margin-bottom: 5px; "></div>
                             <span style="font-size:'.$yuzo_options->font_size.'px;'.$bold_title.'">'.self::yuzo_extract_title( get_the_title(), $yuzo_options->text_length ).'</span>
                        '.$text2_extract .'
                        </a>  
                    </div>';
                    $style="<style>
                                .yuzo_related_post img{width:".((int)$yuzo_options->height_image + 10 )."px !important; height:{$yuzo_options->height_image}px !important;}
                                .yuzo_related_post .relatedthumb{line-height:".((int)$yuzo_options->font_size +2 )."px;background:{$yuzo_options->bg_color} !important;}
                                .yuzo_related_post .relatedthumb:hover{background:{$yuzo_options->bg_color_hover} !important}
                            </style>";
                        $script="<script>
                            jQuery(function() {
                                jQuery('.yuzo_related_post').equalizer({ overflow : 'relatedthumb2' });
                            });
                            </script>";
                }elseif( $yuzo_options->style == 2 ){
                    $image = IF_get_image(  $yuzo_options->thumbnail_size, $yuzo_options->default_image );
                    $_html .= '
                    <div class="relatedthumb yuzo-list"  >  
                        <a rel="external" href="'.get_permalink().'" class="image-list">
                             <div style="background:url('.$image['src'].') 50% 50% no-repeat;width: '.((int)$yuzo_options->height_image+20).'px;height:'.((int)$yuzo_options->height_image - 20).'px;margin-bottom: 5px; "></div>
                        </a>
                        <a class="link-list" href="'.get_permalink().'" style="font-size:'.$yuzo_options->font_size.'px;'.$bold_title.'">'.self::yuzo_extract_title( get_the_title(), $yuzo_options->text_length ).'</a></h3>
                        '.$text2_extract .'
                    </div>';
                    $style="<style>
                        .yuzo_related_post .relatedthumb:hover{background:{$yuzo_options->bg_color_hover} !important}
                    </style>";
                    
                }

				    
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
        
        if( $_GET["page"] == $this->parameter["name_option"] ){
            null;
        }

    }


    function script_and_style_front(){

        // Register styles
        wp_register_style( 'front-css-'.$this->parameter["name_option"], plugins_url('/assets/css/style.css',__FILE__),'all',$this->parameter['version'] );
        // Enqueue styles
        wp_enqueue_style( 'front-css-'.$this->parameter["name_option"] );


        wp_enqueue_script( 'front-js-'.$this->parameter["name_option"], plugins_url('/assets/js/jquery.equalizer.js',__FILE__), array( 'jquery' ), '1.2.5', true );

    }


	function yuzo_extract_title(  $text = "",  $length = 30 ){
		//code 
	  $excert  = trim( $text );
	  if( strlen( $excert  ) > (int)$length )
	  	$title = substr( $excert , 0 , $length )."...";
	  else
	  	$title = substr( $excert , 0 , $length );
	  
	  return html_entity_decode($title, ENT_QUOTES, 'UTF-8');

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
?>