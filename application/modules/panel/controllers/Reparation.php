<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
/**
 * Customers
 *
 *
 * @package     Reparer
 * @category    Controller
 * @author      Usman Sher
*/

class Reparation extends Auth_Controller
{
    // THE CONSTRUCTOR //
    public function __construct()
    {
        parent::__construct();
        $this->load->model('reparation_model');
    }
    
    public function index()
    {
        $this->mPageTitle = lang('reparation');

        $this->repairer->checkPermissions('index', NULL, 'repair');
       
        $this->render('reparation/index');
    }

    private function getStatusByType($type = 'pending'){
        $q = $this->db->where($type, '1')->get('status');
        if ($q->num_rows() > 0) {
            $ids = array();
            foreach ($q->result() as $row) {
                $ids[] = $row->id;
            }
            return $ids;
        }
        return false;
    }
    // GENERATE THE AJAX TABLE CONTENT //
    public function getAllReparations($client_id = null)
    {
        $this->repairer->checkPermissions('index', NULL, 'repair');
        $this->load->library('datatables');
        $type = $this->input->post('type');


        if ($client_id) {
            $this->db->where('client_id', $client_id);
            $this->datatables
            ->select('reparation.id as id, CONCAT(reparation.id, "___", code), reparation.imei as imei, defect, model_name, date_opening, if(status > 0, CONCAT(status.label, "____", status.bg_color, "____", status.fg_color), "cancelled") as status, a.first_name, (SELECT CONCAT(first_name, " ", last_name) FROM users WHERE reparation.updated_by = users.id) as modified_by, grand_total')
            ->join('status', 'status.id=reparation.status', 'left')
            ->join('users a', 'a.id=reparation.created_by', 'left')
            ->from('reparation');
        }else{

            if ($type == 'waiting' || $type == 'completed'){
                $statuses = $this->getStatusByType('in_'.$type);
                $this->datatables->where_in('status', $statuses);
                // if($type == 'completed'){
                //     $this->datatables->or_where('date_closing !=', NULL);
                // }
            }else{
                $statuses = $this->getStatusByType('in_pending');
                $this->datatables->where_in('status', $statuses);
            }
            $this->datatables
            ->select('reparation.id as id, CONCAT(client_id, "___", name) as cname, reparation.imei as imei, telephone, defect, model_name, date_opening, date_closing, if(status > 0, CONCAT(status.label, "____", status.bg_color, "____", status.fg_color), "cancelled") as status, a.first_name, (SELECT CONCAT(first_name, " ", last_name) FROM users WHERE reparation.updated_by = users.id) as modified_by, (SELECT COUNT(attachments.id) FROM attachments WHERE reparation_id=reparation.id) as attached, grand_total,"actions" as actions, warranty')
            ->join('status', 'status.id=reparation.status', 'left')
            ->join('users a', 'a.id=reparation.created_by', 'left')
            ->from('reparation');

            $actions = '<div class="text-center"><div class="btn-group text-left">'
                . '<button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">'
                . ('actions') . ' <span class="caret"></span></button>
            <ul class="dropdown-menu pull-right" role="menu">';
            if ($this->Admin || $this->GP['repair-view_repair']) {
                $actions .= "<li><a data-dismiss='modal' class='view' href='#view_reparation' data-toggle='modal' data-num='$1'><i class='fas fa-check'></i> ".lang('view_reparation')."</a></li>"; 
                $actions .= "<li><a target='_blank' href=\"".base_url()."panel/reparation/invoice/$1/1/\"><i class=\"fas fa-print\"></i> ".lang('invoice')."</a></li>"; 
                $actions .= "<li><a id=\"upload_modal_btn\" data-mode=\"edit\" data-num=\"$1\"><i class=\"fas fa-cloud\"></i> ".lang('view_attached')."</a></li>"; 
            }
            $actions .= "<li><a href=\"".base_url('panel/reparation/view_log/$1')."\" data-num='$1'><i class='fas fa-file-alt'></i> ".lang('view_log_title')."</a><li>";

            if ($this->Admin || $this->GP['repair-edit']) {
                $actions .= "<li><a  data-dismiss='modal' id='modify_reparation' href='#reparationmodal' data-toggle='modal' data-num='$1'><i class='fas fa-edit'></i> ".lang('edit_reparation')."</a></li>"; 
            }
            if ($this->Admin || $this->GP['repair-delete']) {
                $actions .= "<li><a id='delete_reparation' data-num='$1'><i class='fas fa-trash-alt'></i> ".lang('delete_reparation')."</a></li>"; 
            }
                $actions .= '<li><a href="'.base_url().'/panel/reparation/print_barcodes/$1"><i class="fas fa-print"></i> '.lang('print_barcode').'</a></li>'; 

            $actions .= '</ul></div>';
            $this->datatables->edit_column('actions', $actions, 'id');
            $this->datatables->edit_column('warranty', '$1', 'isInWarranty(date_closing, warranty)');
            echo $this->datatables->generate();
            die();
        }

        $this->datatables->unset_column('id');
        echo $this->datatables->generate();
    }
    public function add(){
        $this->repairer->checkPermissions('add', NULL, 'repair');
        $this->load->model('inventory_model');

        $custom_fields = $this->mSettings->custom_fields;
        $custom_fields = explode(',', $custom_fields);
        $cust = array();
        $array = array();
        foreach ($_POST as $key => $var) {
            if (substr($key, 0, 7) === 'custom_' ) {
                $array[(substr($key, 7))] = $var;
            }
        }
        $cust = (json_encode($array));
        $client_details = $this->reparation_model->getClientNameByID($this->input->post('client_name'));
        $model = $this->inventory_model->getModelByName($this->input->post('model'));

     
        $data = array(
            'client_id'           => $this->input->post('client_name'),
            'name'                => $client_details->name,
            'telephone'           => $client_details->telephone,
            'defect'              => $this->input->post('defect'),
            'category'            => $this->input->post('category'),
            'diagnostics'         => $this->input->post('diagnostics'),
            'model_id'            => $model ? $model->id : NULL,
            'model_name'          => $this->input->post('model'),
            'manufacturer'        => $this->input->post('manufacturer'),
            'assigned_to'         => $this->input->post('assigned_to'),
            'advance'             => $this->input->post('advance'),
            'date_opening'        => date('y-m-d H:i:s'),
            'service_charges'     => $this->input->post('service_charges'),
            'comment'             => $this->input->post('comment'),
            'status'              => $this->input->post('status'),
            'code'                => $this->input->post('code'),
            'email'               => $this->input->post('email') == 'true' ? TRUE : FALSE,
            'sms'                 => $this->input->post('sms') == 'true' ? TRUE : FALSE,
            'custom_field'        => $cust,
            'created_by'          => $this->ion_auth->get_user_id(),
            'tax_id'              => NULL,
            'imei'                => $this->input->post('imei'),
            'expected_close_date' => $this->input->post('expected_close_date'),
            'date_opening'        => date('Y-m-d H:i:s', strtotime($this->input->post('date_opening'))),
            'icloud'              => $this->input->post('icloud'),
            'passcode'            => $this->input->post('passcode'),
            'card'                => $this->input->post('card') ? TRUE : FALSE,
            'sim'                 => $this->input->post('sim') ? TRUE : FALSE,
            'warranty'            => $this->input->post('warranty') ? $this->input->post('warranty') : '0',
            'icloud_password'            => $this->input->post('icloud_password'),
        );

        if (!empty($this->input->post('date_closing')) && $this->input->post('date_closing') !== null) {
            $data['date_closing'] = date('Y-m-d H:i:s', strtotime($this->input->post('date_closing')));
        }


        // $tax_rate = $this->settings_model->getTaxRateByID($this->input->post('order_tax'));
        if ($_POST['code'] == null) {
            $data['code'] = time();
        }
        
        $products = array(); 
        $subtotal = 0;
        $total_tax = 0;
        $total = 0;
        $gtotal = 0;
        $invoice_tax = 0;
        if (isset($_POST['item_id']) && $_POST['item_id'] !== null) {
            $i = sizeof($_POST['item_id']);
            for ($r = 0; $r < $i; $r++) {
                $item_id = $_POST['item_id'][$r];
                $item_name = $_POST['item_name'][$r];
                $item_code = $_POST['item_code'][$r];
                $item_quantity = $_POST['item_quantity'][$r];
                $item_price = $_POST['item_price'][$r];
                $products[] = array(
                    'product_id' => $item_id,
                    'product_name' => $item_name,
                    'product_code' => $item_code,
                    'quantity' => $item_quantity,
                    'unit_price' => $item_price,
                    'subtotal' => $item_price * $item_quantity,
                );
                $subtotal += $item_price * $item_quantity;
            }
            $total += $subtotal;
            // if ($tax_rate) {
            //     if ($tax_rate->type == 2) {
            //         $invoice_tax = ($tax_rate->rate);
            //     }
            //     if ($tax_rate->type == 1) {
            //         $invoice_tax = ((($total) * $tax_rate->rate) / 100);
            //     }
            // }
            // $total_tax = $invoice_tax;
        }
        $gtotal = $this->input->post('service_charges') + $total + $total_tax;
        $data['tax'] = $total_tax;
        $data['total'] = $total;
        $data['grand_total'] = $gtotal;
        $attachment_data = $this->input->post('attachment_data') ? $this->input->post('attachment_data') : NULL;
        $result = $this->reparation_model->add_reparation($data, $products, $attachment_data);
        echo $this->repairer->send_json($result);

    }
    public function edit(){
        $this->repairer->checkPermissions('edit', NULL, 'repair');
        $this->load->model('inventory_model');

        $id = $this->input->post('id');
        $custom_fields = $this->mSettings->custom_fields;
        $custom_fields = explode(',', $custom_fields);
        $cust = array();
        $array = array();
        foreach ($_POST as $key => $var) {
            if (substr($key, 0, 7) === 'custom_' ) {
                $array[(substr($key, 7))] = $var;
            }
        }
        $cust = (json_encode($array));
        $client_details = $this->reparation_model->getClientNameByID($this->input->post('client_name'));
        $model = $this->inventory_model->getModelByName($this->input->post('model'));
        $data = array(
            'client_id'           => $this->input->post('client_name'),
            'name'                => $client_details->name,
            'telephone'           => $client_details->telephone,
            'defect'              => $this->input->post('defect'),
            'diagnostics'         => $this->input->post('diagnostics'),
            'category'            => $this->input->post('category'),
            'model_id'            => $model->id,
            'model_name'          => $this->input->post('model'),
            'manufacturer'        => $this->input->post('manufacturer'),
            'assigned_to'         => $this->input->post('assigned_to'),
            'advance'             => $this->input->post('advance'),
            'service_charges'     => $this->input->post('service_charges'),
            'comment'             => $this->input->post('comment'),
            'status'              => $this->input->post('status'),
            'code'                => $this->input->post('code'),
            'custom_field'        => $cust,
            'updated_by'          => $this->ion_auth->get_user_id(),
            // 'tax_id'           => $this->input->post('order_tax'),
            'email'               => $this->input->post('email') == 'true' ? 1 : 0,
            'sms'                 => $this->input->post('sms') == 'true' ? 1 : 0,
            'imei'                => $this->input->post('imei'),
            'expected_close_date' => $this->input->post('expected_close_date'),
            'date_opening'        => date('Y-m-d H:i:s', strtotime($this->input->post('date_opening'))),
            'date_closing'        => null,
            'icloud'              => $this->input->post('icloud'),
            'passcode'            => $this->input->post('passcode'),
            'card'                => $this->input->post('card') ? TRUE : FALSE,
            'sim'                 => $this->input->post('sim') ? TRUE : FALSE,
            'warranty'            => $this->input->post('warranty') ? $this->input->post('warranty') : '0',
            'icloud_password'            => $this->input->post('icloud_password'),
        );

        if (!empty($this->input->post('date_closing')) && $this->input->post('date_closing') !== null) {
            $data['date_closing'] = date('Y-m-d H:i:s', strtotime($this->input->post('date_closing')));
        }
        $reparation_details = $this->reparation_model->getReparationByID($id);

        // $tax_rate = $this->settings_model->getTaxRateByID($this->input->post('order_tax'));
        $this->create_log($id, $data, $reparation_details);
       
        if ($_POST['code'] == null) {
            $data['code'] = time();
        }
        $products = array(); 
        $subtotal = 0;
        $total_tax = 0;
        $total = 0;
        $gtotal = 0;

        if (isset($_POST['item_id']) && $_POST['item_id'] !== null) {
            $i = sizeof($_POST['item_id']);
            for ($r = 0; $r < $i; $r++) {
                $item_id = $_POST['item_id'][$r];
                $item_name = $_POST['item_name'][$r];
                $item_code = $_POST['item_code'][$r];
                $item_quantity = $_POST['item_quantity'][$r];
                $item_price = $_POST['item_price'][$r];
                $products[] = array(
                    'product_id' => $item_id,
                    'product_name' => $item_name,
                    'product_code' => $item_code,
                    'quantity' => $item_quantity,
                    'unit_price' => $item_price,
                    'subtotal' => $item_price * $item_quantity,
                    'reparation_id' => $id,
                );
                $subtotal += $item_price * $item_quantity;
            }
            
            // if ($tax_rate->type == 2) {
            //     $invoice_tax = ($tax_rate->rate);
            // }
            // if ($tax_rate->type == 1) {
            //     $invoice_tax = ((($subtotal) * $tax_rate->rate) / 100);
            // }
            // $total_tax += $invoice_tax;
            $total += $subtotal;

        }
        $gtotal = $this->input->post('service_charges') + $total + $total_tax;
        $data['tax'] = $total_tax;
        $data['total'] = $total;
        $data['grand_total'] = $gtotal;
        $this->reparation_model->edit_reparation($id, $data, $products);

    }

