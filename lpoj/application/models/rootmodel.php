<?php

class Rootmodel extends CI_Model {
    
    function getValue($root_item)
	{
		$q = "SELECT root_value FROM pc_root WHERE root_item=".$this->db->escape($root_item);
		$qr = $this->db->query($q);
		
		if ($qr->num_rows() > 0){
			$result = $qr->first_row();
			return $result->root_value;
		}
	}

}

?>