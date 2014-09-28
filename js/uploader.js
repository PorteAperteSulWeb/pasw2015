jQuery(document).ready(function($){
 
 
    var custom_uploader;
 
 
    $('#pasw_logo_upload').click(function(e) {
 
        e.preventDefault();
 
        //If the uploader object has already been created, reopen the dialog
        if (custom_uploader) {
            custom_uploader.open();
            return;
        }
 
        //Extend the wp.media object
        custom_uploader = wp.media.frames.file_frame = wp.media({
            title: 'Scegli un logo per il tuo sito Pasw2015',
            button: {
                text: 'Scegli un logo per il tuo sito Pasw2015'
            },
            multiple: false
        });
 
        //When a file is selected, grab the URL and set it as the text field's value
        custom_uploader.on('select', function() {
            attachment = custom_uploader.state().get('selection').first().toJSON();
            $('#pasw_logo_n').val(attachment.url);
        });
 
        //Open the uploader dialog
        custom_uploader.open();
 
    });
 
 
});