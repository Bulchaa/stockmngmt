<?php 

class Model_sms extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	/*
	* Logs an SMS record into the sms_log table.
	*/
	public function logSms($data)
	{
		if(!empty($data)) {
			$insert = $this->db->insert('sms_log', $data);
			return ($insert) ? $this->db->insert_id() : false;
		}
		return false;
	}

	/*
	* Returns all SMS log entries.
	*/
	public function getSmsLog($id = null)
	{
		if($id) {
			$sql = "SELECT * FROM `sms_log` WHERE id = ?";
			$query = $this->db->query($sql, array($id));
			return $query->row_array();
		}

		$sql = "SELECT * FROM `sms_log` ORDER BY id DESC";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	/*
	* Returns a single SMS log entry by order id.
	*/
	public function getSmsLogByOrder($order_id)
	{
		$sql = "SELECT * FROM `sms_log` WHERE order_id = ? ORDER BY id DESC";
		$query = $this->db->query($sql, array($order_id));
		return $query->result_array();
	}

	/*
	* Deletes an SMS log entry.
	*/
	public function remove($id)
	{
		if($id) {
			$this->db->where('id', $id);
			$delete = $this->db->delete('sms_log');
			return ($delete) ? true : false;
		}
		return false;
	}
}