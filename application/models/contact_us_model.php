<?php

/*
 * Author: Yudhi Lazuardi
 * Contact: yudhicrasx@gmail.com
 */

Class Contact_us_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }
    
    function select_order($table_name, $fields = '*', $where = "", $backticks = TRUE) {
        if ($where !== "") {
            $this->db->where($where, NULL, $backticks);
        }
        $this->db->select($fields);
        $this->db->order_by("input_date", "desc");
        $data = $this->db->get($table_name);

        if ($data->num_rows() > 0)
            return $data;
        return FALSE;
    }

}

?>
