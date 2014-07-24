<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

class Cron_Controller extends MY_Controller {

    function __construct() {

        parent::__construct();

        $this->load->database();

        $this->load->helper('url');

        $this->load->model('ba_modules/mdl_ba_modules');

        $this->mdl_ba_modules->set_module_data();

        $this->load->model('ba_data/mdl_ba_data');

        $this->mdl_ba_data->set_session_data();

        $this->load->helper(array('uri', 'ba_currency', 'ba_invoice', 'ba_date', 'ba_icon', 'ba_custom', 'ba_app'));

        $this->load->language('ba', $this->mdl_ba_data->setting('default_language'));

        $this->load->model('fields/mdl_fields');

    }

}

?>
