jQuery(document).ready( function() {
 

	jQuery('#tabs')
        .tabs()
        .addClass('ui-tabs-vertical ui-helper-clearfix');




    //Custom
    // =save theme options
    jQuery(".btn_save").on("click",function(){
        document.frmsave.submit();
    });

    // =reset options
    jQuery(".btn_reset").on("click",function(){

    	if( confirm( jQuery(this).attr("data-me") ) )
        	document.frmreset.submit();
    });
    

    var formfield;
    // upload file >3.5
    jQuery('.upload_image_button').on("click",function( event ){  
 
		 	event.preventDefault();
 			formfield = jQuery(this).prev().attr('id');
 			var button_this = jQuery(this);

		    var custom_uploader = wp.media({
		        title: jQuery(button_this).attr('data-title'),
		        button: {
		            text: jQuery(button_this).attr('data-button-set')
		        },
		        multiple: false  // Set this to true to allow multiple files to be selected
		    })
		    .on('select', function() {
		        var attachment = custom_uploader.state().get('selection').first().toJSON();
		        /*$('.custom_media_image').attr('src', attachment.url);
		        $('.custom_media_id').val(attachment.id);*/
		        jQuery("#"+formfield).val(attachment.url);

		        jQuery(button_this).parent().find(".preview").html("<img src='"+attachment.url+"' /><span class='admin_delete_image_upload'></span>");
		    })
		    .open();

	});

    // end upload >3.5


	// upload file old
	var button_this;
	jQuery('.upload_image_button_old').on("click",function( event ){ 
		 button_this = jQuery(this); 
		 formfield = jQuery(this).prev().attr('id');
		 tb_show('', 'media-upload.php?type=image&amp;TB_iframe=true');
		 return false;
	});
	window.send_to_editor = function(html) {
		 imgurl = jQuery('img',html).attr('src');
		 jQuery("#"+formfield).val(imgurl);
		 jQuery(button_this).parent().find(".preview").html("<img src='"+imgurl+"' /><span class='admin_delete_image_upload'></span>");
		 tb_remove();
	}
	// end upload file old


	// delete upload clear input
	jQuery(".admin_delete_image_upload").live("click",function(){
	    jQuery(this).parent().parent().find('.theme_src_upload').val('');
	    jQuery(this).prev().fadeOut(300);
	    jQuery(this).fadeOut(300);
	});



	// select radio image (active)
	jQuery(".radio_image_selection").on("click",function( event){

		event.preventDefault();
		var class_ref;
		var img_obj;


		class_ref = jQuery(this).attr("data-id");
		img_obj = jQuery(this);

		jQuery("."+class_ref).each(function(){
			jQuery(this).removeClass("active");
		});

		jQuery(img_obj).addClass("active");
		jQuery(img_obj).next().attr("checked","checked");

	})

	// set input an colorpicker
	jQuery('.theme_color_picker').wpColorPicker();


	// if exists div class 'mesaggebox' delete element whth effect
	if ( jQuery('.ilentheme-options div.messagebox').length ) {

		setTimeout(function() {
		    jQuery('.ilentheme-options div.messagebox').slideUp(500, function(){
			    jQuery(this).remove();
			});
		 }, 2000);

	}

});