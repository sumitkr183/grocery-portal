<?php
	$data['title'] = "Login";
	$this->load->view('includes/header',$data);
?>

<div class="container">
	<div class="row">
		<div class="col-md-4 col-md-offset-4">
			<div class="form-cover">
				<h3>SIGN IN</h3>
				<form action="" method="post">
				  <div class="form-group">
				    <label for="email">Email Address:</label>
				    <input type="email" class="form-control" name="email" id="email">
				  </div>
				  <div class="form-group">
				    <label for="pwd">Password:</label>
				    <input type="password" class="form-control" name="password" id="pwd">
				  </div>			 
				  <button type="submit" class="btn btn-primary btn-block">Sign In</button>
				  
				</form>
			</div>
		</div>
	</div>
</div>


<?php
	$this->load->view('includes/footer');
?>