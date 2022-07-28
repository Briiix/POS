<?php include('part_top.php') ?>

<div class="col-lg-12 grid-margin stretch-card">
  <div class="card">
    <div class="card-body">
      <h4 class="card-title">Collection Reports</h4>
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

      <!-- Date Filter -->
      <form action="<?php echo base_url() ?>index.php/client/search" method="post">
        <div class="row g-3">

          <div class="col-md-2">
            <label class="form-label">Date From:</label>
            <input type="date" class="form-control" name="created_at" id="created_at" value="<?php echo set_value('created_at'); ?>" required>
          </div>
          <div class="col-md-2 mt-3">
            <button type="submit" class="btn btn-primary" style="margin: 10px;">Filter</button>
          </div>
        </div>
        </br>
      </form>
      <!--Date Filter-->

      <div class="table-responsive">
        <table class="table table-striped " id="myTable">
          <thead>
            <tr>
              <th>ID</th>
              <th>Customer Name</th>
              <th>Product Name</th>
              <th>Supplier Name</th>
              <th>Purchase Quantity</th>
              <th>Purchase Price</th>
              <th>Date</th>
            </tr>
          </thead>
          <tbody id="myTable">
            <?php
            if (!empty($collection_reports)) {
              foreach ($collection_reports as $collection_report) : ?>
                <tr>
                  <td><?php echo $collection_report['purchase_id']; ?></td>
                  <td><?php echo $collection_report['customer_name']; ?></td>
                  <td><?php echo $collection_report['product_name']; ?></td>
                  <td><?php echo $collection_report['supplier_name']; ?></td>
                  <td><?php echo $collection_report['purchase_quantity']; ?></td>
                  <td><?php echo $collection_report['purchase_price']; ?></td>
                  <td><?php echo date('M d, Y H:i A', strtotime($collection_report['created_at'])); ?></td>
                </tr>
              <?php
              endforeach;
            } else { ?>
              <tr class="text-center">
                <td colspan="10">No Records Found</td>
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
        <h5 class="modal-title" id="exampleModalLongTitle">Delete Attendance</h5>
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
  $(document).ready(function() {

    var purchase_id;

    $(document).on('click', '.delete-attendance-btn', function() {
      var id = this.id;
      purchase_id = id;
      $('#deleteAttendanceConfirmation').modal('show');
    });

    $('#confirm-delete-attendance-btn').on('click', function() {
      $.ajax({
        url: "<?php echo base_url() ?>index.php/client/deletepurchase",
        method: "POST",
        data: {
          purchase_id: purchase_id
        },
        success: function(response) {
          window.location.href = '<?php echo base_url() ?>index.php/client/sales';
        }
      });
    });

  });
</script>

<script>
  function myFunction() {
    var input, filter, table, tr, td, i, txtValue;
    input = document.getElementById("myInput");
    filter = input.value.toUpperCase();
    table = document.getElementById("myTable");
    tr = table.getElementsByTagName("tr");
    for (i = 1; i < tr.length; i++) {
      td = tr[i].getElementsByTagName("td")[1];
      if (td) {
        txtValue = td.textContent || td.innerText;
        if (txtValue.toUpperCase().indexOf(filter) > -1) {
          tr[i].style.display = "";
        } else {
          tr[i].style.display = "none";
        }
      }
    }
  }
</script>

<?php include 'part_bottom.php'; ?>