<?php

@include 'db.php';

$id = $_GET['edit'];

if(isset($_POST['update_product'])){

   $product_title = $_POST['product_title'];
   $product_price = $_POST['product_price'];
   $product_desc = $_POST['product_desc'];
   $product_keywords = $_POST['product_keywords'];
   $product_image = $_FILES['product_image']['product_title'];
   $product_image_tmp_name = $_FILES['product_image']['tmp_name'];
   $product_image_folder = 'product_images/'.$product_image;


   if(empty($product_title) || empty($product_price) || empty($product_desc) || empty($product_keywords) || empty($product_image)){
      $message[] = 'please fill out all!';    
   }else{

      $update_data = "UPDATE products SET product_title='$product_title', product_price='$product_price',product_desc='$product_desc' ,product_keywords='$product_keywords',product_image='$product_image'  WHERE product_id = '$id'";
      $upload = mysqli_query($con, $update_data);

      if($upload){
         move_uploaded_file($product_image_tmp_name, $product_image_folder);
         header('location:admin_page.php');
      }else{
         $$message[] = 'please fill out all!'; 
      }

   }
};

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <link rel="stylesheet" href="css.css">
</head>
<body>

<?php
   if(isset($message)){
      foreach($message as $message){
         echo '<span class="message">'.$message.'</span>';
      }
   }
?>

<div class="container">


<div class="admin-product-form-container centered">

   <?php
      
      $select = mysqli_query($con, "SELECT * FROM products WHERE product_id = '$id'");
      while($row = mysqli_fetch_assoc($select)){

   ?>
   
   <form action="" method="post" enctype="multipart/form-data">
      <h3 class="title">update the product</h3>
      <input type="text" class="box" name="product_title" value="<?php echo $row['product_title']; ?>" placeholder="enter the product title">
      
      <input type="number" min="0" class="box" name="product_price" value="<?php echo $row['product_price']; ?>" placeholder="enter the product price">
      
      <input type="text" name="product_desc" class="box" value="<?php echo $row['product_desc']; ?>" placeholder="enter product description">

      <input type="file" class="box" name="product_image"  accept="image/png, image/jpeg, image/jpg">
      
      <input type="text" name="product_keywords" class="box" value="<?php echo $row['product_keywords']; ?>" placeholder="enter product keywords">

      <input type="submit" value="update product" name="update_product" class="btn">
      <a href="admin_page.php" class="btn">go back!</a>
   </form>
   



   <?php }; ?>

   

</div>

</div>
<a href="logout.php" class="btn" >Logout</a>
</body>
</html>