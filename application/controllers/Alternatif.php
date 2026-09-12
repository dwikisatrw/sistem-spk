<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Alternatif extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();

        $this->load->library('pagination');
        $this->load->library('form_validation');
        $this->load->library('upload');

        $this->load->model('Alternatif_model');

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
            'page' => "Alternatif",
            'list' => $this->Alternatif_model->tampil(),
        ];

        $this->load->view('alternatif/index', $data);
    }

    // menampilkan view create
    public function create()
    {
        $data['page'] = "Alternatif";
        $this->load->view('alternatif/create', $data);
    }

    // menambahkan data ke database
    public function store()
    {
        $this->form_validation->set_rules('nama', 'Nama', 'required');
        $this->form_validation->set_rules('telepon', 'Nomor Telepon', 'required');

        if ($this->form_validation->run() != false) {

            $file_pdf = null;

            // cek apakah ada file
            if ($_FILES['file_pdf']['name']) {

                $config['upload_path']   = './uploads/pdf/';
                $config['allowed_types'] = 'pdf';
                $config['max_size']      = 2048;
                $config['encrypt_name']  = TRUE;

                $this->upload->initialize($config);

                if ($this->upload->do_upload('file_pdf')) {

                    $upload_data = $this->upload->data();
                    $file_pdf = $upload_data['file_name'];
                } else {

                    $this->session->set_flashdata(
                        'message',
                        '<div class="alert alert-danger" role="alert">'
                            . $this->upload->display_errors() .
                            '</div>'
                    );

                    redirect('Alternatif/create');
                }
            }

            $data = [
                'nama'     => $this->input->post('nama'),
                'telepon' => $this->input->post('telepon'),
                'file_pdf' => $file_pdf
            ];

            $result = $this->Alternatif_model->insert($data);

            if ($result) {

                $this->session->set_flashdata(
                    'message',
                    '<div class="alert alert-success" role="alert">
                    Data berhasil disimpan!
                    </div>'
                );

                redirect('Alternatif');
            }
        } else {

            $this->session->set_flashdata(
                'message',
                '<div class="alert alert-danger" role="alert">
                Data gagal disimpan!
                </div>'
            );

            redirect('Alternatif/create');
        }
    }

    public function edit($id_alternatif)
    {
        $alternatif = $this->Alternatif_model->show($id_alternatif);

        $data = [
            'page' => "Alternatif",
            'alternatif' => $alternatif
        ];

        $this->load->view('alternatif/edit', $data);
    }

    public function update($id_alternatif)
    {
        $id_alternatif = $this->input->post('id_alternatif');

        $data = [
            'nama' => $this->input->post('nama'),
            'telepon' => $this->input->post('telepon')
        ];

        // cek jika upload file baru
        if ($_FILES['file_pdf']['name']) {

            $config['upload_path']   = './uploads/pdf/';
            $config['allowed_types'] = 'pdf';
            $config['max_size']      = 20480;
            $config['encrypt_name']  = TRUE;

            $this->upload->initialize($config);

            if ($this->upload->do_upload('file_pdf')) {

                $upload_data = $this->upload->data();

                $data['file_pdf'] = $upload_data['file_name'];
            } else {

                $this->session->set_flashdata(
                    'message',
                    '<div class="alert alert-danger" role="alert">'
                        . $this->upload->display_errors() .
                        '</div>'
                );

                redirect('Alternatif/edit/' . $id_alternatif);
            }
        }

        $this->Alternatif_model->update($id_alternatif, $data);

        $this->session->set_flashdata(
            'message',
            '<div class="alert alert-success" role="alert">
            Data berhasil diupdate!
            </div>'
        );

        redirect('Alternatif');
    }

    public function destroy($id_alternatif)
    {
        $alternatif = $this->Alternatif_model->show($id_alternatif);

        // hapus file pdf jika ada
        if ($alternatif->file_pdf != null) {

            $path = './uploads/pdf/' . $alternatif->file_pdf;

            if (file_exists($path)) {
                unlink($path);
            }
        }

        $this->Alternatif_model->delete($id_alternatif);

        $this->session->set_flashdata(
            'message',
            '<div class="alert alert-success" role="alert">
            Data berhasil dihapus!
            </div>'
        );

        redirect('Alternatif');
    }
}
