<?php  
global $wpdb;

// Define your table name
$table_name = $wpdb->prefix . 'did_user_data'; 

// Fetch all records from the custom table
$results = $wpdb->get_results("SELECT * FROM $table_name");
?>

<table class="table">
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
	       		echo wp_get_attachment_image($row->attachment_id, 'thumbnail'); // Display the image
	        ?>

          </td>
          <td><?php 
	       		echo wp_get_attachment_image($row->nid, 'thumbnail'); // Display the image
	        ?>
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
