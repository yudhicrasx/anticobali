<?php

/*
 * Author: Yudhi Lazuardi
 * Contact: yudhicrasx@gmail.com
 */

Class M_users extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function advanced_search_total_record(array $keywords) {
        foreach ($keywords as $key => $keyword) {
            if ((strlen($keyword)) AND ($keyword !== 'null') AND ($keyword !== '0')) {
                $split = explode("_", $key);
                $column_name = $split[1];
                if ($column_name == 'name') {
                    $this->db->where("(firstName LIKE '%{$keyword}%' or lastName LIKE '%{$keyword}%')");
                }
                else
                    $this->db->like($column_name, $keyword);
            }
        }

        $this->db->from(TBL_USERS);
        $total_record = $this->db->count_all_results();

        return $total_record;
    }

    function advanced_search(array $keywords, $limit = 20, $offset = 0) {
        foreach ($keywords as $key => $keyword) {
            if ((strlen($keyword)) AND ($keyword !== 'null') AND ($keyword !== '0')) {
                $split = explode("_", $key);
                $column_name = $split[1];
                if ($column_name == 'name') {
                    $this->db->where("(firstName LIKE '%{$keyword}%' or lastName LIKE '%{$keyword}%')");
                }
                else
                    $this->db->like($column_name, $keyword);
            }
        }

        $data = $this->db->get(TBL_USERS, $limit, $offset);
        if ($data->num_rows() > 0)
            return $data;
        return FALSE;
    }

}

?>
