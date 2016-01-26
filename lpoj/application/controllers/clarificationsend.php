<?php

class ClarificationSend extends CI_Controller {

	function index()
	{
		$ceksess = $this->Usermodel->checkSession() && $this->Usermodel->checkContestSession();
		
		if ($ceksess == FALSE){
			redirect(site_url().'/home');
		}
		else{
			$ctitle = $this->input->post('ctitle');
			$ccontent = $this->input->post('ccontent');			
			$participantid = $this->session->userdata('participantid');
			
			$this->Clarificationmodel->saveToDb($participantid, $ctitle, $ccontent);
			$this->session->set_flashdata(array('clarificationok' => 'Clarification Sent'));
			redirect(site_url().'/clarification');
		}
	}
}

?>