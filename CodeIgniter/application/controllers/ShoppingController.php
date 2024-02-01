
<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class ShoppingController extends CI_Controller {

    public function shoppingCart (){

        $this->load->model('CartModel');
        $data['product'] = $this->CartModel->fetch_all();

        $this->load->view('cart',$data);
    }

    public function cart (){

        $this->load->library('cart');
        $data = array(
            "id"  => $_POST['product_id'],
            "name" =>$_POST['product_name'],
            "qty" =>$_POST['quantity'],
            'price' =>$_POST['product_price']
        );
        $this->cart->insert();

        echo $this->view();
    }


    public  function load(){

        echo $this->view();
    }

    
    public function view(){
        $output = '';
        $output .='
<h3> shopping cart </h3> <br/>
<div class= "table-responsive">
<div align="right">

<button type = "button" id="clear_clear" class="btn btn-warning">
Clear cart
 </button>
</div>
<br/>
<table class="table table-bordered">
<tr>
<th>Name </th>
<th> Quantity </th>
<th> Price </th>
<th> Total </th>
<th> Action </th>
</tr>

        '
        ;
        $count = 0;
        foreach($this->cart->contents() as $items)
        {
            $count ++;
            $output .='
            <tr>
<td>'.$items['name'].'</td>
<td>'.$items['qty'].'</td>
<td>'.$items['price'].'</td>
<td>'.$items['subtotal'].'</td>
<td> <button type ="button" name = "remove" class = "btn btn-danger btn-xs remove_inventory" id ="'.$items["rowid"].'">Remove </button> </td>
            </tr>
            
            '
            ;
        }
        $output .= '
        <tr>
 <td colspan = "4" align ="right">Total </td>
 <td> '.$this->cart->total().' </td>
        </tr>
        </table>
</div>

        '
        ;

        if($count == 0){

            $output = '<h3 class="text-center">  Cart is empty</h3>'  ;
          }
          return $output;
    }
  
}
    


?>