<?php

class Session extends CI_Controller {
	
	function index()
	{
		$username = $this->input->post('username');
		$password = $this->input->post('password');
		
		$this->Usermodel->checkPassword($username,$password);
		
	}
	
	function contest()
	{
		$username = $this->input->post('username');
		$password = $this->input->post('password');
		
		$this->Contestmodel->checkContestPassword($username,$password);
	}
	function manager()
	{
		$username = $this->input->post('username');
		$password = $this->input->post('password');
		
		if($username=="admin"&&$password=="llp")
		{
			//$this->load->library("session");
			$this->session->set_userdata("admin",TRUE);
			//echo $this->session->userdata("admin");
			//echo "pp";
			redirect("manager");
		}
		else
		{
			redirect(base_url());
		}
	}
}

?>
