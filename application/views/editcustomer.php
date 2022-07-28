<?php include 'part_top.php' ?>

<div class="col-12 grid-margin stretch-card">
	<div class="card">
		<div class="card-body">
			<h4 class="card-title">Edit Customer</h4>
			<form method="post" name="" action="<?php echo base_url() . 'index.php/client/editcustomer/' . $customers['id']; ?>">

				<div class="form-group row">
					<div class="col-md-4">
						<label>Customer Name</label>
						<input type="text" class="form-control" id="customer_name" name="customer_name" value="<?php echo set_value('customer_name', $customers['customer_name']); ?>" class="form-control">
						<span class="text-danger"><?php echo form_error('customer_name'); ?></span>
					</div>
					<div class="col-md-4">
						<label>Contact Number</label>
						<input type="text" class="form-control" id="contact_number" name="contact_number" value="<?php echo set_value('contact_number', $customers['contact_number']); ?>" class="form-control">
						<span class="text-danger"><?php echo form_error('contact_number'); ?></span>
					</div>
					<div class="col-md-4">
						<label>Address</label>
						<input type="text" class="form-control" id="address" name="address" value="<?php echo set_value('address', $customers['address']); ?>" class="form-control">
						<span class="text-danger"><?php echo form_error('address'); ?></span>
					</div>
				</div>

				<!-- Buttons -->
				<div class="d-flex flex-row-reverse mt-3">
					<button class="btn btn-primary">Update</button>&nbsp;
					<a href="<?php echo base_url() . 'index.php/client/customerlist'; ?>" class="btn-secondary btn">Cancel</a>
				</div>
				<!-- Buttons -->
			</form>
		</div>
	</div>
</div>

<?php include 'part_bottom.php' ?>