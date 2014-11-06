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


        // get utils
        require_once  ABSPATH.'/wp-content/plugins/'.$this->parameter['name_plugin_url']."/assets/ilenframework/assets/lib/utils.php";

    }

    function getHeaderPlugin(){
        //code 

        global $wp_social_pupup_header_plugins;
        return array(            'id'             =>'yuzo_related_post_id',
                                 'id_menu'        =>'yuzo-related-post',
                                 'name'           =>'Yuzo  ̵ ̵ ̵  Related Post',
                                 'name_long'      =>'Yuzo  ̵ ̵ ̵  Related Post',
                                 'name_option'    =>'yuzo_related_post',
                                 'name_plugin_url'=>'yuzo-related-post',
                                 'descripcion'    =>'Gets the related post on your blog with any design characteristics.',
                                 'version'        =>'2.8',
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
    ${'tabs_plugin_' . $this->parameter['name_option']}['tab01']=array('id'=>'tab01','name'=>'Main Settings','icon'=>'<i class="fa fa-circle-o"></i>','width'=>'200'); 
    ${'tabs_plugin_' . $this->parameter['name_option']}['tab02']=array('id'=>'tab02','name'=>'Styling','icon'=>'<i class="fa fa-pencil"></i>','width'=>'200'); // ,'fix'=>1
    ${'tabs_plugin_' . $this->parameter['name_option']}['tab03']=array('id'=>'tab03','name'=>'Productivity','icon'=>'<i class="fa fa-eye"></i>','width'=>'200'); 
    

    // get category for exclude
    $categories = '';
    $categories = get_categories();
    $categories_array = array();
    foreach ($categories as $cats_key => $cats_value) {
        $categories_array[]=array('value'=>$cats_value->cat_ID,'id'=>$this->parameter['name_option'].'_exca','text'=>$cats_value->name,'help'=>'');
    }

    return array('a'=>array(                'title'      => __('Basic',$this->parameter['name_option']), 
                                            'title_large'=> __('Basic',$this->parameter['name_option']), 
                                            'description'=> '', 
                                            'icon'       => 'fa fa-circle-o',
                                            'tab'        => 'tab01',

                                            'options'    => array(  
                                                                     
                                                                    array(  'title' =>__('Top Text',$this->parameter['name_option']),
                                                                            'help'  =>__('Title top of related',$this->parameter['name_option']),
                                                                            'type'  =>'text',
                                                                            'value' =>'<h3>Related Post</h3>',
                                                                            'id'    =>$this->parameter['name_option'].'_'.'top_text',
                                                                            'name'  =>$this->parameter['name_option'].'_'.'top_text',
                                                                            'class' =>'',
                                                                            'row'   =>array('a','b')),


                                                                    array(  'title' =>__('Number of  similar Post to display',$this->parameter['name_option']),
                                                                            'help'  =>__('Number Post',$this->parameter['name_option']),
                                                                            'type'  =>'select',
                                                                            'value' =>4,
                                                                            'items' =>array(2=>'2',3=>'3',4=>'4',5=>'5',6=>'6',7=>'7',8=>'8',9=>'9',10=>'10',11=>'11',12=>'12',13=>'13',14=>'14',15=>'15',16=>'16',17=>'17',18=>'18',19=>'19',20=>'20'),
                                                                            'id'    =>$this->parameter['name_option'].'_'.'display_post',
                                                                            'name'  =>$this->parameter['name_option'].'_'.'display_post',
                                                                            'class' =>'',
                                                                            'row'   =>array('a','b')),

                                                                    array(  'title' =>__('Post Type:',$this->parameter['name_option']), //title section
                                                                            'help'  =>__('Type related post where is displayed',$this->parameter['name_option']), //descripcion section
                                                                            'type'  =>'checkbox', 
                                                                            'value' =>array('post'),
                                                                            'value_check'=>array('post'),
                                                                            'display'   =>'types_post', 
                                                                            'id'    =>$this->parameter['name_option'].'_'.'post_type', //id
                                                                            'name'  =>$this->parameter['name_option'].'_'.'post_type', //name
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
                                                                            'type'  =>'upload',
                                                                            'value' =>$this->parameter['theme_imagen'].'/default.png',
                                                                            'id'    =>$this->parameter['name_option'].'_'.'default_image',
                                                                            'name'  =>$this->parameter['name_option'].'_'.'default_image',
                                                                            'class' =>'',
                                                                            'row'   =>array('a','b')),

                                                                    array(  'title' =>__('Thumbnail size',$this->parameter['name_option']),
                                                                            'help'  =>__('Image size, recommended "Medium"',$this->parameter['name_option']),
                                                                            'type'  =>'select',
                                                                            'value' =>'medium',
                                                                            'items' =>array('thumbnail'=>'Thumbnail','medium'=>'Medium'),
                                                                            'id'    =>$this->parameter['name_option'].'_'.'thumbnail_size',
                                                                            'name'  =>$this->parameter['name_option'].'_'.'thumbnail_size',
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
                                                                            'id'    =>$this->parameter['name_option'].'_'.'related_to',
                                                                            'name'  =>$this->parameter['name_option'].'_'.'related_to',
                                                                            'class' =>'',
                                                                            'row'   =>array('a','b')),


                                                                    array(  'title' =>__('Order by',$this->parameter['name_option']),
                                                                            'help'  =>__('Multiple criteria systems',$this->parameter['name_option']),
                                                                            'type'  =>'select',
                                                                            'value' =>'rand',
                                                                            'items' =>array('none'=>'None','ID'=>'ID','author'=>'Author','title'=>'Title','name'=>'Name','date'=>'Date','modified'=>'Modified','rand'=>'Rand','comment_count'=>'Comment Count'),
                                                                            'id'    =>$this->parameter['name_option'].'_'.'order_by',
                                                                            'name'  =>$this->parameter['name_option'].'_'.'order_by',
                                                                            'class' =>'',
                                                                            'row'   =>array('a','b')),


                                                                    array(  'title' =>__('Order',$this->parameter['name_option']),
                                                                            'help'  =>'',
                                                                            'type'  =>'select',
                                                                            'value' =>'DESC',
                                                                            'items' =>array('DESC'=>'Desc','ASC'=>'Asc'),
                                                                            'id'    =>$this->parameter['name_option'].'_'.'order',
                                                                            'name'  =>$this->parameter['name_option'].'_'.'order',
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
                                                                            'id'    =>$this->parameter['name_option'].'_'.'height_image',
                                                                            'name'  =>$this->parameter['name_option'].'_'.'height_image',
                                                                            'class' =>'',
                                                                            'row'   =>array('a','b')),


                                                                    array(  'title' =>__('Font size',$this->parameter['name_option']),
                                                                            'help'  =>__('Font size of title related',$this->parameter['name_option']),
                                                                            'type'  =>'select',
                                                                            'value' =>13,
                                                                            'items' =>array(12=>'12',13=>'13',14=>'14',15=>'15',16=>'16',17=>'17',18=>'18',19=>'19',20=>'20'),
                                                                            'id'    =>$this->parameter['name_option'].'_'.'font_size',
                                                                            'name'  =>$this->parameter['name_option'].'_'.'font_size',
                                                                            'class' =>'',
                                                                            'row'   =>array('a','b')),

                                                                    array(  'title' =>__('Title length',$this->parameter['name_option']),
                                                                            'help'  =>__('Number of characters to be shown in the title',$this->parameter['name_option']),
                                                                            'type'  =>'text',
                                                                            'value' =>'50',
                                                                            'id'    =>$this->parameter['name_option'].'_'.'text_length',
                                                                            'name'  =>$this->parameter['name_option'].'_'.'text_length',
                                                                            'class' =>'',
                                                                            'row'   =>array('a','b')),

                                                                    array(  'title' =>__('Title Bold:',$this->parameter['name_option']), //title section
                                                                            'help'  =>'Title font weight',
                                                                            'type'  =>'checkbox', //type input configuration
                                                                            'value' =>'0', //value
                                                                            'value_check'=>1,
                                                                            'id'    =>$this->parameter['name_option'].'_'.'title_bold', //id
                                                                            'name'  =>$this->parameter['name_option'].'_'.'title_bold', //name
                                                                            'class' =>'', //class
                                                                            'row'   =>array('a','b')),

                                                                    array(  'title' =>__('Text length',$this->parameter['name_option']),
                                                                            'help'  =>__('Number of text lettering post',$this->parameter['name_option']),
                                                                            'type'  =>'text',
                                                                            'value' =>'0',
                                                                            'id'    =>$this->parameter['name_option'].'_'.'text2_length',
                                                                            'name'  =>$this->parameter['name_option'].'_'.'text2_length',
                                                                            'class' =>'',
                                                                            'row'   =>array('a','b')),


                                                                    array(  'title' =>__('Background Color',$this->parameter['name_option']),
                                                                            'help'  =>'', 
                                                                            'type'  =>'color', 
                                                                            'value' =>'#FFF', // default
                                                                            'id'    =>$this->parameter['name_option'].'_'.'bg_color',
                                                                            'name'  =>$this->parameter['name_option'].'_'.'bg_color', 
                                                                            'class' =>'', 
                                                                            'row'   =>array('a','b')),

                                                                    array(  'title' =>__('Hover Background Color',$this->parameter['name_option']),
                                                                            'help'  =>'', 
                                                                            'type'  =>'color', 
                                                                            'value' =>'#FFFFE6', // default
                                                                            'id'    =>$this->parameter['name_option'].'_'.'bg_color_hover',
                                                                            'name'  =>$this->parameter['name_option'].'_'.'bg_color_hover', 
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

                                                                            'id'    =>$this->parameter['name_option'].'_'.'style',
                                                                            'name'  =>$this->parameter['name_option'].'_'.'style',
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
                                                                            'help'  =>'Or use <code>&lt;?php if ( function_exists( "get_yuzo_related_posts" ) ) { get_yuzo_related_posts(); } ?&gt;</code> in the Loop', //descripcion section
                                                                            'type'  =>'checkbox', //type input configuration
                                                                            'value' =>'1', //value
                                                                            'value_check'=>1,
                                                                            'id'    =>$this->parameter['name_option'].'_'.'automatically_append', //id
                                                                            'name'  =>$this->parameter['name_option'].'_'.'automatically_append', //name
                                                                            'class' =>'', //class
                                                                            'row'   =>array('a','b')),

                                                                    
                                                                    array(  'title' =>__('Show ONLY Home:',$this->parameter['name_option']), //title section
                                                                            'help'  =>'This option allows only appears on the home page related, will not be displayed anywhere else.',
                                                                            'type'  =>'checkbox', 
                                                                            'value' =>'0', // default
                                                                            'value_check'=>1, // value data
                                                                            'id'    =>$this->parameter['name_option'].'_'.'show_only_home',  
                                                                            'name'  =>$this->parameter['name_option'].'_'.'show_only_home',  
                                                                            'class' =>'', 
                                                                            'row'   =>array('a','b')),


                                                                    array(  'title' =>__('Categories on which related thumbnails will appear:',$this->parameter['name_option']), //title section
                                                                            'help'  =>'',

                                                                            'type'  =>'component_list_categories',
                                                                            'text_first_select' => __('All',$this->parameter['name_option']),

                                                                            'value' =>array('-1'),
                                                                            'value_check'=>0,
                                                                            'id'    =>$this->parameter['name_option'].'_'.'categories', //id
                                                                            'name'  =>$this->parameter['name_option'].'_'.'categories', //name
                                                                            'class' =>'',
                                                                            'row'   =>array('a','b')),

                                                                    
                                                                    array(  'title' =>__('Exclude category:',$this->parameter['name_option']), //title section
                                                                            'help'  =>'Select the category that does not show in the related.',

                                                                            'type'  =>'component_list_categories',
                                                                            'text_first_select' => __('None',$this->parameter['name_option']),

                                                                            'value' =>array('-1'),
                                                                            'value_check'=>0,
                                                                            'id'    =>$this->parameter['name_option'].'_'.'exclude_category', //id
                                                                            'name'  =>$this->parameter['name_option'].'_'.'exclude_category', //name
                                                                            'class' =>'',
                                                                            'row'   =>array('a','b')),



                                                                    array(  'title' =>__('If there is no related post, display random post?',$this->parameter['name_option']), //title section
                                                                            'help'  =>'only if use <code>&lt;?php if ( function_exists( "get_yuzo_related_posts" ) ) { get_yuzo_related_posts(); } ?&gt;</code> in the Loop', //descripcion section
                                                                            'type'  =>'checkbox', 
                                                                            'value' =>'1',
                                                                            'value_check'=>'1',
                                                                            'id'    =>$this->parameter['name_option'].'_'.'display_random',
                                                                            'name'  =>$this->parameter['name_option'].'_'.'display_random',
                                                                            'class' =>'',
                                                                            'row'   =>array('a','b')),

 
                                                            )
                                        ),
                'd'=>array(                'title'      => __('Count',$this->parameter['name_option']), 
                                           'title_large'=> __('',$this->parameter['name_option']), 
                                           'description'=> '',  
                                           'icon'       => '',
                                           'tab'        => 'tab03',

                                            'options'    => array( 


                                                                    array(  'title' =>__('Meta view',$this->parameter['name_option']),
                                                                            'help'  =>__('You can use the meta "Yuzo Views" (key: yuzo_views) or other meta you use to visit the counter.',$this->parameter['name_option']),
                                                                            'type'  =>'select',
                                                                            'value' =>'yuzo-views',
                                                                            'items' =>array('yuzo-views'=>'Yuzo views','other'=>'Other Meta'),
                                                                            'id'    =>$this->parameter['name_option'].'_'.'meta_views',
                                                                            'name'  =>$this->parameter['name_option'].'_'.'meta_views',
                                                                            'class' =>'',
                                                                            'row'   =>array('a','b')),


                                                                    array(  'title' =>__('Use another Meta visit counter',$this->parameter['name_option']),
                                                                            'help'  =>__("Enter the Meta (key) you're using the hit counter for your post, if you do not know anything about this best selected above 'Yuzo views'",$this->parameter['name_option']),
                                                                            'type'  =>'text',
                                                                            'value' =>'',
                                                                            'id'    =>$this->parameter['name_option'].'_'.'meta_views_custom',
                                                                            'name'  =>$this->parameter['name_option'].'_'.'meta_views_custom',
                                                                            'class' =>'class_yuzo_meta_custom',
                                                                            'row'   =>array('a','b')),
 
                                                            )
                                        ),
                'e'=>array(                'title'      => __('Show visits in related post',$this->parameter['name_option']), 
                                           'title_large'=> __('',$this->parameter['name_option']), 
                                           'description'=> '',  
                                           'icon'       => '',
                                           'tab'        => 'tab03',

                                            'options'    => array( 


                                                                    array(  'title' =>__('Show',$this->parameter['name_option']),
                                                                            'help'  =>__('Show related posts.',$this->parameter['name_option']),
                                                                            'type'  =>'checkbox', 
                                                                            'value' =>'0',
                                                                            'value_check'=>'1',
                                                                            'id'    =>$this->parameter['name_option'].'_'.'show_in_related_post',
                                                                            'name'  =>$this->parameter['name_option'].'_'.'show_in_related_post',
                                                                            'class' =>'',
                                                                            'row'   =>array('a','b')),


                                                                    array(  'title' =>__('Position',$this->parameter['name_option']),
                                                                            'help'  =>__('Choose where you want to display the counter.',$this->parameter['name_option']),
                                                                            'type'  =>'select',
                                                                            'value' =>'show-views-bottom',
                                                                            'items' =>array('show-views-top'=>'Before title','show-views-bottom'=>'After title'),
                                                                            'id'    =>$this->parameter['name_option'].'_'.'show_in_related_post_position',
                                                                            'name'  =>$this->parameter['name_option'].'_'.'show_in_related_post_position',
                                                                            'class' =>'',
                                                                            'row'   =>array('a','b')),

                                                                    
                                                                    array(  'title' =>__('Text views',$this->parameter['name_option']),
                                                                            'help'  =>__('Set the text to be displayed to identify visits, if you leave it empty display an icon of an eye.',$this->parameter['name_option']),
                                                                            'type'  =>'text',
                                                                            'value' =>'',
                                                                            'id'    =>$this->parameter['name_option'].'_'.'show_in_related_post_text',
                                                                            'name'  =>$this->parameter['name_option'].'_'.'show_in_related_post_text',
                                                                            'class' =>'',
                                                                            'row'   =>array('a','b')),
 
                                                            )
                                        ),
                'f'=>array(                'title'      => __('Dashboard',$this->parameter['name_option']), 
                                           'title_large'=> __('',$this->parameter['name_option']), 
                                           'description'=> '',  
                                           'icon'       => '',
                                           'tab'        => 'tab03',

                                            'options'    => array( 


                                                                    array(  'title' =>__('View visits in administration',$this->parameter['name_option']),
                                                                            'help'  =>__('Show a column in the Post Manager where it shows the number of visits per Post.',$this->parameter['name_option']),
                                                                            'type'  =>'checkbox', 
                                                                            'value' =>'1',
                                                                            'value_check'=>'1',
                                                                            'id'    =>$this->parameter['name_option'].'_'.'show_columns_dashboard',
                                                                            'name'  =>$this->parameter['name_option'].'_'.'show_columns_dashboard',
                                                                            'class' =>'',
                                                                            'row'   =>array('a','b')),
 
                                                            )
                                        ),
                'g'=>array(                'title'      => __('Template',$this->parameter['name_option']), 
                                           'title_large'=> __('',$this->parameter['name_option']), 
                                           'description'=> '',  
                                           'icon'       => '',
                                           'tab'        => 'tab03',

                                            'options'    => array( 


                                                                    array(  'title' =>__('',$this->parameter['name_option']),
                                                                            'help'  =>__('',$this->parameter['name_option']),
                                                                            'type'  =>'html', 
                                                                            'html1' =>'',
                                                                            'html2' =>'You can put the <code>&lt;?php if ( function_exists( "get_Yuzo_Views" ) ) { echo get_Yuzo_Views(); } ?&gt;</code>
                                                                                      function to get the total view of your post, that you can put in your single.php file anywhere you 
                                                                                      want and with the personalization you want since this function will get the number of visits this Post. <br />
                                                                                      <strong style="font-weight:bold;">Possibly the best WordPress Related Post ;)</strong>',
                                                                            'id'    =>$this->parameter['name_option'].'_'.'yuzo_get_views_html',
                                                                            'name'  =>$this->parameter['name_option'].'_'.'yuzo_get_views_html',
                                                                            'class' =>'yuzo_message_html',
                                                                            'row'   =>array('a','c')),
 
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