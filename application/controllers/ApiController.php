<?php
	
	class ApiController extends CI_Controller
	{
		
		private $secret_key = '';
		public function __construct()
		{
			parent::__construct();
			$this->load->model('DatabaseModel');

			$this->secret_key = 'key-bziseiwn32nb83nwd';
		}


		/**
		* Endpoint For fetch products
		*/
		public function fetchProducts()
		{
			if($this->input->server('REQUEST_METHOD')=='POST'){

				$secret_key = $this->input->post('secret_key');
				if(!empty($secret_key)){

					if($this->secret_key == $secret_key){

						$products = $this->DatabaseModel->getData('products',array('status'=>1));
						if(!empty($products)){

							$tmp_arr = array();
							foreach ($products as $value) {
								$a['id'] = $value['id'];
								$a['name'] = $value['name'];
								$a['category'] = $value['category'];
								$a['image'] = base_url().$value['image'];
								$a['price'] = $value['price'];
								$a['created'] = $value['created'];

								$tmp_arr[] = $a;
							}

							$data['status'] = true;
							$data['message'] = 'Data Found Successfully!';
							$data['data'] = $tmp_arr;

						}else{
							$data['status'] = false;
							$data['message'] = 'Oops.. No records Available';
						}

					}else{
						$data['status'] = false;
						$data['message'] = 'Oops.. Invalid Secret Key';
					}

				}else{
					$data['status'] = false;
					$data['message'] = 'Oops.. Missing Required Paramerters';
				}

			}else{
				$data['status'] = false;
				$data['message'] = 'Invalid Request Method';
			}

			echo json_encode($data);
			die();
		}


		/**
		* Endpoint for Add Products
		*/
		public function addProduct()
		{
			if($this->input->server('REQUEST_METHOD')=='POST'){

				$user_id = $this->input->post('user_id');
				$name = $this->input->post('name');
				$price = $this->input->post('price');
				$category = $this->input->post('category');
				$secret_key = $this->input->post('secret_key');
				
				if(!empty($name) and !empty($price) and !empty($category) and !empty($_FILES['file']['name']) and !empty($user_id) and !empty($secret_key)){	

					/** Check Secret Keys */
					if($this->secret_key != $secret_key){
						$data['status'] = false;
	               		$data['message'] = 'Oops.. Invalid Secret Key';

	               		echo json_encode($data); die();
					}

					/** Check If Input User Exists or not */
					if(!$this->DatabaseModel->exists('users',array('id'=>$user_id))){
						$data['status'] = false;
	               		$data['message'] = 'Oops.. Invalid User ID :'.$user_id.' For Test Enter User ID :10';

	               		echo json_encode($data); die();
					}

					/** Upload Product Image */
					$explode = explode('.', $_FILES['file']['name']);
	                $ext = end($explode);
	                $tmp_name = $_FILES['file']['tmp_name'];
	                $path = 'uploads/product/'.$user_id.'/';
	                $file_name = time().'.'.$ext;

	                /** Check File extension */
	                if($ext != 'png' && $ext !='jpg' && $ext!='jpeg')
	               {
	               		$data['status'] = false;
	               		$data['message'] = 'Oops.. File type not allwoed (jpg,png,jpeg)';

	               		echo json_encode($data); die();
	                }

	                /** Create dir if not created */
	                if(!is_dir($path))
	                {
	                    mkdir($path,0777,true);
	                }

	                /** Upload file */                
	                if(!move_uploaded_file($tmp_name, $path.$file_name))
	                {
	                	$data['status'] = false;
	               		$data['message'] = 'Oops.. File not uploaded, Please try again';

	               		echo json_encode($data); die();
	                }
	                

					$data_arr = array(
						'user_id' => $user_id,
						'name' => $name,
						'image' => $path.$file_name,
						'category' => $category,
						'price' => $price
					);

					if($this->DatabaseModel->saveData('products',$data_arr)){
						
						$data['status'] = true;
						$data['message'] = 'Product Added Successfully!';

						/** Return All Products */
						$products = $this->DatabaseModel->getData('products',array('status'=>1));

						$tmp_arr = array();
						foreach ($products as $value) {
							$a['id'] = $value['id'];
							$a['name'] = $value['name'];
							$a['category'] = $value['category'];
							$a['image'] = base_url().$value['image'];
							$a['price'] = $value['price'];
							$a['created'] = $value['created'];

							$tmp_arr[] = $a;
						}

						$data['data'] = $tmp_arr;

					}else{

						$data['status'] = false;
						$data['message'] = 'Something went wrong, Please try again';
					}


				}else{
					$data['status'] = false;
					$data['message'] = 'Missing Required Parameters';
				}

			}else{
				$data['status'] = false;
				$data['message'] = 'Invalid Request Method';
			}

			echo json_encode($data);
			die();
		}


		/**
		* Endpoint for update Products 
		*/
		public function updateProduct()
		{
			if($this->input->server('REQUEST_METHOD')=='POST'){

				$id = $this->input->post('id');
				$user_id = $this->input->post('user_id');
				$name = $this->input->post('name');
				$price = $this->input->post('price');
				$category = $this->input->post('category');
				$secret_key = $this->input->post('secret_key');
				
				if(!empty($name) and !empty($price) and !empty($category) and !empty($price)
					and !empty($id) and !empty($user_id)){

					/** Check Secret Key */
					if($this->secret_key != $secret_key){
						$data['status'] = false;
						$data['message'] = 'Invalid Secret Key';

						echo json_encode($data); die();
					}

					$products = $this->DatabaseModel->getData('products',array('id'=>$id));

					$data_arr = array(
						'user_id' => $user_id,
						'name' => $name,				
						'category' => $category,
						'price' => $price
					);

					/** Upload image if user updated image */
					if(!empty($_FILES['file']['name'])){

						$explode = explode('.', $_FILES['file']['name']);
		                $ext = end($explode);
		                $tmp_name = $_FILES['file']['tmp_name'];
		                $path = 'uploads/product/'.$user_id.'/';
		                $file_name = time().'.'.$ext;

		                /** Check File extension */
		                if($ext != 'png' && $ext !='jpg' && $ext!='jpeg')
		               {		                   
							$data['status'] = false;
							$data['message'] = 'Oops.. File type not allwoed (jpg,png,jpeg)';
		                }

		                /** Create dir if not created */
		                if(!is_dir($path))
		                {
		                    mkdir($path,0777,true);
		                }

		                /** Upload file */	                
		                if(move_uploaded_file($tmp_name, $path.$file_name))
		                {
		                	$data_arr['image'] = $path.$file_name;
		                	if(file_exists($products[0]['image']))
		                    {
		                        unlink($products[0]['image']);
		                    }	                          
		                }
		                else{		                	
							$data['status'] = false;
							$data['message'] = 'Oops.. File not uploaded, Please try again';
		                }
					}
				
					if($this->DatabaseModel->update('products',$data_arr,'id',$id)){
						
						$data['status'] = true;
						$data['message'] = 'Product Updated Successfully!';

						/** Return All Products */
						$products = $this->DatabaseModel->getData('products',array('status'=>1));

						$tmp_arr = array();
						foreach ($products as $value) {
							$a['id'] = $value['id'];
							$a['name'] = $value['name'];
							$a['category'] = $value['category'];
							$a['image'] = base_url().$value['image'];
							$a['price'] = $value['price'];
							$a['created'] = $value['created'];

							$tmp_arr[] = $a;
						}

						$data['data'] = $tmp_arr;	

					}else{						
						$data['status'] = false;
						$data['message'] = 'Something went wrong, Please try again';
					}

				}else{
					$data['status'] = false;
					$data['message'] = 'Missing Required Parameters';
				}

			}else{
				$data['status'] = false;
				$data['message'] = 'Invalid Request Method';
			}

			echo json_encode($data);
			die();

		}


	}

?>