
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title><?= $settings->title; ?></title>

    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="<?= $assets; ?>bower_components/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?= $assets; ?>plugins/toastr/toastr.min.css">
    <link rel="stylesheet" href="<?= $assets; ?>dist/css/custom/home.css">
    <link rel="stylesheet" href="<?= $assets; ?>dist/css/custom/custom.css">
    <link rel="stylesheet" href="<?= $assets; ?>bower_components/font-awesome/css/font-awesome.min.css">
    <script src="<?= $assets ?>bower_components/jquery/dist/jquery.min.js"></script>
    <script src="<?= $assets ?>bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="<?= $assets ?>plugins/toastr/toastr.min.js"></script>
    <script>var base_url = "<?= base_url(); ?>";</script>
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <script>

    jQuery(document).ready(function () {
	var postJSON;
	postJSON = 'aa'

	toastr.options = {
		"closeButton": true,
		"debug": false,
		"progressBar": true,
		"positionClass": "toast-bottom-right",
		"onclick": null,
		"showDuration": "300",
		"hideDuration": "1000",
		"timeOut": "5000",
		"extendedTimeOut": "1000",
		"showEasing": "swing",
		"hideEasing": "linear",
		"showMethod": "fadeIn",
		"hideMethod": "fadeOut"
	}

	jQuery(document).on("click", "#submit", function () {
          	$('#loadingmessage').show();  // show the loading message.

			var code = jQuery('#code').val();
			var url = "";
			var dataString = "";
			url = base_url + "welcome/status";
			dataString = "code=" + code;
			jQuery.ajax({
				type: "POST",
				url: url,
				data: dataString,
				cache: false,
				dataType: "json",
				success: function (data) {
        	$('#loadingmessage').hide();
					if(isEmpty(data)) {toastr['error']("<?= lang('error'); ?>", "<?= lang('main_invalid_code'); ?>");}
					else {
						var status = "<span class='label' style='background-color:"+data.bg_color+"; color:"+data.fg_color+"'>"+data.status+"</span>";
						toastr['success']("<?= lang('main_success'); ?>", "<?= lang('main_success_code'); ?>")
						jQuery('#client_name').html(data.name);
            jQuery('#status').html(status);
						jQuery('#warranty_status').html(data.warranty_status);

						jQuery('#date_opening').html(data.date_opening);
						jQuery('#defect').html(data.defect);
						jQuery('#model_name').html(data.model_name);
						jQuery('#grand_total').html("<?= $settings->currency; ?> "+data.grand_total);
						jQuery('#advance').html("<?= $settings->currency; ?> "+data.advance);
						jQuery('#result').fadeIn(1000);
            if(data.date_closing == null) {
              jQuery('.centre_box div.date_closing_div').hide();
            } else {
              jQuery('.centre_box div.date_closing_div').fadeIn();
              jQuery('#date_closing').html(data.date_closing)
            }
					}
				}
			});
		});

	});

	function isEmpty(obj) {
		return Object.keys(obj).length === 0;
	}
    </script>
    <style type="text/css">
	  .loader {
	      color: white;
	      top: 0;
	      right: 0;
	      position: fixed;
	      width: 106px;
	      height: 106px;
	      background: url('<?= base_url(); ?>assets/dist/img/loading-page.gif') no-repeat center;
	      z-index: 4;
	  }
      .bio-row p span.bold{
        width: 100%;
      }

      body, html {
        height: 100%;
        margin: 0;
        font: 400 15px/1.8 "Lato", sans-serif;
        color: #777;
      }

    <?php if($settings->background): ?>
      body{
        position: relative;
        /*opacity: 0.65;*/
        background-position: center;
        background-repeat: no-repeat;
        background-size: cover;

      }
      body {
        background-image: url('<?= base_url(); ?>assets/uploads/backgrounds/<?= $settings->background;?>');
        height: 100%;
      }
    <?php endif; ?>
	</style>
	<div id='loadingmessage' class="loader" style='display:none'></div>

  </head>

  <body class="">


    <div class="container ">
      <div class="header clearfix">
        <nav>
          <ul class="nav nav-pills pull-right">
            <li role="presentation" class="active"><a href="#"><?= lang('main_nav_home'); ?></a></li>
            <li role="presentation"><a href="<?= base_url();?>/panel"><?= lang('main_nav_login'); ?></a></li>
          </ul>
        </nav>
        <img height="90" src="<?= base_url(); ?>assets/uploads/logos/<?= $settings->logo; ?>">
      </div>

      <div class="jumbotron">
        <h1><?= $settings->title; ?></h1>
        <div class="pull-left">
        	<label><?= strtoupper(lang('main_reparation_code')); ?></label>
        	<small><?= lang('main_reparation_code_sublines'); ?></small>
        </div>
        <input type="text" id="code" name="code" class="form-control"><br>
        <button class="btn btn-primary" id="submit"><?= lang('main_submit'); ?></button>
      </div>
      		<div class="marketing" style="background: white;box-shadow: inset 0 0 20px 10px rgba(128, 128, 128, 0.05);border-radius: 5px;">
                <div class="form-group"></div>
                <div class="">
                <div class="centre_box status_box" style="display: none;padding-top: 10px;" id="result">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="col-md-6" style="text-align: center;">
                                <p><span style="font-size: 50px;"><?= $this->lang->line('status');?></span><br>
                                <span id="status" style="font-size: 43px;"></span></p>
                                <span id="warranty_status" style="font-size: 43px;"></span></p>
                            </div>
                            <div class="col-md-6">
                                <div class="col-md-12 col-lg-6 bio-row">
                                    <p><span class="bold"><i class="fa fa-user"></i> <?= $this->lang->line('client_title');?> </span><span id="client_name"></span></p>
                                </div>
                                <div class="col-md-12 col-lg-6 bio-row">
                                    <p><span class="bold"><i class="fa fa-calendar"></i> <?= $this->lang->line('date_opening');?> </span><span id="date_opening"></span></p>
                                </div>
                                <div class="col-md-12 col-lg-6 bio-row">
                                    <p><span class="bold"><i class="fa fa-chain-broken"></i> <?= $this->lang->line('reparation_defect');?></span><span id="defect"></span></p>
                                </div>
                                <div class="col-md-12 col-lg-6 bio-row">
                                    <p><span class="bold"><i class="fa fa-tag"></i> <?= $this->lang->line('model_title');?> </span><span id="model_name"></span></p>
                                </div>
                                <div class="col-md-12 col-lg-6 bio-row nofloat">
                                    <p><span class="bold"><i class="fa fa-money"></i> <?= $this->lang->line('grand_total');?> </span><span id="grand_total"></span></p>
                                </div>
                                <div class="col-md-12 col-lg-6 bio-row">
                                    <p><span class="bold"><i class="fa fa-money"></i> <?= $this->lang->line('reparation_advance');?></span><span id="advance"></span></p>
                                </div>
                                <div class="col-md-12 col-lg-6 bio-row date_closing_div">
                                    <p><span class="bold"><i class="fa fa-calendar"></i> <?= $this->lang->line('date_closing');?> </span><span id="date_closing"></span></p>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
            </div>
      <footer class="footer">
        <p>&copy; <?= date('Y'); ?> <?= $settings->title;?></p>
      </footer>
    </div> <!-- /container -->
  </body>
</html>
