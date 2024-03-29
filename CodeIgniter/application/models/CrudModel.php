<?php

class CrudModel extends CI_Model{

        var $table = "users";
        var $select_column = array("id","email","name","password");
        var $order_column= array(null,"email",'name',null,null);

        public function make_query(){
            $this->db->select($this->select_column);
            $this->db->from($this->table);

            if(isset($_POST['search']['value'])){

                $this->db->like('email',$_POST['search']['value']);
                $this->db->or_like('name',$_POST['search']['value']);
            }
            if(isset($_POST['order'])){

    $this->db->order_by($this->order_column[$_POST['order']['0']['column'
    ]], $_POST['order']['0']['dir']);

            }else{

$this->db->order_by("id","DESC");

            }
        }

        public function make_datatables(){
            $this->make_query();
            if($_POST['length'] != -1)
            {
                $this->db->limit($_POST["length"],$_POST['start']);
            }
            $query = $this->db->get();
            return $query->result();
        }
        public function get_filtered_data(){
            $this->make_query();
            $query= $this->db->get();
            return $query->num_rows();
        }
        public function get_all_data(){
            $this->db->select("*");
            $this->db->from($this->table);
            return $this->db->count_all_results();
        }
    public function insert_crud($data){
        $this->db->insert('users',$data);
    }

    //update

    public function fetch_single_user($user_id){
        $this->db->where('id',$user_id);
        $query = $this->db->get('users');

        return $query->result();

    }

    public function update_crud($user_id,$data){
        $this->db->where('id',$user_id);
        $this->db->update('users',$data);
    }

    //delete
    public function delete_single_user($user_id){
        $this->db->where("id",$user_id);
        $this->db->delete("users");

        //DELETE FROM users WHERE id = '$user_id'
    }
}


?>