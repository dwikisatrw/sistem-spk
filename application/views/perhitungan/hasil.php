<?php $this->load->view('layouts/header_admin'); ?>

<div class="d-sm-flex align-items-center justify-content-between mb-4">
	<h1 class="h3 mb-0 text-gray-800"><i class="fas fa-fw fa-chart-area"></i> Data Hasil Akhir</h1>

	<a href="<?= base_url('Laporan'); ?>" class="btn btn-primary"> <i class="fa fa-print"></i> Cetak Data </a>
</div>

<div class="card shadow mb-4">
	<!-- /.card-header -->
	<div class="card-header py-3">
		<h6 class="m-0 font-weight-bold text-danger"><i class="fa fa-table"></i> Hasil Akhir Perangkingan</h6>
	</div>

	<div class="card-body">
		<div class="table-responsive">
			<table class="table table-bordered" width="100%" cellspacing="0">
				<thead class="bg-danger text-white">
					<tr align="center">
						<th>Nama Calon Karyawan (Alternatif)</th>
						<th>Nilai Akhir</th>
						<th width="15%">Rank</th>
					</tr>
				</thead>
				<tbody>
					<?php
					$no = 1;

					foreach ($hasil as $keys):

						$cek_belum_lengkap = $this->db
							->select('penilaian.*')
							->from('penilaian')
							->join(
								'sub_kriteria',
								'sub_kriteria.id_sub_kriteria = penilaian.nilai'
							)
							->where('penilaian.id_alternatif', $keys->id_alternatif)
							->where('sub_kriteria.nilai', 0)
							->get()
							->num_rows();

						// jika masih ada data belum lengkap
						if ($cek_belum_lengkap > 0) {
							continue;
						}
					?>

						<tr align="center">
							<td align="left"><?= $keys->nama ?></td>
							<td><?= $keys->nilai ?></td>
							<td><?= $no; ?></td>
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

<?php
$this->load->view('layouts/footer_admin');
?>