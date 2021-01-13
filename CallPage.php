<?php
require_once 'Product.php';
if(isset( $_POST['category'] ) && !isset( $_POST['brand'] )) {
     
     $myBrand = new Product();
     $brand = $myBrand->getBrand(); 
     $Productresult = $myBrand->getProducts();    
     $response = array(
          "brand" => $brand,
          'Productresult'  => $Productresult
      ); 
     echo json_encode($response); 
}
if(isset( $_POST['brand'] )) {
     
     $myProducts = new Product();      
     $Productresult = $myProducts->getProducts();    
     $response = array(         
          'Productresult'  => $Productresult
      ); 
     echo json_encode($response); 
}