<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

class Mdl_Clients extends MY_Model {

	public function __construct() {

		parent::__construct();

		$this->table_name = 'ba_clients';

		$this->primary_key = 'ba_clients.client_id';

		$this->select_fields = "
		SQL_CALC_FOUND_ROWS
		ba_clients.*,
		ba_clients.client_id as join_client_id,
		(SELECT SUM(invoice_total) FROM ba_invoice_amounts WHERE invoice_id IN (SELECT invoice_id FROM ba_invoices WHERE client_id = join_client_id AND invoice_is_quote = 0)) AS client_total_invoice,
		IFNULL((SELECT SUM(payment_amount) FROM ba_payments JOIN ba_invoices ON ba_invoices.invoice_id = ba_payments.invoice_id WHERE ba_invoices.client_id = ba_clients.client_id AND invoice_is_quote = 0), 0.00) AS client_total_payment,
		(SELECT ROUND(client_total_invoice - client_total_payment, 2)) AS client_total_balance,
		(SELECT SUM(client_credit_amount) FROM ba_client_credits WHERE client_credit_client_id = ba_clients.client_id) AS client_credit_amount";

		$this->order_by = 'client_name';

		$this->custom_fields = $this->mdl_fields->get_object_fields(3);

	}

	public function get($params = NULL) {

		$clients = parent::get($params);

		if (is_array($clients)) {

			if (isset($params['set_client_data'])) {

				foreach ($clients as $client) {

					$this->db->where('client_id', $client->client_id);

					$ba_client_data = $this->db->get('ba_client_data')->result();

					foreach ($ba_client_data as $client_data) {

						$client->{$client_data->ba_client_key} = $client_data->ba_client_value;

					}

				}

			}

		}

		else {

			if (isset($params['set_client_data'])) {

				$this->db->where('client_id', $clients->client_id);

				$ba_client_data = $this->db->get('ba_client_data')->result();

				foreach ($ba_client_data as $client_data) {

					$clients->{$client_data->ba_client_key} = $client_data->ba_client_value;

				}

			}

		}

		return $clients;

	}

	public function get_client_name($client_id) {

		$this->db->select('client_name');
		$this->db->where('client_id', $client_id);

		return $this->db->get('ba_clients')->row()->client_name;

	}

	public function get_active($params = NULL) {

		if (!$params) {

			$params = array(
				'where'	=>	array(
					'client_active'	=>	1
				)
			);

		}

		else {

			$params['where']['client_active'] = 1;

		}

		return $this->get($params);

	}

	public function validate() {

		$this->form_validation->set_rules('client_active', $this->lang->line('client_active'));
		$this->form_validation->set_rules('client_name', $this->lang->line('client_name'), 'required');
		$this->form_validation->set_rules('client_tax_id', $this->lang->line('tax_id_number'));
		$this->form_validation->set_rules('client_address', $this->lang->line('street_address'));
		$this->form_validation->set_rules('client_address_2', $this->lang->line('street_address_2'));
		$this->form_validation->set_rules('client_city', $this->lang->line('city'));
		$this->form_validation->set_rules('client_state', $this->lang->line('state'));
		$this->form_validation->set_rules('client_zip', $this->lang->line('zip'));
		$this->form_validation->set_rules('client_country', $this->lang->line('country'));
		$this->form_validation->set_rules('client_phone_number', $this->lang->line('phone_number'));
		$this->form_validation->set_rules('client_fax_number',	$this->lang->line('fax_number'));
		$this->form_validation->set_rules('client_mobile_number', $this->lang->line('mobile_number'));
		$this->form_validation->set_rules('client_email_address', $this->lang->line('email_address'), 'valid_email');
		$this->form_validation->set_rules('client_web_address', $this->lang->line('web_address'));
		$this->form_validation->set_rules('client_notes', $this->lang->line('notes'));

		foreach ($this->custom_fields as $custom_field) {

			$this->form_validation->set_rules($custom_field->column_name, $custom_field->field_name);

		}

		return parent::validate($this);

	}

	public function delete($client_id) {

		$this->load->model('invoices/mdl_invoices');

		/* Delete the client record */

		parent::delete(array('client_id'=>$client_id));

		/* Delete any related contacts */

		$this->db->where('client_id', $client_id);

		$this->db->delete('ba_contacts');

		/*
		 * Delete any related invoices, but use the invoice model so records
		 * related to the invoice are also deleted
		*/

		$this->db->select('invoice_id');

		$this->db->where('client_id', $client_id);

		$invoices = $this->db->get('ba_invoices')->result();

		foreach ($invoices as $invoice) {

			$this->mdl_invoices->delete($invoice->invoice_id);

		}

	}

	public function save($db_array = NULL) {

		if (!$db_array) {

			$db_array = parent::db_array();

		}

		if (!$this->input->post('client_active') and !isset($db_array['client_active'])) {

			$db_array['client_active'] = 0;

		}

		parent::save($db_array, uri_assoc('client_id'));

	}

}

?>