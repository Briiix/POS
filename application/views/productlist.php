<?php include('part_top.php') ?>

<div class="col-lg-12 grid-margin stretch-card">
  <div class="card">
    <div class="card-body">
      <h4 class="card-title">Product List</h4>
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
      <div class="d-flex flex-row-reverse mb-2">
        <a href="<?php echo base_url() ?>index.php/client/addproduct" class="btn btn btn-primary">New Product</a>
      </div>
      <div class="table-responsive">
        <table class="table table-striped">
          <thead>
            <tr>
              <th>ID</th>
              <th>Product Name</th>
              <th>Supplier</th>
              <th>Price</th>
              <th>Expiration Date</th>
              <th>Quantity</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            <?php
            if (!empty($products)) {
              foreach ($products as $product) : ?>
                <tr>
                  <td><?php echo $product['product_id']; ?></td>
                  <td><?php echo $product['product_name']; ?></td>
                  <td><?php echo $product['supplier_name']; ?></td>
                  <td><?php echo $product['product_price']; ?></td>
                  <td><?php echo date("M d, Y", strtotime($product['expiry_date'])); ?></td>
                  <td><?php echo $product['qty']; ?></td>

                  <td>
                    <!-- Edit -->
                    <a href="<?php echo base_url() . 'index.php/client/editproduct/' . $product['product_id'] ?>" rel="tooltip" data-placement="left" title="Edit User"><i class="bi bi-pen-fill"></i></a>
                    <!-- Delete -->
                    <a class="p-3 delete-product-btn" id="<?php echo $product['product_id'] ?>" rel="tooltip" data-placement="left" title="Delete"><i class="bi bi-trash-fill text-danger"></i></a>
                  </td>
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

<div class="modal fade" id="deleteProductConfirmation" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Delete Product</h5>
      </div>
      <div class="modal-body">
        Are you sure you want to delete this product?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" aria-label="Close">Cancel</button>
        <button type="button" class="btn btn-danger" id="confirm-delete-product-btn">Delete</button>
      </div>
    </div>
  </div>
</div>
<!-- Delete Attendance Confirmation Modal -->

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>

<script>
  $(document).ready(function() {

    var product_id;

    $('.delete-product-btn').on('click', function(e) {
      e.preventDefault();
      var id = this.id;
      product_id = id;
      $('#deleteProductConfirmation').modal('show');
    });

    $('#confirm-delete-product-btn').on('click', function(e) {
      e.preventDefault();
      $.ajax({
        url: "<?php echo base_url() ?>index.php/client/deleteproduct",
        method: "POST",
        data: {product_id: product_id},
        success: function(response) {
          window.location.href = '<?php echo base_url() ?>index.php/client/productlist';
        }
      });
    });

  });
</script>
<?php include 'part_bottom.php'; ?>