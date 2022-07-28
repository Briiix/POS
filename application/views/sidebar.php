<nav class="sidebar sidebar-offcanvas" id="sidebar">
  <ul class="nav">
    <?php
    if($this->session->userdata('role') == 'Cashier') { ?>
      <!-- Buy Products -->
      <li class="nav-item">
        <a href="<?php echo base_url() ?>index.php/client/buyproductlist" class="nav-link">
          <i class="icon-grid menu-icon"></i>
          <span class="menu-title">Buy Products</span>
        </a>
      </li>
    <?php
    } else if($this->session->userdata('role') == 'Admin') { ?>
      <!-- Dashboard -->
      <li class="nav-item">
        <a class="nav-link" href="<?php echo base_url() ?>index.php/client/dashboard">
          <i class="icon-grid menu-icon"></i>
          <span class="menu-title">Dashboard</span>
        </a>
      </li>

      <!-- Buy Products -->
      <li class="nav-item">
        <a href="<?php echo base_url() ?>index.php/client/buyproductlist" class="nav-link">
          <i class="icon-grid menu-icon"></i>
          <span class="menu-title">Buy Products</span>
        </a>
      </li>

      <!-- Products -->
      <li class="nav-item">
        <a href="<?php echo base_url() ?>index.php/client/productlist" class="nav-link">
          <i class="icon-grid menu-icon"></i>
          <span class="menu-title">Products</span>
        </a>
      </li>

      <!-- Sales Report -->
      <li class="nav-item">
        <a class="nav-link" href="<?php echo base_url() ?>index.php/client/sales">
          <i class="icon-grid menu-icon"></i>
          <span class="menu-title">Sales Report</span>
        </a>
      </li>

      <!-- Collection Reports -->
      <li class="nav-item">
        <a class="nav-link" href="<?php echo base_url() ?>index.php/client/collectionreports">
          <i class="icon-grid menu-icon"></i>
          <span class="menu-title">Collection Reports</span>
        </a>
      </li>

      <!-- ARR -->
      <li class="nav-item">
        <a class="nav-link" href="<?php echo base_url() ?>index.php/client/arrlist">
          <i class="icon-grid menu-icon"></i>
          <span class="menu-title">ARR</span>
        </a>
      </li>

      <!-- Reference Tables -->
      <li class="nav-item">
        <a class="nav-link" data-toggle="collapse" href="#ref" aria-expanded="false" aria-controls="ref">
          <i class="icon-bar-graph menu-icon"></i>
          <span class="menu-title">Reference Table</span>
          <i class="menu-arrow"></i>
        </a>
        <div class="collapse" id="ref">
          <!-- Suppliers -->
          <ul class="nav flex-column sub-menu">
            <li class="nav-item"> <a class="nav-link" href="<?php echo base_url() ?>index.php/client/supplierlist">Suppliers</a></li>
          </ul>
          <!-- Customers -->
          <ul class="nav flex-column sub-menu">
            <li class="nav-item"> <a class="nav-link" href="<?php echo base_url() ?>index.php/client/customerlist">Customers</a></li>
          </ul>
        </div>
      </li>

      <!-- Settings -->
      <li class="nav-item">
        <a class="nav-link" data-toggle="collapse" href="#settings" aria-expanded="false" aria-controls="settings">
          <i class="icon-bar-graph menu-icon"></i>
          <span class="menu-title">Settings</span>
          <i class="menu-arrow"></i>
        </a>
        <div class="collapse" id="settings">
          <ul class="nav flex-column sub-menu">
            <li class="nav-item"> <a class="nav-link" href="#">Users</a></li>
          </ul>
        </div>
      </li>
    <?php
    } ?>
  </ul>
</nav>

<div class="main-panel">
  <div class="content-wrapper">