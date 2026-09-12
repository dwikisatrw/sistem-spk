<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Penilaian_wawancara_model extends CI_Model
{

    public function getAlternatif()
    {
        return $this->db->get('alternatif')->result();
    }

    public function getAll()
    {
        $this->db->select('
        wawancara.*,
        alternatif.nama
    ');
        $this->db->from('wawancara');
        $this->db->join('alternatif', 'alternatif.id_alternatif = wawancara.id_alternatif', 'left');

        return $this->db->get()->result();
    }

    public function insert($data)
    {
        return $this->db->insert('wawancara', $data);
    }
}
