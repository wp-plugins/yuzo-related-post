<?php
/* NO REMOVE **********************************************************/
class yuzo_widget extends WP_Widget  {

	// always variables
	var $default          = array();
	var $default_validate = array();
	var $widget_ops       = array();

	var $parameter        = null;
	var $ME               = null;


function print_script_footer_widget(){ $this->ME->ilen_print_script_footer_widget( array('color','range2','input4','jtumbler'), $this->widget_ops['classname'], (int)$this->number  ); }
function __construct(){


	// always variables
	global $IF;
	$this->parameter  = isset($IF->parameter)?(array)$IF->parameter:null;
	$this->ME = $IF;


	// Script need for widgets
	add_action( 'admin_footer-widgets.php', array( $this, 'print_script_footer_widget' ), 9999 );
	/* NO REMOVE **********************************************************/

	// Widget Builder.
	$this->widget_ops = array('classname'     => 'yuzo_widget',
	                        'description'   => 'Show related and more...' );

	$this->WP_Widget('yuzo_widget', "Yuzo", $this->widget_ops);




  // default inputs
  $this->default                    = array( 'title'                     => 'Related Post',
                                            'number_post'                => 4,
                                            'related_based'              => 1,
                                            'order_by'                   => 'rand',
                                            'order'                      => 'DESC',
                                            'order_by_taxonomias'        => '',
                                            'style'                      => 2,
                                            'thumbnail_size'             => 'thumbnail',
                                            'background_size'            => 'cover',
                                            'height_image'               => 120,
                                            'bg_color'                   => '',
                                            'bg_color_hover'             => '#fcfcf4',
                                            'bg_color_hover_transitions' => '0.2 ',
                                            'thumbnail_border_radius'    => 0,
                                            'related_margin'             => '0,0,0,0',
                                            'related_padding'            => '5,0,5,5',
                                            'effect_related'             => 'none',
                                            'font_size'                  => 14,
                                            'text_length'                => 50,
                                            'title_bold'                 => '0',
                                            'title_color'                => '#444444',
                                            'text2_length'               => 0,
                                            'text_show'                  => '',
                                            'text_color'                 => '#777777',
                                            'show_in_related_post'       => '0',
                                            'show_in_related_post_position'=>'show-views-bottom',
                                            'show_in_related_post_text' => 'views',
                                            'format_count'              => '',
                                            'meta_views'                => 'yuzo-views',
                                            'meta_views_custom'         => '',
                                            'yuzo_widget_as'            => 'list-post',
                                            'show_list'                 => 'last-post',
                                            'interval'                  => 'all-along');






  // validate inputs
  $this->default_validate =array( 'title'                      => 't',
                                  'number_post'                => 'i',
                                  'related_based'              => 'i',
                                  'order_by'                   => 's',
                                  'order'                      => 's',
                                  'order_by_taxonomias'        => 's',
                                  'style'                      => 'i',
                                  'thumbnail_size'             => 's',
                                  'background_size'            => 's',
                                  'height_image'               => 'i',
                                  'bg_color'                   => 's',
                                  'bg_color_hover'             => 's',
                                  'bg_color_hover_transitions' => 's',
                                  'thumbnail_border_radius'    => 's',
                                  'related_margin'             => 's',
                                  'related_padding'            => 's',
                                  'effect_related'             => 's',
                                  'font_size'                  => 'i',
                                  'text_length'                => 'i',
                                  'title_bold'                 => 's',
                                  'title_color'                => 's',
                                  'text2_length'               => 'i',
                                  'text_show'                  => 's',
                                  'text_color'                 => 's',
                                  'show_in_related_post'       => 's',
                                  'show_in_related_post_position' => 's',
                                  'show_in_related_post_text'  => 's',
                                  'format_count'               => 's',
                                  'meta_views'                 => 's',
                                  'meta_views_custom'          => 's',
                                  'yuzo_widget_as'             => 's',
                                  'show_list'                  => 's',
                                  'interval'                   => 's');




}

function form($instance){

    if( ! $instance ){ // only validate once (when widget is added)
        $instance = wp_parse_args( (array) $instance, $this->default ); 
    }
  

    // variable's widget
    extract( $instance );


    // set header widget
    $widget_conf = array(
                        'id'          => 'yuzo_widget',
                        'description' => 'Yuzo Widget is created by <a href="http://ilentheme.com">iLen</a>',
                        'color'       => '#96C7E2', // #96E2B2
                        'width'       => '90',
                        );
  
    // validate if new widget or not
    $widget_conf['new'] = !(int)$this->number ? 'new_widget_'.rand(11,5559) : 'no_new_widget '.$widget_conf['id'].'-'.$this->number;
    $status_widget      = $widget_conf['ref'] = (  (int)$this->number > 0 ) ? $widget_conf['id'].'-'.$this->number : $widget_conf['new'];

    // set body widget
    $widget_fields = array('a'=>array(          'title'      => __('Pattern',$this->parameter['name_option']), 
                                                'title_large'=> __('',$this->parameter['name_option']), 
                                                'description'=> '', 
                                                'icon'       => '',

                                                'options'    => array(
                                                                     
                                                                    array(  'title' =>__('Title',$this->parameter['name_option']),
                                                                            'help'  =>__('Title Widget',$this->parameter['name_option']),
                                                                            'type'  =>'text',
                                                                            'value' =>$title,
                                                                            'id'    =>$this->get_field_id('title'),
                                                                            'name'  =>$this->get_field_name('title'),
                                                                            'class' =>'',
                                                                      
                                                                            'row'   =>array('a','b')),

                                                                    array(  'title' =>__('Number Post',$this->parameter['name_option']),
                                                                            'help'  =>__('Number Post to display',$this->parameter['name_option']),
                                                                            'type'  =>'select',
                                                                            'value' =>$number_post,
                                                                            'items' =>array(2=>'2',3=>'3',4=>'4',5=>'5',6=>'6',7=>'7',8=>'8',9=>'9',10=>'10',11=>'11',12=>'12',13=>'13',14=>'14',15=>'15',16=>'16',17=>'17',18=>'18',19=>'19',20=>'20'),
                                                                            'id'    =>$this->get_field_id('number_post'),
                                                                            'name'  =>$this->get_field_name('number_post'),
                                                                            'class' =>'',
                                                                            'row'   =>array('a','b')),

                                                                    array(  'title' =>__('Use Yuzo Widget as',$this->parameter['name_option']),
                                                                            'help'  =>__('Use it in 2 different ways',$this->parameter['name_option']),
                                                                            'type'  =>'select',
                                                                            'value' =>$yuzo_widget_as,
                                                                            'items' =>array('list-post'=>'List Post','related'=>'Related Post'),
                                                                            'id'    =>'use_yuzo_widget_as',
                                                                            'name'  =>$this->get_field_name('yuzo_widget_as'),
                                                                            'class' =>'class_yuzo_widget_as',
                                                                            'row'   =>array('a','b')),

                                                                    array(  'title' =>__('',$this->parameter['name_option']),
                                                                            'help'  =>__('',$this->parameter['name_option']),
                                                                            'type'  =>'html',
                                                                            'html1'  =>'',
                                                                            'html2'  =>'<blockquote>If you use Yuzo Widget as <strong>Related</strong> only appear on single pages, this widget not show either the homepage or on the pages archives, pages categories, etc ...</blockquote>',
                                                                            'id'    =>'use_yuzo_widget_as',
                                                                            'name'  =>$this->get_field_name('yuzo_widget_as'),
                                                                            'class' =>'class_yuzo_widget_as_html_post_list',
                                                                            'style' =>'display:none;',
                                                                            'row'   =>array('a','c')),

                                                                    array(  'title' =>__('Show',$this->parameter['name_option']),
                                                                            'help'  =>__('Select list you want to show',$this->parameter['name_option']),
                                                                            'type'  =>'select',
                                                                            'value' =>$show_list,
                                                                            'items' =>array('last-post'=>'Last Post','most-view'=>'Most View','most-popular'=>'Most Popular (most Commented)','rand'=>'Rand'),
                                                                            'id'    =>$this->get_field_id('show_list'),
                                                                            'name'  =>$this->get_field_name('show_list'),
                                                                            'class' =>'',
                                                                            'before'=>'<div class="class_list_and_interval">',
                                                                            'row'   =>array('a','b')),

                                                                    array(  'title' =>__('Interval',$this->parameter['name_option']),
                                                                            'help'  =>__('Time interval showing',$this->parameter['name_option']),
                                                                            'type'  =>'radio',
                                                                            'value' =>$interval,
                                                                            'items' =>array('last-24h'      => 'Last 24 hours',
                                                                                            'last-48h'      => 'Last 48 hours',
                                                                                            'last-week'     => 'Last week',
                                                                                            'last-month'    => 'Last month',
                                                                                            'last-year'     => 'Last year',
                                                                                            'all-along'     => 'All along'),
                                                                            'id'    =>'yuzo_interval_id',
                                                                            'name'  =>$this->get_field_name('interval'),
                                                                            'class' =>'',
                                                                            'after' =>'</div>',
                                                                            'row'   =>array('a','b')),

                                                                    array(  'title' =>__('Related to',$this->parameter['name_option']),
                                                                            'help'  =>__('Related Post based',$this->parameter['name_option']),
                                                                            'type'  =>'select',
                                                                            'value' =>$related_based,
                                                                            'items' =>array(1=>__('Tags',$this->parameter['name_option']),
                                                                                            2=>__('Category',$this->parameter['name_option']),
                                                                                            3=>__('Tags & Category',$this->parameter['name_option']),
                                                                                            4=>__('Random',$this->parameter['name_option']),
                                                                                            5=>__('Taxonomies',$this->parameter['name_option']),
                                                                                            ),
                                                                            'id'    =>'yuzo_related_post_related_to',
                                                                            'name'  =>$this->get_field_name('related_based'),
                                                                            'class' =>'class_related_post_to',
                                                                            'before'=>'<div class="class_section_use_related_post">',
                                                                            'row'   =>array('a','b')),

                                                                      array(  'title' =>__('Order by',$this->parameter['name_option']),
                                                                              'help'  =>__('Multiple criteria systems',$this->parameter['name_option']),
                                                                              'type'  =>'select',
                                                                              'value' =>$order_by,
                                                                              'items' =>array('none'          =>__('None',$this->parameter['name_option']),
                                                                                              'ID'            =>__('ID',$this->parameter['name_option']),
                                                                                              'author'        =>__('Author',$this->parameter['name_option']),
                                                                                              'title'         =>__('Title',$this->parameter['name_option']),
                                                                                              'name'          =>__('Name',$this->parameter['name_option']),
                                                                                              'date'          =>__('Date',$this->parameter['name_option']),
                                                                                              'modified'      =>__('Modified',$this->parameter['name_option']),
                                                                                              'rand'          =>__('Rand',$this->parameter['name_option']),
                                                                                              'comment_count' =>__('Comment Count',$this->parameter['name_option'])
                                                                                            ),
                                                                              'id'    =>$this->get_field_id('order_by'),
                                                                              'name'  =>$this->get_field_name('order_by'),
                                                                              'class' =>'class_order_by',
                                                                              'row'   =>array('a','b')),


                                                                      array(  'title' =>__('Order',$this->parameter['name_option']),
                                                                              'help'  =>'',
                                                                              'type'  =>'select',
                                                                              'value' =>$order,
                                                                              'items' =>array('DESC'=>'Descendant','ASC'=>'Ascendant'),
                                                                              'id'    =>$this->get_field_id('order'),
                                                                              'name'  =>$this->get_field_name('order'),
                                                                              'class' =>'class_order',
                                                                              'row'   =>array('a','b')),

                                                                      array(  'title' =>__('Order by',$this->parameter['name_option']),
                                                                              'help'  =>__('By via taxonomies, this might be more relevant in the algorithm to search for related real.s',$this->parameter['name_option']),
                                                                              'type'  =>'select',
                                                                              'value' =>$order_by_taxonomias,
                                                                              'items' =>array('related_scores_high__speedy'             =>__('Related Scores : High  ( Speedy )',$this->parameter['name_option']),
                                                                                              ''                                        =>__('Related Scores : High  /  Date Published : New  ( Default setting )',$this->parameter['name_option']),
                                                                                              'related_scores_high__date_published_old' =>__('Related Scores : High  /  Date Published : Old',$this->parameter['name_option']),
                                                                                              'related_scores_low__date_published_new'  =>__('Related Scores : Low  /  Date Published : New',$this->parameter['name_option']),
                                                                                              'related_scores_low__date_published_old'  =>__('Related Scores : Low  /  Date Published : Old',$this->parameter['name_option']),
                                                                                              'related_scores_high__date_modified_new'  =>__('Related Scores : High  /  Date Modified : New',$this->parameter['name_option']),
                                                                                              'related_scores_high__date_modified_old'  =>__('Related Scores : High  /  Date Modified : Old',$this->parameter['name_option']),
                                                                                              'related_scores_low__date_modified_new'   =>__('Related Scores : Low  /  Date Modified : New',$this->parameter['name_option']),
                                                                                              'related_scores_low__date_modified_old'   =>__('Related Scores : Low  /  Date Modified : Old',$this->parameter['name_option']),
                                                                                              
                                                                                              'date_published_new'                      =>__('Date Published : New',$this->parameter['name_option']),
                                                                                              'date_published_old'                      =>__('Date Published : Old',$this->parameter['name_option']),
                                                                                              'date_modified_new'                       =>__('Date Modified : New',$this->parameter['name_option']),
                                                                                              'date_modified_old'                       =>__('Date Modified : Old',$this->parameter['name_option']),
                                                                                            ),
                                                                              'id'    =>$this->get_field_id('order_by_taxonomias'),
                                                                              'name'  =>$this->get_field_name('order_by_taxonomias'),
                                                                              'class' =>'class_order_by_taxonomias',
                                                                              'after' =>'</div>',
                                                                              'row'   =>array('a','b')),

                                                                    ),
                                      ),
                          'b'=>array(       'title'      => __('Styling',$this->parameter['name_option']), 
                                            'title_large'=> __('',$this->parameter['name_option']), 
                                            'description'=> '', 
                                            'icon'       => '',

                                            'options'    => array(  
                                                                     
                                                                    array(  'title' =>__('Choose your style',$this->parameter['name_option']),
                                                                            'help'  =>'Yuzo shows you 4 different styles to show related posts.',
                                                                            'type'  =>'radio_image',
                                                                            'value' =>$style,
                                                                            'items' =>array(    

                                                                                                array('value'=>2,
                                                                                                      'text' =>'Vertical',
                                                                                                      'image'=>$this->parameter['theme_imagen'].'/2-.png'),

                                                                                                array('value'=>1,
                                                                                                      'text' =>'Horizontal',
                                                                                                      'image'=>$this->parameter['theme_imagen'].'/1-.png'),

                                                                                                array('value'=>3,
                                                                                                      'text' =>'List',
                                                                                                      'image'=>$this->parameter['theme_imagen'].'/3-.png'),

                                                                                                array('value'=>4,
                                                                                                      'text' =>'Experimental',
                                                                                                      'image'=>$this->parameter['theme_imagen'].'/4-.png'),
 
                                                                                            ),

                                                                            'id'    =>$this->parameter['name_option'].'_'.'style',
                                                                            'name'  =>$this->get_field_name('style'),
                                                                            'class' =>'yuzo_style_chosse',
                                                                            'row'   =>array('a','c')),

                                                                    array(  'title' =>__('Thumbnail size',$this->parameter['name_option']),
                                                                            'help'  =>__('Image size',$this->parameter['name_option']),
                                                                            'type'  =>'select',
                                                                            'value' =>$thumbnail_size,
                                                                            'items' =>array('thumbnail'=>'Thumbnail','medium'=>'Medium'),
                                                                            'id'    =>$this->get_field_id('thumbnail_size'),
                                                                            'name'  =>$this->get_field_name('thumbnail_size'),
                                                                            'class' =>'',
                                                                            'row'   =>array('a','b')),

                                                                    array(  'title' =>__('Background size',$this->parameter['name_option']),
                                                                            'help'  =>__('<code>Cover:</code> The recommended since adjusts the picture for all related post are well aligned and looks exactly.<br /><br /> <code>Contain:</code>Fits both high and wide to display the image completely, but if the radius ratio is more high than the width of the other related post is not displayed aligned with respect.',$this->parameter['name_option']),
                                                                            'type'  =>'select',
                                                                            'value' =>$background_size,
                                                                            'items' =>array('cover'=>'Cover','contain'=>'Contain'),
                                                                            'id'    =>$this->get_field_id('background_size'),
                                                                            'name'  =>$this->get_field_name('background_size'),
                                                                            'class' =>'',
                                                                            'row'   =>array('a','b')),

                                                                    array(  'title' =>__('Height & Width image',$this->parameter['name_option']),
                                                                            'help'  =>__('in px',$this->parameter['name_option']),
                                                                            'type'  =>'text',
                                                                            'value' =>$height_image,
                                                                            'id'    =>'yuzo_related_post_height_image',
                                                                            'name'  =>$this->get_field_name('height_image'),
                                                                            'class' =>'',
                                                                            'row'   =>array('a','b')),
 
                                                                    array(  'title' =>__('Background Color',$this->parameter['name_option']),
                                                                            'help'  =>'Selected background color, you can also leave blank', 
                                                                            'type'  =>'color',
                                                                            'value' =>$bg_color,
                                                                            'id'    =>$this->get_field_id('bg_color'),
                                                                            'name'  =>$this->get_field_name('bg_color'),
                                                                            'class' =>'', 
                                                                            'row'   =>array('a','b')),

                                                                    array(  'title' =>__('Background Color Hover',$this->parameter['name_option']),
                                                                            'help'  =>'Selected background color on hover, you can also leave blank', 
                                                                            'type'  =>'color',
                                                                            'value' =>$bg_color_hover,
                                                                            'id'    =>$this->get_field_id('bg_color_hover'),
                                                                            'name'  =>$this->get_field_name('bg_color_hover'),
                                                                            'class' =>'', 
                                                                            'row'   =>array('a','b')),

                                                                    array(  'title' =>__('Hover transitions',$this->parameter['name_option']),
                                                                            'help'  =>__('Effect transitions background when mouse over in related<br />You can enter values such as: 0.2, 0.5 , 0.8, 1, 1.5 , 2,3, etc..',$this->parameter['name_option']),
                                                                            'type'  =>'text',
                                                                            'value' =>$bg_color_hover_transitions,
                                                                            'id'    =>$this->get_field_id('bg_color_hover_transitions'),
                                                                            'name'  =>$this->get_field_name('bg_color_hover_transitions'),
                                                                            'class' =>'',
                                                                            'row'   =>array('a','b')),

                                                                    array(  'title' =>__('Thumbnail Border Radio',$this->parameter['name_option']),
                                                                            'help'  =>__('Select the percentage of border for the image (%)<br/> 0=square - 50=circle',$this->parameter['name_option']),
                                                                            'type'  =>'range2',
                                                                            'value' =>$thumbnail_border_radius,
                                                                            'id'  =>$this->get_field_id('thumbnail_border_radius'),
                                                                            'name'  =>$this->get_field_name('thumbnail_border_radius'),
                                                                            'min' =>0,
                                                                            'max' =>50,
                                                                            'step'  =>1,
                                                                            'class' =>'',
                                                                            'color' => 1,
                                                                            'row' => array('a','b')),

                                                                    array(  'title' =>__('Margin',$this->parameter['name_option']),
                                                                            'help'  =>__('Place the related margin on each post',$this->parameter['name_option']),
                                                                            'type'  =>'input_4',
                                                                            'value' =>$related_margin,
                                                                            'id'  =>$this->get_field_id('related_margin'),
                                                                            'name'  =>$this->get_field_name('related_margin'),
                                                                            'min' =>0,
                                                                            'max' =>50,
                                                                            'step'  =>1,
                                                                            'class' =>'class_input4_margin',
                                                                            'row' =>array('a','b')),

                                                                  array(    'title'         =>__('Padding',$this->parameter['name_option']),
                                                                            'help'          =>__('Place the related padding on each post',$this->parameter['name_option']),
                                                                            'type'          =>'input_4',
                                                                            'value'         =>$related_padding,
                                                                            'id'            =>$this->get_field_id('related_padding'),
                                                                            'name'          =>$this->get_field_name('related_padding'),
                                                                            'min'           =>0,
                                                                            'max'           =>50,
                                                                            'step'          =>1,
                                                                            'class'         =>'',
                                                                            'row'           =>array('a','b')),
                                                                  
                                                                  array(    'title' =>__('Choose effect',$this->parameter['name_option']),
                                                                            'help'  =>__('Yuzo has many visual effects with respect to the image when the mouse is over the related.',$this->parameter['name_option']),
                                                                            'type'  =>'select',
                                                                            'value' =>$effect_related,
                                                                            'items' =>array(
                                                                                            'none'           =>__('None',$this->parameter['name_option']),
                                                                                            'enlarge'        =>__('Enlarge related',$this->parameter['name_option']),
                                                                                            'zoom_icon_link' =>__('Zoom + Icons link + Opacity',$this->parameter['name_option']),
                                                                                            'shine'          =>__('Shine',$this->parameter['name_option']),
                                                                                           ),
                                                                            'id'    =>$this->get_field_id('effect_related'),
                                                                            'name'  =>$this->get_field_name('effect_related'),
                                                                            'class' =>'',
                                                                            'row'   =>array('a','b')),


                                                                    ),
                                      ),
                          'c'=>array(       'title'      => __('Text',$this->parameter['name_option']), 
                                            'title_large'=> __('Text',$this->parameter['name_option']), 
                                            'description'=> '', 
                                            'icon'       => '',

                                            'options'    => array(  
                                                                     
                                                                    array(  'title' =>__('Font size',$this->parameter['name_option']),
                                                                            'help'  =>__('Font size of title related',$this->parameter['name_option']),
                                                                            'type'  =>'select',
                                                                            'value' =>$font_size,
                                                                            'items' =>array(12=>'12',13=>'13',14=>'14',15=>'15',16=>'16',17=>'17',18=>'18',19=>'19',20=>'20'),
                                                                            'id'    =>'yuzo_related_post_font_size',
                                                                            'name'  =>$this->get_field_name('font_size'),
                                                                            'class' =>'',
                                                                            'row'   =>array('a','b')),

                                                                    array(  'title' =>__('Title length',$this->parameter['name_option']),
                                                                            'help'  =>__('Number of characters to be shown in the title',$this->parameter['name_option']),
                                                                            'type'  =>'text',
                                                                            'value' =>$text_length,
                                                                            'id'    =>$this->get_field_id('text_length'),
                                                                            'name'  =>$this->get_field_name('text_length'),
                                                                            'class' =>'',
                                                                            'row'   =>array('a','b')),

                                                                    array(  'title' =>__('Title Bold:',$this->parameter['name_option']),
                                                                            'help'  =>__('Title font weight',$this->parameter['name_option']),
                                                                            'type'  =>'checkbox', //type input configuration
                                                                            'value' =>( isset($title_bold) && $title_bold)?$title_bold:0,
                                                                            'id'    =>$this->get_field_id('title_bold'),
                                                                            'name'  =>$this->get_field_name('title_bold'),
                                                                            'class' =>'', //class
                                                                            'row'   =>array('a','b')),

                                                                    array(  'title' =>__('Title color',$this->parameter['name_option']),
                                                                            'help'  =>__('Selected title color, you can also leave blank',$this->parameter['name_option']),
                                                                            'type'  =>'color',
                                                                            'value' =>$title_color,
                                                                            'id'    =>$this->get_field_id('title_color'),
                                                                            'name'  =>$this->get_field_name('title_color'),
                                                                            'class' =>'',
                                                                            'row'   =>array('a','b')),

                                                                    array(  'title' =>__('Text length',$this->parameter['name_option']),
                                                                            'help'  =>__('Number of text lettering post',$this->parameter['name_option']),
                                                                            'type'  =>'text',
                                                                            'value' =>$text2_length,
                                                                            'id'    =>'yuzo_related_post_text2_length',
                                                                            'name'  =>$this->get_field_name('text2_length'),
                                                                            'class' =>'',
                                                                            'row'   =>array('a','b')),

                                                                    array(  'title' =>__('Text to display',$this->parameter['name_option']),
                                                                            'help'  =>__('You can choose from the first text of the article or else the extract of the article',$this->parameter['name_option']),
                                                                            'type'  =>'select',
                                                                            'value' =>$text_show,
                                                                            'items' =>array(
                                                                                            '1'        =>__('Text in the article begins',$this->parameter['name_option']),
                                                                                            '2'        =>__('Excerpt from article',$this->parameter['name_option']),
                                                                                           ),
                                                                            'id'    =>$this->get_field_id('text_show'),
                                                                            'name'  =>$this->get_field_name('text_show'),
                                                                            'class' =>'',
                                                                            'row'   =>array('a','b')),

                                                                    array(  'title' =>__('Text color',$this->parameter['name_option']),
                                                                            'help'  =>__('Selected text color, you can also leave blank',$this->parameter['name_option']),
                                                                            'type'  =>'color',
                                                                            'value' =>$text_color,
                                                                            'id'    =>$this->get_field_id('text_color'),
                                                                            'name'  =>$this->get_field_name('text_color'),
                                                                            'class' =>'',
                                                                            'row' =>array('a','b')), 

                                                                    ),
                                      ),
                          'd'=>array(       'title'      => __('More...',$this->parameter['name_option']), 
                                            'title_large'=> __('',$this->parameter['name_option']), 
                                            'description'=> '', 
                                            'icon'       => '',

                                            'options'    => array(

                                                                    array(  'title' =>__('Meta view',$this->parameter['name_option']),
                                                                            'help'  =>__('You can use the meta "Yuzo Views" (key: yuzo_views) or other meta you use to visit the counter.',$this->parameter['name_option']),
                                                                            'type'  =>'select',
                                                                            'value' =>$meta_views,
                                                                            'items' =>array('yuzo-views'=>'Yuzo views','other'=>'Other Meta'),
                                                                            'id'    =>'yuzo_related_post_meta_views',
                                                                            'name'  =>$this->get_field_name('meta_views'),
                                                                            'class' =>'',
                                                                            'row'   =>array('a','b')),


                                                                    array(  'title' =>__('Use another Meta visit counter',$this->parameter['name_option']),
                                                                            'help'  =>__("Enter the Meta (key) you're using the hit counter for your post, if you do not know anything about this best selected above 'Yuzo views'",$this->parameter['name_option']),
                                                                            'type'  =>'text',
                                                                            'value' =>$meta_views_custom,
                                                                            'id'    =>$this->get_field_id('meta_views_custom'),
                                                                            'name'  =>$this->get_field_name('meta_views_custom'),
                                                                            'class' =>'class_yuzo_meta_custom',
                                                                            'row'   =>array('a','b')),

                                                                     
                                                                    array(  'title' =>__('Show visits',$this->parameter['name_option']),
                                                                            'help'  =>__('Show the hit counter post.',$this->parameter['name_option']),
                                                                            'type'  =>'checkbox', 
                                                                            'value' =>(isset($show_in_related_post) && $show_in_related_post)?$show_in_related_post:0,
                                                                            'id'    =>$this->get_field_id('show_in_related_post'),
                                                                            'name'  =>$this->get_field_name('show_in_related_post'),
                                                                            'class' =>'',
                                                                            'row'   =>array('a','b')),


                                                                    array(  'title' =>__('Position',$this->parameter['name_option']),
                                                                            'help'  =>__('Choose where you want to display the counter.',$this->parameter['name_option']),
                                                                            'type'  =>'select',
                                                                            'value' =>$show_in_related_post_position,
                                                                            'items' =>array('show-views-top'=>'Before title','show-views-bottom'=>'After title'),
                                                                            'id'    =>$this->get_field_id('show_in_related_post_position'),
                                                                            'name'  =>$this->get_field_name('show_in_related_post_position'),
                                                                            'class' =>'',
                                                                            'row'   =>array('a','b')),

                                                                    
                                                                    array(  'title' =>__('Text views',$this->parameter['name_option']),
                                                                            'help'  =>__('Set the text to be displayed to identify visits, if you leave it empty display an icon of an eye.',$this->parameter['name_option']),
                                                                            'type'  =>'text',
                                                                            'value' =>$show_in_related_post_text,
                                                                            'id'    =>$this->get_field_id('show_in_related_post_text'),
                                                                            'name'  =>$this->get_field_name('show_in_related_post_text'),
                                                                            'class' =>'',
                                                                            'row'   =>array('a','b')),

                                                                    array(  'title' =>__('Format thousands',$this->parameter['name_option']),
                                                                            'help'  =>__('Select between 2 formats that you can identify thousands in the hit counter by Post.',$this->parameter['name_option']),
                                                                            'type'  =>'select',
                                                                            'items' =>array(''=>__('none',$this->parameter['name_option']),','=>__(',',$this->parameter['name_option']),'.'=>__('.',$this->parameter['name_option'])),
                                                                            'value' =>$format_count,
                                                                            'id'    =>$this->get_field_id('format_count'),
                                                                            'name'  =>$this->get_field_name('format_count'),
                                                                            'class' =>'',
                                                                            'row'   =>array('a','b')),

                                                                    ),
                                      ),
                            );




  $this->ME->create_ilenWidget( $widget_conf , $widget_fields );



  // Custom script
  echo '<script>
    jQuery(document).ready(function( $ ){

        jQuery("[class*='.$status_widget.'] .class_related_post_to select").on("change",function(){

            if( jQuery(this).val() == "5" ){

              jQuery("[class*='.$status_widget.'] .class_order_by").css("display","none");
              jQuery("[class*='.$status_widget.'] .class_order").css("display","none");
              jQuery("[class*='.$status_widget.'] .class_order_by_taxonomias").css("display","block");

            } else {

              jQuery("[class*='.$status_widget.'] .class_order_by").css("display","block");
              jQuery("[class*='.$status_widget.'] .class_order").css("display","block");
              jQuery("[class*='.$status_widget.'] .class_order_by_taxonomias").css("display","none");

            }

    });
 
    jQuery("[class*='.$status_widget.'] .yuzo_style_chosse #yuzo_related_post_style_img_2").on("click", function(event){
        jQuery("[class*='.$status_widget.'] #yuzo_related_post_height_image").val(85);
        jQuery("[class*='.$status_widget.'] #yuzo_related_post_font_size").val(14);
        jQuery("[class*='.$status_widget.'] #yuzo_related_post_text2_length").val(150);
    });

    jQuery("[class*='.$status_widget.'] .yuzo_style_chosse #yuzo_related_post_style_img_1").on("click", function(event){
        jQuery("[class*='.$status_widget.'] #yuzo_related_post_height_image").val(145);
        jQuery("[class*='.$status_widget.'] #yuzo_related_post_font_size").val(13);
        jQuery("[class*='.$status_widget.'] #yuzo_related_post_text2_length").val(0);
    });

    if( jQuery("[class*='.$status_widget.'] #yuzo_related_post_meta_views").val() == "other" ){
        jQuery("[class*='.$status_widget.'] .class_yuzo_meta_custom").css("display","block");
        jQuery("[class*='.$status_widget.'] .class_yuzo_meta_custom").css("background","rgb(249, 249, 249)");
    }



    if( '.$related_based.' == 5 ){
        jQuery("[class*='.$status_widget.'] .class_order_by").css("display", "none");
        jQuery("[class*='.$status_widget.'] .class_order_by").css("display","none" );
        jQuery("[class*='.$status_widget.'] .class_order").css("display","none");
        jQuery("[class*='.$status_widget.'] .class_order_by_taxonomias").css("display","block");

    } else {

        jQuery("[class*='.$status_widget.'] .class_order_by").css("display","block");
        jQuery("[class*='.$status_widget.'] .class_order").css("display","block");
        jQuery("[class*='.$status_widget.'] .class_order_by_taxonomias").css("display","none");

    }


    });

    jQuery("[class*='.$status_widget.']  #yuzo_related_post_meta_views").on("change",function(){

        if( jQuery(this).val() == "other" ){

            jQuery("[class*='.$status_widget.'] .class_yuzo_meta_custom").css("display","block");

        }else{

            jQuery("[class*='.$status_widget.'] .class_yuzo_meta_custom").css("display","none");

        }

    });

    jQuery("[class*='.$status_widget.'] .yuzo_style_chosse #yuzo_related_post_style_img_2").on("click", function(event){
        jQuery("[class*='.$status_widget.'] #yuzo_related_post_height_image").val(85);
        jQuery("[class*='.$status_widget.'] #yuzo_related_post_font_size").val(14);
        jQuery("[class*='.$status_widget.'] #yuzo_related_post_text2_length").val(150);
    });

    jQuery("[class*='.$status_widget.'] .yuzo_style_chosse #yuzo_related_post_style_img_1").on("click", function(event){
        jQuery("[class*='.$status_widget.'] #yuzo_related_post_height_image").val(115);
        jQuery("[class*='.$status_widget.'] #yuzo_related_post_font_size").val(13);
        jQuery("[class*='.$status_widget.'] #yuzo_related_post_text2_length").val(0);
        jQuery("[class*='.$status_widget.'] .class_input4_margin .b .input_4--square:nth-child(2)").children(".input4_single_input").val(8).change();
        
    });

    if( jQuery("[class*='.$status_widget.'] #yuzo_related_post_meta_views").val() == "other" ){
        jQuery("[class*='.$status_widget.'] .class_yuzo_meta_custom").css("display","block");
        jQuery("[class*='.$status_widget.'] .class_yuzo_meta_custom").css("background","rgb(249, 249, 249)");
    }

    jQuery("[class*='.$status_widget.']  #use_yuzo_widget_as").on("change",function(){

        if( jQuery(this).val() == "list-post" ){

            jQuery("[class*='.$status_widget.'] .class_list_and_interval").css("display","block");
            jQuery("[class*='.$status_widget.'] .class_section_use_related_post").css("display","none");
            jQuery("[class*='.$status_widget.'] .class_yuzo_widget_as_html_post_list").css("display","none");

        }else{

            jQuery("[class*='.$status_widget.'] .class_list_and_interval").css("display","none");
            jQuery("[class*='.$status_widget.'] .class_section_use_related_post").css("display","block");
            jQuery("[class*='.$status_widget.'] .class_yuzo_widget_as_html_post_list").css("display","block");

        }

    });

    
    if( "'.$yuzo_widget_as.'" == "list-post" ){

        jQuery("[class*='.$status_widget.'] .class_list_and_interval").css("display","block");
        jQuery("[class*='.$status_widget.'] .class_section_use_related_post").css("display","none");
        jQuery("[class*='.$status_widget.'] .class_yuzo_widget_as_html_post_list").css("display","none");
        
    } else {

        jQuery("[class*='.$status_widget.'] .class_list_and_interval").css("display","none");
        jQuery("[class*='.$status_widget.'] .class_section_use_related_post").css("display","block");
        jQuery("[class*='.$status_widget.'] .class_yuzo_widget_as_html_post_list").css("display","block");

    }


  </script>
    <style>
    [class*='.$status_widget.'] .class_yuzo_meta_custom{ display: none; }
    [class*='.$status_widget.'] .class_section_use_related_post{ display: none; }
    </style>
  ';
  
?>
<?php }




function update($new_instance, $old_instance){

  $update = array();

  //In the examples of what fields checkbox come without that key, then you can not parse the defects since it back on and it makes you save them wrong.
  foreach ($new_instance as $key => $value)  $update[$key] = $this->ME->ilenwidget_validate_inputs_ext( ($value),$this->default_validate[$key] ); 
  

  return $update;
  
}




function widget($args,$instance){

    global $post, $wp_query, $yuzo_option_widget, $if_utils, $wpdb;


    // get Yuzo Option Main
    $yuzo_options = $if_utils->IF_get_option( $this->parameter['name_option'] );
    $yuzo_option_widget = json_decode (json_encode ($instance), FALSE);

    // Yuzo widget as 'related' only in singular, no show homepage or archive page
    if( ( is_home() || is_archive() || is_category() ) && $yuzo_option_widget->yuzo_widget_as == 'related' ) return;

    $style          = "";
    $script         = "";
    $transient_name = "yuzo_widget_query_cache_".$post->ID;
    $cacheTime      = 20; // minutes
    $rebuilt_query  = false;
    $post_in        = null;
    $post_not_in    = null;

    //verify cache query
    include_once(ABSPATH . 'wp-includes/pluggable.php');
    if( false === ($the_query_yuzo = get_transient($transient_name) ) || ( current_user_can( 'manage_options' )  && !isset($_GET['P3_NOCACHE']) )  ){
        $rebuilt_query  = true;
    }




    $_html = "";
    $_html = "<div class='widget yuzo_widget_wrap'><h3 class='widget-title'><span>".$instance["title"]."</span></h3>";
    $_html .= "<div class='yuzo_related_post_widget style-$yuzo_option_widget->style' >";

    //if( $wp_query->post_count != 0 ){ // if have result in loop post

    if( $rebuilt_query ){

        if( $yuzo_option_widget->yuzo_widget_as == 'related' ){

            // get no categories
            $array_no_category = array();
            $string_no_category = "";
            if( isset($yuzo_option_widget->exclude_category) && is_array($yuzo_option_widget->exclude_category) ){    

                if( ! in_array( '-1',$yuzo_option_widget->exclude_category ) ){    
                    foreach ($yuzo_option_widget->exclude_category as $ce_key => $ce_value) {
                        $array_no_category[]=$ce_value;
                    }
                }

            }

            // verify type page
            $post_type = get_post_type( $post->ID );
            if( is_array($post_type) ){
                if( ! in_array($post_type, (array)$yuzo_option_widget->post_type ) ){
                    return $content;
                }
            }

            // is show home
            if( isset($yuzo_option_widget->show_home) && !$yuzo_option_widget->show_home  && is_home() ){
                return $content;
            }

            // get and validate categories
            $array_categorias = isset($yuzo_option_widget->categories)?$yuzo_option_widget->categories:null;
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

            // get and validate tags
            $tag_ids = array();
            $string_cate = "";
            $string_tags = "";
            $post__in = null;

            $string_order_by = $yuzo_option_widget->order_by;
            $string_order    = $yuzo_option_widget->order;

            if( isset($yuzo_option_widget->related_based) ){
              if( $yuzo_option_widget->related_based == '3' ){
                $tags = wp_get_post_tags($post->ID);
                  if ($tags) {  
                    $tag_ids = array();
                    foreach($tags as $individual_tag) $tag_ids[] = $individual_tag->term_id;
                  }

                  $string_tags =  $tag_ids;
                  $string_cate = $category_plugin;
              }elseif( $yuzo_option_widget->related_based == '1' ){

                $tags = wp_get_post_tags($post->ID);
                  if ($tags) {  
                    $tag_ids = array();  
                    foreach($tags as $individual_tag) $tag_ids[] = $individual_tag->term_id;
                  }

                  //$string_tags =  implode(",",$tag_ids);
                  $string_tags =  $tag_ids;

              }elseif( $yuzo_option_widget->related_based == '2' ){

                $string_cate = $category_plugin;

              }elseif( $yuzo_option_widget->related_based == '4' ){

                $string_order_by = 'rand';

              }elseif( $yuzo_option_widget->related_based == '5' ){ // Taxonomies 

                $post__in = self::taxomy_real();
                $string_order = "";
                $string_order_by = 'post__in';

              }
            }



            $args_sql        = array(
                                  'posts_per_page'      => isset($yuzo_option_widget->number_post)?$yuzo_option_widget->number_post:0,
                                  'post_status'         => 'publish',
                                  'ignore_sticky_posts' => 1,
                                  'orderby'             => $string_order_by,
                                  'order'               => $string_order,
                                  'tag__in'             => $tag_ids,
                                  'category__in'        => $string_cate,
                                  'category__not_in'    => $array_no_category,
                        );


            // validate post current
            $post__not_in[] = $post->ID;
            if( is_array($post__in) ){
              $args_sql['post__in'] =  array_diff($post__in,$post__not_in);
            }else{
              $args_sql['post__not_in'] = $post__not_in;
            }




        }elseif( $yuzo_option_widget->yuzo_widget_as == 'list-post' ){

            if( $yuzo_option_widget->show_list  == 'most-popular' ){

                $args_sql = array('orderby'         => 'comment_count',
                              'posts_per_page'  => (int)$yuzo_option_widget->number_post);

                $args_sql['post__not_in'] = array($post->ID);

            }elseif( $yuzo_option_widget->show_list == 'last-post' ){

                $args_sql = array('order'           => 'DESC',
                                  'orderby'         => 'date',
                                  'posts_per_page'  => (int)$yuzo_option_widget->number_post);

                $args_sql['post__not_in'] = array($post->ID);

            }elseif( $yuzo_option_widget->show_list  == 'rand' ){

                $args_sql = array('orderby'         => 'rand',
                              'posts_per_page'  => (int)$yuzo_option_widget->number_post);

                $args_sql['post__not_in'] = array($post->ID);

            }elseif( $yuzo_option_widget->show_list == 'most-view' ){

                if( isset($yuzo_option_widget->meta_views) && $yuzo_option_widget->meta_views == 'other' ){

                    if( $yuzo_option_widget->meta_views_custom != 'popularposts' ){
                        global $interval_filter;
                        $interval_filter='';

                        // validate INTERVAL
                        if($yuzo_option_widget->interval=='last-month')
                            $interval_filter = " AND post_date > '" . date('Y-m-d', strtotime('-30 days')) . "'";
                        elseif($yuzo_option_widget->interval =='last-year')
                            $interval_filter = " AND post_date > '" . date('Y-m-d', strtotime('-365 days')) . "'";
                        elseif($yuzo_option_widget->interval =='last-week')
                            $interval_filter = " AND post_date > '" . date('Y-m-d', strtotime('-7 days')) . "'";
                        elseif($yuzo_option_widget->interval =='last-24h')
                            $interval_filter = " AND post_date > '" . date('Y-m-d', strtotime('-1 days')) . "'";
                        elseif($yuzo_option_widget->interval =='last-48h')
                            $interval_filter = " AND post_date > '" . date('Y-m-d', strtotime('-2 days')) . "'";

                        // add filter INTERVAL
                        add_filter('posts_where',array( $this,'filter_where_yuzo') );

                        // prepare parameters
                        $args_sql = null;
                        if( $yuzo_option_widget->show_list == 'most-view' ){

                            $meta_view_widget = "";
                            if( isset($yuzo_option_widget->meta_views) && $yuzo_option_widget->meta_views == 'yuzo-views'  ){
                                $meta_view_widget = "yuzo_views";
                            }elseif( isset($yuzo_option_widget->meta_views) && $yuzo_option_widget->meta_views == 'other' ){
                                $meta_view_widget = $yuzo_option_widget->meta_views_custom;
                            }

                            $args_sql = array(  'meta_key'        => $yuzo_option_widget->meta_views_custom,
                                                'orderby'         => 'meta_value_num',
                                                'posts_per_page'  => (int)$yuzo_option_widget->number_post);



                        }

                    }elseif( isset($yuzo_option_widget->meta_views_custom) && $yuzo_option_widget->meta_views_custom == 'popularposts' ){

                        
                        $table_name = $wpdb->prefix . "popularposts";
                        $array_ids = null;

                        // validate INTERVAL
                        if($yuzo_option_widget->interval=='last-month')
                            $interval_filter = "WHERE b.post_date > '" . date('Y-m-d', strtotime('-30 days')) . "' ";
                        elseif($yuzo_option_widget->interval =='last-year')
                            $interval_filter = "WHERE b.post_date > '" . date('Y-m-d', strtotime('-365 days')) . "' ";
                        elseif($yuzo_option_widget->interval =='last-week')
                            $interval_filter = "WHERE b.post_date > '" . date('Y-m-d', strtotime('-7 days')) . "' ";
                        elseif($yuzo_option_widget->interval =='last-24h')
                            $interval_filter = "WHERE b.post_date > '" . date('Y-m-d', strtotime('-1 days')) . "' ";
                        elseif($yuzo_option_widget->interval =='last-48h')
                            $interval_filter = "WHERE b.post_date > '" . date('Y-m-d', strtotime('-2 days')) . "' ";

                        $sql = "SELECT b.ID FROM {$table_name}data a INNER JOIN
                                                 {$wpdb->prefix}posts b 
                                ON a.postid = b.ID
                                $interval_filter 
                                ORDER BY pageviews DESC
                                LIMIT 0,$yuzo_option_widget->number_post";

                        $array_ids = $wpdb->get_results(  $sql , ARRAY_A );

                        if( is_array($array_ids) ){
                            
                            foreach ($array_ids as $array_ids_key => $array_ids_value) {
                                $post_in[] = $array_ids_value["ID"];
                            }

                        }
                    }

                }elseif( isset($yuzo_option_widget->meta_views) && $yuzo_option_widget->meta_views == 'yuzo-views' ){

                        $table_name = $wpdb->prefix . "yuzoviews";
                        $array_ids = null;

                        // validate INTERVAL
                        if($yuzo_option_widget->interval=='last-month')
                            $interval_filter = "WHERE b.post_date > '" . date('Y-m-d', strtotime('-30 days')) . "' ";
                        elseif($yuzo_option_widget->interval =='last-year')
                            $interval_filter = "WHERE b.post_date > '" . date('Y-m-d', strtotime('-365 days')) . "' ";
                        elseif($yuzo_option_widget->interval =='last-week')
                            $interval_filter = "WHERE b.post_date > '" . date('Y-m-d', strtotime('-7 days')) . "' ";
                        elseif($yuzo_option_widget->interval =='last-24h')
                            $interval_filter = "WHERE b.post_date > '" . date('Y-m-d', strtotime('-1 days')) . "' ";
                        elseif($yuzo_option_widget->interval =='last-48h')
                            $interval_filter = "WHERE b.post_date > '" . date('Y-m-d', strtotime('-2 days')) . "' ";

                        $sql = "SELECT b.ID FROM $table_name a INNER JOIN
                                                 {$wpdb->prefix}posts b 
                                ON a.post_id = b.ID
                                $interval_filter 
                                ORDER BY views DESC
                                LIMIT 0,$yuzo_option_widget->number_post";

                        $array_ids = $wpdb->get_results(  $sql , ARRAY_A );

                        if( is_array($array_ids) ){

                            foreach ($array_ids as $array_ids_key => $array_ids_value) {
                                $post_in[] = $array_ids_value["ID"];
                            }

                        }

                }

                $post__not_in[] = $post->ID;
                if( is_array($post_in) ){
                  $args_sql['post__in'] =  array_diff($post_in,$post__not_in);
                }else{
                  $args_sql['post__not_in'] = $post__not_in;
                }


            }

            // ser more general parameter
            $args_sql['post_status']         = 'publish';
            $args_sql['ignore_sticky_posts'] = '1';

        } // yuzo_widget_as

    } // rebuilt query


    //var_dump($args_sql);
    // cache query
    if( $rebuilt_query ){
        $the_query_yuzo = new WP_Query( $args_sql );
        set_transient( $transient_name , $the_query_yuzo, 60 * $cacheTime );
        // remove FILTER interval
        if( $yuzo_option_widget->yuzo_widget_as == 'list-post' && $yuzo_option_widget->meta_views == 'other' && $yuzo_option_widget->meta_views_custom != 'popularposts' ){
            remove_filter('posts_where',array( $this,'filter_where_yuzo') );
        }

    }
    //echo $the_query_yuzo->request;
    
    
    // The Loop
    if ( $the_query_yuzo->have_posts() && $wp_query->post_count != 0 ) {



        // set transitions
        $css_transitions = null;
        if(  isset($yuzo_option_widget->bg_color_hover_transitions) && $yuzo_option_widget->bg_color_hover_transitions ){
            $css_transitions = " -webkit-transition: background {$yuzo_option_widget->bg_color_hover_transitions}s linear; -moz-transition: background {$yuzo_option_widget->bg_color_hover_transitions}s linear; -o-transition: background {$yuzo_option_widget->bg_color_hover_transitions}s linear; transition: background {$yuzo_option_widget->bg_color_hover_transitions}s linear;";
        }

        // border radius
        $css_border = null;
        if( isset($yuzo_option_widget->thumbnail_border_radius) && $yuzo_option_widget->thumbnail_border_radius ){
            $css_border = " border-radius: {$yuzo_option_widget->thumbnail_border_radius}% ";
            if(  $yuzo_option_widget->thumbnail_border_radius == 50 ){
                $css_border = " border-radius: {$yuzo_option_widget->thumbnail_border_radius}%; margin:0 auto; width:".((int)$yuzo_option_widget->height_image - 20)."px";
            }
        }

        // margin related
        $css_margin = null;
        if( isset($yuzo_option_widget->related_margin) && $yuzo_option_widget->related_margin ){
            $margin = explode(",",$yuzo_option_widget->related_margin);
            $css_margin = " margin: {$margin[0]}px  {$margin[1]}px  {$margin[2]}px  {$margin[3]}px!important; ";
        }

        // padding related
        $css_padding = null;
        if( isset($yuzo_option_widget->related_padding) && $yuzo_option_widget->related_padding ){
            $padding = explode(",",$yuzo_option_widget->related_padding);
            $css_padding = " padding: {$padding[0]}px  {$padding[1]}px  {$padding[2]}px  {$padding[3]}px!important; ";
        }

        // effects visual
        $css_effects = self::effects( $yuzo_option_widget );
        $css_shine_effect1="";
        $css_shine_effect2="";
        if( isset($yuzo_option_widget->effect_related) && $yuzo_option_widget->effect_related == 'shine' ){
            $css_shine_effect1=" ilen_shine ";
            $css_shine_effect2=" <span class='shine-effect'></span> ";
        }

        // background size
        $css_background_size = "";
        if( !isset($yuzo_option_widget->background_size) ){ 
            $css_background_size = 'cover';
        }elseif( isset($yuzo_option_widget->background_size) && $yuzo_option_widget->background_size == 'cover' ){
            $css_background_size = 'cover';
        }elseif( isset($yuzo_option_widget->background_size) && $yuzo_option_widget->background_size == 'contain' ){
            $css_background_size = 'contain';
        }

        // variable views
        $my_array_views = array();

        // counter
        $count = 1; 

        if( isset($yuzo_option_widget->top_text) && $yuzo_option_widget->top_text ){
            $_html .= "<div class='yuzo_clearfixed'>". $if_utils->IF_setHtml( $yuzo_option_widget->top_text ) ."</div>";
        }

      
        while ( $the_query_yuzo->have_posts()  ) : $the_query_yuzo->the_post();

            // get array views
            $my_array_views = self::getViewsPost_to_yuzo();

            // title post to bold
            $bold_title = "";
            if( isset($yuzo_option_widget->title_bold) && $yuzo_option_widget->title_bold =='1'){
                $bold_title = "font-weight:bold";
            }


            // validate text to show
            $text_to_show = null;
            $text2_extract = "";
            if( (int)$yuzo_option_widget->text2_length > 0 ){

                if( ! isset($yuzo_option_widget->text_show) ){
                    $text_to_show = get_the_content();
                }elseif( isset($yuzo_option_widget->text_show) && $yuzo_option_widget->text_show == 1 ){
                    $text_to_show = get_the_content();
                }elseif( isset($yuzo_option_widget->text_show) && $yuzo_option_widget->text_show == 2 ){
                    $text_to_show = $post->post_excerpt;
                }

                $text2_extract = '<span class="yuzo_text" style="font-size:'.((int)$yuzo_option_widget->font_size - 4).'px;" >'.$if_utils->IF_setHtml( $if_utils->IF_cut_text( $text_to_show , (int)$yuzo_option_widget->text2_length, TRUE ) ).'</span>';

            }


            // set style widget 
            if( $yuzo_option_widget->style == 1 ){
                $image = $if_utils->IF_get_image(  $yuzo_option_widget->thumbnail_size, $yuzo_options->default_image, get_the_ID() );
                $_html .= '
                      <div class="relatedthumb " style="width:'.((int)$yuzo_option_widget->height_image + 15).'px;float:left;overflow:hidden;">  
                          
                          <a rel="external" href="'.get_permalink().'">
                                  <div class="yuzo-img-wrap '.$css_shine_effect1.'" style="width: '.((int)$yuzo_option_widget->height_image+15).'px;height:'.((int)$yuzo_option_widget->height_image - 20).'px;">
                                    '.$css_shine_effect2.'
                                    <div class="yuzo-img" style="background:url(\''.$image['src'].'\') 50% 50% no-repeat;width: '.((int)$yuzo_option_widget->height_image+15).'px;height:'.((int)$yuzo_option_widget->height_image - 20).'px;margin-bottom: 5px;background-size: '.$css_background_size.'; '.$css_border.'"></div>
                                  </div>
                                    <div style="clear:both;display:block;">'.$my_array_views['top'].'</div>
                               <span style="font-size:'.$yuzo_option_widget->font_size.'px;'.$bold_title.';">'.$if_utils->IF_setHtml( $if_utils->IF_cut_text( get_the_title(), $yuzo_option_widget->text_length , true ) ).'</span>
                          '.$text2_extract .'
                        <div  style="clear:both;display:block;">'.$my_array_views['bottom'].'</div>
                        </a> </div>';
                $style="<style>
                        .yuzo_related_post_widget img{width:".((int)$yuzo_option_widget->height_image + 10 )."px !important; height:{$yuzo_option_widget->height_image}px !important;}
                        .yuzo_related_post_widget .relatedthumb{line-height:".((int)$yuzo_option_widget->font_size +2 )."px;background:{$yuzo_option_widget->bg_color} !important;}";

                if( isset($yuzo_option_widget->style) && $yuzo_option_widget->style != 4 ){
                    $style .=".yuzo_related_post_widget .relatedthumb:hover{background:{$yuzo_option_widget->bg_color_hover} !important;$css_transitions}";
                }
                $style .="
                    .yuzo_related_post_widget .relatedthumb a{color:{$yuzo_option_widget->title_color};}
                    .yuzo_related_post_widget .yuzo_text {color:{$yuzo_option_widget->text_color};}
                    .yuzo_related_post_widget .relatedthumb{ $css_margin $css_padding }
                    $css_effects
                    </style>";

                if ( ! isset($yuzo_option_widget->yuzo_conflict) || ! $yuzo_option_widget->yuzo_conflict ) {
                  $script="<script>
                  jQuery(function() {
                    jQuery('.yuzo_related_post_widget').equalizer({ overflow : 'relatedthumb2' });
                  });
                  </script>";
                }

            }elseif( $yuzo_option_widget->style == 2 ){
                    $image = $if_utils->IF_get_image(  $yuzo_option_widget->thumbnail_size, $yuzo_options->default_image, get_the_ID() );
                    $_html .= '
              <div class="relatedthumb yuzo-list"  >  
                  <a rel="external" href="'.get_permalink().'" class="image-list">
                  <div class="yuzo-img-wrap '.$css_shine_effect1.'" style="width: '.((int)$yuzo_option_widget->height_image+15).'px;height:'.((int)$yuzo_option_widget->height_image - 20).'px;">
                            '.$css_shine_effect2.'
                             <div class="yuzo-img" style="background:url(\''.$image['src'].'\') 50% 50% no-repeat;width: '.((int)$yuzo_option_widget->height_image+20).'px;height:'.((int)$yuzo_option_widget->height_image - 20).'px;margin-bottom: 5px;background-size:  '.$css_background_size.'; '.$css_border.' "></div>
                  </div>
                  </a>
                  <a class="link-list" href="'.get_permalink().'" style="font-size:'.$yuzo_option_widget->font_size.'px;'.$bold_title.';line-height:'.( (int)$yuzo_option_widget->font_size + 8).'px;">'.$my_array_views['top'].' '.$if_utils->IF_setHtml( $if_utils->IF_cut_text( get_the_title(), $yuzo_option_widget->text_length, true ) ).'  '.$my_array_views['bottom'].'</a></h3>
                        '.$text2_extract .'
                       
              </div>';
                    $style="<style>
                .yuzo_related_post_widget .relatedthumb { background:{$yuzo_option_widget->bg_color} !important;$css_transitions }";
                if( isset($yuzo_option_widget->style) && $yuzo_option_widget->style != 4 ){
                    $style .=".yuzo_related_post_widget .relatedthumb:hover{background:{$yuzo_option_widget->bg_color_hover} !important;$css_transitions}";
                }
                $style .=".yuzo_related_post_widget .relatedthumb:hover{background:{$yuzo_option_widget->bg_color_hover} !important;;}
                .yuzo_related_post_widget .yuzo_text {color:{$yuzo_option_widget->text_color};}
                .yuzo_related_post_widget .relatedthumb a{color:{$yuzo_option_widget->title_color};}
                .yuzo_related_post_widget .relatedthumb{ $css_margin $css_padding }
                $css_effects
                </style>";
                    
            }elseif( $yuzo_option_widget->style == 3 ){
                    $_html .= '
                    <div class="relatedthumb yuzo-list"  >  
                        <a class="link-list" href="'.get_permalink().'" style="font-size:'.$yuzo_option_widget->font_size.'px;'.$bold_title.';line-height:'.( (int)$yuzo_option_widget->font_size + 8).'px;">'.$my_array_views['top'].' '.$if_utils->IF_setHtml( $if_utils->IF_cut_text( get_the_title(), $yuzo_option_widget->text_length, true ) ).' '.$my_array_views['bottom'].'</a>   </h3>
                              '.$text2_extract .'
                    </div>';
                    $style="<style>
                .yuzo_related_post_widget .relatedthumb{background:{$yuzo_option_widget->bg_color} !important;$css_transitions}";
                if( isset($yuzo_option_widget->style) && $yuzo_option_widget->style != 4 ){
                    $style .=".yuzo_related_post_widget .relatedthumb:hover{background:{$yuzo_option_widget->bg_color_hover} !important;$css_transitions}";
                }
                $style .=".yuzo_related_post_widget .relatedthumb:hover{background:{$yuzo_option_widget->bg_color_hover} !important;$css_transitions}
                .yuzo_related_post_widget .yuzo_text {color:{$yuzo_option_widget->text_color};}
                .yuzo_related_post_widget .relatedthumb{ $css_margin $css_padding }
                </style>";
                    
            }elseif( $yuzo_option_widget->style == 4 ){
                    //$image = $if_utils->IF_get_image(  $yuzo_option_widget->thumbnail_size, $yuzo_option_widget->default_image );
                    $_html .= '
                    <div class="relatedthumb yuzo-list-color color-'.$count.'"  >  
                        <a class="link-list" href="'.get_permalink().'" style="font-size:'.$yuzo_option_widget->font_size.'px;'.$bold_title.';line-height:'.( (int)$yuzo_option_widget->font_size + 3).'px;">'.$my_array_views['top'].' '.$if_utils->IF_setHtml( $if_utils->IF_cut_text( get_the_title(), $yuzo_option_widget->text_length, true ) ).' '.$my_array_views['bottom'].'</a>  </h3>
                              '.$text2_extract .'
                    </div>';
                    $style="<style>
                    .yuzo_related_post_widget .yuzo_text {color:{$yuzo_option_widget->text_color};}
                    .yuzo_related_post_widget .relatedthumb a{color:{$yuzo_option_widget->title_color};}
                </style>";
                    
            } // style

            $count++;

        endwhile;

    } // $the_query_yuzo->have_posts()


    // set last script and css for this widget
    $_html .= "</div> \n $style $script \n</div>";

    // Reset Post Data
    wp_reset_postdata();
  
    // print HTML
    echo $_html;

}


function effects( $yuzo_w ){

 
   $css_effects = null;
   if( isset( $yuzo_w->effect_related ) ){

      if( $yuzo_w->effect_related == 'enlarge' ){
        /* link: http://santyweb.blogspot.com/2011/06/css-agrandar-imagenes-o-texto-al-pasar.html */
        $css_effects = ".yuzo_related_post_widget .relatedthumb{
display:block!important;
-webkit-transition:-webkit-transform 0.3s ease-out!important;
-moz-transition:-moz-transform 0.3s ease-out!important;
-o-transition:-o-transform 0.3s ease-out!important;
-ms-transition:-ms-transform 0.3s ease-out!important;
transition:transform 0.3s ease-out!important;
}
.yuzo_related_post_widget .relatedthumb:hover{
-moz-transform: scale(1.1);
-webkit-transform: scale(1.1);
-o-transform: scale(1.1);
-ms-transform: scale(1.1);
transform: scale(1.1)
}";
      }elseif( $yuzo_w->effect_related == 'zoom_icon_link' ){
        /* link: http://santyweb.blogspot.com/2011/06/css-agrandar-imagenes-o-texto-al-pasar.html */
        $css_effects = ".yuzo_related_post_widget .relatedthumb .yuzo-img{
  -webkit-transition:all 0.3s ease-out;
  -moz-transition:all 0.3s ease-out;
  -o-transition:all 0.3s ease-out;
  -ms-transition:all 0.3s ease-out;
  transition:all 0.3s ease-out;
}
.yuzo_related_post_widget .relatedthumb .yuzo-img-wrap{
  overflow:hidden;
  background: url(".$this->parameter['theme_imagen']."/link-overlay.png) no-repeat center;
}
.yuzo_related_post_widget .relatedthumb:hover .yuzo-img {
  opacity: 0.7;
  -webkit-transform: scale(1.2);
  transform: scale(1.2);
}";
      }
      elseif( $yuzo_w->effect_related == 'shine' ){
        $css_effects = ".yuzo_related_post_widget .relatedthumb{}";
      }


      
      
   }


   return $css_effects;


}




