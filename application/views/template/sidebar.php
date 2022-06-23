
<?php

  $navbar = [];
  if (isset($_SESSION['people_login'])) {
    $navbar = $this->Main_model->appMenu();
  }
  
?>

<!-- Main Sidebar Container -->
<aside class="main-sidebar elevation-2 sidebar-light-danger">

  <!-- Brand Logo -->
  <a href="<?= base_url('/')?>" class="brand-link">
    <img src="<?= base_url('assets/images/_logo_1.png') ?>" alt=""
      class="brand-image img-circle elevation-0" style="opacity: .8">
    <span class="brand-text font-weight-light Kanit-Regular">MAIN-Manage</span>
  </a>

  <!-- Sidebar -->
  <div class="sidebar">
    <!-- Sidebar Menu -->
    <?php if ($this->session->userdata('people_login') and $this->session->userdata('people_login') == 1) { ?>
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
        <?php foreach ($navbar as $item){ ?>
       
        <li class="nav-item has-treeview">
          <a href="<?= $item['fld_url'] ?>" class="nav-link">
            <i class="nav-icon fas <?= $item['fld_icon'] ?>"></i>
            <p>
              <?= $item['fld_name'] ?>
            </p>
          </a>
        </li>
        <?php } ?>
      </ul>
    </nav>
    <?php }; ?>
    <!-- /.sidebar-menu -->
  </div>
  <!-- /.sidebar -->
</aside>

<!--  เพิ่มมาใหม่ เนื่องจากต้องการแสดงข้อมูลทั้งหมด -->
<div class="content-wrapper">
  <!--  เพิ่มมาใหม่ เนื่องจากต้องการแสดงข้อมูลทั้งหมด -->
