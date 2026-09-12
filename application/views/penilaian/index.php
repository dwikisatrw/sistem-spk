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
							$cek_tombol =
								$this->Penilaian_model
								->untuk_tombol($keys->id_alternatif);
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



<!-- ======================= MODAL ======================= -->

<?php foreach ($alternatif as $keys): ?>

	<!-- ======================= INPUT ======================= -->

	<div class="modal fade"
		id="set<?= $keys->id_alternatif ?>"
		tabindex="-1"
		role="dialog"
		aria-hidden="true">

		<div class="modal-dialog modal-xl"
			role="document">

			<div class="modal-content">

				<div class="modal-header">

					<h5 class="modal-title">
						<i class="fa fa-plus"></i>
						Input Penilaian - <?= $keys->nama ?>
					</h5>

					<button type="button"
						class="close"
						data-dismiss="modal">

						<span>&times;</span>

					</button>

				</div>

				<?= form_open('Penilaian/tambah_penilaian') ?>

				<div class="modal-body">
					<div class="row">

						<!-- PDF Preview -->
						<div class="col-md-6">

							<h6 class="font-weight-bold mb-3">
								<?= $keys->nama ?>
							</h6>

							<?php if (!empty($keys->file_pdf)) { ?>

								<iframe
									src="<?= base_url('uploads/pdf/' . $keys->file_pdf); ?>#toolbar=0"
									width="100%"
									height="600px"
									style="border:1px solid #ccc; border-radius:5px;">
								</iframe>

							<?php } else { ?>

								<div class="alert alert-warning">
									PDF belum tersedia
								</div>

							<?php } ?>

						</div>

						<!-- Form Penilaian -->
						<div class="col-md-6">

							<?php foreach ($kriteria as $key): ?>

								<?php
								$sub_kriteria = $this->Penilaian_model->data_sub_kriteria($key->id_kriteria);
								?>

								<?php if ($sub_kriteria != NULL): ?>

									<input type="hidden" name="id_alternatif" value="<?= $keys->id_alternatif ?>">
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
				</div>

				<div class="modal-footer">

					<button type="button"
						class="btn btn-secondary"
						data-dismiss="modal">

						Tutup

					</button>

					<button type="submit"
						class="btn btn-success">

						<i class="fa fa-save"></i>
						Simpan

					</button>

				</div>

				</form>

			</div>

		</div>

	</div>




	<!-- ======================= EDIT ======================= -->

	<div class="modal fade"
		id="edit<?= $keys->id_alternatif ?>"
		tabindex="-1"
		role="dialog"
		aria-hidden="true">

		<div class="modal-dialog modal-xl"
			role="document">

			<div class="modal-content">

				<div class="modal-header">

					<h5 class="modal-title">
						<i class="fa fa-edit"></i>
						Edit Penilaian - <?= $keys->nama ?>
					</h5>

					<button type="button"
						class="close"
						data-dismiss="modal">

						<span>&times;</span>

					</button>

				</div>

				<?= form_open('Penilaian/update_penilaian') ?>

				<div class="modal-body">

					<div class="row">

						<!-- PDF -->
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
									height="600px"
									style="border:1px solid #ccc; border-radius:5px;">
								</iframe>

							<?php else : ?>

								<div class="alert alert-warning">
									File PDF belum tersedia
								</div>

							<?php endif; ?>

						</div>



						<!-- FORM -->
						<div class="col-md-6">

							<input type="hidden"
								name="id_alternatif"
								value="<?= $keys->id_alternatif ?>">

							<?php foreach ($kriteria as $key): ?>

								<?php
								$sub_kriteria =
									$this->Penilaian_model
									->data_sub_kriteria($key->id_kriteria);
								?>

								<?php if ($sub_kriteria != NULL): ?>

									<input type="hidden"
										name="id_kriteria[]"
										value="<?= $key->id_kriteria ?>">

									<div class="form-group">

										<label class="font-weight-bold">
											<?= $key->keterangan ?>
										</label>

										<select name="nilai[]"
											class="form-control"
											required>

											<option value="">
												-- Pilih --
											</option>

											<?php foreach ($sub_kriteria as $subs_kriteria): ?>

												<?php
												$s_option =
													$this->Penilaian_model
													->data_penilaian(
														$keys->id_alternatif,
														$subs_kriteria['id_kriteria']
													);
												?>

												<option
													value="<?= $subs_kriteria['id_sub_kriteria'] ?>"

													<?php
													if (
														$subs_kriteria['id_sub_kriteria']
														== $s_option['nilai']
													) {
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

				</div>

				<div class="modal-footer">

					<button type="button"
						class="btn btn-secondary"
						data-dismiss="modal">

						Tutup

					</button>

					<button type="submit"
						class="btn btn-success">

						<i class="fa fa-save"></i>
						Update

					</button>

				</div>

				</form>

			</div>

		</div>

	</div>

<?php endforeach; ?>

<?php $this->load->view('layouts/footer_admin'); ?>