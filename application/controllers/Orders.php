<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Orders extends Admin_Controller 
{
	public function __construct()
	{
		parent::__construct();

		$this->not_logged_in();

		$this->data['page_title'] = 'Orders';
$this->load->model('model_customers');
		$this->load->model('model_orders');
		$this->load->model('model_products');
		$this->load->model('model_company');
		$this->load->model('model_sms');
		$this->load->model('model_banks');
		$this->load->library('geezsms');
		$this->load->library('telebirr');
	}

	/*
	* Returns the customer phone number for an order row.
	* Private orders (type 0) store the phone directly on the order.
	* Organization orders (type 2) look it up from the customer table.
	*/
	private function getOrderCustomerPhone($order_data)
	{
		if(isset($order_data['customer_types']) && $order_data['customer_types'] == 2) {
			$customer = $this->model_customers->getCustomerData($order_data['customer_name']);
			return isset($customer['phone']) ? $customer['phone'] : '';
		}
		return isset($order_data['customer_phone']) ? $order_data['customer_phone'] : '';
	}

	/*
	* Sends an SMS receipt to the customer and logs the result.
	* Non-blocking: if SMS is disabled or fails, order operations continue.
	*/
	private function sendOrderSms($order_id, $bill_no, $phone, $message, $sms_type)
	{
		if(empty($phone)) {
			return false;
		}

		$company = $this->model_company->getCompanyData(1);
		$enabled = isset($company['sms_enabled']) ? (int)$company['sms_enabled'] : 0;
		if($enabled != 1) {
			return false;
		}

		if(empty($company['sms_token'])) {
			return false;
		}

		$this->config->set_item('geezsms_token', $company['sms_token']);
		$this->config->set_item('geezsms_shortcode', isset($company['sms_shortcode']) ? $company['sms_shortcode'] : '');
		$this->config->set_item('geezsms_enabled', $enabled);

		$sent = $this->geezsms->send($phone, $message);
		$api_response = $this->geezsms->last_response;
		$api_response_text = (is_array($api_response)) ? json_encode($api_response) : (string)$api_response;

		$log = array(
			'order_id' => $order_id,
			'bill_no' => $bill_no,
			'phone' => $phone,
			'message' => $message,
			'sms_type' => $sms_type,
			'status' => ($sent) ? 1 : 0,
			'api_response' => $api_response_text,
			'created_at' => strtotime(date('Y-m-d h:i:s a')),
		);
		$this->model_sms->logSms($log);

		return $sent;
	}

	/* 
	* It only redirects to the manage order page
	*/
	public function index()
	{
		if(!in_array('viewOrder', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

		$this->data['page_title'] = 'Manage Orders';
		$this->render_template('orders/index', $this->data);		
	}
        
public function in() 
	{
		if(!in_array('viewOrder', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

		$this->data['page_title'] = 'Manage Orders';
		$this->render_template('orders/index_1', $this->data);		
	}
        public function process()
	{
		if(!in_array('viewOrder', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

		$this->data['page_title'] = 'Manage Orders process';
		$this->render_template('orders/process', $this->data);		
	}
	/*
	* Fetches the orders data from the orders table 
	* this function is called from the datatable ajax function
	*/
	public function fetchOrdersData()
	{
		$result = array('data' => array());

		$data = $this->model_orders->getOrdersData();

		foreach ($data as $key => $value) {

			$count_total_item = $this->model_orders->countOrderItem($value['id']);
			$date = date('d-m-Y', $value['date_time']);
			$time = date('h:i a', $value['date_time']);

			$date_time = $date . ' ' . $time;

			// button
			$buttons = '';

			if(in_array('viewOrder', $this->permission)) {
				$buttons .= '<a target="__blank" href="'.base_url('orders/printDiv/'.$value['id']).'" class="btn btn-default"><i class="fa fa-print"></i></a>';
			}

			if(in_array('updateOrder', $this->permission)) {
				$buttons .= ' <a href="'.base_url('orders/update/'.$value['id']).'" class="btn btn-default"><i class="fa fa-pencil"></i></a>';
			
                                 $buttons .= ' <a href="'.base_url('orders/payment/'.$value['id']).'" class="btn btn-default"><i class="fa fa-dollar"></i></a>';
			
                        }

			if(in_array('deleteOrder', $this->permission)) {
				$buttons .= ' <button type="button" class="btn btn-default" onclick="removeFunc('.$value['id'].')" data-toggle="modal" data-target="#removeModal"><i class="fa fa-trash"></i></button>';
			}

			if($value['paid_status'] == 2) {
				$paid_status = '<span class="label label-warning">Advance Payment</span>';	
			}
			else 
                        if($value['paid_status'] == 1) {
				$paid_status = '<span class="label label-success">Paid</span>';	
			}
                        else 
                        if($value['paid_status'] == 0) {
				$paid_status = '<span class="label label-danger">Loan</span>';	
			}
                        
                        

			$result['data'][$key] = array(
				$value['bill_no'],
				$value['customer_name'],
				$value['customer_phone'],
				$date_time,
				$count_total_item,
				$value['net_amount'],
				$paid_status,
				$buttons
			);
		} // /foreach

		echo json_encode($result);
	}

        
        
     //fetch organization orders data
        
        public function fetchOrdersData1()
	{
		$result = array('data' => array());

		$data = $this->model_orders->getOrdersData1();

		foreach ($data as $key => $value) {
 $id=$value['customer_name'];
                        $users_data = $this->model_customers->getCustomerData($id);
			$count_total_item = $this->model_orders->countOrderItem($value['id']);
			$date = date('d-m-Y', $value['date_time']);
			$time = date('h:i a', $value['date_time']);

			$date_time = $date . ' ' . $time;

			// button
			$buttons = '';

			if(in_array('viewOrder', $this->permission)) {
				$buttons .= '<a target="__blank" href="'.base_url('orders/printDiv1/'.$value['id']).'" class="btn btn-default"><i class="fa fa-print"></i></a>';
			}

			if(in_array('updateOrder', $this->permission)) {
				$buttons .= ' <a href="'.base_url('orders/update1/'.$value['id']).'" class="btn btn-default"><i class="fa fa-pencil"></i></a>';
			
                                $buttons .= ' <a href="'.base_url('orders/payment1/'.$value['id']).'" class="btn btn-default"><i class="fa fa-dollar"></i></a>';
			
                        }

			if(in_array('deleteOrder', $this->permission)) {
				$buttons .= ' <button type="button" class="btn btn-default" onclick="removeFunc('.$value['id'].')" data-toggle="modal" data-target="#removeModal"><i class="fa fa-trash"></i></button>';
			}

			if($value['paid_status'] == 2) {
				$paid_status = '<span class="label label-warning">Advance Payment</span>';	
			}
			else 
                        if($value['paid_status'] == 1) {
				$paid_status = '<span class="label label-success">Paid</span>';	
			}
                        else 
                        if($value['paid_status'] == 0) {
				$paid_status = '<span class="label label-danger">Loan</span>';	
			}
                       

//                                                    if (!empty($user_data)) {
//                                                        $user_data = $user_data->username;
//                                                    } else {
//                                                        $user_data = '';
//                                                    }
                                                    
			$result['data'][$key] = array(
				$value['bill_no'],
				$users_data['username'],
				$users_data['phone'],
				$date_time,
				$count_total_item,
				$value['net_amount'],
				$paid_status,
				$buttons
			);
		} // /foreach

		echo json_encode($result);
	}
        
     //fetchordersforprocess   
	 public function fetchOrdersDataProcess()
	{
		$result = array('data' => array());

		$data = $this->model_orders->getOrdersData();

		foreach ($data as $key => $value) {

			$count_total_item = $this->model_orders->countOrderItem($value['id']);
			$date = date('d-m-Y', $value['date_time']);
			$time = date('h:i a', $value['date_time']);

			$date_time = $date . ' ' . $time;

			// button
			$buttons = '';

			if(in_array('viewOrder', $this->permission)) {
				$buttons .= '<a target="__blank" href="'.base_url('orders/printDiv/'.$value['id']).'" class="btn btn-default"><i class="fa fa-print"></i></a>';
			}

			if(in_array('updateOrder', $this->permission)) {
				$buttons .= ' <a href="'.base_url('orders/update/'.$value['id']).'" class="btn btn-default"><i class="fa fa-pencil"></i></a>';
			
                                 $buttons .= ' <a href="'.base_url('orders/payment/'.$value['id']).'" class="btn btn-default"><i class="fa fa-dollar"></i></a>';
			
                        }

			if(in_array('deleteOrder', $this->permission)) {
				$buttons .= ' <button type="button" class="btn btn-default" onclick="removeFunc('.$value['id'].')" data-toggle="modal" data-target="#removeModal"><i class="fa fa-trash"></i></button>';
			}

			if($value['paid_status'] == 2) {
				$paid_status = '<span class="label label-warning">Advance Payment</span>';	
			}
			else 
                        if($value['paid_status'] == 1) {
				$paid_status = '<span class="label label-success">Paid</span>';	
			}
                        else 
                        if($value['paid_status'] == 0) {
				$paid_status = '<span class="label label-danger">Loan</span>';	
			}
                        
                        

			$result['data'][$key] = array(
				$value['bill_no'],
				$value['customer_name'],
				$value['customer_phone'],
				$date_time,
				$count_total_item,
				$value['net_amount'],
				$paid_status,
				$buttons
			);
		} // /foreach

		echo json_encode($result);
	}
  public function fetchOrdersProcess()
	{
		$result = array('data' => array());

		$data = $this->model_orders->getOrdersProcess();

		foreach ($data as $key => $value) {

                        $process = $this->model_orders->getProcessorders($value['id']);
			$count_total_item = $this->model_orders->countOrderItem($value['id']);
                       // $orders_items = $this->model_orders->getOrdersItemData($value['id']);

                        $processed_date = '';
                       if($process && isset($process['processed_date']) && $process['processed_date'] != 0) {
                           $processed_date = $process['processed_date'];
                       }
                       if(!$processed_date) {
                           $processed_date = $value['date_time'];
                       }

                       $date2 = ($processed_date) ? date('d-m-Y', $processed_date) : '';
			$time2 = ($processed_date) ? date('h:i a', $processed_date) : '';

			$date_time2 = $date2 . ' ' . $time2;
                        
                        
			$date = date('d-m-Y', $value['date_time']);
			$time = date('h:i a', $value['date_time']);

			$date_time = $date . ' ' . $time;
 
			// button
			$buttons = '';

			

			if(in_array('updateOrder', $this->permission)) {
				$buttons .= ' <a href="'.base_url('orders/process_update/'.$value['id']).'" class="btn btn-default"><i class="fa fa-arrow-circle-o-right"></i></a>';
			}

			

			if($value['process_status'] == 2) {
				$process_status = '<span class="label label-success">Delivered</span>';	
			}
			else 
                        if($value['process_status'] == 1) {
				$process_status = '<span class="label label-warning">Under Process</span>';	
			}
                        else 
                        if($value['process_status'] == 0) {
				$process_status = '<span class="label label-danger">Not Processed</span>';	
			}

                        // clickable quick-status buttons
                        $process_btn = '';
                        if(in_array('updateOrder', $this->permission)) {
                            if($value['process_status'] == 0) {
                                $process_btn = ' <button type="button" class="btn btn-warning btn-xs btn-process-status" data-id="'.$value['id'].'" data-status="1">Under Process</button>';
                            }
                            else if($value['process_status'] == 1) {
                                $process_btn = ' <button type="button" class="btn btn-success btn-xs btn-process-status" data-id="'.$value['id'].'" data-status="2">Mark Processed</button>';
                            }
                        }
			$process_status = $process_status . $process_btn;
                        
                        
                           if($value['customer_types'] == 2) {
				$customer = '<span class="label label-danger">የድርጀት ድንብኘ</span>';
                           $Customer_name55 = $this->model_customers->getCustomerData($value['customer_name']);
                        $Customer_name =  ($Customer_name55 && isset($Customer_name55['username'])) ? $Customer_name55['username'].'/'.$Customer_name55['oname'] : $value['customer_name'];
			}
			else 
                        if($value['customer_types'] == 0) {
				$customer = '<span class="label label-default">የግለ ድንብኘ</span>';
                                $Customer_name = $value['customer_name'];
			}
                        
                        
                        if($value['process_status'] == 2 || $value['process_status'] == 1 ){
                        $count_dates = $date_time2;
                        
                        }
                        else{
                            $count_dates = '<span class="label label-danger">it not Processed</span>';
                        }
                        //foreach ($orders_items as $k => $v) {

			          //	$product_data = $this->model_products->getProductData($v['product_id']); 
			          	//$product = $product_data['name'];
////			          	$html .= '<tr>
////				            <td>'.$product_data['name'].'</td>
////				            <td>'.$v['rate'].'</td>
////				            <td>'.$v['qty'].'</td>
////				            <td>'.$v['amount'].'</td>
////			          	</tr>';
			         // }

			$result['data'][$key] = array(
				$date_time,
				$value['bill_no'],
				$count_dates,
			$Customer_name,		
                            $count_total_item,
                            $customer,
				$process_status,
				$buttons
			);
		} // /foreach

		echo json_encode($result);
	}

              
        
        
	/*
	* If the validation is not valid, then it redirects to the create page.
	* If the validation for each input field is valid then it inserts the data into the database 
	* and it stores the operation message into the session flashdata and display on the manage group page
	*/
	public function create()
	{
		if(!in_array('createOrder', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

		$this->data['page_title'] = 'Add Order';

		$this->form_validation->set_rules('product[]', 'Product name', 'trim|required');
		
	
        if ($this->form_validation->run() == TRUE) {        	
        	
        	$order_id = $this->model_orders->create();
        	
        	if($order_id) {
        		$order_row = $this->model_orders->getOrdersData($order_id);
        		$phone = $this->getOrderCustomerPhone($order_row);
        		$message = 'Yeroo: Order #'.$order_row['bill_no'].' received. Total: ETB '.$order_row['net_amount'].'. Thank you!';
        		$this->sendOrderSms($order_id, $order_row['bill_no'], $phone, $message, 'order_created');

        		$this->session->set_flashdata('success', 'Successfully created');
        		redirect('orders/update/'.$order_id, 'refresh');
        	}
        	else {
        		$this->session->set_flashdata('errors', 'Error occurred!!');
        		redirect('orders/create/', 'refresh');
        	}
        }
        else {
            // false case
        	$company = $this->model_company->getCompanyData(1);
        	$this->data['company_data'] = $company;
        	$this->data['is_vat_enabled'] = ($company['vat_charge_value'] > 0) ? true : false;
        	$this->data['is_service_enabled'] = ($company['service_charge_value'] > 0) ? true : false;

        	$this->data['products'] = $this->model_products->getActiveProductData();      	

        	$this->data['bank_accounts'] = $this->model_banks->getActiveBanks('bank');
        	$this->data['telebirr_accounts'] = $this->model_banks->getActiveBanks('telebirr');

            $this->render_template('orders/create', $this->data);
        }	
	}
public function create1()
	{
		if(!in_array('createOrder', $this->permission)) {
            redirect('dashboard', 'refresh');
        }
        $this->data['user_data'] = $this->model_customers->getCustomerData();
	
			



		$this->data['page_title'] = 'Add Order';

		$this->form_validation->set_rules('product[]', 'Product name', 'trim|required');
		
	
        if ($this->form_validation->run() == TRUE) {        	
        	
        	$order_id = $this->model_orders->create1();
        	
        	if($order_id) {
        		$order_row = $this->model_orders->getOrdersData1($order_id);
        		$phone = $this->getOrderCustomerPhone($order_row);
        		$message = 'Yeroo: Order #'.$order_row['bill_no'].' received. Total: ETB '.$order_row['net_amount'].'. Thank you!';
        		$this->sendOrderSms($order_id, $order_row['bill_no'], $phone, $message, 'order_created');

        		$this->session->set_flashdata('success', 'Successfully created');
        		redirect('orders/update1/'.$order_id, 'refresh');
        	}
        	else {
        		$this->session->set_flashdata('errors', 'Error occurred!!');
        		redirect('orders/create1/', 'refresh');
        	}
        }
        else {
            // false case
        	$company = $this->model_company->getCompanyData(1);
        	$this->data['company_data'] = $company;
        	$this->data['is_vat_enabled'] = ($company['vat_charge_value'] > 0) ? true : false;
        	$this->data['is_service_enabled'] = ($company['service_charge_value'] > 0) ? true : false;

        	$this->data['products'] = $this->model_products->getActiveProductData();      	

        	$this->data['bank_accounts'] = $this->model_banks->getActiveBanks('bank');
        	$this->data['telebirr_accounts'] = $this->model_banks->getActiveBanks('telebirr');

            $this->render_template('orders/create_1', $this->data);
        }	
	}

	/*
	* It gets the product id passed from the ajax method.
	* It checks retrieves the particular product data from the product id 
	* and return the data into the json format.
	*/
	public function getProductValueById()
	{
		$product_id = $this->input->post('product_id');
		if($product_id) {
			$product_data = $this->model_products->getProductData($product_id);
			echo json_encode($product_data);
		}
	}
	public function getCustomerValueById()
	{
		$userId = $this->input->post('customer_id');
		if($userId) {
			$customer_data = $this->model_customers->getCustomerData($userId);
			echo json_encode($customer_data);
		}
	}

	/*
	* It gets the all the active product inforamtion from the product table 
	* This function is used in the order page, for the product selection in the table
	* The response is return on the json format.
	*/
	public function getTableProductRow()
	{
		$products = $this->model_products->getActiveProductData();
		echo json_encode($products);
	}
public function process_update($id)
	{
		if(!in_array('updateOrder', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

		if(!$id) {
			redirect('dashboard', 'refresh');
		}

		$this->data['page_title'] = 'Process Order';

		$this->form_validation->set_rules('status', 'Customer name', 'trim|required');
		$this->data['user_data'] = $this->model_customers->getCustomerData();
	
	
        if ($this->form_validation->run() == TRUE) {        	
        	
        	$update = $this->model_orders->updateprocess($id);
        	
        	if($update == true) {
        		$order_row = $this->model_orders->getOrdersDataProcess($id);
        		$phone = $this->getOrderCustomerPhone($order_row);
        		$status_text = ($this->input->post('status') == 2) ? 'Delivered' : 'Under Process';
        		$message = 'Yeroo: Order #'.$order_row['bill_no'].' status updated to '.$status_text.'. Thank you!';
        		$this->sendOrderSms($id, $order_row['bill_no'], $phone, $message, 'status_change');

        		$this->session->set_flashdata('success', 'Successfully updated');
        		redirect('orders/process/'.$id, 'refresh');
        	}
        	else {
        		$this->session->set_flashdata('errors', 'Error occurred!!');
        		redirect('orders/process/'.$id, 'refresh');
        	}
        }
        else {
            // false case
        	$company = $this->model_company->getCompanyData(1);
        	$this->data['company_data'] = $company;
        	$this->data['is_vat_enabled'] = ($company['vat_charge_value'] > 0) ? true : false;
        	$this->data['is_service_enabled'] = ($company['service_charge_value'] > 0) ? true : false;

        	$result = array();
        	$orders_data = $this->model_orders->getOrdersDataProcess($id);

    		$result['order'] = $orders_data;
    		$orders_item = $this->model_orders->getOrdersItemData($orders_data['id']);

    		foreach($orders_item as $k => $v) {
    			$result['order_item'][] = $v;
    		}

    		$this->data['order_data'] = $result;
$this->data['payment'] = $this->model_orders->getPaymentData();
        	$this->data['products'] = $this->model_products->getActiveProductData();      	

            $this->render_template('orders/process_edit', $this->data);
        }
	}
	/*
	* Updates the process status of an order via AJAX (used by the quick buttons
	* on the process list page and the process_update page).
	*/
	public function updateProcessStatusAjax()
	{
		if(!in_array('updateOrder', $this->permission)) {
			echo json_encode(array('success' => false, 'messages' => 'Permission denied'));
			return;
		}

		$order_id = $this->input->post('order_id');
		$status = $this->input->post('status');

		if(!$order_id || !in_array($status, array('0', '1', '2'))) {
			echo json_encode(array('success' => false, 'messages' => 'Invalid arguments'));
			return;
		}

		if($this->model_orders->updateProcessStatus($order_id, $status)) {
			$order_row = $this->model_orders->getOrdersDataProcess($order_id);
			if($order_row && $status != '0') {
				$phone = $this->getOrderCustomerPhone($order_row);
				$status_text = ($status == '2') ? 'Delivered' : 'Under Process';
				$message = 'Yeroo: Order #'.$order_row['bill_no'].' status updated to '.$status_text.'. Thank you!';
				$this->sendOrderSms($order_id, $order_row['bill_no'], $phone, $message, 'status_change');
			}

			echo json_encode(array('success' => true, 'messages' => 'Successfully updated'));
		}
		else {
			echo json_encode(array('success' => false, 'messages' => 'Error occurred'));
		}
	}
	/*
	* If the validation is not valid, then it redirects to the edit orders page 
	* If the validation is successfully then it updates the data into the database 
	* and it stores the operation message into the session flashdata and display on the manage group page
	*/
	public function update($id)
	{
		if(!in_array('updateOrder', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

		if(!$id) {
			redirect('dashboard', 'refresh');
		}

		$this->data['page_title'] = 'Update Order';

		$this->form_validation->set_rules('product[]', 'Product name', 'trim|required');
		
	
        if ($this->form_validation->run() == TRUE) {        	
        	
        	$update = $this->model_orders->update($id);
        	
        	if($update == true) {
        		$this->session->set_flashdata('success', 'Successfully updated');
        		redirect('orders/update/'.$id, 'refresh');
        	}
        	else {
        		$this->session->set_flashdata('errors', 'Error occurred!!');
        		redirect('orders/update/'.$id, 'refresh');
        	}
        }
        else {
            // false case
        	$company = $this->model_company->getCompanyData(1);
        	$this->data['company_data'] = $company;
        	$this->data['is_vat_enabled'] = ($company['vat_charge_value'] > 0) ? true : false;
        	$this->data['is_service_enabled'] = ($company['service_charge_value'] > 0) ? true : false;

        	$result = array();
        	$orders_data = $this->model_orders->getOrdersData($id);

    		$result['order'] = $orders_data;
    		$orders_item = $this->model_orders->getOrdersItemData($orders_data['id']);

    		foreach($orders_item as $k => $v) {
    			$result['order_item'][] = $v;
    		}

    		$this->data['order_data'] = $result;
$this->data['payment'] = $this->model_orders->getPaymentData();
        	$this->data['products'] = $this->model_products->getActiveProductData();      	

            $this->render_template('orders/edit', $this->data);
        }
	}
public function update1($id)
	{
		if(!in_array('updateOrder', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

		if(!$id) {
			redirect('dashboard', 'refresh');
		}

		$this->data['page_title'] = 'Update Order';

		$this->form_validation->set_rules('product[]', 'Product name', 'trim|required');
		$this->data['user_data'] = $this->model_customers->getCustomerData();
	
	
        if ($this->form_validation->run() == TRUE) {        	
        	
        	$update = $this->model_orders->update1($id);
        	
        	if($update == true) {
        		$this->session->set_flashdata('success', 'Successfully updated');
        		redirect('orders/update1/'.$id, 'refresh');
        	}
        	else {
        		$this->session->set_flashdata('errors', 'Error occurred!!');
        		redirect('orders/update1/'.$id, 'refresh');
        	}
        }
        else {
            // false case
        	$company = $this->model_company->getCompanyData(1);
        	$this->data['company_data'] = $company;
        	$this->data['is_vat_enabled'] = ($company['vat_charge_value'] > 0) ? true : false;
        	$this->data['is_service_enabled'] = ($company['service_charge_value'] > 0) ? true : false;

        	$result = array();
        	$orders_data = $this->model_orders->getOrdersData1($id);

    		$result['order'] = $orders_data;
    		$orders_item = $this->model_orders->getOrdersItemData($orders_data['id']);

    		foreach($orders_item as $k => $v) {
    			$result['order_item'][] = $v;
    		}

    		$this->data['order_data'] = $result;
                

                        
        	$this->data['products'] = $this->model_products->getActiveProductData();      	

            $this->render_template('orders/edit_1', $this->data);
        }
	}
	
        
        public function payment($id)
	{
		if(!in_array('updateOrder', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

		if(!$id) {
			redirect('dashboard', 'refresh');
		}

		$this->data['page_title'] = 'Update Order';

		$this->form_validation->set_rules('product[]', 'Product name', 'trim|required');
		$this->data['user_data'] = $this->model_customers->getCustomerData();
	
	
        if ($this->form_validation->run() == TRUE) {        	
        	
        	$update = $this->model_orders->paymentupdate($id);
        	
        	if($update == true) {
        		$order_row = $this->model_orders->getOrdersData($id);
        		$phone = $this->getOrderCustomerPhone($order_row);
        		$paid_now = $this->input->post('remaining');
        		$message = 'Yeroo: Order #'.$order_row['bill_no'].'. Payment of ETB '.$paid_now.' received. Thank you!';
        		$this->sendOrderSms($id, $order_row['bill_no'], $phone, $message, 'payment');

        		$this->session->set_flashdata('success', 'Successfully updated');
        		redirect('orders/payment/'.$id, 'refresh');
        	}
        	else {
        		$this->session->set_flashdata('errors', 'Error occurred!!');
        		redirect('orders/payment/'.$id, 'refresh');
        	}
        }
        else {
            // false case
        	$company = $this->model_company->getCompanyData(1);
        	$this->data['company_data'] = $company;
        	$this->data['is_vat_enabled'] = ($company['vat_charge_value'] > 0) ? true : false;
        	$this->data['is_service_enabled'] = ($company['service_charge_value'] > 0) ? true : false;

        	$result = array();
        	$orders_data = $this->model_orders->getOrdersData($id);

    		$result['order'] = $orders_data;
    		$orders_item = $this->model_orders->getOrdersItemData($orders_data['id']);

    		foreach($orders_item as $k => $v) {
    			$result['order_item'][] = $v;
    		}

    		$this->data['order_data'] = $result;
                

                        
        	$this->data['products'] = $this->model_products->getActiveProductData();      	

        	$this->data['bank_accounts'] = $this->model_banks->getActiveBanks('bank');
        	$this->data['telebirr_accounts'] = $this->model_banks->getActiveBanks('telebirr');

            $this->render_template('orders/payment', $this->data);
        }
	}
        
      public function payment1($id)
	{
		if(!in_array('updateOrder', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

		if(!$id) {
			redirect('dashboard', 'refresh');
		}

		$this->data['page_title'] = 'Update Order';

		$this->form_validation->set_rules('product[]', 'Product name', 'trim|required');
		$this->data['user_data'] = $this->model_customers->getCustomerData();
	
	
        if ($this->form_validation->run() == TRUE) {        	
        	
        	$update = $this->model_orders->paymentupdate1($id);
        	
        	if($update == true) {
        		$order_row = $this->model_orders->getOrdersData1($id);
        		$phone = $this->getOrderCustomerPhone($order_row);
        		$paid_now = $this->input->post('remaining');
        		$message = 'Yeroo: Order #'.$order_row['bill_no'].'. Payment of ETB '.$paid_now.' received. Thank you!';
        		$this->sendOrderSms($id, $order_row['bill_no'], $phone, $message, 'payment');

        		$this->session->set_flashdata('success', 'Successfully updated');
        		redirect('orders/payment1/'.$id, 'refresh');
        	}
        	else {
        		$this->session->set_flashdata('errors', 'Error occurred!!');
        		redirect('orders/payment1/'.$id, 'refresh');
        	}
        }
        else {
            // false case
        	$company = $this->model_company->getCompanyData(1);
        	$this->data['company_data'] = $company;
        	$this->data['is_vat_enabled'] = ($company['vat_charge_value'] > 0) ? true : false;
        	$this->data['is_service_enabled'] = ($company['service_charge_value'] > 0) ? true : false;

        	$result = array();
        	$orders_data = $this->model_orders->getOrdersData1($id);

    		$result['order'] = $orders_data;
    		$orders_item = $this->model_orders->getOrdersItemData($orders_data['id']);

    		foreach($orders_item as $k => $v) {
    			$result['order_item'][] = $v;
    		}

    		$this->data['order_data'] = $result;
                

                        
        	$this->data['products'] = $this->model_products->getActiveProductData();      	

        	$this->data['bank_accounts'] = $this->model_banks->getActiveBanks('bank');
        	$this->data['telebirr_accounts'] = $this->model_banks->getActiveBanks('telebirr');

            $this->render_template('orders/payment_1', $this->data);
        }
	}  
        /*
	* It removes the data from the database
	* and it returns the response into the json format
	*/
	public function remove()
	{
		if(!in_array('deleteOrder', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

		$order_id = $this->input->post('order_id');

        $response = array();
        if($order_id) {
            $delete = $this->model_orders->remove($order_id);
            if($delete == true) {
                $response['success'] = true;
                $response['messages'] = "Successfully removed"; 
            }
            else {
                $response['success'] = false;
                $response['messages'] = "Error in the database while removing the product information";
            }
        }
        else {
            $response['success'] = false;
            $response['messages'] = "Refersh the page again!!";
        }

        echo json_encode($response); 
	}

	/*
	* It gets the product id and fetch the order data. 
	* The order print logic is done here 
	*/
	public function printDiv($id)
	{
		if(!in_array('viewOrder', $this->permission)) {
            redirect('dashboard', 'refresh');
        }
        
		if($id) {
			$order_data = $this->model_orders->getOrdersData($id);
			$orders_items = $this->model_orders->getOrdersItemData($id);
			$company_info = $this->model_company->getCompanyData(1);
 $ids = $order_data['id']; $users_data = $this->model_orders->getPaymentData($ids); 
   
			$order_date = date('d/m/Y', $order_data['date_time']);
			
                      $due_amount =  $users_data['paid_amount'] - $order_data['net_amount'];
                        
                        
if($order_data['paid_status'] == 2) {
				$paid_status = '<span class="label label-warning">Kaffaltii Dursa Qofa</span>';	
			}
			else 
                        if($order_data['paid_status'] == 1) {
				$paid_status = '<span class="label label-success">Kaffalamee jira</span>';	
			}
                        else 
                        if($order_data['paid_status'] == 0) {
				$paid_status = '<span class="label label-Danger">Hin kaffalmne</span>';	
			}
			$paper_w = $company_info['paper_width'] ? $company_info['paper_width'] : 80;
			$paper_h = $company_info['paper_height'] ? $company_info['paper_height'] : 297;
			$paper_css = '@page { size: '.$paper_w.'mm '.$paper_h.'mm; margin: 5mm; } @media print { body { -webkit-print-color-adjust: exact; } }';

			$html = '<!-- Main content -->
			<!DOCTYPE html>
			<html>
			<head>
			  <meta charset="utf-8">
			  <meta http-equiv="X-UA-Compatible" content="IE=edge">
			  <title>Mana Maxxansaa Yeroo </title>
			  <style>'.$paper_css.'</style>
			  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
			  <link rel="stylesheet" href="'.base_url('assets/bower_components/bootstrap/dist/css/bootstrap.min.css').'">
			  <link rel="stylesheet" href="'.base_url('assets/bower_components/font-awesome/css/font-awesome.min.css').'">
			  <link rel="stylesheet" href="'.base_url('assets/dist/css/AdminLTE.min.css').'">
			</head>
			<body onload="window.print();">
			<div style="position: fixed;
        bottom: 200px;
            left: 200px;
            z-index: 10000;
            font-size:10px;
            color: red;
            
            transform:rotate(-30deg);
            opacity: 0.6;">
 
</div>

			<div class="wrapper">
			  <section class="invoice">
			    <!-- title row -->
			    <div class="row">
			      <div class="col-xs-12">
                              <img  src="'.base_url('assets/images/yeroo.jpg').'" width="100%" height="80px">
			       
                                     
</div>			        

			      <!-- /.col -->
			    </div>
			    <!-- info row -->
			    <div class="row invoice-info">
			      <br>
                              <br>
			      <div class="col-sm-4 invoice-col">
			        <b>Guyyaa:</b> '.$order_date.'<br>
			        <b>Lakk. Nagahee:</b> '.$order_data['bill_no'].'<br>
			        <b>Maqaa Maamiila:</b> '.$order_data['customer_name'].'<br>
			        <b>Teessoo Maamiila:</b> '.$order_data['customer_address'].' <br />
			        <b>Bilbiila Maamiila:</b> '.$order_data['customer_phone'].'
			      </div>
			      <!-- /.col -->
			    </div>
			    <!-- /.row -->

			    <!-- Table row -->
			    <div class="row">
			      <div class="col-xs-12 table-responsive">
			        <table class="table table-striped">
			          <thead>
			          <tr>
			            <th>Maqaa Meesha</th>
			            
						<th>Balina</th>
						<th>Gatii tokkoo</th>
			            <th>Bayiina</th>
			            <th>idaama</th>
			          </tr>
			          </thead>
			          <tbody>'; 

			          foreach ($orders_items as $k => $v) {

			          	$product_data = $this->model_products->getProductData($v['product_id']); 
						  $hgt_wdth_text = ''; // Initialize the text for height and width

						  if (!empty($v['hgt']) && !empty($v['wdth'])) {
							  $hgt_wdth_text = $v['hgt'].'*'.$v['wdth'].'='.$v['kaaree'];
						  }
					  
						  $rate_text = $v['rate']; // Default text for rate
					  
						  if (!empty($v['kaaree'])) {
							  $rate_text = $v['rate'] . '*' . $v['kaaree'];
						  }
			          	$html .= '<tr>
						  <td>'.$product_data['name'].'</td>
						  <td>'.$hgt_wdth_text.'</td>
						 
						  <td>'.$rate_text.'</td>
						  <td>'.$v['qty'].'</td>
						  <td>'.$v['amount'].'</td>
			          	</tr>';
			          }
			          
			          $html .= '</tbody>
			        </table>
			      </div>
			      <!-- /.col -->
			    </div>
			    <!-- /.row -->

			    <div class="row">
			       
			      <div class="col-xs-6 pull pull-right">

			        <div class="table-responsive">
			          <table class="table">
			          ';

			            if($order_data['service_charge'] > 0) {
			            	$html .= '<tr>
				              <th>Gatii Tajaajiila ('.$order_data['service_charge_rate'].'%)</th>
				              <td>'.$order_data['service_charge'].'</td>
				            </tr>';
			            }

			            if($order_data['vat_charge'] > 0) {
			            	$html .= '<tr>
				              <th>TOT ('.$order_data['vat_charge_rate'].'%)</th>
				              <td>'.$order_data['vat_charge'].'</td>
				            </tr>';
			            }
			            
			            
			            $html .=' <tr>
			              <th>Hirriifama:</th>
			              <td>'.$order_data['discount'].'</td>
			            </tr>
			            <tr>
			              <th>Gatii Waliigalaa:</th>
			              <td>'.$order_data['net_amount'].'</td>
			            </tr>
			            <tr>
			              <th>Haala Kaffaltii :</th>
			              <td>'.$paid_status.'</td>
			            </tr>
                                    <tr>
			              <th>Kaffaltii Dursaa  :</th>
			              <td>Qar.'.$users_data['paid_amount'].'</td>
			            </tr>
                                    <tr>
			              <th>Haaftee :</th>
			              <td>Qar.'.$due_amount.'</td>
			            </tr>
			          </table>
			        </div>
			      </div>
			      <!-- /.col -->
			    </div>
                            <div class="row">
			       
			      <div class="col-xs-12">
                              <img  src="'.base_url('assets/images/footer.jpg').'" width="100%" height="50px">
</div>
                            
</div>
			    <!-- /.row -->
			  </section>
			  <!-- /.content -->
			</div>
		</body>
	</html>';

			  echo $html;
		}
	}
public function printDiv1($id)
	{
		if(!in_array('viewOrder', $this->permission)) {
            redirect('dashboard', 'refresh');
        }
        
		if($id) {
			$order_data = $this->model_orders->getOrdersData1($id);
			$orders_items = $this->model_orders->getOrdersItemData($id);
			$company_info = $this->model_company->getCompanyData(1);
 $ids = $order_data['id']; $users_data = $this->model_orders->getPaymentData($ids); 
   $idss=$order_data['customer_name'];
                        $users_name = $this->model_customers->getCustomerData($idss);
			$order_date = date('d/m/Y', $order_data['date_time']);
			
                      $due_amount =  $users_data['paid_amount'] - $order_data['net_amount'];
                        
                        
if($order_data['paid_status'] == 2) {
				$paid_status = '<span class="label label-warning">Kaffaltii Dursa Qofa</span>';	
			}
			else 
                        if($order_data['paid_status'] == 1) {
				$paid_status = '<span class="label label-success">Kaffalamee jira</span>';	
			}
                        else 
                        if($order_data['paid_status'] == 0) {
				$paid_status = '<span class="label label-Danger">Hin kaffalmne</span>';	
			}
			$paper_w = $company_info['paper_width'] ? $company_info['paper_width'] : 80;
			$paper_h = $company_info['paper_height'] ? $company_info['paper_height'] : 297;
			$paper_css = '@page { size: '.$paper_w.'mm '.$paper_h.'mm; margin: 5mm; } @media print { body { -webkit-print-color-adjust: exact; } }';

			$html = '<!-- Main content -->
			<!DOCTYPE html>
			<html>
			<head>
			  <meta charset="utf-8">
			  <meta http-equiv="X-UA-Compatible" content="IE=edge">
			  <title>Mana Maxxansaa Yeroo </title>
			  <style>'.$paper_css.'</style>
			  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
			  <link rel="stylesheet" href="'.base_url('assets/bower_components/bootstrap/dist/css/bootstrap.min.css').'">
			  <link rel="stylesheet" href="'.base_url('assets/bower_components/font-awesome/css/font-awesome.min.css').'">
			  <link rel="stylesheet" href="'.base_url('assets/dist/css/AdminLTE.min.css').'">
			</head>
			<body onload="window.print();">
			
			<div class="wrapper">
			  <section class="invoice">
			    <!-- title row -->
			    <div class="row">
			      <div class="col-xs-12">
			       
                                <img  src="'.base_url('assets/images/yeroo.jpg').'" width="100%" height="80px">
			       
			         
</div>			        

			      <!-- /.col -->
			    </div>
			    <!-- info row -->
			    <div class="row invoice-info">
			      <br>
                              <br>
			      <div class="col-sm-6 invoice-col">
			       <b>Date:</b> '.$order_date.'<br>
			        <b>Lakk. Nagahee:</b> '.$order_data['bill_no'].'<br>
			        <b>Maqaa Maamiila:</b> '.$users_name['oname']
				.'<br>
			        <b>Teessoo Maamiila:</b> '.$users_name['oaddress'].' <br />
			        <b>Bilbiila Maamiila:</b> '.$users_name['phone'].'
			      </div>
			      <!-- /.col -->
			    </div>
			    <!-- /.row -->

			    <!-- Table row -->
			    <div class="row">
			      <div class="col-xs-12 table-responsive">
			        <table class="table table-striped">
			          <thead>
			          <tr>
			            <th>Maqaa Meesha</th>
			            
						<th>Balina</th>
						<th>Gatii tokkoo</th>
			            <th>Bayiina</th>
			            <th>idaama</th>
			          </tr>
			          </thead>
			          <tbody>'; 

			          foreach ($orders_items as $k => $v) {

			          	$product_data = $this->model_products->getProductData($v['product_id']); 
						  $hgt_wdth_text = ''; // Initialize the text for height and width

						  if (!empty($v['hgt']) && !empty($v['wdth'])) {
							  $hgt_wdth_text = $v['hgt'].'*'.$v['wdth'].'='.$v['kaaree'];
						  }
					  
						  $rate_text = $v['rate']; // Default text for rate
					  
						  if (!empty($v['kaaree'])) {
							  $rate_text = $v['rate'] . '*' . $v['kaaree'];
						  }
			          	$html .= '<tr>
						  <td>'.$product_data['name'].'</td>
						  <td>'.$hgt_wdth_text.'</td>
						 
						  <td>'.$rate_text.'</td>
						  <td>'.$v['qty'].'</td>
						  <td>'.$v['amount'].'</td>
			          	</tr>';
			          }
			          
			          $html .= '</tbody>
			        </table>
			      </div>
			      <!-- /.col -->
			    </div>
			    <!-- /.row -->

			    <div class="row">
			       
			      <div class="col-xs-6 pull pull-right">

			        <div class="table-responsive">
			          <table class="table">
			          ';

			            if($order_data['service_charge'] > 0) {
			            	$html .= '<tr>
				              <th>Gatii Tajaajiila ('.$order_data['service_charge_rate'].'%)</th>
				              <td>'.$order_data['service_charge'].'</td>
				            </tr>';
			            }

			            if($order_data['vat_charge'] > 0) {
			            	$html .= '<tr>
				              <th>TOT ('.$order_data['vat_charge_rate'].'%)</th>
				              <td>'.$order_data['vat_charge'].'</td>
				            </tr>';
			            }
			            
			            
			            $html .=' <tr>
			              <th>Hirriifama:</th>
			              <td>'.$order_data['discount'].'</td>
			            </tr>
			            <tr>
			              <th>Gatii Waliigalaa:</th>
			              <td>'.$order_data['net_amount'].'</td>
			            </tr>
			            <tr>
			              <th>Haala Kaffaltii :</th>
			              <td>'.$paid_status.'</td>
			            </tr>
                                    <tr>
			              <th>Kaffaltii Dursaa  :</th>
			              <td>Qar.'.$users_data['paid_amount'].'</td>
			            </tr>
                                    <tr>
			              <th>Haaftee :</th>
			              <td>Qar.'.$due_amount.'</td>
			            </tr>
			          </table>
			        </div>
			      </div>
			      <!-- /.col -->
			    </div>
			    <!-- /.row -->
                                        <div class="row">
			       
			      <div class="col-xs-12">
                              <img  src="'.base_url('assets/images/footer.jpg').'" width="100%" height="50px">
</div>
                            
</div>


			  </section>
			  <!-- /.content -->
			</div>
		</body>
	</html>';

			  echo $html;
		}
	}

	/*
	* Displays the SMS log history page
	*/
	public function sms_log()
	{
		if(!in_array('viewOrder', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

		$this->data['page_title'] = 'SMS Log';
		$this->render_template('sms/index', $this->data);		
	}

	/*
	* Fetches the SMS log data for the datatable
	*/
	public function fetchSmsLogData()
	{
		$result = array('data' => array());

		$data = $this->model_sms->getSmsLog();

		foreach ($data as $key => $value) {
			$date = date('d-m-Y h:i a', $value['created_at']);

			if($value['status'] == 1) {
				$status = '<span class="label label-success">Sent</span>';
			}
			else if($value['status'] == 0) {
				$status = '<span class="label label-danger">Failed</span>';
			}

			$result['data'][$key] = array(
				$value['id'],
				$value['bill_no'],
				$value['phone'],
				$value['sms_type'],
				$value['message'],
				$status,
				$date
			);
		}

		echo json_encode($result);
	}

	/*
	* Test endpoint to send a single SMS to verify the GeeSMS integration
	*/
	public function send_test_sms()
	{
		if(!in_array('viewOrder', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

		$company = $this->model_company->getCompanyData(1);
		$phone = $this->input->post('phone');
		$message = $this->input->post('message');
		$token = $this->input->post('token');
		$shortcode = $this->input->post('shortcode');

		if(empty($phone) || empty($message)) {
			echo json_encode(array('success' => false, 'message' => 'Phone and message are required.'));
			return;
		}

		if(empty($token)) {
			$token = isset($company['sms_token']) ? $company['sms_token'] : '';
		}
		if(empty($shortcode)) {
			$shortcode = isset($company['sms_shortcode']) ? $company['sms_shortcode'] : '';
		}

		if(empty($token)) {
			echo json_encode(array('success' => false, 'message' => 'No API token configured. Enter your GeeSMS token first.'));
			return;
		}

		$this->config->set_item('geezsms_token', $token);
		$this->config->set_item('geezsms_shortcode', $shortcode);
		$this->config->set_item('geezsms_enabled', 1);

		$sent = $this->geezsms->send($phone, $message);

		if($sent) {
			echo json_encode(array('success' => true, 'message' => 'SMS sent successfully.'));
		}
		else {
			$api_response = $this->geezsms->last_response;
			$api_response_text = (is_array($api_response)) ? json_encode($api_response) : (string)$api_response;
			echo json_encode(array('success' => false, 'message' => 'SMS failed. Response: '.$api_response_text));
		}
	}

	/*
	* Verifies a Telebirr transaction/receipt number against the
	* Ethio Telecom transaction info service.
	* Returns the parsed receipt details as JSON.
	* Expected POST: tt_number
	*/
	public function verify_telebirr()
	{
		if(!in_array('viewOrder', $this->permission) && !in_array('createOrder', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

		$tt_number = $this->input->post('tt_number');

		$result = $this->telebirr->verify($tt_number);

		// cross-check the credited party account against the configured telebirr accounts
		$accounts = $this->model_banks->getActiveBanks('telebirr');
		$expected_accounts = array();
		foreach($accounts as $account) {
			$expected_accounts[] = trim($account['account_number']);
		}

		$result['account_matches'] = false;
		if(!empty($expected_accounts) && $result['found'] && !empty($result['credited_account'])) {
			$result['account_matches'] = in_array(trim($result['credited_account']), $expected_accounts);
		}

		// overall verification result: found + completed for today
		$result['verified'] = (
			$result['found'] &&
			strcasecmp($result['status'], 'Completed') === 0 &&
			$result['is_today']
		);

		echo json_encode($result);
	}
}