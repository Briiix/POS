<?php include('part_top.php') ?>

<div class="col-lg-12 grid-margin stretch-card">
  <div class="card">
    <div class="card-body">
      <h4 class="card-title">Buy Product</h4>
      <div class="row">
        <div class="col-md-12">
          <?php
          $success = $this->session->userdata('success');
          if ($success != "") { ?>
            <div class="alert alert-success">
              <?php echo $success ?>
            </div>
          <?php
          }
          $error = $this->session->userdata('error');
          if ($error != "") { ?>
            <div class="alert alert-danger">
              <?php echo $error ?>
            </div>
          <?php
          } ?>
        </div>
      </div>
      <div class="table-responsive">
        <table class="table table-striped">
          <thead>
            <tr>
              <th>ID</th>
              <th>Product Name</th>
              <th>Supplier</th>
              <th>Price</th>
              <th>Quantity</th>
            </tr>
          </thead>
          <tbody>
            <?php
            if (!empty($products)) {
              foreach ($products as $product) : ?>
                <tr style="cursor:pointer">
                  <td><a href="<?php echo base_url() . 'index.php/client/productdetails/' . $product['product_id'] ?>" style="text-decorations:none; color:inherit;"><?php echo $product['product_id']; ?></a></td>
                  <td><a href="<?php echo base_url() . 'index.php/client/productdetails/' . $product['product_id'] ?>" style="text-decorations:none; color:inherit;"><?php echo $product['product_name']; ?></a></td>
                  <td><a href="<?php echo base_url() . 'index.php/client/productdetails/' . $product['product_id'] ?>" style="text-decorations:none; color:inherit;"><?php echo $product['supplier_name']; ?></a></td>
                  <td><a href="<?php echo base_url() . 'index.php/client/productdetails/' . $product['product_id'] ?>" style="text-decorations:none; color:inherit;"><?php echo $product['product_price']; ?></a></td>
                  <td><a href="<?php echo base_url() . 'index.php/client/productdetails/' . $product['product_id'] ?>" style="text-decorations:none; color:inherit;"><?php echo $product['qty']; ?></a></td>
                </tr>
              <?php
              endforeach;
            } else { ?>
              <tr class="text-center">
                <td colspan="10">No Records Found.</td>
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