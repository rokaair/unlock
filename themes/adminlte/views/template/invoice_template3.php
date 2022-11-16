<!DOCTYPE html>
<html>
<head>
	<title>Repair Reciept</title>
    <script src="<?= $assets;?>bower_components/jquery/dist/jquery.min.js"></script>
    <link rel="stylesheet" type="text/css" href="<?= $assets;?>/dist/css/custom/thermal.css">
    <script src="<?= $assets;?>bower_components/jquery/dist/jquery.min.js"></script>
	<style type="text/css">
		/*body   { font-family: 'Arial', sans-serif; font-weight: bold;}*/
		#invoice-POS {
		  box-shadow: 0 0 1in -0.25in rgba(0, 0, 0, 0.5);
		  padding: 2mm;
		  margin: 0 auto;
		  width: 80mm;
		  background: #FFF;
		}
		#invoice-POS ::selection {
		  background: #f31544;
		  color: #FFF;
		}
		#invoice-POS ::moz-selection {
		  background: #f31544;
		  color: #FFF;
		}
		#invoice-POS h1 {
		  font-size: 1.5em;
		  color: #222;
		}
		#invoice-POS h2 {
		  font-size: .9em;
		}
		#invoice-POS h3 {
		  font-size: 1.2em;
		  /*font-weight: 300;*/
		  line-height: 2em;
		}
		#invoice-POS p {
		  font-size: .7em;
		  color: #666;
		  line-height: 1.2em;
		}
		#invoice-POS #top, #invoice-POS #mid, #invoice-POS #bot {
		  /* Targets all id with 'col-' */
		  border-bottom: 1px solid #EEE;
		}
		#invoice-POS #top {
		  min-height: 100px;
		}
		#invoice-POS #mid {
		  min-height: 80px;
		}
		#invoice-POS #bot {
		  min-height: 50px;
		}
		#invoice-POS #top .logo img {
		  height: 60px;
		  /*width: 60px;*/
		  /*background: url('') no-repeat;*/
		  /*background-size: 60px auto;*/
		}
		#invoice-POS .info {
		  display: block;
		  margin-left: 0;
		}
		#invoice-POS .title {
		  float: right;
		}
		#invoice-POS .title p {
		  text-align: right;
		}
		#invoice-POS table {
		  width: 100%;
		  border-collapse: collapse;
		}
		#invoice-POS .tabletitle {
		  font-size: .7em;
		  background: #EEE;
		}
		#invoice-POS .service {
		  border-bottom: 1px solid #EEE;
		}
		#invoice-POS .item {
		  width: 47mm;
		}
		#invoice-POS .itemtext {
		  font-size: .7em;
		}
		#invoice-POS #legalcopy {
		  margin-top: 5mm;
		}

		@media print {
			body * { visibility: hidden; }
			#invoice-POS * { visibility: visible; }
			#invoice-POS { margin: 0; padding: 0; padding-top: 5px }
		}
		@page  
		{ 
		    size: auto;   /* auto is the initial value */ 
		    margin: 0;  
		} 
	</style>
</head>
<body>

  <div id="invoice-POS">
    
    <center id="top">
      <div class="logo">
      	<img src="<?=base_url();?>assets/uploads/logos/<?=$settings->logo; ?>">
      </div>
      <div class="info"> 
        <h2><?=$settings->title;?></h2>
        <p> 
            <?=lang('client_address');?> : <?=$settings->address;?></br>
            <?=lang('client_email');?>   : <?=$settings->invoice_mail;?></br>
            <?=lang('client_telephone');?>   : <?=$settings->phone;?></br>
        </p>
      </div><!--End Info-->
    </center><!--End InvoiceTop-->
	<div class="clearfix"></div>
    
    <div id="mid">
      <div class="info">
      	<h2></h2>
      	<center>
	    	<div id="" style="margin-left: -10px; margin-top: -3px;margin-bottom: 9px;">
		        <?= $this->repairer->barcode($db['code'], 'code128', 30, true); ?>
		    </div>
		</center>
        <h2><?=lang('customer_name');?>: <?=$db['name'];?></h2>
		<div class="clearfix"></div>
      </div>

    </div><!--End Invoice Mid-->
   
    <div id="bot">
		<div id="table">
			<table>
				<tr class="tabletitle">
					<td class="item"><h2><?=lang('repair_item');?></h2></td>
					<td class="Hours"></td>
					<td class="Rate price"></h2></td>
				</tr>

				<tr class="service">
					<td colspan="3" class="tableitem"><p class="itemtext">
						<strong><?= $db['model_name'];?></strong>
						<small><?= $db['imei'] ? '('.$db['imei'].')' : '';?>
						<br>
						<?=$db['defect'];?></small>
					</p></td>
				</tr>

				<tr class="tabletitle">
					<td></td>
					<td class="Rate"><h2><?=lang('total_price');?></h2></td>
					<td class="payment"><h2><?=$settings->currency; ?> <?=number_format($db['grand_total'], 2); ?></h2></td>
				</tr>
				<tr class="tabletitle">
					<td></td>
					<td class="Rate"><h2><?=lang('advance');?></h2></td>
					<td class="payment"><h2><?=$settings->currency; ?> <?=number_format($db['advance'], 2); ?></h2></td>
				</tr>

				<tr class="tabletitle">
					<td></td>
					<td class="Rate"><h2><?=lang('balance');?></h2></td>
					<td class="payment"><h2><?=$settings->currency; ?> <?=$db['grand_total']-$db['advance']; ?></h2></td>
				</tr>

				

			</table>
		</div><!--End Table-->

		<div id="legalcopy">
			<p class="legal"><?=$settings->disclaimer;?> 
			</p>


		</div>
			<center>
				<?= $this->repairer->qrcode('link', urlencode(base_url()), 1); ?>
			</center>
			<div class="clearfix"></div>


        
	</div><!--End InvoiceBot-->
	
  </div><!--End Invoice-->
<script type="text/javascript">
	$( document ).ready(function() {
        setTimeout(function() {
            window.print();
        }, 500);
        // window.onafterprint = function(){
        //     setTimeout(function() {
        //         window.close();
        //     }, 10000);
        // }
    });
</script>
</body>
</html>
