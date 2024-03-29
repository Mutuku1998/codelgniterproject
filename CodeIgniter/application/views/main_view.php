<!DOCTYPE html>
<html lang="en">
<head>
  <title>Bootstrap Example</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
<body>

<div class="container">
  <h1 Class="text-danger">INSERTING DATA  INTO DB</h1>
  <form action="<?php echo base_url()?>main/form_validation" autocomplete="off" method ="post">
<?php

if($this->uri->segment(2) == 'inserted'){


    echo '<p class="text-success"> Data inserted successfully </p>';
}
?>
  <div class="form-group">
    <label for="name">Email address:</label>
    <input type="email" name="email" class="form-control" id="email">
    <span class="text-danger"> <?php echo form_error('email');?></span> 
  </div>
  <div class="form-group">
    <label for="name">User name:</label>
    <input type="text" name="name" class="form-control" id="name" />
  </div>
  <div class="form-group">
    <label for="pwd">Password:</label>
    <input type="password" name="password" class="form-control" id="pwd"/>
  </div>
  <div class="checkbox">
    <label><input type="checkbox"> Remember me</label>
  </div>
  <button type="submit" name="insert" class="btn btn-default">Submit</button>
</form>
<div>
    <h2>Fetching data</h2>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>SN</th>
                <th>Email</th>
                <th>Password</th>
                <th>Name</th>
                <th>delete</th>
                <th>update</th>
            </tr>
        </thead>
        <tbody>

            <?php
            if ($fetch_data->num_rows() > 0) {

                foreach ($fetch_data->result() as $row) {
            ?>
                    <tr>
                        <td> <?php echo $row->id; ?> </td>
                        <td> <?php echo $row->email; ?> </td>
                        <td> <?php echo $row->password; ?> </td>
                        <td> <?php echo $row->name; ?> </td>
                        <td><a href="#" class="delete_data btn-danger btn" id ="<?php echo $row->id ?>"> delete </a> </td>
                        <td><a href="<?php echo base_url();?>main/update_data/<?php echo $row->id ?>" class="btn btn-primary">Edit</a> </td>
                    </tr>
            <?php
                }
            } else {
            ?>
                <tr>
                    <td colspan="4">
                        No data found
                    </td>
                </tr>
            <?php
            }
            ?>

        </tbody>
    </table>
</div>

</div>
<script>
$(document).ready(function(){
  $(".delete_data").click(function(e){
    e.preventDefault();
    var id = $(this).attr("id"); // Use attr("data-id") instead of data("id")
    console.log("Clicked ID:", id);
    
    if(confirm("Are you sure you want to delete this?")){
      window.location = "<?php echo base_url(); ?>main/delete_data/"+id;
    } else {
      console.log("Deletion canceled");
      return false;
    }
  });
});


 </script>

</body>
</html