<?php
class Dashboardmodel extends CI_Model {

    function getproducts(){
        $query = "SELECT *
        FROM products
        WHERE is_deleted = '0'";
        $rs = $this->db->query($query);
        $products = $rs->result_array();
        return $products;
    }

    function getproductcount() {
        $query = "SELECT *
        FROM products
        WHERE is_deleted = '0'";
        $rs = $this->db->query($query);
        $productscount = $rs->num_rows();
        return $productscount;
    }

    function getcustomercount() {
        $query = "SELECT *
        FROM customers
        WHERE is_deleted = '0'";
        $rs = $this->db->query($query);
        $customerscount = $rs->num_rows();
        return $customerscount;
    }

    function getsales() {
        $query = "SELECT *
        FROM purchases
        WHERE is_deleted = '0'";
        $rs = $this->db->query($query);
        $sales = $rs->result_array();
        return $sales;
    }
    function allSales(){
        $query = "SELECT purchases.id as purchase_id, purchases.*, suppliers.supplier_name, customers.customer_name, products.product_name, products.product_price
        FROM purchases
        LEFT JOIN products ON products.id = purchases.product_id
        LEFT JOIN suppliers ON suppliers.id = products.supplier_id
        LEFT JOIN customers ON customers.id = purchases.customer_id
        WHERE purchases.is_deleted = '0'
        AND purchases.is_deleted = '0'
        ORDER BY purchases.id DESC
        LIMIT 5";
        $rs = $this->db->query($query);
        $prod = $rs->result_array();
        return $prod;
    }

    function allARR(){
        $query = "SELECT purchases.id as purchase_id, purchases.*, customers.customer_name, products.product_name, products.product_price, payment_status.status as payment_status
        FROM purchases
        LEFT JOIN customers ON customers.id = purchases.customer_id
        LEFT JOIN products ON products.id = purchases.product_id
        LEFT JOIN payment_status ON payment_status.id = purchases.payment_status_id
        WHERE purchases.payment_status_id = '2'
        AND purchases.is_deleted = '0'
        ORDER BY purchases.id DESC
        LIMIT 5";
        $rs = $this->db->query($query);
        $prod = $rs->result_array();
        return $prod;
    }

}
