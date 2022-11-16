<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Reports extends Auth_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->library('repairer');
		$this->load->model('reports_model');
	}

	function stock()
    {
        $this->mPageTitle = lang('stock');
        $this->repairer->checkPermissions();
        $data['error'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('error');
        $this->data['stock'] = $this->reports_model->getStockValue();
        $this->data['totals'] = $this->reports_model->getStockTotals();
        $this->render('reports/stock_chart');

    }

	public function finance($month = NULL, $year = NULL)
    {
        $this->repairer->checkPermissions();
        $this->mPageTitle = lang('revenue_chart');

        $this->data['currency'] = $this->mSettings->currency;
        $this->data['settings'] = $this->mSettings;
        if (isset($month) && isset($year)) {
            $this->data['list'] = $this->reports_model->list_earnings($month, $year);
        } else {
            $this->data['list'] = $this->reports_model->list_earnings(date('m'), date('Y'));
        }
        $this->render('reports/finance');
    }

    function quantity_alerts($warehouse_id = NULL)
    {
        $this->repairer->checkPermissions();
        $this->mPageTitle = lang('quantity_alerts');

        $this->render('reports/quantity_alerts');
    }
    function getQuantityAlerts($warehouse_id = NULL, $pdf = NULL, $xls = NULL)
    {
        $this->repairer->checkPermissions('quantity_alerts');

        $this->load->library('datatables');
        
        $this->datatables
            ->select('code, name, quantity, alert_quantity')
            ->from('inventory')
            ->where('isDeleted', 0)
            ->where('alert_quantity > quantity', NULL)
            ->where('alert_quantity >', 0);
        echo $this->datatables->generate();
    }





    function sales()
    {
        $this->repairer->checkPermissions();
        $this->render('reports/sales');
    }
    
   
    function getAllSales($pdf = NULL, $xls = NULL)
    {
        if ($this->input->get('start_date')) {
            $start_date = date('Y-m-d', strtotime($this->input->get('start_date'))) . " 00:00:00";
        } else {
            $start_date = null;
        }
        if ($this->input->get('end_date')) {
            $end_date = date('Y-m-d', strtotime($this->input->get('end_date'))) . " 23:59:59";
        } else {
            $end_date = null;
        }

        if ($pdf || $xls) {
             $this->db->select("sales.id as id,LPAD(sales.id, 4, '0') as sale_id, DATE_FORMAT(date, '%m-%d-%Y %T') as date, customer, (SELECT GROUP_CONCAT(product_name) FROM sale_items WHERE sale_items.sale_id = sales.id) as name, TRUNCATE(grand_total, 2) as grand_total, TRUNCATE(paid, 2) as paid, (TRUNCATE(grand_total, 2) -  TRUNCATE(paid, 2)) as balance")
                ->from('sales')
                ->where('sale_status', 'completed')
                ->group_by('sales.id');
                
            if ($start_date) {
                $this->db->where('date BETWEEN "' . $start_date . '" and "' . $end_date . '"');
            }

            $q = $this->db->get();
            if ($q->num_rows() > 0) {
                foreach (($q->result()) as $row) {
                    $data[] = $row;
                }
            } else {
                $data = NULL;
            }

            if (!empty($data)) {

                $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
                $sheet = $spreadsheet->getActiveSheet();



                $sheet->SetCellValue('A1', "Sales report from ".date('m-d-Y H:i:s', strtotime($start_date))." to ".date('m-d-Y H:i:s', strtotime($end_date)));
                $sheet->mergeCells('A1:G1');
                $sheet->setTitle("Sales Report");
                $sheet->SetCellValue('A2', "Sale ID");
                $sheet->SetCellValue('B2', "Date");
                $sheet->SetCellValue('C2', ('Customer'));
                $sheet->SetCellValue('D2', ('Product Name'));
                $sheet->SetCellValue('E2', ('Grand Total'));
                $sheet->SetCellValue('F2', ('Paid'));
                $sheet->SetCellValue('G2', ('Balance'));

                $row = 3;
                $tgrand_total = 0;
                $tpaid = 0;
                $tbalance = 0;
                foreach ($data as $data_row) {
                    $ir = $row + 1;
                    if ($ir % 2 == 0) {
                        $style_header = array(                  
                            'fill' => array(
                                'type' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                                'color' => array('rgb'=>'CCCCCC'),
                            ),
                        );
                        $sheet->getStyle("A$row:G$row")->applyFromArray( $style_header );
                    }
                    $grand_total = number_format($data_row->grand_total, 2);
                    $paid = number_format($data_row->paid, 2);
                    $balance = number_format($data_row->balance, 2);
                    $tgrand_total += $grand_total;
                    $tpaid += $paid;
                    $tbalance += $balance;
                    $sheet->SetCellValue('A' . $row, ($data_row->sale_id));
                    $sheet->SetCellValue('B' . $row, $data_row->date);
                    $sheet->SetCellValue('C' . $row, $data_row->customer);
                    $sheet->SetCellValue('D' . $row, $data_row->name);
                    $sheet->SetCellValue('E' . $row, $grand_total);
                    $sheet->SetCellValue('F' . $row, $paid);
                    $sheet->SetCellValue('G' . $row, $balance);
                    $row++;
                }
                $style_header = array(      
                    'fill' => array(
                        'type' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                        'color' => array('rgb'=>'fdbf2d'),
                    ),
                );
                $sheet->getStyle("A$row:G$row")->applyFromArray( $style_header );
                $sheet->SetCellValue('E' . $row, $tgrand_total);
                $sheet->SetCellValue('F' . $row, $tpaid);
                $sheet->SetCellValue('G' . $row, $tbalance);

                $sheet->getColumnDimension('A')->setWidth(10);
                $sheet->getColumnDimension('B')->setWidth(30);
                $sheet->getColumnDimension('C')->setWidth(25);
                $sheet->getColumnDimension('D')->setWidth(45);
                $sheet->getColumnDimension('E')->setWidth(15);
                $sheet->getColumnDimension('F')->setWidth(15);
                $sheet->getColumnDimension('G')->setWidth(15);
               
                $filename = 'sales_report';
                $sheet->getParent()->getDefaultStyle()->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
                $sheet->getStyle('E2:E' . ($row))->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
                $sheet->getStyle('F2:F' . ($row))->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
                $sheet->getStyle('G2:G' . ($row))->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);

                $sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);


                $header = 'A1:G1';
                $sheet->getStyle($header)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB('94ce58');
                $style = array(
                    'font' => array('bold' => true,),
                    'alignment' => array('horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,),
                );
                $sheet->getStyle($header)->applyFromArray($style);
                

                $header = 'A2:G2';
                $sheet->getStyle($header)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB('fdbf2d');
                $style = array(
                    'font' => array('bold' => true,),
                    'alignment' => array('horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_GENERAL,),
                );
                $sheet->getStyle($header)->applyFromArray($style);


                $header = 'A'.$row.':G'.$row;
                $sheet->getStyle($header)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB('fdbf2d');
                $style = array(
                    'font' => array('bold' => true,),
                    'alignment' => array('horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_GENERAL,),
                );
                $sheet->getStyle($header)->applyFromArray($style);

                if ($pdf) {
                    $styleArray = [
                        'borders' => [
                            'allBorders' => [
                                'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
                                'color' => ['argb' => 'FFFF0000'],
                            ],
                        ],
                    ];
                    $sheet->getStyle('A0:G'.($row))->applyFromArray($styleArray);
                    $sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
                    header('Content-Type: application/pdf');
                    header('Content-Disposition: attachment;filename="' . $filename . '.pdf"');
                    header('Cache-Control: max-age=0');
                    $writer = PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Mpdf');
                    $writer->save('php://output');
                }
                if ($xls) {
                    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
                    header('Content-Disposition: attachment;filename="'.$filename.'.xlsx"');
                    header('Cache-Control: max-age=0');

                    $writer = PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
                    $writer->save('php://output');
                    exit();
                }
            }
        } else {
            $this->load->library('datatables');

            if ($start_date ) {
                $this->datatables->where('sales.date BETWEEN "' . $start_date . '" and "' . $end_date . '"');
            }
            $this->datatables
                ->select("sales.id as id,LPAD(sales.id, 4, '0') as sale_id, DATE_FORMAT(sales.date, '%m-%d-%Y %T') as date, clients.name as customer, (SELECT GROUP_CONCAT(product_name) FROM sale_items WHERE sale_items.sale_id = sales.id) as name, TRUNCATE(grand_total, 2) as grand_total, TRUNCATE(paid, 2) as paid, (TRUNCATE(grand_total, 2) -  TRUNCATE(paid, 2)) as balance, payment_status, sales.id")
                ->from('sales')
                ->join('clients', 'clients.id=sales.customer_id', 'left')
                ->where('sale_status', 'completed')
                ->group_by('sales.id');


            $q = isset($_GET) ? http_build_query($_GET) : '';
            $detail_link = anchor('panel/pos/modal_view/$1', '<i class="fa fa-file-text-o"></i> ' . lang('sale_details'), 'data-toggle="modal" data-target="#myModalLG"');
            $bill_link = '<a href="'.base_url('panel/pos/view/$1').'" ><i class="fa fa-file-text-o"></i> '.lang('view_sale').'</a>';
            $payments_link = anchor('panel/pos/payments/$1', '<i class="fa fa-money"></i> ' . lang('view_payments'), 'data-toggle="modal" data-target="#myModal" class="dropdown-item"');
            $add_payment_link = anchor('panel/pos/add_payment/$1/?'.$q, '<i class="fa fa-money"></i> ' . lang('add_payment'), 'data-toggle="modal" data-target="#myModal" class="dropdown-item"');
            $action = '<div class="text-center"><div class="btn-group text-left">'
                . '<button type="button" class="btn btn-default btn-xs btn-primary dropdown-toggle" data-toggle="dropdown">'
                . lang('actions') . ' <span class="caret"></span></button>
                <ul class="dropdown-menu pull-right" role="menu">
                    <li>' . $detail_link . '</li>
                    <li>' . $bill_link . '</li>
                    <li>' . $payments_link . '</li>
                    <li>' . $add_payment_link . '</li>
                </ul>
            </div></div>';
            $this->datatables->add_column('actions', $action, 'id');
            $this->datatables->unset_column('id');
            echo $this->datatables->generate();
        }



    }


    public function drawer()
    {
        $this->repairer->checkPermissions();
        $this->mPageTitle = lang('drawer_report');
        $this->render('reports/drawer');
    }

    function getDrawerReport($pdf = NULL, $xls = NULL)
    {
        if ($this->input->get('start_date')) {
            $start_date = date('Y-m-d', strtotime($this->input->get('start_date'))) . " 00:00:00";
        } else {
            $start_date = date('Y-m-d 00:00:00');
        }
        if ($this->input->get('end_date')) {
            $end_date = date('Y-m-d', strtotime($this->input->get('end_date'))) . " 23:59:59";
        } else {
            $end_date = date('Y-m-d 23:59:59');
        }


        if ($pdf || $xls) {
             $this->db
                ->select("date, closed_at, (SELECT CONCAT(users.first_name, ' ', users.last_name) FROM users where users.id=pos_register.user_id) as opened_by,(SELECT CONCAT(users.first_name, ' ', users.last_name) FROM users where users.id=pos_register.closed_by) as closed_by, cash_in_hand, total_cc, total_cheques, total_cash, total_cc_submitted, total_cheques_submitted,total_cash_submitted", FALSE)
                ->from("pos_register")
                ->order_by('date desc');

            if ($start_date) {
                $this->db->where('date BETWEEN "' . $start_date . '" and "' . $end_date . '"');
            }

            $q = $this->db->get();
            if ($q->num_rows() > 0) {
                foreach (($q->result()) as $row) {
                    $data[] = $row;
                }
            } else {
                $data = NULL;
            }

            if (!empty($data)) {

                $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
                $sheet = $spreadsheet->getActiveSheet();
          
                $sheet->setTitle(lang('drawer_report'));
                $sheet->SetCellValue('A2', lang('open_time'));
                $sheet->SetCellValue('B2', lang('close_time'));
                $sheet->SetCellValue('C2', lang('opened_by'));
                $sheet->SetCellValue('D2', lang('closed_by'));
                $sheet->SetCellValue('E2', lang('cash_in_hand'));
                $sheet->SetCellValue('F2', lang('cc_slips'));
                $sheet->SetCellValue('G2', lang('cheques'));
                $sheet->SetCellValue('H2', lang('total_cash'));
                $sheet->SetCellValue('I2', lang('cc_slips_submitted'));
                $sheet->SetCellValue('J2', lang('cheques_submitted'));
                $sheet->SetCellValue('K2', lang('total_cash_submitted'));
               

                $sheet->SetCellValue('A1', sprintf(lang('drawer_report_Date'), date('m-d-Y H:i:s', strtotime($start_date)), date('m-d-Y H:i:s', strtotime($end_date))));
                $sheet->mergeCells('A1:K1');

                
                $row = 3;
                foreach ($data as $data_row) {
                    $ir = $row + 1;
                    if ($ir % 2 == 0) {
                        $style_header = array(                  
                            'fill' => array(
                                'type' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                                'color' => array('rgb'=>'CCCCCC'),
                            ),
                        );
                        $sheet->getStyle("A$row:K$row")->applyFromArray( $style_header );
                    }

                    $sheet->SetCellValue('A' . $row, ($data_row->date));
                    $sheet->SetCellValue('B' . $row, $data_row->closed_at);
                    $sheet->SetCellValue('C' . $row, $data_row->opened_by);
                    $sheet->SetCellValue('D' . $row, $data_row->closed_by);
                    $sheet->SetCellValue('E' . $row, $data_row->cash_in_hand);
                    $sheet->SetCellValue('F' . $row, $data_row->total_cc);
                    $sheet->SetCellValue('G' . $row, $data_row->total_cheques);
                    $sheet->SetCellValue('H' . $row, $data_row->total_cash);
                    $sheet->SetCellValue('I' . $row, $data_row->total_cc_submitted);
                    $sheet->SetCellValue('J' . $row, $data_row->total_cheques_submitted);
                    $sheet->SetCellValue('K' . $row, $data_row->total_cash_submitted);
                    if($data_row->total_cash_submitted < $data_row->total_cash || $data_row->total_cheques_submitted < $data_row->total_cheques || $data_row->total_cc_submitted < $data_row->total_cc) {
                        $sheet->getStyle('A'.$row.':K'.$row)->applyFromArray(

                                array( 'fill' => array('type' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'color' => array('rgb' => 'F2DEDE')) )
                                );
                    }
                    $row++;
                }



                $sheet->getColumnDimension('A')->setWidth(25);
                $sheet->getColumnDimension('B')->setWidth(25);
                $sheet->getColumnDimension('C')->setWidth(25);
                $sheet->getColumnDimension('D')->setWidth(25);
                $sheet->getColumnDimension('E')->setWidth(15);
                $sheet->getColumnDimension('F')->setWidth(15);
                $sheet->getColumnDimension('G')->setWidth(15);
                $sheet->getColumnDimension('H')->setWidth(15);
                $sheet->getColumnDimension('I')->setWidth(15);
                $sheet->getColumnDimension('J')->setWidth(15);
                $sheet->getColumnDimension('K')->setWidth(15);
                $filename = 'register_report';

                $sheet->getParent()->getDefaultStyle()->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);

                $sheet->getStyle('E2:K' . ($row))->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);


                $sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);

                $header = 'A1:K1';
                $sheet->getStyle($header)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB('94ce58');
                $style = array(
                    'font' => array('bold' => true,),
                    'alignment' => array('horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,),
                );
                $sheet->getStyle($header)->applyFromArray($style);
               

                $header = 'A2:K2';
                $sheet->getStyle($header)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB('fdbf2d');
                $style = array(
                    'font' => array('bold' => true,),
                    'alignment' => array('horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,),
                );

                $sheet->getStyle($header)->applyFromArray($style);


                $sheet->getParent()->getDefaultStyle()->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);

                if ($pdf) {
                    $styleArray = [
                        'borders' => [
                            'allBorders' => [
                                'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
                                'color' => ['argb' => 'FFFF0000'],
                            ],
                        ],
                    ];
                    $sheet->getStyle('A0:K'.($row-1))->applyFromArray($styleArray);
                    $sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
                    header('Content-Type: application/pdf');
                    header('Content-Disposition: attachment;filename="' . $filename . '.pdf"');
                    header('Cache-Control: max-age=0');
                    $writer = PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Mpdf');
                    $writer->save('php://output');
                }
                if ($xls) {
                    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
                    header('Content-Disposition: attachment;filename="'.$filename.'.xlsx"');
                    header('Cache-Control: max-age=0');

                    $writer = PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
                    $writer->save('php://output');
                    exit();
                }
            }else{
                $this->session->set_flashdata('warning', lang('no_record_found'));
                redirect('panel/reports/drawer');
            }
        } else {
            $this->load->library('datatables');

            $this->datatables

                ->select("(SELECT CONCAT(users.first_name, ' ', users.last_name) FROM users where users.id=pos_register.user_id) as opener,DATE_FORMAT(date, '%m-%d-%Y %T') as op_date, cash_in_hand, (SELECT CONCAT(users.first_name, ' ', users.last_name) FROM users where users.id=pos_register.closed_by) as closer, DATE_FORMAT(closed_at, '%m-%d-%Y %T') as cl_date,total_cash, pos_register.id as id, pos_register.status as status")
                ->from('pos_register');
            if ($start_date) {
                $this->datatables->where('pos_register.date BETWEEN "' . $start_date . '" and "' . $end_date . '"');
            }
            echo $this->datatables->generate();
        }

    }

}
