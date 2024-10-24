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

	let table = new DataTable('#dm_table');

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
	        data: formData, 
	        contentType: false, 
	        processData: false, 
	        success: function(response) {
	            dm_modal(false);
	            $('#image_preview, #nid_preview').hide();
	            $('#dm_submit').attr('disabled', true);
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
	const $villageEdit		= $('#dm_upozila_edit');
    const $unionSelect 		= $('#dm_union');
    const $unionEdit 		= $('#dm_union_edit');

    
    function filterUnions() {
        const selectedUpazila = $villageSelect.val();
        $unionSelect.val('');
        $unionSelect.find('.union-option').each(function () {

            $(this).toggle($(this).data('upozila') === selectedUpazila);
        });
    }

    $villageSelect.on('change', filterUnions);

    filterUnions();


   

    // Delete user

    $('.delete-button').on('click', function() {
    var button = $(this);
    var itemId = button.data('id');

    if (confirm('Are you sure you want to delete this item?')) {
        $.ajax({
        type: 'POST',
        url: DID_MANAGER.ajaxurl, // Make sure this is the correct spelling
        data: {
            id: itemId,
            action: 'delete_user',
            _wpnonce: DID_MANAGER._wpnonce
        },
        success: function(response) {
            if (response.success) {
                button.closest('tr').remove(); 
                // alert('Item deleted successfully!');
            } else {
                alert('Error: ' + response.data);
            }
        },
        error: function() {
            alert('AJAX error: Unable to delete item.');
        }
    });

    }
});


    $('.edit-button').on('click', function() {
        var postID = $(this).data('id'); 

       
        $.ajax({
            url: DID_MANAGER.ajaxurl,  
            type: 'POST',
            data: {
                action: 'get_user_data',  
                postID: postID,
                _wpnonce:DID_MANAGER._wpnonce
            },
            success: function(response) {
                if (response.success) {
                	$('#edit_post_id').val(response.data.post_id);
                	$('#dm_nid_edit').val(response.data.nid_number);
               		$('#dm_name_edit').val(response.data.name);
                	$('#dm_birthday_edit').val(response.data.birthday);
                	$('#dm_mobile_no_edit').val(response.data.mobile_no);
                	$('#dm_upozila_edit').val(response.data.upozila);
                	$('#dm_union_edit').val(response.data.union);
                	$('#dm_word_no_edit').val(response.data.word_no);
                	$('#image_preview_edit').attr('src', response.data.image).show();  
    				$('#nid_preview_edit').attr('src', response.data.nid).show();
    				$('#edit-user-modal').modal('show');
                } else {
                    alert('Error fetching user data.');
                }
            },
            error: function() {
                alert('Failed to communicate with the server.');
            }
        });
    });
  	$('#close-modal').on('click', function() {

        $('#edit-user-modal').hide();            
        $('.modal-backdrop').remove();           
        location.reload();                       
    });

  $(document).on('keydown', function(event) {
        if (event.key === "Escape") { // Check if the 'Esc' key is pressed
            $('#edit-user-modal').hide();
            $('.modal-backdrop').remove();
            location.reload();
        }
    });

  // After reload show same tab

  $(document).ready(function() {
	    var activeTab = localStorage.getItem('activeTab');

	    if (activeTab) {
	        $('.nav-link').removeClass('active');
	        $('.tab-pane').removeClass('show active');

	        $(activeTab).addClass('active');
	        var targetTab = $(activeTab).data('target');
	        $(targetTab).addClass('show active');
	    }

	    $('.nav-link').on('click', function() {
	        $('.nav-link').removeClass('active');
	        $('.tab-pane').removeClass('show active');

	        $(this).addClass('active');
	        var targetTab = $(this).data('target');
	        $(targetTab).addClass('show active');

	        var tabId = '#' + $(this).attr('id');
	        localStorage.setItem('activeTab', tabId);
	    });
	});

   // Handle form submission
	$('#edit-user-form').on('submit', function(e) {
	    e.preventDefault(); // Prevent the default form submission

	    // Create a FormData object and append additional data
	    var formData = new FormData(this); 
	    formData.append('action', 'update_user_data'); 
	    formData.append('_wpnonce', DID_MANAGER._wpnonce); 

	    // AJAX request to submit form data
	    $.ajax({
	        type: 'POST',
	        url: DID_MANAGER.ajaxurl,
	        data: formData,
	        processData: false, 
	        contentType: false, 
	        success: function(response) {
	            if (response.success) {
	                // alert('Data saved successfully!');
	                $('#edit-user-modal').modal('hide'); 
	            } else {
	                alert('An error occurred: ' + response.data); 
	            }
	        },
	        error: function(xhr, status, error) {
	            alert('AJAX error: ' + error); 
	        }
	    });
	});


})










