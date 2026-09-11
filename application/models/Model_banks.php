<?php 

class Model_banks extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	/* get the active banks information */
	public function getActiveBanks($category = null)
	{
		if($category) {
			$sql = "SELECT * FROM `banks` WHERE is_active = 1 AND category = ?";
			$query = $this->db->query($sql, array($category));
			return $query->result_array();
		}

		$sql = "SELECT * FROM `banks` WHERE is_active = 1";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	/* get the bank data */
	public function getBankData($id = null)
	{
		if($id) {
			$sql = "SELECT * FROM `banks` WHERE id = ?";
			$query = $this->db->query($sql, array($id));
			return $query->row_array();
		}

		$sql = "SELECT * FROM `banks` ORDER BY is_default DESC, id DESC";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	/* get the default bank for a category */
	public function getDefaultBank($category = null)
	{
		if($category) {
			$sql = "SELECT * FROM `banks` WHERE is_active = 1 AND is_default = 1 AND category = ?";
			$query = $this->db->query($sql, array($category));
			$row = $query->row_array();
			if($row) {
				return $row;
			}
		}

		$sql = "SELECT * FROM `banks` WHERE is_active = 1 AND category = ? LIMIT 1";
		$query = $this->db->query($sql, array($category));
		return $query->row_array();
	}

	/* releases the default flag from all active accounts of a category */
	public function resetDefault($category)
	{
		$this->db->where('category', $category);
		$this->db->update('banks', array('is_default' => 0));
	}

	public function create($data)
	{
		if($data) {
			$insert = $this->db->insert('banks', $data);
			return ($insert == true) ? true : false;
		}
	}

	public function update($data, $id)
	{
		if($data && $id) {
			$this->db->where('id', $id);
			$update = $this->db->update('banks', $data);
			return ($update == true) ? true : false;
		}
	}

	public function remove($id)
	{
		if($id) {
			$this->db->where('id', $id);
			$delete = $this->db->delete('banks');
			return ($delete == true) ? true : false;
		}
	}

}