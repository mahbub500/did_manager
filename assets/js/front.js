let dm_modal = ( show = true ) => {
	if(show) {
		jQuery('#did-manager-modal').show();
	}
	else {
		jQuery('#did-manager-modal').hide();
	}
}

jQuery(function($){

    // $('#dm_notice').hide();
     $('#dm_submit').attr('disabled', true);

    function checkLength(inputElement, displayElementId) {
	    const length = $(inputElement).val().length;

	    if ([9, 16].includes(length)) {
	        $('#dm_notice').hide();
	        $('#dm_submit').removeAttr('disabled');
	    } else {
	        $('#dm_notice').show()
	            .html('Enter 10 or 17 Digit Nid Number')
	            .addClass('text-danger');
	        $('#dm_submit').attr('disabled', true);
	    }
	}

	$('#dm_nid').on('input', function() {
	    checkLength(this, '#dm_nid');
	});

	$('#add_user_form').on('submit', function(event) {
        event.preventDefault(); 

        const formData = $(this).serialize(); 

        $.ajax({
           type: 'POST',
           url: DID_MANAGER.ajaxurl, 
           data: formData + '&action=add_user&_wpnonce=' + DID_MANAGER._wpnonce, 
		   success: function(response) {
                // alert('Form submitted successfully!');
                console.log(response);
            },
            error: function(error) {
                alert('Form submission failed!');
                // console.log(error);
            }
        });
    });      
	
})