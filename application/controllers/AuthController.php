<?php


/**
 * 
 */
class AuthController extends CI_Controller
{
	
	public function __construct()
	{
		parent::__construct();		
		$this->load->model('DatabaseModel');
	}

	public function index()
	{
		$user_id = $this->session->userdata('user_id');
        if(!empty($user_id))
        {
            redirect('dashboard');
        }

		if($this->input->server('REQUEST_METHOD')=='POST'){

			$email = $this->input->post('email');
			$password = $this->input->post('password');

			if(!empty($email) and !empty($password)){

				/** check if email exists */
				if($this->DatabaseModel->exists('users',array('email'=>$email))){

					/** check if email already verified */
					if($this->DatabaseModel->exists('users',array('email'=>$email,'status'=>0))){
						$this->session->set_flashdata('error','Oops.. Your email is not verified');
						redirect($_SERVER['HTTP_REFERER']);
					}

					/** Login User */
					if($user_id = $this->DatabaseModel->validateLogin($email,$password)){

						/** Set user session */	
						$this->session->set_userdata('user_id',$user_id);

						$this->session->set_flashdata('success','You have logged in Successfully!');
						redirect('dashboard');
						
					}else{
						$this->session->set_flashdata('error','Oops.. You have entered wrong email or password');
						redirect($_SERVER['HTTP_REFERER']);
					}

				}else{
					$this->session->set_flashdata('error','Oops.. Email address not exists');
					redirect($_SERVER['HTTP_REFERER']);
				}

			}else{
				$this->session->set_flashdata('error','Oops.. Missing required parameter');
				redirect($_SERVER['HTTP_REFERER']);
			}

		}else{
			$this->load->view('login');
		}

	}


	public function logout()
	{
		$this->session->sess_destroy();
		redirect('login');
	}



}

?>