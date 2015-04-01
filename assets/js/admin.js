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


  $("#yuzo_related_post_related_to").on('change',function(){

    if( $(this).val() == '5' ){

      $(".class_order_by").css("display","none");
      $(".class_order").css("display","none");
      $(".class_order_by_taxonomias").css("display","block");
      

    } else {

      $(".class_order_by").css("display","block");
      $(".class_order").css("display","block");
      $(".class_order_by_taxonomias").css("display","none");

    }

  });


 
	$('.yuzo_style_chosse #yuzo_related_post_style_img_2').on("click", function(event){
    $("#yuzo_related_post_height_image").val(85);
    $("#yuzo_related_post_font_size").val(14);
    $("#yuzo_related_post_text2_length").val(150);
  });

  $('.yuzo_style_chosse #yuzo_related_post_style_img_1').on("click", function(event){
    $("#yuzo_related_post_height_image").val(145);
    $("#yuzo_related_post_font_size").val(13);
    $("#yuzo_related_post_text2_length").val(0);
  });

  if( $("#yuzo_related_post_meta_views").val() == 'other' ){
    $(".class_yuzo_meta_custom").css("display","block");
    $(".class_yuzo_meta_custom").css("background","rgb(249, 249, 249)");
  }



  if( $("#yuzo_related_post_related_to").val() == 5 ){

    $(".class_order_by").css("display","none");
    $(".class_order").css("display","none");
    $(".class_order_by_taxonomias").css("display","block");
    

  } else {

    $(".class_order_by").css("display","block");
    $(".class_order").css("display","block");
    $(".class_order_by_taxonomias").css("display","none");

  }


});

function delete_meta_yuzo(){
 
}