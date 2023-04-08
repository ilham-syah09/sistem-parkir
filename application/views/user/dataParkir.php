<!-- page content -->
<div class="right_col" role="main">
	<div class="row">
		<div class="col-sm-12">
			<div class="card">
				<div class="card-header">
					<h4>Parkir hari ini - <?= hari(date('N')) . ', ' . date('d M Y'); ?></h4>
				</div>
				<div class="card-body">
					<div class="table-responsive">
						<table class="table table-bordered table-hover">
							<thead class="bg-info">
								<tr>
									<th>Parkir Masuk</th>
									<th>Parkir Pulang</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<?php if ($dataParkirHariIni) : ?>
										<?php if ($dataParkirHariIni->parkirMasuk != null && $dataParkirHariIni->parkirKeluar != null) : ?>
											<td>
												<a href="#" class="badge badge-info" data-toggle="modal" data-target="#modalScan" data-title="Scan" id="btn-scan" data-typescan="Masuk">Scan</a>
											</td>
											<td></td>
										<?php else : ?>
											<td></td>
											<td>
												<?php if ($dataParkirHariIni->parkirMasuk != null) : ?>
													<a href="#" class="badge badge-info" data-toggle="modal" data-target="#modalScan" data-title="Scan" id="btn-scan" data-typeScan="Keluar">Scan</a>
												<?php endif; ?>
											</td>
										<?php endif; ?>
									<?php else : ?>
										<td>
											<a href="#" class="badge badge-info" data-toggle="modal" data-target="#modalScan" data-title="Scan" id="btn-scan" data-typescan="Masuk">Scan</a>
										</td>
										<td></td>
									<?php endif; ?>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
		<div class="col-sm-4 col-xl-4">
			<div class="form-group">
				<label for="by_tahun">Tahun</label>
				<select class="js-select2 form-control" name="by_tahun" id="by_tahun">
					<option value="">-- Pilih Tahun --</option>
					<?php foreach ($tahun as $th) : ?>
						<option value="<?= $th->tahun; ?>" <?= ($th->tahun == $th_ini) ? 'selected' : ''; ?>>
							<?= $th->tahun; ?></option>
					<?php endforeach; ?>
				</select>
			</div>
		</div>
		<div class="col-sm-4 col-xl-4">
			<div class="form-group">
				<label for="by_tahun">Bulan</label>
				<select class="js-select2 form-control" name="by_bulan" id="by_bulan">
					<option value="">-- Pilih Bulan --</option>
					<?php foreach (range(1, 12) as $bulan) : ?>
						<option value="<?= $bulan; ?>" <?= ($bulan == $bln_ini) ? 'selected' : ''; ?>>
							<?= bulan($bulan); ?></option>
					<?php endforeach; ?>
				</select>
			</div>
		</div>
		<div class="col-lg-12">
			<div class="card">
				<div class="card-header">
					<h4>Riwayat Presensi</h4>
				</div>
				<div class="card-body">
					<div class="table-responsive">
						<table class="table table-bordered table-hover" id="example">
							<thead class="bg-info">
								<tr>
									<th>#</th>
									<th>Tanggal</th>
									<th>Parkir Masuk</th>
									<th>Parkir Keluar</th>
									<th>Metode</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody>
								<?php $i = 1;
								foreach ($dataParkir as $data) : ?>
									<tr>
										<td><?= $i++; ?></td>
										<td><?= date('d M Y', strtotime($data->tanggal)); ?></td>
										<td>
											<span class="badge badge-success"><?= $data->parkirMasuk; ?></span>
										</td>
										<td>
											<?php if ($data->parkirKeluar == null) : ?>
												<span class="badge badge-warning">Belum Keluar</span>
											<?php else : ?>
												<span class="badge badge-success"><?= $data->parkirKeluar; ?></span>
											<?php endif; ?>
										</td>
										<td><?= $data->metode; ?></td>
										<td>
											<a href="<?= base_url('user/data/detail/') . $data->id; ?>" class="badge badge-warning" data-toggle="tooltip" data-title="Detail">Detail</a>
										</td>
									</tr>
								<?php endforeach; ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- /page content -->

<!-- modal presensi -->
<div class="modal fade" id="modalScan" tabindex="-1" role="dialog" aria-labelledby="modalScan" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="headerScan"></h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="card card-default">
					<div class="card-body">
						<div class="alert alert-info text-center mb-3">
							<i class="fa fa-warning"></i> Untuk menggunakan scan QR Code, izinkan halaman ini mengakses kamera Anda
						</div>

						<video id="lihat_kamera" class="mb-2" poster="<?= base_url(); ?>assets/img/kamera.png" style="object-fit: cover; width:100%; max-height: 300px;">
							Browser Anda tidak mendukung pemindai kode QR.
						</video>

						<button type="button" id="ganti_kamera" class="btn btn-block btn-default" value="depan">
							<i class="fa fa-camera mr-2"></i> Ganti Kamera
						</button>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-danger" data-dismiss="modal" id="close">Close</button>
			</div>
		</div>
	</div>
</div>

<script src="<?= base_url(); ?>assets/vendors/instascan/instascan.min.js"></script>

<script>
	$('#by_tahun').change(function() {
		let tahun = $(this).find(':selected').val();

		if (tahun === '') {
			return 0;
		}

		document.location.href = `<?php echo base_url('user/data/') ?>${tahun}`;
	});

	$('#by_bulan').change(function() {
		let tahun = $('#by_tahun').find(':selected').val();
		let bulan = $(this).find(':selected').val();

		if (bulan === '') {
			return 0;
		}

		document.location.href = `<?php echo base_url('user/data/') ?>${tahun}/${bulan}`;
	});

	var scanner;

	$('#btn-scan').click(function() {
		let typeScan = $(this).data('typescan');

		$('#typeScan').val(typeScan);

		if (typeScan === 'Masuk') {
			$('#headerScan').text('Parkir Masuk');
		} else {
			$('#headerScan').text('Parkir Keluar');
		}

		scanner = new Instascan.Scanner({
			video: document.getElementById('lihat_kamera'),
			mirror: false
		});

		scanner.addListener('scan', function(content) {
			if (content.includes('<?php echo base_url(); ?>')) {
				window.location = content;
			} else {
				alert("Bukan kode QR Sistem Parkir");
			}
		});

		Instascan.Camera.getCameras().then(function(cameras) {
			if (cameras.length > 0) {
				if (cameras[1]) {
					scanner.start(cameras[1]);
				} else {
					scanner.start(cameras[0]);
				}

				$("#ganti_kamera").on("click", function() {
					if ($("#ganti_kamera").val() == "depan") {
						if (cameras[0] != "") {
							scanner.start(cameras[0]);
						} else {
							alert("Kamera tidak dapat diakses");
						}

						$("#ganti_kamera").val("belakang");
					} else if ($("#ganti_kamera").val() == "belakang") {
						if (cameras[1] != "") {
							scanner.start(cameras[1]);
						} else {
							alert("Kamera tidak dapat diakses");
						}

						$("#ganti_kamera").val("depan");
					}
				});
			} else {
				alert("Kamera tidak dapat diakses");
				$("#ganti_kamera").hide();
			}
		});
	});

	$('#close').click(function() {
		scanner.stop();
	});
</script>