<?php

/*
 * Author: Yudhi Lazuardi
 * Contact: yudhicrasx@gmail.com
 */

Class M_refer extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    /*
     * WHERE can uses an array, with a key as the field
     */

    function select_by($table_name, $fields = '*', $where = "", $backticks = TRUE) {
        if ($where !== "") {
            if(is_array($where)){
                $this->db->where($where);
            }else
            $this->db->where($where, NULL, $backticks);
        }
        $this->db->select($fields);
        $data = $this->db->get($table_name);

        if ($data->num_rows() > 0)
            return $data;
        return FALSE;
    }

    function select_by_where_in($table_name, $fields = '*', $selector = 'id', $where = "") {
        if ($where !== "") {
            $this->db->where_in($selector, $where);
        }
        $this->db->select($fields);
        $data = $this->db->get($table_name);

        if ($data->num_rows() > 0)
            return $data;
        return FALSE;
    }
    
    /*
     * return: (boolean) result of querie(s) (insert/update), last_id(s) => condition "insert"
     * Support: insert & update, multi 'where' condition
     */

    function insert_update($post_data, $action = "insert", $where = "") {
        if ($action == "insert") {
            foreach ($post_data as $key => $rows):
                $query = $this->db->insert($key, $rows);
                if (!$query) { //if error mysql
                    $data['process'] = 0;
                    return $data;
                }
                else
                    $res[] = $query;
                $last_id[$key][] = $this->db->insert_id();
            endforeach;
        }
        else { /* condition $action == update */
            /* collecting the table(s) */
            foreach ($where as $where_key => $wh):
                $whe[] = $where_key;
            endforeach;

            $i = 0;
            foreach ($post_data as $key => $rows):
                if ((isset($whe[$i])) && ($whe[$i] == $key)) {
                    $this->db->where($where[$key]);
                    $res = $this->db->update($key, $rows);
                }
                $i++;
            endforeach;
        }
        $data["process"] = $res;
        $action == "insert" ? ($data["last_id"] = $last_id) : '';
        return $data;
    }
    
    function insert_batch($table_name, $post_data) {
            $query = $this->db->insert_batch($table_name, $post_data);
            if (!$query) { //if error mysql
                $data['process'] = 0;
                return $data;
            }
            else
                $res = $query;

        $data["process"] = $res;
        return $data;
    }
    
    function delete_by_ids($table_name, $selector, $ids=array()) {
        $this->db->where_in($selector, $ids);
        $this->db->delete($table_name);  
        if(($this->db->affected_rows() > 0)) {
           return TRUE; 
        }else {
            return FALSE;
        }
    }

}

?>
