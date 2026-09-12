<?php
$this->load->view('layouts/header_admin');
//Matrix Keputusan (X)
$matriks_x = array();
foreach ($alternatifs as $alternatif):
	foreach ($kriterias as $kriteria):

		$id_alternatif = $alternatif->id_alternatif;
		$id_kriteria = $kriteria->id_kriteria;

		$data_pencocokan = $this->Perhitungan_model->data_nilai($id_alternatif, $id_kriteria);
		$nilai = $data_pencocokan['nilai'];

		$matriks_x[$id_kriteria][$id_alternatif] = $nilai;
	endforeach;
endforeach;

//Matrix Keputusan (X)
$nilai_u = array();
foreach ($alternatifs as $alternatif):
	foreach ($kriterias as $kriteria):

		$id_alternatif = $alternatif->id_alternatif;
		$id_kriteria = $kriteria->id_kriteria;
		$type_kriteria = $kriteria->jenis;

		$x = $matriks_x[$id_kriteria][$id_alternatif];
		$min = min($matriks_x[$id_kriteria]);
		$max = max($matriks_x[$id_kriteria]);

		// if($type_kriteria == "Cost") {
		// 	$u = ($max-$x)/($max-$min);
		// }else{
		// 	$u = ($x-$min)/($max-$min);
		// }

		$pembagi = ($max - $min);

		if ($pembagi != 0) {

			if ($type_kriteria == "Cost") {
				$u = ($max - $x) / $pembagi;
			} else {
				$u = ($x - $min) / $pembagi;
			}
		} else {
			$u = 0;
		}

		$nilai_u[$id_kriteria][$id_alternatif] = $u;
	endforeach;
endforeach;

//Perhitungan nilai akhir
$nilai_ub = array();
$nilai_akhir = array();
foreach ($alternatifs as $alternatif):
	$total = 0;
	$id_alternatif = $alternatif->id_alternatif;
	foreach ($kriterias as $kriteria):

		$bobot = $kriteria->bobot_swara;
		$id_kriteria = $kriteria->id_kriteria;

		$u = $nilai_u[$id_kriteria][$id_alternatif];
		$ub = $bobot * $u;
		$nilai_ub[$id_kriteria][$id_alternatif] = $ub;
		$total += $ub;
	endforeach;
	$nilai_akhir[$id_alternatif] = $total;
endforeach;
?>

<div class="d-sm-flex align-items-center justify-content-between mb-4">
	<h1 class="h3 mb-0 text-gray-800"><i class="fas fa-fw fa-calculator"></i> Data Perhitungan</h1>
</div>

<div class="alert alert-danger text-justify">
	Bobot kriteria didapatkan dari perhitungan menggunakan metode <b>SWARA</b>. Silahkan menuju ke halaman <a href="<?= base_url('') ?>Kriteria/swara" class="btn btn-info">Pembobotan SWARA</a> untuk melihat proses perhitungan metode SWARA.
</div>

<div class="card shadow mb-4">
	<!-- /.card-header -->
	<div class="card-header py-3">
		<h6 class="m-0 font-weight-bold text-danger"><i class="fa fa-table"></i> Bobot Preferensi (W)</h6>
	</div>

	<div class="card-body">
		<div class="table-responsive">
			<table class="table table-bordered" width="100%" cellspacing="0">
				<thead class="bg-danger text-white">
					<tr align="center">
						<th width="5%">No</th>
						<th>Kode Kriteria</th>
						<th>Nama Kriteria</th>
						<th>Bobot Awal</th>
						<th>Bobot SWARA</th>
						<th>Jenis</th>
					</tr>
				</thead>
				<tbody>
					<?php
					$no = 1;
					foreach ($kriterias as $value) {
					?>
						<tr align="center">
							<td><?= $no ?></td>
							<td><?php echo $value->kode_kriteria ?></td>
							<td><?php echo $value->keterangan ?></td>
							<td><?php echo $value->bobot_awal ?></td>
							<td>
								<?php
								if ($value->bobot_swara == NULL) {
									echo "-";
								} elseif ($value->bobot_swara == "0") {
									echo "-";
								} else {
									echo $value->bobot_swara;
								}
								?>
							</td>
							<td><?php echo $value->jenis ?></td>
						</tr>
					<?php
						$no++;
					}
					?>
				</tbody>
			</table>
		</div>
	</div>
</div>

