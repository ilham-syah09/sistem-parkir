<!-- page content -->
<div class="right_col" role="main">
    <div class="row">
        <div class="col-sm-12 col-md-6 col-lg-6 col-xl-3">
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
                                <span>NIP - <?= $this->dt_user->nip; ?></span>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="bg-info p-2 text-white">
                                <span>Email - <?= $this->dt_user->email; ?></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /page content -->