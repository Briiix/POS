<?php include 'part_top.php' ?>

<div class="col-12 grid-margin stretch-card">
	<div class="card">
		<div class="card-body">
			<h4 class="card-title">Edit Product</h4>
			<form method="post" name="" action="<?php echo base_url() . 'index.php/client/editproduct/' . $product['id']; ?>" enctype="multipart/form-data">

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
					<div class="col-md-6">
						<label>Product Name <span class="text-danger">*</span></label>
						<input type="text" class="form-control" id="product_name" name="product_name" value="<?php echo set_value('product_name', $product['product_name']); ?>" class="form-control">
						<span class="text-danger"><?php echo form_error('product_name'); ?></span>
					</div>
					<div class="col-md-6">
						<label>Supplier Name <span class="text-danger">*</span></label>
						<select class="form-control" name="supplier_id" id="supplier_id">
							<option value="" selected="selected">--Select--</option>
							<?php
							$set_suppliers = set_value('supplier_id');
							if ($set_suppliers != '' && form_error('supplier_id') == '') {
								foreach ($suppliers as $supp) {
									if ($supp['id'] == $set_suppliers) {?>
										<option value="<?php echo $supp['id']; ?>" selected="selected"><?php echo $supp['supplier_name']; ?></option>
									<?php
									} else { ?>
										<option value="<?php echo $supp['id']; ?>"><?php echo $supp['supplier_name']; ?></option>
									<?php
									}
								}
							} elseif (form_error('supplier_id') != '') {
								if (!empty($suppliers)) {
									foreach ($suppliers as $supp) { ?>
										<option value="<?php echo $supp['id']; ?>"><?php echo $supp['supplier_name']; ?></option>
									<?php
									}
								}
							} else {
								foreach ($suppliers as $supp) {
									if ($supp['id'] == $product['supplier_id']) { ?>
										<option value="<?php echo $supp['id']; ?>" selected="selected"><?php echo $supp['supplier_name']; ?></option>
									<?php
									} else {?>
										<option value="<?php echo $supp['id']; ?>"><?php echo $supp['supplier_name']; ?></option>
									<?php
									}
								}
							}?>
						</select>
						<span class="text-danger"><?php echo form_error('supplier_id'); ?></span>
					</div>
				</div>
				<div class="form-group row mt-3">
					<div class="col-md-4">
						<label>Product Price <span class="text-danger">*</span></label>
						<input type="text" class="form-control" id="product_price" name="product_price" value="<?php echo set_value('product_price', $product['product_price']); ?>" class="form-control">
						<span class="text-danger"><?php echo form_error('product_price'); ?></span>
					</div>

					<div class="col-md-4">
						<label>Expiration Date <span class="text-danger">*</span></label>
						<input type="date" class="form-control" id="expiry_date" name="expiry_date" value="<?php echo set_value('expiry_date', $product['expiry_date']); ?>" class="form-control">
						<span class="text-danger"><?php echo form_error('expiry_date'); ?></span>
					</div>

					<!-- Quantity -->
					<div class="col-md-4">
						<label>Quantity <span class="text-danger">*</span></label>
						<input type="number" class="form-control" id="quantity" name="quantity" value="<?php echo set_value('quantity', $product['qty']); ?>">
						<span class="text-danger"><?php echo form_error('quantity'); ?></span>
					</div>
				</div>

				<!-- Buttons -->
				<div class="d-flex flex-row-reverse mt-3">
					<button class="btn btn-primary">Update</button>&nbsp;
					<a href="<?php echo base_url() . 'index.php/client/productlist'; ?>" class="btn-secondary btn">Cancel</a>
				</div>
			</form>
		</div>
	</div>
</div>
<?php include 'part_bottom.php' ?>