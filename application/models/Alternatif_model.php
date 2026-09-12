<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Alternatif_model extends CI_Model
{

    public function tampil()
    {
        $query = $this->db->get('alternatif');
        return $query->result();
    }

    public function insert($data = [])
    {
        $simpan = array(
            'nama'      => $data['nama'],
            'telepon'      => $data['telepon'],
            'file_pdf'  => $data['file_pdf']
        );

        $result = $this->db->insert('alternatif', $simpan);
        return $result;
    }

    public function show($id_alternatif)
    {
        $this->db->where('id_alternatif', $id_alternatif);
        $query = $this->db->get('alternatif');
        return $query->row();
    }

    public function update($id_alternatif, $data = [])
    {
        $ubah = array(
            'nama' => $data['nama'],
            'telepon' => $data['telepon']
        );

        // jika file pdf diupload
        if (!empty($data['file_pdf'])) {
            $ubah['file_pdf'] = $data['file_pdf'];
        }

        $this->db->where('id_alternatif', $id_alternatif);
        $this->db->update('alternatif', $ubah);
    }

    public function delete($id_alternatif)
    {
        $this->db->where('id_alternatif', $id_alternatif);
        $this->db->delete('alternatif');
    }
}
