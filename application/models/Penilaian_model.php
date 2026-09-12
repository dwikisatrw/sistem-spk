<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Penilaian_model extends CI_Model
{

    public function tambah_penilaian($id_alternatif, $id_kriteria, $nilai)
    {
        $data = array(
            'id_alternatif' => $id_alternatif,
            'id_kriteria'   => $id_kriteria,
            'nilai'         => $nilai
        );

        return $this->db->insert('penilaian', $data);
    }

    public function edit_penilaian($id_alternatif, $id_kriteria, $nilai)
    {
        $this->db->where('id_alternatif', $id_alternatif);
        $this->db->where('id_kriteria', $id_kriteria);

        return $this->db->update('penilaian', [
            'nilai' => $nilai
        ]);
    }

    public function get_kriteria()
    {
        return $this->db->get('kriteria')->result();
    }

    public function get_alternatif()
    {
        // tambahkan order biar rapi
        $this->db->order_by('id_alternatif', 'ASC');

        return $this->db->get('alternatif')->result();
    }

    public function data_penilaian($id_alternatif, $id_kriteria)
    {
        $this->db->where('id_alternatif', $id_alternatif);
        $this->db->where('id_kriteria', $id_kriteria);

        return $this->db->get('penilaian')->row_array();
    }

    public function untuk_tombol($id_alternatif)
    {
        $this->db->where('id_alternatif', $id_alternatif);

        return $this->db->get('penilaian')->num_rows();
    }

    public function data_sub_kriteria($id_kriteria)
    {
        $this->db->where('id_kriteria', $id_kriteria);
        $this->db->order_by('nilai', 'DESC');

        return $this->db->get('sub_kriteria')->result_array();
    }

    // tambahan ambil pdf alternatif
    public function get_pdf_alternatif($id_alternatif)
    {
        $this->db->select('file_pdf');
        $this->db->where('id_alternatif', $id_alternatif);

        return $this->db->get('alternatif')->row_array();
    }

    public function data_penilaian2($id_alternatif, $id_kriteria)
    {
        return $this->db->get_where(
            'penilaian',
            [
                'id_alternatif' => $id_alternatif,
                'id_kriteria' => $id_kriteria
            ]
        )->row_array();
    }
}
