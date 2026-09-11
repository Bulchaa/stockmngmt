<?php  

defined('BASEPATH') OR exit('No direct script access allowed');

class Reports extends Admin_Controller 
{	
	public function __construct()
	{
		parent::__construct();
		$this->data['page_title'] = 'Stores';
		$this->load->model('model_reports');
                $this->load->model('model_customers');
		$this->load->model('model_orders');
		$this->load->model('model_products');
		$this->load->model('model_company');
	}

	/* 
    * It redirects to the report page
    * and based on the year, all the orders data are fetch from the database.
    */
	public function index()
	{
		if(!in_array('viewReports', $this->permission)) {
            redirect('dashboard', 'refresh');
        }
		
		$today_year = date('Y');

		if($this->input->post('select_year')) {
			$today_year = $this->input->post('select_year');
		}

		$parking_data = $this->model_reports->getOrderData($today_year);
		$this->data['report_years'] = $this->model_reports->getOrderYear();
		

		$final_parking_data = array();
		foreach ($parking_data as $k => $v) {
			
			if(count($v) > 1) {
				$total_amount_earned = array();
				foreach ($v as $k2 => $v2) {
					if($v2) {
						$total_amount_earned[] = $v2['gross_amount'];						
					}
				}
				$final_parking_data[$k] = array_sum($total_amount_earned);	
			}
			else {
				$final_parking_data[$k] = 0;	
			}
			
		}
		
		$this->data['selected_year'] = $today_year;
		$this->data['company_currency'] = $this->company_currency();
		$this->data['results'] = $final_parking_data;

		$this->render_template('reports/index', $this->data);
	}
           function treatmentReport() {
       
        

        $date_from = strtotime($this->input->post('date_from'));
        $date_to = strtotime($this->input->post('date_to'));
        if (!empty($date_to)) {
            $date_to = $date_to + 24 * 60 * 60;
        }

        if (empty($date_from) || empty($date_to)) {
            $data['appointments'] = $this->model_reports->getPaymentsData();
        } else {
            $data['appointments'] = $this->model_reports->getPaymentsDataByDate($date_from, $date_to);
            $data['from'] = $this->input->post('date_from');
            $data['to'] = $this->input->post('date_to');
        }

     
    }
        
        public function sales()
	{
		if(!in_array('viewReports', $this->permission)) {
            redirect('dashboard', 'refresh');
        }
		$date_from = strtotime($this->input->post('date_from'));
        $date_to = strtotime($this->input->post('date_to'));
        if (!empty($date_to)) {
            $date_to = $date_to + 24 * 60 * 60;
        }
        if (empty($date_from) || empty($date_to)) {
            $this->data['users_data'] = $this->model_customers->getCustomerData();
            $this->data['orders_data'] = $this->model_orders->getOrdersData();
            $this->data['total'] = $this->model_reports->getPaymentsData();
		$data2 = $this->model_reports->getPaymentsData();
		$result = array();
                foreach ($data2 as $key => $value) {$result[$key]['payment_info'] = $value;
	}
                $this->data['user_data'] = $result;
		 } else {	
                      $this->data['total'] = $this->model_reports->getPaymentsDataByDate($date_from, $date_to);  
$data2 = $this->model_reports->getPaymentsDataByDate($date_from, $date_to);
		$result = array();
                foreach ($data2 as $key => $value) {$result[$key]['payment_info'] = $value;
}
                $this->data['user_data'] = $result;
		  $data['from'] = $this->input->post('date_from');
            $data['to'] = $this->input->post('date_to');	
                        
                        
                 }
		$this->render_template('reports/sales', $this->data);
	}
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
        
        
        
         public function fetchOrdersData2()
	{
		$result = array('data' => array());

		
$data2 = $this->model_reports->getPaymentsData();
		foreach ($data2 as $key => $value) {

			
			$date = date('d-m-Y', $value['datetime']);
			$time = date('h:i a', $value['datetime']);

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

			if($value['payment_status'] == 2) {
				$paid_status = '<span class="label label-warning">Advance Payment</span>';	
			}
			else 
                        if($value['payment_status'] == 1) {
				$paid_status = '<span class="label label-success">Paid</span>';	
			}
                        else 
                        if($value['payment_status'] == 0) {
				$paid_status = '<span class="label label-danger">Loan</span>';	
			}
                        if($value['payment_types'] == 3) {
				$paid_types = '<span class="label label-primary">Telebirr</span>';	
			}
			else 
                        if($value['payment_types'] == 2) {
				$paid_types = '<span class="label label-warning">Transfer (Mobile)</span>';	
			}
			else 
                        if($value['payment_types'] == 1) {
				$paid_types = '<span class="label label-success">Transfer</span>';	
			}
                        else 
                        if($value['payment_types'] == 0) {
				$paid_types = '<span class="label label-danger">Cash</span>';	
			}
                        

			$result['data'][$key] = array(
				$value['bill_no'],
				$value['customer_name'],
				$value['customer_types'],
				$date_time,
				
				$value['total_amount'],
                            $value['paid_amount'],
                            $value['due_amount'],
                            $paid_types,
				$paid_status,
				$buttons
			);
		} // /foreach

		echo json_encode($result);
	}
}	