<div class="card shadow mb-4">
	<!-- /.card-header -->
	<div class="card-header py-3">
		<h6 class="m-0 font-weight-bold text-danger"><i class="fa fa-table"></i> Matrix Keputusan (X)</h6>
	</div>

	<div class="card-body">
		<div class="table-responsive">
			<table class="table table-bordered" width="100%" cellspacing="0">
				<thead class="bg-danger text-white">
					<tr align="center">
						<th width="5%" rowspan="2">No</th>
						<th>Nama Alternatif</th>
						<?php foreach ($kriterias as $kriteria): ?>
							<th><?= $kriteria->kode_kriteria ?></th>
						<?php endforeach ?>
					</tr>
				</thead>
				<tbody>
					<?php
					$no = 1;
					foreach ($alternatifs as $alternatif): ?>
						<tr align="center">
							<td><?= $no; ?></td>
							<td align="left"><?= $alternatif->nama ?></td>
							<?php
							foreach ($kriterias as $kriteria):
								$id_alternatif = $alternatif->id_alternatif;
								$id_kriteria = $kriteria->id_kriteria;
								echo '<td>';
								echo $matriks_x[$id_kriteria][$id_alternatif];
								echo '</td>';
							endforeach
							?>
						</tr>
					<?php
						$no++;
					endforeach
					?>
				</tbody>
			</table>
		</div>
	</div>
</div>

<div class="card shadow mb-4">
	<!-- /.card-header -->
	<div class="card-header py-3">
		<h6 class="m-0 font-weight-bold text-danger"><i class="fa fa-table"></i> Nilai Utility (U)</h6>
	</div>

	<div class="card-body">
		<div class="table-responsive">
			<table class="table table-bordered" width="100%" cellspacing="0">
				<thead class="bg-danger text-white">
					<tr align="center">
						<th width="5%" rowspan="2">No</th>
						<th>Nama Alternatif</th>
						<?php foreach ($kriterias as $kriteria): ?>
							<th><?= $kriteria->kode_kriteria ?></th>
						<?php endforeach ?>
					</tr>
				</thead>
				<tbody>
					<?php
					$no = 1;
					foreach ($alternatifs as $alternatif): ?>
						<tr align="center">
							<td><?= $no; ?></td>
							<td align="left"><?= $alternatif->nama ?></td>
							<?php
							foreach ($kriterias as $kriteria):
								$id_alternatif = $alternatif->id_alternatif;
								$id_kriteria = $kriteria->id_kriteria;
								echo '<td>';
								echo $nilai_u[$id_kriteria][$id_alternatif];
								echo '</td>';
							endforeach;
							?>
						</tr>
					<?php
						$no++;
					endforeach
					?>
				</tbody>
			</table>
		</div>
	</div>
</div>


<div class="card shadow mb-4">
	<!-- /.card-header -->
	<div class="card-header py-3">
		<h6 class="m-0 font-weight-bold text-danger"><i class="fa fa-table"></i> Perhitungan Nilai Akhir</h6>
	</div>

	<div class="card-body">
		<div class="table-responsive">
			<table class="table table-bordered" width="100%" cellspacing="0">
				<thead class="bg-danger text-white">
					<tr align="center">
						<th width="5%" rowspan="2">No</th>
						<th>Nama Alternatif</th>
						<?php foreach ($kriterias as $kriteria): ?>
							<th><?= $kriteria->kode_kriteria ?></th>
						<?php endforeach ?>
						<th>Total Nilai</th>
					</tr>
				</thead>
				<tbody>
					<?php
					$no = 1;
					$this->Perhitungan_model->hapus_hasil();
					foreach ($alternatifs as $alternatif):
						$id_alternatif = $alternatif->id_alternatif;
					?>
						<tr align="center">
							<td><?= $no; ?></td>
							<td align="left"><?= $alternatif->nama ?></td>
							<?php
							foreach ($kriterias as $kriteria):
								$id_kriteria = $kriteria->id_kriteria;
								echo '<td>';
								echo $nilai_ub[$id_kriteria][$id_alternatif];
								echo '</td>';
							endforeach;
							echo '<td>';
							echo $nilai_akhir[$id_alternatif];
							echo '</td>';
							?>
						</tr>
					<?php
						$no++;
						$hasil_akhir = [
							'id_alternatif' => $id_alternatif,
							'nilai' => $nilai_akhir[$id_alternatif]
						];
						$this->Perhitungan_model->insert_hasil($hasil_akhir);
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