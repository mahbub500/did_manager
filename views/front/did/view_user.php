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
          <td><?php echo esc_html($row->union); ?></td>
          <td><?php echo esc_html($row->word_no); ?></td>
          <td>
          	<?php 


	       		$attachment_id = $row->attachment_id; 
    			$image_url = wp_get_attachment_url($attachment_id);

	       		if ($image_url) {
	       			echo '<a href="' . esc_url($image_url) . '" download>';
			        echo wp_get_attachment_image($attachment_id, 'thumbnail'); 
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
			        echo wp_get_attachment_image($nid, 'thumbnail'); 
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
            <input type="hidden" name="action" value="add_user">
            <div class="form-group row">
                <label for="dm_nid" class="col-sm-2 col-form-label">Nid :</label>
                <div class="col-sm-10">
                    <input type="number" name="nid_number" class="form-control-plaintext" id="dm_nid" placeholder="Enter your Nid" >
                    <small id="dm_notice" class="form-text "></small>
                </div>
            </div>
            <div class="form-group row">
                <label for="dm_name" class="col-sm-2 col-form-label">Name :</label>
                <div class="col-sm-10">
                    <input type="text" required name="user_name" class="form-control" id="dm_name" placeholder="Enter your name">
                </div>
            </div>
            <div class="form-group row">
                <label for="dm_birthday" class="col-sm-2 col-form-label">Birth Day :</label>
                <div class="col-sm-10">
                    <input type="date" name="dm_birthday" class="form-control" id="dm_birthday" required>
                </div>
            </div>
            <div class="form-group row">
                <label for="dm_mobile_no" class="col-sm-2 col-form-label">Mobile No :</label>
                <div class="col-sm-10">
                    <input type="number" minlength="0" maxlength="10" required name="dm_mobile_no" class="form-control" id="dm_mobile_no">
                </div>
            </div>
            <div class="form-group row">
                <label for="dm_upozila" class="col-sm-2 col-form-label">Upozila :</label>
                <div class="col-sm-10">
                    <select name='dm_upozila' class="form-control" id="dm_upozila">
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
                <label for="dm_union" class="col-sm-2 col-form-label">Union :</label>
                <div class="col-sm-10">
                    <select name='dm_union' class="form-control" id="dm_union">
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
                <label for="dm_word_no" class="col-sm-2 col-form-label">Word No :</label>
                <div class="col-sm-10">
                    <input type="number" name="dm_word_no" class="form-control" id="dm_word_no">
                </div>
            </div>
            <div class="form-group row">
                <label for="dm_image" class="col-sm-2 col-form-label">Image :</label>
                <div class="col-sm-10">
                    <input type="file" name="dm_image" class="form-control image-input" id="dm_image" data-preview="#image_preview" accept="image/*">
                    <img id="image_preview" src="" alt="Image Preview" style="display:none; max-width: 100px; margin-top: 10px;" />
                </div>
            </div>
            <div class="form-group row">
                <label for="dm_nid_image" class="col-sm-2 col-form-label">Nid :</label>
                <div class="col-sm-10">
                    <input type="file" name="dm_nid_image" class="form-control image-input" id="dm_nid_image" data-preview="#nid_preview" accept="image/*">
                    <img id="nid_preview" src="" alt="NID Preview" style="display:none; max-width: 100px; margin-top: 10px;" />
                </div>
            </div>
            <button id="dm_update" type="submit" disabled class="btn btn-primary">Update</button>
        </form>
    </div>
</div>


