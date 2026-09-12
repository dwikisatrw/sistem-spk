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

    public function get_soal_wawancara()
    {
        return $this->db->get('soal_wawancara')->result();
    }

    public function get_jawaban_wawancara($id_alternatif)
    {
        $res = $this->db->get_where('jawaban_wawancara', ['id_alternatif' => $id_alternatif])->result_array();
        $jawaban = [];
        foreach ($res as $row) {
            $jawaban[$row['id_soal']] = $row['jawaban'];
        }
        return $jawaban;
    }

    public function simpan_jawaban_wawancara($id_alternatif, $jawaban_map)
    {
        if (empty($jawaban_map) || !is_array($jawaban_map)) {
            return;
        }

        foreach ($jawaban_map as $id_soal => $val) {
            $val = (int)$val;
            $cek = $this->db->get_where('jawaban_wawancara', [
                'id_alternatif' => $id_alternatif,
                'id_soal'       => $id_soal
            ])->row_array();

            if ($cek) {
                $this->db->where('id_jawaban', $cek['id_jawaban']);
                $this->db->update('jawaban_wawancara', ['jawaban' => $val]);
            } else {
                $this->db->insert('jawaban_wawancara', [
                    'id_alternatif' => $id_alternatif,
                    'id_soal'       => $id_soal,
                    'jawaban'       => $val
                ]);
            }
        }
    }

    public function kalkulasi_kesesuaian_persyaratan($id_alternatif)
    {
        // 1. Ambil total soal wawancara
        $total_soal = $this->db->count_all('soal_wawancara');
        if ($total_soal == 0) {
            return;
        }

        // 2. Hitung jumlah jawaban Ya (1)
        $this->db->where('id_alternatif', $id_alternatif);
        $this->db->where('jawaban', 1);
        $total_ya = $this->db->count_all_results('jawaban_wawancara');

        // 3. Hitung rasio
        $ratio = $total_ya / $total_soal;

        if ($ratio >= 0.85) {
            $nilai_target = 5; // Sangat Baik (Misal 5/5 = 100%)
        } elseif ($ratio >= 0.65) {
            $nilai_target = 4; // Baik (Misal 4/5 = 80%)
        } elseif ($ratio >= 0.45) {
            $nilai_target = 3; // Cukup (Misal 3/5 = 60%)
        } elseif ($ratio >= 0.25) {
            $nilai_target = 2; // Kurang (Misal 2/5 = 40%)
        } else {
            $nilai_target = 1; // Sangat Kurang (Misal 1/5 = 20% atau 0/5 = 0%)
        }

        // 4. Cari id_kriteria untuk 'Kesesuaian Persyaratan Kerja'
        $kriteria_c5 = $this->db->group_start()
            ->where('kode_kriteria', 'C5')
            ->or_like('keterangan', 'Kesesuaian Persyaratan Kerja')
            ->group_end()
            ->get('kriteria')->row_array();

        if (!$kriteria_c5) {
            return;
        }

        $id_kriteria_c5 = $kriteria_c5['id_kriteria'];

        // 5. Cari id_sub_kriteria yang nilainya = $nilai_target
        $sub = $this->db->get_where('sub_kriteria', [
            'id_kriteria' => $id_kriteria_c5,
            'nilai'       => $nilai_target
        ])->row_array();

        if (!$sub) {
            return;
        }

        $id_sub_kriteria = $sub['id_sub_kriteria'];

        // 6. Simpan atau Update ke tabel penilaian
        $cek_penilaian = $this->data_penilaian($id_alternatif, $id_kriteria_c5);
        if (!$cek_penilaian) {
            $this->tambah_penilaian($id_alternatif, $id_kriteria_c5, $id_sub_kriteria);
        } else {
            $this->edit_penilaian($id_alternatif, $id_kriteria_c5, $id_sub_kriteria);
        }
    }
}
