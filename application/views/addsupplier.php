<?php include 'part_top.php' ?>

<div class="col-12 grid-margin stretch-card">
  <div class="card">
    <div class="card-body">
      <h4 class="card-title">Add New Suppliers</h4>

      <form class="forms-sample" method="POST" action="<?php echo base_url() . 'index.php/client/addsupplier'; ?>">

        <div class="form-group row">
          <div class="col-md-4">
            <?php
            $set_supplier_name = '';
            if(form_error('supplier_name') == '') {
              $set_supplier_name = set_value('supplier_name');
            }?>
            <label>Supplier Name</label>
            <input type="text" class="form-control" id="supplier_name" name="supplier_name" value="<?php echo $set_supplier_name ?>">
            <span class="text-danger"><?php echo form_error('supplier_name'); ?></span>
          </div>
          <div class="col-md-4">
            <label>Contact Number</label>
            <input type="text" class="form-control" id="contact_number" name="contact_number" value="<?php echo set_value('contact_number') ?>">
            <span class="text-danger"><?php echo form_error('contact_number'); ?></span>
          </div>
          <div class="col-md-4">
            <label>Address</label>
            <input type="text" class="form-control" id="address" name="address" value="<?php echo set_value('address') ?>">
            <span class="text-danger"><?php echo form_error('address'); ?></span>
          </div>
        </div>

        <div class="d-flex flex-row-reverse md-3">
          <button type="submit" class="btn btn-primary mr-2">Submit</button> &nbsp;&nbsp;&nbsp;
          <a href="<?php echo base_url() . 'index.php/client/customerlist'; ?>" class="btn-secondary btn">Cancel</a>
        </div>
      </form>
    </div>
  </div>
</div>

<?php include 'part_bottom.php' ?>