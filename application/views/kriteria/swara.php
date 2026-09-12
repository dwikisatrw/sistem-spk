<?php 
$this->load->view('layouts/header_admin'); 

$rank=1;
$total_rank = 0;
$total_kriteria = count($list);
foreach ($list as $data) {
$total_rank += $rank;
$rank++;	
}
$rata_rank = $total_rank/$total_kriteria;

$data_sj = array();
$data_kj = array();
$no=1;
for ($i = 0; $i < count($list); $i++) {
	$sj = $i/$rata_rank;
	$kj = $sj+1;
	$data_sj[$no] = $sj;
	$data_kj[$no] = $kj;
	$no++;
}

$data_qi = array();
foreach ($data_kj as $no => $x) { if ($no == "1"){ $n1= 1/$x; $data_qi[$no] = $n1; foreach ($data_kj as $no => $x) { if ($no == "2"){ $n2 = $n1/$x; $data_qi[$no] = $n2; foreach ($data_kj as $no => $x) { if ($no == "3"){ $n3 = $n2/$x; $data_qi[$no] = $n3; foreach ($data_kj as $no => $x) { if ($no == "4"){ $n4 = $n3/$x; $data_qi[$no] = $n4; foreach ($data_kj as $no => $x) { if ($no == "5"){ $n5 = $n4/$x; $data_qi[$no] = $n5; foreach ($data_kj as $no => $x) { if ($no == "6"){ $n6 = $n5/$x; $data_qi[$no] = $n6; foreach ($data_kj as $no => $x) { if ($no == "7"){ $n7 = $n6/$x; $data_qi[$no] = $n7; foreach ($data_kj as $no => $x) { if ($no == "8"){ $n8 = $n7/$x; $data_qi[$no] = $n8; foreach ($data_kj as $no => $x) { if ($no == "9"){ $n9 = $n8/$x; $data_qi[$no] = $n9; foreach ($data_kj as $no => $x) { if ($no == "10"){ $n10 = $n9/$x; $data_qi[$no] = $n10; foreach ($data_kj as $no => $x) { if ($no == "11"){ $n11 = $n10/$x; $data_qi[$no] = $n11; foreach ($data_kj as $no => $x) { if ($no == "12"){ $n12 = $n11/$x; $data_qi[$no] = $n12; foreach ($data_kj as $no => $x) { if ($no == "13"){ $n13 = $n12/$x; $data_qi[$no] = $n13; foreach ($data_kj as $no => $x) { if ($no == "14"){ $n14 = $n13/$x; $data_qi[$no] = $n14; foreach ($data_kj as $no => $x) { if ($no == "15"){ $n15 = $n14/$x; $data_qi[$no] = $n15; foreach ($data_kj as $no => $x) { if ($no == "16"){ $n16 = $n15/$x; $data_qi[$no] = $n16; foreach ($data_kj as $no => $x) { if ($no == "17"){ $n17 = $n16/$x; $data_qi[$no] = $n17; foreach ($data_kj as $no => $x) { if ($no == "18"){ $n18 = $n17/$x; $data_qi[$no] = $n18; foreach ($data_kj as $no => $x) { if ($no == "19"){ $n19 = $n18/$x; $data_qi[$no] = $n19; foreach ($data_kj as $no => $x) { if ($no == "20"){ $n20 = $n19/$x; $data_qi[$no] = $n20; foreach ($data_kj as $no => $x) { if ($no == "21"){ $n21 = $n20/$x; $data_qi[$no] = $n21; foreach ($data_kj as $no => $x) { if ($no == "22"){ $n22 = $n21/$x; $data_qi[$no] = $n22; foreach ($data_kj as $no => $x) { if ($no == "23"){ $n23 = $n22/$x; $data_qi[$no] = $n23; foreach ($data_kj as $no => $x) { if ($no == "24"){ $n24 = $n23/$x; $data_qi[$no] = $n24; foreach ($data_kj as $no => $x) { if ($no == "25"){ $n25 = $n24/$x; $data_qi[$no] = $n25; } } } } } } } } } } } } } } } } } } } } } } } } } } } } } } } } } } } } } } } } } } } } } } } } } }

$total_qi = 0;
foreach ($data_qi as $no => $x) {
	$total_qi += $x;
}

$data_wi = array();
foreach ($data_qi as $no => $x) {
	$data_wi[$no] = $x/$total_qi;
}

$total_wi = 0;
foreach ($data_wi as $no => $x) {
	$total_wi += $x;
}
?>

<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800"><i class="fas fa-fw fa-cube"></i> Data Kriteria</h1>

    <a href="<?= base_url('Kriteria'); ?>" class="btn btn-secondary btn-icon-split"><span class="icon text-white-50"><i class="fas fa-arrow-left"></i></span>
		<span class="text">Kembali</span>
	</a>
</div>

<div class="alert alert-info">
	Proses pembobotan dengan metode SWARA berhasil dilakukan.
</div>

<div class="card shadow mb-4">
    <!-- /.card-header -->
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-danger"><i class="fa fa-table"></i> Penentuan Bobot Menggunakan Metode SWARA</h6>
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
						<th>Rank Awal</th>
						<th>Sj</th>
						<th>Kj</th>
						<th>Qi</th>
						<th>Wi (Bobot SWARA)</th>
					</tr>
				</thead>
				<tbody>
					<?php
						$no=1;
						foreach ($list as $data => $value) {
					?>
					<tr align="center">
						<td><?=$no ?></td>
						<td><?php echo $value->kode_kriteria ?></td>
						<td><?php echo $value->keterangan ?></td>
						<td><?php echo $value->bobot_awal ?></td>
						<td><?php echo $no ?></td>
						<td><?= $data_sj[$no] ?></td>
						<td><?= $data_kj[$no] ?></td>
						<td><?= $data_qi[$no] ?></td>
						<td class="bg-light"><b><?= $data_wi[$no] ?></b></td>
					</tr>
					<?php
						$data = array(
							'bobot_swara' => $data_wi[$no],
						);
						$this->Kriteria_model->update_bobot($value->id_kriteria, $data);
						$no++;
						}
					?>
					<tr align="center">
						<th class="bg-light" colspan='4'>Rata-rata rank awal</th>
						<th class="bg-light"><?php echo $rata_rank; ?></th>
						<th class="bg-light" colspan='2'></th>
						<th class="bg-light"><?php echo $total_qi; ?></th>
						<th class="bg-light"><?php echo $total_wi; ?></th>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
</div>


<?php $this->load->view('layouts/footer_admin'); ?>