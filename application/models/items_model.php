<?php

/*
 * Author: Yudhi Lazuardi
 * Contact: yudhicrasx@gmail.com
 */

Class Items_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function select_order($table_name, $fields = '*', $where = "", $backticks = TRUE) {
        if ($where !== "") {
            $this->db->where($where, NULL, $backticks);
        }
        $this->db->select($fields);
        $this->db->order_by("order");
        $this->db->order_by("id_items", "desc");
        $data = $this->db->get($table_name);

        if ($data->num_rows() > 0)
            return $data;
        return FALSE;
    }

    function reorder($id_items, $query) {
        $this->db->where('id_items', $id_items);
        $this->db->update(TBL_ITEMS, $query);
    }

    function join_items_photos($where='') {
        if($where !== '') {
            $this->db->where($where); 
        }
        $this->db->select('*');
        $this->db->from(TBL_ITEMS);
        $this->db->join(TBL_PHOTOS, TBL_PHOTOS.".id_items = ".TBL_ITEMS.".id_items");
        $data = $this->db->get();

        if ($data->num_rows() > 0)
            return $data;
        return FALSE;
    }


    function join_items_itemsCategories($where='') {
        if($where !== '') {
            $this->db->where($where); 
        }
        $this->db->where(TBL_ITEMS.".active", 1);
        $this->db->select('*');
        $this->db->from(TBL_ITEMS);
        $this->db->join(TBL_PHOTOS, TBL_PHOTOS.".id_items = ".TBL_ITEMS.".id_items");
        $this->db->join(TBL_ITEMS_CATEGORIES, TBL_ITEMS_CATEGORIES.".id_items = ".TBL_ITEMS.".id_items");
        $this->db->join(TBL_CATEGORIES, TBL_CATEGORIES.".id_categories = ".TBL_ITEMS_CATEGORIES.".id_categories");
        $data = $this->db->get();

        if ($data->num_rows() > 0)
            return $data;
        return FALSE;
    }
    
    function search($keyword) {
        // Explode words into array, using space as delimiter
        $words = explode(' ', (trim($keyword)));

        // Set fields that you wish to search
        $searchFields = array(TBL_ITEMS.'.name', TBL_ITEMS.'.description', TBL_ITEMS.'.keywords', TBL_CATEGORIES.'.category');

        // Construct query, creating a WHERE clause for every word
        $full_string = '';
        foreach ($searchFields as $field):
            $where_string = '';
            foreach ($words as $word):
                $where_string .= " AND ".$field." LIKE '%".$word."%'";
            endforeach;
            $full_string .= " OR (".substr($where_string, 5).")";
            //$this->db->where($full_string);
        endforeach;
        $final_string = '('.substr($full_string, 4).')';
        
        $this->db->where(TBL_ITEMS.".active", 1);
        $this->db->where($final_string);
        $this->db->select('*');
        $this->db->from(TBL_ITEMS);
        $this->db->join(TBL_PHOTOS, TBL_PHOTOS.".id_items = ".TBL_ITEMS.".id_items");
        $this->db->join(TBL_ITEMS_CATEGORIES, TBL_ITEMS_CATEGORIES.".id_items = ".TBL_ITEMS.".id_items");
        $this->db->join(TBL_CATEGORIES, TBL_CATEGORIES.".id_categories = ".TBL_ITEMS_CATEGORIES.".id_categories");
        $data = $this->db->get();

        if ($data->num_rows() > 0)
            return $data;
        return FALSE;
    }

}

?>
