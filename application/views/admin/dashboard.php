<!-- page content -->
<div class="right_col" role="main">
    <div class="row">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h4>Total User</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <label>Mahasiswa</label><br>
                            <h4><?= $mahasiswa; ?></h4>
                        </div>
                        <div class="col-md-4">
                            <label>Tamu</label><br>
                            <h4><?= $tamu; ?></h4>
                        </div>
                        <div class="col-md-4">
                            <label>Karyawan</label><br>
                            <h4><?= $karyawan; ?></h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h4>Scan</h4>
                </div>
                <div class="card-body">
                    <div class="col-md-4">
                        <label>QR Scan Masuk</label><br>
                        <a href="<?= base_url('scan/masuk'); ?>" target="_blank" class="btn btn-success">klik tombol ini </a>
                    </div>
                    <div class="col-md-4">
                        <label>QR Scan Keluar</label><br>
                        <a href="<?= base_url('scan/keluar'); ?>" target="_blank" class="btn btn-info">klik tombol ini </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h4>Setting</h4>
                </div>
                <div class="card-body">
                    <form action="<?= base_url('admin/home/updateSetting'); ?>" method="post">
                        <div class="row">
                            <div class="col-lg-6">
                                <input type="hidden" name="id" value="<?= $setting->id; ?>">
                                <div class="form-group">
                                    <label>Status</label>
                                    <select class="form-control" name="status">
                                        <option value="SCAN" <?= ($setting->status == 'SCAN') ? 'selected' : '' ?>>SCAN</option>
                                        <option value="REGISTRASI" <?= ($setting->status == 'REGISTRASI') ? 'selected' : '' ?>>REGISTRASI</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#addSmt">Add Semester</a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover" id="example">
                            <thead>
                                <tr>
                                    <th class="text-center">#</th>
                                    <th class="text-center">Semester</th>
                                    <th class="text-center">Tanggal Awal</th>
                                    <th class="text-center">Tanggal Akhir</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1;
                                $today = date('Y-m-d');
                                foreach ($semester as $smt) : ?>
                                    <tr>
                                        <td class="text-center"><?= $i++; ?></td>
                                        <td><?= $smt->semester; ?></td>
                                        <td><?= date('d M Y', strtotime($smt->awal)); ?></td>
                                        <td><?= date('d M Y', strtotime($smt->akhir)); ?></td>
                                        <td class="text-center">
                                            <?php if ($today >= $smt->awal && $today <= $smt->akhir) : ?>
                                                <span class="btn btn-sm btn-success">Aktif</span>
                                            <?php else : ?>
                                                <span class="btn btn-sm btn-danger">Tidak Aktif</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <a href="#" class="badge badge-warning edit_btn" data-toggle="modal" data-target="#editSmt" data-id="<?= $smt->id; ?>" data-nama="<?= $smt->semester; ?>" data-awal="<?= $smt->awal; ?>" data-akhir="<?= $smt->akhir; ?>">Edit</a>
                                            <a href="<?= base_url('admin/home/delSmt/' . $smt->id); ?>" onclick="return confirm('Apakah anda yakin ingin menghapus data ini ?')" class="badge badge-danger">Delete</a>
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
<div class="modal fade" id="addSmt" tabindex="-1" role="dialog" aria-labelledby="addSmt" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Semester</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="basic-form" action="<?= base_url('admin/home/addSemt'); ?>" method="post">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Nama Semester</label>
                                <input type="text" class="form-control" name="nama" required autocomplete="off">
                            </div>
                            <div class="form-group">
                                <label>Tanggal Awal</label>
                                <input type="date" class="form-control" name="awal" required autocomplete="off">
                            </div>
                            <div class="form-group">
                                <label>Tanggal Akhir</label>
                                <input type="date" class="form-control" name="akhir" required autocomplete="off">
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

<!-- modal add -->
<div class="modal fade" id="editSmt" tabindex="-1" role="dialog" aria-labelledby="editSmt" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Semester</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="basic-form" action="<?= base_url('admin/home/editSemt'); ?>" method="post">
                    <div class="row">
                        <div class="col-md-12">
                            <input type="hidden" name="id" id="id">
                            <div class="form-group">
                                <label>Nama Semester</label>
                                <input type="text" class="form-control" name="nama" required autocomplete="off" id="nama">
                            </div>
                            <div class="form-group">
                                <label>Tanggal Awal</label>
                                <input type="date" class="form-control" name="awal" required autocomplete="off" id="awal">
                            </div>
                            <div class="form-group">
                                <label>Tanggal Akhir</label>
                                <input type="date" class="form-control" name="akhir" required autocomplete="off" id="akhir">
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

<script>
    let edit_btn = $('.edit_btn');

    $(edit_btn).each(function(i) {
        $(edit_btn[i]).click(function() {
            let id = $(this).data('id');
            let nama = $(this).data('nama');
            let awal = $(this).data('awal');
            let akhir = $(this).data('akhir');

            $('#id').val(id);
            $('#nama').val(nama);
            $('#awal').val(awal);
            $('#akhir').val(akhir);
        });
    });
</script>