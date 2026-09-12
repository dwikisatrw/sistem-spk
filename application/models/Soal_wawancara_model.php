<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Soal_wawancara_model extends CI_Model
{
    public function get_all()
    {
        return $this->db->get('soal_wawancara')->result();
    }

    public function get_by_id($id_soal)
    {
        return $this->db->get_where('soal_wawancara', ['id_soal' => $id_soal])->row();
    }

    public function insert($data)
    {
        return $this->db->insert('soal_wawancara', $data);
    }

    public function update($id_soal, $data)
    {
        $this->db->where('id_soal', $id_soal);
        return $this->db->update('soal_wawancara', $data);
    }

    public function delete($id_soal)
    {
        $this->db->where('id_soal', $id_soal);
        return $this->db->delete('soal_wawancara');
    }
}
