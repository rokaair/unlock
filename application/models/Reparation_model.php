<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Reparation_model extends CI_Model
{
        
	public function __construct()
    {
        parent::__construct();
        $this->load->model('settings_model');
    }

   
    public function email_message($to, $subject,$text, $name = '', $model = '', $code = '', $id = '')
    {
        $settings = $this->settings_model->getSettings();

        $search  = array('%businessname%', '%customer%', '%model%', '%site_url%', '%statuscode%', '%businesscontact%', '%id%');
        $replace = array($settings->title, $name, $model, site_url(), $code, $settings->phone,  $id);
        $text = str_replace($search, $replace, $text);
            // $to, $subject = null, $message, $from = null, $from_name = null,

        return $this->send_email($to, $subject, $text, $settings->invoice_mail, $settings->title);
    }


    public function getAllClients()
    {
        $q = $this->db->get('clients');
        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return FALSE;
    }
    public function getAllReparationItems($id)
    {
        $q = $this->db->get_where('reparation_items', array('reparation_id' => $id));
        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return FALSE;
    }
    private function getBalanceQuantity($product_id) {
        $this->db->select('SUM(COALESCE(quantity, 0)) as stock', False);
        $this->db->where('product_id', $product_id)->where('quantity !=', 0);
        $q = $this->db->get('reparation_items');
        if ($q->num_rows() > 0) {
            $data = $q->row();
            return $data->stock;
        }
        return 0;
    }
    public function getProdQty($product_id) {
        $this->db->select('SUM(COALESCE(quantity, 0)) as stock', False);
        $this->db->where('id', $product_id)->where('quantity !=', 0);
        $q = $this->db->get('inventory');
        if ($q->num_rows() > 0) {
            $data = $q->row();
            return $data->stock;
        }
        return 0;
    }
    
    public function isNotService($product_id) {
        $this->db->select('type', False);
        $this->db->where('id', $product_id);
        $q = $this->db->get('inventory');
        if ($q->num_rows() > 0) {
            $data = $q->row();
            if ($data->type !== 'service') {
                return true;
            }else{
                return false;
            }
        }
        return 0;
    }
    
    public function syncProductQty($product_id, $num) {
        if ($this->db->update('inventory', array('quantity' => $num), array('id' => $product_id))) {
            return TRUE;
        }
    }
    public function getAllModels()
    {
        $q = $this->db->where('parent_id !=', 0)->get('models');
        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return FALSE;
    }

    public function getClientNameByID($id)
    {
        $q = $this->db->get_where('clients', array('id' => $id));
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return FALSE;
    }
    public function id_from_name($name)
    {
        $value = $this->db->escape_like_str($name);

        $data = array();

        $this->db->from('clients');
        $this->db->where("CONCAT(name, ' ', company) LIKE '%".$value."%'", null, false);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $data = $query->row_array();
            return $data['id'];
        } else {
            return false;
        }
    }
    public function getModelNameByID($id)
    {
        $q = $this->db->get_where('models', array('id' => $id));
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return FALSE;
    }
    
	public function add_reparation($data, $items, $attachments) {
        $this->db->insert('reparation', $data);
        $id = $this->db->insert_id();
        $i = sizeof($items);
        if ($id && ($i > 0)) {
            for ($r = 0; $r < $i; $r++) {
                $items[$r]['reparation_id'] = $id;
            }
            $this->db->insert_batch('reparation_items', $items);
            for ($r = 0; $r < $i; $r++) {
                if ($this->isNotService($items[$r]['product_id'])) {
                    $num = $this->getProdQty($items[$r]['product_id']) - $items[$r]['quantity'];
                    $this->syncProductQty($items[$r]['product_id'], $num);
                }
            }
        }

        if ($attachments) {
            $attachments = explode(',', $attachments);
            $this->db
                ->where_in('id', $attachments)
                ->update('attachments', array('reparation_id'=>$id));
        }

        $array = array();
        $array['id'] = $id;
        $this->change_status($id, $data['status']);
        return $array;
    }

    public function edit_reparation($id, $data, $items) {
        $this->db->where('id', $id);
        $this->db->update('reparation', $data);
        $pitems = $this->reparation_model->getAllReparationItems($id);
        $this->db->where('reparation_id', $id);
        if ($this->db->delete('reparation_items')) {
            $i = sizeof($pitems);
            if ($pitems && $i > 0) {
                for ($r = 0; $r < $i; $r++) {
                    if ($this->isNotService($pitems[$r]->product_id)) {
                        $qty = $pitems[$r]->quantity;
                        $num = $this->getProdQty($pitems[$r]->product_id) + $qty;
                        $this->syncProductQty($pitems[$r]->product_id, $num);
                    }
                }
            }
            $i = sizeof($items);
            if ($id && ($i > 0)) {
                $this->db->insert_batch('reparation_items', $items);
                for ($r = 0; $r < $i; $r++) {
                    if ($this->isNotService($items[$r]['product_id'])) {
                        $num = $this->getProdQty($items[$r]['product_id']) - $items[$r]['quantity'];
                        $this->syncProductQty($items[$r]['product_id'], $num);
                    }
                }
            }
            $this->change_status($id, $data['status']);
            return true;
        }

        return false;
    }
    


    public function getReparationByID($id) {
        $this->db->where('reparation.id', $id);
        $q = $this->db
                ->select('reparation.*, status.label as status_name, status.position as status_position, status.bg_color as bg_color, status.fg_color as fg_color, CONCAT(users.first_name," ", users.last_name) as assigned_name, tax_rates.name as tax_name')
                ->join('status', 'status.id = reparation.status', 'left')
                ->join('users', 'users.id = reparation.assigned_to', 'left')
                ->join('tax_rates', 'tax_rates.id = reparation.tax_id', 'left')
                ->get('reparation');

        $data = array();
        $items = array();
        if ($q->num_rows() > 0) {
            $data = $q->row_array();
            $q = $this->db->get_where('reparation_items', array('reparation_id' => $id));
            foreach (($q->result()) as $row) {
                $items[$row->id]['id'] = $row->product_id;
                $items[$row->id]['code'] = $row->product_code;
                $items[$row->id]['name'] = $row->product_name;
                $items[$row->id]['qty'] = $row->quantity;
                $items[$row->id]['price'] = $row->unit_price;
            }
            $data['items'] = $items;
            $data['next_status'] = $this->getNextStatusByID($data['status']);
            return $data;
        }

        return false;
    }


    public function getReparationByIMEI($imei) {
        $this->db->where('imei', $imei);
        $q = $this->db->select('*')
                ->get('reparation');

        $data = array();
        $items = array();
        if ($q->num_rows() > 0) {
            $data = $q->row_array();
            return $data;
        }
        return false;
    }

    public function getNextStatusByID($id) {
        $this->db->where('id > ', $id);
        $q = $this->db
                ->limit(1)
                ->order_by('position', 'ASC')
                ->select('*')
                ->get('status');
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return false;
    }

    /*
    |--------------------------------------------------------------------------
    | Change THE ORDER STATUS
    | @param Order ID
    |--------------------------------------------------------------------------
    */
    public function change_status($id, $to_status) {
        $sms_result = FALSE;
        $email_result = FALSE;

        if ($to_status < 1) {
            $this->db->update('reparation', array('status' => $status_Data->id), array('id'=>$id)); 
            $returnData = array();
            $returnData['sms_sent'] = $sms_result;
            $returnData['email_sent'] = $email_result;
            $returnData['label'] = 'Cancelled';
            return $returnData;
        }
        
        $reparation = $this->findReparationByID($id);
        $status_Data = $this->settings_model->getStatusByID($to_status);
        if ($reparation['sms'] && $status_Data->send_sms) {
            $msg = $status_Data->sms_text;
            $sms_result = $this->send_sms($reparation['telephone'], $msg, $reparation['name'], $reparation['model_name'], $reparation['code'], $id);
        }
        if ($reparation['email'] && $status_Data->send_email) {
            $email = $status_Data->email_text;
            $client_details = $this->reparation_model->getClientNameByID($reparation['client_id']);
            $email_result = $this->email_message($client_details->email, 'Status of Reparation was update to '.$status_Data->label, $email, $reparation['name'], $reparation['model_name'], $reparation['code'], $id);
        }
        $data = array(
            'status' => $status_Data->id,
        );
        if (!$this->getNextStatusByID($status_Data->id)) {
            $data['date_closing'] = date('Y-m-d H:i:s');
        }
        $this->db->update('reparation', $data, array('id'=>$id)); 

        $returnData = array();
        $returnData['sms_sent'] = $sms_result;
        $returnData['email_sent'] = $email_result;
        $returnData['label'] = $status_Data->label;
        return $returnData;
    }


    /*
    |--------------------------------------------------------------------------
    | FIND ORDER/REPARATION
    | @param The ID
    |--------------------------------------------------------------------------
    */
    public function findReparationByID($id)
    {
        $data = array();
        $query = $this->db->get_where('reparation', array('id' => $id));
        if ($query->num_rows() > 0) {
            $data = $query->row_array();
        }

        return $data;
    }

   /*
    |--------------------------------------------------------------------------
    | SEND THE EMAIL TO CUSTOMER
    |--------------------------------------------------------------------------
    */
    public function send_email($to, $subject = null, $message, $from = null, $from_name = null, $attachment = null, $cc = null, $bcc = null)
    {
        $settings = $this->settings_model->getSettings();

        $this->load->library('email');
        $config['useragent'] = "Library Management System";
        $config['protocol'] = 'smtp';
        $config['mailtype'] = "html";
        $config['crlf'] = "\r\n";
        $config['charset']   = 'utf-8';
        $config['newline']   = "\r\n";
       
        $this->load->library('encrypt');

        $config['smtp_host'] = $settings->smtp_host;
        $config['smtp_user'] = $settings->smtp_user;
        $config['smtp_pass'] = $settings->smtp_pass;
        $config['smtp_port'] = $settings->smtp_port;
      

        $this->email->initialize($config);

        if ($from && $from_name) {
            $this->email->from($from, $from_name);
        } elseif ($from) {
            $this->email->from($from, $settings->title);
        } else {
            $this->email->from($settings->email, $settings->title);
        }

        $this->email->to($to);
        if ($cc) {
            $this->email->cc($cc);
        }
        if ($bcc) {
            $this->email->bcc($bcc);
        }
        $this->email->subject($subject);
        $this->email->message($message);
        if ($attachment) {
            if (is_array($attachment)) {
                foreach ($attachment as $file) {
                    $this->email->attach($file);
                }
            } else {
                $this->email->attach($attachment, "inline");
            }
        }

        if ($this->email->send()) {
            return true;
        } else {
            // echo $this->email->print_debugger(); die();
            return false;
        }
    }


    /*
    |--------------------------------------------------------------------------
    | SEND THE SMS TO CUSTOMER
    |--------------------------------------------------------------------------
    */
    public function send_sms($number, $text, $name = '', $model = '', $code = '', $id = '')
    {
        $this->load->library('nexmo');

        $settings = $this->settings_model->getSettings();
        $search  = array('%businessname%', '%customer%', '%model%', '%site_url%', '%statuscode%', '%id%');
        $replace = array($settings->title, $name, $model, site_url(), $code, $id);
        $text = str_replace($search, $replace, $text);

        if($settings->usesms == 1) {
            // IF THAT IS NEXMO //
            $this->nexmo->set_format('json');
            $from = $settings->phone;
            $to = $number;
            $message = array(
                'text' => $text,
            );
            $response = $this->nexmo->send_message($from, $to, $message);
            foreach ($response['messages'] as $message ) {
                if ($message['status'] == 0) {
                    return true;
                } else {
                    return false;
                }
            }
        } else {
            try {
                $client = new Twilio\Rest\Client($settings->twilio_account_sid, $settings->twilio_auth_token);
                $message = $client->messages->create(
                    $number,
                    array(
                        'from' => $settings->twilio_number,
                        'body' => $text,
                    )
                );
            } catch (Exception $e) {
                return FALSE;
            }
            if($message->sid){
                return TRUE;
            }
        }
    }

    public function getStatusNameByID($id)
    {
        $q = $this->db->get_where('status', array('id'=>$id));
        if ($q->num_rows() > 0) {
            return $q->row()->label;
        }
        return '';
    }
    public function getTaxLabelByID($id)
    {
        $q = $this->db->get_where('tax_rates', array('id'=>$id));
        if ($q->num_rows() > 0) {
            return $q->row()->name;
        }
        return '';
    }
}
