<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Client extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->helper('html');
		$this->load->helper('url');
		$this->load->helper('text');
		$this->load->helper('file');
		$this->load->library('session');
		$this->load->library('pagination');
		$this->load->library('form_validation');

		$this->load->model('authmodel');
		$this->load->model('dashboardmodel');
		$this->load->model('productmodel');
		$this->load->model('customermodel');
		$this->load->model('suppliermodel');
		$this->load->model('salesmodel');
		$this->load->model('buyproductmodel');
	}

	public function index()
	{ // Index page
		$this->load->view('login');
	}

	public function login()
	{ // Login
		$username = $this->input->post('username');
		$password = $this->input->post('password');
		$this->form_validation->set_rules('username', 'username', 'required');
		$this->form_validation->set_rules('password', 'password', 'required');
		if ($this->form_validation->run() == FALSE) {
			$form_error = array(
				'username' => form_error('username'),
				'password' => form_error('password'),
				'error' => TRUE
			);
			echo json_encode($form_error);
		} else {
			$result = $this->authmodel->validate($username, $password);
			if ($result == 1) {
				$user = $this->authmodel->getuser($username, $password);

				$user_data = array(
					'role_id' => $user['role_id'],
					'is_user' => TRUE
				);
				echo json_encode($user_data);

				$ses_data = array(
					'role_id' => $user['role_id'],
					'user_id' => $user['user_id'],
					'role' => $user['role'],
					'is_user' => TRUE
				);
				$this->session->set_userdata($ses_data);
			} else {
				$user = array(
					'invalid_user' => 'Invalid user',
					'is_user' => FALSE
				);
				echo json_encode($user);
			}
		}
	}
	
	public function logout()
	{ // Logout
		$this->session->sess_destroy();
		redirect('client/index');
	}

	public function dashboard()
	{
		$products = $this->dashboardmodel->getproducts();
		$productscount = $this->dashboardmodel->getproductcount();
		$customerscount = $this->dashboardmodel->getcustomercount();
		$sales = $this->dashboardmodel->getsales();
		$salesreport = $this->dashboardmodel->allSales();
		$accountrecievablereports = $this->dashboardmodel->allARR();

		$product_to_expire = 0;
		$today = date('m');

		foreach($products as $product) {
			$product_expiry_date = date('m', strtotime($product['expiry_date']));
			if($product_expiry_date == $today) {
				$product_to_expire += 1;
			}
		}

		$sales_this_month = 0;
		
		foreach($sales as $sale) {
			$month_sales = date('m', strtotime($sale['created_at']));
			if($month_sales == $today) {
				$sales_this_month += 1;
			}
		}

		$data = array();
		$data['accountrecievablereports'] = $accountrecievablereports;
		$data['salesreport'] = $salesreport;
		$data['product_to_expire'] = $product_to_expire;
		$data['productscount'] = $productscount;
		$data['customerscount'] = $customerscount;
		$data['sales_this_month'] = $sales_this_month;
		$this->load->view('dashboard', $data);
	}

	public function productlist($offset = 0)
	{
		$config['base_url'] = site_url('index.php/client/productlist/');
		$config['total_rows'] = $this->productmodel->countallproducts();
		$config['per_page'] = 10;
		$config['full_tag_open'] = '<ul class="pagination">';
		$config['first_tag_open'] = '<li class="page-item"><span class="page-link">';
		$config['first_tag_close'] = '</span></li>';
		$config['prev_link'] = '&laquo';
		$config['prev_tag_open'] = '<li class="page-item"><span class="page-link">';
		$config['prev_tag_close'] = '</span></li>';
		$config['next_link'] = '&raquo';
		$config['next_tag_open'] = '<li class="page-item"><span class="page-link">';
		$config['next_tag_close'] = '</span></li>';
		$config['last_tag_open'] = '<li class="page-item"><span class="page-link">';
		$config['last_tag_close'] = '</span></li>';
		$config['cur_tag_open'] = '<li class="page-item active"><span class="page-link">';
		$config['cur_tag_close'] = '</span></li>';
		$config['num_tag_open'] = '<li class="page-item"><span class="page-link">';
		$config['num_tag_close'] = '</span></li>';
		$config['full_tag_close'] = '</ul>';

		$this->pagination->initialize($config);
		$products = $this->productmodel->allproducts($offset, $config['per_page']);

		$data = array();
		$data['products'] = $products;

		$this->load->view('productlist', $data);
	}

	public function addproduct()
	{
		$config['allowed_types'] = 'jpg|jpeg'; // File Extensions
		$config['upload_path'] = './assets/product_images/'; // Upload Path

		$this->load->library('upload', $config);

		$this->load->model('productmodel');

		$data = array();
		$data['upload_error'] = "";
		$data['suppliers'] = $this->productmodel->getsuppliers();

		$this->form_validation->set_rules('product_name', '', 'callback_check_product');
		$this->form_validation->set_rules('supplier_id', 'supplier', 'required');
		$this->form_validation->set_rules('product_price', 'product price', 'required');
		$this->form_validation->set_rules('expiry_date', 'expiration date', 'required');
		$this->form_validation->set_rules('quantity', 'quantity', 'required');
		$this->form_validation->set_rules('product_image', '', 'callback_check_file');

		if ($this->form_validation->run() == false) {
			$this->load->view('addproduct', $data);
		} else {
			if (!$this->upload->do_upload('product_image')) { // Check if the file uploading is unsuccessful
				$data['upload_error'] = $this->upload->display_errors();
				$this->load->view('addproduct', $data);
			} else {
				$file = $this->upload->data();
				$file_name = $file['file_name'];

				$formArray = array();
				$formArray['product_name'] = $this->input->post('product_name');
				$formArray['qty'] = $this->input->post('quantity');
				$formArray['supplier_id'] = $this->input->post('supplier_id');
				$formArray['product_price'] = $this->input->post('product_price');
				$formArray['expiry_date'] = $this->input->post('expiry_date');
				$formArray['image'] = $file_name;

				$this->productmodel->addproduct($formArray);
				$this->session->set_flashdata('success', 'Record added Successfully');
				$this->session->mark_as_temp('success', 3);
				redirect(base_url() . 'index.php/client/productlist');
			}
		}
	}

	public function check_product($product_name) 
    {
		$product_name = $this->input->post('product_name');

		if($product_name === '') {
			$this->form_validation->set_message('check_product', 'The product name field is required.');
			return false;
		}

		$result = $this->productmodel->checkduplicateproduct($product_name);

		if($result > 0) {
			$this->form_validation->set_message('check_product', 'Product name already exists.');
			return false;
		} else {
			return true;
		}
    }

	public function check_file($str)
	{ // File Uploading Form Validation
		$allowed_mime_type_arr = array('image/jpg', 'image/jpeg');
		$mime = get_mime_by_extension($_FILES['product_image']['name']);
		if (isset($_FILES['product_image']['name']) && $_FILES['product_image']['name'] != '') {
			if (in_array($mime, $allowed_mime_type_arr)) {
				return true;
			} else {
				$this->form_validation->set_message('check_file', 'Invalid Product Image.');
				return false;
			}
		} else {
			$this->form_validation->set_message('check_file', 'The product image field is required.');
			return false;
		}
	}

	public function editproduct($id)
	{ // Edit Role
		$config['allowed_types'] = 'jpg|jpeg'; // File Extensions
		$config['upload_path'] = './assets/product_images/'; // Upload Path

		$this->load->library('upload', $config);

		$product = $this->productmodel->getproduct($id);

		$data = array();
		$data['menu_item_dashboard'] = 'menu-item';
		$data['menu_item_employee'] = 'menu-item';
		$data['menu_item_timekeeping'] = 'menu-item';
		$data['menu_item_payroll'] = 'menu-item';
		$data['menu_item_billing'] = 'menu-item';
		$data['menu_item_inventory'] = 'menu-item';
		$data['menu_item_reference_table'] = 'menu-item';
		$data['menu_item_settings'] = 'menu-item active';

		$data['upload_error'] = "";
		$data['suppliers'] = $this->productmodel->getsuppliers();

		$this->form_validation->set_rules('product_name', 'product name', 'required');
		$this->form_validation->set_rules('supplier_id', 'supplier', 'required');
		$this->form_validation->set_rules('product_price', 'product price', 'required');
		$this->form_validation->set_rules('expiry_date', 'expiration date', 'required');
		$this->form_validation->set_rules('quantity', 'quantity', 'required');

		if ($this->form_validation->run() == false) {
			$data['product'] = $product;
			$this->load->view('editproduct', $data);
		} else {
			$product_name = $this->input->post('product_name');
			$supplier_id = $this->input->post('supplier_id');
			$product_price = $this->input->post('product_price');
			$expiry_date = $this->input->post('expiry_date');
			$quantity = $this->input->post('quantity');
			$this->productmodel->updateproduct($id, $product_name, $supplier_id, $product_price, $expiry_date, $quantity);
			$this->session->set_flashdata('success', 'Record updated Successfully',);
			$this->session->mark_as_temp('success', 3);
			redirect(base_url() . 'index.php/client/productlist');
		}
	}

	public function deleteproduct()
	{ // Delete Role
		$product_id = $_POST['product_id'];

		$this->productmodel->deleteproduct($product_id);
		$this->session->set_flashdata('success', 'Record Deleted Successfully');
		$this->session->mark_as_temp('success', 3);
		redirect(base_url() . 'index.php/client/productlist');
	}

	public function customerlist($offset = 0)
	{
		$config['base_url'] = site_url('index.php/client/customerlist/');
		$config['total_rows'] = $this->customermodel->countAllProd();
		$config['per_page'] = 10;
		$config['full_tag_open'] = '<ul class="pagination">';
		$config['first_tag_open'] = '<li class="page-item"><span class="page-link">';
		$config['first_tag_close'] = '</span></li>';
		$config['prev_link'] = '&laquo';
		$config['prev_tag_open'] = '<li class="page-item"><span class="page-link">';
		$config['prev_tag_close'] = '</span></li>';
		$config['next_link'] = '&raquo';
		$config['next_tag_open'] = '<li class="page-item"><span class="page-link">';
		$config['next_tag_close'] = '</span></li>';
		$config['last_tag_open'] = '<li class="page-item"><span class="page-link">';
		$config['last_tag_close'] = '</span></li>';
		$config['cur_tag_open'] = '<li class="page-item active"><span class="page-link">';
		$config['cur_tag_close'] = '</span></li>';
		$config['num_tag_open'] = '<li class="page-item"><span class="page-link">';
		$config['num_tag_close'] = '</span></li>';
		$config['full_tag_close'] = '</ul>';
		$this->pagination->initialize($config);
		$customers = $this->customermodel->allProd($config['per_page'], $offset);
		$data = array();
		$data['customers'] = $customers;
		$this->load->view('customerlist', $data);
	}

	public function addcustomer()
	{
		$data = array();
		$this->form_validation->set_rules('customer_name', '', 'callback_check_customer');
		$this->form_validation->set_rules('contact_number', 'contact number', 'required');
		$this->form_validation->set_rules('address', 'address', 'required');

		if ($this->form_validation->run() == false) {
			$this->load->view('addcustomer', $data);
		} else {
			$formArray = array();
			$formArray['customer_name'] = $this->input->post('customer_name');
			$formArray['contact_number'] = $this->input->post('contact_number');
			$formArray['address'] = $this->input->post('address');

			$this->customermodel->addcustomer($formArray);
			$this->session->set_flashdata('success', 'Record added Successfully');
			$this->session->mark_as_temp('success', 3);
			redirect(base_url() . 'index.php/client/customerlist');
		}
	}

	public function check_customer($product_name) 
    {
		$customer_name = $this->input->post('customer_name');

		if($customer_name === '') {
			$this->form_validation->set_message('check_customer', 'The customer name field is required.');
			return false;
		}

		$result = $this->customermodel->checkduplicatecustomer($customer_name);

		if($result > 0) {
			$this->form_validation->set_message('check_customer', 'Customer name already exists.');
			return false;
		} else {
			return true;
		}
    }

	public function editcustomer($id)
	{ // Edit Role
		$customers = $this->customermodel->getcustomer($id);

		$data = array();
		$data['menu_item_dashboard'] = 'menu-item';
		$data['menu_item_employee'] = 'menu-item';
		$data['menu_item_timekeeping'] = 'menu-item';
		$data['menu_item_payroll'] = 'menu-item';
		$data['menu_item_billing'] = 'menu-item';
		$data['menu_item_inventory'] = 'menu-item';
		$data['menu_item_reference_table'] = 'menu-item';
		$data['menu_item_settings'] = 'menu-item active';

		$this->form_validation->set_rules('customer_name', 'customer name', 'required');
		$this->form_validation->set_rules('contact_number', 'contact number', 'required');
		$this->form_validation->set_rules('address', 'address', 'required');

		if ($this->form_validation->run() == false) {
			$data['customers'] = $customers;
			$this->load->view('editcustomer', $data);
		} else {
			$customer_name = $this->input->post('customer_name');
			$contact_number = $this->input->post('contact_number');
			$address = $this->input->post('address');
			$this->customermodel->updatecus($id, $customer_name, $contact_number, $address);
			$this->session->set_flashdata('success', 'Record updated Successfully',);
			$this->session->mark_as_temp('success', 3);
			redirect(base_url() . 'index.php/client/customerlist');
		}
	}

	public function deletecustomer()
	{ // Delete Role
		$customer_id = $_POST['customer_id'];

		$this->customermodel->deletecus($customer_id);

		redirect(base_url() . 'index.php/client/customerlist');
	}

	public function supplierlist($offset = 0)
	{
		$config['base_url'] = site_url('index.php/client/supplierlist/');
		$config['total_rows'] = $this->suppliermodel->countAllProd();
		$config['per_page'] = 10;
		$config['full_tag_open'] = '<ul class="pagination">';
		$config['first_tag_open'] = '<li class="page-item"><span class="page-link">';
		$config['first_tag_close'] = '</span></li>';
		$config['prev_link'] = '&laquo';
		$config['prev_tag_open'] = '<li class="page-item"><span class="page-link">';
		$config['prev_tag_close'] = '</span></li>';
		$config['next_link'] = '&raquo';
		$config['next_tag_open'] = '<li class="page-item"><span class="page-link">';
		$config['next_tag_close'] = '</span></li>';
		$config['last_tag_open'] = '<li class="page-item"><span class="page-link">';
		$config['last_tag_close'] = '</span></li>';
		$config['cur_tag_open'] = '<li class="page-item active"><span class="page-link">';
		$config['cur_tag_close'] = '</span></li>';
		$config['num_tag_open'] = '<li class="page-item"><span class="page-link">';
		$config['num_tag_close'] = '</span></li>';
		$config['full_tag_close'] = '</ul>';
		$this->pagination->initialize($config);
		$suppliers = $this->suppliermodel->allProd($config['per_page'], $offset);
		$data = array();
		$data['suppliers'] = $suppliers;
		$this->load->view('supplierlist', $data);
	}

	public function addsupplier()
	{
		$data = array();
		$this->form_validation->set_rules('supplier_name', '', 'callback_check_supplier');
		$this->form_validation->set_rules('contact_number', 'contact number', 'required');
		$this->form_validation->set_rules('address', 'address', 'required');
		if ($this->form_validation->run() == false) {
			$this->load->view('addsupplier', $data);
		} else {
			$formArray = array();
			$formArray['supplier_name'] = $this->input->post('supplier_name');
			$formArray['contact_number'] = $this->input->post('contact_number');
			$formArray['address'] = $this->input->post('address');

			$this->suppliermodel->addSupp($formArray);
			$this->session->set_flashdata('success', 'Record added Successfully');
			$this->session->mark_as_temp('success', 3);
			redirect(base_url() . 'index.php/client/supplierlist');
		}
	}

	public function check_supplier($supplier_name) 
    {
		$supplier_name = $this->input->post('supplier_name');

		if($supplier_name === '') {
			$this->form_validation->set_message('check_supplier', 'The supplier name field is required.');
			return false;
		}

		$result = $this->suppliermodel->checkduplicatesupplier($supplier_name);

		if($result > 0) {
			$this->form_validation->set_message('check_supplier', 'Supplier name already exists.');
			return false;
		} else {
			return true;
		}
    }

	public function editsupplier($id)
	{ // Edit Role
		$suppliers = $this->suppliermodel->getsupplier($id);

		$data = array();
		$data['menu_item_dashboard'] = 'menu-item';
		$data['menu_item_employee'] = 'menu-item';
		$data['menu_item_timekeeping'] = 'menu-item';
		$data['menu_item_payroll'] = 'menu-item';
		$data['menu_item_billing'] = 'menu-item';
		$data['menu_item_inventory'] = 'menu-item';
		$data['menu_item_reference_table'] = 'menu-item';
		$data['menu_item_settings'] = 'menu-item active';

		$this->form_validation->set_rules('supplier_name', 'supplier name', 'required');
		$this->form_validation->set_rules('contact_number', 'contact number', 'required');
		$this->form_validation->set_rules('address', 'address', 'required');

		if ($this->form_validation->run() == false) {
			$data['suppliers'] = $suppliers;
			$this->load->view('editsupplier', $data);
		} else {
			$supplier_name = $this->input->post('supplier_name');
			$contact_number = $this->input->post('contact_number');
			$address = $this->input->post('address');
			$this->suppliermodel->updatesupp($id, $supplier_name, $contact_number, $address);
			$this->session->set_flashdata('success', 'Record updated Successfully',);
			$this->session->mark_as_temp('success', 3);
			redirect(base_url() . 'index.php/client/supplierlist');
		}
	}

	public function deletesupp()
	{ // Delete Role
		$supplier_id = $_POST['supplier_id'];

		$this->suppliermodel->deletesupp($supplier_id);

		redirect(base_url() . 'index.php/client/supplierlist');
	}


	public function sales($offset = 0)
	{
		$config['base_url'] = site_url('client/sales/');
		$config['total_rows'] = $this->salesmodel->countAllSales();
		$config['per_page'] = 10;
		$config['full_tag_open'] = '<ul class="pagination">';
		$config['first_tag_open'] = '<li class="page-item"><span class="page-link">';
		$config['first_tag_close'] = '</span></li>';
		$config['prev_link'] = '&laquo';
		$config['prev_tag_open'] = '<li class="page-item"><span class="page-link">';
		$config['prev_tag_close'] = '</span></li>';
		$config['next_link'] = '&raquo';
		$config['next_tag_open'] = '<li class="page-item"><span class="page-link">';
		$config['next_tag_close'] = '</span></li>';
		$config['last_tag_open'] = '<li class="page-item"><span class="page-link">';
		$config['last_tag_close'] = '</span></li>';
		$config['cur_tag_open'] = '<li class="page-item active"><span class="page-link">';
		$config['cur_tag_close'] = '</span></li>';
		$config['num_tag_open'] = '<li class="page-item"><span class="page-link">';
		$config['num_tag_close'] = '</span></li>';
		$config['full_tag_close'] = '</ul>';
		$this->pagination->initialize($config);
		$sales = $this->salesmodel->allSales($config['per_page'], $offset);
		$data = array();
		$data['sales'] = $sales;
		$this->load->view('sales', $data);
	}

	public function search($offset = 0)
	{
		$purchased_date = '';

		if(isset($_POST['created_at'])) {
			$purchased_date = date("Y-m-d H:i:s", strtotime($_POST['created_at']));;
			$this->session->set_userdata('purchased_date', $purchased_date);
		} else {
			$purchased_date = $this->session->userdata('purchased_date');
		}

		$this->salesmodel->show($purchased_date);

		$config['base_url'] = site_url('client/search');
		$config['total_rows'] = $this->salesmodel->show($purchased_date);
		$config['per_page'] = 10;
		$config['full_tag_open'] = '<ul class="pagination right-content-end">';
		$config['full_tag_close'] = '</ul>';
		$config['first_tag_open'] = '<li class="page-item"><span class="page-link">';
		$config['first_tag_close'] = '</span></li>';
		$config['prev_link'] = '&laquo';
		$config['prev_tag_open'] = '<li class="page-item"><span class="page-link">';
		$config['prev_tag_close'] = '</span></li>';
		$config['next_link'] = '&raquo';
		$config['next_tag_open'] = '<li class="page-item"><span class="page-link">';
		$config['next_tag_close'] = '</span></li>';
		$config['last_tag_open'] = '<li class="page-item"><span class="page-link">';
		$config['last_tag_close'] = '</span></li>';
		$config['cur_tag_open'] = '<li class="page-item active"><a class="page-link" href="#">';
		$config['cur_tag_close'] = '</a></li>';
		$config['num_tag_open'] = '<li class="page-item"><span class="page-link">';
		$config['num_tag_close'] = '</span></li>';

		$this->pagination->initialize($config);
		$sales = $this->salesmodel->search($offset, $config['per_page'], $purchased_date);
		$data = array();
		$data['sales'] = $sales;
		$this->load->view('sales', $data);
	}

	public function deletepurchase()
	{ // Delete Purchase
		$purchase_id = $_POST['purchase_id'];

		$this->salesmodel->deletepurchase($purchase_id);
		$this->session->set_flashdata('success', 'Record Deleted Successfully');
		$this->session->mark_as_temp('success', 3);
		redirect(base_url() . 'index.php/client/sales');
	}

	public function buyproductlist($offset = 0)
	{
		$config['base_url'] = site_url('index.php/client/buyproductlist');
		$config['total_rows'] = $this->buyproductmodel->countallproducts();
		$config['per_page'] = 10;
		$config['full_tag_open'] = '<ul class="pagination">';
		$config['first_tag_open'] = '<li class="page-item"><span class="page-link">';
		$config['first_tag_close'] = '</span></li>';
		$config['prev_link'] = '&laquo';
		$config['prev_tag_open'] = '<li class="page-item"><span class="page-link">';
		$config['prev_tag_close'] = '</span></li>';
		$config['next_link'] = '&raquo';
		$config['next_tag_open'] = '<li class="page-item"><span class="page-link">';
		$config['next_tag_close'] = '</span></li>';
		$config['last_tag_open'] = '<li class="page-item"><span class="page-link">';
		$config['last_tag_close'] = '</span></li>';
		$config['cur_tag_open'] = '<li class="page-item active"><span class="page-link">';
		$config['cur_tag_close'] = '</span></li>';
		$config['num_tag_open'] = '<li class="page-item"><span class="page-link">';
		$config['num_tag_close'] = '</span></li>';
		$config['full_tag_close'] = '</ul>';
		$this->pagination->initialize($config);
		$products = $this->buyproductmodel->allproducts($offset, $config['per_page']);
		$data = array();
		$data['products'] = $products;
		$this->load->view('buyproduct', $data);
	}

	public function productdetails($id)
	{
		$customers = $this->buyproductmodel->getcustomers();
		$payment_methods = $this->buyproductmodel->getpaymentmethods();
		$product = $this->buyproductmodel->productdetails($id);

		$data = array();
		$data['product'] = $product;
		$data['customers'] = $customers;
		$data['payment_methods'] = $payment_methods;

		$this->load->view('productdetails', $data);
	}

	public function buyproduct()
	{
		$payment_method_id = $this->input->post('payment_method_id');
		$this->form_validation->set_rules('quantity', 'quantity', 'callback_check_quantity');
		$this->form_validation->set_rules('payment_method_id', 'payment method', 'required');

		if($payment_method_id == '2') {
			$this->form_validation->set_rules('customer_id', 'customer', 'required');
		}

		if ($this->form_validation->run() == false) {
			$form_error = array(
				'quantity_error' => form_error('quantity'),
				'payment_method_id_error' => form_error('payment_method_id'),
				'customer_id_error' => form_error('customer_id'),
				'error' => TRUE
			);
			echo json_encode($form_error);
		} else {
			$form_error = array(
				'error' => FALSE
			);
			echo json_encode($form_error);

			$product_id = $this->input->post('product_id');
			$product_price = $this->input->post('product_price');
			$quantity = $this->input->post('quantity');
			$payment_method_id = $this->input->post('payment_method_id');
			$customer_id = $this->input->post('customer_id');
			$purchased_price = (int)$product_price * (int)$quantity;
			$old_quantity = $this->input->post('old_quantity');
			$new_quantity = (int)$old_quantity - (int)$quantity;
			$payment_status_id = '';

			if ($payment_method_id == '1') {
				$payment_status_id = '1';
			} else {
				$payment_status_id = '2';
			}

			$this->buyproductmodel->buyproduct($product_id, $quantity, $payment_method_id, $payment_status_id, $customer_id, $purchased_price, $new_quantity);

			$this->session->set_flashdata('success', 'Purchased Successfully');
			$this->session->mark_as_temp('success', 3);
		}
	}

	public function check_quantity($quantity) {
		$quantity = $this->input->post('quantity');
		$old_quantity = $this->input->post('old_quantity');

		if($quantity === '') {
			$this->form_validation->set_message('check_quantity', 'The quantity field is required.');
			return false;
		}

		if($quantity > $old_quantity) {
			$this->form_validation->set_message('check_quantity', 'Entered quantity exceeds the product quantity.');
			return false;
		} else {
			return true;
		}
	}

	public function arrlist($offset = 0)
	{
		$config['base_url'] = site_url('index.php/client/arrlist/');
		$config['total_rows'] = $this->buyproductmodel->countallarr();
		$config['per_page'] = 10;
		$config['full_tag_open'] = '<ul class="pagination">';
		$config['first_tag_open'] = '<li class="page-item"><span class="page-link">';
		$config['first_tag_close'] = '</span></li>';
		$config['prev_link'] = '&laquo';
		$config['prev_tag_open'] = '<li class="page-item"><span class="page-link">';
		$config['prev_tag_close'] = '</span></li>';
		$config['next_link'] = '&raquo';
		$config['next_tag_open'] = '<li class="page-item"><span class="page-link">';
		$config['next_tag_close'] = '</span></li>';
		$config['last_tag_open'] = '<li class="page-item"><span class="page-link">';
		$config['last_tag_close'] = '</span></li>';
		$config['cur_tag_open'] = '<li class="page-item active"><span class="page-link">';
		$config['cur_tag_close'] = '</span></li>';
		$config['num_tag_open'] = '<li class="page-item"><span class="page-link">';
		$config['num_tag_close'] = '</span></li>';
		$config['full_tag_close'] = '</ul>';
		$this->pagination->initialize($config);
		$arr_reports = $this->buyproductmodel->allarr($offset, $config['per_page']);
		$data = array();
		$data['arr_reports'] = $arr_reports;
		$this->load->view('arrlist', $data);
	}

	public function updatepaymentstatus($id)
	{
		$payment_status_id = '1';
		$this->salesmodel->updatepaymentstatus($id, $payment_status_id);
		$this->session->set_flashdata('success', 'Record updated Successfully',);
		$this->session->mark_as_temp('success', 3);
		redirect(base_url() . 'index.php/client/arrlist');
	}

	public function collectionreports($offset = 0)
	{
		$config['base_url'] = site_url('index.php/client/arrlist/');
		$config['total_rows'] = $this->buyproductmodel->countcollectionreports();
		$config['per_page'] = 10;
		$config['full_tag_open'] = '<ul class="pagination">';
		$config['first_tag_open'] = '<li class="page-item"><span class="page-link">';
		$config['first_tag_close'] = '</span></li>';
		$config['prev_link'] = '&laquo';
		$config['prev_tag_open'] = '<li class="page-item"><span class="page-link">';
		$config['prev_tag_close'] = '</span></li>';
		$config['next_link'] = '&raquo';
		$config['next_tag_open'] = '<li class="page-item"><span class="page-link">';
		$config['next_tag_close'] = '</span></li>';
		$config['last_tag_open'] = '<li class="page-item"><span class="page-link">';
		$config['last_tag_close'] = '</span></li>';
		$config['cur_tag_open'] = '<li class="page-item active"><span class="page-link">';
		$config['cur_tag_close'] = '</span></li>';
		$config['num_tag_open'] = '<li class="page-item"><span class="page-link">';
		$config['num_tag_close'] = '</span></li>';
		$config['full_tag_close'] = '</ul>';
		$this->pagination->initialize($config);
		$collection_reports = $this->buyproductmodel->allcollectionreports($offset, $config['per_page']);
		$data = array();
		$data['collection_reports'] = $collection_reports;
		$this->load->view('collection_reports', $data);
	}
}
