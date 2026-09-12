<?php $this->load->view('layouts/header_admin'); ?>

<div class="d-sm-flex align-items-center justify-content-between mb-4">
	<h1 class="h3 mb-0 text-gray-800">
		<i class="fas fa-fw fa-edit"></i> Data Penilaian Awal
	</h1>
</div>

<?= $this->session->flashdata('message'); ?>

<div class="card shadow mb-4">

	<div class="card-header py-3">
		<h6 class="m-0 font-weight-bold text-danger">
			<i class="fa fa-table"></i> Daftar Data Penilaian
		</h6>
	</div>

	<div class="card-body">

		<div class="table-responsive">

			<table class="table table-bordered"
				id="dataTable"
				width="100%"
				cellspacing="0">

				<thead class="bg-danger text-white">

					<tr align="center">
						<th width="5%">No</th>
						<th>Nama Kandidat Calon Karyawan (Alternatif)</th>
						<th width="15%">Status</th>
						<th width="15%">Aksi</th>
					</tr>

				</thead>

				<tbody>

					<?php
					$no = 1;
					foreach ($alternatif as $keys):
					?>

						<tr align="center">

							<td><?= $no ?></td>

							<td align="left">
								<?= $keys->nama ?>
							</td>

							<td>
								<?php
								$belum_lengkap = false;

								foreach ($kriteria as $k) {
									$cek_nilai = $this->Penilaian_model->data_penilaian(
										$keys->id_alternatif,
										$k->id_kriteria
									);

									if (!empty($cek_nilai)) {
										$sub = $this->db
											->get_where(
												'sub_kriteria',
												[
													'id_sub_kriteria' => $cek_nilai['nilai']
												]
											)
											->row_array();

										if (
											!empty($sub) &&
											$sub['nilai'] == 0
										) {
											$belum_lengkap = true;
										}
									} else {
										$belum_lengkap = true;
									}
								}
								?>

								<?php if ($belum_lengkap) { ?>
									<span class="badge badge-danger">
										Lengkapi Data
									</span>
								<?php } else { ?>
									<span class="badge badge-success">
										Lengkap
									</span>
								<?php } ?>
							</td>

							<?php
							$cek_tombol = $this->Penilaian_model->untuk_tombol($keys->id_alternatif);
							?>

							<td>
								<?php if ($cek_tombol == 0) { ?>
									<a data-toggle="modal"
										href="#set<?= $keys->id_alternatif ?>"
										class="btn btn-success btn-sm">
										<i class="fa fa-plus"></i> Input
									</a>
								<?php } else { ?>
									<a data-toggle="modal"
										href="#edit<?= $keys->id_alternatif ?>"
										class="btn btn-warning btn-sm">
										<i class="fa fa-edit"></i> Edit
									</a>
								<?php } ?>
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


<!-- ======================= MODAL INPUT & EDIT ======================= -->