function getViewsPost_to_yuzo(){

    global $yuzo_option_widget;

    // Display Views
    $counts = 0;
    $meta_views_top = "";
    $meta_views_bottom = "";

    if( isset($yuzo_option_widget->meta_views) && $yuzo_option_widget->meta_views && isset($yuzo_option_widget->show_in_related_post) && $yuzo_option_widget->show_in_related_post ){

        // get count
        if( $yuzo_option_widget->meta_views == 'yuzo-views' ){

          $counts = self::yuzo_get_PostViews( get_the_ID() );

        }elseif( $yuzo_option_widget->meta_views == 'other' ){

          $meta_views_custom = isset( $yuzo_option_widget->meta_views_custom )?$yuzo_option_widget->meta_views_custom:'';
          $counts = self::yuzo_get_PostViews( get_the_ID(), $meta_views_custom  );

        }


        //get postition
        if( isset( $yuzo_option_widget->show_in_related_post_position ) && $yuzo_option_widget->show_in_related_post_position ){

            $text_views = "";
            $class_views= "";
            if( isset(  $yuzo_option_widget->show_in_related_post_text ) && $yuzo_option_widget->show_in_related_post_text ){
                $text_views = $yuzo_option_widget->show_in_related_post_text;
            }


            if( $yuzo_option_widget->show_in_related_post_position == 'show-views-top' ){
                $meta_views_top = "<div class='yuzo_views_post yuzo_icon_views yuzo_icon_views__top' style='font-size:".((int)$yuzo_option_widget->font_size - 2)."px;'>$text_views $counts</div>";
            }elseif( $yuzo_option_widget->show_in_related_post_position == 'show-views-bottom' ){
                $meta_views_bottom = "<div class='yuzo_views_post yuzo_icon_views yuzo_icon_views__bottom' style='font-size:".((int)$yuzo_option_widget->font_size - 2)."px;'>$text_views $counts</div>";
            }

        }

    }

    $array_views_yuzo_post = array();

    $array_views_yuzo_post['top'] = $meta_views_top;
    $array_views_yuzo_post['bottom'] = $meta_views_bottom;

    return $array_views_yuzo_post;

}



