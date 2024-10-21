<?php  
    use wppluginhub\Did_Manager\Helper;

    if ( ! is_user_logged_in() ) {
      $current_url = esc_url( home_url( add_query_arg( null, null ) ) );
      $login_url = wp_login_url( $current_url ); 
      echo 'Please <a href="' . esc_url($login_url) . '">Login</a>'; 
      return;
    }
?>

<div class="container mt-5">
  <div class="row">

    <div class="col-md-12">
     <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
      <li class="nav-item" role="presentation">
        <button class="nav-link active" id="pills-home-tab" data-toggle="pill" data-target="#pills-home" type="button" role="tab" aria-controls="pills-home" aria-selected="true">Add User</button>
      </li>
      <li class="nav-item" role="presentation">
        <button class="nav-link" id="pills-profile-tab" data-toggle="pill" data-target="#pills-profile" type="button" role="tab" aria-controls="pills-profile" aria-selected="false">View User</button>
      </li>
      <li class="nav-item" role="presentation">
        <button class="nav-link" id="pills-contact-tab" data-toggle="pill" data-target="#pills-contact" type="button" role="tab" aria-controls="pills-contact" aria-selected="false">Contact</button>
      </li>
    </ul>
    <div class="tab-content" id="pills-tabContent">
      <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
        <?php echo Helper::get_template( 'add_user', '/views/front/did' ); ?>
      </div>
      <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
         <?php echo Helper::get_template( 'view_user', '/views/front/did' ); ?>
      </div>
      <div class="tab-pane fade" id="pills-contact" role="tabpanel" aria-labelledby="pills-contact-tab">...</div>
    </div>
    </div>
  </div>
</div>
