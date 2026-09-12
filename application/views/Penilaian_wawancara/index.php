<?php $this->load->view('layouts/header_admin'); ?>

<div class="container-fluid">

    <h1 class="h3 mb-4 text-gray-800">
        <i class="fas fa-user-check"></i> Data Penilaian Wawancara
    </h1>

    <div class="card shadow mb-4">
        <div class="card-header">
            <strong>Form Penilaian Wawancara</strong>
        </div>

        <div class="card-body">

            <form action="<?= base_url('Penilaian_wawancara/simpan'); ?>" method="POST">

                <div class="form-group">
                    <label><b>Nama Alternatif</b></label>

                    <select name="id_alternatif" class="form-control" required>
                        <option value="">-- Pilih Alternatif --</option>

                        <?php if (!empty($alternatif)) : ?>
                            <?php foreach ($alternatif as $a) : ?>
                                <option value="<?= $a->id_alternatif; ?>">
                                    <?= $a->nama; ?>
                                </option>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <option value="">Data alternatif tidak ditemukan</option>
                        <?php endif; ?>

                    </select>
                </div>

                <hr>

                <?php
                $pertanyaan = [
                    "Apakah siap ditempatkan di daerah kerja?",
                    "Mampu mengendarai motor dan memiliki SIM C?",
                    "Mampu mengendarai mobil dan memiliki SIM A?",
                    "Siap bekerja on-call 24 jam?",
                    "Siap bekerja tidak sesuai job-desc?"
                ];

                foreach ($pertanyaan as $i => $p) :
                ?>

                    <div class="form-group">
                        <label><strong><?= ($i + 1) . ". " . $p; ?></strong></label>

                        <div>

                            <div class="custom-control custom-radio custom-control-inline">
                                <input
                                    type="radio"
                                    class="custom-control-input"
                                    id="ya<?= $i; ?>"
                                    name="jawaban<?= $i + 1; ?>"
                                    value="1"
                                    required>

                                <label class="custom-control-label" for="ya<?= $i; ?>">
                                    Ya
                                </label>
                            </div>

                            <div class="custom-control custom-radio custom-control-inline">
                                <input
                                    type="radio"
                                    class="custom-control-input"
                                    id="tidak<?= $i; ?>"
                                    name="jawaban<?= $i + 1; ?>"
                                    value="0">

                                <label class="custom-control-label" for="tidak<?= $i; ?>">
                                    Tidak
                                </label>
                            </div>

                        </div>
                    </div>

                <?php endforeach; ?>

                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Simpan
                </button>

            </form>

        </div>
    </div>

</div>

<?php $this->load->view('layouts/footer_admin'); ?>