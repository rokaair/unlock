<!DOCTYPE html>
<html>
	<head>

	  	<meta charset="utf-8">
	  	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	  	<title><?php echo $page_title; ?></title>
	  	<!-- Tell the browser to be responsive to screen width -->
	  	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
	  	<!-- Bootstrap 3.3.6 -->
	  	<link rel="stylesheet" href="<?= $assets ?>bower_components/bootstrap/dist/css/bootstrap.min.css">
	  	<!-- Font Awesome -->
	  	<link href="//use.fontawesome.com/releases/v5.0.8/css/all.css" rel="stylesheet">
	  	<!-- Ionicons -->
	  	<link rel="stylesheet" href="<?= $assets ?>bower_components/Ionicons/css/ionicons.min.css">
	  	<!-- Select2 -->
	  	<link rel="stylesheet" href="<?= $assets ?>bower_components/select2/dist/css/select2.css">
	  	<!-- Theme style -->
	  	<?php if($settings->use_dark_theme): ?>
	  		<link rel="stylesheet" href="<?= $assets ?>dist/css/custom/AdminLTE_dark.css">
	  	<?php else: ?>
	  		<link rel="stylesheet" href="<?= $assets ?>dist/css/AdminLTE.min.css">
	  	<?php endif; ?>
	  	<!-- AdminLTE Skins. Choose a skin from the css/skins folder instead of downloading all of them to reduce the load. -->
  		<link rel="stylesheet" href="<?= $assets ?>dist/css/skins/_all-skins.min.css">

	  	<!-- iCheck -->
	  	<link rel="stylesheet" href="<?= $assets ?>plugins/iCheck/all.css">
	  	<!-- Morris chart -->
	  	<link rel="stylesheet" href="<?= $assets ?>bower_components/morris.js/morris.css">
	  	<!-- jvectormap -->
	  	<!-- <link rel="stylesheet" href="<?= $assets ?>plugins/jvectormap/jquery-jvectormap-1.2.2.css"> -->
	  	<!-- Date Picker -->
	  	<link rel="stylesheet" href="<?= $assets ?>bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
	  	<!-- jQueryUI -->
	  	<link rel="stylesheet" href="<?= $assets ?>bower_components/jquery-ui/themes/ui-lightness/jquery-ui.min.css">
	  	<link rel="stylesheet" href="<?= $assets ?>bower_components/jquery-ui/themes/ui-lightness/theme.css">
	  	<!-- Daterange picker -->
	  	<link rel="stylesheet" href="<?= $assets ?>bower_components/bootstrap-daterangepicker/daterangepicker.css">
	  	<!-- DataTables -->
  	  	<link rel="stylesheet" href="<?= $assets ?>bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
  	  	<!-- DataTables -->
      	<link rel="stylesheet" href="<?= $assets ?>plugins/toastr/toastr.min.css">
      	<link rel="stylesheet" href="<?= $assets ?>bower_components/bootstrap-colorpicker/dist/css/bootstrap-colorpicker.min.css">
	  	<!-- bootstrap wysihtml5 - text editor -->
	  	<link rel="stylesheet" href="<?= $assets ?>plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
	  	<!-- datetime picker -->
	  	<link rel="stylesheet" href="<?= $assets ?>dist/css/custom/jquery.datetimepicker.css">
	  	<!-- Custom CSS -->
	  	<link rel="stylesheet" href="<?= $assets ?>dist/css/custom/custom.css">
	  	<link rel="stylesheet" href="<?= $assets ?>plugins/parsley/parsley.css">
	  
		<script type="text/javascript">
        	var base_url = "<?=site_url();?>";
			var site = <?= json_encode(array('base_url' => base_url(), 'settings' => $settings));?>;
	        var tax_rates = <?php echo json_encode($taxRates); ?>;
		</script>

		<!-- jQuery 2.2.3 -->
		<script src="<?= $assets ?>bower_components/jquery/dist/jquery.min.js"></script>
		<script src="//code.jquery.com/jquery-migrate-3.0.0.js"></script>
		
		<!-- jQuery UI 1.11.4 -->
		<script src="<?= $assets ?>bower_components/jquery-ui/jquery-ui.min.js"></script>
		<!-- Bootstrap JS -->
		<script src="<?= $assets ?>bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
		
		<!-- DataTables -->
		<script src="<?= $assets ?>bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
		<script src="<?= $assets ?>bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
		<!-- Select2 -->
		<script src="<?= $assets ?>bower_components/select2/dist/js/select2.min.js"></script>
		<script src="<?= $assets ?>bower_components/bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js"></script>
		<script src="<?= $assets ?>bower_components/moment/moment.js"></script>
		<script src="<?= $assets ?>plugins/custom/jquery.datetimepicker.min.js"></script>
		<!-- iCheck -->
		<script src="<?= $assets ?>plugins/iCheck/icheck.min.js"></script>
		<!-- _Underscore.js -->
		<script src="<?= $assets ?>plugins/custom/underscore.js"></script>
		<!-- Toastr -->
		<script src="<?= $assets ?>plugins/toastr/toastr.min.js"></script>
		<!-- Accounting.js -->
		<script src="<?= $assets ?>plugins/custom/accounting.min.js"></script>
		<!-- Bootbox.js -->
		<script src="https://cdnjs.cloudflare.com/ajax/libs/bootbox.js/4.4.0/bootbox.min.js"></script>
		<!-- Bootstrap Validator -->
		<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-validator/0.5.3/js/bootstrapValidator.js"></script>
		<!-- Morris.js charts -->
		<script src="<?= $assets ?>bower_components/raphael/raphael.js"></script>
		<script src="<?= $assets ?>bower_components/morris.js/morris.min.js"></script>
		<!-- Custom -->
		<script src="<?= $assets ?>plugins/custom/core.js"></script>
		<script src="<?= $assets ?>plugins/custom/custom.js"></script>
		<script src="<?= $assets ?>plugins/parsley/parsley.min.js"></script>


		<link rel="stylesheet" href="<?= $assets ?>plugins/bootstrap-fileinput/css/fileinput.min.css">
		<script src="<?= $assets ?>plugins/bootstrap-fileinput/js/fileinput.min.js"></script>
		<script src="<?= $assets ?>plugins/typeahead.bundle.js"></script>
	  	

	    <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">

		<script type="text/javascript">
		    $(function() {
		        $('#sidebar_toggle').on('click', function(e) {
		            var body = $('body');
		            var state = '';

		            if (!body.hasClass('sidebar-collapse')) {
		                state = 'sidebar-collapse';
		            }

		            $.ajax({
		                type: 'post',
		                mode: 'queue',
		                url: '<?php echo base_url('panel/welcome/nav_toggle'); ?>',
		                data: {
		                    state: state
		                },
		                success: function(data) {

		                }
		            });
		        });
		        $('.select').select2();
		        $('.date').datepicker({
		        	format: 'yyyy/mm/dd',
		        });
		    });

			$(document).ajaxStart(function() {
			  $("#loadingmessage").show();
			});

			$(document).ajaxStop(function() {
			  $("#loadingmessage").hide();
			});
			function formatMyDecimal(number) {
				var options = {
					decimal : "<?= $settings->decimal_seperator; ?>",
					thousand: "<?= $settings->thousand_seperator; ?>",
					precision : 0,
				};
				return accounting.formatNumber(number, options)
			}
			function formatDecimal(number) {
				var options = {
					decimal : ".",
					thousand: "",
					precision : 0,
				};
				return parseFloat(accounting.formatNumber(number, options));
			}
		</script>
			<?php if($settings->language == 'arabic'):?>
				<link rel="stylesheet" href="<?= $assets;?>rtl/bootstrap-rtl.css" rel="stylesheet" />
      			<link rel="stylesheet" href="<?= $assets;?>rtl/rtl.css">
			<?php endif; ?>
		<style type="text/css">
			<?php if($settings->language == 'arabic'):?>
				@font-face {
				    font-family: 'ithra';
				    src: url('<?=base_url();?>assets/ithra-light-webfont.ttf');
				}
				body {
				   font-family: ithra !important;
				   font-weight: bolder;
				}
			<?php else: ?>
				body {
				   font-family: 'Open Sans', sans-serif  !important;
				   font-weight: bolder;
				}
			<?php endif; ?>
			
		  	.loader {
		      	color: white;
		        top: 30px;
				right: -9px;
		      	position:fixed; z-index:9999;
		      	width: 106px;
		      	height: 106px;
		      	background: url('<?= $assets ?>dist/img/loading-page.gif') no-repeat center;
		  	}
		  	/* Styling for Select2 with error */
			div.has-error ul.select2-choices {
			  border-color: rgb(185, 74, 72) !important;
			}
		  	<?php if(!$settings->use_dark_theme): ?>
				.skin-custom .main-header .navbar {
				  background-color: <?=$settings->header_color; ?>;
				}
				.skin-custom .main-header .navbar .nav > li > a {
				  color: #ffffff;
				}
				.skin-custom .main-header .navbar .nav > li > a:hover,
				.skin-custom .main-header .navbar .nav > li > a:active,
				.skin-custom .main-header .navbar .nav > li > a:focus,
				.skin-custom .main-header .navbar .nav .open > a,
				.skin-custom .main-header .navbar .nav .open > a:hover,
				.skin-custom .main-header .navbar .nav .open > a:focus,
				.skin-custom .main-header .navbar .nav > .active > a {
				  background: rgba(0, 0, 0, 0.1);
				  color: #f6f6f6;
				}
				.skin-custom .main-header .navbar .sidebar-toggle {
				  color: #ffffff;
				}
				.skin-custom .main-header .navbar .sidebar-toggle:hover {
				  color: #f6f6f6;
				  background: rgba(0, 0, 0, 0.1);
				}
				.skin-custom .main-header .navbar .sidebar-toggle {
				  color: #fff;
				}
				.skin-custom .main-header .navbar .sidebar-toggle:hover {
				  background-color: <?=$settings->header_color; ?>;
				}
				@media (max-width: 767px) {
				  .skin-custom .main-header .navbar .dropdown-menu li.divider {
				    background-color: rgba(255, 255, 255, 0.1);
				  }
				}
				.skin-custom .main-header .logo {
				  background-color: <?=$settings->menu_color; ?>;
				  color: #ffffff;
				  border-bottom: 0 solid transparent;
				}
				.skin-custom .main-header .logo:hover {
				  background-color: <?=$settings->menu_color; ?>;
				}
				.skin-custom .main-header li.user-header {
				  background-color: <?=$settings->menu_color; ?>;
				}
				.skin-custom .content-header {
				  background: transparent;
				}
				.skin-custom .wrapper,
				.skin-custom .main-sidebar,
				.skin-custom .left-side {
				  background-color: <?=$settings->menu_color; ?>;
				}
				.skin-custom .user-panel > .info,
				.skin-custom .user-panel > .info > a {
				  color: <?=$settings->mmenu_text_color; ?>;
				}
				.skin-custom .sidebar-menu > li.header {
				  color: <?=$settings->mmenu_text_color; ?>;
				  background: <?=$settings->menu_color; ?>;
				}
				.skin-custom .sidebar-menu > li > a {
				  border-left: 3px solid transparent;
				}
				.skin-custom .sidebar-menu > li:hover > a,
				.skin-custom .sidebar-menu > li.active > a {
				  color: #ffffff;
				  background: <?=$settings->menu_active_color; ?>;
				  border-left-color: <?=$settings->header_color; ?>;
				}
				.skin-custom .sidebar-menu > li > .treeview-menu {
				  margin: 0 1px;
				  background: <?=$settings->menu_active_color; ?>;
				}
				.skin-custom .sidebar a {
				  color: <?=$settings->mmenu_text_color; ?>;
				}
				.skin-custom .sidebar a:hover {
				  text-decoration: none;
				}
				
				.skin-custom .treeview-menu > li > a {
				  color: <?=$settings->menu_text_color; ?>;
				}
				.skin-custom .treeview-menu > li.active > a,
				.skin-custom .treeview-menu > li > a:hover {
				  color: #ffffff;
				}
				.skin-custom .sidebar-form {
				  border-radius: 3px;
				  border: 1px solid #374850;
				  margin: 10px 10px;
				}
				.skin-custom .sidebar-form input[type="text"],
				.skin-custom .sidebar-form .btn {
				  box-shadow: none;
				  background-color: #374850;
				  border: 1px solid transparent;
				  height: 35px;
				}
				.skin-custom .sidebar-form input[type="text"] {
				  color: #666;
				  border-top-left-radius: 2px;
				  border-top-right-radius: 0;
				  border-bottom-right-radius: 0;
				  border-bottom-left-radius: 2px;
				}
				.skin-custom .sidebar-form input[type="text"]:focus,
				.skin-custom .sidebar-form input[type="text"]:focus + .input-group-btn .btn {
				  background-color: #fff;
				  color: #666;
				}
				.skin-custom .sidebar-form input[type="text"]:focus + .input-group-btn .btn {
				  border-left-color: #fff;
				}
				.skin-custom .sidebar-form .btn {
				  color: #999;
				  border-top-left-radius: 0;
				  border-top-right-radius: 2px;
				  border-bottom-right-radius: 2px;
				  border-bottom-left-radius: 0;
				}
				.skin-custom.layout-top-nav .main-header > .logo {
				  background-color: <?=$settings->header_color; ?>;
				  color: #ffffff;
				  border-bottom: 0 solid transparent;
				}
				.skin-custom.layout-top-nav .main-header > .logo:hover {
				  background-color: #3b8ab8;
				}

				.content-wrapper, .right-side {
				    background-color: <?=$settings->bg_color; ?> !important;
				}
				
				.spinner-wrapper {
					position: fixed;
					top: 0;
					left: 0;
					right: 0;
					bottom: 0;
					/*background-color: #ff6347;*/
					z-index: 999999;
				}
				.spinner {
				  width: 40px;
				  height: 40px;

				  position: relative;
				  /*margin: 100px auto;*/
				  position: absolute;
					top: 48%;
					left: 48%;
				}

				.double-bounce1, .double-bounce2 {
				  width: 100%;
				  height: 100%;
				  border-radius: 50%;
				  background-color: #333;
				  opacity: 0.6;
				  position: absolute;
				  top: 0;
				  left: 0;
				  
				  -webkit-animation: sk-bounce 2.0s infinite ease-in-out;
				  animation: sk-bounce 2.0s infinite ease-in-out;
				}

				.double-bounce2 {
				  -webkit-animation-delay: -1.0s;
				  animation-delay: -1.0s;
				}

				@-webkit-keyframes sk-bounce {
				  0%, 100% { -webkit-transform: scale(0.0) }
				  50% { -webkit-transform: scale(1.0) }
				}

				@keyframes sk-bounce {
				  0%, 100% { 
				    transform: scale(0.0);
				    -webkit-transform: scale(0.0);
				  } 50% { 
				    transform: scale(1.0);
				    -webkit-transform: scale(1.0);
				  }
				}
				.main-header .sidebar-toggle:before {
				        font-family: "Font Awesome 5 Free"; font-weight: 900; content: "\f0c9";

				}
				.content-header h1 {
				    color: <?=$settings->bg_text_color; ?>;
				}
			<?php endif;?>
			body{
				font-size: <?=$settings->body_font; ?>px;
				padding-right: 0 !important;
			}

			.skin-custom .main-header .logo {
				color: <?=$settings->logo_text_color; ?>;
			}

		</style>
		

  		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">



		  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
		  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
		  <!--[if lt IE 9]>
		  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
		  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
		  <![endif]-->
		 
	</head>
	<?php if($settings->use_topbar): ?>
		<body class="<?php echo $body_class; ?> layout-top-nav">
	<?php else:?>
		<body class="<?php echo $body_class; ?> skin-custom <?= $this->session->userdata('main_sidebar_state'); ?>">
	<?php endif;?>

<div id='loadingmessage' class="loader" style="display: none;"></div>
