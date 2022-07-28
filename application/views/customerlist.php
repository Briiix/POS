<?php include('part_top.php') ?>

<div class="col-lg-12 grid-margin stretch-card">
  <div class="card">
    <div class="card-body">
      <h4 class="card-title">Customer List</h4>
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
        <a href="<?php echo base_url() ?>index.php/client/addCustomer" class="btn btn btn-primary">New Customer</a>
      </div>
      <div class="table-responsive">
        <table class="table table-striped ">
          <thead>
            <tr>
              <th>ID</th>
              <th>Customer Name</th>
              <th>Contact Number</th>
              <th>Address</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            <?php
            if (!empty($customers)) {
              foreach ($customers as $cus) : ?>
                <tr>
                  <td><?php echo $cus['id']; ?></td>
                  <td><?php echo $cus['customer_name']; ?></td>
                  <td><?php echo $cus['contact_number']; ?></td>
                  <td><?php echo $cus['address']; ?></td>

                  <td>
                    <button class="btn"><a href="<?php echo base_url() . 'index.php/client/editcustomer/' . $cus['id'] ?>" rel="tooltip" data-placement="left" title="Edit User"><i class="bi bi-pen-fill"></i></a></button>

                    <a class="p-3 delete-attendance-btn" id="<?php echo $cus['id'] ?>" rel="tooltip" data-placement="left" title="Delete"><i class="bi bi-trash-fill text-danger"></i></a>
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
<div class="modal fade" id="deleteAttendanceConfirmation" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Delete Customer</h5>
      </div>
      <div class="modal-body">
        Are you sure you want to delete this product?
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

    var customer_id;

    $(document).on('click', '.delete-attendance-btn', function() {
      var id = this.id;
      customer_id = id;
      $('#deleteAttendanceConfirmation').modal('show');
    });

    $('#confirm-delete-attendance-btn').on('click', function() {
      $.ajax({
        url: "<?php echo base_url() ?>index.php/client/deletecustomer",
        method: "POST",
        data: {
          customer_id: customer_id
        },
        success: function(response) {
          window.location.href = '<?php echo base_url() ?>index.php/client/customerlist';
        }
      });
    });

  });
</script>
<?php include 'part_bottom.php'; ?>