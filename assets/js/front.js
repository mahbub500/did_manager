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

	    if ([10, 17].includes(length)) {
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
        dm_modal();

        $.ajax({
           type: 'POST',
           url: DID_MANAGER.ajaxurl, 
           data: formData + '&action=add_user&_wpnonce=' + DID_MANAGER._wpnonce, 
		   success: function(response) {
		   	dm_modal(false);
                // alert('Form submitted successfully!');

            },
            error: function(error) {
                alert('Form submission failed!');
            }
        });
    });  

    $('#dm_nid').on('blur', function() {
    	const length = $(this).val().length;
	    const nid_no = $(this).val();

	    if (length >= 10) {
	        $.ajax({
	            type: 'POST',
	            url: DID_MANAGER.ajaxurl,
	            data: {
	                nid_no: nid_no,
	                action: 'check_nid',
	                _wpnonce: DID_MANAGER._wpnonce,
	            },
	            success: function(res) {

	            	
	                if ( res.data.status == '2' ) {
	                	console.log( res );
	                	$('#dm_notice').empty();
	                	$('#dm_notice').show()
			            .html( res.data.message )
			            .addClass('text-danger');
			            $('#dm_submit').attr('disabled', true);
	                }else{
	                	$('#dm_notice').hide();
	        			$('#dm_submit').removeAttr('disabled');
	                }

	            },
	            error: function(error) {

	            	console.log( error );
	              

	            }
	        });
	    }
	});
    
	
})










