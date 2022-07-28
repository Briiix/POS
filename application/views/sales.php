<?php include('part_top.php') ?>

<div class="col-lg-12 grid-margin stretch-card">
  <div class="card">
    <div class="card-body">
      <h4 class="card-title">Sales Reports</h4>
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

          <div class="col-md-3">
            <label class="form-label">Search Date:</label>
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
              <th>Action</th>
            </tr>
          </thead>
          <tbody id="myTable">
            <?php
            if (!empty($sales)) {
              foreach ($sales as $sale) : ?>
                <tr>
                  <td><?php echo $sale['purchase_id']; ?></td>
                  <td><?php echo $sale['customer_name']; ?></td>
                  <td><?php echo $sale['product_name']; ?></td>
                  <td><?php echo $sale['supplier_name']; ?></td>
                  <td><?php echo $sale['purchase_quantity']; ?></td>
                  <td><?php echo $sale['purchase_price']; ?></td>
                  <td><?php echo $sale['created_at']; ?></td>

                  <td>
                    <a class="p-3 delete-purchase-btn" id="<?php echo $sale['purchase_id'] ?>" rel="tooltip" data-placement="left" title="Delete"><i class="bi bi-trash-fill text-danger"></i></a>
                  </td>

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
        <!-- Pagination Links -->
				<div class="d-flex flex-row-reverse mt-2">
					<?php
					echo $this->pagination->create_links();?>
				</div>
				<!-- Pagination Links -->
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="deletePurchaseConfirmation" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
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
        <button type="button" class="btn btn-danger" id="confirm-delete-purchase-btn">Delete</button>
      </div>
    </div>
  </div>
</div>
<!-- Delete Attendance Confirmation Modal -->

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
    "paging": false,
    "ordering": false,
    "info": false,
    "scrollY": false,
    dom: 'Bfrtip',
    buttons: [
      'excel', 'pdf', 'print'
    ]
  });
</script>

<script>
  $(document).ready(function() {

    var purchase_id;

    $(document).on('click', '.delete-purchase-btn', function() {
      var id = this.id;
      purchase_id = id;
      $('#deletePurchaseConfirmation').modal('show');
    });

    $('#confirm-delete-purchase-btn').on('click', function() {
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
  if (created_at != '') {
    var dataTable = $('#myTable').DataTable({
      "processing": true,
      "serverSide": true,
      "$.ajax": {
        url: "<?php echo base_url() ?>index.php/client/search",
        type: "POST",
        data: {
          created_at: created_at
        },
        success: function(data) {
          alert(id);
          $('#myTable').html(data);
        }
      }
    });
  } else {
    alert("Empty");
  }

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