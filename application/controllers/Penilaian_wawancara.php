<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Penilaian_wawancara extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Penilaian_wawancara_model');
        $this->load->model('Penilaian_model');

        if ($this->session->userdata('id_user_level') != "1") {
?>
            <script type="text/javascript">
                alert('Anda tidak berhak mengakses halaman ini!');
                window.location = '<?php echo base_url("Login/home"); ?>';
            </script>
<?php
        }
    }

    public function index()
    {
        $data['page']           = 'Penilaian Wawancara';
        $data['alternatif']     = $this->Penilaian_wawancara_model->getAlternatif();
        $data['soal_wawancara'] = $this->Penilaian_model->get_soal_wawancara();

        $this->load->view('Penilaian_wawancara/index', $data);
    }

    public function get_jawaban_ajax()
    {
        $id_alternatif = $this->input->post('id_alternatif');
        $jawaban = $this->Penilaian_model->get_jawaban_wawancara($id_alternatif);
        echo json_encode($jawaban);
    }

    public function simpan()
    {
        $id_alternatif = $this->input->post('id_alternatif');
        $jawaban_soal  = $this->input->post('jawaban_soal');

        if (!empty($id_alternatif) && !empty($jawaban_soal)) {
            $this->Penilaian_model->simpan_jawaban_wawancara($id_alternatif, $jawaban_soal);
            $this->Penilaian_model->kalkulasi_kesesuaian_persyaratan($id_alternatif);

            $this->session->set_flashdata('pesan', '<div class="alert alert-success" role="alert">Data penilaian wawancara berhasil disimpan!</div>');
        } else {
            $this->session->set_flashdata('pesan', '<div class="alert alert-danger" role="alert">Data gagal disimpan! Harap pilih alternatif dan jawab semua pertanyaan.</div>');
        }

        redirect('Penilaian_wawancara');
    }
}
