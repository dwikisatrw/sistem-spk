<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Penilaian extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();

        $this->load->library('pagination');
        $this->load->library('form_validation');

        $this->load->model('Penilaian_model');

        if ($this->session->userdata('id_user_level') != "1") {
?>
            <script type="text/javascript">
                alert('Anda tidak berhak mengakses halaman ini!');
                window.location = '<?php echo base_url("Login/home"); ?>'
            </script>
<?php
        }
    }

    public function index()
    {
        $data = [
            'page'       => "Penilaian",
            'kriteria'   => $this->Penilaian_model->get_kriteria(),
            'alternatif' => $this->Penilaian_model->get_alternatif(),
        ];

        $this->load->view('penilaian/index', $data);
    }

    public function tambah_penilaian()
    {
        $id_alternatif = $this->input->post('id_alternatif');
        $id_kriteria   = $this->input->post('id_kriteria');
        $nilai         = $this->input->post('nilai');

        // validasi
        if (empty($id_alternatif) || empty($id_kriteria) || empty($nilai)) {

            $this->session->set_flashdata(
                'message',
                '<div class="alert alert-danger" role="alert">
                Data penilaian gagal disimpan!
                </div>'
            );

            redirect('Penilaian');
        }

        foreach ($nilai as $i => $key) {

            $cek = $this->Penilaian_model->data_penilaian(
                $id_alternatif,
                $id_kriteria[$i]
            );

            // jika belum ada maka insert
            if (!$cek) {

                $this->Penilaian_model->tambah_penilaian(
                    $id_alternatif,
                    $id_kriteria[$i],
                    $key
                );
            }
        }

        $this->session->set_flashdata(
            'message',
            '<div class="alert alert-success" role="alert">
            Data berhasil disimpan!
            </div>'
        );

        redirect('Penilaian');
    }

    public function update_penilaian()
    {
        $id_alternatif = $this->input->post('id_alternatif');
        $id_kriteria   = $this->input->post('id_kriteria');
        $nilai         = $this->input->post('nilai');

        // validasi
        if (empty($id_alternatif) || empty($id_kriteria) || empty($nilai)) {

            $this->session->set_flashdata(
                'message',
                '<div class="alert alert-danger" role="alert">
                Data penilaian gagal diupdate!
                </div>'
            );

            redirect('Penilaian');
        }

        foreach ($nilai as $i => $key) {

            $cek = $this->Penilaian_model->data_penilaian(
                $id_alternatif,
                $id_kriteria[$i]
            );

            // jika belum ada maka insert
            if (!$cek) {

                $this->Penilaian_model->tambah_penilaian(
                    $id_alternatif,
                    $id_kriteria[$i],
                    $key
                );
            } else {

                // jika sudah ada maka update
                $this->Penilaian_model->edit_penilaian(
                    $id_alternatif,
                    $id_kriteria[$i],
                    $key
                );
            }
        }

        $this->session->set_flashdata(
            'message',
            '<div class="alert alert-success" role="alert">
            Data berhasil diupdate!
            </div>'
        );

        redirect('Penilaian');
    }
}
