<?php
/*
Plugin Name: Yuzo Related Post
Plugin URI: https://wordpress.org/plugins/yuzo-related-post/
Description: Gets the related post on your blog with any design characteristics.
Version: 1.9.6
Author: iLen
Author URI: 
*/
if ( !class_exists('yuzo_related_post') ) {

class yuzo_related_post{

	public $parameter 		= array();
	public $options 		= array();
	public $components		= array();

	
	function __construct(){


		if( is_admin() ){

			self::configuration_plugin();
			require_once( plugin_dir_path( __FILE__ )."assets/ilenframework/assets/lib/plugin.class.php" );

		}elseif( ! is_admin() ) {

			// set parameter 
			self::parameters();


			global $options_my_plugin;
			$options_my_plugin = get_option( $this->parameter['name_option']."_options" ) ;

			

			if( $options_my_plugin[ $this->parameter['name_option'].'_automatically_append' ] !='1' ){
 
				add_action('the_content',array( &$this,'create_post_related') );	
				
			}

			

			// add scripts & styles
			add_action('wp_enqueue_scripts', array( &$this,'load_script_and_style_responsive_related_post') );

		}




	}


	function parameters(){
		

		$this->parameter = array('id'			  =>'yuzo_related_post_id',
								 'id_menu'		  =>'yuzo_related_post_menu',
								 'name'			  =>'Yuzo Related Post',
								 'name_long'	  =>'Yuzo Related Post',
								 'name_option'	  =>'yuzo_related_post',
								 'name_plugin_url'=>'yuzo-related-post',
								 'descripcion'    =>'Gets the related post on your blog with any design characteristics.',
								 'version'        =>'1.9.6',
								 'url'            =>'',
								 'logo'			  =>'<i class="fa fa-bolt"></i>', // or image .jpg,png
								 'logo_text'	  =>'', // alt of image
								 'slogan'		  =>'', // powered by <a href="">iLenTheme</a>
								 'url_framework'  =>plugins_url('/assets/ilenframework',__FILE__),
								 'theme_imagen'	  =>plugins_url('/assets/images',__FILE__),
								 'twitter'		  => 'https://twitter.com/intent/tweet?text=View this awesome plugin WP;url=http://bit.ly/1rLUvBM&amp;via=iLenElFuerte',
								 'wp_review'	  => 'http://wordpress.org/support/view/plugin-reviews/yuzo-related-post?filter=5',
								 'type'		  	  =>'plugin',
								 'method'		  =>'free',
								 'themeadmin'	  =>'fresh');
		
	}

	function myoptions_build(){
		
		$this->options = array('a'=>array(	'title'	 	 => __('Display Options',$this->parameter['name_option']), 		//title section
											'title_large'=> __('Display Options',$this->parameter['name_option']),//title large section
											'description'=> '',	//description section
											'icon'		 => 'fa fa-circle-o',

											'options'	 => array(  
																	 
																	array(	'title'	=>__('Top Text',$this->parameter['name_option']),
																	 		'help' 	=>__('Title top of related',$this->parameter['name_option']),
																	 		'type' 	=>'text',
																	 		'value'	=>'<h3>Related Post</h3>',
																	 		'id' 	=>$this->parameter['name_option'].'_top_text',
																	 		'name'	=>$this->parameter['name_option'].'_top_text',
																	 		'class'	=>'',
																	 		'row'	=>array('a','b')),


																	array(	'title'	=>__('Number of  similar Post to display',$this->parameter['name_option']),
																	 		'help' 	=>__('Number Post',$this->parameter['name_option']),
																	 		'type' 	=>'select',
																	 		'value'	=>4,
																	 		'items'	=>array(2=>'2',3=>'3',4=>'4',5=>'5',6=>'6',7=>'7',8=>'8',9=>'9',10=>'10',11=>'11',12=>'12',13=>'13',14=>'14',15=>'15',16=>'16',17=>'17',18=>'18',19=>'19',20=>'20'),
																	 		'id' 	=>$this->parameter['name_option'].'_display_post',
																	 		'name'	=>$this->parameter['name_option'].'_display_post',
																	 		'class'	=>'',
																	 		'row'	=>array('a','b')),

																	array(	'title'	=>__('Post Type:',$this->parameter['name_option']), //title section
																	 		'help' 	=>__('Type related post where is displayed',$this->parameter['name_option']), //descripcion section
																	 		'type' 	=>'checkbox', 
																	 		'value'	=>array('post'),
																	 		'value_check'=>array('post'),
																	 		'display'	=>'list', // list or horizontal
																	 		'items' => array(
																	 							array('id'=>$this->parameter['name_option'].'_post_type',
																	 								  'value'=>'post',
																	 								  'text' =>__('Post',$this->parameter['name_option']),
																	 								  'help' => '' ),
																	 							array('id'=>$this->parameter['name_option'].'_post_type',
																	 								  'value'=>'page',
																	 								  'text' =>__('Page',$this->parameter['name_option']),
																	 								  'help' => '' ),
																	 							array('id'=>$this->parameter['name_option'].'_post_type',
																	 								  'value'=>'attachment',
																	 								  'text' =>__('Attachment',$this->parameter['name_option']),
																	 								  'help' => '' ),
																	 						),
																	 		'id' 	=>$this->parameter['name_option'].'_post_type', //id
																	 		'name'	=>$this->parameter['name_option'].'_post_type', //name
																	 		'class'	=>'', //class
																	 		'row'	=>array('a','b')),


																	array(	'title'	=>__('Default image URL',$this->parameter['name_option']),
																	 		'help' 	=>__('Default image in case there is no image in the post',$this->parameter['name_option']),
																	 		'type' 	=>'text',
																	 		'value'	=>plugins_url( 'assets/images/default.png' , __FILE__ ),
																	 		'id' 	=>$this->parameter['name_option'].'_default_image',
																	 		'name'	=>$this->parameter['name_option'].'_default_image',
																	 		'class'	=>'',
																	 		'row'	=>array('a','b')),

																	array(	'title'	=>__('Thumbnail size',$this->parameter['name_option']),
																	 		'help' 	=>__('Image size, recommended "Thumbnail"',$this->parameter['name_option']),
																	 		'type' 	=>'select',
																	 		'value'	=>'thumbnail',
																	 		'items'	=>array('thumbnail'=>'Thumbnail','medium'=>'Medium'),
																	 		'id' 	=>$this->parameter['name_option'].'_thumbnail_size',
																	 		'name'	=>$this->parameter['name_option'].'_thumbnail_size',
																	 		'class'	=>'',
																	 		'row'	=>array('a','b')),

																	array(	'title'	=>__('Height & Width image',$this->parameter['name_option']),
																	 		'help' 	=>__('in px',$this->parameter['name_option']),
																	 		'type' 	=>'text',
																	 		'value'	=>'110',
																	 		'id' 	=>$this->parameter['name_option'].'_height_image',
																	 		'name'	=>$this->parameter['name_option'].'_height_image',
																	 		'class'	=>'',
																	 		'row'	=>array('a','b')),


																	array(	'title'	=>__('Font size',$this->parameter['name_option']),
																	 		'help' 	=>__('Font size of title related',$this->parameter['name_option']),
																	 		'type' 	=>'select',
																	 		'value'	=>13,
																	 		'items'	=>array(12=>'12',13=>'13',14=>'14',15=>'15',16=>'16',17=>'17',18=>'18',19=>'19',20=>'20'),
																	 		'id' 	=>$this->parameter['name_option'].'_font_size',
																	 		'name'	=>$this->parameter['name_option'].'_font_size',
																	 		'class'	=>'',
																	 		'row'	=>array('a','b')),

																	array(	'title'	=>__('Title length',$this->parameter['name_option']),
																	 		'help' 	=>__('Number of characters to be shown in the title',$this->parameter['name_option']),
																	 		'type' 	=>'text',
																	 		'value'	=>'50',
																	 		'id' 	=>$this->parameter['name_option'].'_text_length',
																	 		'name'	=>$this->parameter['name_option'].'_text_length',
																	 		'class'	=>'',
																	 		'row'	=>array('a','b')),

																	array(	'title'	=>__('Title Bold:',$this->parameter['name_option']), //title section
																	 		'help' 	=>'Title font weight',
																	 		'type' 	=>'checkbox', //type input configuration
																	 		'value'	=>'0', //value
																	 		'value_check'=>1,
																	 		'id' 	=>$this->parameter['name_option'].'_title_bold', //id
																	 		'name'	=>$this->parameter['name_option'].'_title_bold', //name
																	 		'class'	=>'', //class
																	 		'row'	=>array('a','b')),

																	array(	'title'	=>__('Text length',$this->parameter['name_option']),
																	 		'help' 	=>__('Number of text lettering post',$this->parameter['name_option']),
																	 		'type' 	=>'text',
																	 		'value'	=>'0',
																	 		'id' 	=>$this->parameter['name_option'].'_text2_length',
																	 		'name'	=>$this->parameter['name_option'].'_text2_length',
																	 		'class'	=>'',
																	 		'row'	=>array('a','b')),


																	array(	'title'	=>__('Background Color',$this->parameter['name_option']),
																	 		'help' 	=>'', 
																	 		'type' 	=>'color', 
																	 		'value'	=>'#FFF', // default
																	 		'id' 	=>$this->parameter['name_option'].'_bg_color',
																	 		'name'	=>$this->parameter['name_option'].'_bg_color', 
																	 		'class'	=>'', 
																	 		'row'	=>array('a','b')),

																	array(	'title'	=>__('Hover Background Color',$this->parameter['name_option']),
																	 		'help' 	=>'', 
																	 		'type' 	=>'color', 
																	 		'value'	=>'#FFFFE6', // default
																	 		'id' 	=>$this->parameter['name_option'].'_bg_color_hover',
																	 		'name'	=>$this->parameter['name_option'].'_bg_color_hover', 
																	 		'class'	=>'', 
																	 		'row'	=>array('a','b')),
                                                                            
                                                                            
                                                                    array(	'title'	=>__('Style',$this->parameter['name_option']),
																	 		'help' 	=>'',
																	 		'type' 	=>'radio_image',
																	 		'value'	=>1,
																	 		'items'	=>array(	array('value'=>1,
																	 								  'text' =>'Horizontal',
																	 								  'image'=>$this->parameter['theme_imagen'].'/horizontal1.jpg'),

																	 							array('value'=>2,
																	 								  'text' =>'Vertical',
																	 								  'image'=>$this->parameter['theme_imagen'].'/vertical1.jpg'),
 
																	 						),

																	 		'id' 	=>$this->parameter['name_option'].'_style',
																	 		'name'	=>$this->parameter['name_option'].'_style',
																	 		'class'	=>'',
																	 		'row'	=>array('a','b')),
                                                                            
                                                                            

																	array(	'title'	=>__('Related to',$this->parameter['name_option']),
																	 		'help' 	=>__('Related Post based',$this->parameter['name_option']),
																	 		'type' 	=>'select',
																	 		'value'	=>1,
																	 		'items'	=>array(1=>__('Tags',$this->parameter['name_option']),
																	 						2=>__('Category',$this->parameter['name_option']),
																	 						3=>__('Tags & Category',$this->parameter['name_option']),
																	 						4=>__('Random',$this->parameter['name_option']),
																	 						),
																	 		'id' 	=>$this->parameter['name_option'].'_related_to',
																	 		'name'	=>$this->parameter['name_option'].'_related_to',
																	 		'class'	=>'',
																	 		'row'	=>array('a','b')),


																	array(	'title'	=>__('Order by',$this->parameter['name_option']),
																	 		'help' 	=>__('Multiple criteria systems',$this->parameter['name_option']),
																	 		'type' 	=>'select',
																	 		'value'	=>'rand',
																	 		'items'	=>array('none'=>'None','ID'=>'ID','author'=>'Author','title'=>'Title','name'=>'Name','date'=>'Date','modified'=>'Modified','rand'=>'Rand','comment_count'=>'Comment Count'),
																	 		'id' 	=>$this->parameter['name_option'].'_order_by',
																	 		'name'	=>$this->parameter['name_option'].'_order_by',
																	 		'class'	=>'',
																	 		'row'	=>array('a','b')),


																	array(	'title'	=>__('Order',$this->parameter['name_option']),
																	 		'help' 	=>'',
																	 		'type' 	=>'select',
																	 		'value'	=>'DESC',
																	 		'items'	=>array('DESC'=>'Desc','ASC'=>'Asc'),
																	 		'id' 	=>$this->parameter['name_option'].'_order',
																	 		'name'	=>$this->parameter['name_option'].'_order',
																	 		'class'	=>'',
																	 		'row'	=>array('a','b')),


																	array(	'title'	=>__('Automatically append to the post content:',$this->parameter['name_option']), //title section
																	 		'help' 	=>'Or use <code>&lt;?php get_yuzo_related_posts(); ?&gt;</code> in the Loop', //descripcion section
																	 		'type' 	=>'checkbox', //type input configuration
																	 		'value'	=>'0', //value
																	 		'value_check'=>1,
																	 		'id' 	=>$this->parameter['name_option'].'_automatically_append', //id
																	 		'name'	=>$this->parameter['name_option'].'_automatically_append', //name
																	 		'class'	=>'', //class
																	 		'row'	=>array('a','b')),


																	array(	'title'	=>__('Categories on which related thumbnails will appear:',$this->parameter['name_option']), //title section
																	 		'help' 	=>'', //descripcion section
																	 		'type' 	=>'component_list_categories',  
																	 		'value'	=>array('-1'), //value
																	 		'value_check'=>0,
																	 		'id' 	=>$this->parameter['name_option'].'_categories', //id
																	 		'name'	=>$this->parameter['name_option'].'_categories', //name
																	 		'class'	=>'', //class
																	 		'row'	=>array('a','b')),



																	array(	'title'	=>__('If there is no related post, display random post?',$this->parameter['name_option']), //title section
																	 		'help' 	=>'only if use <code>&lt;?php get_yuzo_related_posts(); ?&gt;</code> in the Loop', //descripcion section
																	 		'type' 	=>'checkbox', 
																	 		'value'	=>'1',
																	 		'value_check'=>'1',
																	 		'id' 	=>$this->parameter['name_option'].'_display_random', //id
																	 		'name'	=>$this->parameter['name_option'].'_display_random', //name
																	 		'class'	=>'', //class
																	 		'row'	=>array('a','b')),

																	

															)
										),
							'last_update'=>time(),


							 );


		return $this->options;
		
	}


	function use_components(){
		//code 
		
		$this->components = array('list_categories');

	}


	function configuration_plugin(){
		

		// set parameter 
		self::parameters();


		// my configuration 
		self::myoptions_build();


		// my component to use
		self::use_components();

		
	}




	// MAKE HTML of PLUGIN
	function create_post_related( $content ){

		 //$content = get_the_content();
		 $orig_post = $post;  
    	 global $post,$options_my_plugin,$wp_query;  


    	$_html = "";
	  	$_html .= "<div class='yuzo_related_post'>";
 		 
 		 if( $wp_query->post_count != 0 ){ // if have result in loop post

	    	 // verify type page
	    	 $post_type = get_post_type( $post->ID );
	    	 //var_dump( $post_type );
	    	 //var_dump( (array)$options_my_plugin[ $this->parameter['name_option'].'_post_type' ]) ;
	    	 if( $post_type ){
		    	 if( ! in_array($post_type, (array)$options_my_plugin[ $this->parameter['name_option'].'_post_type' ]) ){
		    	 	return $content;
		    	 }
		     }
	   

			$array_categorias = $options_my_plugin[ $this->parameter['name_option'].'_categories' ];
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
	 
			
			 
			if( $options_my_plugin[ $this->parameter['name_option'].'_related_to' ] == '3' ){
				$tags = wp_get_post_tags($post->ID);
			    if ($tags) {  
				    $tag_ids = array();  
				    foreach($tags as $individual_tag) $tag_ids[] = $individual_tag->term_id;
			    }
	 
			    $string_tags =  $tag_ids;
			    $string_cate = $category_plugin;
			}elseif( $options_my_plugin[ $this->parameter['name_option'].'_related_to' ] == '1' ){

				$tags = wp_get_post_tags($post->ID);
			    if ($tags) {  
				    $tag_ids = array();  
				    foreach($tags as $individual_tag) $tag_ids[] = $individual_tag->term_id;
			    }

			    //$string_tags =  implode(",",$tag_ids);
			    $string_tags =  $tag_ids;

			}elseif( $options_my_plugin[ $this->parameter['name_option'].'_related_to' ] == '2' ){

				$string_cate = $category_plugin;

			}elseif( $options_my_plugin[ $this->parameter['name_option'].'_related_to' ] == '4' ){

				$string_order_by = 'rand';

			}


			$string_order_by = $options_my_plugin[ $this->parameter['name_option'].'_order_by' ];
			$string_order 	 = $options_my_plugin[ $this->parameter['name_option'].'_order' ];

			$post__not_in[] = $post->ID;
			$args = array('post__not_in' => $post__not_in,
						  'posts_per_page'=>(int)$options_my_plugin[ $this->parameter['name_option'].'_display_post' ],
						  'tag__in' => $string_tags,
						  'post_type' => 'post',
						  'post_status' => 'publish',
						  'caller_get_posts'=> 1,
						  'category__in'=>$string_cate,
						  'orderby' => $string_order_by,
						  'order' =>$string_order
						 );

			query_posts( $args );  
 
  		}

  		if( have_posts() && $wp_query->post_count != 0 ){

  			
  			
  			
  			$_html .= "<div class='clear'>".html_entity_decode($options_my_plugin[ $this->parameter['name_option'].'_top_text' ], ENT_QUOTES, 'UTF-8')."</div>";
		    while ( have_posts() ) : the_post();



	  			$bold_title = "";
	  			$text2_extract = "";
	  			if($options_my_plugin[ $this->parameter['name_option'].'_title_bold' ]=='1'){
	  				$bold_title = "font-weight:bold";
	  			}
	  			if( (int)$options_my_plugin[ $this->parameter['name_option'].'_text2_length' ]>0 ){
	  				$text2_extract = '<span style="font-size:'.((int)$options_my_plugin[ $this->parameter['name_option'].'_font_size' ]-4).'px;" >'.self::yuzo_extract_title( strip_tags( get_the_content() ), (int)$options_my_plugin[ $this->parameter['name_option'].'_text2_length' ] ).'</span>';
	  			}
 
                if( $options_my_plugin[ $this->parameter['name_option'].'_style' ] == 1 ){
    			    $_html .= '
    			    <div class="relatedthumb" style="width:'.((int)$options_my_plugin[ $this->parameter['name_option'].'_height_image' ]+15).'px;float:left">  
    			        <a rel="external" href="'.get_permalink().'">
    			        <img  width="'.((int)$options_my_plugin[ $this->parameter['name_option'].'_height_image' ]+10).'" height="'.$options_my_plugin[ $this->parameter['name_option'].'_height_image' ].'" src="'.self::ilen_get_image(  $options_my_plugin[ $this->parameter['name_option'].'_thumbnail_size' ] ).'" />
    			        <span style="font-size:'.$options_my_plugin[ $this->parameter['name_option'].'_font_size' ].'px;'.$bold_title.'">'.self::yuzo_extract_title( get_the_title(), $options_my_plugin[ $this->parameter['name_option'].'_text_length' ] ).'</span>
    			        '.$text2_extract .'
    			        </a>  
    			    </div>';
    			    $style="<style>
            	    			.yuzo_related_post img{width:".((int)$options_my_plugin[ $this->parameter['name_option'].'_height_image' ] + 10 )."px !important; height:{$options_my_plugin[ $this->parameter['name_option'].'_height_image' ]}px !important;}
            	    			.yuzo_related_post .relatedthumb{line-height:".((int)$options_my_plugin[ $this->parameter['name_option'].'_font_size' ]+2)."px;background:{$options_my_plugin[ $this->parameter['name_option'].'_bg_color' ]} !important;}
            	    			.yuzo_related_post .relatedthumb:hover{background:{$options_my_plugin[ $this->parameter['name_option'].'_bg_color_hover' ]} !important}
            	    	    </style>";
            	   		$script="<script>
            				jQuery(function() {
            					jQuery('.yuzo_related_post').equalizer({ overflow : 'relatedthumb2' });
            				});
            				</script>";
                }elseif( $options_my_plugin[ $this->parameter['name_option'].'_style' ] == 2 ){
                    
                    $_html .= '
    			    <div class="relatedthumb yuzo-list"  >  
    			        <a rel="external" href="'.get_permalink().'" class="image-list">
    			             <img style="width:'.((int)$options_my_plugin[ $this->parameter['name_option'].'_height_image' ]+10).'px;height:'.$options_my_plugin[ $this->parameter['name_option'].'_height_image' ].'px;" width="'.((int)$options_my_plugin[ $this->parameter['name_option'].'_height_image' ]+10).'px" height="'.$options_my_plugin[ $this->parameter['name_option'].'_height_image' ].'" src="'.self::ilen_get_image(  $options_my_plugin[ $this->parameter['name_option'].'_thumbnail_size' ] ).'" />
    			        </a>
                        <a class="link-list" href="'.get_permalink().'" style="font-size:'.$options_my_plugin[ $this->parameter['name_option'].'_font_size' ].'px;'.$bold_title.'">'.self::yuzo_extract_title( get_the_title(), $options_my_plugin[ $this->parameter['name_option'].'_text_length' ] ).'</a></h3>
                        '.$text2_extract .'
    			    </div>';
                    $style="<style>
    	    			.yuzo_related_post .relatedthumb:hover{background:{$options_my_plugin[ $this->parameter['name_option'].'_bg_color_hover' ]} !important}
    	    	    </style>";
                    
                }

		    endwhile;
            
            
            

	    }else{
	    
	    	


	    	if( $options_my_plugin[ $this->parameter['name_option'].'_display_random' ]  ){

				$args = array(
								'posts_per_page'   =>(int)$options_my_plugin[ $this->parameter['name_option'].'_display_post' ],
								'post_type'        => 'post',
								'post_status'      => 'publish',
								'caller_get_posts' => 1,
								'orderby'          => 'rand'
							 );
				query_posts( $args ); 
				$_html .= "<div class='clear'>".$options_my_plugin[ $this->parameter['name_option'].'_top_text' ]."</div>";
			    while ( have_posts() ) : the_post();


				    $bold_title = "";
		  			$text2_extract = "";
		  			if($options_my_plugin[ $this->parameter['name_option'].'_title_bold' ]=='1'){
		  				$bold_title = "font-weight:bold";
		  			}
		  			if( (int)$options_my_plugin[ $this->parameter['name_option'].'_text2_length' ]>0 ){
		  				$text2_extract = '<span style="font-size:'.((int)$options_my_plugin[ $this->parameter['name_option'].'_font_size' ]-4).'px;" >'.self::yuzo_extract_title( strip_tags( get_the_content() ), (int)$options_my_plugin[ $this->parameter['name_option'].'_text2_length' ] ).'</span>';
		  			}
                
                
                    if( $options_my_plugin[ $this->parameter['name_option'].'_style' ] == 1 ){
                    	$_html .= '
			    			    <div class="relatedthumb" style="width:'.((int)$options_my_plugin[ $this->parameter['name_option'].'_height_image' ]+15).'px;float:left">  
			    			        <a rel="external" href="'.get_permalink().'">
			    			        <img  width="'.((int)$options_my_plugin[ $this->parameter['name_option'].'_height_image' ]+10).'" height="'.$options_my_plugin[ $this->parameter['name_option'].'_height_image' ].'" src="'.self::ilen_get_image(  $options_my_plugin[ $this->parameter['name_option'].'_thumbnail_size' ] ).'" />
			    			        <span style="font-size:'.$options_my_plugin[ $this->parameter['name_option'].'_font_size' ].'px;'.$bold_title.'">'.self::yuzo_extract_title( get_the_title(), $options_my_plugin[ $this->parameter['name_option'].'_text_length' ] ).'</span>
			    			        '.$text2_extract .'
			    			        </a>  
			    			    </div>';
            		    $style="<style>
            	    			.yuzo_related_post img{width:".((int)$options_my_plugin[ $this->parameter['name_option'].'_height_image' ] + 10 )."px !important; height:{$options_my_plugin[ $this->parameter['name_option'].'_height_image' ]}px !important;}
            	    			.yuzo_related_post .relatedthumb{line-height:".((int)$options_my_plugin[ $this->parameter['name_option'].'_font_size' ]+2)."px;background:{$options_my_plugin[ $this->parameter['name_option'].'_bg_color' ]} !important;}
            	    			.yuzo_related_post .relatedthumb:hover{background:{$options_my_plugin[ $this->parameter['name_option'].'_bg_color_hover' ]} !important}
            	    	    </style>";
            	   		$script="<script>
            				jQuery(function() {
            					jQuery('.yuzo_related_post').equalizer({ overflow : 'relatedthumb2' });
            				});
            				</script>";
                    }elseif( $options_my_plugin[ $this->parameter['name_option'].'_style' ] == 2 ){
                            
                            $_html .= '
            			    <div class="relatedthumb yuzo-list"  >  
            			        <a rel="external" href="'.get_permalink().'" class="image-list">
            			             <img style="width:'.((int)$options_my_plugin[ $this->parameter['name_option'].'_height_image' ]+10).'px;height:'.$options_my_plugin[ $this->parameter['name_option'].'_height_image' ].'px;" width="'.((int)$options_my_plugin[ $this->parameter['name_option'].'_height_image' ]+10).'px" height="'.$options_my_plugin[ $this->parameter['name_option'].'_height_image' ].'" src="'.self::ilen_get_image(  $options_my_plugin[ $this->parameter['name_option'].'_thumbnail_size' ] ).'" />
            			        </a>
                                <a class="link-list" href="'.get_permalink().'" style="font-size:'.$options_my_plugin[ $this->parameter['name_option'].'_font_size' ].'px;">'.self::yuzo_extract_title( get_the_title(), $options_my_plugin[ $this->parameter['name_option'].'_text_length' ] ).'</a></h3>
                                '.$text2_extract .'
            			    </div>';
                            $style="<style>
            	    			.yuzo_related_post .relatedthumb:hover{background:{$options_my_plugin[ $this->parameter['name_option'].'_bg_color_hover' ]} !important}
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


	



	function load_script_and_style_responsive_related_post(){

		// Register styles
		wp_register_style( 'yuzo-related-post-ilen', plugins_url('/assets/css/style.css',__FILE__) );

		// Enqueue styles
		wp_enqueue_style( 'yuzo-related-post-ilen' );

		wp_enqueue_script( 'yuzo-related-post', plugins_url('/assets/js/jquery.equalizer.js',__FILE__), array( 'jquery' ), '1.2.5', true );

	}




	/* FUNCTION GET IMAGE POST */
	/*
	// Thumbnail (default 150px x 150px max)
	// Medium resolution (default 300px x 300px max)
	// Large resolution (default 640px x 640px max)
	// Full resolution (original size uploaded)
	*/

	/* get image for src image in post // get original size  */
	function catch_that_image() {

	  global $post, $posts, $options_my_plugin;
	  $first_img = '';
	  ob_start();
	  ob_end_clean();
	  $output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $post->post_content, $matches);
	  $first_img = $matches[1][0];


	  return $first_img;

	}

	/* get featured image */
	function get_featured_image( $size = "medium" ){
		//code 
		global $post;
		if ( has_post_thumbnail() ) { // check if the post has a Post Thumbnail assigned to it.
		 	$thumb = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), $size);
			return $url = $thumb['0']; 
		}else{
			return false;
		}
	}

	/* get attachment image */
	function get_image_post_attachment( $size = "medium" ){
		//code 
		global $post;
		$args = array(
		   'post_type' => 'attachment',
		   'numberposts' => -1,
		   'post_status' => null,
		   'post_parent' => $post->ID
		);

		$attachments = get_posts( $args );
		if ( $attachments ) {
	        foreach ( $attachments as $attachment ) {
	           $_array_img = wp_get_attachment_image_src( $attachment->ID , $size );
	           return $_array_img[0];
	          }
	     }

		return false;
	}


	/* get default imagen */
	function get_image_default(){
		//code
		global $options_my_plugin;

		return $options_my_plugin[ $this->parameter['name_option'].'_default_image' ];
	}


	function ilen_get_image( $size = "medium" ){
		global $options_my_plugin;

		if( $img = self::get_featured_image($size) ){

			return $img;

		}elseif( $img = self::get_image_post_attachment($size)  ){

			return $img;

		}elseif( $img = self::catch_that_image() ){

			return $img;

		}else{

			return self::get_image_default();

		}

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



	 
	global $IF_CONFIG;
	unset($IF_CONFIG);
	$IF_CONFIG = null;
	$IF_CONFIG = new yuzo_related_post;

	function get_yuzo_related_posts($content=""){
		
		global $IF_CONFIG;

		echo $IF_CONFIG->create_post_related($content);
		
	}

} // end if



require_once "assets/ilenframework/core.php";
?>