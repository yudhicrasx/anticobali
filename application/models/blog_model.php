<?php

/*
 * Author: Yudhi Lazuardi
 * Contact: yudhicrasx@yahoo.com
 */

Class Blog_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }
    
    function select_order($table_name, $fields = '*', $where = "", $backticks = TRUE) {
        if ($where !== "") {
            $this->db->where($where, NULL, $backticks);
        }
        $this->db->select($fields);
        $this->db->order_by("id_blog", "desc");
        $data = $this->db->get($table_name);

        if ($data->num_rows() > 0)
            return $data;
        return FALSE;
    }

    function reorder($id_items, $order) {
        $this->db->where('id_blog', $id_items);
        $this->db->update(TBL_BLOG, array("order" => $order));
    }

}

?>
