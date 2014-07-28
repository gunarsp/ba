<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

class Mdl_ba_Client_Data extends MY_Model {

    public $settings;

	public function get($client_id, $key) {

		$this->db->select('ba_client_value');

		$this->db->where('ba_client_key', $key);

		$this->db->where('client_id', $client_id);

		$query = $this->db->get('ba_client_data');

		if ($query->row()) {

			return $query->row()->ba_client_value;

		}

		else {

			return NULL;

		}

	}

	public function save($client_id, $key, $value) {

		if (!is_null($this->get($client_id, $key))) {

			$this->db->where('ba_client_key', $key);

			$this->db->where('client_id', $client_id);

			$db_array = array(
				'ba_client_value'	=>	$value
			);

			$this->db->update('ba_client_data', $db_array);

		}

		else {

			$db_array = array(
				'client_id'			=>	$client_id,
				'ba_client_key'	=>	$key,
				'ba_client_value'	=>	$value
			);

			$this->db->insert('ba_client_data', $db_array);

		}

	}

	public function delete($client_id, $key) {

		$this->db->where('ba_client_key', $key);

		$this->db->where('client_id', $client_id);

		$this->db->delete('ba_client_data');

	}

	public function set_session_data($client_id) {

		$this->db->where('client_id', $client_id);

		$ba_client_data = $this->db->get('ba_client_data')->result();

		foreach ($ba_client_data as $data) {

			$this->settings->{$data->ba_client_key} = $data->ba_client_value;

		}

	}

	public function setting($key) {

		return (isset($this->settings->$key)) ? $this->settings->$key : NULL;

	}

}

?>