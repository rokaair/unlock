<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends MY_Controller {


	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */

	// public function __construct()
	// {
	// 	parent::__construct();

	// }
	public function index()
	{
		$this->load->model('settings_model');
		$this->load->view($this->theme . 'home', $this->data);
		$this->load->language('main_lang');
	}
	public function status()
    {
        $code = $this->input->post('code', true);
        if (strpos($code, 'CASE') !== false) {
        	$id = (int) str_replace('CASE', '', $code);
		 	$this->db->where('reparation.id', $id);
		}else{
		 	$this->db->where('code', $code);
		}
		 	$this->db->or_where('imei', $code);

        $data = array();
        $query = $this->db
        	->select('*, status.label as status, fg_color, bg_color')
        	->join('status', 'status.id=reparation.status')
        	->get('reparation');
        if ($query->num_rows() > 0 && strlen($code) > 3) {
            $data = $query->row_array();
            $data['warranty_status'] = getWarrantyStatus($data['date_closing'], $data['warranty']);
            echo json_encode($data);
        } else {
            echo 'false';
        }
    }
}
