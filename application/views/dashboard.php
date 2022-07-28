<?php include 'part_top.php'; ?>
<!-- partial -->

<div class="row">
  <div class="col-md-12 grid-margin">
  </div>
</div>
<div class="row">
  <div class="col-md-6 grid-margin stretch-card">
    <div class="card tale-bg">
      <div class="card-people mt-auto">
        <img src="<?php echo base_url() ?>assets/images/dashboard/people.svg" alt="people">
        <div class="weather-info">
          <div class="d-flex">
            <div class="ml-2">
              <h4 class="location font-weight-normal">POS</h4>
              <h6 class="font-weight-normal">Point of Sales</h6>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-md-6 grid-margin transparent">
    <div class="row">
      <div class="col-md-6 mb-4 stretch-card transparent">
        <div class="card card-tale">
          <div class="card-body">
            <p class="mb-4">Products that will expire in this month</p>
            <p class="fs-30 mb-2"><?php echo $product_to_expire?></p>
            <p>Total</p>
          </div>
        </div>
      </div>
      <div class="col-md-6 mb-4 stretch-card transparent">
        <div class="card card-dark-blue">
          <div class="card-body">
            <p class="mb-4">Number of Products</p>
            <p class="fs-30 mb-2"><?php echo $productscount?></p>
            <p>Total</p>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-6 mb-4 mb-lg-0 stretch-card transparent">
        <div class="card card-light-blue">
          <div class="card-body">
            <p class="mb-4">Number of Customers</p>
            <p class="fs-30 mb-2"><?php echo $customerscount?></p>
            <p>Total</p>
          </div>
        </div>
      </div>
      <div class="col-md-6 stretch-card transparent">
        <div class="card card-light-danger">
          <div class="card-body">
            <p class="mb-4">Total Sales This Month</p>
            <p class="fs-30 mb-2"><?php echo $sales_this_month?></p>
            <p>Total</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="row">
  <div class="col-md-6 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
      <div class="d-flex justify-content-between">
          <p class="card-title">Account Receivable Reports</p>
          <a  href="<?php echo base_url() ?>index.php/client/arrlist" class="text-info">View all</a>
        </div>
        <div class="table-responsive">
        <table class="table table-striped" id="myTable">
          <thead>
            <tr>
              <th>Product Name</th>
              <th>Customer Name</th>
              <th>Status</th>
              <th>Date</th>
            </tr>
          </thead>
          <tbody id="myTable">
            <?php
            if (!empty($accountrecievablereports)) {
              foreach ($accountrecievablereports as $arr) : ?>
                <tr>
                  <td><?php echo $arr['product_name']; ?></td>
                  <td><?php echo $arr['customer_name']; ?></td>
                  <td><?php echo $arr['payment_status']; ?></td>
                  <td><?php echo date('M d, Y', strtotime($arr['created_at'])); ?></td>
                </tr>
              <?php
              endforeach;
            } else { ?>
              <tr class="text-center">
                <td colspan="10">Filter to display data.</td>
              </tr>
            <?php
            } ?>
          </tbody>
        </table>
      </div>
      </div>
    </div>
  </div>
  <div class="col-md-6 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <div class="d-flex justify-content-between">
          <p class="card-title">Sales Report</p>
          <a  href="<?php echo base_url() ?>index.php/client/sales" class="text-info">View all</a>
        </div>
        <div class="table-responsive">
        <table class="table table-striped" id="myTable">
          <thead>
            <tr>
              <th>Product Name</th>
              <th>Customer Name</th>
              <th>Price</th>
              <th>Date</th>
            </tr>
          </thead>
          <tbody id="myTable">
            <?php
            if (!empty($salesreport)) {
              foreach ($salesreport as $sale) : ?>
                <tr>
                  <td><?php echo $sale['product_name']; ?></td>
                  <td><?php echo $sale['customer_name']; ?></td>
                  <td><?php echo $sale['product_price']; ?></td>
                  <td><?php echo date('M d, Y', strtotime($sale['created_at'])); ?></td>
                </tr>
              <?php
              endforeach;
            } else { ?>
              <tr class="text-center">
                <td colspan="10">Filter to display data.</td>
              </tr>
            <?php
            } ?>
          </tbody>
        </table>
      </div>
      </div>
    </div>
  </div>
  <?php include 'part_bottom.php'; ?>