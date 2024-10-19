<form id="add_user_form" name="add_user" method="post">
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
      <input type="date" name="dm_birthday" class="form-control" id="dm_birthday" required >
    </div>
  </div>
  <div class="form-group row">
    <label for="dm_mobile_no" class="col-sm-2 col-form-label">Mobile No :</label>
    <div class="col-sm-10">
      <input type="number" minlength="0" maxlength="10" required name="dm_mobile_no" class="form-control" id="dm_mobile_no" >
    </div>
  </div>
 <div class="form-group row">
    <label for="dm_village" class="col-sm-2 col-form-label">Upozila :</label>
    <div class="col-sm-10">
        <select class="form-control" id="dm_village">
            <option value="">Select Upozila</option>
            <?php 
            foreach (all_upozila_list() as $key => $value) {
                echo '<option value="' . $key . '">' . str_replace('_', ' ', $key) . '</option>';
            }
            ?>
        </select>
    </div>
</div>

<div class="form-group row">
    <label for="dm_union" class="col-sm-2 col-form-label">Union :</label>
    <div class="col-sm-10">
        <select class="form-control" id="dm_union">
            <option value="">Select Union</option>
            <!-- Unions for each Upazila (hidden) -->
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
      <input type="number" name="dm_word_no" class="form-control" id="dm_word_no" >
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
    <label for="dm_nid" class="col-sm-2 col-form-label">Nid :</label>
    <div class="col-sm-10">
      <input type="file" name="dm_nid" class="form-control image-input" id="dm_nid" data-preview="#nid_preview" accept="image/*">
<img id="nid_preview" src="" alt="NID Preview" style="display:none; max-width: 100px; margin-top: 10px;" />

    </div>
  </div>
   <button id="dm_submit" type="submit" disabled class="btn btn-primary">Submit</button>
</form>

