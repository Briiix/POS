<?php
class Productmodel extends CI_model
{
	function addproduct($formArray)
	{
		$this->db->insert('products', $formArray);
	}

	public function checkduplicateproduct($product_name) 
	{
		$this->db->where('product_name', $product_name);
		$query = $this->db->get('products');
		$row_count = $query->num_rows();
		return $row_count;
	}

	function countallproducts()
	{
		return $this->db->get('products')->num_rows();
	}

	function allproducts($offset, $limit)
	{
		$query = "SELECT p.id as product_id, p.product_name, s.supplier_name, p.product_price, p.expiry_date, p.qty
		FROM products p
		LEFT JOIN suppliers s ON s.id = p.supplier_id
		WHERE p.is_deleted = '0'
		LIMIT $offset, $limit;";
		$rs = $this->db->query($query);
		$prod = $rs->result_array();
		return $prod;
	}

	function updateproduct($id, $product_name, $supplier_id, $product_price, $expiry_date, $quantity)
	{
		$this->db->where('id', $id);
		$this->db->set('product_name', $product_name);
		$this->db->set('supplier_id', $supplier_id);
		$this->db->set('product_price', $product_price);
		$this->db->set('expiry_date', $expiry_date);
		$this->db->set('qty', $quantity);
		$this->db->update('products');
	}

	function deleteproduct($id)
	{
		$this->db->where('id', $id);
		$this->db->set('is_deleted', 1);
		$this->db->update('products');
	}

	function getsuppliers()
	{
		$query = "SELECT * FROM suppliers";
		$rs = $this->db->query($query);
		$supp = $rs->result_array();
		return $supp;
	}

	function getproduct($id)
	{
		$this->db->where('id', $id);
		return $this->db->get('products')->row_array();
	}
}
