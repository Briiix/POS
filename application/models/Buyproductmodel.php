<?php
date_default_timezone_set('Asia/Manila');
class Buyproductmodel extends CI_model
{

	function countallproducts()
	{
		return $this->db->get('products')->num_rows();
	}

	function allproducts($offset, $limit)
	{
		$today = date('Y-m-d');
		$query = "SELECT p.id as product_id, p.product_name, s.supplier_name, p.product_price, p.qty
			FROM products p
			LEFT JOIN suppliers s ON s.id = p.supplier_id
			WHERE p.qty != '0'
			AND p.expiry_date >= '$today'
			LIMIT $offset, $limit";
		$rs = $this->db->query($query);
		$products = $rs->result_array();
		return $products;
	}

	function countcollectionreports()
	{
		$query = "SELECT *
			FROM purchases
			WHERE payment_status_id = '1'
			AND payment_method_id = '2'
			AND is_deleted = '0'";
		$rs = $this->db->query($query);
		$collection_reports_count = $rs->num_rows();
		return $collection_reports_count;
	}

	function allcollectionreports($offset, $limit)
	{
		$query = "SELECT pu.id as purchase_id, c.customer_name, pr.product_name, s.supplier_name, pu.purchase_quantity, pu.purchase_price, pu.created_at
			FROM purchases pu
			LEFT JOIN customers c ON c.id = pu.customer_id
			LEFT JOIN products pr ON pr.id = pu.product_id
			LEFT JOIN payment_status ps ON ps.id = pu.payment_status_id
			LEFT JOIN suppliers s ON s.id = pr.supplier_id
			WHERE pu.payment_status_id = '1'
			AND pu.payment_method_id = '2'
			AND pu.is_deleted = '0'
			LIMIT $offset, $limit";
		$rs = $this->db->query($query);
		$prod = $rs->result_array();
		return $prod;
	}

	function countallarr()
	{
		return $this->db->get('purchases')->num_rows();
	}

	function allarr($offset, $limit)
	{
		$query = "SELECT pu.id as purchase_id, c.customer_name, pr.product_name, pu.purchase_quantity, pu.purchase_price, pu.payment_status_id
			FROM purchases pu
			LEFT JOIN customers c ON c.id = pu.customer_id
			LEFT JOIN products pr ON pr.id = pu.product_id
			LEFT JOIN payment_status ps ON ps.id = pu.payment_status_id
			WHERE pu.payment_status_id = '2'
			AND pu.payment_method_id = '2'
			AND pu.is_deleted = '0'
			LIMIT $offset, $limit";
		$rs = $this->db->query($query);
		$arrs = $rs->result_array();
		return $arrs;
	}

	function buyproduct($product_id, $quantity, $payment_method_id, $payment_status_id, $customer_id, $purchased_price, $new_quantity)
	{
		$query = "INSERT INTO purchases (product_id, purchase_quantity, payment_method_id, payment_status_id, customer_id, purchase_price)
		VALUES ('$product_id', '$quantity', '$payment_method_id', '$payment_status_id', '$customer_id', '$purchased_price')";
		$this->db->query($query);

		$query = "UPDATE products
		SET qty = '$new_quantity'
		WHERE id = '$product_id'";
		$this->db->query($query);
	}

	function getpaymentmethods()
	{
		$query = "SELECT * FROM payment_methods";
		$rs = $this->db->query($query);
		$payment_methods = $rs->result_array();
		return $payment_methods;
	}

	function getcustomers()
	{
		$query = "SELECT * FROM customers";
		$rs = $this->db->query($query);
		$customers = $rs->result_array();
		return $customers;
	}

	function productdetails($id)
	{
		$query = "SELECT *
			FROM products
			WHERE id = '$id'";
		$rs = $this->db->query($query);
		$product = $rs->row_array();
		return $product;
	}
}
