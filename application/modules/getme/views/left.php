
  <header class="main-header">
    <!-- Logo -->
    <a href="<?= base_url();?>main/home" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b>HD</b></span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b>HD</b> SYSTEM</span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </a>

      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <!-- Messages: style can be found in dropdown.less-->
          <!-- Notifications: style can be found in dropdown.less -->
          <!-- Tasks: style can be found in dropdown.less -->
          <!-- User Account: style can be found in dropdown.less -->
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <img src="<?= base_url('assets/dist/img/'.$image);?>" class="user-image" alt="User Image">
              <span class="hidden-xs"><?=$first_name.' '.$last_name?></span>
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">
                <img src="<?= base_url('assets/dist/img/'.$image);?>" class="img-circle" alt="User Image">
                <p>
                  <?=ucwords($username);?><small><?=($email)?" (".$email.")":"";?></small>
                  <small>Last login: <?=$last_login;?></small>
                  <!-- <small>Member since Nov. 2012</small> -->
                </p>
              </li>
              <!-- Menu Body -->
              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-right">
                  <a href="<?= base_url();?>auth/logout" class="btn btn-default btn-flat">Sign out</a>
                </div>
              </li>
            </ul>
          </li>
          <!-- Control Sidebar Toggle Button -->
        </ul>
      </div>
    </nav>
  </header>

  <!-- =============================================== -->

  <!-- Left side column. contains the sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="pull-left image">
          <img src="<?= base_url('assets/dist/img/'.$image);?>" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p><?=$first_name.' '.$last_name?></p>
          <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
      </div>
      <!-- search form -->
      <!-- /.search form -->
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu">
        <li class="header">MAIN NAVIGATION</li>
        <?php 
        // MENU
        $module_group_id = 0;
        $module_id=0;
        $multilevel=0;
        $closed_sub_menu = 0;
        $closed_level_menu = 0;
        foreach ($menus as $menu)
        {
          if ($module_group_id != $menu->module_group_id)
          {
            if ($closed_sub_menu) echo "</ul></li>";
              
            $module_group_id   = $menu->module_group_id;
            echo '<li class="treeview">';
            
            // Default Navbar
             echo '<a href="#">';
            echo '<i class="fa fa-fw '.$menu->module_group_icon.'"></i><span>'.$menu->module_group_name.'</span><i class="fa fa-angle-left pull-right"></i></a>';
            echo '<ul class="treeview-menu">';
            
            // SUB MENU DETAIL
            $module_page_link = site_url($menu->module_page_link);

            echo '<li><a href="'.$module_page_link.'"><i class="fa fa-circle-o text-aqua"></i>'.$menu->module_name.'</a></li>';
              
            $closed_sub_menu = 1;
            
          }
          else
          {
            $module_group_id   = $menu->module_group_id;
            $module_page_link = site_url($menu->module_page_link);
            echo '<li><a href="'.$module_page_link.'"><i class="fa fa-circle-o text-aqua"></i>'.$menu->module_name.'</a></li>';
          }
        }
        ?>
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>

  <!-- =============================================== -->
