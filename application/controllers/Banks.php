<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Banks extends Admin_Controller 
{
	public function __construct()
	{
		parent::__construct();

		$this->not_logged_in();

		$this->data['page_title'] = 'Payment Accounts';

		$this->load->model('model_banks');
	}

	/*
	* It only redirects to the manage payment accounts page
	*/
	public function index()
	{
		if(!in_array('updateSetting', $this->permission)) {
			redirect('dashboard', 'refresh');
		}

		$result = $this->model_banks->getBankData();

		$this->data['results'] = $result;

		$this->render_template('banks/index', $this->data);
	}

	/*
	* Fetches the bank data from the banks table 
	* this function is called from the datatable ajax function
	*/
	public function fetchBankData()
	{
		$result = array('data' => array());

		$data = $this->model_banks->getBankData();
		foreach ($data as $key => $value) {

			// button
			$buttons = '';

			if(in_array('updateSetting', $this->permission)) {
				$buttons .= '<button type="button" class="btn btn-default" onclick="editBank('.$value['id'].')" data-toggle="modal" data-target="#editBankModal"><i class="fa fa-pencil"></i></button>';	
			}
			
			if(in_array('updateSetting', $this->permission)) {
				$buttons .= ' <button type="button" class="btn btn-default" onclick="removeBank('.$value['id'].')" data-toggle="modal" data-target="#removeBankModal"><i class="fa fa-trash"></i></button>
				';
			}				

			$status = ($value['is_active'] == 1) ? '<span class="label label-success">Active</span>' : '<span class="label label-warning">Inactive</span>';
			$default = ($value['is_default'] == 1) ? '<span class="label label-info">Default</span>' : '';
			$category = ($value['category'] == 'telebirr') ? '<span class="label label-primary">Telebirr</span>' : '<span class="label label-success">Bank Transfer</span>';

			$result['data'][$key] = array(
				$value['id'],
				$value['bank_name'],
				$value['account_name'],
				$value['account_number'],
				$category,
				$status . ' ' . $default,
				$buttons
			);
		} // /foreach

		echo json_encode($result);
	}

	/*
	* It checks if it gets the bank id and retreives
	* the bank information from the bank model and 
	* returns the data into json format. 
	* This function is invoked from the view page.
	*/
	public function fetchBankDataById($id)
	{
		if($id) {
			$data = $this->model_banks->getBankData($id);
			echo json_encode($data);
		}

		return false;
	}

	/*
	* Its checks the bank form validation 
	* and if the validation is successfully then it inserts the data into the database 
	* and returns the json format operation messages
	*/
	public function create()
	{
		if(!in_array('updateSetting', $this->permission)) {
			redirect('dashboard', 'refresh');
		}

		$response = array();

		$this->form_validation->set_rules('bank_name', 'Bank / Account Name', 'trim|required');
		$this->form_validation->set_rules('account_name', 'Account Holder Name', 'trim|required');
		$this->form_validation->set_rules('account_number', 'Account Number', 'trim|required');
		$this->form_validation->set_rules('category', 'Category', 'trim|required');

		$this->form_validation->set_error_delimiters('<p class="text-danger">','</p>');

        if ($this->form_validation->run() == TRUE) {
        	$data = array(
        		'bank_name' => $this->input->post('bank_name'),
        		'account_name' => $this->input->post('account_name'),
        		'account_number' => $this->input->post('account_number'),
        		'account_type' => $this->input->post('account_type'),
        		'category' => $this->input->post('category'),
        		'is_default' => ($this->input->post('is_default') == 1) ? 1 : 0,
        		'is_active' => ($this->input->post('is_active') == 1) ? 1 : 0,
        		'created_at' => date('Y-m-d H:i:s'),
        	);

        	// ensure only one active default per category
        	if($data['is_default'] == 1) {
        		$this->model_banks->resetDefault($data['category']);
        	}

        	$create = $this->model_banks->create($data);
        	if($create == true) {
        		$response['success'] = true;
        		$response['messages'] = 'Succesfully created';
        	}
        	else {
        		$response['success'] = false;
        		$response['messages'] = 'Error in the database while creating the bank information';			
        	}
        }
        else {
        	$response['success'] = false;
        	foreach ($_POST as $key => $value) {
        		$response['messages'][$key] = form_error($key);
        	}
        }

        echo json_encode($response);

	}

	/*
	* Its checks the bank form validation 
	* and if the validation is successfully then it updates the data into the database 
	* and returns the json format operation messages
	*/
	public function update($id)
	{
		if(!in_array('updateSetting', $this->permission)) {
			redirect('dashboard', 'refresh');
		}

		$response = array();

		if($id) {
			$this->form_validation->set_rules('edit_bank_name', 'Bank / Account Name', 'trim|required');
			$this->form_validation->set_rules('edit_account_name', 'Account Holder Name', 'trim|required');
			$this->form_validation->set_rules('edit_account_number', 'Account Number', 'trim|required');
			$this->form_validation->set_rules('edit_category', 'Category', 'trim|required');

			$this->form_validation->set_error_delimiters('<p class="text-danger">','</p>');

	        if ($this->form_validation->run() == TRUE) {
	        	$data = array(
	        		'bank_name' => $this->input->post('edit_bank_name'),
	        		'account_name' => $this->input->post('edit_account_name'),
	        		'account_number' => $this->input->post('edit_account_number'),
	        		'account_type' => $this->input->post('edit_account_type'),
	        		'category' => $this->input->post('edit_category'),
	        		'is_default' => ($this->input->post('edit_is_default') == 1) ? 1 : 0,
	        		'is_active' => ($this->input->post('edit_is_active') == 1) ? 1 : 0,
	        	);

	        	if($data['is_default'] == 1) {
	        		$this->model_banks->resetDefault($data['category']);
	        	}

	        	$update = $this->model_banks->update($data, $id);
	        	if($update == true) {
	        		$response['success'] = true;
	        		$response['messages'] = 'Succesfully updated';
	        	}
	        	else {
	        		$response['success'] = false;
	        		$response['messages'] = 'Error in the database while updating the bank information';			
	        	}
	        }
	        else {
	        	$response['success'] = false;
	        	foreach ($_POST as $key => $value) {
	        		$response['messages'][$key] = form_error($key);
	        	}
	        }
		}
		else {
			$response['success'] = false;
    		$response['messages'] = 'Error please refresh the page again!!';
		}

		echo json_encode($response);
	}

	/*
	* It removes the bank information from the database 
	* and returns the json format operation messages
	*/
	public function remove()
	{
		if(!in_array('updateSetting', $this->permission)) {
			redirect('dashboard', 'refresh');
		}
		
		$bank_id = $this->input->post('bank_id');
		$response = array();
		if($bank_id) {
			$delete = $this->model_banks->remove($bank_id);

			if($delete == true) {
				$response['success'] = true;
				$response['messages'] = "Successfully removed";	
			}
			else {
				$response['success'] = false;
				$response['messages'] = "Error in the database while removing the bank information";
			}
		}
		else {
			$response['success'] = false;
			$response['messages'] = "Refersh the page again!!";
		}

		echo json_encode($response);
	}

}