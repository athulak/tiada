<?php
class M_roundtable_setting extends CI_Model{
    public function __construct() {
        parent::__construct();
    }
     function get_roundtable_setting() {
        $query = $this->db->get_where('roundtable_setting');
        return $query->row();
    }
    function update_roundtable_setting($roundtable) {
        $data = array(
            'roundtable' => $roundtable
        );
        $this->db->update('roundtable_setting', $data);
        return 1;
    }
 }   
?>