    public function create_log($id, $new, $old) {
        $new['status_name'] = $this->reparation_model->getStatusNameByID($new['status']);
        $new['tax_name'] = $this->reparation_model->getTaxLabelByID($new['tax_id']);
        $old['tax_name'] = $this->reparation_model->getTaxLabelByID($old['tax_id']);

        $old['email'] = (int)$old['email'];
        $old['sms'] = (int)$old['sms'];
        $new['email'] = (int)$new['email'];
        $new['sms'] = (int)$new['sms'];

        $changes = array();
        
        if ($new['email'] !== $old['email']) {
            if ($new['email'] == 1) {
                $changes[] = lang('email_set_to_true');
            }else{
                $changes[] = lang('email_set_to_false');
            }
        }

        if ($new['sms'] !== $old['sms']) {
            if ($new['sms']) {
                $changes[] = lang('sms_set_to_true');
            }else{
                $changes[] = lang('sms_set_to_false');
            }
        }

        // Unset IDs & Numeric Values
        unset(
            $new['client_id'], 
            $new['model_id'], 
            $new['updated_by'], 
            $new['status'], 
            $new['tax_id'], 
            $new['email'], 
            $new['sms'],
            $new['custom_field'],
            $new['telephone']
        );

        foreach ($old as $key => $value) {
            foreach ($new as $_key => $_value) {
                if ($_key == $key) {
                    if ($value !== $_value) {
                        $changes[] = array($key, $value, $_value);
                    }
                }
            }
        }
        
        // Insert Log
        if (!empty($changes)) {
            $log = array(
                'updated_by' => $this->ion_auth->get_user_id(),
                'date' => date('Y-m-d H:i:s'),
                'reparation_id' => $id,
                'log' => json_encode($changes),
            );
            $this->db->insert('log', $log);
        }
        
    }
    public function delete(){
        $add_to_stock = (string)$this->input->post('add_to_stock');
        $this->repairer->checkPermissions('delete', NULL, 'repair');
        $this->db->where('id', $this->input->post('id'));
        $this->db->delete('reparation');
        if ($add_to_stock == 'true') {
            $items = $this->reparation_model->getAllReparationItems($this->input->post('id'));
            $i = sizeof($items);
            for ($r = 0; $r < $i; $r++) {
                if ($this->reparation_model->isNotService($items[$r]->product_id)) {
                    $qty = $items[$r]->quantity;
                    $num = $this->reparation_model->getProdQty($items[$r]->product_id) + $qty;
                    $this->reparation_model->syncProductQty($items[$r]->product_id, $num);
                }
            }
        }
        $this->db->where('id', $this->input->post('id'));
        $this->db->delete('reparation_items');
        echo "true";
    }

