<?php
	$data['title'] = "Edit Product";
	$this->load->view('includes/header',$data);
?>

<div class="container">
	<div class="row">
		<div class="col-md-4 col-md-offset-4">
			<div class="form-cover2">
				<h3>EDIT PRODUCT</h3>
				<form action="" method="post" enctype="multipart/form-data">
					<div class="form-group">
					    <label for="name">Name</label>
					    <input type="text" name="name" value="<?= $product[0]['name'] ?>" class="form-control" id="name">
				  	</div>				  
				  	<div class="form-group">
				  		<label>Category</label>
				  		<input type="text" name="category" value="<?= $product[0]['category'] ?>" class="form-control">
				  	</div>		 
				  	<div class="form-group">
				  		<label>Price</label>
				  		<input type="number" name="price" value="<?= $product[0]['price'] ?>" class="form-control">
				  	</div>
				  	<div class="form-group">
				  		<label>Image <small>(leave blank if you don't want to change image)</small></label>
				  		<input type="file" name="file" class="form-control">
				  	</div>
				  	<input type="hidden" name="id" value="<?= $product[0]['id'] ?>">
				  	<button type="submit" class="btn btn-primary btn-block">Update Product</button>
				</form>
			</div>
		</div>
	</div>
</div>


<?php
	$this->load->view('includes/footer');
?>