<?php
	$data['title'] = "Add Product";
	$this->load->view('includes/header',$data);
?>

<div class="container">
	<div class="row">
		<div class="col-md-4 col-md-offset-4">
			<div class="form-cover2">
				<h3>ADD PRODUCT</h3>
				<form action="" method="post" enctype="multipart/form-data">
					<div class="form-group">
					    <label for="name">Name</label>
					    <input type="text" name="name" class="form-control" id="name">
				  	</div>				  
				  	<div class="form-group">
				  		<label>Category</label>
				  		<input type="text" name="category" class="form-control">
				  	</div>		 
				  	<div class="form-group">
				  		<label>Price</label>
				  		<input type="number" name="price" class="form-control">
				  	</div>
				  	<div class="form-group">
				  		<label>Image</label>
				  		<input type="file" name="file" class="form-control">
				  	</div>
				  	<button type="submit" class="btn btn-primary btn-block">Add Product</button>
				</form>
			</div>
		</div>
	</div>
</div>


<?php
	$this->load->view('includes/footer');
?>