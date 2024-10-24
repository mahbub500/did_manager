<?php  
global $wpdb;

// Define your table name
$table_name = $wpdb->prefix . 'did_user_data'; 

// Fetch all records from the custom table
$results = $wpdb->get_results("SELECT * FROM $table_name");
?>

<table <?php if ( !empty( $results ) ) echo 'id="dm_table"'; ?> class="table">

  <thead>
    <tr>
      <th scope="col">Sl</th>
      <th scope="col">NID Number</th>
      <th scope="col">Name</th>
      <th scope="col">Birthday</th>
      <th scope="col">Mobile No</th>
      <th scope="col">Upozila</th>
      <th scope="col">Union</th>
      <th scope="col">Word No</th>
      <th scope="col">Image</th>
      <th scope="col">NID</th>
      <th scope="col">Action</th>
    </tr>
  </thead>
  <tbody>
    <?php if (!empty($results)) : ?>
      <?php foreach ($results as $index => $row) : ?>
        <tr>
          <th scope="row"><?php echo esc_html($index + 1); ?></th>
          <td><?php echo esc_html($row->nid_number); ?></td>
          <td><?php echo esc_html($row->user_name); ?></td>
          <td><?php echo esc_html($row->birthday); ?></td>
          <td><?php echo esc_html($row->mobile_no); ?></td>
          <td><?php echo esc_html($row->upozila); ?></td>
          <td><?php echo esc_html($row->dm_union); ?></td>
          <td><?php echo esc_html($row->word_no); ?></td>
          <td>
          	<?php 


	       		$attachment_id = $row->attachment_id; 
    			$image_url = wp_get_attachment_url($attachment_id);

	       		if ($image_url) {
	       			echo '<a href="' . esc_url($image_url) . '" download>';
			        echo wp_get_attachment_image($attachment_id, array( 50, 50 )); 
			        echo '</a>';
			    } else {
			        echo 'No image'; 
			    }
	        ?>

          </td>
          <td><?php 

	       		$nid = $row->nid; 
    			$nid_url = wp_get_attachment_url($nid);

	       		if ($nid_url) {
	       			echo '<a href="' . esc_url($nid_url) . '" download>';
			        echo wp_get_attachment_image($nid, array( 50, 50 )); 
			        echo '</a>';
			    } else {
			        echo 'No Nid '; 
			    }
	        ?>
          </td>
          <td>
          	<button class="btn btn-primary btn-sm edit-button" data-id="<?php echo esc_attr($row->id); ?>" >Edit</button>
          	<button class="btn btn-danger btn-sm delete-button" data-id="<?php echo esc_attr($row->id); ?>" >Delete</button>
          </td>
        </tr>
      <?php endforeach; ?>
    <?php else : ?>
      <tr>
        <td colspan="11">No records found.</td>
      </tr>
    <?php endif; ?>
  </tbody>
</table>

<!-- Edit User Modal -->
<div id="edit-user-modal" class="dm_modal">
    <div class="modal-content">


        <form id="edit-user-form">
            <input type="hidden" value="" id="edit_post_id" name="">
            
            <div class="form-group row">
                <label for="dm_nid_edit" class="col-sm-2 col-form-label">Nid :</label>
                <div class="col-sm-10">
                    <input type="number" readonly value="" name="nid_number" class="form-control" id="dm_nid_edit" placeholder="Enter your Nid" >
                    <small id="dm_notice" class="form-text "></small>
                </div>
            </div>
            <div class="form-group row">
                <label for="dm_name_edit" class="col-sm-2 col-form-label">Name :</label>
                <div class="col-sm-10">
                    <input type="text" value="" required name="user_name" class="form-control" id="dm_name_edit" placeholder="Enter your name">
                </div>
            </div>
            <div class="form-group row">
                <label for="dm_birthday_edit" class="col-sm-2 col-form-label">Birth Day :</label>
                <div class="col-sm-10">
                    <input type="date" value="" name="dm_birthday_edit" class="form-control" id="dm_birthday_edit" required>
                </div>
            </div>
            <div class="form-group row">
                <label for="dm_mobile_no_edit" class="col-sm-2 col-form-label">Mobile No :</label>
                <div class="col-sm-10">
                    <input type="number" value="" minlength="0" maxlength="10" required name="dm_mobile_no_edit" class="form-control" id="dm_mobile_no_edit">
                </div>
            </div>
            <div class="form-group row">
                <label for="dm_upozila_edit" class="col-sm-2 col-form-label">Upozila :</label>
                <div class="col-sm-10">
                    <select name='dm_upozila_edit' class="form-control" id="dm_upozila_edit">
                        <option value="">Select Upozila</option>
                        <?php 
                        foreach (all_upozila_list() as $key => $value) {
                            $selected = ($key === 'Companiganj') ? 'selected' : '';  
                            echo '<option value="' . $key . '" ' . $selected . '>' . str_replace('_', ' ', $key) . '</option>';
                        }
                        ?>
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label for="dm_union_edit" class="col-sm-2 col-form-label">Union :</label>
                <div class="col-sm-10">
                    <select name='dm_union_edit' class="form-control" id="dm_union_edit">
                        <option value="">Select Union</option>
                        <?php foreach (all_upozila_list() as $key => $value): ?>
                            <?php foreach ($value as $union): ?>
                                <option class="union-option" data-upozila="<?php echo $key; ?>" value="<?php echo $union; ?>">
                                    <?php echo $union; ?>
                                </option>
                            <?php endforeach; ?>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label for="dm_word_no_edit" class="col-sm-2 col-form-label">Word No :</label>
                <div class="col-sm-10">
                    <input type="number" value="" name="dm_word_no_edit" class="form-control" id="dm_word_no_edit">
                </div>
            </div>
            <div class="form-group row">
                <label for="dm_image_edit" class="col-sm-2 col-form-label">Image :</label>
                <div class="col-sm-10">
                    <input type="file"  name="dm_image_edit" class="form-control image-input" id="dm_image_edit" data-preview="#image_preview" value="" >
                    <img  id="image_preview_edit" src="" alt="Image Preview" style="display:none; max-width: 100px; margin-top: 10px;" />
                </div>
            </div>
            <div class="form-group row">
                <label for="dm_nid_image_edit" class="col-sm-2 col-form-label">Nid :</label>
                <div class="col-sm-10">
                    <input type="file" name="dm_nid_image_edit" class="form-control image-input" id="dm_nid_image_edit" data-preview="#nid_preview" value="" >
                    <img id="nid_preview_edit" src="" alt="NID Preview" style="display:none; max-width: 100px; margin-top: 10px;" />
                </div>
            </div>
             <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary">Save changes</button>
          </div>
        </form>
    </div>
</div>


