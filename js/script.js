$(document).ready(function() {

	firstProductListView();
	//Category Change
	$( "select[name='category']" ).change(function () {
		CategoryChange();
	});

	function CategoryChange(){
		var category = $("#category").val();
		if(category) {
			$.ajax({
				type: 'POST',
				url: "CallPage.php",
				dataType: 'Json',
				data: {'category':category},
				success: function(data) {
					$("#results").html('');									
					$('select[name="brand"]').empty();					
					if(data.brand.length>0){	
						$('select[name="brand"]').append('<option value="0">Select Brand</option>');								   
						$.each(data.brand, function(key, value) {							
							$('select[name="brand"]').append('<option value="'+ value.brand +'">'+ value.brand +'</option>');
						});
					}else{					   
						$('select[name="brand"]').append('<option value="0">Select Brand</option>');
					}
					if(data.Productresult==''){
						firstProductListView();
					}
					$("#results").append(data.Productresult);
					
				}
			});
		}else{
			$('select[name="brand"]').empty();
		}
	}
	//end ccategory change

	//Brand Chnage
	$( "select[name='brand']" ).change(function () {

		var brand = $(this).val();
		var catID=$("#category").val();
		if(brand===0){
			brand='';
		}		
		if(brand) {
			$.ajax({
				type: 'POST',
				url: "CallPage.php",
				dataType: 'Json',
				data: {'brand':brand,'category':catID},
				success: function(data) {
					$("#results").html('');
					if(data.Productresult==''){
						CategoryChange();
					}
					$("#results").append(data.Productresult);
					
				}
			});
		}else{
			$('select[name="brand"]').empty();
		}
	});
	//end brand chnage
});

function firstProductListView(){

	$.ajax({
		type: 'POST',
		url : "load_products.php",
		dataType: "json",			
		
		success: function (data) {
			$("#results").append(data.products);
			
		}
	});
}




