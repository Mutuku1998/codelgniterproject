<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Csv_import extends CI_Controller {
 
 public function __construct()
 {
  parent::__construct();
  $this->load->model('CSVmodel');
//   $this->load->library('csvimport');

 }

  public function importdata()
 {
  $this->load->view('csvdata');
 }

  public function load_data()
 {
  $result = $this->CSVmodel->select();
  $output = '
   <h3 align="center">Imported User Details from CSV File</h3>
        <div class="table-responsive">
         <table class="table table-bordered table-striped">
          <tr>
           <th>Sr. No</th>
           <th>email</th>
           <th>name</th>
           <th>password</th>
          </tr>
  ';
  $count = 0;
  if($result->num_rows() > 0)
  {
   foreach($result->result() as $row)
   {
    $count = $count + 1;
    $output .= '
    <tr>
     <td>'.$count.'</td>
     <td>'.$row->email.'</td>
     <td>'.$row->name.'</td>
     <td>'.$row->password.'</td>
    </tr>
    ';
   }
  }
  else
  {
   $output .= '
   <tr>
       <td colspan="5" align="center">Data not Available</td>
      </tr>
   ';
  }
  $output .= '</table></div>';
  echo $output;
 }

public function import()
 {
  $file_data = $this->csvimport->get_array($_FILES["csv_file"]["tmp_name"]);
  foreach($file_data as $row)
  {
   $data[] = array(
    'email' => $row["email"],
          'name'  => $row["name"],
          'password'   => $row["password"],
        
   );
  }
  $this->CSVmodel->insert($data);
 }
 
  
}
