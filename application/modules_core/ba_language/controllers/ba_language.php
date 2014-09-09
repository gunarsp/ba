<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

class ba_Language extends MX_Controller {

    public $languages;

    function __construct() {

        parent::__construct();

        $this->load->helper(
            array(
            'directory',
            'inflector'
            )
        );

        $languages = directory_map(APPPATH . '/language');

        foreach ($languages as $key=>$language) {

            if (is_array($language)) {

                if (is_numeric(array_search('ba_lang.php', $language))) {

                    $this->languages[$key] = humanize($key);

                }

            }

        }

    }

}

?>
