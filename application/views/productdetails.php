<?php include('part_top.php') ?>

<div class="col-lg-12 grid-margin stretch-card">
	<div class="card">
		<div class="card-body">
			<h4 class="card-title">
				Product Details
			</h4>
			<form>
				<div class="form-group row">
					<div class="col-md-6">
						<img src="<?php echo base_url() ?>assets/product_images/<?php echo $product['image'] ?>" class="card card-background" style="background-image" alt="Product Image" height="430px" width="430px">
					</div>
					<div class="col-md-6">
						<h4 class="title" id="<?php echo $product['id'] ?>"><?php echo $product['product_name'] ?></h4>
						<h3 class="title"><span>&#8369;</span> <?php echo $product['product_price'] ?></h3>
					</div>
				</div>
				<div class="d-flex flex-row-reverse mb-2">
					<a href="<?php echo base_url() . 'index.php/client/buyproductlist'; ?>" class="btn btn-secondary btn-rounded">Cancel</a>

					&nbsp;<a href="#" class="btn btn-primary btn-rounded exampleModal" data-id="<?= $product['id']; ?>" data-product_name="<?= $product['product_name']; ?>" data-product_price="<?= $product['product_price']; ?>" data-supplier_id="<?= $product['supplier_id']; ?>">Buy</a>
				</div>
			</form>
		</div>
	</div>
</div>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Product Details</h5>
			</div>
			<div class="modal-body">
				<div class="form-group row">
					<div class="col-md-6">
						<label>Product Name <span class="text-danger">*</span></label>
						<input type="text" id="product_name" class="form-control" readonly>
					</div>
					<div class="col-md-6">
						<label>Price <span class="text-danger">*</span></label>
						<input type="text" id="product_price" class="form-control" readonly>
					</div>
				</div>
				<div class="form-group row mt-3">
					<div class="col-md-4">
						<?php
						$set_quantity = '';
						if (form_error('quantity') == '') {
							$set_quantity = set_value('quantity');
						} ?>
						<label>Quantity <span class="text-danger">*</span></label>
						<input type="number" name="quantity" id="quantity" class="form-control" min="1" max="<?php echo $product['qty'] ?>" value="<?php echo $set_quantity ?>">
						<span class="text-danger" id="quantity_error"></span>
					</div>
					<div class="col-md-4">
						<label>Payment Method <span class="text-danger">*</span></label>
						<select class="form-control" name="payment_method_id" id="payment_method_id" required>
							<option value="">--Select--</option>
							<?php foreach ($payment_methods as $payment_method) : ?>
								<option value="<?php echo $payment_method['id']; ?>"><?php echo $payment_method['method']; ?></option>
							<?php endforeach; ?>
						</select>
						<span class="text-danger" id="payment_method_id_error"></span>
					</div>
					<div class="col-md-4">
						<label>Customer Name <span class="text-danger">*</span></label>
						<select class="form-control" name="customer_id" id="customer_id" required>
							<option value="">--Select--</option>
							<?php foreach ($customers as $customer) : ?>
								<option value="<?php echo $customer['id']; ?>"><?php echo $customer['customer_name']; ?></option>
							<?php endforeach; ?>
						</select>
						<span class="text-danger" id="customer_id_error"></span>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" id="close_btn" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
				<button type="submit" id="add_btn" class="btn btn-primary add_btn">Proceed</button>
			</div>
		</div>
	</div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>

<script>
	$(document).ready(function() {

		var product_id;
		var product_price;

		$("#customer_id").attr("disabled", "disabled");

		$('.exampleModal').on('click', function() {
			// get data from button edit
			const id = $(this).data('id');
			const product_name = $(this).data('product_name');
			const price = $(this).data('product_price');

			product_id = id;
			product_price = price;
			// Set data to Form Edit
			$('#product_name').val(product_name);
			$('#product_price').val(price);

			// Call Modal Edit
			$('#exampleModal').modal('show');
		});

		$('#payment_method_id').on('click', function() {
			if($('#payment_method_id').val() == '2') {
				$("#customer_id").removeAttr("disabled");
			} else {
				$("#customer_id").attr("disabled", "disabled");
			}
		});

		$('#add_btn').on('click', function() {
			var id = product_id;
			var quantity = $('#quantity').val();
			var customer_id = $('#customer_id').val();
			var payment_method_id = $('#payment_method_id').val();
			var old_quantity = <?php echo $product['qty'] ?>;

			$.ajax({
				url: '<?php echo base_url() ?>index.php/client/buyproduct',
				method: 'POST',
				data: {
					product_id: product_id,
					product_price: product_price,
					quantity: quantity,
					customer_id: customer_id,
					payment_method_id: payment_method_id,
					old_quantity: old_quantity
				},
				success: function(resp) {
					rs = JSON.parse(resp);

					if (rs.error === true) {
						$('#quantity_error').html(rs.quantity_error);
						$('#payment_method_id_error').html(rs.payment_method_id_error);
						$('#customer_id_error').html(rs.customer_id_error);
					} else if (rs.error === false) {
						window.location.href = '<?php echo base_url("index.php/client/buyproductlist") ?>';
					}
				}
			});
		});

	});
</script>

<?php include 'part_bottom.php'; ?>