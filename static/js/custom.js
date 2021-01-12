;(function($){
    $(document).ready(function(){
     $(".color-variable-item-z-sherwin-color").append($("#color-picker"));
     $(".color-variable-item-z-sherwin-color .variable-item-span-color").css("background-image", 'url('+colorpicker.siteurl+'/static/media/colorpicker.6cbcc0e9.png)');

 
     $(".color-variable-item").on("click", function(e){
         
         if($(e.target).hasClass("color-variable-item-z-sherwin-color") ){
             $(".hoodsly-colorpicker-main").toggle();
             $(".variations").toggleClass("color-on");
         }else if($(e.target).hasClass("single_color") ){

            var hbgColor = $(e.target).css("background-color"); 

            $(".color-variable-item-z-sherwin-color .variable-item-span-color").css({ 'background-image' : '', 'opacity' : '', "background-color": hbgColor });
    
         }else if($(e.target).hasClass("search_input")){
            e.stopPropagation();
 
         }else{
             $(".hoodsly-colorpicker-main").hide();
             $(".variations").removeClass("color-on"); 
             $(".color-variable-item-z-sherwin-color .variable-item-span-color").css("background-image", 'url('+colorpicker.siteurl+'/static/media/colorpicker.6cbcc0e9.png)');
             $(".hoodsly-colorpicker-main input").removeAttr("value");
         }  
         
     });

});

 })(jQuery);
 





