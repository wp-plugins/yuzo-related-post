<?php 
/**
 * iLenFramework 1.3
 * @package ilentheme
 */

global $IF_CONFIG;
//var_dump( $IF_CONFIG );

// COMPONENTS _______________________________________________________________________
if( in_array( 'list_categories', $IF_CONFIG->components )  ){
	require_once "assets/components/list_categories.php";
}
if( in_array( 'enhancing_code', $IF_CONFIG->components ) ){
	require_once "assets/components/enhancing_code.php";	
}
// __________________________________________________________________________________





// REQUIRED FILES TO RUN


if ( !class_exists('ilen_framework_1_3') ) {


class ilen_framework_1_3 {

		var $options		   	= "";
		var $parameter 			= "";
		var $save_status		= null;
		var $IF_CONFIG			= null;

	



	function __construct(){

		if( ! is_admin() ){ // only front-end

			require_once 'assets/lib/utils.php';
			return;

		}elseif( is_admin()  ){ // only admin

			// set default if not exists
			self::_ini_();



			// add menu options
			self::iLenFramework_add_menu();
				



			if( is_admin()  && isset($_GET["page"]) && $_GET["page"] == $this->parameter['id_menu'] ){ // validate if admin page is the option

				// add scripts & styles
				add_action('admin_enqueue_scripts', array( &$this,'ilenframework_add_scripts_admin') );

			}

		}


	}





	// =Definitions Fields
	function theme_definitions(){

 
		return $this->options;
		
	}	


	// =Add Menu
	function iLenFramework_add_menu(){

		if( $this->parameter['type'] == "theme" ){

			if( $this->parameter['method'] == "free"  ){

				add_action('admin_menu', array( &$this,'menu_free') );		

			}elseif( $this->parameter['method'] == "buy" ){

				add_action('admin_menu', array( &$this,'menu_pay') );		

			}

		}elseif( $this->parameter['type'] == "plugin"  ){

			if( $this->parameter['method'] == "free"  ){

				add_action('admin_menu', array( &$this,'menu_free') );		

			}elseif( $this->parameter['method'] == "buy" ){

				add_action('admin_menu', array( &$this,'menu_pay') );		

			}

		}
		
	}







	// =INIT theme
	function _ini_(){
		
		global $IF_CONFIG;
		$this->IF_CONFIG		= $IF_CONFIG;
		$this->parameter 		= $this->IF_CONFIG->parameter;

		if( isset($_GET["page"]) == $this->parameter['id_menu'] ){ // validate if admin page is the option

			// get Components
			//self::_getComponents_();

			// set varaible configuration
			$this->options = $this->IF_CONFIG->options;

			// if save update options
			self::save_options();

			// if not exists options them create
			$default = self::get_default_options();

			$name_option =  $this->parameter['name_option']."_options";
			
			if( ! $n = get_option( $name_option ) ){

				update_option( $name_option, $default);

			}

		}


	}




	// =DEFAULTS OPTIONS
	function get_default_options(){
		
		$defaults = array();

		$Myoptions = self::theme_definitions();
		foreach ($Myoptions as $key2 => $value2) {
			if(  $key2 != 'last_update' ){
				foreach ($value2['options'] as $key => $value) {

					$defaults[$value['name']] = $value['value'];

				}
			}
		}

		return $defaults;
		
	}





	// =MENU--------------------------------------------
	function menu_free() {

		if( $this->parameter['type'] == "theme" ){
			add_theme_page($this->parameter['name'], $this->parameter['name_long'], 'edit_theme_options', $this->parameter['id_menu'] , array( &$this,'ilentheme_full') );
		}elseif( $this->parameter['type']  == "plugin" ){
			add_options_page( $this->parameter['name'], $this->parameter['name_long'], 'manage_options', $this->parameter['id_menu'], array( &$this,'ilentheme_full') );
		}
	}

	function menu_pay() {

		add_theme_page($this->parameter['name'], $this->parameter['name_long'], 'manage_options',  $this->parameter['id_menu'], array( &$this,'ilentheme_full') );

	}






	function ilentheme_full(){
		//code 


		self::ShowHTML();
		
 
	}

 



	// =Interface Create for Theme---------------------------------------------
	function ilentheme_options_wrap_for_theme(){ ?>
		 
		<div class='ilentheme-options'>
			<form action="" method="POST" name="frmsave" id="frmsave">
			<header>
				<div class="top-left logo">
					<?php 
						if( !$this->parameter["logo"] )
							echo "<h1><a href='#'>{$this->parameter["name"]}</a> <span>".$this->parameter['slogan']."</span></h1>";
						else
							echo "<a href='#'><img src='{$this->parameter["logo"]}' /></a>";
					?>
					<!-- <span><?php //echo $this->parameter["slogan"] ?></span> -->
				</div>
				<div class="top-right">
					<a href="#" class="btn btn_save super"  ><?php _e('Save options',$this->parameter['name_option']) ?></a>
				</div>
			</header>

			<div id="tabs">
				<ul>

					<?php $Myoptions = self::theme_definitions();

						foreach ($Myoptions as $key => $value) { ?>
							<?php if($key != 'last_update'){ ?>
									<li>
						            	<a href="#<?php echo $key; ?>">
						            		<?php 
						            			if( $value['icon'] )
						            				echo '<i class="'.$value['icon'].'"></i>';
						            		?>
						            		<?php echo $value['title']; ?>
						            	</a>
						            </li>
				            <?php } ?>

						<?php  }

					?>

				</ul>

				<?php 
					// set mesagge status
					if( $this->save_status===true )
						$class_status="ok";
					elseif( $this->save_status===false )
						$class_status="error";
				?>
				<?php if( $this->save_status ){ ?><div class="messagebox <?php echo $class_status; ?>"><i class="fa fa-check"></i> <?php _e('Update successfully',$this->parameter['name_option']) ?></div><?php } ?>


				<?php 
					foreach ($Myoptions as $key => $value) { ?>
							<?php if($key != 'last_update'){ ?>
								<div id="<?php echo $key; ?>" class="content-tab">
					            	<h2>
					            		<?php 
					            			if( $value['icon'] )
					            				echo '<i class="'.$value['icon'].'"></i>';
					            		?>
					            		<?php echo $value['title']; ?>
					            	</h2>
					            	<?php if( $value['description'] ){ ?>
					            		<p class="description"><?php echo $value['description']; ?></p>
					            	<?php } ?>
					            	
					            	<?php self::build_fields( $value['options'] ) ?>
					            </div>
					        <?php } ?>

					<?php  }
				?>

			</div>
			<footer>
				<a href="#" class="btn btn_reset super" data-me="<?php _e('Want to update all the default values​​ &#63;',$this->parameter['name_option']) ?>"><?php _e('Reset',$this->parameter['name_option']) ?></a>
				<div class="top-right">
					<a href="#" class="btn btn_save super"  ><?php _e('Save options',$this->parameter['name_option']) ?></a>
				</div>
			</footer>

			<input type="hidden" name='save_options' value='1' />
			<input type="hidden" name='name_options' value='<?php echo $this->parameter["name_option"]; ?>' />
			</form>
			<form action="" method="POST" name="frmreset" id="frmreset">
				<input type="hidden" name='reset_options' value='1' />
				<input type="hidden" name='name_options' value='<?php echo $this->parameter['name_option']; ?>' />
			</form>
		</div>	
 

	<?php }




	// =Interface Create for plugin---------------------------------------------
	function ilentheme_options_wrap_for_plugin(){ ?>

		<div class='ilenplugin-options'>

			<form action="" method="POST" name="frmsave" id="frmsave">
 
				<div id="poststuff" class="metabox-holder has-right-sidebar">

					<div id="post-body-content" class="has-sidebar-content">
					<header>
						<h2>
							<?php echo $this->parameter['logo']." ".$this->parameter['name_long']; ?>
							<span class='ilen-version'><?php echo $this->parameter['version'] ?></span>
						</h2>
						<a href="<?php echo $this->parameter['wp_review'] ?>" class="leave-a-review ibtn btnred right"><span><i class="fa fa-star"></i></span>Leave a review</a>
						<a href="<?php echo $this->parameter['twitter'] ?>" class="tweet-about-it ibtn btnturke right"><span><i class="fa fa-twitter"></i></span>Write your experience</a>
					</header>
					<?php 
						// set mesagge status
						if( $this->save_status===true )
							echo '<div id="message" class="updated fade">'.__('Update successfully',$this->parameter['name_option']).'</div>';
						elseif( $this->save_status===false )
							echo '<div id="message" class="error">'.__('Failed to update',$this->parameter['name_option']).'</div>';
					?>
						<div class="meta-box-sortabless">
							<div class="has-sidebar sm-padded">


								<?php $Myoptions = self::theme_definitions();


									if( is_array( $Myoptions ) ){
										foreach ($Myoptions as $key => $value) { ?>
											<?php if($key != 'last_update'){  ?>

										            <div id="box_<?php echo $key; ?>" class="postbox">
														<h3 class="hndle">
															<span>
															<?php 
										            			if( $value['icon'] )
										            				echo '<i class="'.$value['icon'].'"></i>&nbsp;&nbsp;';
										            		?><?php echo $value['title']; ?>
										            		</span>
										            	</h3>
														<div class="inside">
															<p>
																<?php self::build_fields_p( $value['options'] ) ?>
															</p>
														</div>
													</div>

								            <?php } ?>

										<?php  }

									}

							?>

								

							</div>
						</div>
						<footer>
							<a href="#" class="ibtn btnblack left btn_save"><span><i class="fa fa-refresh"></i></span><?php _e('Save Changes',$this->parameter['name_option']) ?></a>
							<a href="#" class="ibtn btnred left btn_reset" data-me="<?php _e('Want to update all the default values​​ &#63;',$this->parameter['name_option']) ?>"><span><i class="fa fa-repeat"></i></span><?php _e('Reset',$this->parameter['name_option']) ?></a>
						</footer>
					</div>
				</div>
				<input type="hidden" name='save_options' value='1' />
				<input type="hidden" name='name_options' value='<?php echo $this->parameter["name_option"]; ?>' />
				</form>
				<form action="" method="POST" name="frmreset" id="frmreset">
					<input type="hidden" name='reset_options' value='1' />
					<input type="hidden" name='name_options' value='<?php echo $this->parameter['name_option']; ?>' />
				</form>
		</div>


	<?php 
	}





	// =BUILD Fields themes---------------------------------------------
	function build_fields( $fields = array() ){

			$options_theme = get_option( $this->parameter['name_option']."_options" );
 
			foreach ($fields as $key => $value) {

					if( in_array("b", $value['row']) ) { $side_two = "b"; }else{  $side_two ="c"; }

					switch ( $value['type'] ) {

						

						case "text": ?>

							<div class="row">
								<div class="a"><h3><?php echo $value['title']; ?></h3></div>
								<div class="<?php echo $side_two; ?>">
									<input type="text"  value="<?php echo esc_html($options_theme[ $value['name'] ]) ?>" name="<?php echo $value['id'] ?>" id="<?php echo $value['id'] ?>"  autocomplete="off"  />
									<div class="help"><?php echo $value['help']; ?></div>
								</div>
							</div>

						<?php break;

						case "checkbox": ?>

							<div class="row">
								<div class="a"><h3><?php echo $value['title']; ?></h3></div>
								<div class="<?php echo $side_two;  ?>">
									
									<input type="checkbox" <?php checked( $options_theme[ $value['name'] ], 1  ); ?> name="<?php echo $value['id'] ?>" id="<?php echo $value['id'] ?>" value="<?php echo $value['value_check'] ?>"  />
									<label for="<?php echo $value['id'] ?>"><span class="ui"></span></label>
									<div class="help"><?php echo $value['help']; ?></div>

								</div>
								
							</div>

						<?php break;


						case "upload": ?>

							<div class="row upload">
								<div class="a"><h3><?php echo $value['title']; ?></h3></div>
								<div class="<?php echo $side_two; ?>">
									<input id="<?php echo $value['id'] ?>" type="text" name="<?php echo $value['name'] ?>" value="<?php echo $options_theme[ $value['name'] ]; ?>" class="theme_src_upload"  />
									<input type="button" value="<?php _e('Upload Image',$this->parameter['name_option']) ?>" class="upload_image_button" data-title="<?php echo $value['title'] ?>" data-button-set="<?php _e('Select image',$this->parameter['name_option']) ?>" />
									<div class="preview">
										<?php  if( $options_theme[ $value['name'] ] ) : ?>
											<img src="<?php echo $options_theme[ $value['name'] ]; ?>" />
											<span class='admin_delete_image_upload'></span>
										<?php endif; ?>
									</div>
									<div class="help"><?php echo $value['help']; ?></div>
								</div>
							</div>

						<?php break;


						case "upload_old": ?>

							<div class="row upload">
								<div class="a"><h3><?php echo $value['title']; ?></h3></div>
								<div class="<?php echo $side_two; ?>">
									<input id="<?php echo $value['id'] ?>" type="text" name="<?php echo $value['name'] ?>" value="<?php echo $options_theme[ $value['name'] ]; ?>" class="theme_src_upload" />
									<input type="button" value="<?php _e('Upload Image',$this->parameter['name_option']) ?>" class="upload_image_button_old" />
									<div class="preview">
										<?php  if( $options_theme[ $value['name'] ] ) : ?>
											<img src="<?php echo $options_theme[ $value['name'] ]; ?>" />
											<span class='admin_delete_image_upload'></span>
										<?php endif; ?>
									</div>
									<div class="help"><?php echo $value['help']; ?></div>
								</div>
							</div>

						<?php break;


						case "select": ?>

							<div class="row">
								<div class="a"><h3><?php echo $value['title']; ?></h3></div>
								<div class="<?php echo $side_two; ?>">

									<select name="<?php echo $value['name'] ?>" id="<?php echo $value['id'] ?>">
										<?php 
											if( is_array( $value['items'] ) ){
												foreach ( $value['items'] as $item_key => $item_value ): ?>
												
													<option value="<?php echo $item_key ?>" <?php selected( $options_theme[ $value['name'] ] ,   $item_key ); ?>><?php echo $item_value ?></option>	

												<?php
												endforeach;
											}
										?>
									</select>
									<div class="help"><?php echo $value['help']; ?></div>
								</div>
							</div>

						<?php break;


						case "radio_image": ?>

							<div class="row radio_image">
								<div class="a"><h3><?php echo $value['title']; ?></h3></div>
								<div class="<?php echo $side_two; ?>">

									<?php 
									if( is_array( $value['items'] ) ){
										foreach ($value['items'] as $item_key => $item_value): ?>
											
											<label for="<?php echo $value['id']."_".$item_value['value']; ?>">
												<img name="<?php echo $value['name']."_img"; ?>" src="<?php echo $item_value['image'] ?>" class="radio_image_selection <?php echo $value['name']; ?> <?php echo ($options_theme[ $value['name'] ] == $item_value['value']?"active":"") ?>" data-id="<?php echo $value['name']; ?>" title="<?php echo $item_value['text']; ?>" />
												<input  <?php checked( $options_theme[ $value['name'] ], $item_value['value'] ); ?> id="<?php echo $value['id']."_".$item_value['value']; ?>" type="radio" name="<?php echo $value['name']; ?>" value="<?php echo $item_value['value'] ?>" />
											</label>

									<?php endforeach;
									} ?>
									<div class="help"><?php echo $value['help']; ?></div>
								</div>
							</div>

						<?php break;



						case "divide": ?>
								<div class="divide">
									<?php 
				            			if( $value['icon'] )
				            				echo '<i class="'.$value['icon'].'"></i>';
				            		?>
									<?php echo $value['title'] ?>
								</div>
						<?php break;



						case "color": ?>

							<div class="row">
								<div class="a"><h3><?php echo $value['title']; ?></h3></div>
								<div class="<?php echo $side_two; ?>">
									<input type="text" class="theme_color_picker" value="<?php echo $options_theme[ $value['name'] ] ?>" name="<?php echo $value['name']; ?>" id="<?php echo $value['id'] ?>" data-default-color="<?php echo $value['value']; ?>" />
									<div class="help"><?php echo $value['help']; ?></div>
								</div>
							</div>

						<?php break;



						case "textarea": ?>

							<div class="row">
								<div class="a"><h3><?php echo $value['title']; ?></h3></div>
								<div class="<?php echo $side_two; ?>">
									<textarea name="<?php echo $value['name'] ?>" id="<?php echo $value['id'] ?>" style="width:100%;height:150px;"><?php echo $options_theme[ $value['name'] ] ?></textarea>
									<div class="help"><?php echo $value['help']; ?></div>
								</div>

							</div>

						<?php break;

					}

			}

	}



	// =BUILD Fields plugin---------------------------------------------
	function build_fields_p( $fields = array() ){

			$options_theme = get_option( $this->parameter['name_option']."_options" );
 
			foreach ($fields as $key => $value) {

					if( in_array("b", $value['row']) ) { $side_two = "b"; }else{  $side_two ="c"; }

					switch ( $value['type'] ) {

						

						case "text": ?>

							<div class="row">
								<div class="a"><strong><?php echo $value['title']; ?></strong><div class="help"><?php echo $value['help']; ?></div></div>
								<div class="<?php echo $side_two; ?>">
									<input type="text"  value="<?php echo $options_theme[ $value['name'] ] ?>" name="<?php echo $value['name'] ?>" id="<?php echo $value['id'] ?>"  autocomplete="off"  />
								</div>
							</div>

						<?php break;

						case "checkbox": ?>

							<div class="row"> 
								<div class="a"><strong><?php echo $value['title']; ?></strong><div class="help"><?php echo $value['help']; ?></div></div>
								<div class="<?php echo $side_two; ?>">

									
									<?php if( isset($value['display']) && $value['display'] == 'list' ){  ?>
										<?php 
											if( !is_array(  $options_theme[ $value['name'] ] ) ){
												$options_theme[ $value['name'] ] = array();
											}

											foreach ($value['items'] as $key2 => $value2): ?>

											<div class="row_checkbox_list">
												<input  type="checkbox" <?php if( in_array( $value2['value']  , $options_theme[ $value['name'] ] ) ){ echo " checked='checked' ";} ?> name="<?php echo $value2['id'] ?>[]" id="<?php echo $value2['id']."_".$value2['value'] ?>" value="<?php echo $value2['value'] ?>"  />	&nbsp;<?php echo  $value2['text']; ?> 
												<label for="<?php echo $value2['id'] ?>"><span class="ui"></span></label>
												<div class="help"><?php echo $value2['help']; ?></div>
											</div>

										<?php endforeach; ?>
										
									<?php } else { ?>

										<input  type="checkbox" <?php checked( $options_theme[ $value['name'] ], 1  ); ?> name="<?php echo $value['name'] ?>" id="<?php echo $value['id'] ?>" value="<?php echo $value['value_check'] ?>"  />
										<label for="<?php echo $value['id'] ?>"><span class="ui"></span></label>
									<?php } ?>
									
								</div>
								
							</div>

						<?php break;



						case "component_list_categories": ?>

							<div class="row"> 
								<div class="a"><strong><?php echo $value['title']; ?></strong><div class="help"><?php echo $value['help']; ?></div></div>
								<div class="<?php echo $side_two; ?> component_list_categories">

									<?php 
										global $IF_COMPONENT;

										$IF_COMPONENT['component_list_category']->display( $value['id'], $options_theme[ $value['name'] ] );

									?>
									
								</div>
								
							</div>

						<?php break;



						case "component_enhancing_code": ?>

							<div class="row"> 
								<div class="a"><strong><?php echo $value['title']; ?></strong><div class="help"><?php echo $value['help']; ?></div></div>
								<div class="<?php echo $side_two; ?> component_enhancing_css">

									<?php 
										global $IF_COMPONENT;

										$IF_COMPONENT['component_enhancing_code']->display( $value['id'], $options_theme[ $value['name'] ] );

									?>
									
								</div>
								
							</div>

						<?php break;


						case "upload": ?>

							<div class="row upload">
								<div class="a"><strong><?php echo $value['title']; ?></strong><div class="help"><?php echo $value['help']; ?></div></div>
								<div class="<?php echo $side_two; ?>">
									<input id="<?php echo $value['id'] ?>" type="text" name="<?php echo $value['name'] ?>" value="<?php echo $options_theme[ $value['name'] ]; ?>" class="theme_src_upload"  />
									<input type="button" value="<?php _e('Upload Image',$this->parameter['name_option']) ?>" class="upload_image_button" data-title="<?php echo $value['title'] ?>" data-button-set="<?php _e('Select image',$this->parameter['name_option']) ?>" />
									<div class="preview">
										<?php  if( $options_theme[ $value['name'] ] ) : ?>
											<img src="<?php echo $options_theme[ $value['name'] ]; ?>" />
											<span class='admin_delete_image_upload'></span>
										<?php endif; ?>
									</div>
								</div>
							</div>

						<?php break;


						case "upload_old": ?>

							<div class="row upload">
								<div class="a"><strong><?php echo $value['title']; ?></strong><div class="help"><?php echo $value['help']; ?></div></div>
								<div class="<?php echo $side_two; ?>">
									<input id="<?php echo $value['id'] ?>" type="text" name="<?php echo $value['name'] ?>" value="<?php echo $options_theme[ $value['name'] ]; ?>" class="theme_src_upload" />
									<input type="button" value="<?php _e('Upload Image',$this->parameter['name_option']) ?>" class="upload_image_button_old" />
									<div class="preview">
										<?php  if( $options_theme[ $value['name'] ] ) : ?>
											<img src="<?php echo $options_theme[ $value['name'] ]; ?>" />
											<span class='admin_delete_image_upload'></span>
										<?php endif; ?>
									</div>
								</div>
							</div>

						<?php break;


						case "select": ?>

							<div class="row">
								<div class="a"><strong><?php echo $value['title']; ?></strong><div class="help"><?php echo $value['help']; ?></div></div>
								<div class="<?php echo $side_two; ?>">

									<select name="<?php echo $value['name'] ?>" id="<?php echo $value['id'] ?>">
										<?php 
											if( is_array( $value['items'] ) ){
												foreach ( $value['items'] as $item_key => $item_value ): ?>
												
													<option value="<?php echo $item_key ?>" <?php selected( $options_theme[ $value['name'] ] ,   $item_key ); ?>><?php echo $item_value ?></option>	

												<?php
												endforeach;
											}
										?>
									</select>
								</div>
							</div>

						<?php break;


						case "radio_image": ?>
							<div class="row radio_image">
								<div class="a"><strong><?php echo $value['title']; ?></strong><div class="help"><?php echo $value['help']; ?></div></div>
								<div class="<?php echo $side_two; ?>">

									<?php 
									if( is_array( $value['items'] ) ){
										foreach ($value['items'] as $item_key => $item_value): ?>
											
											<label for="<?php echo $value['id']."_".$item_value['value']; ?>">
												<img name="<?php echo $value['name']."_img"; ?>" src="<?php echo $item_value['image'] ?>" class="radio_image_selection <?php echo $value['name']; ?> <?php echo ($options_theme[ $value['name'] ] == $item_value['value']?"active":"") ?>" data-id="<?php echo $value['name']; ?>" title="<?php echo $item_value['text']; ?>" />
												<input  <?php checked( $options_theme[ $value['name'] ], $item_value['value'] ); ?> id="<?php echo $value['id']."_".$item_value['value']; ?>" type="radio" name="<?php echo $value['name']; ?>" value="<?php echo $item_value['value'] ?>" />
											</label>

									<?php endforeach;
									} ?>
								</div>
							</div>

						<?php break;



						case "divide": ?>
								<div class="divide">
									<?php 
				            			if( $value['icon'] )
				            				echo '<i class="'.$value['icon'].'"></i>';
				            		?>
									<?php echo $value['title'] ?>
								</div>
						<?php break;



						case "color": ?>

							<div class="row">
								<div class="a"><strong><?php echo $value['title']; ?></strong><div class="help"><?php echo $value['help']; ?></div></div>
								<div class="<?php echo $side_two; ?>">
									<input type="text" class="theme_color_picker" value="<?php echo $options_theme[ $value['name'] ] ?>" name="<?php echo $value['name']; ?>" id="<?php echo $value['id'] ?>" data-default-color="<?php echo $value['value']; ?>" />
								</div>
							</div>

						<?php break;



						case "textarea": ?>

							<div class="row">
								<div class="a"><strong><?php echo $value['title']; ?></strong><div class="help"><?php echo $value['help']; ?></div></div>
								<div class="<?php echo $side_two; ?>">
									<textarea name="<?php echo $value['name'] ?>" id="<?php echo $value['id'] ?>" style="width:100%;height:150px;"><?php echo $options_theme[ $value['name'] ] ?></textarea>
								</div>

							</div>

						<?php break;


						case "radio": ?>

							<div class="row radio">
								<div class="a"><strong><?php echo $value['title']; ?></strong><div class="help"><?php echo $value['help']; ?></div></div>
								<div class="<?php echo $side_two; ?>">
									<?php 
									if( is_array( $value['items'] ) ){
										foreach ($value['items'] as $item_key => $item_value): ?>
											<div class="row_radio">
												<label for="<?php echo $value['id']."_".$item_value['value']; ?>">
													<input  <?php checked( $options_theme[ $value['name'] ], $item_value['value'] ); ?> id="<?php echo $value['id']."_".$item_value['value']; ?>" type="radio" name="<?php echo $value['name']; ?>" value="<?php echo $item_value['value'] ?>" />
													<?php echo $item_value['text'] ?>
												</label>
												<span><?php echo $item_value['help'] ?></span>
											</div>

									<?php endforeach;
									} ?>
								</div>

							</div>

						<?php break;

					}

			}

	}

 


	// =OUTPUT HTML ---------------------------------------------

	function ShowHTML(){  
  		
  		
  		if( $this->parameter['type']  == "theme" ){
			self::ilentheme_options_wrap_for_theme(); 
		}elseif( $this->parameter['type'] == "plugin" ){
			self::ilentheme_options_wrap_for_plugin(); 
		}
  		
 
	}




	// =SAVE options---------------------------------------------
	function save_options(){

		//code save options the theme
		if( isset($_POST) && ( isset($_POST['save_options']) || isset($_POST['reset_options'] ) ) && $_POST["name_options"] == $this->parameter["name_option"] ){
 
			$Myoptions = self::theme_definitions();
			foreach ($Myoptions as $key2 => $value2) {
				if( $key2 != 'last_update' ){
					foreach ($value2['options'] as $key => $value) {
				 
						if( isset($_POST['save_options']) ){
 
							// save options check list
							if(  isset($value['display']) && ( $value['display'] == 'checkbox' || $value['display'] == 'list' ) ){
 

								$array_get_values_check = array();
								$array_set_values_check = array();
								foreach ( $value['items'] as $key2 => $value2 ) $array_get_values_check[] = $value2['value'];
 
								if ( is_array( $_POST[$value['name']] ) ) {

									foreach ( $_POST[$value['name']] as $key3 => $value3) {
										if( in_array( $value3 , $array_get_values_check ) ){

											$array_set_values_check[] = $value3;
										}

									}

								}
 
								// set values type check list
								$options_update[$value['name']] = $array_set_values_check;



							}elseif(  $value['type'] == 'component_list_categories' ){



								 $array_set_values_check = array();
								 if( isset($_POST[$value['id'] ]) &&  is_array( $_POST[$value['id'] ] ) ){

								 	if( in_array( '-1', $_POST[$value['id'] ] ) )
								 		$array_set_values_check[]="-1";
								 	else{

								 		$array_set_values_check = $_POST[$value['id'] ];

								 	}


								 }

								 if( ! $array_set_values_check ){
								 	$array_set_values_check = array("-1");
								 }

								 // set values type check list
								$options_update[$value['name']] = $array_set_values_check;

								

							}else{



								// set values normal
								$value_final = '';
								if( isset($_POST[$value['name']]) ){
									$value_final = (string)$_POST[$value['name']];
								}
								$options_update[$value['name']] = htmlentities(stripslashes( $value_final ));



							}


							// -->

							
						
						}elseif( $_POST['reset_options'] ){

							
							$options_update[$value['name']] =  $value['value'] ;

						}

					}
				}else{
					$options_update[$key2] = time();
				}
			}

			if( is_array($options_update) )
				if(update_option( $this->parameter['name_option']."_options" , $options_update))
					$this->save_status = true;
				else
					$this->save_status = false;
			else
				$this->save_status = false;

		}
	}





	// =SCRIPT & STYLES---------------------------------------------
	function ilenframework_add_scripts_admin(){

		// If is admin page (if front-end not load)
		if( is_admin() ){

			// Register styles
			wp_register_style( 'ilentheme-styles-admin', $this->parameter['url_framework'] ."/core.css" );
			// Enqueue styles
			wp_enqueue_style( 'ilentheme-styles-admin' );
			// Enqueue Script Core
			wp_enqueue_script('ilentheme-script-admin', $this->parameter['url_framework'] . '/core.js', array( 'jquery','jquery-ui-core','jquery-ui-tabs','wp-color-picker' ), '', true );
			
			if(  isset($_GET["page"]) && $_GET["page"] == $this->parameter['id_menu'] ){ // only load if page option or theme

				// Enqueue Scripts
				if(function_exists( 'wp_enqueue_media' )){
				    wp_enqueue_media();
				}else{
					wp_enqueue_script('media-upload'); // else put this
				    wp_enqueue_script('media-models');
				}

			    wp_enqueue_style('thickbox');
			    wp_enqueue_script('thickbox');
			    wp_enqueue_style( 'wp-color-picker' );

			    // google fonts
			    wp_register_style( 'fonts-google-if', 'http://fonts.googleapis.com/css?family=Open+Sans+Condensed:300italic,300,400,600,700|Roboto' );
			    wp_enqueue_style( 'fonts-google-if' );

				// theme
				if( $this->parameter['themeadmin'] ){
					wp_register_style( 'ilentheme-styles-admin-theme-'.$this->parameter['themeadmin'], $this->parameter['url_framework'] ."/assets/css/{$this->parameter['type']}-{$this->parameter['themeadmin']}.css" );
					wp_enqueue_style( 'ilentheme-styles-admin-theme-'.$this->parameter['themeadmin'] );
				}

			}
		}

	}



} // class
} // if


global $IF_CONFIG;
if( ! is_array($IF_CONFIG->components) ){
	$IF_CONFIG->components = array();
}

global $IF;
$IF = null;
$IF = new ilen_framework_1_3;
?>