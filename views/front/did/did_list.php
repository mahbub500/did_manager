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
      <input type="text" name="user_name" class="form-control" id="dm_name" placeholder="Enter your name">
    </div>
  </div>
  <div class="form-group row">
    <label for="dm_birthday" class="col-sm-2 col-form-label">Birth Day :</label>
    <div class="col-sm-10">
      <input type="date" name="dm_birthday" class="form-control" id="dm_birthday" required >
    </div>
  </div>
   <button id="dm_submit" type="submit" class="btn btn-primary">Submit</button>
</form>