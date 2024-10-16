let dm_modal = ( show = true ) => {
	if(show) {
		jQuery('#did-manager-modal').show();
	}
	else {
		jQuery('#did-manager-modal').hide();
	}
}

jQuery(function($){

    $(document).ready(function() {
        $('.dm_tab').on('click', function() {
        	console.log( 'test' );
            // Remove active class from all tabs
            $('.dm_tab').removeClass('active');
            // Add active class to the clicked tab
            $(this).addClass('active');
            
            // Hide all content
            $('.dm_content').removeClass('active');
            // Show the content for the clicked tab
            var tabId = $(this).data('tab');
            $('#' + tabId).addClass('active');
        });
    });
      
	
})