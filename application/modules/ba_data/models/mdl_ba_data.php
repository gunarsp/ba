<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

class Mdl_ba_Data extends MY_Model {

	public $settings;

	public function get($key) {

		$this->db->select('ba_value');

		$this->db->where('ba_key', $key);

		$query = $this->db->get('ba_data');

		if ($query->row()) {

			return $query->row()->ba_value;

		}

		else {

			return NULL;

		}

	}

	public function save($key, $value, $only_if_null = FALSE) {

		if (!is_null($this->get($key)) and !$only_if_null) {

			$this->db->where('ba_key', $key);

			$db_array = array(
				'ba_value'	=>	$value
			);

			$this->db->update('ba_data', $db_array);

		}

		else {

			if ($only_if_null) {

				if (!is_null($this->get($key))) {

					return;

				}

			}

			$db_array = array(
				'ba_key'	=>	$key,
				'ba_value'	=>	$value
			);

			$this->db->insert('ba_data', $db_array);

		}

	}

	public function delete($key) {

		$this->db->where('ba_key', $key);

		$this->db->delete('ba_data');

	}

	public function set_session_data() {
		
		$ba_data = $this->db->get('ba_data')->result();
		
		foreach ($ba_data as $data) {
			
			$this->settings->{$data->ba_key} = $data->ba_value;

		}

	}

    public function set_application_title() {

        $this->settings->application_title = $this->get('application_title');

    }

	public function setting($key) {

		return (isset($this->settings->$key)) ? $this->settings->$key : NULL;

	}

    public function set_setting($key, $value) {

        $this->settings->$key = $value;

    }

}

?>