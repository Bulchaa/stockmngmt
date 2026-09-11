<?php 

class Model_orders extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	/* get the orders data */
	public function getOrdersData($id = null)
	{
		if($id) {
			$sql = "SELECT * FROM `orders` WHERE id = ? AND customer_types = 0";
			$query = $this->db->query($sql, array($id));
			return $query->row_array();
		}

		$sql = "SELECT * FROM `orders` WHERE customer_types = 0 ORDER BY id DESC";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
        public function getOrdersProcess($id = null)
	{
		if($id) {
			$sql = "SELECT * FROM `orders` WHERE id = ? ";
			$query = $this->db->query($sql, array($id));
			return $query->row_array();
		}

		$sql = "SELECT * FROM `orders` ORDER BY id DESC";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
             public function getOrdersProcessByDate($date_from, $date_to)
	{
		

		$sql = "SELECT * FROM `orders` WHERE date_time BETWEEN '$date_from' AND '$date_to' ORDER BY id DESC";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
        public function getProcessorders($id = null)
	{
		if($id) {
			$sql = "SELECT * FROM `process` WHERE order_no = ? ";
			$query = $this->db->query($sql, array($id));
			return $query->row_array();
		}

		$sql = "SELECT * FROM `process` ORDER BY id DESC";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	public function getOrdersData1($id = null)
	{
		if($id) {
			$sql = "SELECT * FROM `orders` WHERE id = ? AND customer_types = 2";
			$query = $this->db->query($sql, array($id));
			return $query->row_array();
		}

		$sql = "SELECT * FROM `orders` WHERE customer_types = 2 ORDER BY id DESC";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
        public function getOrdersDataProcess($id = null)
	{
		if($id) {
			$sql = "SELECT * FROM `orders` WHERE id = ?";
			$query = $this->db->query($sql, array($id));
			return $query->row_array();
		}

		$sql = "SELECT * FROM `orders` ORDER BY id DESC";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	// get the orders item data
	public function getOrdersItemData($order_id = null)
	{
		if(!$order_id) {
			return false;
		}

		$sql = "SELECT * FROM `orders_item` WHERE order_id = ?";
		$query = $this->db->query($sql, array($order_id));
		return $query->result_array();
	}
public function getPaymentData($id = null)
	{
		if($id) {
			$sql = "SELECT * FROM `payment` WHERE order_no = ?";
			$query = $this->db->query($sql, array($id));
			return $query->row_array();
		}


		$sql = "SELECT * FROM `payment` WHERE order_no = ?";
		$query = $this->db->query($sql, array($id));
		return $query->result_array();
	}
	public function create()
	{
		$user_id = $this->session->userdata('id');
		$bill_no = $this->generateBillNo($this->input->post('customer_phone'));
    	$data = array(
    		'bill_no' => $bill_no,
    		'customer_name' => $this->input->post('customer_name'),
    		'customer_address' => $this->input->post('customer_address'),
    		'customer_phone' => $this->input->post('customer_phone'),
    		'date_time' => strtotime(date('Y-m-d h:i:s a')),
    		'gross_amount' => $this->input->post('gross_amount_value'),
    		'service_charge_rate' => $this->input->post('service_charge_rate'),
    		'service_charge' => ($this->input->post('service_charge_value') > 0) ?$this->input->post('service_charge_value'):0,
    		'vat_charge_rate' => $this->input->post('vat_charge_rate'),
    		'vat_charge' => ($this->input->post('vat_charge_value') > 0) ? $this->input->post('vat_charge_value') : 0,
    		'net_amount' => $this->input->post('net_amount_value'),
    		'discount' => $this->input->post('discount'),
    		'paid_status' => 2,
    		'user_id' => $user_id
    	);

		$insert = $this->db->insert('orders', $data);
		$order_id = $this->db->insert_id();

                $payment = array (
                    'order_no' => $order_id,
                    'bill_no' => $bill_no,
                    'customer_types' => '0',
    		'customer_name' => $this->input->post('customer_name'),
    			'total_amount' => $this->input->post('net_amount_value'),
                   
                    'paid_amount' => $this->input->post('paid_amount'),
                    'payment_types' => $this->input->post('paid_type'),
                    'payment_status' => $this->input->post('paid_status'),
                    'datetime' => strtotime(date('Y-m-d h:i:s a')),
    			'tt_number' => $this->input->post('tt_number'),
    			'due_amount' => $this->input->post('due_amount_value'),
    			
                );
                $this->db->insert('payment', $payment);
		$this->load->model('model_products');

		$count_product = count($this->input->post('product'));
    	for($x = 0; $x < $count_product; $x++) {
    		$items = array(
    			'order_id' => $order_id,
				'hgt' =>$this->input->post('hgt')[$x],
			'wdth' =>$this->input->post('wdth')[$x],
			'kaaree' =>$this->input->post('kaaree_value')[$x],
    			'product_id' => $this->input->post('product')[$x],
    			'qty' => $this->input->post('qty')[$x],
    			'rate' => $this->input->post('rate_value')[$x],
    			'amount' => $this->input->post('amount_value')[$x],
    		);
$this->db->insert('orders_item', $items);
    		
    		// now decrease the stock FROM `the` product
    		$product_data = $this->model_products->getProductData($this->input->post('product')[$x]);
    		$qty = (int) $product_data['qty'] - (int) $this->input->post('qty')[$x];

    		$update_product = array('qty' => $qty);


    		$this->model_products->update($update_product, $this->input->post('product')[$x]);
    	}

		return ($order_id) ? $order_id : false;
	}

        
        
      //
                      
        //organization customers
        public function create1()
	{
		$user_id = $this->session->userdata('id');
		$customer_phone = '';
		$customer_id = $this->input->post('customer_name');
		if($customer_id) {
			$customer_query = $this->db->query("SELECT phone FROM customer WHERE id = ?", array($customer_id));
			$customer_row = $customer_query->row_array();
			if($customer_row) {
				$customer_phone = $customer_row['phone'];
			}
		}
		$bill_no = $this->generateBillNo($customer_phone);
    	$data = array(
    		'bill_no' => $bill_no,
    		'customer_name' => $this->input->post('customer_name'),
    		'customer_types' => $this->input->post('customer_types'),
    		
    		'date_time' => strtotime(date('Y-m-d h:i:s a')),
			
    		'gross_amount' => $this->input->post('gross_amount_value'),
    		'service_charge_rate' => $this->input->post('service_charge_rate'),
    		'service_charge' => ($this->input->post('service_charge_value') > 0) ?$this->input->post('service_charge_value'):0,
    		'vat_charge_rate' => $this->input->post('vat_charge_rate'),
    		'vat_charge' => ($this->input->post('vat_charge_value') > 0) ? $this->input->post('vat_charge_value') : 0,
    		'net_amount' => $this->input->post('net_amount_value'),
    		'discount' => $this->input->post('discount'),
    		'paid_status' => 2,
    		'user_id' => $user_id
    	);

		$insert = $this->db->insert('orders', $data);
		$order_id = $this->db->insert_id();
$payment = array (
                    'order_no' => $order_id,
                    'bill_no' => $bill_no,
                    'customer_types' => '2',
    		'customer_name' => $this->input->post('customer_name'),
    			'total_amount' => $this->input->post('net_amount_value'),
                   
                    'paid_amount' => $this->input->post('paid_amount'),
                    'payment_types' => $this->input->post('paid_type'),
                    'payment_status' => $this->input->post('paid_status'),
                    'datetime' => strtotime(date('Y-m-d h:i:s a')),
    			'tt_number' => $this->input->post('tt_number'),
    			'due_amount' => $this->input->post('due_amount_value'),
    			
                );
                $this->db->insert('payment', $payment);
		$this->load->model('model_products');

		$count_product = count($this->input->post('product'));
    	for($x = 0; $x < $count_product; $x++) {
    		$items = array(
				'hgt' =>$this->input->post('hgt')[$x],
			'wdth' =>$this->input->post('wdth')[$x],
			'kaaree' =>$this->input->post('kaaree_value')[$x],
    			'order_id' => $order_id,
    			'product_id' => $this->input->post('product')[$x],
    			'qty' => $this->input->post('qty')[$x],
    			'rate' => $this->input->post('rate_value')[$x],
    			'amount' => $this->input->post('amount_value')[$x],
    		);

    		$this->db->insert('orders_item', $items);
 
    		// now decrease the stock FROM `the` product
    		$product_data = $this->model_products->getProductData($this->input->post('product')[$x]);
    		$qty = (int) $product_data['qty'] - (int) $this->input->post('qty')[$x];

    		$update_product = array('qty' => $qty);


    		$this->model_products->update($update_product, $this->input->post('product')[$x]);
    	}

		return ($order_id) ? $order_id : false;
	}

        
        
        
        
        
	public function countOrderItem($order_id)
	{
		if($order_id) {
			$sql = "SELECT * FROM `orders_item` WHERE order_id = ?";
			$query = $this->db->query($sql, array($order_id));
			return $query->num_rows();
		}
	}
public function paymentupdate($id)
	{
		if($id) {
			$user_id = $this->session->userdata('id');
			// fetch the order data 

			$data = array(
			
	    		'paid_status' => $this->input->post('paid_status'),
                          
                           
	    		
	    	);

			$this->db->where('id', $id);
			$update = $this->db->update('orders', $data);

			// now the order item 
			// first we will replace the product qty to original and subtract the qty again
			 $payment = array (
                    'order_no' => $id,
                   'bill_no' => $this->input->post('bill_no'),
                    'customer_types' => '0',
    		'customer_name' => $this->input->post('customer_name'),
    			'total_amount' => $this->input->post('net_amount_value'),
                   
                    'paid_amount' => $this->input->post('remaining'),
                    'payment_types' => $this->input->post('paid_type'),
                    'payment_status' => $this->input->post('paid_status'),
                    'datetime' => strtotime(date('Y-m-d h:i:s a')),
    			'tt_number' => $this->input->post('tt_number'),
    			'due_amount' =>  '0'
    			
                );
                $this->db->insert('payment', $payment);

			// now remove the order item data 
			
			// now decrease the product qty
			
	    		
	    	}

			return true;
		
	}
public function paymentupdate1($id)
	{
		if($id) {
			$user_id = $this->session->userdata('id');
			// fetch the order data 

			$data = array(
			
	    		'paid_status' => $this->input->post('paid_status'),
                          
                           
	    		
	    	);

			$this->db->where('id', $id);
			$update = $this->db->update('orders', $data);

			// now the order item 
			// first we will replace the product qty to original and subtract the qty again
			 $payment = array (
                    'order_no' => $id,
                   'bill_no' => $this->input->post('bill_no'),
                    'customer_types' => '2',
    		'customer_name' => $this->input->post('customer_name'),
    			'total_amount' => $this->input->post('net_amount_value'),
                   
                    'paid_amount' => $this->input->post('remaining'),
                    'payment_types' => $this->input->post('paid_type'),
                    'payment_status' => $this->input->post('paid_status'),
                    'datetime' => strtotime(date('Y-m-d h:i:s a')),
    			'tt_number' => $this->input->post('tt_number'),
    			'due_amount' =>  '0'
    			
                );
                $this->db->insert('payment', $payment);

			// now remove the order item data 
			
			// now decrease the product qty
			
	    		
	    	}

			return true;
		
	}
	public function update($id)
	{
		if($id) {
			$user_id = $this->session->userdata('id');
			// fetch the order data 

			$data = array(
				'customer_name' => $this->input->post('customer_name'),
	    		'customer_address' => $this->input->post('customer_address'),
	    		'customer_phone' => $this->input->post('customer_phone'),
	    		'gross_amount' => $this->input->post('gross_amount_value'),
	    		'service_charge_rate' => $this->input->post('service_charge_rate'),
	    		'service_charge' => ($this->input->post('service_charge_value') > 0) ? $this->input->post('service_charge_value'):0,
	    		'vat_charge_rate' => $this->input->post('vat_charge_rate'),
	    		'vat_charge' => ($this->input->post('vat_charge_value') > 0) ? $this->input->post('vat_charge_value') : 0,
	    		'net_amount' => $this->input->post('net_amount_value'),
	    		'discount' => $this->input->post('discount'),
	    		'paid_status' => $this->input->post('paid_status'),
	    		'user_id' => $user_id
	    	);

			$this->db->where('id', $id);
			$update = $this->db->update('orders', $data);

			// now the order item 
			// first we will replace the product qty to original and subtract the qty again
			$this->load->model('model_products');
			$get_order_item = $this->getOrdersItemData($id);
			foreach ($get_order_item as $k => $v) {
				$product_id = $v['product_id'];
				$qty = $v['qty'];
				// get the product 
				$product_data = $this->model_products->getProductData($product_id);
				$update_qty = $qty + $product_data['qty'];
				$update_product_data = array('qty' => $update_qty);
				
				// update the product qty
				$this->model_products->update($update_product_data, $product_id);
			}

			// now remove the order item data 
			$this->db->where('order_id', $id);
			$this->db->delete('orders_item');

			// now decrease the product qty
			$count_product = count($this->input->post('product'));
	    	for($x = 0; $x < $count_product; $x++) {
	    		$items = array(
	    			'order_id' => $id,
	    			'product_id' => $this->input->post('product')[$x],
	    			'qty' => $this->input->post('qty')[$x],
	    			'rate' => $this->input->post('rate_value')[$x],
	    			'amount' => $this->input->post('amount_value')[$x],
	    		);
	    		$this->db->insert('orders_item', $items);

	    		// now decrease the stock FROM `the` product
	    		$product_data = $this->model_products->getProductData($this->input->post('product')[$x]);
	    		$qty = (int) $product_data['qty'] - (int) $this->input->post('qty')[$x];

	    		$update_product = array('qty' => $qty);
	    		$this->model_products->update($update_product, $this->input->post('product')[$x]);
	    	}

			return true;
		}
	}

       public function updateprocess($id)
	{
		if($id) {
			$user_id = $this->session->userdata('id');
			// fetch the order data 

			$data = array(
				
	    		'process_status' => $this->input->post('status'),
	    		'user_id' => $user_id
	    	);

			$this->db->where('id', $id);
			$update = $this->db->update('orders', $data);

		

			// now remove the order item data 
			
			// now decrease the product qty
		$items = array(
                    
                    'bill_no' => $this->input->post('bill_no'),
                    'process_status' => $this->input->post('status'),
                    'processed_date' => strtotime(date('Y-m-d h:i:s a')),
	    		'order_no' => $id
                );
	    		$this->db->insert('process', $items);

	    		

			return true;
		}
	}
 
        public function update1($id)
	{
		if($id) {
			$user_id = $this->session->userdata('id');
			// fetch the order data 

			$data = array(
				'customer_name' => $this->input->post('customer_name'),
	    		
	    		'gross_amount' => $this->input->post('gross_amount_value'),
	    		'service_charge_rate' => $this->input->post('service_charge_rate'),
	    		'service_charge' => ($this->input->post('service_charge_value') > 0) ? $this->input->post('service_charge_value'):0,
	    		'vat_charge_rate' => $this->input->post('vat_charge_rate'),
	    		'vat_charge' => ($this->input->post('vat_charge_value') > 0) ? $this->input->post('vat_charge_value') : 0,
	    		'net_amount' => $this->input->post('net_amount_value'),
	    		'discount' => $this->input->post('discount'),
	    		'paid_status' => $this->input->post('paid_status'),
	    		'user_id' => $user_id
	    	);

			$this->db->where('id', $id);
			$update = $this->db->update('orders', $data);

			// now the order item 
			// first we will replace the product qty to original and subtract the qty again
			$this->load->model('model_products');
			$get_order_item = $this->getOrdersItemData($id);
			foreach ($get_order_item as $k => $v) {
				$product_id = $v['product_id'];
				$qty = $v['qty'];
				// get the product 
				$product_data = $this->model_products->getProductData($product_id);
				$update_qty = $qty + $product_data['qty'];
				$update_product_data = array('qty' => $update_qty);
				
				// update the product qty
				$this->model_products->update($update_product_data, $product_id);
			}

			// now remove the order item data 
			$this->db->where('order_id', $id);
			$this->db->delete('orders_item');

			// now decrease the product qty
			$count_product = count($this->input->post('product'));
	    	for($x = 0; $x < $count_product; $x++) {
	    		$items = array(
	    			'order_id' => $id,
	    			'product_id' => $this->input->post('product')[$x],
	    			'qty' => $this->input->post('qty')[$x],
	    			'rate' => $this->input->post('rate_value')[$x],
	    			'amount' => $this->input->post('amount_value')[$x],
	    		);
	    		$this->db->insert('orders_item', $items);

	    		// now decrease the stock FROM `the` product
	    		$product_data = $this->model_products->getProductData($this->input->post('product')[$x]);
	    		$qty = (int) $product_data['qty'] - (int) $this->input->post('qty')[$x];

	    		$update_product = array('qty' => $qty);
	    		$this->model_products->update($update_product, $this->input->post('product')[$x]);
	    	}

			return true;
		}
	}



	public function remove($id)
	{
		if($id) {
			$this->db->where('id', $id);
			$delete = $this->db->delete('orders');

			$this->db->where('order_id', $id);
			$delete_item = $this->db->delete('orders_item');
			return ($delete == true && $delete_item) ? true : false;
		}
	}

	public function countTotalPaidOrders()
	{
		$sql = "SELECT * FROM `orders` WHERE paid_status = ?";
		$query = $this->db->query($sql, array(1));
		return $query->num_rows();
	}
public function countTotalOrders()
	{
		$sql = "SELECT * FROM `orders` WHERE customer_types = 0";
		$query = $this->db->query($sql, array(1));
		return $query->num_rows();
	}
        public function countTotalCOrders()
	{
		$sql = "SELECT * FROM `orders` WHERE customer_types = 2";
		$query = $this->db->query($sql, array(1));
		return $query->num_rows();
	}
        public function countTotalLOrders()
	{
		$sql = "SELECT * FROM `orders` WHERE paid_status = 0";
		$query = $this->db->query($sql, array(1));
		return $query->num_rows();
	}
            public function countProcessedOrders()
	{
		$sql = "SELECT * FROM `orders` WHERE process_status = 2";
		$query = $this->db->query($sql, array(1));
		return $query->num_rows();
	}

	/*
	* Generates a unique order number using the last 5 digits of the
	* customer phone number followed by a 4-digit sequential number.
	* Example: phone 0911223344 -> 12344-0001, 12344-0002, ...
	*/
	public function generateBillNo($phone = '')
	{
		$phone = preg_replace('/[^0-9]/', '', $phone);
		$last5 = substr($phone, -5);

		if(strlen($last5) < 5) {
			$last5 = str_pad($last5, 5, '0', STR_PAD_LEFT);
		}

		$this->db->select('bill_no');
		$this->db->like('bill_no', $last5 . '-', 'after');
		$query = $this->db->get('orders');

		$max_seq = 0;
		foreach($query->result() as $row) {
			$parts = explode('-', $row->bill_no);
			if(isset($parts[1]) && (int)$parts[1] > $max_seq) {
				$max_seq = (int)$parts[1];
			}
		}

		$sequence = $max_seq + 1;

		return $last5 . '-' . str_pad($sequence, 4, '0', STR_PAD_LEFT);
	}
}