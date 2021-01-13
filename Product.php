<?php
class Product{
	private $host  = 'localhost';
    private $user  = 'root';
    private $password   = "";
    private $database  = "product_mobile";
	private $productTable = 'products';    
	private $dbConnect = false;
    public function __construct(){
        if(!$this->dbConnect){ 
            $conn = new mysqli($this->host, $this->user, $this->password, $this->database);
            if($conn->connect_error){
                die("Error failed to connect to MySQL: " . $conn->connect_error);
            }else{				
                $this->dbConnect = $conn;
            }
        }
    }
	private function getData($sqlQuery) {
		$result = mysqli_query($this->dbConnect, $sqlQuery);		
		if(!$result){
			die('Error in query: '. mysqli_error());
		}
		$data= array();
		while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
			$data[]=$row;            
		}
		return $data;
	}
	private function getNumRows($sqlQuery) {
		$result = mysqli_query($this->dbConnect, $sqlQuery);
		if(!$result){
			die('Error in query: '. mysqli_error());
		}
		$numRows = mysqli_num_rows($result);
		return $numRows;
	}	
	public function cleanString($str){
		
		return str_replace(' ','_',$str);
	}
	public function getCategories() {		
		$sqlQuery = "
			SELECT category_id, category_name
			FROM ".$this->productTable." 
			GROUP BY category_name";
        return  $this->getData($sqlQuery);
	}
	public function getBrand () {
		$sql = '';
		if(isset($_POST['category']) && $_POST['category']!="") {
			$category = $_POST['category'];
			$sql.=" WHERE category_id =".$category ;
		}
		$sqlQuery = "
			SELECT distinct brand
			FROM ".$this->productTable." 
			$sql GROUP BY brand";
			
       return  $this->getData($sqlQuery);
	}


	public function getTotalProducts () {
		$sql= "SELECT distinct id FROM ".$this->productTable."  WHERE qty != 0";
		if(isset($_POST['category']) && $_POST['category']!="") {
			$category = $_POST['category'];
			$sql.=" AND category_id IN ('".implode("','",$category)."')";
		}
		if(isset($_POST['brand']) && $_POST['brand']!="") {
			$brand = $_POST['brand'];
			$sql.=" AND brand IN ('".implode("','",$brand)."')";
		}
			
		$productPerPage = 9;		
		$rowCount = $this->getNumRows($sql);
		$totalData = ceil($rowCount / $productPerPage);
		return $totalData;
	}		
	
	public function getProducts() {
		
		$sql= "SELECT * FROM ".$this->productTable." WHERE qty != 0";	
		
		if(isset($_POST['category']) && $_POST['category']!=""){			
			$sql.=" AND category_id  =".$_POST['category'] ;
		}

		if(isset($_POST['brand']) && $_POST['brand']!=""){			
			$sql.=" AND brand  ='".$_POST['brand']."'" ;
		}
		
		$sql.=" ORDER BY id DESC";			
			
		$products = $this->getData($sql);
		$rowcount = $this->getNumRows($sql);
		$productHTML = '';

		if(isset($products) && count($products)) {			
            foreach ($products as $key => $product) {				
                $productHTML .= '<article class="col-md-4 col-sm-6">';
                $productHTML .= '<div class="thumbnail product">';
                $productHTML .= '<figure>';
                $productHTML .= '<a href="#"><img src="images/'.$product['image'].'" alt="'.$product['product_name'].'" /></a>';
                $productHTML .= '</figure>';
                $productHTML .= '<div class="caption">';
                $productHTML .= '<a href="" class="product-name">'.$product['product_name'].'</a>';
                $productHTML .= '<div class="price">$'.$product['price'].'</div>';
                $productHTML .= '<h6>Brand : '.$product['brand'].'</h6>';                             
                $productHTML .= '</div>';
                $productHTML .= '</div>';
                $productHTML .= '</article>';				
			}
		}
		return 	$productHTML;	
	}	
}
?>