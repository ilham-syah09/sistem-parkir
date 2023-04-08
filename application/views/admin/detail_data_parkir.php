<!-- page content -->
<div class="right_col" role="main">
	<div class="row mb-3 text-right">
		<div class="col-xl-12">
			<a href="<?= base_url('admin/data/list/') . $data_parkir->tanggal; ?>" class="btn btn-primary">Kembali</a>
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
						<div class="col-md-12 text-center mb-3">
							<img src="<?= base_url('upload/parkir/') . $data_parkir->pictureMasuk; ?>" alt="Picture Parkir Masuk" class="img-thumbnail" width="400">
						</div>
						<div class="col-md-12">
							<div class="table-responsive">
								<table class="table table-bordered" width="100%" cellspacing="0">
									<thead>
										<tr>
											<td>Metode</td>
											<td>:</td>
											<td><?= $data_parkir->metode; ?></td>
										</tr>
										<tr>
											<td>Parkir Masuk</td>
											<td>:</td>
											<td><?= $data_parkir->parkirMasuk; ?></td>
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
						<?php if ($data_parkir->parkirKeluar != null) : ?>
							<div class="col-md-12 text-center mb-3">
								<img src="<?= base_url('upload/parkir/') . $data_parkir->pictureKeluar; ?>" alt="Picture Parkir Keluar" class="img-thumbnail" width="400">
							</div>
							<div class="col-md-12">
								<div class="table-responsive">
									<table class="table table-bordered" width="100%" cellspacing="0">
										<thead>
											<tr>
												<td>Metode</td>
												<td>:</td>
												<td><?= $data_parkir->metode; ?></td>
											</tr>
											<tr>
												<td>Parkir Keluar</td>
												<td>:</td>
												<td><?= $data_parkir->parkirKeluar; ?></td>
											</tr>
										</thead>
									</table>
								</div>
							</div>
						<?php else : ?>
							<div class="col-md-12 bg-danger text-white p-3 text-center">
								<span class="h4">Belum Keluar</span>
							</div>
						<?php endif; ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- /page content -->