<?php foreach ($alternatif as $keys): ?>

	<?php
	// Ambil jawaban wawancara alternatif ini
	$existing_jawaban = $this->Penilaian_model->get_jawaban_wawancara($keys->id_alternatif);
	?>

	<!-- ======================= INPUT MODAL ======================= -->

	<div class="modal fade"
		id="set<?= $keys->id_alternatif ?>"
		tabindex="-1"
		role="dialog"
		aria-hidden="true">

		<div class="modal-dialog modal-xl" role="document">

			<div class="modal-content">

				<div class="modal-header bg-danger text-white">

					<h5 class="modal-title">
						<i class="fa fa-plus"></i>
						Input Penilaian - <?= $keys->nama ?>
					</h5>

					<button type="button" class="close text-white" data-dismiss="modal">
						<span>&times;</span>
					</button>

				</div>

				<?= form_open('Penilaian/tambah_penilaian', ['id' => 'form_set_' . $keys->id_alternatif]) ?>

				<input type="hidden" name="id_alternatif" value="<?= $keys->id_alternatif ?>">

				<div class="modal-body">

					<!-- Indicator Header -->
					<div class="mb-4">
						<ul class="nav nav-pills nav-justified" id="pills-tab-set<?= $keys->id_alternatif ?>" role="tablist">
							<li class="nav-item">
								<a class="nav-link active font-weight-bold" id="step1-tab-set<?= $keys->id_alternatif ?>" style="pointer-events: none;">
									1. Penilaian Kriteria Awal
								</a>
							</li>
							<li class="nav-item">
								<a class="nav-link text-secondary font-weight-bold" id="step2-tab-set<?= $keys->id_alternatif ?>" style="pointer-events: none;">
									2. Pertanyaan Wawancara
								</a>
							</li>
						</ul>
					</div>

					<!-- STEP 1: KRITERIA -->
					<div id="step1_set<?= $keys->id_alternatif ?>">

						<div class="row">

							<!-- PDF Preview -->
							<div class="col-md-6">
								<h6 class="font-weight-bold mb-3">
									Dokumen PDF: <?= $keys->nama ?>
								</h6>

								<?php if (!empty($keys->file_pdf)) { ?>
									<iframe
										src="<?= base_url('uploads/pdf/' . $keys->file_pdf); ?>#toolbar=0"
										width="100%"
										height="500px"
										style="border:1px solid #ccc; border-radius:5px;">
									</iframe>
								<?php } else { ?>
									<div class="alert alert-warning">
										PDF belum tersedia
									</div>
								<?php } ?>
							</div>

							<!-- Form Penilaian Kriteria Non-C5 -->
							<div class="col-md-6">

								<?php foreach ($kriteria as $key): ?>

									<?php
									// Skip Kesesuaian Persyaratan Kerja (C5) dari pilihan manual
									if ($key->kode_kriteria == 'C5' || stripos($key->keterangan, 'Kesesuaian Persyaratan Kerja') !== false) {
										continue;
									}

									$sub_kriteria = $this->Penilaian_model->data_sub_kriteria($key->id_kriteria);
									?>

									<?php if ($sub_kriteria != NULL): ?>

										<input type="hidden" name="id_kriteria[]" value="<?= $key->id_kriteria ?>">

										<div class="form-group">
											<label class="font-weight-bold">
												<?= $key->keterangan ?>
											</label>

											<select name="nilai[]" class="form-control" required>
												<option value="">-- Pilih --</option>

												<?php foreach ($sub_kriteria as $subs_kriteria): ?>
													<option value="<?= $subs_kriteria['id_sub_kriteria'] ?>">
														<?= $subs_kriteria['deskripsi'] ?>
													</option>
												<?php endforeach; ?>

											</select>
										</div>

									<?php endif; ?>

								<?php endforeach; ?>

							</div>

						</div>

						<div class="modal-footer px-0 pb-0 mt-3">
							<button type="button" class="btn btn-secondary" data-dismiss="modal">
								Tutup
							</button>
							<button type="button" class="btn btn-primary" onclick="goToStep(<?= $keys->id_alternatif ?>, 2, 'set')">
								Lanjut ke Soal Wawancara <i class="fa fa-arrow-right ml-1"></i>
							</button>
						</div>

					</div>

					<!-- STEP 2: SOAL WAWANCARA -->
					<div id="step2_set<?= $keys->id_alternatif ?>" style="display:none;">

						<div class="alert alert-info">
							<i class="fas fa-info-circle mr-1"></i> Jawablah pertanyaan wawancara di bawah ini. Hasil jawaban akan secara otomatis dikalkulasikan untuk menentukan tingkat <strong>Kesesuaian Persyaratan Kerja</strong>.
						</div>

						<div class="card card-body shadow-sm mb-3">
							<?php if (!empty($soal_wawancara)): ?>
								<?php foreach ($soal_wawancara as $idx => $s): ?>
									<div class="form-group <?= ($idx < count($soal_wawancara) - 1) ? 'border-bottom pb-3' : '' ?>">
										<label class="font-weight-bold text-dark">
											<?= ($idx + 1) . '. ' . htmlspecialchars($s->pertanyaan) ?>
										</label>

										<div class="mt-1">
											<div class="custom-control custom-radio custom-control-inline">
												<input type="radio"
													id="set_ya_<?= $keys->id_alternatif ?>_<?= $s->id_soal ?>"
													name="jawaban_soal[<?= $s->id_soal ?>]"
													value="1"
													class="custom-control-input"
													required>
												<label class="custom-control-label text-success font-weight-bold" for="set_ya_<?= $keys->id_alternatif ?>_<?= $s->id_soal ?>">
													<i class="fa fa-check-circle"></i> Ya / Sesuai
												</label>
											</div>

											<div class="custom-control custom-radio custom-control-inline">
												<input type="radio"
													id="set_tidak_<?= $keys->id_alternatif ?>_<?= $s->id_soal ?>"
													name="jawaban_soal[<?= $s->id_soal ?>]"
													value="0"
													class="custom-control-input"
													required>
												<label class="custom-control-label text-danger font-weight-bold" for="set_tidak_<?= $keys->id_alternatif ?>_<?= $s->id_soal ?>">
													<i class="fa fa-times-circle"></i> Tidak / Tidak Sesuai
												</label>
											</div>
										</div>
									</div>
								<?php endforeach; ?>
							<?php else: ?>
								<div class="alert alert-warning mb-0">
									Belum ada master soal wawancara. Silakan tambahkan soal melalui menu Master Soal Wawancara.
								</div>
							<?php endif; ?>
						</div>

						<div class="modal-footer px-0 pb-0 mt-3">
							<button type="button" class="btn btn-secondary" onclick="goToStep(<?= $keys->id_alternatif ?>, 1, 'set')">
								<i class="fa fa-arrow-left mr-1"></i> Kembali
							</button>

							<button type="submit" class="btn btn-success">
								<i class="fa fa-save"></i> Simpan Penilaian
							</button>
						</div>

					</div>

				</div>

				</form>

			</div>

		</div>

	</div>




	<!-- ======================= EDIT MODAL ======================= -->

	<div class="modal fade"
		id="edit<?= $keys->id_alternatif ?>"
		tabindex="-1"
		role="dialog"
		aria-hidden="true">

		<div class="modal-dialog modal-xl" role="document">

			<div class="modal-content">

				<div class="modal-header bg-warning text-white">

					<h5 class="modal-title">
						<i class="fa fa-edit"></i>
						Edit Penilaian - <?= $keys->nama ?>
					</h5>

					<button type="button" class="close text-white" data-dismiss="modal">
						<span>&times;</span>
					</button>

				</div>

				<?= form_open('Penilaian/update_penilaian', ['id' => 'form_edit_' . $keys->id_alternatif]) ?>

				<input type="hidden" name="id_alternatif" value="<?= $keys->id_alternatif ?>">

				<div class="modal-body">

					<!-- Indicator Header -->
					<div class="mb-4">
						<ul class="nav nav-pills nav-justified" id="pills-tab-edit<?= $keys->id_alternatif ?>" role="tablist">
							<li class="nav-item">
								<a class="nav-link active font-weight-bold" id="step1-tab-edit<?= $keys->id_alternatif ?>" style="pointer-events: none;">
									1. Penilaian Kriteria Awal
								</a>
							</li>
							<li class="nav-item">
								<a class="nav-link text-secondary font-weight-bold" id="step2-tab-edit<?= $keys->id_alternatif ?>" style="pointer-events: none;">
									2. Pertanyaan Wawancara
								</a>
							</li>
						</ul>
					</div>

					<!-- STEP 1: KRITERIA -->
					<div id="step1_edit<?= $keys->id_alternatif ?>">

						<div class="row">

							<!-- PDF Preview -->
							<div class="col-md-6">

								<?php if (!empty($keys->file_pdf)) : ?>

									<div class="mb-2">
										<a href="<?= base_url('uploads/pdf/' . $keys->file_pdf); ?>"
											target="_blank"
											class="btn btn-danger btn-sm">
											<i class="fa fa-file-pdf"></i>
											Buka PDF Full
										</a>
									</div>

									<iframe
										src="<?= base_url('uploads/pdf/' . $keys->file_pdf); ?>"
										width="100%"
										height="500px"
										style="border:1px solid #ccc; border-radius:5px;">
									</iframe>

								<?php else : ?>

									<div class="alert alert-warning">
										File PDF belum tersedia
									</div>

								<?php endif; ?>

							</div>

							<!-- FORM KRITERIA NON-C5 -->
							<div class="col-md-6">

								<?php foreach ($kriteria as $key): ?>

									<?php
									// Skip Kesesuaian Persyaratan Kerja (C5)
									if ($key->kode_kriteria == 'C5' || stripos($key->keterangan, 'Kesesuaian Persyaratan Kerja') !== false) {
										continue;
									}

									$sub_kriteria = $this->Penilaian_model->data_sub_kriteria($key->id_kriteria);
									?>

									<?php if ($sub_kriteria != NULL): ?>

										<input type="hidden" name="id_kriteria[]" value="<?= $key->id_kriteria ?>">

										<div class="form-group">

											<label class="font-weight-bold">
												<?= $key->keterangan ?>
											</label>

											<select name="nilai[]" class="form-control" required>
												<option value="">-- Pilih --</option>

												<?php foreach ($sub_kriteria as $subs_kriteria): ?>

													<?php
													$s_option = $this->Penilaian_model->data_penilaian(
														$keys->id_alternatif,
														$subs_kriteria['id_kriteria']
													);
													?>

													<option value="<?= $subs_kriteria['id_sub_kriteria'] ?>"
														<?php
														if (!empty($s_option) && $subs_kriteria['id_sub_kriteria'] == $s_option['nilai']) {
															echo "selected";
														}
														?>>
														<?= $subs_kriteria['deskripsi'] ?>
													</option>

												<?php endforeach; ?>

											</select>

										</div>

									<?php endif; ?>

								<?php endforeach; ?>

							</div>

						</div>

						<div class="modal-footer px-0 pb-0 mt-3">
							<button type="button" class="btn btn-secondary" data-dismiss="modal">
								Tutup
							</button>
							<button type="button" class="btn btn-primary" onclick="goToStep(<?= $keys->id_alternatif ?>, 2, 'edit')">
								Lanjut ke Soal Wawancara <i class="fa fa-arrow-right ml-1"></i>
							</button>
						</div>

					</div>

					<!-- STEP 2: SOAL WAWANCARA -->
					<div id="step2_edit<?= $keys->id_alternatif ?>" style="display:none;">

						<div class="alert alert-info">
							<i class="fas fa-info-circle mr-1"></i> Ubah jawaban pertanyaan wawancara di bawah ini. Nilai Kesesuaian Persyaratan Kerja akan diperbarui secara otomatis.
						</div>

						<div class="card card-body shadow-sm mb-3">
							<?php if (!empty($soal_wawancara)): ?>
								<?php foreach ($soal_wawancara as $idx => $s): ?>
									<?php
									$current_val = isset($existing_jawaban[$s->id_soal]) ? $existing_jawaban[$s->id_soal] : null;
									?>
									<div class="form-group <?= ($idx < count($soal_wawancara) - 1) ? 'border-bottom pb-3' : '' ?>">
										<label class="font-weight-bold text-dark">
											<?= ($idx + 1) . '. ' . htmlspecialchars($s->pertanyaan) ?>
										</label>

										<div class="mt-1">
											<div class="custom-control custom-radio custom-control-inline">
												<input type="radio"
													id="edit_ya_<?= $keys->id_alternatif ?>_<?= $s->id_soal ?>"
													name="jawaban_soal[<?= $s->id_soal ?>]"
													value="1"
													class="custom-control-input"
													<?= ($current_val == 1) ? 'checked' : '' ?>
													required>
												<label class="custom-control-label text-success font-weight-bold" for="edit_ya_<?= $keys->id_alternatif ?>_<?= $s->id_soal ?>">
													<i class="fa fa-check-circle"></i> Ya / Sesuai
												</label>
											</div>

											<div class="custom-control custom-radio custom-control-inline">
												<input type="radio"
													id="edit_tidak_<?= $keys->id_alternatif ?>_<?= $s->id_soal ?>"
													name="jawaban_soal[<?= $s->id_soal ?>]"
													value="0"
													class="custom-control-input"
													<?= ($current_val === '0' || $current_val === 0) ? 'checked' : '' ?>
													required>
												<label class="custom-control-label text-danger font-weight-bold" for="edit_tidak_<?= $keys->id_alternatif ?>_<?= $s->id_soal ?>">
													<i class="fa fa-times-circle"></i> Tidak / Tidak Sesuai
												</label>
											</div>
										</div>
									</div>
								<?php endforeach; ?>
							<?php else: ?>
								<div class="alert alert-warning mb-0">
									Belum ada master soal wawancara. Silakan tambahkan soal melalui menu Master Soal Wawancara.
								</div>
							<?php endif; ?>
						</div>

						<div class="modal-footer px-0 pb-0 mt-3">
							<button type="button" class="btn btn-secondary" onclick="goToStep(<?= $keys->id_alternatif ?>, 1, 'edit')">
								<i class="fa fa-arrow-left mr-1"></i> Kembali
							</button>

							<button type="submit" class="btn btn-success">
								<i class="fa fa-save"></i> Update Penilaian
							</button>
						</div>

					</div>

				</div>

				</form>

			</div>

		</div>

	</div>

