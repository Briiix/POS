<?php include 'part_top.php' ?>

<div class="col-12 grid-margin stretch-card">
	<div class="card">
		<div class="card-body">
			<h4 class="card-title">Edit Supplier</h4>
			<form method="post" name="" action="<?php echo base_url() . 'index.php/client/editsupplier/' . $suppliers['id']; ?>">

				<div class="form-group row">
					<div class="col-md-4">
						<label>Supplier Name</label>
						<input type="text" class="form-control" id="supplier_name" name="supplier_name" value="<?php echo set_value('supplier_name', $suppliers['supplier_name']); ?>" class="form-control">
						<span class="text-danger"><?php echo form_error('supplier_name'); ?></span>
					</div>
					<div class="col-md-4">
						<label>Contact Number</label>
						<input type="text" class="form-control" id="contact_number" name="contact_number" value="<?php echo set_value('contact_number', $suppliers['contact_number']); ?>" class="form-control">
						<span class="text-danger"><?php echo form_error('contact_number'); ?></span>
					</div>
					<div class="col-md-4">
						<label>Address</label>
						<input type="text" class="form-control" id="address" name="address" value="<?php echo set_value('address', $suppliers['address']); ?>" class="form-control">
						<span class="text-danger"><?php echo form_error('address'); ?></span>
					</div>
				</div>

				<!-- Buttons -->
				<div class="d-flex flex-row-reverse mt-3">
					<button class="btn btn-primary">Update</button>&nbsp;
					<a href="<?php echo base_url() . 'index.php/client/supplierlist'; ?>" class="btn-secondary btn">Cancel</a>
				</div>
				<!-- Buttons -->
			</form>
		</div>
	</div>
</div>
<?php include 'part_bottom.php' ?>