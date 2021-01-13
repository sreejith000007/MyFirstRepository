<?php 
include("Product.php");
$product = new Product();
$categories = $product->getCategories();

//$totalRecords = $product->getTotalProducts();
include('inc/header.php');
?>
<title>Demo Product Search Filtering</title>
<link rel="stylesheet" type='text/css' href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/fontawesome.min.css">
<link rel="stylesheet" type='text/css' href="css/style.css">       
<?php include('inc/container.php');?>
<div class="content"> 
	<div class="container-fluid">				
            <form method="post" id="search_form">               
                <div class="row">                    
                    <aside class="col-lg-3 col-md-4">						
						<div class="panel list">
                            <div class="panel-heading"><h3 class="panel-title" data-toggle="collapse" data-target="#panelOne" aria-expanded="true">Categories</h3></div>
                            <div class="panel-body collapse in" id="panelOne">
                            <select name="category" id="category" class='form-control'>
                            <option value="0">Select Category</option>
                            <?php 
                            foreach ($categories as $key => $category){
                            ?>
                                    <option value="<?php echo $category["category_id"];?>"><?php echo $category["category_name"];?></option>
                            <?php
                            }
                            ?>
                            </select>
                               
                            </div>
                        </div>
                        <div class="panel list">
                            <div class="panel-heading"><h3 class="panel-title" data-toggle="collapse" data-target="#panelOne" aria-expanded="true">Brand</h3></div>
                            <div class="panel-body collapse in" id="panelOne">
                            <select name="brand" id='brand' class="form-control" style="width:350px">
                            <option value="0">Select Brand</option>
                            </select>
                            </div>
                        </div>
                    </aside>
                    <section class="col-lg-9 col-md-8">
                        <div class="row">
                            <div id="results"></div>
                        </div>
                    </section>
                </div>
				<input type="hidden" id="totalRecords" value="<?php echo $totalRecords; ?>">
            </form>
        </div>        
    </div>        
<script src="js/script.js"></script>

<?php include('inc/footer.php');?>


