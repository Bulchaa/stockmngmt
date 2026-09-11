<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Configuration extends Admin_Controller 
{
	public function __construct()
	{
		parent::__construct();

		$this->not_logged_in();

		$this->data['page_title'] = 'System Configuration';

		$this->load->model('model_company');
		$this->load->model('model_banks');
	}

	/*
	* Renders the System Configuration page with tabbed panes:
	* Company, Payment Accounts, Printer, Paper size.
	*/
	public function index()
	{
		if(!in_array('updateCompany', $this->permission) && !in_array('updateSetting', $this->permission)) {
			redirect('dashboard', 'refresh');
		}

		$this->data['company_data'] = $this->model_company->getCompanyData(1);
		$this->data['currency_symbols'] = $this->currency();
		$this->data['bank_accounts'] = $this->model_banks->getBankData();

		// remember the active tab after a form save
		$this->data['active_tab'] = ($this->session->flashdata('active_tab')) ? $this->session->flashdata('active_tab') : 'company';

		// pre-load partials into strings so the shell view just echoes them
		$this->data['company_partial'] = $this->load->view('configuration/partials/company', $this->data, TRUE);
		$this->data['banks_partial']   = $this->load->view('configuration/partials/banks', $this->data, TRUE);
		$this->data['printer_partial'] = $this->load->view('configuration/partials/printer', $this->data, TRUE);
		$this->data['paper_partial']   = $this->load->view('configuration/partials/paper', $this->data, TRUE);

		$this->render_template('configuration/index', $this->data);
	}

	/*
	* Saves the Company tab form (company details + SMS settings).
	*/
	public function update_company()
	{
		if(!in_array('updateCompany', $this->permission)) {
			redirect('dashboard', 'refresh');
		}

		$this->form_validation->set_rules('company_name', 'Company name', 'trim|required');
		$this->form_validation->set_rules('service_charge_value', 'Charge Amount', 'trim|integer');
		$this->form_validation->set_rules('vat_charge_value', 'Vat Charge', 'trim|integer');
		$this->form_validation->set_rules('address', 'Address', 'trim|required');
		$this->form_validation->set_rules('message', 'Message', 'trim|required');

		if($this->form_validation->run() == TRUE) {
			$data = array(
				'company_name' => $this->input->post('company_name'),
				'service_charge_value' => $this->input->post('service_charge_value'),
				'vat_charge_value' => $this->input->post('vat_charge_value'),
				'address' => $this->input->post('address'),
				'phone' => $this->input->post('phone'),
				'country' => $this->input->post('country'),
				'message' => $this->input->post('message'),
				'website' => $this->input->post('website'),
				'telegram' => $this->input->post('telegram'),
				'facebook' => $this->input->post('facebook'),
				'tiktok' => $this->input->post('tiktok'),
				'currency' => $this->input->post('currency'),
				'sms_enabled' => ($this->input->post('sms_enabled') == '1') ? 1 : 0,
				'sms_token' => $this->input->post('sms_token'),
				'sms_shortcode' => $this->input->post('sms_shortcode')
			);

			$update = $this->model_company->update($data, 1);
			if($update == true) {
				$this->session->set_flashdata('success', 'Company information updated successfully.');
				$this->session->set_flashdata('active_tab', 'company');
			}
			else {
				$this->session->set_flashdata('error', 'Error occurred while updating company information.');
				$this->session->set_flashdata('active_tab', 'company');
			}
		}
		else {
			$this->session->set_flashdata('error', 'Please fill all required fields.');
			$this->session->set_flashdata('active_tab', 'company');
		}

		redirect('configuration/', 'refresh');
	}

	/*
	* Saves the Printer tab form.
	*/
	public function update_printer()
	{
		if(!in_array('updateSetting', $this->permission)) {
			redirect('dashboard', 'refresh');
		}

		$this->form_validation->set_rules('printer_type', 'Printer Type', 'trim|required');

		if($this->form_validation->run() == TRUE) {
			$data = array(
				'printer_type' => $this->input->post('printer_type'),
			);

			$update = $this->model_company->update($data, 1);
			if($update == true) {
				$this->session->set_flashdata('success', 'Printer settings updated successfully.');
			}
			else {
				$this->session->set_flashdata('error', 'Error occurred while updating printer settings.');
			}
			$this->session->set_flashdata('active_tab', 'printer');
		}
		else {
			$this->session->set_flashdata('error', 'Please select a printer type.');
			$this->session->set_flashdata('active_tab', 'printer');
		}

		redirect('configuration/', 'refresh');
	}

	/*
	* Saves the Paper tab form (paper size in mm).
	*/
	public function update_paper()
	{
		if(!in_array('updateSetting', $this->permission)) {
			redirect('dashboard', 'refresh');
		}

		$this->form_validation->set_rules('paper_size', 'Paper Size', 'trim|required');
		$this->form_validation->set_rules('paper_width', 'Paper Width (mm)', 'trim|required|integer|greater_than[0]');
		$this->form_validation->set_rules('paper_height', 'Paper Height (mm)', 'trim|required|integer|greater_than[0]');

		if($this->form_validation->run() == TRUE) {
			$data = array(
				'paper_size' => $this->input->post('paper_size'),
				'paper_width' => $this->input->post('paper_width'),
				'paper_height' => $this->input->post('paper_height'),
			);

			$update = $this->model_company->update($data, 1);
			if($update == true) {
				$this->session->set_flashdata('success', 'Paper size updated successfully.');
			}
			else {
				$this->session->set_flashdata('error', 'Error occurred while updating paper size.');
			}
			$this->session->set_flashdata('active_tab', 'paper');
		}
		else {
			$this->session->set_flashdata('error', 'Please fill the paper size correctly.');
			$this->session->set_flashdata('active_tab', 'paper');
		}

		redirect('configuration/', 'refresh');
	}

}