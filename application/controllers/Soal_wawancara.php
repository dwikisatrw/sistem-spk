<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Soal_wawancara extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('Soal_wawancara_model');

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
        $data = [
            'page' => 'Soal Wawancara',
            'soal' => $this->Soal_wawancara_model->get_all()
        ];
        $this->load->view('soal_wawancara/index', $data);
    }

    public function store()
    {
        $this->form_validation->set_rules('pertanyaan', 'Pertanyaan', 'required');

        if ($this->form_validation->run() != FALSE) {
            $data = [
                'pertanyaan' => $this->input->post('pertanyaan')
            ];
            $this->Soal_wawancara_model->insert($data);
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Data soal berhasil disimpan!</div>');
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Data gagal disimpan! Pertanyaan wajib diisi.</div>');
        }
        redirect('Soal_wawancara');
    }

    public function update($id_soal)
    {
        $this->form_validation->set_rules('pertanyaan', 'Pertanyaan', 'required');

        if ($this->form_validation->run() != FALSE) {
            $data = [
                'pertanyaan' => $this->input->post('pertanyaan')
            ];
            $this->Soal_wawancara_model->update($id_soal, $data);
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Data soal berhasil diupdate!</div>');
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Data gagal diupdate! Pertanyaan wajib diisi.</div>');
        }
        redirect('Soal_wawancara');
    }

    public function destroy($id_soal)
    {
        $this->Soal_wawancara_model->delete($id_soal);
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Data soal berhasil dihapus!</div>');
        redirect('Soal_wawancara');
    }
}
