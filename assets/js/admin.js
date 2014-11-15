jQuery(document).ready(function( $ ){

	$(".class_yuzo_meta_custom").css("display","none");
	$(".class_yuzo_meta_custom").css("background","#F9F9F9");
	

	$("#yuzo_related_post_meta_views").on('change',function(){

		if( $(this).val() == 'other' ){

			$(".class_yuzo_meta_custom").css("display","block");

		}else{

			$(".class_yuzo_meta_custom").css("display","none");

		}

	});

});