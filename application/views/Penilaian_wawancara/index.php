<?php $this->load->view('layouts/header_admin'); ?>

<div class="container-fluid">

    <h1 class="h3 mb-4 text-gray-800">
        <i class="fas fa-user-check"></i> Data Penilaian Wawancara
    </h1>

    <?= $this->session->flashdata('pesan'); ?>

    <!-- <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-danger">
                <i class="fa fa-edit"></i> Form Penilaian Wawancara
            </h6>
        </div>

        <div class="card-body">

            <form action="<?= base_url('Penilaian_wawancara/simpan'); ?>" method="POST">

                <div class="form-group">
                    <label class="font-weight-bold">Nama Alternatif (Kandidat)</label>

                    <select name="id_alternatif" id="select_alternatif" class="form-control" required onchange="loadAnswers(this.value)">
                        <option value="">-- Pilih Alternatif --</option>

                        <?php if (!empty($alternatif)) : ?>
                            <?php foreach ($alternatif as $a) : ?>
                                <option value="<?= $a->id_alternatif; ?>">
                                    <?= htmlspecialchars($a->nama); ?>
                                </option>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <option value="">Data alternatif tidak ditemukan</option>
                        <?php endif; ?>

                    </select>
                </div>

                <hr>

                <div class="alert alert-info">
                    <i class="fas fa-info-circle mr-1"></i> Pilihlah jawaban untuk pertanyaan wawancara di bawah ini. Hasil kalkulasi jawaban akan menentukan skor <strong>Kesesuaian Persyaratan Kerja</strong> pada Data Penilaian Awal.
                </div>

                <?php if (!empty($soal_wawancara)) : ?>
                    <?php foreach ($soal_wawancara as $i => $s) : ?>

                        <div class="form-group border-bottom pb-3">
                            <label class="font-weight-bold text-dark">
                                <?= ($i + 1) . ". " . htmlspecialchars($s->pertanyaan); ?>
                            </label>

                            <div>
                                <div class="custom-control custom-radio custom-control-inline">
                                    <input
                                        type="radio"
                                        class="custom-control-input radio_ya"
                                        id="ya<?= $s->id_soal; ?>"
                                        name="jawaban_soal[<?= $s->id_soal; ?>]"
                                        value="1"
                                        required>

                                    <label class="custom-control-label text-success font-weight-bold" for="ya<?= $s->id_soal; ?>">
                                        <i class="fa fa-check-circle"></i> Ya
                                    </label>
                                </div>

                                <div class="custom-control custom-radio custom-control-inline">
                                    <input
                                        type="radio"
                                        class="custom-control-input radio_tidak"
                                        id="tidak<?= $s->id_soal; ?>"
                                        name="jawaban_soal[<?= $s->id_soal; ?>]"
                                        value="0"
                                        required>

                                    <label class="custom-control-label text-danger font-weight-bold" for="tidak<?= $s->id_soal; ?>">
                                        <i class="fa fa-times-circle"></i> Tidak
                                    </label>
                                </div>
                            </div>
                        </div>

                    <?php endforeach; ?>

                    <button type="submit" class="btn btn-success mt-2">
                        <i class="fas fa-save"></i> Simpan Penilaian Wawancara
                    </button>
                <?php else : ?>
                    <div class="alert alert-warning">
                        Belum ada soal wawancara yang tersedia. Silakan tambahkan soal melalui menu <a href="<?= base_url('Soal_wawancara'); ?>" class="alert-link">Master Soal Wawancara</a>.
                    </div>
                <?php endif; ?>

            </form>

        </div>
    </div> -->

    <!-- Ringkasan Hasil Penilaian Wawancara -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-danger">
                <i class="fa fa-table"></i> Ringkasan Hasil Kesesuaian Persyaratan Kerja
            </h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <thead class="bg-danger text-white" align="center">
                        <tr>
                            <th width="5%">No</th>
                            <th>Nama Kandidat</th>
                            <th>Status Kesesuaian Persyaratan Kerja</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        $kriteria_c5 = $this->db->group_start()
                            ->where('kode_kriteria', 'C5')
                            ->or_like('keterangan', 'Kesesuaian Persyaratan Kerja')
                            ->group_end()
                            ->get('kriteria')->row_array();

                        $total_soal_count = !empty($soal_wawancara) ? count($soal_wawancara) : 0;

                        foreach ($alternatif as $alt) :
                            $status_text = '<span class="badge badge-secondary">Belum Dinilai</span>';

                            if ($kriteria_c5) {
                                $pen = $this->Penilaian_model->data_penilaian($alt->id_alternatif, $kriteria_c5['id_kriteria']);
                                if (!empty($pen)) {
                                    $sub = $this->db->get_where('sub_kriteria', ['id_sub_kriteria' => $pen['nilai']])->row_array();
                                    
                                    $total_ya_alt = $this->db->get_where('jawaban_wawancara', [
                                        'id_alternatif' => $alt->id_alternatif,
                                        'jawaban'       => 1
                                    ])->num_rows();

                                    if (!empty($sub)) {
                                        $info_soal = ($total_soal_count > 0) ? ' (' . $total_ya_alt . '/' . $total_soal_count . ' Ya)' : '';
                                        if ($sub['nilai'] == 5) {
                                            $status_text = '<span class="badge badge-success" style="font-size: 90%;">' . $sub['deskripsi'] . $info_soal . '</span>';
                                        } elseif ($sub['nilai'] == 4) {
                                            $status_text = '<span class="badge badge-info" style="font-size: 90%;">' . $sub['deskripsi'] . $info_soal . '</span>';
                                        } elseif ($sub['nilai'] == 3) {
                                            $status_text = '<span class="badge badge-warning" style="font-size: 90%;">' . $sub['deskripsi'] . $info_soal . '</span>';
                                        } elseif ($sub['nilai'] == 2) {
                                            $status_text = '<span class="badge badge-danger" style="font-size: 90%;">' . $sub['deskripsi'] . $info_soal . '</span>';
                                        } elseif ($sub['nilai'] == 1) {
                                            $status_text = '<span class="badge badge-danger" style="font-size: 90%;">' . $sub['deskripsi'] . $info_soal . '</span>';
                                        } else {
                                            $status_text = '<span class="badge badge-secondary" style="font-size: 90%;">' . $sub['deskripsi'] . '</span>';
                                        }
                                    }
                                }
                            }
                        ?>
                            <tr align="center">
                                <td><?= $no++; ?></td>
                                <td align="left"><?= htmlspecialchars($alt->nama); ?></td>
                                <td><?= $status_text; ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

<script>
function loadAnswers(id_alternatif) {
    if (!id_alternatif) {
        $('input[type="radio"]').prop('checked', false);
        return;
    }

    $.ajax({
        url: '<?= base_url("Penilaian_wawancara/get_jawaban_ajax"); ?>',
        type: 'POST',
        data: { id_alternatif: id_alternatif },
        dataType: 'json',
        success: function(data) {
            $('input[type="radio"]').prop('checked', false);
            if (data && typeof data === 'object') {
                $.each(data, function(id_soal, val) {
                    if (val == 1) {
                        $('#ya' + id_soal).prop('checked', true);
                    } else if (val == 0) {
                        $('#tidak' + id_soal).prop('checked', true);
                    }
                });
            }
        }
    });
}
</script>

<?php $this->load->view('layouts/footer_admin'); ?>