<?php include('part_top.php') ?>

<div class="col-lg-12 grid-margin stretch-card">
  <div class="card">
    <div class="card-body">
      <h4 class="card-title">Supplier List</h4>
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
        <a href="<?php echo base_url() ?>index.php/client/addsupplier" class="btn btn btn-primary">New Supplier</a>
      </div>
      <div class="table-responsive">
        <table class="table table-striped ">
          <thead>
            <tr>
              <th>ID</th>
              <th>Supplier Name</th>
              <th>Contact Number</th>
              <th>Address</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            <?php
            if (!empty($suppliers)) {
              foreach ($suppliers as $supp) : ?>
                <tr>
                  <td><?php echo $supp['id']; ?></td>
                  <td><?php echo $supp['supplier_name']; ?></td>
                  <td><?php echo $supp['contact_number']; ?></td>
                  <td><?php echo $supp['address']; ?></td>

                  <td>
                    <a href="<?php echo base_url() . 'index.php/client/editsupplier/' . $supp['id'] ?>" rel="tooltip" data-placement="left" title="Edit User"><i class="bi bi-pen-fill"></i></a>

                    <a class="p-3 delete-product-btn" id="<?php echo $supp['id'] ?>" rel="tooltip" data-placement="left" title="Delete"><i class="bi bi-trash-fill text-danger"></i></a>
                  </td>
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
        <h5 class="modal-title" id="exampleModalLongTitle">Delete Supplier</h5>
      </div>
      <div class="modal-body">
        Are you sure you want to delete this supplier?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" aria-label="Close">Cancel</button>
        <button type="button" class="btn btn-danger" id="confirm-delete-attendance-btn">Delete</button>
      </div>
    </div>
  </div>
</div>
<!-- Delete Attendance Confirmation Modal -->

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>

<script>
  $(document).ready(function() {

    var supplier_id;

    $(document).on('click', '.delete-product-btn', function() {
      var id = this.id;
      supplier_id = id;
      $('#deleteProductConfirmation').modal('show');
    });

    $('#confirm-delete-attendance-btn').on('click', function() {
      $.ajax({
        url: "<?php echo base_url() ?>index.php/client/deletesupp",
        method: "POST",
        data: {
          supplier_id: supplier_id
        },
        success: function(response) {
          window.location.href = '<?php echo base_url() ?>index.php/client/supplierlist';
        }
      });
    });

  });
</script>
<?php include 'part_bottom.php'; ?>