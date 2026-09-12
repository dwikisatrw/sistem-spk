<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Penilaian_wawancara_model extends CI_Model
{
    public function getAlternatif()
    {
        $this->db->order_by('id_alternatif', 'ASC');
        return $this->db->get('alternatif')->result();
    }

    public function getAllHasilWawancara()
    {
        $this->db->select('
            jawaban_wawancara.*,
            alternatif.nama,
            soal_wawancara.pertanyaan
        ');
        $this->db->from('jawaban_wawancara');
        $this->db->join('alternatif', 'alternatif.id_alternatif = jawaban_wawancara.id_alternatif', 'left');
        $this->db->join('soal_wawancara', 'soal_wawancara.id_soal = jawaban_wawancara.id_soal', 'left');
        $this->db->order_by('jawaban_wawancara.id_alternatif', 'ASC');

        return $this->db->get()->result();
    }
}
