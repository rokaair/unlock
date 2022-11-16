<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 * Setting
 *
 *
 * @package		Repair
 * @category	Controller
 * @author		Urepairern Sher
*/

class settings extends Auth_Controller
{
	// THE CONSTRUCTOR //
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Settings_model');
        
        $this->upload_path = 'assets/uploads/';
        $this->thumbs_path = 'assets/uploads/thumbs/';
        $this->image_types = 'gif|jpg|jpeg|png|tif';
        $this->allowed_file_size = '1024';

        // $this->lang->load('global', $this->Main_model->language());
    }

	// SHOW THE settings PAGE //
    public function index()
    {
        if(
            !$this->Admin && 
            !$this->GP['settings-general'] && 
            !$this->GP['settings-orders'] && 
            !$this->GP['settings-invoice'] && 
            !$this->GP['settings-sms'] && 
            !$this->GP['settings-appearance'] && 
            !$this->GP['settings-upload_logo'] && 
            !$this->GP['settings-upload_background']
        ){
            $this->repairer->checkPermissions('general', NULL, 'settings');
        }
        $this->mPageTitle = lang('system_settings');
        $this->data['tax_rates'] = $this->settings_model->getTaxRates();
        $this->render('settings');
    }
    
    // AJAX LOGO UPLOAD //
    public function upload_image()
    {
        $status = "";
        $msg = "";
        $this->load->library('upload');
        $this->upload_path = 'assets/uploads/logos';
        $this->upload_path_favicon = 'assets/uploads/logos/favicons';
        $this->image_types = 'jpg|jpeg|png|gif';
        $this->allowed_file_size = 190 * 53;

        $config['upload_path'] = $this->upload_path;
        $config['allowed_types'] = $this->image_types;
        $config['max_size'] = $this->allowed_file_size;
        $config['overwrite'] = FALSE;
        $config['max_filename'] = 25;
        $config['encrypt_name'] = TRUE;
        $this->upload->initialize($config);
        if (!$this->upload->do_upload('logo_upload')) {
            $error = $this->upload->display_errors();
            $status = 'error';
            echo $msg = $this->upload->display_errors('', '');
            echo 'false1';
        }else{
            $data = $this->upload->data();
            if($data)
            {
                $name = $this->upload->file_name;
                $this->Settings_model->update_logo($name);
                echo $name;
            }
            else
            {
                unlink($data['full_path']);
                echo 'false';
            }

        }

    }

    // AJAX LOGO UPLOAD //
    public function upload_background()
    {
        $status = "";
        $msg = "";
        $this->load->library('upload');
        $this->upload_path = 'assets/uploads/backgrounds';
        $this->image_types = 'jpg|jpeg|png|gif';
        $this->allowed_file_size = 190 * 53;

        $config['upload_path'] = $this->upload_path;
        $config['allowed_types'] = $this->image_types;
        $config['max_size'] = $this->allowed_file_size;
        $config['overwrite'] = FALSE;
        $config['max_filename'] = 25;
        $config['encrypt_name'] = TRUE;
        $this->upload->initialize($config);
        if (!$this->upload->do_upload('background_upload')) {
            $error = $this->upload->display_errors();
            $status = 'error';
            echo $msg = $this->upload->display_errors('', '');
            echo 'false1';
        }else{
            $data = $this->upload->data();
            if($data)
            {
                $name = $this->upload->file_name;
                $this->db->update('settings', array(
                    'background' => $name
                ));
                echo $name;
            }
            else
            {
                unlink($data['full_path']);
                echo 'false';
            }

        }

    }


	// SAVE THE SETTING //
    public function save_settings()
    {   

 
		
		
        $generalSettings = array(
            'title'                 => $this->input->post('title'),
            'language'              => $this->input->post('language'),
            'currency'              => $this->input->post('currency'),
            'product_discount'      => $this->input->post('product_discount'),
            'purchase_prefix'       => $this->input->post('purchase_prefix'),
            'reference_format'      => $this->input->post('reference_format'),
            'decimals'              => $this->input->post('decimals'),
            'qty_decimals'          => $this->input->post('qty_decimals'),
            'tax1'                  => ($this->input->post('tax_rate') != 0) ? 1 : 0,
            'tax2'                  => ($this->input->post('tax_rate2') != 0) ? 1 : 0,
            'default_tax_rate'      => $this->input->post('tax_rate'),
            'default_tax_rate2'     => $this->input->post('tax_rate2'),
            'update_cost'           => $this->input->post('update_cost'),
            'bc_fix'                => $this->input->post('bc_fix'),
            'disable_editing'       => $this->input->post('disable_editing'),
            'model_based_search'    => $this->input->post('model_based_search'),
            'iwidth'                => $this->input->post('iwidth'),
            'iheight'               => $this->input->post('iheight'),
            'twidth'                => $this->input->post('twidth'),
            'theight'               => $this->input->post('theight'),
            'watermark'             => $this->input->post('watermark'),
            'rows_per_page'         => $this->input->post('rows_per_page'),
            'enable_recaptcha'      => $this->input->post('enable_recaptcha'),
            'invoice_template'      => $this->input->post('invoice_template'),
            'report_template'       => $this->input->post('report_template'),
            'show_settings_menu'    => $this->input->post('show_settings_menu'),
            'google_site_key'       => $this->input->post('google_site_key'),
            'google_secret_key'     => $this->input->post('google_secret_key'),
            'google_api_key'        => $this->input->post('google_api_key'),
        );

        $orders_reparations = array(
            'category'              => is_array($this->input->post('category')) ? implode(',', $this->input->post('category')) : '',
            'custom_fields'         => is_array($this->input->post('custom_fields')) ? implode(',', $this->input->post('custom_fields')) : '',
        );


        $invoice = array(
            'invoice_name'          => $this->input->post('invoice_name'),
            'invoice_mail'          => $this->input->post('invoice_mail'),
            'address'               => $this->input->post('invoice_address'),
            'phone'                 => $this->input->post('invoice_phone'),
            'vat'                   => $this->input->post('invoice_vat'),
            'disclaimer'            => $this->input->post('disclaimer'),
        );


        $sms = array(
            'usesms'                => $this->input->post('usesms'),
            'nexmo_api_key'         => $this->input->post('n_api_key'),
            'nexmo_api_secret'      => $this->input->post('n_api_secret'),
            'twilio_mode'           => $this->input->post('t_mode'),
            'twilio_account_sid'    => $this->input->post('t_account_sid'),
            'twilio_auth_token'     => $this->input->post('t_token'),
            'twilio_number'         => $this->input->post('t_number'),
            'smtp_host'             => $this->input->post('smtp_host'),
            'smtp_user'             => $this->input->post('smtp_user'),
            'smtp_pass'             => $this->input->post('smtp_pass'),
            'smtp_port'             => $this->input->post('smtp_port'),
        );

        $appearance = array(
            'bg_color' => $this->input->post('bg_color'),
            'header_color' => $this->input->post('header_color'),
            'menu_color' => $this->input->post('menu_color'),
            'menu_active_color' => $this->input->post('menu_active_color'),
            'menu_text_color' => $this->input->post('menu_text_color'),
            'mmenu_text_color' => $this->input->post('mmenu_text_color'),
            'bg_text_color' => $this->input->post('bg_text_color'),
            'invoice_table_color' => $this->input->post('invoice_table_color'),
            'body_font' => $this->input->post('body_font'),
            'use_dark_theme' => $this->input->post('use_dark_theme'),
            'use_topbar' => $this->input->post('use_topbar'),
            'logo_text_color' => $this->input->post('logo_text_color'),
            'warranty_ribbon_color' => $this->input->post('warranty_ribbon_color'),
        );


        $data = array();
        if($this->Admin || $this->GP['settings-general']){
            $data = array_merge($data, $generalSettings);
        }
        if($this->Admin || $this->GP['settings-orders']){
            $data = array_merge($data, $orders_reparations);
        }
        if($this->Admin || $this->GP['settings-invoice']){
            $data = array_merge($data, $invoice);
        }
        if($this->Admin || $this->GP['settings-sms']){
            $data = array_merge($data, $sms);
        }
        if($this->Admin || $this->GP['settings-appearance']){
            $data = array_merge($data, $appearance);
        }

        $data = $this->Settings_model->update_settings($data);
        echo json_encode($data);

    }

    // SHOW THE settings PAGE //
    public function tax_rates($action = NULL)
    {
        $this->mPageTitle = lang('taxrate_title');

        if (!$action) {
            $this->repairer->checkPermissions('index', NULL, 'tax_rates');
            $this->render('tax_rates');
        }
        if ($action == 'getAll') {
            $this->repairer->checkPermissions('index', NULL, 'tax_rates');
            $this->load->library('datatables');
            $this->datatables
                ->select('id, name, code, rate, type')
                ->from('tax_rates');
            $actions = "";
            if ($this->Admin || $this->GP['tax_rates-edit']) {
                $actions .= "<a  data-dismiss='modal' id='modify' href='#taxmodal' data-toggle='modal' data-num='$1'><button class='btn btn-primary btn-xs'><i class='fas fa-edit'></i></button></a>";
            }
            if ($this->Admin || $this->GP['tax_rates-delete']) {
                $actions .= "<a id='delete' data-num='$1'><button class='btn btn-danger btn-xs'><i class='fas fa-trash'></i></button></a>";
            }

            $this->datatables->add_column('actions', $actions, 'id');
            $this->datatables->unset_column('id');
            echo $this->datatables->generate();
        }elseif ($action == 'delete') {
            $this->repairer->checkPermissions('delete', NULL, 'tax_rates');

            if ($this->input->post('id') == 1) {
                # code...
                return false;
            }
            $this->db->where('id', $this->input->post('id'));
            $this->db->delete('tax_rates');
            echo "true";
        }elseif ($action == 'byID') {
            $data = array();
            $query = $this->db->get_where('tax_rates', array('id' => $this->input->post('id')));
            if ($query->num_rows() > 0) {
                $data = $query->row_array();
            }
            echo  json_encode($data);
        }elseif ($action == 'add') {
            $this->repairer->checkPermissions('add', NULL, 'tax_rates');

            $data = array(
                'name' => $this->input->post('name'), 
                'code' => $this->input->post('code'), 
                'rate' => $this->input->post('rate'), 
                'type' => $this->input->post('type'), 
            );
            $this->db->insert('tax_rates', $data);
        }elseif ($action == 'edit') {
            $this->repairer->checkPermissions('edit', NULL, 'tax_rates');

            $data = array(
                'name' => $this->input->post('name'), 
                'code' => $this->input->post('code'), 
                'rate' => $this->input->post('rate'), 
                'type' => $this->input->post('type'), 
            );
            $this->db->where('id', $this->input->post('id'));
            $this->db->update('tax_rates', $data);
        }
    }


    function categories()
    {
        $this->mPageTitle = lang('categories');

        $this->render('settings/categories');
    }

    function getCategories()
    {

        $this->load->library('datatables');
        $actions = "";
        if ($this->Admin || $this->GP['categories-edit']) {
            $actions .= "<a href='" . base_url('panel/settings/edit_category/$1') . "' data-toggle='modal' data-target='#myModal' class='tip' title='" . lang("edit_category") . "'><i class=\"fa fa-edit\"></i></a>";
        }
        if ($this->Admin || $this->GP['categories-delete']) {
            $actions .= "<a href='#' class='tip po' title='<b>" . lang("delete_category") . "</b>' data-content=\"<p>" . lang('r_u_sure') . "</p><a class='btn btn-danger po-delete' href='" . base_url('panel/settings/delete_category/$1') . "'>" . lang('i_m_sure') . "</a> <button class='btn po-close'>" . lang('no') . "</button>\"  rel='popover'><i class=\"fas fa-trash\"></i></a>";
        }
        $this->datatables
            ->select("{$this->db->dbprefix('categories')}.id as id, {$this->db->dbprefix('categories')}.image, {$this->db->dbprefix('categories')}.code, {$this->db->dbprefix('categories')}.name, c.name as parent", FALSE)
            ->from("categories")
            ->join("categories c", 'c.id=categories.parent_id', 'left')
            ->group_by('categories.id')
            ->add_column("Actions", "<div class=\"text-center\">".$actions."</div>", "id");
        echo $this->datatables->generate();
    }

    function add_category()
    {
        $this->load->helper('security');
        $this->form_validation->set_rules('code', lang("category_code"), 'trim|is_unique[categories.code]|required');
        $this->form_validation->set_rules('name', lang("name"), 'required|min_length[3]');
        $this->form_validation->set_rules('userfile', lang("category_image"), 'xss_clean');
        if ($this->form_validation->run() == true) {
            $data = array(
                'name' => $this->input->post('name'),
                'code' => $this->input->post('code'),
                'parent_id' => $this->input->post('parent'),
            );

            if ($_FILES['userfile']['size'] > 0) {
                $this->load->library('upload');
                $config['upload_path'] = $this->upload_path;
                $config['allowed_types'] = $this->image_types;
                $config['max_size'] = $this->allowed_file_size;
                $config['max_width'] = $this->mSettings->iwidth;
                $config['max_height'] = $this->mSettings->iheight;
                $config['overwrite'] = FALSE;
                $config['encrypt_name'] = TRUE;
                $config['max_filename'] = 25;
                $this->upload->initialize($config);
                if (!$this->upload->do_upload()) {
                    $error = $this->upload->display_errors();
                    $this->session->set_flashdata('error', $error);
                    redirect($_SERVER["HTTP_REFERER"]);
                }
                $photo = $this->upload->file_name;
                $data['image'] = $photo;
                $this->load->library('image_lib');
                $config['image_library'] = 'gd2';
                $config['source_image'] = $this->upload_path . $photo;
                $config['new_image'] = $this->thumbs_path . $photo;
                $config['maintain_ratio'] = TRUE;
                $config['width'] = $this->mSettings->twidth;
                $config['height'] = $this->mSettings->theight;
                $this->image_lib->clear();
                $this->image_lib->initialize($config);
                if (!$this->image_lib->resize()) {
                    echo $this->image_lib->display_errors();
                }
                if ($this->mSettings->watermark) {
                    $this->image_lib->clear();
                    $wm['source_image'] = $this->upload_path . $photo;
                    $wm['wm_text'] = 'Copyright ' . date('Y') . ' - ' . $this->mSettings->site_name;
                    $wm['wm_type'] = 'text';
                    $wm['wm_font_path'] = 'system/fonts/texb.ttf';
                    $wm['quality'] = '100';
                    $wm['wm_font_size'] = '16';
                    $wm['wm_font_color'] = '999999';
                    $wm['wm_shadow_color'] = 'CCCCCC';
                    $wm['wm_vrt_alignment'] = 'top';
                    $wm['wm_hor_alignment'] = 'left';
                    $wm['wm_padding'] = '10';
                    $this->image_lib->initialize($wm);
                    $this->image_lib->watermark();
                }
                $this->image_lib->clear();
                $config = NULL;
            }

        } elseif ($this->input->post('add_category')) {
            $this->session->set_flashdata('error', validation_errors());
            redirect("panel/settings/categories");
        }

        if ($this->form_validation->run() == true && $this->settings_model->addCategory($data)) {
            $this->session->set_flashdata('message', lang("category_added"));
            redirect("panel/settings/categories");
        } else {

            $this->data['error'] = validation_errors() ? validation_errors() : $this->session->flashdata('error');
            $this->data['categories'] = $this->settings_model->getParentCategories();
            $this->load->view($this->theme . 'settings/add_category', $this->data);

        }
    }

    function edit_category($id = NULL)
    {
        $this->load->helper('security');
        $this->form_validation->set_rules('code', lang("category_code"), 'trim|required');
        $pr_details = $this->settings_model->getCategoryByID($id);
        if ($this->input->post('code') != $pr_details->code) {
            $this->form_validation->set_rules('code', lang("category_code"), 'required|is_unique[categories.code]');
        }

        $this->form_validation->set_rules('name', lang("category_name"), 'required|min_length[3]');
        $this->form_validation->set_rules('userfile', lang("category_image"), 'xss_clean');

        if ($this->form_validation->run() == true) {

            $data = array(
                'name' => $this->input->post('name'),
                'code' => $this->input->post('code'),
                'parent_id' => $this->input->post('parent'),
                );

            if ($_FILES['userfile']['size'] > 0) {
                $this->load->library('upload');
                $config['upload_path'] = $this->upload_path;
                $config['allowed_types'] = $this->image_types;
                $config['max_size'] = $this->allowed_file_size;
                $config['max_width'] = $this->mSettings->iwidth;
                $config['max_height'] = $this->mSettings->iheight;
                $config['overwrite'] = FALSE;
                $config['encrypt_name'] = TRUE;
                $config['max_filename'] = 25;
                $this->upload->initialize($config);
                if (!$this->upload->do_upload()) {
                    $error = $this->upload->display_errors();
                    $this->session->set_flashdata('error', $error);
                    redirect($_SERVER["HTTP_REFERER"]);
                }
                $photo = $this->upload->file_name;
                $data['image'] = $photo;
                $this->load->library('image_lib');
                $config['image_library'] = 'gd2';
                $config['source_image'] = $this->upload_path . $photo;
                $config['new_image'] = $this->thumbs_path . $photo;
                $config['maintain_ratio'] = TRUE;
                $config['width'] = $this->mSettings->twidth;
                $config['height'] = $this->mSettings->theight;
                $this->image_lib->clear();
                $this->image_lib->initialize($config);
                if (!$this->image_lib->resize()) {
                    echo $this->image_lib->display_errors();
                }
                if ($this->mSettings->watermark) {
                    $this->image_lib->clear();
                    $wm['source_image'] = $this->upload_path . $photo;
                    $wm['wm_text'] = 'Copyright ' . date('Y') . ' - ' . $this->mSettings->site_name;
                    $wm['wm_type'] = 'text';
                    $wm['wm_font_path'] = 'system/fonts/texb.ttf';
                    $wm['quality'] = '100';
                    $wm['wm_font_size'] = '16';
                    $wm['wm_font_color'] = '999999';
                    $wm['wm_shadow_color'] = 'CCCCCC';
                    $wm['wm_vrt_alignment'] = 'top';
                    $wm['wm_hor_alignment'] = 'left';
                    $wm['wm_padding'] = '10';
                    $this->image_lib->initialize($wm);
                    $this->image_lib->watermark();
                }
                $this->image_lib->clear();
                $config = NULL;
            }

        } elseif ($this->input->post('edit_category')) {
            $this->session->set_flashdata('error', validation_errors());
            redirect("panel/settings/categories");
        }

        if ($this->form_validation->run() == true && $this->settings_model->updateCategory($id, $data)) {
            $this->session->set_flashdata('message', lang("category_updated"));
            redirect("panel/settings/categories");
        } else {

            $this->data['error'] = validation_errors() ? validation_errors() : $this->session->flashdata('error');
            $this->data['category'] = $this->settings_model->getCategoryByID($id);
            $this->data['categories'] = $this->settings_model->getParentCategories();
            $this->load->view($this->theme . 'settings/edit_category', $this->data);

        }
    }

    function delete_category($id = NULL)
    {

        if ($this->settings_model->getSubCategories($id)) {
            $this->repairer->send_json(array('error' => 1, 'msg' => lang("category_has_subcategory")));
        }

        if ($this->settings_model->deleteCategory($id)) {
            $this->repairer->send_json(array('error' => 0, 'msg' => lang("category_deleted")));
        }
    }

    function category_actions()
    {

        $this->form_validation->set_rules('form_action', lang("form_action"), 'required');

        if ($this->form_validation->run() == true) {

            if (!empty($_POST['val'])) {
                if ($this->input->post('form_action') == 'delete') {
                    foreach ($_POST['val'] as $id) {
                        $this->settings_model->deleteCategory($id);
                    }
                    $this->session->set_flashdata('message', lang("categories_deleted"));
                    redirect($_SERVER["HTTP_REFERER"]);
                }

                if ($this->input->post('form_action') == 'export_excel' || $this->input->post('form_action') == 'export_pdf') {
                    $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
                    $sheet = $spreadsheet->getActiveSheet();

                    $sheet->setTitle(lang('categories'));
                    $sheet->SetCellValue('A1', lang('code'));
                    $sheet->SetCellValue('B1', lang('name'));
                    $sheet->SetCellValue('C1', lang('image'));
                    $sheet->SetCellValue('D1', lang('parent_category'));
                    $row = 2;
                    foreach ($_POST['val'] as $id) {
                        $sc = $this->settings_model->getCategoryByID($id);
                        $parent_actegory = '';
                        if ($sc->parent_id) {
                            $pc = $this->settings_model->getCategoryByID($sc->parent_id);
                            $parent_actegory = $pc->code;
                        }
                        $sheet->SetCellValue('A' . $row, $sc->code);
                        $sheet->SetCellValue('B' . $row, $sc->name);
                        $sheet->SetCellValue('C' . $row, $sc->image);
                        $sheet->SetCellValue('D' . $row, $parent_actegory);
                        $row++;
                    }

                    $sheet->getColumnDimension('B')->setWidth(20);
                    $sheet->getColumnDimension('D')->setWidth(20);
                    $sheet->getParent()->getDefaultStyle()->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
                    $filename = 'categories_' . date('Y_m_d_H_i_s');

                    if ($this->input->post('form_action') == 'export_excel') {
                        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
                        header('Content-Disposition: attachment;filename="'.$filename.'.xlsx"');
                        header('Cache-Control: max-age=0');

                        $writer = PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
                        $writer->save('php://output');
                        exit();
                    }

                    if ($this->input->post('form_action') == 'export_pdf') {
                        $styleArray = [
                            'borders' => [
                                'allBorders' => [
                                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
                                    'color' => ['argb' => 'FFFF0000'],
                                ],
                            ],
                        ];
                        $sheet->getStyle('A0:D'.($row-1))->applyFromArray($styleArray);
                        $sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
                        header('Content-Type: application/pdf');
                        header('Content-Disposition: attachment;filename="' . $filename . '.pdf"');
                        header('Cache-Control: max-age=0');
                        $writer = PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Mpdf');
                        $writer->save('php://output');
                    }
                }
            } else {
                $this->session->set_flashdata('error', lang("no_record_selected"));
                redirect($_SERVER["HTTP_REFERER"]);
            }
        } else {
            $this->session->set_flashdata('error', validation_errors());
            redirect($_SERVER["HTTP_REFERER"]);
        }
    }


    function import_categories()
    {

        $this->load->helper('security');
        $this->form_validation->set_rules('userfile', lang("upload_file"), 'xss_clean');

        if ($this->form_validation->run() == true) {

            if (isset($_FILES["userfile"])) {

                $this->load->library('upload');
                $config['upload_path'] = 'files/';
                $config['allowed_types'] = 'csv';
                $config['max_size'] = $this->allowed_file_size;
                $config['overwrite'] = TRUE;
                $this->upload->initialize($config);

                if (!$this->upload->do_upload()) {
                    $error = $this->upload->display_errors();
                    $this->session->set_flashdata('error', $error);
                    redirect("settings/categories");
                }

                $csv = $this->upload->file_name;

                $arrResult = array();
                $handle = fopen('files/' . $csv, "r");
                if ($handle) {
                    while (($row = fgetcsv($handle, 5000, ",")) !== FALSE) {
                        if (!array_key_exists(3, $row)) {
                            $row[] = NULL;
                        }
                        $arrResult[] = $row;
                    }
                    fclose($handle);
                }

                $titles = array_shift($arrResult);
                $keys = array('code', 'name', 'image', 'pcode');
                $final = array();
                foreach ($arrResult as $key => $value) {
                    $final[] = array_combine($keys, $value);
                }

                foreach ($final as $csv_ct) {
                    if ( ! $this->settings_model->getCategoryByCode(trim($csv_ct['code']))) {
                        $pcat = NULL;
                        $pcode = trim($csv_ct['pcode']);
                        if (!empty($pcode)) {
                            if ($pcategory = $this->settings_model->getCategoryByCode(trim($csv_ct['pcode']))) {
                                $data[] = array(
                                    'code' => trim($csv_ct['code']),
                                    'name' => trim($csv_ct['name']),
                                    'image' => trim($csv_ct['image']),
                                    'parent_id' => $pcategory->id,
                                );
                            }
                        } else {
                            $data[] = array(
                                'code' => trim($csv_ct['code']),
                                'name' => trim($csv_ct['name']),
                                'image' => trim($csv_ct['image']),
                            );
                        }
                    }
                }
            }

            // $this->repairer->print_arrays($data);
        }

        if ($this->form_validation->run() == true && $this->settings_model->addCategories($data)) {
            $this->session->set_flashdata('message', lang("categories_added"));
            redirect('panel/settings/categories');
        } else {

            $this->data['error'] = (validation_errors() ? validation_errors() : $this->session->flashdata('error'));
            $this->data['userfile'] = array('name' => 'userfile',
                'id' => 'userfile',
                'type' => 'text',
                'value' => $this->form_validation->set_value('userfile')
            );
            $this->load->view($this->theme . 'settings/import_categories', $this->data);

        }
    }

    function import_subcategories()
    {

        $this->load->helper('security');
        $this->form_validation->set_rules('userfile', lang("upload_file"), 'xss_clean');

        if ($this->form_validation->run() == true) {

            if (isset($_FILES["userfile"])) {

                $this->load->library('upload');
                $config['upload_path'] = 'files/';
                $config['allowed_types'] = 'csv';
                $config['max_size'] = $this->allowed_file_size;
                $config['overwrite'] = TRUE;
                $this->upload->initialize($config);

                if (!$this->upload->do_upload()) {
                    $error = $this->upload->display_errors();
                    $this->session->set_flashdata('error', $error);
                    redirect("panel/settings/categories");
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
                $keys = array('code', 'name', 'category_code', 'image');
                $final = array();
                foreach ($arrResult as $key => $value) {
                    $final[] = array_combine($keys, $value);
                }

                $rw = 2;
                foreach ($final as $csv_ct) {
                    if ( ! $this->settings_model->getSubcategoryByCode(trim($csv_ct['code']))) {
                        if ($parent_actegory = $this->settings_model->getCategoryByCode(trim($csv_ct['category_code']))) {
                            $data[] = array(
                                'code' => trim($csv_ct['code']),
                                'name' => trim($csv_ct['name']),
                                'image' => trim($csv_ct['image']),
                                'category_id' => $parent_actegory->id,
                                );
                        } else {
                            $this->session->set_flashdata('error', lang("check_category_code") . " (" . $csv_ct['category_code'] . "). " . lang("category_code_x_exist") . " " . lang("line_no") . " " . $rw);
                            redirect("settings/categories");
                        }
                    }
                    $rw++;
                }
            }

            // $this->repairer->print_arrays($data);
        }

        if ($this->form_validation->run() == true && $this->settings_model->addSubCategories($data)) {
            $this->session->set_flashdata('message', lang("subcategories_added"));
            redirect('panel/settings/categories');
        } else {

            $this->data['error'] = (validation_errors() ? validation_errors() : $this->session->flashdata('error'));
            $this->data['userfile'] = array('name' => 'userfile',
                'id' => 'userfile',
                'type' => 'text',
                'value' => $this->form_validation->set_value('userfile')
            );
            $this->load->view($this->theme . 'settings/import_subcategories', $this->data);

        }
    }

    public function slug() {
        echo $this->repairer->slug($this->input->get('title', TRUE), $this->input->get('type', TRUE));
        exit();
    }    

    public function repair_statuses() {
        $this->mPageTitle = lang('repair_statuses');
        $this->repairer->checkPermissions('index', NULL, 'repair_statuses');
        
        $this->data['statuses'] = $this->settings_model->getRepairStatuses();
        $this->render('repair_statuses');
    }   
     
    public function updatePosition() {
        $i = 1;
        foreach ($_GET['id'] as $item):
            $this->db
                ->where('id', $item)
                ->update('status', array('position' => $i));
            $i++;
        endforeach;
    }    

    public function status_add() {
        $data = array(
            'label' => $this->input->post('label'),
            'bg_color' => $this->input->post('bg_color'),
            'fg_color' => $this->input->post('fg_color'),
            'send_email' => $this->input->post('send_email') ? 1 : 0,
            'send_sms' => $this->input->post('send_sms') ? 1 : 0,
            'email_text' => $this->input->post('send_email') ? $this->input->post('email_text') : NULL,
            'sms_text' => $this->input->post('send_sms') ? $this->input->post('sms_text') : NULL,
            'position' => $this->settings_model->countRepairStatuses(),
        );
        $this->db->insert('status', $data);
        echo $this->repairer->send_json(array('success'=>true));
    }    

    public function status_edit() {
        $id = $this->input->post('id');
        $data = array(
            'label' => $this->input->post('label'),
            'bg_color' => $this->input->post('bg_color'),
            'fg_color' => $this->input->post('fg_color'),
            'send_email' => $this->input->post('send_email') ? 1 : 0,
            'send_sms' => $this->input->post('send_sms') ? 1 : 0,
            'email_text' => $this->input->post('send_email') ? $this->input->post('email_text') : NULL,
            'sms_text' => $this->input->post('send_sms') ? $this->input->post('sms_text') : NULL,
        );
        $this->db->update('status', $data, array('id'=>$id));
        echo $this->repairer->send_json(array('success'=>true));
    }    
    
    public function statusDelete() {
        $id = $this->input->post('id');
        if ($this->settings_model->verifyStatusDelete($id)) {
            $this->db->delete('status', array('id'=>$id));
            echo $this->repairer->send_json(array('success'=>true));
            die();
        }
        echo $this->repairer->send_json(array('success'=>false));

    }    
    
    // GET CUSTOMER AND SEND TO AJAX FOR SHOW IT //
    public function getStatusByID()
    {
        $id = $this->security->xss_clean($this->input->post('id', true));
        $data = $this->db->get_where('status', array('id'=>$id));
        if ($data->num_rows() > 0) {
            return $this->repairer->send_json(array('status' => true,'data'=>$data->row()));
        }
        return $this->repairer->send_json(array('status' => false));

    }

}

