<?php

class Main_Model extends CI_Model{

    public function main_test(){
        echo "new model";
    }
    //write database operations here

    public function  insert_data($data){
        $this->db->insert('users',$data);
    }

    public function fetch_data(){
        $query = $this->db->get('users');

        return $query;
    }
}
?>