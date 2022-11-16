<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Events extends Auth_Controller {

	public function __construct()
	{
		parent::__construct();
	}

	public function getAllEvents() {
		$data = array();
		$q = $this->db->get('events');

		if ($q->num_rows() > 0) {
			foreach ($q->result() as $row) {
				$data[] = array(
				  	'id'   => $row->id,
				  	'title'   => $row->title,
				  	'start'   => $row->start_event,
				  	'end'   => $row->end_event,
				);
			}
		}
		$this->repairer->send_json($data);
	}

	public function add()
	{
		$data = array(
			'title'=>$this->input->post('title'),
			'start_event'=>$this->input->post('start'),
			'end_event'=>$this->input->post('end'),
		);
		$this->db->insert('events', $data);
	}

	public function update()
	{
		$id = $this->input->post('id');
		$data = array(
			'title'=>$this->input->post('title'),
			'start_event'=>$this->input->post('start'),
			'end_event'=>$this->input->post('end'),
		);
		$this->db->where('id', $id)->update('events', $data);
	}
	public function delete()
	{
		$id = $this->input->post('id');
		$this->db->delete('events', array('id'=>$id));
	}

}