    public function getReparationByID(){
        $id = $this->input->post('id');
        $reparation_details = $this->reparation_model->getReparationByID($id);
        echo json_encode($reparation_details);
    }


    public function status_toggle(){
        $id = $this->input->post('id');
        $to_status = $this->input->post('to_status');
        $result = $this->reparation_model->change_status($id, $to_status);
        echo $this->repairer->send_json(array('success'=>true, 'data'=>$result)); 
    }
    
     // SEND A SMS DIRECT //
    public function send_sms() {
        $text = $this->input->post('text', true);
        $number = $this->input->post('number', true);
        $result = $this->reparation_model->send_sms($number, $text);
        echo json_encode(array('status' => $result, 'data'=>$result));
    }
    // SHOW A INVOICE TEMPLATE //
    public function invoice($id,$type,$is_a4=0,$two_copies = 0)
    {
        $this->data['db'] = $this->reparation_model->findReparationByID($id);
        $this->data['items'] = $this->reparation_model->getAllReparationItems($id);
        $this->data['tax_rate'] = $this->settings_model->getTaxRateByID($this->data['db']['tax_id']);
        $this->data['client'] = $this->reparation_model->getClientNameByID($this->reparation_model->id_from_name($this->data['db']['name']));
        $this->data['currency'] = $this->mSettings->currency;
        $this->data['language'] = $this->mSettings->language;
        $this->data['status'] = $this->settings_model->getStatusByID($this->data['db']['status']);

        $this->data['user'] = $this->mUser;
        $this->data['two_copies'] = $two_copies;
        $this->data['is_a4'] = $is_a4;
        if($type == 1) {
            $this->mPageTitle = lang('invoice_title');
            if (in_array($this->mSettings->invoice_template, array(1,2,3))) {
                $this->load->view($this->theme . 'template/invoice_template'.$this->mSettings->invoice_template, $this->data);
            }else{
                $this->load->view($this->theme . 'template/invoice_template1', $this->data);
            }
        } else {
            $this->mPageTitle = lang('report');
            if (in_array($this->mSettings->report_template, array(1,2,3))) {
                $this->load->view($this->theme . 'template/report_template'.$this->mSettings->report_template, $this->data);
            }else{
                $this->load->view($this->theme . 'template/report_template1', $this->data);
            }
        };
    }