//Gets the  number of Post Views to be used later.
function yuzo_get_PostViews($post_ID, $count_key = ''){

    global $yuzo_option_widget;
    $transient_name      = "yuzo_view_cache";
    $cacheTime           = 20; // minutes
    $the_cache_yuzo_view = false;


    // verify cache query
    include_once(ABSPATH . 'wp-includes/pluggable.php');
    if( false === ($count = get_transient($transient_name) ) || ( current_user_can( 'manage_options' )  && !isset($_GET['P3_NOCACHE']) )  ){
      $the_cache_yuzo_view  = true;
    }
 
    if( $the_cache_yuzo_view == true ){

        $count = 0;
        if( isset($yuzo_option_widget->meta_views) && $yuzo_option_widget->meta_views == 'other' ){
          $count_key = isset($yuzo_option_widget->meta_views_custom)? $yuzo_option_widget->meta_views_custom:'';
        }

        //Returns values of the custom field with the specified key from the specified post.
        if( $count_key != 'popularposts' && !$count_key ){
            $count = self::yuzo_get_views($post_ID); // default yuzo
        }elseif( $count_key == 'popularposts'  ){ // if use 'WordPress Popular Posts'
            $count = self::wpp_get_views( $post_ID );
        }else{
            $count = get_post_meta($post_ID, $count_key , true); // other custom views
        }

        set_transient( $transient_name , $count, 60 * $cacheTime); // set cache

    }else{
        $count = $count;
    }

    // format
    if( isset($yuzo_option_widget->format_count) && $yuzo_option_widget->format_count ){
      $count = number_format((int)$count, 0, '', "$yuzo_option_widget->format_count");
    }  
 
    return $count;
}


