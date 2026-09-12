<?php $this->load->view('layouts/header_admin'); ?>

<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">
        <i class="fas fa-fw fa-question-circle"></i> Master Soal Wawancara
    </h1>

    <button type="button" class="btn btn-success" data-toggle="modal" data-target="#modalTambah">
        <i class="fa fa-plus"></i> Tambah Soal
    </button>
</div>

<?= $this->session->flashdata('message'); ?>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-danger">
            <i class="fa fa-table"></i> Daftar Soal Wawancara
        </h6>
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead class="bg-danger text-white">
                    <tr align="center">
                        <th width="5%">No</th>
                        <th>Pertanyaan Wawancara</th>
                        <th width="15%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 1;
                    foreach ($soal as $s) :
                    ?>
                        <tr>
                            <td align="center"><?= $no ?></td>
                            <td><?= htmlspecialchars($s->pertanyaan) ?></td>
                            <td align="center">
                                <div class="btn-group" role="group">
                                    <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#modalEdit<?= $s->id_soal ?>" title="Edit Data">
                                        <i class="fa fa-edit"></i> Edit
                                    </button>
                                    <a href="<?= base_url('Soal_wawancara/destroy/' . $s->id_soal) ?>" onclick="return confirm('Apakah Anda yakin ingin menghapus soal ini?')" class="btn btn-danger btn-sm" title="Hapus Data">
                                        <i class="fa fa-trash"></i> Hapus
                                    </a>
                                </div>
                            </td>
                        </tr>
                    <?php
                        $no++;
                    endforeach;
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Tambah -->
<div class="modal fade" id="modalTambah" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fa fa-plus"></i> Tambah Soal Wawancara</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?= form_open('Soal_wawancara/store') ?>
            <div class="modal-body">
                <div class="form-group">
                    <label class="font-weight-bold">Pertanyaan</label>
                    <textarea name="pertanyaan" class="form-control" rows="3" placeholder="Masukkan pertanyaan wawancara..." required></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Simpan</button>
            </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Edit -->
<?php foreach ($soal as $s) : ?>
    <div class="modal fade" id="modalEdit<?= $s->id_soal ?>" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="fa fa-edit"></i> Edit Soal Wawancara</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <?= form_open('Soal_wawancara/update/' . $s->id_soal) ?>
                <div class="modal-body">
                    <div class="form-group">
                        <label class="font-weight-bold">Pertanyaan</label>
                        <textarea name="pertanyaan" class="form-control" rows="3" required><?= htmlspecialchars($s->pertanyaan) ?></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Update</button>
                </div>
                </form>
            </div>
        </div>
    </div>
<?php endforeach; ?>

<?php $this->load->view('layouts/footer_admin'); ?>
