<!DOCTYPE html>
<html lang="en">

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<!-- Meta, title, CSS, favicons, etc. -->
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<title><?= $title; ?></title>

	<!-- Bootstrap -->
	<link href="<?= base_url(); ?>assets/vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
	<!-- Font Awesome -->
	<link href="<?= base_url(); ?>assets/vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
	<!-- NProgress -->
	<link href="<?= base_url(); ?>assets/vendors/nprogress/nprogress.css" rel="stylesheet">
	<!-- Animate.css -->
	<link href="<?= base_url(); ?>assets/vendors/animate.css/animate.min.css" rel="stylesheet">

	<!-- Custom Theme Style -->
	<link href="<?= base_url(); ?>assets/build/css/custom.min.css" rel="stylesheet">

	<!-- FancyBox -->
	<link rel="stylesheet" href="<?= base_url(); ?>assets/vendors/fancybox/jquery.fancybox.min.css" type="text/css" />

	<link rel="stylesheet" href="<?= base_url(); ?>assets/vendors/toastr/toastr.min.css">
</head>

<body class="login">
	<div>
		<a class="hiddenanchor" id="signup"></a>
		<a class="hiddenanchor" id="signin"></a>

		<div class="toastr-success" data-flashdata="<?= $this->session->flashdata('toastr-success'); ?>"></div>
		<div class="toastr-error" data-flashdata="<?= $this->session->flashdata('toastr-error'); ?>"></div>

		<div class="login_wrapper">
			<div class="animate form login_form">
				<div class="row">
					<div class="col-xl-12 text-center text-dark">
						<h1>Scan Disini Untuk Keluar</h1>
					</div>
					<div class="col-xl-12 text-center">
						<div class="box-body no-padding" style="max-height:500px">
							<div class="text-center tooltip_title" title="Klik Untuk Memperbesar">
								<a id="qrcode_kehadiran" data-fancybox="gallery"><img width="350" /></a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- jQuery -->
	<script src="<?= base_url(); ?>assets/vendors/jquery/dist/jquery.min.js"></script>

	<!-- FancyBox -->
	<script src="<?= base_url(); ?>assets/vendors/fancybox/jquery.fancybox.min.js"></script>

	<script src="<?= base_url(); ?>assets/vendors/toastr/toastr.min.js"></script>
	<script src="<?= base_url(); ?>assets/vendors/toastr/customScript.js"></script>

	<script>
		$(document).ready(function() {
			QRCodeKehadiran();

			setInterval(function() {
				QRCodeKehadiran();
			}, 120000);
		});

		function QRCodeKehadiran() {
			$.ajax({
				type: "POST",
				url: '<?= base_url('scan/generateQRCode/keluar'); ?>',
				dataType: "json",
				success: function(data) {
					$('#qrcode_kehadiran').attr('href', data);
					$('#qrcode_kehadiran img').attr('src', data);
				}
			});
		}
	</script>
</body>

</html>