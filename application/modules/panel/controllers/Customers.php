<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 * Customers
 *
 *
 * @package		Repairer
 * @category	Controller
 * @author		Usman Sher
*/

// Includes all customers controller

class Customers extends Auth_Controller
{
	// THE CONSTRUCTOR //
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Customers_model');
        $this->upload_path = 'assets/uploads/images';
        $this->image_types = 'gif|jpg|jpeg|png|tif|zip|vcf|rar';
        $this->allowed_image_size = 1000000;
        $this->load->library('upload');
    }

	// PRINT A CUSTOMERS PAGE //
    public function index()
    {
        $this->mPageTitle = lang('clients');
        $this->repairer->checkPermissions('index');
        $this->render('clients/index');
    }

	// GENERATE THE AJAX TABLE CONTENT //
    public function getAllCustomers()
    {
        $this->repairer->checkPermissions('index');
        $this->load->library('datatables');
        $this->datatables
            ->select('id, name, company, telephone, telephone2')
            // ->select('id, name, company, address, email, telephone, image')
            ->from('clients');


        $actions = '<div class="text-center"><div class="btn-group text-left">'
            . '<button type="button" class="btn btn-default btn-xs btn-primary dropdown-toggle" data-toggle="dropdown">'
            . ('actions') . ' <span class="caret"></span></button>
        <ul class="dropdown-menu pull-right" role="menu">';
        if ($this->Admin || $this->GP['customers-view_customer']) {
            $actions .= "<li><a data-dismiss='modal' class='view_client' href='#view_client' data-toggle='modal' data-num='$1'><i class='fas fa-check'></i> ".lang('view_client')."</a></li>";
            $actions .= "<li>".anchor('panel/customers/view_repairs/$1', '<i class="fas fa-check"></i> ' . lang('view_client_repair'), 'data-toggle="modal" data-target="#myModalLG"')."</li>";

        }

         if ($this->Admin || $this->GP['customers-edit']) {
            $actions .= "<li><a data-dismiss='modal' id='modify_client' href='#clientmodal' data-toggle='modal' data-num='$1'><i class='fas fa-edit'></i> ".lang('edit_client')."</a></li>";
        }


        if ($this->Admin || $this->GP['customers-delete']) {
            $actions .= "<li><a id='delete_client' data-num='$1'><i class='fas fa-trash'></i> ".lang('delete_client')."</a></li>";
        }
        $actions .= "<li><a id='view_image' data-num='$2'><i class='fas fa-image'></i> ".lang('view_image')."</a></li>";

        $actions .= '</ul></div>';


        $this->datatables->add_column('actions', $actions, 'id, image');
        $this->datatables->unset_column('id');
        $this->datatables->unset_column('image');
        echo $this->datatables->generate();
    }

    // PRINT A CUSTOMERS PAGE //
    public function view_repairs($id=NULL)
    {
        $this->mPageTitle = lang('clients');
        // $this->repairer->checkPermissions('index');
        $data['settings'] = $this->mSettings;
        $data['id'] = $id;
        $this->load->view($this->theme . 'clients/getRepairs', $data);
    }

    // GENERATE THE AJAX TABLE CONTENT //
    public function getClientRepairs($id = NULL)
    {
        $this->repairer->checkPermissions('index');
        $this->load->library('datatables');
        $this->datatables
            ->select('reparation.id as id, code, name, reparation.imei as imei, telephone, defect, model_name, date_opening, a.first_name, (SELECT CONCAT(first_name, " ", last_name) FROM users WHERE reparation.updated_by = users.id) as modified_by, (SELECT COUNT(attachments.id) FROM attachments WHERE reparation_id=reparation.id) as attached, grand_total')
            ->join('users a', 'a.id=reparation.created_by', 'left')
            ->where('client_id', $id)
            ->from('reparation');
        echo $this->datatables->generate();
    }
	
    
	// ADD A CUSTOMER //
    public function add()
    {

        $this->repairer->checkPermissions();

        $name = $this->input->post('name', true);
        $company = $this->input->post('company', true);
        $address = $this->input->post('address', true);
        $city = $this->input->post('city', true);
        $postal_code = $this->input->post('postal_code', true);
        $telephone = $this->input->post('telephone', true);
        $email = $this->input->post('email', true);
        $comment = $this->input->post('comment', true);
        $vat = $this->input->post('vat', true);
        $cf = $this->input->post('cf', true);
        $telephone2 = $this->input->post('telephone2', true);
        $info = $this->input->post('info', true);
		
        $address = $address ? $address : '';
        $city = $city ? $city : '';
        $postal_code = $postal_code ? $postal_code : '';
        $email = $email ? $email : '';
        $vat = $vat ? $vat : '';
        $cf = $cf ? $cf : '';
        

        $data = array(
            'name' => $name,
            'company' => $company,
            'telephone' => $telephone,
            'address' => $address,
            'city' => $city,
            'postal_code' => $postal_code,
            'email' => $email,
            'date' => date('Y-m-d H:i:s'),
            'comment' => $comment,
            'vat' => $vat,
            'cf' => $cf,
            'image' => null,
            'telephone2' => $telephone2,
            'info' => $info,
            'icloud_user' => $this->input->post('icloud_user'),
            'icloud_pass' => $this->input->post('icloud_pass'),
        );

        $error = null;
        if (isset($_FILES['image'])) {
            if ($_FILES['image']['size'] > 0) {
                $config['upload_path'] = $this->upload_path;
                $config['allowed_types'] = $this->image_types;
                $config['max_size'] = $this->allowed_image_size;
                // $config['max_width'] = $this->mSettings->iwidth;
                // $config['max_height'] = $this->mSettings->iheight;
                $config['overwrite'] = FALSE;
                $config['max_filename'] = 25;
                $config['encrypt_name'] = FALSE;
                $this->upload->initialize($config);
                if (!$this->upload->do_upload('image')) {
                    $error = $this->upload->display_errors();
                }else{
                    $upload_file = $this->upload->file_name;
                    $data['image'] = $upload_file;
                    $config = NULL;
                }
            }
        }

        $id = $this->Customers_model->insert_client($data);
        echo $this->repairer->send_json(array('id'=>$id, 'error'=>$error));
    }

	// EDIT CUSTOMER //
    public function edit()
    {

        $this->repairer->checkPermissions();
        $id = $this->input->post('id', true);
        $name = $this->input->post('name', true);
        $company = $this->input->post('company', true);
        $address = $this->input->post('address', true);
        $city = $this->input->post('city', true);
        $postal_code = $this->input->post('postal_code', true);
        $telephone = $this->input->post('telephone', true);
        $email = $this->input->post('email', true);
        $comment = $this->input->post('comment', true);
        $vat = $this->input->post('vat', true);
        $cf = $this->input->post('cf', true);
        $telephone2 = $this->input->post('telephone2', true);
        $info = $this->input->post('info', true);

        $address = $address ? $address : '';
        $city = $city ? $city : '';
        $postal_code = $postal_code ? $postal_code : '';
        $email = $email ? $email : '';
        $vat = $vat ? $vat : '';
        $cf = $cf ? $cf : '';

        $data = array(
            'name' => $name,
            'company' => $company,
            'telephone' => $telephone,
            'address' => $address,
            'city' => $city,
            'postal_code' => $postal_code,
            'email' => $email,
            'comment' => $comment,
            'vat' => $vat,
            'cf' => $cf,
            'telephone2' => $telephone2,
            'info' => $info,
            'icloud_user' => $this->input->post('icloud_user'),
            'icloud_pass' => $this->input->post('icloud_pass'),
        );



        $error = null;
        if (isset($_FILES['image'])) {
            if ($_FILES['image']['size'] > 0) {
                $config['upload_path'] = $this->upload_path;
                $config['allowed_types'] = $this->image_types;
                $config['max_size'] = $this->allowed_image_size;
                // $config['max_width'] = $this->mSettings->iwidth;
                // $config['max_height'] = $this->mSettings->iheight;
                $config['overwrite'] = FALSE;
                $config['max_filename'] = 25;
                $config['encrypt_name'] = FALSE;
                $this->upload->initialize($config);
                if (!$this->upload->do_upload('image')) {
                    $error = $this->upload->display_errors();
                }else{
                    $upload_file = $this->upload->file_name;
                    $data['image'] = $upload_file;
                    $config = NULL;
                }
            }
        }
        $this->Customers_model->edit_client($id, $data);
        echo $this->repairer->send_json(array('id'=>$id, 'error'=>$error));
    }

	// DELETE CUSTOMER 
    public function delete()
    {
        $this->repairer->checkPermissions();
		$id = $this->security->xss_clean($this->input->post('id', true));
        $data = $this->Customers_model->delete_clients($id);
        echo json_encode($data);
    }

