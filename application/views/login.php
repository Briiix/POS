<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>POS Login</title>
  <!-- plugins:css -->
  <link rel="stylesheet" href="<?php echo base_url() ?>assets/vendors/feather/feather.css">
  <link rel="stylesheet" href="<?php echo base_url() ?>assets/vendors/ti-icons/css/themify-icons.css">
  <link rel="stylesheet" href="<?php echo base_url() ?>assets/vendors/css/vendor.bundle.base.css">
  <link rel="stylesheet" href="<?php echo base_url() ?>assets/css/vertical-layout-light/style.css">
  <!-- endinject -->
  <link rel="shortcut icon" href="assets/images/favicon.png" />
</head>

<body>
  <div class="container-scroller">
    <div class="container-fluid page-body-wrapper full-page-wrapper">
      <div class="content-wrapper d-flex align-items-center auth px-0">
        <div class="row w-100 mx-0">
          <div class="col-lg-4 mx-auto">
            <div class="auth-form-light text-left py-5 px-4 px-sm-5">
              <div class="row">
                <div id="form_error" class="col-md-12"></div>
              </div>
              <center>
                <h3>Point of Sales</h3>
              </center>
              <form class="pt-3" id="login-form">
                <div class="form-group">
                  <input type="text" class="form-control form-control-lg" id="username" name="username" placeholder="Username">
                  <span class="text-danger" id="username_error"></span>
                </div>
                <div class="form-group">
                  <input type="password" class="form-control form-control-lg" id="password" name="password" placeholder="Password">
                  <span class="text-danger" id="password_error"></span>
                </div>
                <div class="mt-3">
                  <button type="submit" value="submit" name="submit" class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn">Login</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script src="<?php echo base_url() ?>assets/js/jquery.min.js"></script>
  <script src="<?php echo base_url() ?>assets/js/bootstrap.min.js"></script>
  <script src="<?php echo base_url() ?>assets/vendors/js/vendor.bundle.base.js"></script>
  <script src="<?php echo base_url() ?>assets/js/off-canvas.js"></script>
  <script src="<?php echo base_url() ?>assets/js/hoverable-collapse.js"></script>
  <script src="<?php echo base_url() ?>assets/js/template.js"></script>
  <script src="<?php echo base_url() ?>assets/js/settings.js"></script>
  <script src="<?php echo base_url() ?>assets/js/todolist.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
</body>

</html>
<script>
  $(document).ready(function() {

    $('#login-form').submit(function(e) {
      e.preventDefault();
      var username = $('#username').val();
      var password = $('#password').val();
      $.ajax({
        url:"<?php echo base_url('index.php/client/login') ?>",
        method:'POST',
        data:{username:username, password:password},
        success:function(resp) {
          rs = JSON.parse(resp);
          if (rs.error === true) {
            $('#username_error').html(rs.username);
            $('#password_error').html(rs.password);
          } else if(rs.is_user === true) {
            if(rs.role_id === '1') {
              window.location.href = '<?php echo base_url("index.php/client/dashboard") ?>';
            } else if(rs.role_id === '2') {
              window.location.href = '<?php echo base_url("index.php/client/buyproductlist") ?>';
            }
          } else if(rs.is_user === false) {
            $('#form_error').html('<div class="alert alert-danger">'+rs.invalid_user+'</div>');
            $('#username').val('');
            $('#password').val('');
          }
        }
      });
    });

  });
</script>