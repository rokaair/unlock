<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Reports_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function getStockValue()
    {
        $q = $this->db->query("SELECT SUM(by_price) as stock_by_price, SUM(by_cost) as stock_by_cost FROM ( Select COALESCE(sum(inventory.quantity), 0)*price as by_price, COALESCE(sum(inventory.quantity), 0)*cost as by_cost FROM inventory WHERE isDeleted != 1 AND quantity != 0 GROUP BY inventory.id )a");
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return FALSE;
    }
    public function getStockTotals()
    {
        $this->db->select('sum(quantity) as total_quantity, count(id) as total_items', FALSE);
        $this->db->where('quantity !=', 0);
        $this->db->where('isDeleted !=', 1);
        $q = $this->db->get('inventory');
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return FALSE;
    }
    /*
        |--------------------------------------------------------------------------
        | GET EARNINGS BY MONTHS/YEARS
        | @param month, year
        |--------------------------------------------------------------------------
        */
        public function list_earnings($month, $year)
        {
            $data = $this->list_closed_reparations($month, $year);
            $number = array();
            for ($i = 1; $i <= 33; ++$i) {
                $number[$i] = 0;
            }
            for ($d = 0; $d <= count($data); ++$d) {
                $id = @date('j', strtotime($data[$d]['date_closing']));
                $number[$id] = $number[$id] + @$data[$d]['grand_total'];
            }
            $number[32] = (int) $month;
            $number[33] = (int) $year;
            return $number;
        }
        /*
    |--------------------------------------------------------------------------
    | LIST OF CLOSED ORDER/REPARATION
    | @param month, year
    |--------------------------------------------------------------------------
    */
    public function list_closed_reparations($month, $year)
    {
        $data = array();
        $data1 = array();
        $this->db->order_by('id', 'asc');
        $query = $this->db->get('reparation');
        if ($query->num_rows() > 0) {
            $data = $query->result_array();
        }
        foreach ($data as $d) {
            // if ($d['status'] == 0) {
                if ((date('m', strtotime($d['date_closing'])) == $month) && (date('Y', strtotime($d['date_closing'])) == $year)) {
                    $data1[] = $d;
                }
            // }
        }
        return $data1;
    }


}
