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
                        <input type="hidden" name="id" value="<?= $setting->id; ?>">
                        <div class="form-group">
                            <label>Status</label>
                            <select class="form-control" name="status">
                                <option value="SCAN" <?= ($setting->status == 'SCAN') ? 'selected' : '' ?>>SCAN</option>
                                <option value="REGISTRASI" <?= ($setting->status == 'REGISTRASI') ? 'selected' : '' ?>>REGISTRASI</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">save</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /page content -->
<!-- /page content -->