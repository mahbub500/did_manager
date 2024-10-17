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

	    if ([ 9, 16].includes(length)) {
	    	$('#dm_notice').hide();
	    	$('#dm_submit').attr( 'disabled' );
	    	$('#dm_submit').removeAttr('disabled');
	    }else{
	    	$('#dm_notice').show();
	        $('#dm_notice').html('Enter 10 or 17 Digit Nid Nunber'); 
	        $('#dm_notice').addClass( 'text-danger' ); 
	        $('#dm_submit').attr('disabled', true);
	    }
	}


    $('#dm_nid').on('keypress', function() {
        checkLength(this, '#dm_nid');
    });

    $( "#dm_nid" ).on( "blur", function() {

    } );
      
	
})