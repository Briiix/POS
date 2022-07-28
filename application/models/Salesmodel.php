<?php 
	class Salesmodel extends CI_model {
		function countAllSales() {
			$this->db->where('is_deleted', 0);
			return $this->db->get('purchases')->num_rows();
		}

		function allSales($limit,$offset){
            $query = "SELECT purchases.id as purchase_id, purchases.*, suppliers.supplier_name, customers.customer_name, products.product_name
            FROM purchases
			LEFT JOIN products ON products.id = purchases.product_id
            LEFT JOIN suppliers ON suppliers.id = products.supplier_id
            LEFT JOIN customers ON customers.id = purchases.customer_id
			WHERE purchases.is_deleted = '0'
			LIMIT $offset, $limit";
			$rs = $this->db->query($query);
			$purchases = $rs->result_array();
			return $purchases;
        }
		
		function deletepurchase($id){
			$this->db->where('id', $id);
			$this->db->set('is_deleted', 1);
			$this->db->update('purchases');
		}

		function updatepaymentstatus($id,$payment_status_id) {
			$this->db->where('id', $id);
			$this->db->set('payment_status_id', $payment_status_id);
			$this->db->update('purchases');
		}

		function show($created_at){
			$query = "SELECT * FROM purchases WHERE DATE(created_at) = '$created_at'";
			$rs = $this->db->query($query);
			$payrolls = $rs->num_rows();
			return $payrolls; 
		}
	
		function search($offset, $limit, $created_at) {
			$query = "SELECT purchases.id as purchase_id, purchases.*, suppliers.supplier_name, customers.customer_name, products.product_name
            FROM purchases
			LEFT JOIN products ON products.id = purchases.product_id
            LEFT JOIN suppliers ON suppliers.id = products.supplier_id
            LEFT JOIN customers ON customers.id = purchases.customer_id
			WHERE CAST(purchases.created_at as DATE) =  '$created_at'
			AND purchases.is_deleted = '0'
			LIMIT $offset, $limit;";
			$rs = $this->db->query($query);
			$payrolls = $rs->result_array();
			return $payrolls;
		}
    }

