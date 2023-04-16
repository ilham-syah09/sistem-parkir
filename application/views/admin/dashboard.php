<!-- page content -->
<div class="right_col" role="main">
    <div class="row mb-2">
        <div class="col-lg-4 col-md-4 col-sm-6 col-12">
            <div class="card card-statistic-1">
                <div class="card-wrap">
                    <div class="card-header bg-primary text-white">
                        <h5>Total User</h5>
                    </div>
                    <div class="card-body">
                        <?= $user; ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-6 col-12">
            <div class="card card-statistic-1">
                <div class="card-wrap">
                    <div class="card-header bg-primary text-white">
                        <h5>Scan</h5>
                    </div>
                    <div class="card-body">
                        <a href="<?= base_url('scan'); ?>" target="_blank" class="btn btn-success">klik tombol ini </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h3>Metode</h3>
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