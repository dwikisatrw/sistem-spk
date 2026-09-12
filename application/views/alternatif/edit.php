<?php $this->load->view('layouts/header_admin'); ?>

<div class="d-sm-flex align-items-center justify-content-between mb-4">
	<h1 class="h3 mb-0 text-gray-800">
		<i class="fas fa-fw fa-users"></i> Data Alternatif
	</h1>

	<a href="<?= base_url('Alternatif'); ?>" class="btn btn-secondary btn-icon-split">
		<span class="icon text-white-50">
			<i class="fas fa-arrow-left"></i>
		</span>
		<span class="text">Kembali</span>
	</a>
</div>

<?= $this->session->flashdata('message'); ?>

<div class="card shadow mb-4">

	<div class="card-header py-3">
		<h6 class="m-0 font-weight-bold text-danger">
			<i class="fas fa-fw fa-edit"></i> Edit Data Calon Karyawan (Alternatif)
		</h6>
	</div>

	<!-- gunakan multipart -->
	<?php echo form_open_multipart('Alternatif/update/' . $alternatif->id_alternatif); ?>

	<div class="card-body">
		<div class="row">

			<?php echo form_hidden('id_alternatif', $alternatif->id_alternatif) ?>

			<div class="form-group col-md-12">
				<label class="font-weight-bold">Nama Alternatif</label>

				<input
					autocomplete="off"
					type="text"
					name="nama"
					value="<?php echo $alternatif->nama ?>"
					required
					class="form-control" />
			</div>

			<div class="form-group col-md-12">
				<label class="font-weight-bold">Nomor Telepon</label>

				<input
					autocomplete="off"
					type="number"
					name="telepon"
					value="<?php echo $alternatif->telepon ?>"
					required
					class="form-control" />
			</div>

			<!-- upload pdf -->
			<div class="form-group col-md-12">
				<label class="font-weight-bold">Upload File PDF</label>

				<input
					type="file"
					name="file_pdf"
					accept=".pdf"
					class="form-control" />

				<small class="text-muted">
					Format file harus PDF
				</small>
			</div>

			<!-- preview pdf -->
			<?php if (!empty($alternatif->file_pdf)) : ?>

				<div class="col-md-12 mt-3">

					<h5 class="font-weight-bold text-center mb-3">
						CV - <?= $alternatif->nama ?>
					</h5>

					<iframe
						src="<?= base_url('uploads/pdf/' . $alternatif->file_pdf); ?>#toolbar=0"
						width="100%"
						height="600px"
						style="border:1px solid #ccc; border-radius:5px;">
					</iframe>

				</div>

			<?php endif; ?>

		</div>
	</div>

	<div class="card-footer text-right">

		<button type="submit" class="btn btn-success">
			<i class="fa fa-save"></i> Simpan
		</button>

		<button type="reset" class="btn btn-info">
			<i class="fa fa-sync-alt"></i> Reset
		</button>

	</div>

	<?php echo form_close() ?>

</div>

<?php $this->load->view('layouts/footer_admin'); ?>