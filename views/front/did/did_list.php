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
      <input type="number" min="0" max="10" required name="dm_mobile_no" class="form-control" id="dm_mobile_no" >
    </div>
  </div>
  <div class="form-group row">
    <label for="dm_village" class="col-sm-2 col-form-label">Village :</label>
    <div class="col-sm-10">
      <input type="text" name="dm_village" class="form-control" id="dm_village" >
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
      <input type="file" name="dm_image" class="form-control" id="dm_image" >
    </div>
  </div>

  <div class="form-group row">
    <label for="dm_nid" class="col-sm-2 col-form-label">Nid :</label>
    <div class="col-sm-10">
      <input type="file" name="dm_nid" class="form-control" id="dm_nid" >
    </div>
  </div>
   <button id="dm_submit" type="submit" disabled class="btn btn-primary">Submit</button>
</form>