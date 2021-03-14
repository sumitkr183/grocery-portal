<?php
	$data['title'] = "Dashboard";
	$this->load->view('includes/header',$data);
?>

    <div class="container">
        <div class="row">

        	<div class="col-md-12">
        		<div class="add-header">
        			<a href="<?= base_url() ?>add-product" class="btn btn-primary"><i class="glyphicon glyphicon-plus"></i> Add Product</a>
        		
                    <div class="text-right"> 
                        <a href="<?= base_url() ?>logout" class="btn btn-danger">Logout</a>
                    </div>
        		</div>
        	</div>
                       
            <div class="col-md-12">
                <div class="table-responsive" style="margin-top: 5rem;">
                    <table class="table table-striped" id="myTable">
                        <thead>
                            <tr>
                                <th>S No.</th>
                                <th>Name</th>
                                <th>Image</th>
                                <th>Category</th>
                                <th>Price</th>
                                <th>Added by</th>
                                <th>Created</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($products as $product) : ?>
                            	<tr>
                            		<td><?= $product['id'] ?></td>
                            		<td><?= $product['name'] ?></td>
                                    <td>
                                        <img src="<?= base_url().$product['image'] ?>" width="40px">
                                    </td>
                                    <td><?= $product['category'] ?></td>
                            		<td><?= $product['price'] ?></td>
                            		<td>
                                        <?= $this->DatabaseModel->getField('email','users',$product['user_id']) ?>
                                    </td>
                            		<td><?= $product['created'] ?></td>
                            		<td>
                            			<a href="<?= base_url() ?>edit-product/<?= $product['id'] ?>" class="btn btn-primary" title="Edit">
                            				<span class="glyphicon glyphicon-pencil"></span>
                            			</a>
                            			<a href="<?= base_url() ?>delete-product/<?= $product['id'] ?>" onclick="return confirm('Are you sure you want to delete this product?');" class="btn btn-danger" title="Delete">
                            				<span class="glyphicon glyphicon-trash"></span>
                            			</a>
                            		</td>
                            	</tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>

<?php
	$this->load->view('includes/footer');
?>
