<?php

class Publicrank extends CI_Controller {

	function contest($id=null)
	{
		$id = $this->db->escape($id);
		$data = array ('id' => $id);
		$this->load->view('freeze_view', $data);
	}
} 
