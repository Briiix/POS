<?php
class Customermodel extends CI_model
{
	function addcustomer($formArray)
	{
		$this->db->insert('customers', $formArray);
	}
	
	function countAllProd()
	{
		return $this->db->get('customers')->num_rows();
	}

	function allProd($limit, $offset)
	{
		$this->db->WHERE('is_deleted', 0);
		$this->db->limit($limit);
		$this->db->offset($offset);
		return $products = $this->db->get('customers')->result_array();
	}

	function getcustomer($id)
	{
		$this->db->where('id', $id);
		return $this->db->get('customers')->row_array();
	}
	
	function updatecus($id, $customer_name, $contact_number, $address)
	{
		$this->db->where('id', $id);
		$this->db->set('customer_name', $customer_name);
		$this->db->set('contact_number', $contact_number);
		$this->db->set('address', $address);
		$this->db->update('customers');
	}

	function deletecus($id)
	{
		$this->db->where('id', $id);
		$this->db->set('is_deleted', 1);
		$this->db->update('customers');
	}

	function checkduplicatecustomer($customer_name) {
		$this->db->where('customer_name', $customer_name);
		$query = $this->db->get('customers');
		$row_count = $query->num_rows();
		return $row_count;
	}
}