    public function upload_attachments()
    {
        // upload.php
        // 'images' refers to your file input name attribute
        if (empty($_FILES['upload_manager'])) {
            echo json_encode(['error'=>lang('upload_no_file')]); 
            // or you can throw an exception 
            return; // terminate
        }
        // get user id posted
        $reparation_id = $this->input->post('id') ? $this->input->post('id') : NULL;

        // a flag to see if everything is ok
        $success = null;

        // file paths to store
        $paths = [];

        // loop and process files
        $this->load->library('upload');
        $number_of_files_uploaded = count($_FILES['upload_manager']['name']);
        for ($i = 0; $i < $number_of_files_uploaded; $i++) {
            $_FILES['userfile']['name']     = $_FILES['upload_manager']['name'][$i];
            $_FILES['userfile']['type']     = $_FILES['upload_manager']['type'][$i];
            $_FILES['userfile']['tmp_name'] = $_FILES['upload_manager']['tmp_name'][$i];
            $_FILES['userfile']['error']    = $_FILES['upload_manager']['error'][$i];
            $_FILES['userfile']['size']     = $_FILES['upload_manager']['size'][$i];
            $config = array(
                'upload_path'   => 'files/',
                'allowed_types' => 'zip|psd|ai|rar|pdf|doc|docx|xls|xlsx|ppt|pptx|gif|jpg|jpeg|png|tif|txt',
                'max_size'      => 204800,
            );
            $this->upload->initialize($config);
            if ( ! $this->upload->do_upload('userfile')){
                $success = false;
                break;
            }else{
                $success = true;
                $paths[] = $this->upload->file_name;
            }
        }

        // check and process based on successful status 
        if ($success === true) {
            $uploaded_ids = array();
            foreach ($paths as $file) {
                $label = explode('.', $file);
                $data = array(
                    'label' => $label[0],
                    'filename' => $file,
                    'added_date' => date('Y-m-d H:i:s'),
                    'reparation_id' => $reparation_id,
                );
                $this->db->insert('attachments', $data);
                $uploaded_ids[] = $this->db->insert_id();
            }
            $output = ["success"=> true, 'data'=>json_encode($uploaded_ids)];
        } elseif ($success === false) {
            $output = ['error'=>lang('error_Contant_Admin')];
            foreach ($paths as $file) {
                unlink('files/'.$file);
            }
        } else {
            $output = ['error'=>lang('error_proccess_upload')];
        }

        echo json_encode(array_unique($output));
    }
    public function getAttachments()
    {
        $id = $this->input->post('id');
        $q = $this->db->get_where('attachments', array('reparation_id'=>$id));

        $urls = array();
        $previews = array();
        if ($q->num_rows() > 0) {
            $result = $q->result();
            foreach ($result as $row) {
                $url = base_url().'files/'.$row->filename;
                $burl = FCPATH.'files/'.$row->filename;
                if (file_exists($burl)) {
                    list($width) = getimagesize($burl);
                    $size = filesize($burl);
                    $extension = (explode('.', $row->filename));
                    $extension = $extension[count($extension) - 1];
                    if (in_array($extension, explode('|', 'doc|docx|xls|xlsx|ppt|pptx'))) {
                        $type = 'office';
                    }elseif (in_array($extension, explode('|', 'pdf'))) {
                        $type = 'pdf';

                    }elseif (in_array($extension, explode('|', 'htm|html'))) {
                        $type = 'html';
                    }elseif (in_array($extension, explode('|', 'txt|ini|csv|java|php|js|css'))) {
                        $type = 'text';
                    }elseif (in_array($extension, explode('|', 'avi|mpg|mkv|mov|mp4|3gp|webm|wmv'))) {
                        $type = 'video';
                    }elseif (in_array($extension, explode('|', 'mp3|wav'))) {
                        $type = 'audio';
                    }
                    elseif (in_array($extension, explode('|', 'doc|docx|xls|xlsx|ppt|pptx'))) {
                        $type = 'office';
                    }
                    elseif (in_array($extension, explode('|', 'png|gif|jpg|jpeg|tif'))) {
                        $type = 'image';
                    }else{
                        $type = 'other';
                    }
            
                    $previews[] = array(
                        'caption' => $row->filename,
                        'filename' => $row->filename,
                        'downloadUrl' => $url,
                        'size' => $width,
                        'width' => (string)$width.'px',
                        'key'=>$row->id,
                        'filetype' => mime_content_type($burl),
                        'type'=>$type,
                    );
                    $urls[] = $url;
                }
                
            }
        }
        echo $this->repairer->send_json(array(
            'show_data' => !empty($urls) ? TRUE : FALSE,
            'previews' => $previews,
            'urls' => $urls,
        ));
    }
    public function delete_attachment()
    {
        $id = $this->input->post('key');
        $q = $this->db->get_where('attachments', array('id'=>$id));
        if ($q->num_rows() > 0) {
            $row = $q->row();
            $this->db->delete('attachments', array('id'=>$id));
            unlink(FCPATH.'/files/'.$row->filename);
            $this->repairer->send_json(array('success'=>true));
            return true;
        }
        $this->repairer->send_json(array('success'=>false));
        return false;

    }

