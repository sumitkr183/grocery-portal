<?php

/**
 * 
 */
class DashboardController extends CI_Controller
{
	
	public function __construct()
	{
		parent::__construct();
		$this->load->model('DatabaseModel');

		/** Check if user already logged in */
		$this->_auth();
	}


	public function index()
	{
		$data['products'] = $this->DatabaseModel->getData('products',array('status'=>1));

		$this->load->view('dashboard/dashboard',$data);
	}

	public function addProduct()
	{
		if($this->input->server('REQUEST_METHOD')=='POST'){

			$name = $this->input->post('name');
			$price = $this->input->post('price');
			$category = $this->input->post('category');
			$image = $_FILES['file']['name'];
		
			if(!empty($name) and !empty($price) and !empty($category) and !empty($image)){		

				$user_id = $this->session->userdata('user_id');

				/** Upload Product Image */
				$explode = explode('.', $image);
                $ext = end($explode);
                $tmp_name = $_FILES['file']['tmp_name'];
                $path = 'uploads/product/'.$user_id.'/';
                $file_name = time().'.'.$ext;

                /** Check File extension */
                if($ext != 'png' && $ext !='jpg' && $ext!='jpeg')
               {
                    $this->session->set_flashdata('error','Oops.. File type not allwoed (jpg,png,jpeg)');
					redirect($_SERVER['HTTP_REFERER']);
                }

                /** Create dir if not created */
                if(!is_dir($path))
                {
                    mkdir($path,0777,true);
                }

                /** Upload file */                
                if(!move_uploaded_file($tmp_name, $path.$file_name))
                {
                    $this->session->set_flashdata('error','Oops.. File not uploaded, Please try again');
					redirect($_SERVER['HTTP_REFERER']);                
                }
                

				$data_arr = array(
					'user_id' => $user_id,
					'name' => $name,
					'image' => $path.$file_name,
					'category' => $category,
					'price' => $price
				);

				if($this->DatabaseModel->saveData('products',$data_arr)){
					$this->session->set_flashdata('success','Product added successfully!');
					redirect('dashboard');
				}else{
					$this->session->set_flashdata('error','Something went wrong, Please try again');
					redirect($_SERVER['HTTP_REFERER']);
				}


			}else{
				$this->session->set_flashdata('error','Oops.. Missing required parameters');
				redirect($_SERVER['HTTP_REFERER']);
			}

		}else{		
			$this->load->view('dashboard/add_product');
		}
	}


	public function editProduct($id)
	{
		if($this->input->server('REQUEST_METHOD')=='POST'){

			$id = $this->input->post('id');
			$name = $this->input->post('name');
			$price = $this->input->post('price');
			$category = $this->input->post('category');
			
			if(!empty($name) and !empty($price) and !empty($category) and !empty($price)){

				$user_id = $this->session->userdata('user_id');
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
	                    $this->session->set_flashdata('error','Oops.. File type not allwoed (jpg,png,jpeg)');
						redirect($_SERVER['HTTP_REFERER']);
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
	                	$this->session->set_flashdata('error','Oops.. File not uploaded, Please try again');
						redirect($_SERVER['HTTP_REFERER']);
	                }
				}
			
				if($this->DatabaseModel->update('products',$data_arr,'id',$id)){
					$this->session->set_flashdata('success','Products updated successfully!');
					redirect('dashboard');
				}else{
					$this->session->set_flashdata('error','Something went wrong, Please try again');
					redirect($_SERVER['HTTP_REFERER']);
				}


			}else{
				$this->session->set_flashdata('error','Oops.. Missing required parameters');
				redirect($_SERVER['HTTP_REFERER']);
			}

		}else{
			$data['product'] = $this->DatabaseModel->getData('products',array('id'=>$id));
			
			$this->load->view('dashboard/edit_product',$data);
		}
	}


	public function deleteProduct($id)
	{
		if($this->DatabaseModel->delete('products',array('id'=>$id))){
			$this->session->set_flashdata('success','Product deleted successfully!');
			redirect('dashboard');
		}else{
			$this->session->set_flashdata('error','Something went wrong, Please try again');
			redirect($_SERVER['HTTP_REFERER']);
		}
	}


	private function _auth()
    {
        $user_id = $this->session->userdata('user_id');

        if(empty($user_id))
        {
        	$this->session->set_flashdata('error','For access this location, Please login first');
            redirect('login');
        }
        return true;
    }



}

?>