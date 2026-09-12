<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Penilaian_wawancara extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();

        $this->load->model('Penilaian_wawancara_model');
    }
    public function index()
    {
        $data['page'] = 'Penilaian Wawancara';
        $data['alternatif'] = $this->Penilaian_wawancara_model->getAlternatif();

        $this->load->view('penilaian_wawancara/index', $data);
    }
    public function tambah()
    {
        $data['page'] = 'Penilaian Wawancara';
        $data['alternatif'] = $this->Penilaian_wawancara_model->getAlternatif();

        $this->load->view('penilaian_wawancara/tambah', $data);
    }

    public function simpan()
    {
        $data = [
            'id_alternatif' => $this->input->post('id_alternatif'),
            'jawaban1'      => $this->input->post('jawaban1'),
            'jawaban2'      => $this->input->post('jawaban2'),
            'jawaban3'      => $this->input->post('jawaban3'),
            'jawaban4'      => $this->input->post('jawaban4'),
            'jawaban5'      => $this->input->post('jawaban5')
        ];

        $this->Penilaian_wawancara_model->insert($data);

        $this->session->set_flashdata('pesan', 'Data berhasil disimpan.');

        redirect('Penilaian_wawancara');
    }
}
