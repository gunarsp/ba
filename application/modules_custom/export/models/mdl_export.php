<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

class Mdl_Export extends CI_Model {

    function get_invoices_query() {

        $this->db->select(
            'ba_invoices.invoice_id, ' .
            'ba_invoices.invoice_number, ' .
            "FROM_UNIXTIME(ba_invoices.invoice_date_entered, '%Y/%m/%d') AS invoice_date_entered, " .
            "FROM_UNIXTIME(ba_invoices.invoice_due_date, '%Y/%m/%d') AS invoice_due_date, " .
            'ba_invoices.invoice_notes, ' .
            'ba_invoice_amounts.invoice_item_subtotal, ' .
            'ba_invoice_amounts.invoice_item_tax, ' .
            'ba_invoice_amounts.invoice_subtotal, ' .
            'ba_invoice_amounts.invoice_tax, ' .
            'ba_invoice_amounts.invoice_shipping, ' .
            'ba_invoice_amounts.invoice_discount, ' .
            'ba_invoice_amounts.invoice_total, ' .
            'ba_invoice_amounts.invoice_paid, ' .
            'ba_invoice_amounts.invoice_balance',
            FALSE);

        $this->db->join('ba_clients', 'ba_clients.client_id = ba_invoices.client_id');
        $this->db->join('ba_invoice_amounts', 'ba_invoice_amounts.invoice_id = ba_invoices.invoice_id');
        $this->db->where('invoice_is_quote', 0);
        $this->db->order_by('invoice_date_entered');

        return $this->db->get('ba_invoices');

    }

    function get_clients_query() {

        $this->db->select('ba_clients.*');

        $this->db->order_by('ba_clients.client_name');

        return $this->db->get('ba_clients');

    }

    function get_payments_query() {

        $this->db->select(
            'ba_payments.payment_id, ' .
            'ba_payments.invoice_id, ' .
            'ba_invoices.invoice_number, ' .
            'ba_clients.client_id, ' .
            'ba_clients.client_name, ' .
            "FROM_UNIXTIME(ba_payments.payment_date, '%Y/%m/%d') AS payment_date, " .
            'ba_payments.payment_amount, ' .
            'ba_payment_methods.payment_method, ' .
            'ba_payments.payment_note',
            FALSE
        );

        $this->db->join('ba_invoices', 'ba_invoices.invoice_id = ba_payments.invoice_id');
        $this->db->join('ba_clients', 'ba_clients.client_id = ba_invoices.client_id');
        $this->db->join('ba_payment_methods', 'ba_payment_methods.payment_method_id = ba_payments.payment_method_id', 'LEFT');
        $this->db->order_by('ba_payments.payment_date');

        return $this->db->get('ba_payments');

    }

}

?>