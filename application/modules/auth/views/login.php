<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Log in</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.6 -->
    <link rel="stylesheet" href="<?= base_url();?>assets/bootstrap/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?= base_url();?>assets/font-awesome-4.6.3/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="<?= base_url();?>assets/ionicons-2.0.1/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?= base_url();?>assets/dist/css/AdminLTE.min.css">
    <!-- iCheck -->
    <!-- <link rel="stylesheet" href="<?= base_url();?>/assets/plugins/iCheck/square/blue.css"> -->
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body class="hold-transition login-page">
    <div class="login-box">
      <div class="login-logo">
        <a href="<?= base_url();?>index.php/auth/login"><b>HD</b>SYSTEMS</a>
      </div>
      <!-- /.login-logo -->
      <div class="login-box-body">
        <fieldset>
          <p class="login-box-msg">Sign in to start your session</p>
          <!-- <form action="<?= base_url();?>index.php/auth/login" method="post"> -->
          <?php echo form_open("auth/login");?>
          <div class="form-group has-feedback">
            <?php echo form_input($identity,'','class="form-control" placeholder="User Name" type="text" autofocus');?>
            <!-- <input type="text" class="form-control" placeholder="User Name" > -->
            <span class="glyphicon glyphicon-user form-control-feedback"></span>
          </div>
          <div class="form-group has-feedback">
            <?php echo form_input($password,'','class="form-control" placeholder="Password"  type="password"');?>
            <!-- <input type="password" class="form-control" placeholder="Password"> -->
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
          </div>
          <div class="row">
            <div class="col-xs-8">
            </div>
            <!-- /.col -->
            <div class="col-xs-4">
              <?php echo form_submit('submit', lang('login_submit_btn'),'class="btn btn-primary btn-block btn-flat"');?>
              <?php echo form_close();?>
              <!-- <button type="submit" class="btn btn-primary btn-block btn-flat">Sign In</button> -->
            </div>
            <!-- /.col -->
          </div>
        </fieldset>
        <?php echo $message;?>
        <div class="social-auth-links text-center">
          <p></p>
        </div>
        <!-- /.social-auth-links -->
        <!-- <a href="#">I forgot my password</a><br>
        <a href="register.html" class="text-center">Register a new membership</a> -->
      </div>
      <!-- /.login-box-body -->
    </div>
    <!-- /.login-box -->
    <!-- jQuery 2.2.0 -->
    <script src="<?= base_url();?>/assets/plugins/jQuery/jQuery-2.2.0.min.js"></script>
    <!-- Bootstrap 3.3.6 -->
    <script src="<?= base_url();?>/assets/bootstrap/js/bootstrap.min.js"></script>
    <!-- iCheck -->
    <!-- <script src="<?= base_url();?>/assets/plugins/iCheck/icheck.min.js"></script> -->
    <!--     <script>
    $(function () {
    $('input').iCheck({
    checkboxClass: 'icheckbox_square-blue',
    radioClass: 'iradio_square-blue',
    increaseArea: '20%' // optional
    });
    });
    </script> -->
  </body>
</html>