    public function state_save() {
        $state = $this->input->post('state');
        $this->db->update('settings', array('reparation_table_state'=>($state)));
    }

    public function load_state() {
        if (!empty($this->mSettings->reparation_table_state)) {
            header('Content-Type: application/json');
            echo $this->mSettings->reparation_table_state;
        } else {
            http_response_code(201);
        }
    }

    public function view_log($reparation_id  = NULL) {
        $this->mPageTitle = lang('view_log_title');
        $this->data['id'] = $reparation_id;
        $this->render('reparation/view_log');
    }
    public function getLogTable($reparation_id  = NULL) {
        $this->load->library('datatables');
        $this->datatables
            ->select('date,CONCAT(users.first_name, " ",users.last_name) as name, log') 
            ->join('users', 'users.id=log.updated_by', 'left')
            ->where('reparation_id', $reparation_id)
            ->from('log');
        echo $this->datatables->generate();
    }

    function print_barcodes($repair_id = NULL)
    {
        $this->mPageTitle = lang('print_barcode');
        $this->repairer->checkPermissions();
        
        if ($repair_id) {
            if ($row = $this->reparation_model->getReparationByID($repair_id)) {
                $data = array(
                    'name' => $row['name'],
                    'model' => $row['model_name'],
                    'imei' => $row['imei'],
                    'price' => number_format($row['grand_total'], 0, '', ''),
                    'barcode' => $row['imei'],
                    'passcode' => $row['passcode'],
                    'quantity' => 1,
                    'defect' => $row['defect'],
                    'date_opening' => $row['date_opening'],
                    'telephone' => $row['telephone'],
                    'icloud' => $row['icloud'],
                    'icloud_password' => $row['icloud_password'],
                    'warranty' => lang($row['warranty']),
                );
            }
        }else{
            redirect('panel/reparation');
        }
        $this->data['barcode_configs'] = $this->settings_model->getAllBarcodeConfigs();
        $this->data['item'] = $data;
        $this->render('reparation/print_barcodes');
    
    }

    public function getDefects($term = null) {
        if ($term) {
            $this->db->like('defect', $term);
        }
        $q = $this->db->group_by('defect')->get('reparation');
        $defects = array();
        if ($q->num_rows() > 0) {
            $defects = $q->result_array();
        }
        echo $this->repairer->send_json($defects);
    }

    public function getMobileImeis($term = null) {
        if ($term) {
            $this->db->like('imei', $term);
        }
        $q = $this->db->group_by('imei')->get('reparation');
        $imei = array();
        if ($q->num_rows() > 0) {
            $imei = $q->result_array();
        }
        echo $this->repairer->send_json($imei);
    }

     public function getReparationByIMEI(){
        $imei = $this->input->post('imei');
        $reparation_details = $this->reparation_model->getReparationByIMEI($imei);
        echo $this->repairer->send_json($reparation_details);
    }
    
}