<!-- page content -->
<div class="right_col" role="main">
	<div class="row mb-3 text-right">
		<div class="col-xl-12">
			<a href="<?= base_url('admin/data/') . $url; ?>" class="btn btn-primary">Kembali</a>
		</div>
	</div>
	<div class="row">
		<div class="col-lg-12">
			<div class="card">
				<div class="card-header">
					<h4><?= date('d M Y', strtotime($tanggal)); ?></h4>
				</div>
				<div class="card-body">
					<div class="table-responsive">
						<table class="table table-bordered table-hover" id="examples">
							<thead class="bg-info">
								<tr>
									<th>Nama User</th>
									<th>Parkir Masuk</th>
									<th>Parkir Keluar</th>
									<th>Metode</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody>
								<?php foreach ($data_parkir as $data) : ?>
									<tr>
										<td><?= $data->nama; ?></td>
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
											<a href="<?= base_url('admin/data/detail/') . $data->id; ?>" class="badge badge-warning" data-toggle="tooltip" data-title="Detail">Detail</a>
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