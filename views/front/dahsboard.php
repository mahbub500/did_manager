<?php  
    use Codexpert\Did_Manager\Helper;
?>

<div class="container mt-5">
  <div class="row">
    <div class="col-md-3">
      <!-- Vertical Tabs -->
      <ul class="nav flex-column nav-tabs" id="myTab" role="tablist">
        <li class="nav-item">
          <a class="nav-link active" id="tab1-tab" data-toggle="tab" href="#tab1" role="tab" aria-controls="tab1" aria-selected="true">Did List</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" id="tab2-tab" data-toggle="tab" href="#tab2" role="tab" aria-controls="tab2" aria-selected="false">Add Did</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" id="tab3-tab" data-toggle="tab" href="#tab3" role="tab" aria-controls="tab3" aria-selected="false">Add User</a>
        </li>
      </ul>
    </div>
    <div class="col-md-9">
      <!-- Tab Content -->
      <div class="tab-content" id="myTabContent">
        <div class="tab-pane fade show active" id="tab1" role="tabpanel" aria-labelledby="tab1-tab">
          <?php 
        echo Helper::get_template( 'did_list', '/views/front/did' );
           ?>
        </div>
        <div class="tab-pane fade" id="tab2" role="tabpanel" aria-labelledby="tab2-tab">
          <h3>Add Did</h3>
          <p>This is the content for Tab 2.</p>
        </div>
        <div class="tab-pane fade" id="tab3" role="tabpanel" aria-labelledby="tab3-tab">
          <h3>Add User</h3>
          <p>This is the content for Tab 3.</p>
        </div>
      </div>
    </div>
  </div>
</div>