public function delete_image()
    {
        $id = $this->security->xss_clean($this->input->post('id', true));
        $this->db->where('id', $id);
        $this->db->update('clients', array('image'=>null));
        echo $this->repairer->send_json(array('success'=>true));
    }
	// GET CUSTOMER AND SEND TO AJAX FOR SHOW IT //
    public function getCustomerByID()
    {
        $id = $this->security->xss_clean($this->input->post('id', true));
		$data = $this->Customers_model->find_customer($id);
		$token = $this->input->post('token', true);
		// if($_SESSION['token'] != $token) die('CSRF Attempts');
        echo json_encode($data);
    }


     function export()
    {

        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();



        $sheet->setTitle(lang('customer'));
        $sheet->SetCellValue('A1', lang('client_company'));
        $sheet->SetCellValue('B1', lang('client_name'));
        $sheet->SetCellValue('C1', lang('client_telephone'));
        $sheet->SetCellValue('D1', lang('client_email'));
        $sheet->SetCellValue('E1', lang('client_address'));
        $sheet->SetCellValue('F1', lang('client_city'));
        $sheet->SetCellValue('G1', lang('client_postal_code'));
        $sheet->SetCellValue('H1', lang('client_vat'));
        $sheet->SetCellValue('I1', lang('client_ssn'));
        $sheet->SetCellValue('J1', lang('date'));
        $sheet->SetCellValue('K1', lang('client_comment'));
        $row = 2;

        $q = $this->db->get('clients');
        if ($q->num_rows() > 0) {
            $clients = $q->result();
            foreach ($clients as $client) {
                $sheet->SetCellValue('A' . $row, $client->company);
                $sheet->SetCellValue('B' . $row, $client->name);
                $sheet->SetCellValue('C' . $row, $client->telephone);
                $sheet->SetCellValue('D' . $row, $client->email);
                $sheet->SetCellValue('E' . $row, $client->address);
                $sheet->SetCellValue('F' . $row, $client->city);
                $sheet->SetCellValue('G' . $row, $client->postal_code);
                $sheet->SetCellValue('H' . $row, $client->vat);
                $sheet->SetCellValue('I' . $row, $client->cf);
                $sheet->SetCellValue('J' . $row, $client->date);
                $sheet->SetCellValue('K' . $row, $client->comment);
                $row++;
            }
        }else{
            redirect('No Clients Found');
        }

        $sheet->getColumnDimension('A')->setWidth(20);
        $sheet->getColumnDimension('B')->setWidth(20);
        $sheet->getColumnDimension('C')->setWidth(20);
        $sheet->getParent()->getDefaultStyle()->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
        $filename = 'customers_' . date('Y_m_d_H_i_s');

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="'.$filename.'.xlsx"');
        header('Cache-Control: max-age=0');

        $writer = PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save('php://output');
        exit();
    }

    function import_csv()
    {
        $this->repairer->checkPermissions('add', true);
        $this->load->helper('security');
        $this->form_validation->set_rules('csv_file', lang("upload_file"), 'xss_clean');
        if ($this->form_validation->run() == true) {
            if (isset($_FILES["csv_file"])) /* if($_FILES['userfile']['size'] > 0) */ {
                $this->load->library('upload');
                $config['upload_path'] = 'files';
                $config['allowed_types'] = 'csv';
                $config['max_size'] = '2000';
                $config['overwrite'] = FALSE;
                $config['encrypt_name'] = FALSE;

                $this->upload->initialize($config);
                if (!$this->upload->do_upload('csv_file')) {
                    $error = $this->upload->display_errors();
                    $this->session->set_flashdata('error', $error);
                    redirect("panel/customers");
                }
                $csv = $this->upload->file_name;
                $arrResult = array();
                $handle = fopen('files/' . $csv, "r");
                if ($handle) {
                    while (($row = fgetcsv($handle, 5000, ",")) !== FALSE) {
                        $arrResult[] = $row;
                    }
                    fclose($handle);
                }
                $titles = array_shift($arrResult);
                $keys = array('company', 'name', 'telephone', 'telephone2', 'comment', 'info');
                $final = array();
                foreach ($arrResult as $key => $value) {
                    $final[] = array_combine($keys, $value);
                }
                foreach ($final as $record) {
                    $record['date'] = date('Y-m-d');
                    $data[] = $record;
                }
            }

        } elseif ($this->input->post('import')) {
            $this->session->set_flashdata('error', validation_errors());
            redirect('panel/customers');
        }

        if ($this->form_validation->run() == true && !empty($data)) {
            if ($this->Customers_model->addCustomers($data)) {
                $this->session->set_flashdata('message', lang("customers_added"));
                redirect('panel/customers');
            }
        } else {
            $this->data['error'] = (validation_errors() ? validation_errors() : $this->session->flashdata('error'));
            $this->load->view($this->theme.'clients/import', $this->data);
        }
    }
}