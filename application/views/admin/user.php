<!-- page content -->
<div class="right_col" role="main">
	<div class="row">
		<div class="col-lg-12">
			<div class="card">
				<div class="card-header">
					<a href="#" class="btn btn-primary" data-toggle="modal" data-target="#addUser">Add User</a>
				</div>
				<div class="card-body">
					<div class="table-responsive">
						<table class="table table-bordered table-hover" id="example">
							<thead>
								<tr>
									<th class="text-center">#</th>
									<th>Nama</th>
									<th>NIM</th>
									<th>Email</th>
									<th>Level</th>
									<th>No. Kartu</th>
									<th>Password</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody>
								<?php $i = 1;
								foreach ($user as $u) : ?>
									<tr>
										<td class="text-center"><?= $i++; ?></td>
										<td><?= $u->nama; ?></td>
										<td><?= $u->nim; ?></td>
										<td><?= $u->email; ?></td>
										<td><?= $u->level; ?></td>
										<td><?= $u->noKartu; ?></td>
										<td>
											<?php if (password_verify('user123', $u->password)) : ?>
												<span class="badge badge-warning">Default</span>
											<?php else : ?>
												<span class="badge badge-success">Custom</span>
											<?php endif; ?>
										</td>
										<td>
											<a href="#" class="badge badge-warning edit_btn" data-toggle="modal" data-target="#editUser" data-id="<?= $u->id; ?>" data-nama="<?= $u->nama; ?>" data-nim="<?= $u->nim; ?>" data-email="<?= $u->email; ?>" data-jk="<?= $u->jk; ?>" data-level="<?= $u->level; ?>" data-nokartu="<?= $u->noKartu; ?>">Edit</a>
											<a href="<?= base_url('admin/user/delete/' . $u->id); ?>" onclick="return confirm('Apakah anda yakin ingin menghapus data ini ?')" class="badge badge-danger">Delete</a>
											<a href="<?= base_url('admin/user/resetPwd/' . $u->id); ?>" onclick="return confirm('Apakah anda yakin ingin reset password?')" class="badge badge-dark">reset pwd</a>
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

<!-- modal add -->
<div class="modal fade" id="addUser" tabindex="-1" role="dialog" aria-labelledby="addUser" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Tambah User</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form id="basic-form" action="<?= base_url('admin/user/add'); ?>" method="post">
					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<label>Nama User</label>
								<input type="text" class="form-control" name="nama" required>
							</div>
							<div class="form-group">
								<label>NIM</label>
								<input type="text" class="form-control" name="nim" required>
							</div>
							<div class="form-group">
								<label>Email</label>
								<input type="email" class="form-control" name="email" required>
							</div>
							<div class="form-group">
								<label>Jenis Kelamin</label>
								<select name="jk" class="form-control" required>
									<option value="">-- Pilih Jenis Kelamin --</option>
									<option value="1">Laki - laki</option>
									<option value="2">Perempuan</option>
								</select>
							</div>
							<div class="form-group">
								<label>Level</label>
								<select name="level" class="form-control" required>
									<option value="">-- Pilih Level --</option>
									<option value="Karyawan">Karyawan</option>
									<option value="Mahasiswa">Mahasiswa</option>
									<option value="Tamu">Tamu</option>
								</select>
							</div>
							<div class="form-group">
								<label>No. Kartu</label>
								<input type="text" class="form-control" name="noKartu" required>
							</div>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
						<button type="submit" class="btn btn-primary">Save changes</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

<!-- modal edit -->
<div class="modal fade" id="editUser" tabindex="-1" role="dialog" aria-labelledby="editUser" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Edit User</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form action="<?= base_url('admin/user/edit'); ?>" method="post">
				<div class="modal-body">
					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<label>Nama User</label>
								<input type="hidden" name="id_user" id="id_user">
								<input type="text" class="form-control" name="nama" id="nama">
							</div>
							<div class="form-group">
								<label>NIM</label>
								<input type="text" class="form-control" name="nim" id="nim">
							</div>
							<div class="form-group">
								<label>Email</label>
								<input type="email" class="form-control" name="email" id="email">
							</div>
							<div class="form-group">
								<label>Jenis Kelamin</label>
								<select name="jk" class="form-control" id="jk">
									<option value="">-- Pilih Jenis Kelamin --</option>
									<option value="1">Laki - laki</option>
									<option value="2">Perempuan</option>
								</select>
							</div>
							<div class="form-group">
								<label>Level</label>
								<select name="level" class="form-control" id="level">
									<option value="">-- Pilih Level --</option>
									<option value="Karyawan">Karyawan</option>
									<option value="Mahasiswa">Mahasiswa</option>
									<option value="Tamu">Tamu</option>
								</select>
							</div>
							<div class="form-group">
								<label>No. Kartu</label>
								<input type="text" class="form-control" name="noKartu" id="noKartu" readonly>
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-primary">Save changes</button>
				</div>
			</form>
		</div>
	</div>
</div>

<script>
	let edit_btn = $('.edit_btn');

	$(edit_btn).each(function(i) {
		$(edit_btn[i]).click(function() {
			let id = $(this).data('id');
			let nama = $(this).data('nama');
			let nim = $(this).data('nim');
			let email = $(this).data('email');
			let jk = $(this).data('jk');
			let level = $(this).data('level');
			let noKartu = $(this).data('nokartu');

			$('#id_user').val(id);
			$('#nama').val(nama);
			$('#nim').val(nim);
			$('#email').val(email);
			$('#jk').val(jk);
			$('#level').val(level);
			$('#noKartu').val(noKartu);
		});
	});
</script>