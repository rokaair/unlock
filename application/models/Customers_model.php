<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Customers_model extends CI_Model
{
	  /*
    |--------------------------------------------------------------------------
    | GET ALL CUSTOMERS LIST
    |--------------------------------------------------------------------------
    */
    public function getClients()
    {
        $data = array();
        $this->db->order_by('id', 'desc');
        $query = $this->db->get('clients');
        if ($query->num_rows() > 0) {
            $data = $query->result_array();
        }

        return $data;
    }
    public function delete_clients($id)
    {
        $this->db->delete('clients', array('id' => $id));
    }


    /*
    |--------------------------------------------------------------------------
    | ADD CUSTOMERS TO DB
    | @param Customer name, surname, street, city, phone, mail, comments
    |--------------------------------------------------------------------------
    */
    public function insert_client($data)
    {
        $this->db->insert('clients', $data);
        return $this->db->insert_id();
    }

    /*
    |--------------------------------------------------------------------------
    | SAVE CUSTOMER
    | @param Customer name, surname, street, city, phone, id, mail, comments
    |--------------------------------------------------------------------------
    */
    public function edit_client($id, $data)
    {
        $this->db->where('id', $id);
        if ($this->db->update('clients', $data)) {
            return TRUE;
        }else{
            return FALSE;
        }
    }
    
     /*
    |--------------------------------------------------------------------------
    | FIND CUSTOMER
    | @param The ID
    |--------------------------------------------------------------------------
    */
    public function find_customer($id)
    {
        $data = array();
        $query = $this->db->get_where('clients', array('id' => $id));
        if ($query->num_rows() > 0) {
            $data = $query->row_array();
        }

        return $data;
    }

    public function addCustomers($data) {
        $this->db->insert_batch('clients',$data);
        return TRUE;
    }
	
}
