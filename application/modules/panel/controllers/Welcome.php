<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends Auth_Controller {
	public function __construct()
    {
        parent::__construct();
        $this->load->model('welcome_model');
        $this->load->model('reports_model');
    }
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
	public function index()
	{
        $this->mPageTitle = lang('home');

		$this->data['reparation_count'] = $this->welcome_model->getReparationCount();
		$this->data['clients_count'] = $this->welcome_model->getClientCount();
		$this->data['stock_count'] = $this->welcome_model->getStockCount();
		$this->data['currency'] = $this->mSettings->currency;
		$this->data['stock'] = $this->reports_model->getStockValue();
        $this->data['list'] = $this->reports_model->list_earnings(date('m'), date('Y'));
		$this->render('dashboard');
	}
	public function send_mail(){
		$to 		= ($this->input->post('to')  != '') ? $this->input->post('to') : FALSE;
		$subject 	= ($this->input->post('subject') != '') ? $this->input->post('subject') : FALSE;
		$body 		= ($this->input->post('body') != '') ? $this->input->post('body') : FALSE;
		if ($to==FALSE OR $subject==FALSE OR $body==FALSE) {
			echo 2;
			die();
		}
		$this->load->library('repairer');
		$result = $this->repairer->send_email($to, $subject, $body);
		if ($result) {
			echo 1;
		}else{
			echo 0;
		}
	}
	public function nav_toggle() {
        $this->output->set_header('Content-Type: application/json; charset=utf-8');
        $state = (string) $this->input->post('state');
        if ($state == '') {
            $state = null;
            $this->session->unset_userdata('main_sidebar_state');
        } else {
            $this->session->set_userdata('main_sidebar_state', $state);
        }
        $this->output->set_output(json_encode(array('state' => $state)));
    }
    
   
}