function taxomy_real(){

  global $yuzo_options,$wpdb;

  $args = "SELECT term_taxonomy_id FROM {$wpdb->term_relationships} WHERE object_id = " . get_the_ID();

  $term_taxonomy_ids = $wpdb->get_col( "$args" );
  if ( !$term_taxonomy_ids ) { return; }
  $term_taxonomy_ids_str = implode( ",", $term_taxonomy_ids );
  
  $object_ids = array();
  $object_ids = $wpdb->get_col( "SELECT object_id FROM {$wpdb->term_relationships} WHERE term_taxonomy_id IN ( {$term_taxonomy_ids_str} ) " );
  if ( !$object_ids ) { return; }
  
  $object_ids = array_count_values( $object_ids );
  
  arsort( $object_ids );

  $order_by = isset($yuzo_options->order_by_taxonomias)?$yuzo_options->order_by_taxonomias:'';
  $array_id_post_return = null;
  if ( $order_by == "related_scores_high__speedy" ) {
    $count = 1;
    foreach ( $object_ids as $object_id => $relevancy_score ) {
      $related_post = $wpdb->get_row( "SELECT ID FROM {$wpdb->posts} WHERE ID = {$object_id} AND post_status = 'publish'" );
      if ( $related_post ) {

        $array_id_post_return[] = $related_post->ID;

        if ( $count++ >= ( (int)$yuzo_options->display_post + 1 ) ) {
          break;
        }
      }
    }
  } else {
    $relevancy_scores = array();
    $post_ids = array();
    $post_date = array();
    $post_modified = array();
    foreach ( $object_ids as $object_id => $relevancy_score ) {
      $related_post = $wpdb->get_row( "SELECT ID, post_date, post_modified FROM {$wpdb->posts} WHERE ID = {$object_id} AND  post_status = 'publish'" );
      if ( $related_post ) {
        array_push( $relevancy_scores, $relevancy_score );
        array_push( $post_ids, $related_post->ID );
        array_push( $post_date, $related_post->post_date );
        array_push( $post_modified, $related_post->post_modified );
      }
    }
    if ( $post_ids ) {  
      if ( $order_by == "related_scores_high__date_published_old" ){
        array_multisort( $relevancy_scores, SORT_DESC, $post_date, SORT_ASC, $post_ids, SORT_ASC, $post_modified, SORT_ASC );
      } elseif ( $order_by == "related_scores_low__date_published_new" ) {
        array_multisort( $relevancy_scores, SORT_ASC, $post_date, SORT_DESC, $post_ids, SORT_DESC, $post_modified, SORT_DESC );
      } elseif ( $order_by == "related_scores_low__date_published_old" ) {
        array_multisort( $relevancy_scores, SORT_ASC, $post_date, SORT_ASC, $post_ids, SORT_ASC, $post_modified, SORT_ASC );
      } elseif ( $order_by == "related_scores_high__date_modified_new" ) {
        array_multisort( $relevancy_scores, SORT_DESC, $post_modified, SORT_DESC, $post_date, SORT_DESC, $post_ids, SORT_DESC );
      } elseif ( $order_by == "related_scores_high__date_modified_old" ) {
        array_multisort( $relevancy_scores, SORT_DESC, $post_modified, SORT_ASC, $post_date, SORT_ASC, $post_ids, SORT_ASC );
      } elseif ( $order_by == "related_scores_low__date_modified_new" ) {
        array_multisort( $relevancy_scores, SORT_ASC, $post_modified, SORT_DESC, $post_date, SORT_DESC, $post_ids, SORT_DESC );
      } elseif ( $order_by == "related_scores_low__date_modified_old" ) {
        array_multisort( $relevancy_scores, SORT_ASC, $post_modified, SORT_ASC, $post_date, SORT_ASC, $post_ids, SORT_ASC );
      } elseif ( $order_by == "date_published_new" ) {
        array_multisort( $post_date, SORT_DESC, $post_ids, SORT_DESC, $post_modified, SORT_DESC, $relevancy_scores, SORT_DESC );
      } elseif ( $order_by == "date_published_old" ) {
        array_multisort( $post_date, SORT_ASC, $post_ids, SORT_ASC, $post_modified, SORT_ASC, $relevancy_scores, SORT_DESC );
      } elseif ( $order_by == "date_modified_new" ) {
        array_multisort( $post_modified, SORT_DESC, $post_date, SORT_DESC, $post_ids, SORT_DESC, $relevancy_scores, SORT_DESC );
      } elseif ( $order_by == "date_modified_old" ) {
        array_multisort( $post_modified, SORT_ASC, $post_date, SORT_ASC, $post_ids, SORT_ASC, $relevancy_scores, SORT_DESC );
      } else {
        array_multisort( $relevancy_scores, SORT_DESC, $post_date, SORT_DESC, $post_ids, SORT_DESC, $post_modified, SORT_DESC );
      }
      $count = 1;
      foreach ( $post_ids as $key => $post_id ) {
        $array_id_post_return[] = $post_id;
        if ( $count++ >= ((int)$yuzo_options->display_post + 1 ) ) {
          break;
        }
      }
    }
  }


  return $array_id_post_return;
}


