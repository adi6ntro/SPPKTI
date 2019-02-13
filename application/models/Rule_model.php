<?php
Class Rule_model extends CI_Model
{
  function get_atribut_linked($id = '') {
		$gejala = array();
		if (trim($id) != '') {
			$gej = $this->db->select('A.*')->from('skkni_unit A')
				->join('relasi B', 'A.id_unit = B.id_unit AND B.id_skema = "'.$id.'"')->get();
			$atribut = $gej->result_array();
		}
		foreach ($atribut as $value) {
			printf("<li data-id='%s' draggable='true' >%s</li>\n", $value['id_unit'], $value['id_unit'].' - '.$value['nama_unit']);
		}
	}

	function get_atribut_not_linked($id = '') {
		$gejala = array();
		if (trim($id) != '') {
			$sql = "SELECT * FROM skkni_unit WHERE id_unit NOT IN (SELECT id_unit FROM relasi WHERE id_skema = ?)";
			$gej = $this->db->query($sql, array($id));
			$atribut = $gej->result_array();
		}
		foreach ($atribut as $value) {
			printf("<li data-id='%s'  draggable='true'>%s</li>\n", $value['id_unit'], $value['id_unit'].' - '.$value['nama_unit']);
		}

	}
}
