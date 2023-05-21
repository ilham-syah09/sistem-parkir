<!-- page content -->
<div class="right_col" role="main">
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header justify-content-center">
                    <h5>Biodata</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-12 text-center mb-3">
                            <img src="<?= base_url('upload/profile/') . $this->dt_user->image; ?>" alt="Image Profile" class="img-thumbnail" width="200">
                        </div>
                        <div class="col-sm-12">
                            <div class="bg-info p-2 text-white mb-2">
                                <span>Nama - <?= $this->dt_user->nama; ?></span>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="bg-info p-2 text-white mb-2">
                                <span>NIM - <?= $this->dt_user->nim; ?></span>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="bg-info p-2 text-white">
                                <span>Email - <?= $this->dt_user->email; ?></span>
                            </div>
                        </div>
                        <div class="col-sm-12 mt-2">
                            <form action="<?= base_url('user/profile/changeImage'); ?>" method="post" enctype="multipart/form-data">
                                <input type="hidden" name="previmage" value="<?= $this->dt_user->image; ?>">
                                <div class="form-group">
                                    <label>Upload Foto</label>
                                    <input type="file" class="form-control" name="image">
                                </div>
                                <button type="submit" class="btn btn-primary btn-sm float-right">upload</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <?php if (password_verify('user123', $this->dt_user->password)) : ?>
                <div class="alert alert-danger" role="alert">
                    Anda masih menggunakan password default. segera ganti password anda!
                </div>
            <?php endif; ?>

            <?php if (password_verify('user123', $this->dt_user->password)) : ?>
                <div class="card">
                    <div class="card-header justify-content-center">
                        <h5>Password</h5>
                    </div>
                    <div class="card-body">
                        <form action="<?= base_url('user/profile/changeNewPwd'); ?>" method="post">
                            <input type="hidden" name="id" value="<?= $this->dt_user->id; ?>">
                            <div class="form-group">
                                <label>Password</label>
                                <input type="password" class="form-control" name="password">
                            </div>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </form>
                    </div>
                </div>
            <?php else : ?>
                <div class="card">
                    <div class="card-header justify-content-center">
                        <h5>Password</h5>
                    </div>
                    <div class="card-body">
                        <form action="<?= base_url('user/profile/changePwd'); ?>" method="post">
                            <input type="hidden" name="id" value="<?= $this->dt_user->id; ?>">
                            <div class="form-group">
                                <label>Current Password</label>
                                <input type="password" class="form-control" name="current_password">
                            </div>
                            <div class="form-group">
                                <label>New Password</label>
                                <input type="password" class="form-control" name="password">
                            </div>
                            <div class="form-group">
                                <label>Retype New Password</label>
                                <input type="password" class="form-control" name="retype_password">
                            </div>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </form>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<!-- /page content -->