/**
* Gets the filter if the query is for some rando to date,
* this filter is put in this place as we had problems 
* with recursion in the main file with the problem that was solved
*
* @param string $where variable global for query
* @return string  Return
*/
function filter_where_yuzo($where = ''){
    //posts in the last 30 days or others
    global $interval_filter;
    $where .= $interval_filter;
    return $where;
}



/**
 * WordPress Popular Posts template tags for use in themes.
 * ( This function is copied from the original plugin to take the hit counter based on this plugin. )
 */
/**
 * Template tag - gets views count.
 *
 * @since   2.0.3
 * @global  object  wpdb
 * @param   int     id
 * @return  string
 */
function wpp_get_views($id = NULL) {

    global $wpdb;
    $table_name = $wpdb->prefix . "popularposts";

    $query = "SELECT pageviews FROM {$table_name}data WHERE postid = '{$id}'";
    $result = $wpdb->get_var($query);

    if ( !$result ) {
        return "0";
    }

    return $result;
}


function yuzo_get_views($id = NULL) {

    global $wpdb;
    $table_name = $wpdb->prefix . "yuzoviews";

    $query = "SELECT views FROM {$table_name} WHERE post_id = $id";
    $result = $wpdb->get_var($query);

    if ( !$result ) {
        return "0";
    }

    return $result;
}


}


add_action( 'widgets_init', create_function('', 'return register_widget("yuzo_widget");') ); 

?>