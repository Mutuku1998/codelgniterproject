<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Main extends CI_Controller {

public function index (){

  $this->load->model("Main_Model");

	$data['fetch_data'] = $this->Main_Model->fetch_data();
	$this->load->view('crud_view',$data);


}

// form validation library

public function form_validation() {
    $this->load->library('form_validation');

    $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
    $this->form_validation->set_rules('name', 'Name', 'required');
    $this->form_validation->set_rules('password', 'Password', 'required');

    if ($this->form_validation->run()) {
        $this->load->model('Main_Model');

        $data = array(
            'email' => $this->input->post('email'),
            'name' => $this->input->post('name'),
            'password' => $this->input->post('password')
        );

        if($this->input->post("update")){

            $this->Main_Model->update_data($data,$this->input->post("hidden_id"));
            redirect(base_url()."main/updated");
        }

        if($this->input->post('insert')){
 
        $this->Main_Model->insert_data($data);

        redirect(base_url() . 'main/inserted');
        }

    } else {
        $this->index();
    }
}

public function inserted(){
	$this->index();
}

 public function delete_data(){
    $id = $this->uri->segment(3);
    var_dump($id); //  debugging
    $this->load->model('Main_Model');
    $this->Main_Model->delete_data($id);
    redirect(base_url() ."main/deleted");
}


    public function deleted(){
        $this->index();
    }
    
    public function update_data(){
        $user_id = $this->uri->segment(3);
        $this->load->model('Main_Model');
    
        // Fetch data for the specified user
        $data['user_data'] = $this->Main_Model->fetch_single_data($user_id);
    
        // Load the view with the user data
        $this->load->view('update', $data);
    }
    public function updated(){
        $this->index();
    }

//user login

public function login (){
    $data['title'] = "sample of login session";
    $this->load->view('login',$data);
}
//form validation
public function login_validation(){

    $this->load->library('form_validation');
    $this->form_validation->set_rules('email','email','required');
    $this->form_validation->set_rules('password','password','required');

    if($this->form_validation->run())
    {
$email = $this->input->post('email');
$password = $this->input->post('password');

$this->load->model('Main_Model');
if($this->Main_Model->can_login($email,$password)){

    $session_data = array(
'email' => $email
    );
$this->session->set_userdata($session_data);

redirect(base_url(). 'main/enter');
}else
{
    $this->session->set_flashdata('error','incorrect email or password');
    redirect(base_url(). 'main/login');
}

    }
    
    else{

        $this->login();

    }
}

public function enter(){
    if($this->session->userdata('email')!=''){

        $this->load->view('admindashboard');

    }else{

        redirect(base_url() . 'main/login');
    }
}
public function logout(){
    $this->session->unset_userdata('email');
    redirect(base_url() . "main/login");
}
// image upload
public function image_upload(){

    $data['title'] = "How to upload image using ajax jquery";
$this->load->model('Main_Model');
$data['image_data'] = $this->Main_Model->fetch_image();
    $this->load->view('image_upload',$data);
}

public function ajax_upload(){
    if(isset($_FILES['image_file']['name']))
    {
        $config['upload_path'] = './upload/';
        $config['allowed_types'] = 'jpg|jpeg|png|gif';
        $this->load->library('upload', $config);



        if(!$this->upload->do_upload('image_file')){
            echo $this->upload->display_errors();
        }
        else{
            $data = $this->upload->data();

            $config['image-library'] = 'gd2';
            $config['source_image'] = './upload/'.$data["file_name"];
            $config['create_thumb'] = FALSE;
            $config['maintain_radio'] = FALSE;
            $config['quality'] ="60%";
            $config['width'] = 200;
            $config['height'] = 200;
            $config['new_image'] = '.upload/'.$data['file_name'];
            $this->load->library('image_lib',$config);
            $this->image_lib->resize();
            //imstert image

            $this->load->model('Main_Model');
            
            $image_data = array(
                'image' => $data['file_name']

            );
            $this->Main_Model->insert_image($image_data);
  echo $this->Main_Model->fetch_image();

            // echo '<img src="'.base_url().'upload/'.$data['file_name'].'" />';
        }
    }
}

//check if email exists 

public function email_availability(){
    $data['title'] = "Check if Email Exists";
    $this->load->view('email_availability', $data);
}

public function check_email_availability(){
    if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
        echo '<label class="text-danger"> <span class="glyphicon glyphicon-remove"> Email is not valid </span> </label>';
    } else {
        $this->load->model('Main_Model');

        if($this->Main_Model->is_email_available($_POST['email'])){
            echo '<label class="text-danger"> <span class="glyphicon glyphicon-remove"> Email already exists </span> </label>';
        } else {
            echo '<label class="text-success"> <span class="glyphicon glyphicon-ok"> Email is available </span> </label>';
        }
    }
}


}
?>