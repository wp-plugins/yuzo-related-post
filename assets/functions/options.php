<?php
/**
 * Options Plugin
 * Make configutarion
*/

if ( !class_exists('yuzo_related_post_make') ) {

class yuzo_related_post_make{

        public $parameter       = array();
        public $options         = array();
        public $components      = array();

    function __construct(){

        if( is_admin() )
            self::configuration_plugin();
        else
            self::parameters();

    }

    function getHeaderPlugin(){
        //code 

        global $wp_social_pupup_header_plugins;
        return array(            'id'             =>'yuzo_related_post_id',
                                 'id_menu'        =>'yuzo_related_post_menu',
                                 'name'           =>'Yuzo Related Post',
                                 'name_long'      =>'Yuzo Related Post',
                                 'name_option'    =>'yuzo_related_post',
                                 'name_plugin_url'=>'yuzo-related-post',
                                 'descripcion'    =>'Gets the related post on your blog with any design characteristics.',
                                 'version'        =>'2.0.6',
                                 'url'            =>'',
                                 'logo'           =>'<i class="fa fa-bolt"></i>', // or image .jpg,png
                                 'logo_text'      =>'', // alt of image
                                 'slogan'         =>'', // powered by <a href="">iLenTheme</a>
                                 'url_framework'  =>plugins_url()."/yuzo-related-post/assets/ilenframework",
                                 'theme_imagen'   =>plugins_url()."/yuzo-related-post/assets/images",
                                 'languages'      =>plugins_url()."/yuzo-related-post/assets/languages",
                                 'twitter'        => 'https://twitter.com/intent/tweet?text=View this awesome plugin WP;url=http://bit.ly/1rLUvBM&amp;via=iLenElFuerte',
                                 'wp_review'      => 'http://wordpress.org/support/view/plugin-reviews/yuzo-related-post?filter=5',
                                 'type'           =>'plugin',
                                 'method'         =>'free',
                                 'themeadmin'     =>'fresh');
    }

    function getOptionsPlugin(){

    global ${'tabs_plugin_' . $this->parameter['name_option']};
    ${'tabs_plugin_' . $this->parameter['name_option']} = array();
    ${'tabs_plugin_' . $this->parameter['name_option']}['tab01']=array('id'=>'tab01','name'=>'Main Settings','icon'=>'<i class="fa fa-circle-o"></i>','width'=>'358'); // 358px = 2 columns
    ${'tabs_plugin_' . $this->parameter['name_option']}['tab02']=array('id'=>'tab02','name'=>'Styling','icon'=>'<i class="fa fa-pencil"></i>','width'=>'358','fix'=>1);


    return array('a'=>array(                'title'      => __('General',$this->parameter['name_option']), 
                                            'title_large'=> __('General',$this->parameter['name_option']), 
                                            'description'=> '', 
                                            'icon'       => 'fa fa-circle-o',
                                            'tab'        => 'tab01',

                                            'options'    => array(  
                                                                     
                                                                    array(  'title' =>__('Top Text',$this->parameter['name_option']),
                                                                            'help'  =>__('Title top of related',$this->parameter['name_option']),
                                                                            'type'  =>'text',
                                                                            'value' =>'<h3>Related Post</h3>',
                                                                            'id'    =>$this->parameter['name_option'].'_top_text',
                                                                            'name'  =>$this->parameter['name_option'].'_top_text',
                                                                            'class' =>'',
                                                                            'row'   =>array('a','b')),


                                                                    array(  'title' =>__('Number of  similar Post to display',$this->parameter['name_option']),
                                                                            'help'  =>__('Number Post',$this->parameter['name_option']),
                                                                            'type'  =>'select',
                                                                            'value' =>4,
                                                                            'items' =>array(2=>'2',3=>'3',4=>'4',5=>'5',6=>'6',7=>'7',8=>'8',9=>'9',10=>'10',11=>'11',12=>'12',13=>'13',14=>'14',15=>'15',16=>'16',17=>'17',18=>'18',19=>'19',20=>'20'),
                                                                            'id'    =>$this->parameter['name_option'].'_display_post',
                                                                            'name'  =>$this->parameter['name_option'].'_display_post',
                                                                            'class' =>'',
                                                                            'row'   =>array('a','b')),

                                                                    array(  'title' =>__('Post Type:',$this->parameter['name_option']), //title section
                                                                            'help'  =>__('Type related post where is displayed',$this->parameter['name_option']), //descripcion section
                                                                            'type'  =>'checkbox', 
                                                                            'value' =>array('post'),
                                                                            'value_check'=>array('post'),
                                                                            'display'   =>'types_post', 
                                                                            'id'    =>$this->parameter['name_option'].'_post_type', //id
                                                                            'name'  =>$this->parameter['name_option'].'_post_type', //name
                                                                            'class' =>'', //class
                                                                            'row'   =>array('a','b')),

                                                                    array(  'title' =>__('Show in Home:',$this->parameter['name_option']), //title section
                                                                            'help'  =>'Displays related post in the home? (only if template allows)',
                                                                            'type'  =>'checkbox', //type input configuration
                                                                            'value' =>'0', // default
                                                                            'value_check'=>1, // value data
                                                                            'id'    =>$this->parameter['name_option'].'_'.'show_home',  
                                                                            'name'  =>$this->parameter['name_option'].'_'.'show_home',  
                                                                            'class' =>'', //class
                                                                            'row'   =>array('a','b')),

                                                                    array(  'title' =>__('Default image URL',$this->parameter['name_option']),
                                                                            'help'  =>__('Default image in case there is no image in the post',$this->parameter['name_option']),
                                                                            'type'  =>'text',
                                                                            'value' =>$this->parameter['theme_imagen'].'/default.png',
                                                                            'id'    =>$this->parameter['name_option'].'_default_image',
                                                                            'name'  =>$this->parameter['name_option'].'_default_image',
                                                                            'class' =>'',
                                                                            'row'   =>array('a','b')),

                                                                    array(  'title' =>__('Thumbnail size',$this->parameter['name_option']),
                                                                            'help'  =>__('Image size, recommended "Medium"',$this->parameter['name_option']),
                                                                            'type'  =>'select',
                                                                            'value' =>'medium',
                                                                            'items' =>array('thumbnail'=>'Thumbnail','medium'=>'Medium'),
                                                                            'id'    =>$this->parameter['name_option'].'_thumbnail_size',
                                                                            'name'  =>$this->parameter['name_option'].'_thumbnail_size',
                                                                            'class' =>'',
                                                                            'row'   =>array('a','b')),


                                                                     array(  'title' =>__('Related to',$this->parameter['name_option']),
                                                                            'help'  =>__('Related Post based',$this->parameter['name_option']),
                                                                            'type'  =>'select',
                                                                            'value' =>1,
                                                                            'items' =>array(1=>__('Tags',$this->parameter['name_option']),
                                                                                            2=>__('Category',$this->parameter['name_option']),
                                                                                            3=>__('Tags & Category',$this->parameter['name_option']),
                                                                                            4=>__('Random',$this->parameter['name_option']),
                                                                                            ),
                                                                            'id'    =>$this->parameter['name_option'].'_related_to',
                                                                            'name'  =>$this->parameter['name_option'].'_related_to',
                                                                            'class' =>'',
                                                                            'row'   =>array('a','b')),


                                                                    array(  'title' =>__('Order by',$this->parameter['name_option']),
                                                                            'help'  =>__('Multiple criteria systems',$this->parameter['name_option']),
                                                                            'type'  =>'select',
                                                                            'value' =>'rand',
                                                                            'items' =>array('none'=>'None','ID'=>'ID','author'=>'Author','title'=>'Title','name'=>'Name','date'=>'Date','modified'=>'Modified','rand'=>'Rand','comment_count'=>'Comment Count'),
                                                                            'id'    =>$this->parameter['name_option'].'_order_by',
                                                                            'name'  =>$this->parameter['name_option'].'_order_by',
                                                                            'class' =>'',
                                                                            'row'   =>array('a','b')),


                                                                    array(  'title' =>__('Order',$this->parameter['name_option']),
                                                                            'help'  =>'',
                                                                            'type'  =>'select',
                                                                            'value' =>'DESC',
                                                                            'items' =>array('DESC'=>'Desc','ASC'=>'Asc'),
                                                                            'id'    =>$this->parameter['name_option'].'_order',
                                                                            'name'  =>$this->parameter['name_option'].'_order',
                                                                            'class' =>'',
                                                                            'row'   =>array('a','b')),


                                                                    ),
                ),
                'b'=>array(                'title'      => __('Custom styling',$this->parameter['name_option']), 
                                           'title_large'=> __('',$this->parameter['name_option']), 
                                           'description'=> '',  
                                           'icon'       => '',
                                           'tab'        => 'tab02',

                                            'options'    => array( 

                                                                    array(  'title' =>__('Height & Width image',$this->parameter['name_option']),
                                                                            'help'  =>__('in px',$this->parameter['name_option']),
                                                                            'type'  =>'text',
                                                                            'value' =>'110',
                                                                            'id'    =>$this->parameter['name_option'].'_height_image',
                                                                            'name'  =>$this->parameter['name_option'].'_height_image',
                                                                            'class' =>'',
                                                                            'row'   =>array('a','b')),


                                                                    array(  'title' =>__('Font size',$this->parameter['name_option']),
                                                                            'help'  =>__('Font size of title related',$this->parameter['name_option']),
                                                                            'type'  =>'select',
                                                                            'value' =>13,
                                                                            'items' =>array(12=>'12',13=>'13',14=>'14',15=>'15',16=>'16',17=>'17',18=>'18',19=>'19',20=>'20'),
                                                                            'id'    =>$this->parameter['name_option'].'_font_size',
                                                                            'name'  =>$this->parameter['name_option'].'_font_size',
                                                                            'class' =>'',
                                                                            'row'   =>array('a','b')),

                                                                    array(  'title' =>__('Title length',$this->parameter['name_option']),
                                                                            'help'  =>__('Number of characters to be shown in the title',$this->parameter['name_option']),
                                                                            'type'  =>'text',
                                                                            'value' =>'50',
                                                                            'id'    =>$this->parameter['name_option'].'_text_length',
                                                                            'name'  =>$this->parameter['name_option'].'_text_length',
                                                                            'class' =>'',
                                                                            'row'   =>array('a','b')),

                                                                    array(  'title' =>__('Title Bold:',$this->parameter['name_option']), //title section
                                                                            'help'  =>'Title font weight',
                                                                            'type'  =>'checkbox', //type input configuration
                                                                            'value' =>'0', //value
                                                                            'value_check'=>1,
                                                                            'id'    =>$this->parameter['name_option'].'_title_bold', //id
                                                                            'name'  =>$this->parameter['name_option'].'_title_bold', //name
                                                                            'class' =>'', //class
                                                                            'row'   =>array('a','b')),

                                                                    array(  'title' =>__('Text length',$this->parameter['name_option']),
                                                                            'help'  =>__('Number of text lettering post',$this->parameter['name_option']),
                                                                            'type'  =>'text',
                                                                            'value' =>'0',
                                                                            'id'    =>$this->parameter['name_option'].'_text2_length',
                                                                            'name'  =>$this->parameter['name_option'].'_text2_length',
                                                                            'class' =>'',
                                                                            'row'   =>array('a','b')),


                                                                    array(  'title' =>__('Background Color',$this->parameter['name_option']),
                                                                            'help'  =>'', 
                                                                            'type'  =>'color', 
                                                                            'value' =>'#FFF', // default
                                                                            'id'    =>$this->parameter['name_option'].'_bg_color',
                                                                            'name'  =>$this->parameter['name_option'].'_bg_color', 
                                                                            'class' =>'', 
                                                                            'row'   =>array('a','b')),

                                                                    array(  'title' =>__('Hover Background Color',$this->parameter['name_option']),
                                                                            'help'  =>'', 
                                                                            'type'  =>'color', 
                                                                            'value' =>'#FFFFE6', // default
                                                                            'id'    =>$this->parameter['name_option'].'_bg_color_hover',
                                                                            'name'  =>$this->parameter['name_option'].'_bg_color_hover', 
                                                                            'class' =>'', 
                                                                            'row'   =>array('a','b')),
                                                                            
                                                                            
                                                                    array(  'title' =>__('Style',$this->parameter['name_option']),
                                                                            'help'  =>'',
                                                                            'type'  =>'radio_image',
                                                                            'value' =>1,
                                                                            'items' =>array(    array('value'=>1,
                                                                                                      'text' =>'Horizontal',
                                                                                                      'image'=>$this->parameter['theme_imagen'].'/horizontal1.jpg'),

                                                                                                array('value'=>2,
                                                                                                      'text' =>'Vertical',
                                                                                                      'image'=>$this->parameter['theme_imagen'].'/vertical1.jpg'),
 
                                                                                            ),

                                                                            'id'    =>$this->parameter['name_option'].'_style',
                                                                            'name'  =>$this->parameter['name_option'].'_style',
                                                                            'class' =>'',
                                                                            'row'   =>array('a','b')),
                                                                            
                                                                            

                                                                   ),
                ),
                'c'=>array(                'title'      => __('Advanced',$this->parameter['name_option']), 
                                           'title_large'=> __('',$this->parameter['name_option']), 
                                           'description'=> '',  
                                           'icon'       => '',
                                           'tab'        => 'tab01',

                                            'options'    => array( 


                                                                    array(  'title' =>__('Automatically append to the post content:',$this->parameter['name_option']), //title section
                                                                            'help'  =>'Or use <code>&lt;?php get_yuzo_related_posts(); ?&gt;</code> in the Loop', //descripcion section
                                                                            'type'  =>'checkbox', //type input configuration
                                                                            'value' =>'0', //value
                                                                            'value_check'=>1,
                                                                            'id'    =>$this->parameter['name_option'].'_automatically_append', //id
                                                                            'name'  =>$this->parameter['name_option'].'_automatically_append', //name
                                                                            'class' =>'', //class
                                                                            'row'   =>array('a','b')),


                                                                    array(  'title' =>__('Categories on which related thumbnails will appear:',$this->parameter['name_option']), //title section
                                                                            'help'  =>'', //descripcion section
                                                                            'type'  =>'component_list_categories',  
                                                                            'value' =>array('-1'), //value
                                                                            'value_check'=>0,
                                                                            'id'    =>$this->parameter['name_option'].'_categories', //id
                                                                            'name'  =>$this->parameter['name_option'].'_categories', //name
                                                                            'class' =>'', //class
                                                                            'row'   =>array('a','b')),



                                                                    array(  'title' =>__('If there is no related post, display random post?',$this->parameter['name_option']), //title section
                                                                            'help'  =>'only if use <code>&lt;?php get_yuzo_related_posts(); ?&gt;</code> in the Loop', //descripcion section
                                                                            'type'  =>'checkbox', 
                                                                            'value' =>'1',
                                                                            'value_check'=>'1',
                                                                            'id'    =>$this->parameter['name_option'].'_display_random', //id
                                                                            'name'  =>$this->parameter['name_option'].'_display_random', //name
                                                                            'class' =>'', //class
                                                                            'row'   =>array('a','b')),

                                                                    

                                                            )
                                        ),
                            'last_update'=>time(),


                             );
        
    }





    



    function parameters(){

        $this->parameter = self::getHeaderPlugin();
    }

    function myoptions_build(){
        
        $this->options = self::getOptionsPlugin();

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

}
}


?>