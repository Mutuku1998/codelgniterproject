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

        // //using model
        // $query = $this->db->get('users');

        //using sql query
        $query = $this->db->query("SELECT * FROM users ORDER BY id DESC");

        return $query;
    }
    //delete function

    public function delete_data($id){
        $this->db->where('id', $id);
        $this->db->delete('users');
    }

    public function fetch_single_data($id){
        $this->db->where('id', $id);
        $query = $this->db->get('users');
        
        // Return the single row
        return $query->row();
    }

    public function update_data($data,$id){

        $this->db->where("id",$id);
        $this->db->update("users",$data);
    }
    

    //login
    public function can_login($email, $password)
    {
        $this->db->where('email', $email);
        $this->db->where('password', $password);
    
        $query = $this->db->get('login');
        if ($query->num_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }
    
    //inserting images on db

    public function insert_image($data){

        $this->db->insert('tb_images',$data);
    }
//fetching images from db

public function fetch_image(){
    $output = '';
    $this->db->select('image');
    $this->db->from('tb_images');
    $this->db->order_by('id',"DESC");
    $query = $this->db->get();


    foreach ($query->result() as $row) {
        $output .= '
            <div class="col-md-3">
                <img src="' . base_url() . 'upload/' . $row->image. '"
                     class="img_responsive img-thumbnail"/>
            </div>';
    }
    

    return $output;
}
 //check if email exists
 public function is_email_available($email){
    $this->db->where('email', $email);
    $query = $this->db->get('login');

    // SELECT * FROM login WHERE email = '$email'

    if($query->num_rows() > 0){
        return true;
    } else {
        return false;
    }
}


}
?>