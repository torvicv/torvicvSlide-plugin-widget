var gk_media_init = function(selector, button_selector)  {
    var clicked_button = false;
 
    jQuery(selector).each(function (i, input) {
        var button = jQuery(input).next(button_selector);
        button.click(function (event) {
            event.preventDefault();
            var selected_img;
            clicked_button = jQuery(this);
 
            // check for media manager instance
            if(wp.media.frames.gk_frame) {
                wp.media.frames.gk_frame.open();
                return;
            }
            // configuration of the media manager new instance
            wp.media.frames.gk_frame = wp.media({
                title: 'Select image',
                multiple: false,
                library: {
                    type: 'image'
                },
                button: {
                    text: 'Use selected image'
                }
            });
 
            // Function used for the image selection and media manager closing
            var gk_media_set_image = function() {
                var selection = wp.media.frames.gk_frame.state().get('selection');
 
                // no selection
                if (!selection) {
                    return;
                }
 
                // iterate through selected elements
                selection.each(function(attachment) {
                    var url = attachment.attributes.url;
                    clicked_button.prev(selector).val(url);
                });
            };
 
            // closing event for media manger
            wp.media.frames.gk_frame.on('close', gk_media_set_image);
            // image selection event
            wp.media.frames.gk_frame.on('select', gk_media_set_image);
            // showing media manager
            wp.media.frames.gk_frame.open();
        });
   });
};

function disabled_button(){
    jQuery('input#verificar').attr("disabled", true); 
    jQuery("div[id*='torvicvslide_widget'] .alignright input[id*='torvicvslide_widget']").css("display", "none");//div[id^='sparkle'] 
    setInterval(function(){

var ruta1 = jQuery("#widgets-right input[id$='ruta1']").val();
var ruta2 = jQuery("#widgets-right input[id$='ruta2']").val(); 
var ruta3 = jQuery("#widgets-right input[id$='ruta3']").val(); 

    // Check if empty or not
    if (ruta1  === '' || ruta2  === '' || ruta3  === '') {
        jQuery('input#verificar').attr("disabled", true); 
    }else{
        jQuery('input#verificar').attr("disabled", false); 
    }
    }, 1000);
};

jQuery(document).ready( function($){
gk_media_init('.upload_image_input', '.upload_image_button');
disabled_button();
 
});

//he cambiado #sparklesidebarone por otro selector  div[id^='sparkle'] para que afecte todas los sidebar y
// main area que hay en los widgets.