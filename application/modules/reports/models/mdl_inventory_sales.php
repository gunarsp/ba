<?php

class Mdl_Inventory_Sales extends CI_Model {

    function get($from_date = NULL, $to_date = NULL) {

        $params = array(
            'select'    =>  'ba_inventory.inventory_name, (sum(item_subtotal)) AS inventory_sum_amount, sum(item_qty) AS inventory_sum_quantity',
            'where' =>  array(
                'ba_invoice_items.inventory_id >'		=>  0
            ),
            'joins' =>  array(
                'ba_inventory' =>  array(
                    'ba_inventory.inventory_id = ba_invoice_items.inventory_id', 'left'
                ),
                'ba_invoice_item_amounts'  =>  'ba_invoice_item_amounts.invoice_item_id = ba_invoice_items.invoice_item_id',
				'ba_invoices'				=>	'ba_invoices.invoice_id = ba_invoice_items.invoice_id'
            ),
            'group_by'  =>  'ba_inventory.inventory_id'
        );

		if (!$this->session->userdata('global_admin')) {

			$params['where']['ba_invoices.user_id'] = $this->session->userdata('user_id');

		}

		if ($from_date and $to_date) {

			$params['where']['item_date >='] = $from_date;
			$params['where']['item_date <='] = $to_date;

		}

		return $this->mdl_items->get($params);

    }

}

?>
