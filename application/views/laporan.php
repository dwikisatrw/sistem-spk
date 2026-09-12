<!DOCTYPE html>
<html>

<head>
	<title>Sistem Pendukung Keputusan Metode SWARA SMART</title>
</head>
<style>
	table {
		border-collapse: collapse;
	}

	table,
	th,
	td {
		border: 1px solid black;
	}
</style>

<body>
	<h4>Hasil Akhir Perangkingan</h4>
	<table border="1" width="100%">
		<thead>
			<tr align="center">
				<th>Alternatif</th>
				<th>Nilai</th>
				<th width="15%">Rank</th>
			</tr>
		</thead>
		<tbody>
			<?php
			$no = 1;

			foreach ($hasil as $keys):

				$tampil = true;

				$penilaian = $this->db
					->get_where(
						'penilaian',
						['id_alternatif' => $keys->id_alternatif]
					)
					->result();

				foreach ($penilaian as $p) {

					$sub = $this->db
						->get_where(
							'sub_kriteria',
							['id_sub_kriteria' => $p->nilai]
						)
						->row();

					if ($sub && $sub->nilai == 0) {
						$tampil = false;
						break;
					}
				}

				if ($tampil):
			?>

					<tr align="center">
						<td align="left"><?= $keys->nama ?></td>
						<td><?= $keys->nilai ?></td>
						<td><?= $no; ?></td>
					</tr>

			<?php
					$no++;
				endif;

			endforeach;
			?>
		</tbody>
	</table>
	<script>
		window.print();
	</script>
</body>

</html>