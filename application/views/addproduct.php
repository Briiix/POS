<?php include 'part_top.php' ?>

<div class="col-12 grid-margin stretch-card">
  <div class="card">
    <div class="card-body">
      <h4 class="card-title">Add New Products</h4>
      <form class="forms-sample" method="POST" action="<?php echo base_url() . 'index.php/client/addproduct'; ?>" enctype="multipart/form-data">

        <!-- Alerts -->
        <div class="row">
          <div class="col-md-12">
            <?php
            if ($upload_error != "") { ?>
              <div class="alert alert-danger">
                <?php echo $upload_error ?>
              </div>
            <?php
            } ?>
          </div>
        </div>
        <!-- Alerts -->

        <?php echo form_open_multipart('client/addproduct'); ?>

        <div class="form-group row">
          <!-- Product Name -->
          <div class="col-md-6">
            <?php
            $set_product_name = '';
            if(form_error('product_name') == '') {
              $set_product_name = set_value('product_name');
            }?>
            <label>Product Name <span class="text-danger">*</span></label>
            <input type="text" class="form-control" id="product_name" name="product_name" value="<?php echo $set_product_name ?>">
            <span class="text-danger"><?php echo form_error('product_name'); ?></span>
          </div>

          <!-- Supplier Name -->
          <div class="col-md-6">
            <label>Supplier Name <span class="text-danger">*</span></label>
            <select class="form-control" name="supplier_id" id="supplier_id">
              <option value="" selected="selected">--Select--</option>
              <?php
              $set_suppliers = set_value('supplier_id');
              if ($set_suppliers != '' && form_error('suppliers') == '') {
                foreach ($suppliers as $supplier) {
                  if ($supplier['id'] == $set_suppliers) { ?>
                    <option value="<?php echo $supplier['id']; ?>" selected="selected"><?php echo $supplier['supplier_name']; ?></option>
                  <?php
                  } else { ?>
                    <option value="<?php echo $supplier['id']; ?>"><?php echo $supplier['supplier_name']; ?></option>
                  <?php
                  }
                }
              } else {
                if (!empty($suppliers)) {
                  foreach ($suppliers as $supplier) { ?>
                    <option value="<?php echo $supplier['id']; ?>"><?php echo $supplier['supplier_name']; ?></option>
                  <?php
                  }
                }
              } ?>
            </select>
            <span class="text-danger"><?php echo form_error('supplier_id'); ?></span>
          </div>
        </div>

        <div class="form-group row mt-3">
          <!-- Product Price -->
          <div class="col-md-4">
            <label>Product Price <span class="text-danger">*</span></label>
            <input type="text" class="form-control" id="product_price" name="product_price" placeholder="Price">
            <span class="text-danger"><?php echo form_error('product_price'); ?></span>
          </div>

          <!-- Expiration Date -->
          <div class="col-md-4">
            <label>Expiration Date <span class="text-danger">*</span></label>
            <input type="date" class="form-control" id="expiry_date" name="expiry_date">
            <span class="text-danger"><?php echo form_error('expiry_date'); ?></span>
          </div>

          <!-- Quantity -->
          <div class="col-md-4">
            <label>Quantity <span class="text-danger">*</span></label>
            <input type="number" class="form-control" id="quantity" name="quantity">
            <span class="text-danger"><?php echo form_error('quantity'); ?></span>
          </div>
        </div>

        <div class="form-group row mt-3">
          <!-- Product Image -->
          <div class="col-md-12">
            <label>Product Image <span class="text-danger">*</span></label>
            <input name="product_image" id="product_image" type="file" class="form-control" accept="image/jpeg">
            <span class="text-danger"><?php echo form_error('product_image'); ?></span>
          </div>
        </div>

        <!-- Submit Button -->
        <div class="d-flex flex-row-reverse md-3">
          <button type="submit" class="btn btn-primary mr-2">Submit</button> &nbsp;&nbsp;&nbsp;
          <a href="<?php echo base_url() . 'index.php/client/productlist'; ?>" class="btn-secondary btn">Cancel</a>
        </div>
      </form>
    </div>
  </div>
</div>

<?php include 'part_bottom.php' ?>