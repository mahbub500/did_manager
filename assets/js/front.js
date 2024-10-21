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
     // $('#dm_submit').attr('disabled', true);

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

	    const formData = new FormData(this); 
	   var form = this;


	    formData.append('action', 'add_user');
	    formData.append('_wpnonce', DID_MANAGER._wpnonce);

	    dm_modal();

	    $.ajax({
	        type: 'POST',
	        url: DID_MANAGER.ajaxurl, 
	        data: formData, // Use FormData object directly
	        contentType: false, // Required for FormData
	        processData: false, // Required for FormData
	        success: function(response) {
	            dm_modal(false);
	            alert('Form submitted successfully!');
	            form.reset();
	        },
	        error: function(error) {
	            alert('Form submission failed!');
	            dm_modal(false);
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
    
    $('.image-input').on('change', function() {
	    const imagePreview = $(this).data('preview'); // Use data attribute to target the preview element
	    const file = this.files[0]; 
	    previewImage(file, $(imagePreview));
	});

	function previewImage(file, imagePreview) {
	    if (file) {
	        const reader = new FileReader();

	        reader.onload = function(e) {
	            imagePreview.attr('src', e.target.result).show(); // Show the image preview
	        };

	        reader.readAsDataURL(file); // Read the file to preview it
	    } else {
	        imagePreview.attr('src', '').hide(); // Hide the preview if no file is selected
	    }
	}

	const $villageSelect	= $('#dm_upozila');
    const $unionSelect 		= $('#dm_union');

    
    function filterUnions() {
        const selectedUpazila = $villageSelect.val();
        $unionSelect.val('');
        $unionSelect.find('.union-option').each(function () {

            $(this).toggle($(this).data('upozila') === selectedUpazila);
        });
    }

    $villageSelect.on('change', filterUnions);

    filterUnions();
})










