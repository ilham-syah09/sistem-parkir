<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="images/favicon.ico" type="image/ico" />

    <title><?= $title; ?></title>

    <!-- Bootstrap -->
    <link href="<?= base_url(); ?>assets/vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="<?= base_url(); ?>assets/vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">

    <!-- Custom Theme Style -->
    <link href="<?= base_url(); ?>assets/build/css/custom.min.css" rel="stylesheet">

    <!-- Datatables -->
    <link rel="stylesheet" href="<?= base_url('assets/vendors/datatable/dataTables.bootstrap4.min.css') ?>" type="text/css">

    <!-- jQuery -->
    <script src="<?= base_url(); ?>assets/vendors/jquery/dist/jquery.min.js"></script>

    <link rel="stylesheet" href="<?= base_url(); ?>assets/vendors/toastr/toastr.min.css">
</head>

<body class="nav-md">
    <div class="toastr-success" data-flashdata="<?= $this->session->flashdata('toastr-success'); ?>"></div>
    <div class="toastr-error" data-flashdata="<?= $this->session->flashdata('toastr-error'); ?>"></div>

    <div class="container body">
        <div class="main_container">
            <div class="col-md-3 left_col menu_fixed">
                <div class="left_col scroll-view">
                    <div class="navbar nav_title" style="border: 0;">
                        <a href="<?= base_url($this->session->userdata('role')); ?>" class="site_title"><i class="fa fa-paw"></i> <span>SISTEM PARKIR</span></a>
                    </div>

                    <div class="clearfix"></div>

                    <br />

                    <?php $this->load->view($sidebar); ?>


                </div>
            </div>

            <?php $this->load->view($navbar); ?>

            <!-- page content -->

            <?php $this->load->view($page); ?>

            <!-- /page content -->

            <!-- footer content -->
            <footer>
                <div class="pull-right">
                    SISTEM PARKIR</a>
                </div>
                <div class="clearfix"></div>
            </footer>
            <!-- /footer content -->
        </div>
    </div>

    <!-- Bootstrap -->
    <script src="<?= base_url(); ?>assets/vendors/bootstrap/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Custom Theme Scripts -->
    <script src="<?= base_url(); ?>assets/build/js/custom.min.js"></script>

    <!-- Datatables -->
    <script src="<?php echo base_url(); ?>assets/vendors/datatable/jquery.dataTables.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/vendors/datatable/dataTables.bootstrap4.min.js"></script>

    <script src="<?= base_url('assets/vendors/jquery.maskedinput/'); ?>jquery.maskedinput.min.js"></script>

    <script src="<?= base_url(); ?>assets/vendors/toastr/toastr.min.js"></script>
    <script src="<?= base_url(); ?>assets/vendors/toastr/customScript.js"></script>

    <script>
        $('#example').DataTable();

        $('.js-masked-time').mask('99:99');
    </script>

</body>

</html>