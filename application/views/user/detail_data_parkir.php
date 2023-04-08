<!-- page content -->
<div class="right_col" role="main">
	<div class="row mb-3 text-right">
		<div class="col-xl-12">
			<a href="<?= base_url('user/data/') . date('Y', strtotime($dataParkir[0]->tanggal)) . '/' . date('m', strtotime($dataParkir[0]->tanggal)); ?>" class="btn btn-primary">Kembali</a>
		</div>
	</div>
	<div class="row">
		<div class="col-lg-6">
			<div class="card">
				<div class="card-header">
					<h4>Parkir Masuk</h4>
				</div>
				<div class="card-body">
					<div class="row">
						<div class="col-md-12">
							<div class="col-md-12 text-center mb-3">
								<img src="<?= base_url('upload/parkir/') . $dataParkir[0]->pictureMasuk; ?>" alt="Picture Parkir Masuk" class="img-thumbnail" width="400">
							</div>
							<div class="table-responsive">
								<table class="table table-bordered" width="100%" cellspacing="0">
									<thead>
										<tr>
											<td>Keterangan</td>
											<td>:</td>
											<td><?= $dataParkir[0]->metode; ?></td>
										</tr>
										<tr>
											<td>Parkir Masuk</td>
											<td>:</td>
											<td><?= $dataParkir[0]->parkirMasuk; ?></td>
										</tr>
									</thead>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-lg-6">
			<div class="card">
				<div class="card-header">
					<h4>Parkir Keluar</h4>
				</div>
				<div class="card-body">
					<div class="row">
						<?php if ($dataParkir[0]->parkirKeluar != null) : ?>
							<div class="col-md-12">
								<div class="col-md-12 text-center mb-3">
									<img src="<?= base_url('upload/parkir/') . $dataParkir[0]->pictureKeluar; ?>" alt="Picture Parkir Masuk" class="img-thumbnail" width="400">
								</div>
								<div class="table-responsive">
									<table class="table table-bordered" width="100%" cellspacing="0">
										<thead>
											<tr>
												<td>Keterangan</td>
												<td>:</td>
												<td><?= $dataParkir[0]->metode; ?></td>
											</tr>
											<tr>
												<td>Parkir Masuk</td>
												<td>:</td>
												<td><?= $dataParkir[0]->parkirKeluar; ?></td>
											</tr>
										</thead>
									</table>
								</div>
							</div>
						<?php else : ?>
							<div class="col-md-12 bg-danger text-white p-3 text-center">
								<span class="h4">Belum keluar</span>
							</div>
						<?php endif; ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- /page content -->