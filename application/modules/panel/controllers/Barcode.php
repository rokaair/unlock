<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Barcode extends Auth_Controller {

	public function __construct()
	{
		parent::__construct();
	}

	public function index() {
		$this->data['barcode_configs'] = $this->settings_model->getAllBarcodeConfigs();
		$this->render('barcodes/index');
	}

	public function newSizeBarcode() {
		$data = array(
			'name' => $this->input->post('name'),
			'm_top' => $this->input->post('m_top'),
			'width' => $this->input->post('width'),
			'height' => $this->input->post('height'),
			'm_width' => $this->input->post('m_width'),
			'y_width' => $this->input->post('y_width'),
			'num_x' => $this->input->post('num_x'),
			'num_y' => $this->input->post('num_y'),
			'ch_barcode' => $this->input->post('ch_barcode'),
			'ch_name' => $this->input->post('ch_name'),
			'ch_detail' => $this->input->post('ch_detail'),
			'ch_price' => $this->input->post('ch_price'),
			'ch_phone' => $this->input->post('ch_phone'),
			'ch_passcode' => $this->input->post('ch_passcode'),
			'ch_date' => $this->input->post('ch_date'),
			'ch_model' => $this->input->post('ch_model'),
		);
		$this->db->insert('barcode_configs', $data);
		$this->repairer->send_json(array('success'=>true, 'msg'=> lang('added_barcode')));
	}


	public function updateSizeBarcode() {
		$id = $this->input->post('id');
		$data = array(
			'm_top'       => $this->input->post('m_top'),
			'width'       => $this->input->post('width'),
			'height'      => $this->input->post('height'),
			'm_width'     => $this->input->post('m_width'),
			'y_width'     => $this->input->post('y_width'),
			'num_x'       => $this->input->post('num_x'),
			'num_y'       => $this->input->post('num_y'),
			'ch_barcode'  => $this->input->post('ch_barcode'),
			'ch_name'     => $this->input->post('ch_name'),
			'ch_detail'   => $this->input->post('ch_detail'),
			'ch_price'    => $this->input->post('ch_price'),
			'ch_phone'    => $this->input->post('ch_phone'),
			'ch_passcode' => $this->input->post('ch_passcode'),
			'ch_date'     => $this->input->post('ch_date'),
			'ch_model'    => $this->input->post('ch_model'),
		);
		$this->db
			->where('id', $id)
			->update('barcode_configs', $data);
		$this->repairer->send_json(array('success'=>true, 'msg'=> lang('updated_barcode')));
	}

	public function removeSet()
	{
		$id =$this->input->post('id');
		$this->db->where('id', $id)->delete('barcode_configs');
		$this->repairer->send_json(array('success'=>true, 'msg'=> lang('deleted_barcode')));
	}
}