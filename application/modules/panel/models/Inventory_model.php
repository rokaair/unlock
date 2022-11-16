<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Inventory_model extends CI_Model
{
	
    public function getModelNameByID($id)
    {
        $q = $this->db->get_where('models', array('id' => $id), 1);
        if ($q->num_rows() > 0) {
            return $q->row()->name;
        }
        return FALSE;
    }

    public function addProduct($data)
    {
        if ($this->db->insert('inventory', $data)) {
            return true;
        }
    }
    public function deleteProduct($id)
    {
        $this->db->where('id', $id);
        if ($this->db->update('inventory', array('isDeleted' => 1))) {
            return true;
        }
        return FALSE;
    }

    public function getProductByID($id)
    {
        $q = $this->db->get_where('inventory', array('id' => $id), 1);
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return FALSE;
    }
    public function updateProduct($id, $data)
    {
        if ($this->db->update('inventory', $data, array('id' => $id))) {
            return true;
        } else {
            return false;
        }
    }
    
     public function getProductNames($term, $limit = 5, $model_id = FALSE)
    {
        $this->db->select('*')
            ->where("(" . $this->db->dbprefix('inventory') . ".name LIKE '%" . $term . "%' OR code LIKE '%" . $term . "%' OR
                concat(" . $this->db->dbprefix('inventory') . ".name, ' (', code, ')') LIKE '%" . $term . "%')")->where('isDeleted !=', 1);
            if ($model_id) {
               $this->db->where('model_id', $model_id);
            }
            $this->db->group_by('inventory.id')->where('isDeleted', 0)->limit($limit);

        $q = $this->db->get('inventory');
        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
    }
    /*
    |--------------------------------------------------------------------------
    | GET ALL CUSTOMERS LIST
    |--------------------------------------------------------------------------
    */
    public function getSuppliers()
    {
        $data = array();
        $this->db->order_by('id', 'desc');
        $query = $this->db->get('suppliers');
        if ($query->num_rows() > 0) {
            $data = $query->result_array();
        }

        return $data;
    }
    public function delete_supplier($id)
    {
        $this->db->delete('suppliers', array('id' => $id));
    }


    /*
    |--------------------------------------------------------------------------
    | ADD CUSTOMERS TO DB
    | @param Customer name, surname, street, city, phone, mail, comments
    |--------------------------------------------------------------------------
    */
    public function insert_supplier($data)
    {
        $this->db->insert('suppliers', $data);
        return $this->db->insert_id();
    }

     /*
    |--------------------------------------------------------------------------
    | FIND CUSTOMER
    | @param The ID
    |--------------------------------------------------------------------------
    */
    public function find_supplier($id)
    {
        $data = array();
        $query = $this->db->get_where('suppliers', array('id' => $id));
        if ($query->num_rows() > 0) {
            $data = $query->row_array();
        }

        return $data;
    }

    /*
    |--------------------------------------------------------------------------
    | SAVE CUSTOMER
    | @param Customer name, surname, street, city, phone, id, mail, comments
    |--------------------------------------------------------------------------
    */
    public function edit_supplier($id, $data)
    {
        
        $this->db->where('id', $id);
        if ($this->db->update('suppliers', $data)) {
            return TRUE;
        }else{
            return FALSE;
        }
        

    }




    /*
    |--------------------------------------------------------------------------
    | GET ALL CUSTOMERS LIST
    |--------------------------------------------------------------------------
    */
    public function getModels()
    {
        $data = array();
        $this->db->order_by('id', 'desc');
        $query = $this->db->get('models');
        if ($query->num_rows() > 0) {
            $data = $query->result_array();
        }

        return $data;
    }
    public function delete_model($id)
    {
        $this->db->delete('models', array('id' => $id));
    }


    /*
    |--------------------------------------------------------------------------
    | ADD CUSTOMERS TO DB
    | @param Customer name, surname, street, city, phone, mail, comments
    |--------------------------------------------------------------------------
    */
    public function insert_model($data)
    {
        $this->db->insert('models', $data);
        return $this->db->insert_id();
    }

     /*
    |--------------------------------------------------------------------------
    | FIND CUSTOMER
    | @param The ID
    |--------------------------------------------------------------------------
    */

    public function find_model($id)
    {
        $query = $this->db->where('id', $id)->get('models');
        if ($query->num_rows() > 0) {
            $data = $query->row();
            return $data;
        }
        return false;
    }

    public function find_manufacturer($id)
    {
        $query = $this->db->where('id', $id)->get('models');
        if ($query->num_rows() > 0) {
            $data = $query->row();
            return $data;
        }
        return false;
    }

    

    /*
    |--------------------------------------------------------------------------
    | SAVE CUSTOMER
    | @param Customer name, surname, street, city, phone, id, mail, comments
    |--------------------------------------------------------------------------
    */
    public function edit_model($id, $data)
    {
        
        $this->db->where('id', $id);
        if ($this->db->update('models', $data)) {
            return TRUE;
        }else{
            return FALSE;
        }
        

    }


    public function getSubCategories($parent_id) {
        $this->db->select('id as id, name as text')
        ->where('parent_id', $parent_id)->order_by('name');
        $q = $this->db->get("categories");
        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return FALSE;
    }

    public function getManufacturerByName($name)
    {
        $name = strtolower($name);
        $q = $this->db
            ->where('parent_id', 0)
            ->where('LOWER(`name`)', ($name))
            ->get('models');

        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return FALSE;
    }

    public function getModelByName($name)
    {
        $name = strtolower($name);
        $q = $this->db
            ->where('parent_id !=', 0)
            ->where('LOWER(`name`)', ($name))
            ->get('models');

        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return FALSE;
    }


    public function addManufacturer($data)
    {
        $q = $this->db->insert('models', $data);
        return $this->db->insert_id();
    }

    public function delete_manufacturer($id)
    {
        $q = $this->db->where('parent_id', $id)->get('models');
        if ($q->num_rows() > 0) {
            return false;
        }else{
            $this->db->delete('models', array('id'=>$id));
            return true;
        }
    }
	
}
