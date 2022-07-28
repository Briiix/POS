<?php include('part_top.php') ?>

<div class="col-lg-12 grid-margin stretch-card">
  <div class="card">
    <div class="card-body">
      <h4 class="card-title">Account Receivable Reports</h4>
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
        <table class="table table-striped" id="myTable">
          <thead>
            <tr>
              <th>ID</th>
              <th>Customer Name</th>
              <th>Product Name</th>
              <th>Purchase Quantity</th>
              <th>Purchase Price</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody id="myTable">
            <?php
            if (!empty($arr_reports)) {
              foreach ($arr_reports as $arr_report) : ?>
                <tr>
                  <td><?php echo $arr_report['purchase_id']; ?></td>
                  <td><?php echo $arr_report['customer_name']; ?></td>
                  <td><?php echo $arr_report['product_name']; ?></td>
                  <td><?php echo $arr_report['purchase_quantity']; ?></td>
                  <td><?php echo $arr_report['purchase_price']; ?></td>
                  <td>
									<?php
										if($arr_report['payment_status_id'] == '2') {?>
											<a href="<?php echo base_url().'index.php/client/updatepaymentstatus/'.$arr_report['purchase_id']?>" Onclick="return ConfirmApproved();"name="actionapproved"><i class="bi bi-wallet-fill"></i></a>
										<?php
										}?>
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
        <h5 class="modal-title" id="exampleModalLongTitle">Delete</h5>
      </div>
      <div class="modal-body">
        Are you sure you want to delete this record?
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
<link href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css" rel="stylesheet" />
<link href="https://cdn.datatables.net/buttons/2.2.3/css/buttons.dataTables.min.css" rel="stylesheet" />

<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.3/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.print.min.js"></script>

<script>
  $('#myTable').DataTable({
    dom: 'Bfrtip',
    buttons: [
      'excel', 'pdf', 'print'
    ]
  });
</script>
<script>
		function ConfirmApproved() {
			return confirm("Are you sure you want to Mark this as Paid?");
		}
	</script> 
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