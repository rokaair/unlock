<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 * Inventory
 *
 *
 * @package     Repairer
 * @category    Controller
 * @author      Usman Sher
*/

// Includes all customers controller

class Inventory extends Auth_Controller
{
    // THE CONSTRUCTOR //
    public function __construct()
    {
        parent::__construct();
        $this->load->model('inventory_model');
        $this->load->library('repairer');
        $this->digital_upload_path = 'files/';
        $this->upload_path = 'assets/uploads/';
        $this->thumbs_path = 'assets/uploads/thumbs/';
        $this->image_types = 'gif|jpg|jpeg|png|tif';
        $this->digital_file_types = 'zip|psd|ai|rar|pdf|doc|docx|xls|xlsx|ppt|pptx|gif|jpg|jpeg|png|tif|txt';
        $this->allowed_file_size = '1024';
        $this->popup_attributes = array('width' => '900', 'height' => '600', 'window_name' => 'sma_popup', 'menubar' => 'yes', 'scrollbars' => 'yes', 'status' => 'no', 'resizable' => 'yes', 'screenx' => '0', 'screeny' => '0');
    }

    function index()
    {
        $this->mPageTitle = lang('inventory_label');
        $this->repairer->checkPermissions();
        $this->render('inventory/index');
    }

    function getProducts()
    {
        $this->repairer->checkPermissions('index');

        $delete_link = "";
        if ($this->Admin || $this->GP['inventory-delete']) {
            $delete_link .= "<a href='#' class='tip po' title='<b>" . lang("delete_product") . "</b>' data-content=\"<p>"
            . lang('r_u_sure') . "</p><a class='btn btn-danger po-delete' id='a__$1' href='" . site_url('panel/inventory/delete/$1') . "'>"
            . lang('i_m_sure') . "</a> <button class='btn po-close'>" . lang('no') . "</button>\"  rel='popover'><i class=\"fas fa-trash\"></i> "
            . lang('delete_product') . "</a>";
        }
        
        $single_barcode = anchor('panel/inventory/print_barcodes/$1', '<i class="fa fa-print"></i> ' . lang('print_barcode_label'));
        $action = '<div class="text-center"><div class="btn-group text-left">'
            . '<button type="button" class="btn btn-default btn-xs btn-primary dropdown-toggle" data-toggle="dropdown">'
            . lang('actions') . ' <span class="caret"></span></button>
        <ul class="dropdown-menu pull-right" role="menu">
            <li><a href="' . site_url('panel/inventory/add/$1') . '"><i class="fa fa-plus-square"></i> ' . lang('duplicate_product') . '</a></li>
            <li><a href="' . site_url('panel/inventory/edit/$1') . '"><i class="fa fa-edit"></i> ' . lang('edit_product') . '</a></li>';
        
        $action .= '<li>' . $single_barcode . '</li>
            <li class="divider"></li>
            <li>' . $delete_link . '</li>
            </ul>
        </div></div>';
        $this->load->library('datatables');
        
            $this->datatables
                ->select($this->db->dbprefix('inventory') . ".id as productid,  {$this->db->dbprefix('inventory')}.code as code, {$this->db->dbprefix('inventory')}.name as name, cost as cost, price as price, COALESCE(quantity, 0) as quantity, alert_quantity", FALSE)
                ->from('inventory')
                ->where('isDeleted != ', 1)
                ->group_by("inventory.id");

        $this->datatables->add_column("Actions", $action, "productid, image, code, name");
        echo $this->datatables->generate();
    }
    /* ------------------------------------------------------- */

