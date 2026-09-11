<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Site extends CI_Controller
{
	public function index()
	{
		$html = file_get_contents(FCPATH . 'site.html');

		if($html) {
			$html = str_replace(
				array('{{ERP_LOGIN}}', '{{ERP_BASE}}'),
				array(base_url('auth/login'), base_url()),
				$html
			);
		}

		$this->output->set_content_type('text/html')->set_output($html);
	}
}