<?php endforeach; ?>

<script>
function goToStep(id_alternatif, step, mode) {
    if (step === 2) {
        var step1 = document.getElementById('step1_' + mode + id_alternatif);
        if (step1) {
            var selects = step1.querySelectorAll('select[required]');
            for (var i = 0; i < selects.length; i++) {
                if (!selects[i].checkValidity()) {
                    selects[i].reportValidity();
                    return false;
                }
            }
        }

        $('#step1_' + mode + id_alternatif).hide();
        $('#step2_' + mode + id_alternatif).show();

        $('#step1-tab-' + mode + id_alternatif).removeClass('active').addClass('text-secondary');
        $('#step2-tab-' + mode + id_alternatif).removeClass('text-secondary').addClass('active btn-danger text-white');
    } else {
        $('#step2_' + mode + id_alternatif).hide();
        $('#step1_' + mode + id_alternatif).show();

        $('#step2-tab-' + mode + id_alternatif).removeClass('active btn-danger text-white').addClass('text-secondary');
        $('#step1-tab-' + mode + id_alternatif).removeClass('text-secondary').addClass('active');
    }
}

$(document).ready(function() {
    $('.modal form').on('submit', function(e) {
        var form = this;
        var modal = $(form).closest('.modal');
        var modalId = modal.attr('id');
        
        if (!modalId) return;
        
        var mode = modalId.startsWith('set') ? 'set' : (modalId.startsWith('edit') ? 'edit' : '');
        var id_alternatif = modalId.replace(mode, '');
        
        if (mode && id_alternatif) {
            var step1 = document.getElementById('step1_' + mode + id_alternatif);
            if (step1) {
                var selects = step1.querySelectorAll('select[required]');
                for (var i = 0; i < selects.length; i++) {
                    if (!selects[i].value) {
                        e.preventDefault();
                        goToStep(id_alternatif, 1, mode);
                        selects[i].reportValidity();
                        return false;
                    }
                }
            }
        }
    });
});
</script>

<?php $this->load->view('layouts/footer_admin'); ?>