    function add($id = NULL)
    {
        $this->repairer->checkPermissions();
        $this->mPageTitle = lang('add_product');

        $this->load->helper('security');
        $this->form_validation->set_error_delimiters('', '');

        if ($this->input->post('type') == 'standard') {
            $this->form_validation->set_rules('cost', lang("product_cost"), 'required');
            $this->form_validation->set_rules('unit', lang("product_unit"), 'required');
        }
        $this->form_validation->set_rules('category', lang("category"), 'required|is_natural_no_zero');
        $this->form_validation->set_rules('supplier[]', lang("supplier"), 'required');

        $this->form_validation->set_rules('code', ("product_code"), 'is_unique[inventory.code]|alpha_dash');

        if ($this->form_validation->run() == true) {
            $tax_rate = $this->input->post('tax_rate') ? $this->settings_model->getTaxRateByID($this->input->post('tax_rate')) : NULL;
            $data = array(
                'code' => $this->input->post('code'),
                'name' => $this->input->post('name'),
                'type' => $this->input->post('type'),
                'model_id' => $this->input->post('model'),
                'model_name' => $this->inventory_model->getModelNameByID($this->input->post('model')),
                'price' => ($this->input->post('price')),
                'image' => 'no_image.png',
                'cost' => NULL,
                'unit' => NULL,
                'tax_rate' => $this->input->post('tax_rate'),
                'tax_method' => ($this->input->post('tax_method')) ? $this->input->post('tax_method') : 0,
                'alert_quantity' => 0,
                'quantity' => 0,
                'details' => $this->input->post('details'),
                'category_id' => $this->input->post('category'),
                'subcategory_id' => $this->input->post('subcategory') ? $this->input->post('subcategory') : NULL,
                'category' => $this->settings_model->getCategoryByID($this->input->post('category'))->name,
                'subcategory' => $this->input->post('subcategory') ? $this->settings_model->getCategoryByID($this->input->post('subcategory'))->name : NULL,
                'supplier' => $this->input->post('supplier') ? implode(',', $this->input->post('supplier')) : null,
            );

            if ($this->input->post('type') == 'standard') {
                $data['cost'] = ($this->input->post('cost'));
                $data['unit'] = $this->input->post('unit');
                $data['quantity'] = ($this->input->post('quantity'));
                $data['alert_quantity'] = ($this->input->post('alert_quantity'));
            }

             $this->load->library('upload');
            if ($_FILES['product_image']['size'] > 0) {

                $config['upload_path'] = $this->upload_path;
                $config['allowed_types'] = $this->image_types;
                $config['max_size'] = $this->allowed_file_size;
                $config['max_width'] = $this->mSettings->iwidth;
                $config['max_height'] = $this->mSettings->iheight;
                $config['overwrite'] = FALSE;
                $config['max_filename'] = 25;
                $config['encrypt_name'] = TRUE;
                $this->upload->initialize($config);
                if (!$this->upload->do_upload('product_image')) {
                    $error = $this->upload->display_errors();
                    $this->session->set_flashdata('error', $error);
                    redirect("panel/inventory/add");
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
        }

        if ($this->form_validation->run() == true && $this->inventory_model->addProduct($data)) {
            $this->session->set_flashdata('message', ("product_added"));
            redirect('panel/inventory');
        } else {
            $this->data['error'] = (validation_errors() ? validation_errors() : $this->session->flashdata('error'));
            $this->data['tax_rates'] = $this->settings_model->getTaxRates();
            $this->data['product'] = $id ? $this->inventory_model->getProductByID($id) : NULL;
            $this->data['categories'] = $this->settings_model->getAllCategories();
            $this->data['suppliers'] = $this->settings_model->getAllSuppliers();
            $this->render('inventory/add');
        }
    }

    function product_barcode($product_code = NULL, $bcs = 'code128', $height = 30)
    {
        header('Content-type: image/svg+xml');
        $this->gen_barcode($product_code, $bcs, $height);
        // site_url('panel/inventory/gen_barcode/' . $product_code . '/' . $bcs . '/' . $height);
    }

    function barcode($product_code = NULL, $bcs = 'code128', $height = 60)
    {
        return site_url('panel/inventory/gen_barcode/' . $product_code . '/' . $bcs . '/' . $height);
    }

    function gen_barcode($product_code = NULL, $bcs = 'code128', $height = 60, $text = 1)
    {
        $drawText = ($text != 1) ? FALSE : TRUE;
        $this->load->library('zend');
        $this->zend->load('Zend/Barcode');
        $barcodeOptions = array('text' => $product_code, 'barHeight' => $height, 'drawText' => $drawText, 'factor' => 0.9, 'size'=>1);
        // if ($this->mSettings->barcode_img) { 
            // $rendererOptions = array('imageType' => 'jpg', 'horizontalPosition' => 'center', 'verticalPosition' => 'middle');
            // $imageResource = Zend_Barcode::render($bcs, 'image', $barcodeOptions, $rendererOptions);
            // return $imageResource;
        // } else {
            $rendererOptions = array('renderer' => 'svg', 'horizontalPosition' => 'center', 'verticalPosition' => 'middle');
            $imageResource = Zend_Barcode::render($bcs, 'svg', $barcodeOptions, $rendererOptions);
            header("Content-Type: image/svg+xml");
            return $imageResource;
        // }
    }
    function print_barcodes($product_id = NULL)
    {
        $this->mPageTitle = lang('print_barcode');
        $this->repairer->checkPermissions();
        $this->form_validation->set_rules('style', lang("style"), 'required');
    
        if ($product_id) {
            if ($row = $this->inventory_model->getProductByID($product_id)) {
                 $pr = array('id' => $row->id, 'label' => $row->name . " (" . $row->code . ")", 'code' => $row->code, 'name' => $row->name, 'price' => $row->price, 'qty' => $row->quantity, 'details' => $row->details);
            }
        }else{
            redirect('panel/inventory');
        }
        $this->data['barcode_configs'] = $this->settings_model->getAllBarcodeConfigs();
        $this->data['item'] = $pr;
        $this->render('inventory/print_barcodes');

    }
     /* -------------------------------------------------------- */

    function edit($id = NULL)
    {
        $this->mPageTitle = lang('edit_product');

        $this->repairer->checkPermissions();

        $this->load->helper('security');
        if ($this->input->post('id')) {
            $id = $this->input->post('id');
        }
        $product = $this->inventory_model->getProductByID($id);
        if (!$id || !$product) {
            $this->session->set_flashdata('error', ('prduct_not_found'));
            redirect($_SERVER["HTTP_REFERER"]);
        }
        if ($this->input->post('type') == 'standard') {
            $this->form_validation->set_rules('cost', lang("product_cost"), 'required');
            $this->form_validation->set_rules('unit', lang("product_unit"), 'required');
        }
        $this->form_validation->set_rules('category', lang("category"), 'required|is_natural_no_zero');
        $this->form_validation->set_rules('supplier[]', lang("supplier"), 'required');
        $this->form_validation->set_rules('code', lang("product_code"), 'alpha_dash');
        if ($this->input->post('code') !== $product->code) {
            $this->form_validation->set_rules('code', ("product_code"), 'is_unique[inventory.code]');
        }
        if ($this->input->post('barcode_symbology') == 'ean13') {
            $this->form_validation->set_rules('code', lang("product_code"), 'min_length[13]|max_length[13]');
        }

        if ($this->form_validation->run('panel/inventory/edit') == true) {
            $data = array(
                'code' => $this->input->post('code'),
                'name' => $this->input->post('name'),
                'type' => $this->input->post('type'),
                'model_id' => $this->input->post('model'),
                'model_name' => $this->inventory_model->getModelNameByID($this->input->post('model')),
                'cost' => ($this->input->post('cost')),
                'price' => ($this->input->post('price')),
                'unit' => $this->input->post('unit'),
                'tax_rate' => $this->input->post('tax_rate'),
                'tax_method' => $this->input->post('tax_method'),
                'alert_quantity' => $this->input->post('alert_quantity'),
                'details' => $this->input->post('details'),
                'category_id' => $this->input->post('category'),
                'subcategory_id' => $this->input->post('subcategory') ? $this->input->post('subcategory') : NULL,
                'category' => $this->settings_model->getCategoryByID($this->input->post('category'))->name,
                'subcategory' => $this->input->post('subcategory') ? $this->settings_model->getCategoryByID($this->input->post('subcategory'))->name : NULL,
                'supplier' => $this->input->post('supplier') ? implode(',', $this->input->post('supplier')) : null,
            );
            
            
            $this->load->library('upload');
            if ($_FILES['product_image']['size'] > 0) {

                $config['upload_path'] = $this->upload_path;
                $config['allowed_types'] = $this->image_types;
                $config['max_size'] = $this->allowed_file_size;
                $config['max_width'] = $this->mSettings->iwidth;
                $config['max_height'] = $this->mSettings->iheight;
                $config['overwrite'] = FALSE;
                $config['max_filename'] = 25;
                $config['encrypt_name'] = TRUE;
                $this->upload->initialize($config);
                if (!$this->upload->do_upload('product_image')) {
                    $error = $this->upload->display_errors();
                    $this->session->set_flashdata('error', $error);
                    redirect("panel/inventory/edit/".$id);
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
            // $this->repairer->print_arrays($data);
        }

        if ($this->form_validation->run() == true && $this->inventory_model->updateProduct($id, $data)) {
            $this->session->set_flashdata('message', lang("product_updated"));
            redirect('panel/inventory');
        } else {
            $this->data['error'] = (validation_errors() ? validation_errors() : $this->session->flashdata('error'));
            $this->data['tax_rates'] = $this->settings_model->getTaxRates();
            $this->data['product'] = $product;
            $this->data['categories'] = $this->settings_model->getAllCategories();
            $this->data['suppliers'] = $this->settings_model->getAllSuppliers();
            $this->render('inventory/edit');
        }
    }
    function delete($id = NULL)
    {
        $this->repairer->checkPermissions();

        if ($this->input->get('id')) {
            $id = $this->input->get('id');
        }

        if ($this->inventory_model->deleteProduct($id)) {
            if($this->input->is_ajax_request()) {
                echo lang("product_deleted"); die();
            }
            $this->session->set_flashdata('message', lang('product_deleted'));
            redirect('welcome');
        }

    }
    function modal_view($id = NULL)
    {
        $pr_details = $this->inventory_model->getProductByID($id);
        if (!$id || !$pr_details) {
            $this->session->set_flashdata('error', lang('prduct_not_found'));
            $this->repairer->md();
        }
        $this->data['barcode'] = "<img src='" . site_url('panel/inventory/gen_barcode/' . $pr_details->code . '/' . 'code128' . '/40/0') . "' alt='" . $pr_details->code . "' class='pull-left' />";
        
        $this->data['product'] = $pr_details;
        $this->data['tax_rate'] = $pr_details->tax_rate ? $this->settings_model->getTaxRateByID($pr_details->tax_rate) : NULL;
        $this->data['Settings'] = $this->mSettings;

        $this->load->view($this->theme . 'inventory/modal_view', $this->data);
    }


    // PRINT A SUPPLIERS PAGE //
    public function suppliers()
    {
        $this->mPageTitle = lang('suppliers');
        $this->repairer->checkPermissions();
        $this->render('inventory/suppliers_index');
    }

    // GENERATE THE AJAX TABLE CONTENT //
    public function getAllSuppliers()
    {
        $this->load->library('datatables');
        $this->datatables
            ->select('id, name, company, phone, email, city, country, vat_no')
            ->from('suppliers');
        $actions = '<div class="text-center"><div class="btn-group text-left">'
            . '<button type="button" class="btn btn-default btn-xs btn-primary dropdown-toggle" data-toggle="dropdown">'
            . lang('actions') . ' <span class="caret"></span></button>
        <ul class="dropdown-menu pull-right" role="menu">';

        $actions .= "<li><a data-dismiss='modal' class='view' href='#view_supplier' data-toggle='modal' data-num='$1'><i class='fas fa-check'></i> ".lang('view_supplier')."</a></li>";
        if ($this->Admin || $this->GP['inventory-edit_supplier']) {
            $actions .= "<li><a  data-dismiss='modal' id='modify_supplier' href='#suppliermodal' data-toggle='modal' data-num='$1'><i class='fas fa-edit'></i> ".lang('edit_supplier')."</a></li>";
        }
        if ($this->Admin || $this->GP['inventory-delete_supplier']) {
        $actions .= "<li><a id='delete' data-num='$1'><i class='fas fa-trash'></i> ".lang('delete_supplier')."</a></li>";
        }
        $actions .= '</ul></div>';

        $this->datatables->add_column('actions', $actions, 'id');
        $this->datatables->unset_column('id');
        echo $this->datatables->generate();
    }
    
    // ADD A CUSTOMER //
    public function add_supplier()
    {
        $this->repairer->checkPermissions();

        $data = array(
            'name'      => $this->input->post('name', true),
            'company'   => $this->input->post('company', true),
            'address'   => $this->input->post('address', true),
            'city'      => $this->input->post('city', true),
            'country'   => $this->input->post('country', true),
            'state'     => $this->input->post('state', true),
            'postal_code'  => $this->input->post('postal_code', true),
            'phone'     => $this->input->post('phone', true),
            'email'     => $this->input->post('email', true),
            'vat_no'    => $this->input->post('vat_no', true),
        );
        // $token = $this->input->post('token', true);
        
        // // if($_SESSION['token'] != $token) die('CSRF Attempts');

        echo $this->inventory_model->insert_supplier($data);
    }

    // EDIT CUSTOMER //
    public function edit_supplier()
    {
        $this->repairer->checkPermissions();

        $id = $this->input->post('id', true);
        $data = array(
            'name'      => $this->input->post('name', true),
            'company'   => $this->input->post('company', true),
            'address'   => $this->input->post('address', true),
            'city'      => $this->input->post('city', true),
            'country'   => $this->input->post('country', true),
            'state'     => $this->input->post('state', true),
            'postal_code'  => $this->input->post('postal_code', true),
            'phone'     => $this->input->post('phone', true),
            'email'     => $this->input->post('email', true),
            'vat_no'    => $this->input->post('vat_no', true),
        );
        $token = $this->input->post('token', true);
        // if($_SESSION['token'] != $token) die('CSRF Attempts');
        echo $this->inventory_model->edit_supplier($id, $data);
       
    }

    // DELETE CUSTOMER 
    public function delete_supplier()
    {
        $this->repairer->checkPermissions();

        $id = $this->security->xss_clean($this->input->post('id', true));
        $data = $this->inventory_model->delete_supplier($id);
        echo json_encode($data);
    }

    // GET CUSTOMER AND SEND TO AJAX FOR SHOW IT //
    public function getSupplierByID()
    {
        $id = $this->security->xss_clean($this->input->post('id', true));
        $data = $this->inventory_model->find_supplier($id);
        $token = $this->input->post('token', true);
        // if($_SESSION['token'] != $token) die('CSRF Attempts');
        echo json_encode($data);
    }

    ///////////////////////////////////////
    // PRINT A Models PAGE //
    public function models()
    {
        $this->mPageTitle = lang('models');
        $this->repairer->checkPermissions();
        $this->render('inventory/model_index');
    }

    // GENERATE THE AJAX TABLE CONTENT //
    public function getAllModels()
    {
        $this->load->library('datatables');
        $this->datatables
            ->select("{$this->db->dbprefix('models')}.id as id, {$this->db->dbprefix('models')}.name, c.name as parent", FALSE)
            ->from("models")
            ->join("models c", 'c.id=models.parent_id', 'left')
            ->where('models.parent_id !=', 0)
            ->group_by('models.id');

        $actions = '';
        if ($this->Admin || $this->GP['inventory-edit_model']) {
            $actions .= "<a  class='btn btn-sm btn-primary' id='modify_model' data-num='$1'><i class='fas fa-edit'></i></a> ";
        }

        if ($this->Admin || $this->GP['inventory-delete_model']) {
            $actions .= "<a class='btn btn-sm btn-danger' id='delete' data-num='$1'><i class='fas fa-trash'></i></a>";
        }

        $this->datatables->add_column('actions', $actions, 'id');
        $this->datatables->unset_column('id');
        echo $this->datatables->generate();
    }
    
    // ADD A CUSTOMER //
    public function add_model()
    {
        $this->repairer->checkPermissions();
        $manufacturer = ($this->input->post('parent_id'));
        if ($mdata = $this->inventory_model->getManufacturerByName($manufacturer)) {
            $parent_id = $mdata->id;
        }else{
            $parent_id = $this->inventory_model->addManufacturer(array(
                'name' => $manufacturer,
                'parent_id' => 0
            ));
        }
        $models = $this->input->post('name');
        $data = array();
        foreach ($models as $model) {
            $mdata = $this->inventory_model->getModelByName($model);
            if (!$mdata) {
                $data[] = array(
                    'name'      => $model,
                    'parent_id' => $parent_id,
                );
            }
        }
        $this->db->insert_batch('models' ,$data);
        echo 'true';
    }

    // EDIT CUSTOMER //
    public function edit_model()
    {
        $this->repairer->checkPermissions();
        $id = $this->input->post('id');
        $name = $this->input->post('name');
        $this->db->where('id', $id)->update('models', array('name'=>$name));
        echo $this->repairer->send_json(array('success'=>true));
    }

    // DELETE CUSTOMER 
    public function delete_model()
    {
        $this->repairer->checkPermissions();

        $id = $this->security->xss_clean($this->input->post('id', true));
        $data = $this->inventory_model->delete_model($id);
        echo json_encode($data);
    }


    // GET MODEL BY ID //
    public function getModelByID()
    {
        $id = $this->security->xss_clean($this->input->post('id', true));
        $data = $this->inventory_model->find_model($id);
        echo $this->repairer->send_json($data);
    }


    // GET Manufacturer BY ID //
    public function getManufacturerByID()
    {
        $id = $this->security->xss_clean($this->input->post('id', true));
        $data = $this->inventory_model->find_manufacturer($id);
        echo $this->repairer->send_json($data);
    }

    ///////////////////////////////////////
    // PRINT A Models PAGE //
    public function manufacturers()
    {
        $this->mPageTitle = lang('manufacturers');
        $this->repairer->checkPermissions();
        $this->render('inventory/manufacturer_index');
    }

    // GENERATE THE AJAX TABLE CONTENT //
    public function getAllManufacturers()
    {
        $this->load->library('datatables');
        $this->datatables
            ->select("id, name")
            ->from("models")
            ->where('parent_id', 0)
            ->or_where('parent_id', null);

        $actions = '';
        if ($this->Admin || $this->GP['inventory-edit_manufacturer']) {
            $actions .= "<a class='btn btn-primary btn-sm' id='modify_manufacturer' data-num='$1'><i class='fas fa-edit'></i> </a> ";
        }

        if ($this->Admin || $this->GP['inventory-delete_manufacturer']) {
        $actions .= "<a class='btn btn-danger btn-sm' id='delete' data-num='$1'><i class='fas fa-trash'></i> </a>";
        }

        $this->datatables->add_column('actions', $actions, 'id');
        $this->datatables->unset_column('id');
        echo $this->datatables->generate();
    }
    
    // ADD A CUSTOMER //
    public function add_manufacturer()
    {
        $this->repairer->checkPermissions();
        $manufacturer = ($this->input->post('name'));
        $parent_id = null;
        if ($mdata = $this->inventory_model->getManufacturerByName($manufacturer)) {
            $success = false;
        }else{
            $parent_id = $this->inventory_model->addManufacturer(array(
                'name' => $manufacturer,
                'parent_id' => 0
            ));
        }
        if ($parent_id) {
            echo $this->repairer->send_json(array('success'=>true));
        }else{
            echo $this->repairer->send_json(array('success'=>false));
        }
    }

    // EDIT CUSTOMER //
    public function edit_manufacturer()
    {
        $this->repairer->checkPermissions();
        $id = $this->input->post('id');
        $name = $this->input->post('name');

        $this->db->where('id', $id)->update('models', array('name'=>$name));
        echo $this->repairer->send_json(array('success'=>true));
    }

    // DELETE CUSTOMER 
    public function delete_manufacturer()
    {
        $this->repairer->checkPermissions();
        $id = $this->security->xss_clean($this->input->post('id', true));
        $success = $this->inventory_model->delete_manufacturer($id);
        echo $this->repairer->send_json(array(
            'success' => $success,
        ));
    }


  
    function suggestions()
    {
        $term = $this->input->get('term', TRUE);
        if ($this->mSettings->model_based_search) {
            $model_id = $this->input->get('model_id', TRUE) ? $this->input->get('model_id', TRUE) : FALSE;
        }else{
            $model_id = FALSE;
        }
        if (strlen($term) < 1 || !$term) {
            die("<script type='text/javascript'>setTimeout(function(){ window.top.location.href = '" . site_url('welcome') . "'; }, 10);</script>");
        }
        $rows = $this->inventory_model->getProductNames($term, 5,$model_id);
        if ($rows) {
            foreach ($rows as $row) {

                $pr[] = array('id' => $row->id, 'label' => $row->name . " (" . $row->code . ")", 'code' => $row->code, 'name' => $row->name, 'price' => $row->price, 'qty' => 1, 'available_now' => $row->quantity, 'total_qty' => $row->quantity, 'type' => $row->type);
            }
            $this->repairer->send_json($pr);
        } else {
            $this->repairer->send_json(array(array('id' => 0, 'label' => lang('no_match_found'), 'value' => $term)));
        }
    }
    function product_actions($wh = NULL)
    {
       
        $this->repairer->checkPermissions();
        $this->form_validation->set_rules('form_action', lang("form_action"), 'required');

        if ($this->form_validation->run() == true) {

            if (!empty($_POST['val'])) {
                if ($this->input->post('form_action') == 'delete') {
                    foreach ($_POST['val'] as $id) {
                        $this->inventory_model->deleteProduct($id);
                    }
                    $this->session->set_flashdata('message', $this->lang->line("products_deleted"));
                    redirect($_SERVER["HTTP_REFERER"]);

                } elseif ($this->input->post('form_action') == 'labels') {
                    foreach ($_POST['val'] as $id) {
                        $row = $this->inventory_model->getProductByID($id);
                        if($row->type != 'service'){
                            $pr[$row->id] = array('id' => $row->id, 'label' => $row->name . " (" . $row->code . ")", 'code' => $row->code, 'name' => $row->name, 'price' => $row->price, 'qty' => $row->quantity);

                        }
                    }
                    $this->data['items'] = isset($pr) ? json_encode($pr) : false;
                    $this->data['error'] = (validation_errors() ? validation_errors() : $this->session->flashdata('error'));
                    $this->render('inventory/print_barcodes');

                } elseif ($this->input->post('form_action') == 'export_excel' || $this->input->post('form_action') == 'export_pdf') {

                    $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
                    $sheet = $spreadsheet->getActiveSheet();

                    $sheet->setTitle('Products');
                    $sheet->SetCellValue('A1', lang('code'));
                    $sheet->SetCellValue('B1', lang('name'));
                    $sheet->SetCellValue('C1', lang('model'));
                    $sheet->SetCellValue('D1', lang('cost'));
                    $sheet->SetCellValue('E1', lang('price'));
                    $sheet->SetCellValue('F1', lang('alert_quantity'));
                    $sheet->SetCellValue('G1', lang('tax_rate'));
                    $sheet->SetCellValue('H1', lang('tax_method'));
                    $sheet->SetCellValue('I1', lang('quantity'));
                    $sheet->SetCellValue('J1', lang('type'));

                    $row = 2;
                    foreach ($_POST['val'] as $id) {
                        $product = $this->inventory_model->getProductByID($id);
                        $tax_rate = $this->settings_model->getTaxRateByID($product->tax_rate);
                        $quantity = $product->quantity;

                        $sheet->SetCellValue('A' . $row, $product->code);
                        $sheet->SetCellValue('B' . $row, $product->name);
                        $sheet->SetCellValue('C' . $row, ($product->model_name));
                        $sheet->SetCellValue('D' . $row, $this->repairer->formatDecimal($product->cost));
                        $sheet->SetCellValue('E' . $row, $product->price);
                        $sheet->SetCellValue('F' . $row, $product->alert_quantity);
                        $sheet->SetCellValue('G' . $row, $tax_rate['name']);
                        $sheet->SetCellValue('H' . $row, $product->tax_method ? lang('exclusive') : lang('inclusive'));
                        $sheet->SetCellValue('I' . $row, $quantity);
                        $sheet->SetCellValue('J' . $row, $product->type);
                        $row++;
                    }

                    $sheet->getColumnDimension('A')->setWidth(15);
                    $sheet->getColumnDimension('B')->setWidth(20);
                    $sheet->getColumnDimension('C')->setWidth(10);
                    $sheet->getColumnDimension('D')->setWidth(10);
                    $sheet->getColumnDimension('E')->setWidth(10);
                    $sheet->getColumnDimension('F')->setWidth(10);
                    $sheet->getColumnDimension('G')->setWidth(10);
                    $sheet->getParent()->getDefaultStyle()->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
                    $filename = 'products_' . date('Y_m_d_H_i_s');
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
                        $sheet->getStyle('A0:J'.($row-1))->applyFromArray($styleArray);
                        $sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
                        header('Content-Type: application/pdf');
                        header('Content-Disposition: attachment;filename="' . $filename . '.pdf"');
                        header('Cache-Control: max-age=0');
                        $writer = PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Mpdf');
                        $writer->save('php://output');
                    }

                    redirect($_SERVER["HTTP_REFERER"]);
                }
            } else {
                $this->session->set_flashdata('error', $this->lang->line("no_product_selected"));
                redirect($_SERVER["HTTP_REFERER"]);
            }
        } else {
            $this->session->set_flashdata('error', validation_errors());
            redirect($_SERVER["HTTP_REFERER"]);
        }
    }

    function getSubCategories($category_id = NULL)
    {
        if ($rows = $this->inventory_model->getSubCategories($category_id)) {
            $data = json_encode($rows);
        } else {
            $data = 'null';
        }
        echo $data;
    }

    public function getModels($term = null)
    {
        $manufacturer = $this->input->get('manufacturer');
        // if ($mdata = $this->inventory_model->getManufacturerByName($manufacturer)) {
        //     $this->db->where('parent_id', $mdata->id);
        // }   
        if ($term) {
            $this->db->like('name', $term);
        }
        $q = $this->db->where('parent_id !=', 0)->get('models');
        $names = array();
        if ($q->num_rows() > 0) {
            $names = $q->result_array();
        }
        echo $this->repairer->send_json($names);
    }
}