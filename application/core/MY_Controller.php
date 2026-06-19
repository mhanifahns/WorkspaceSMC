<?php
 
if (!defined('BASEPATH')) exit('No direct script access allowed');
 
/* load the MX_Router class */
 
class MY_Controller extends CI_Controller {
    public function view($file, $data = array())
    {
        $this->load->view('default/v_header',$data);
        $this->load->view('default/v_menu',$data);
        $this->load->view($file, $data);

        $this->load->view('default/v_footer',$data);
    }
}