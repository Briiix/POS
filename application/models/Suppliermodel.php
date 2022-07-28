<?php
class Suppliermodel extends CI_model
{
	function addSupp($formArray)
	{
		$this->db->insert('suppliers', $formArray);
	}

	function countAllProd()
	{
		return $this->db->get('suppliers')->num_rows();
	}

	function allProd($limit, $offset)
	{
		$this->db->WHERE('is_deleted', 0);
		$this->db->limit($limit);
		$this->db->offset($offset);
		return $products = $this->db->get('suppliers')->result_array();
	}

	function getsupplier($id)
	{
		$this->db->where('id', $id);
		return $this->db->get('suppliers')->row_array();
	}

	function updatesupp($id, $suppliers_name, $contact_number, $address)
	{
		$this->db->where('id', $id);
		$this->db->set('supplier_name', $suppliers_name);
		$this->db->set('contact_number', $contact_number);
		$this->db->set('address', $address);
		$this->db->update('suppliers');
	}

	function deletesupp($id)
	{
		$this->db->where('id', $id);
		$this->db->set('is_deleted', 1);
		$this->db->update('suppliers');
	}

	function checkduplicatesupplier($supplier_name) {
		$this->db->where('supplier_name', $supplier_name);
		$query = $this->db->get('suppliers');
		$row_count = $query->num_rows();
		return $row_count;
	}
}
