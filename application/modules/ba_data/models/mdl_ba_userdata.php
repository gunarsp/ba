<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

class Mdl_ba_Userdata extends MY_Model {

	public $settings;

	public function get($user_id, $key) {

		$this->db->select('ba_userdata_value');

		$this->db->where('ba_userdata_user_id', $user_id);
		$this->db->where('ba_userdata_key', $key);

		$query = $this->db->get('ba_userdata');

		if ($query->row()) {

			return $query->row()->ba_userdata_value;

		}

		else {

			return NULL;

		}

	}

	public function save($user_id, $key, $value) {

		if (!is_null($this->get($user_id, $key))) {

			$this->db->where('ba_userdata_user_id', $user_id);
			$this->db->where('ba_userdata_key', $key);

			$db_array = array(
				'ba_userdata_value'	=>	$value
			);

			$this->db->update('ba_userdata', $db_array);

		}

		else {

			$db_array = array(
				'ba_userdata_user_id'	=>	$user_id,
				'ba_userdata_key'		=>	$key,
				'ba_userdata_value'	=>	$value
			);

			$this->db->insert('ba_userdata', $db_array);

		}

	}

	public function delete($user_id, $key) {

		$this->db->where('ba_userdata_user_id', $user_id);
		$this->db->where('ba_userdata_key', $key);

		$this->db->delete('ba_userdata');

	}

	public function set_session_data($user_id) {

		$this->db->where('ba_userdata_user_id', $user_id);

		$ba_userdata = $this->db->get('ba_userdata')->result();

		foreach ($ba_userdata as $data) {

			$this->settings->{$data->ba_userdata_key} = $data->ba_userdata_value;

		}

	}

	public function setting($key) {

		return (isset($this->settings->$key)) ? $this->settings->$key : NULL;

	}

	public function set_setting($key, $value) {

		$this->settings->$key = $value;

	}

	public function save_settings($user_id, $user_settings) {

		foreach ($user_settings as $key=>$value) {

			$this->mdl_ba_userdata->save($user_id, $key, $value);

		}

	}

}

?>