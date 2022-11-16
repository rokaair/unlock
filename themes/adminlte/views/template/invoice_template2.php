<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <link rel="stylesheet" href="<?=$assets;?>bower_components/bootstrap/dist/css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="<?=$assets;?>dist/css/custom/table-print.css">

        <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
        <script src="<?=$assets;?>bower_components/jquery/dist/jquery.min.js"></script>
        <title><?=lang('invoice');?></title>
        <style type="text/css">
            body {
                font-family: 'Open Sans', sans-serif  !important;
                font-weight: bolder !important;
                color: #777; 
                font-weight:400;
            }
        </style>
    </head>
<body>


<center>
    <div class="x_content">
        <?php if($is_a4): ?>
            <div id="copy" class="row" style="width: 21cm;height: 29.5cm;margin: 0 auto;padding:0;">
        <?php else: ?>
            <div id="copy" class="row" style="width: 21cm;height: 14.8cm;margin: 0 auto;padding:0;">
        <?php endif;?>
        <div class="col-md-12 col-sm-12 col-xs-12" style="padding: 0.5cm 21px 0px 21px;">
            <div class="col-xs-5" style="text-align:left;padding-left: 0;">
                <div class="text-muted well well-sm no-shadow head_left" style="background: #3d3d3d;border: 1px solid #2f2f2f;">
                    <h4 class="text-head1" style="margin-top: 0px;margin-bottom: 0px;color: #ffffff;"><?=lang('invoice');?> CASE<?=str_pad($db['id'], 4, '0', STR_PAD_LEFT); ?></h4>
                    <h6 class="text-head1" style="margin-top: 0px;margin-bottom: 0px;color: #ffffff;"><?=lang('invoice_subheading');?></h6>                   
                </div>   
                
                <h5 style="margin: 4px 1px;" class="color"><?=lang('inv_date_opening');?>: <?= date('d/m/Y',strtotime($db['date_opening']));?></h5>
                <h5 style="margin: 4px 1px;" class="color"><?=lang('report_code');?>: UNLOCK<?=str_pad($db['id'], 4, '0', STR_PAD_LEFT); ?></h5>
                <h5 style="margin: 4px 1px;" class="color"><?=lang('report_client');?>:  <?= $client->name;?></h5>
                <h5 style="margin: 4px 1px;" class="color"><?=lang('report_telephone');?>: <?= $client->telephone;?> </h5>              
            </div>
            <div class="col-xs-4 bg-col" style="text-align:left;border-top: 1px solid #D8D8D8;background-color: #f5f5f5;border-right: 1px solid #D8D8D8;border-bottom: 1px solid #D8D8D8;padding: 10px;height:136px;">
                <h5 style="margin: 4px 1px;" class="color"><?=lang('bc_management');?></h5>
                <h5 style="margin: 4px 1px;" class="color">
                    <div id="" style="margin-left: -10px; margin-top: -3px;margin-bottom: 9px;">
                        <?= $this->repairer->barcode($db['code'], 'code128', 20, false); ?>
                    </div>
                </h5>  
               
                <h4 style="margin: 23px 1px 0px 0px;font-size:16px;" class="color"><?=lang('check_online');?></h4>
                <h5 style="margin: 4px 1px;font-size:10px;" class="color">
                    <?=base_url();?>
                </h5>
                            
            </div>
            <div class="col-xs-3" style="padding-right: 0;">
                <h4 class="color" style="margin-top: 0px;margin-bottom: 0px;text-align: right;">
                    <img src="<?=base_url();?>assets/uploads/logos/<?=$settings->logo;?>" style="height: 70px;padding-bottom: 10px;;">
                </h4>
                <h4 class="color" style="margin-top: 0px;margin-bottom: 0px;text-align: right;"><?=$settings->title;?></h4>
                <h5 class="color" style="margin-top: 4px;margin-bottom: 0px;text-align: right;"><?=$settings->address;?></h5>
                <h5 class="color" style="margin-top: 4px;margin-bottom: 0px;text-align: right;"><?=lang('report_telephone');?>: <?=$settings->phone;?></h5>
            </div>
        </div>
        <div class="is-table-row col-md-12 col-sm-12 col-xs-12" style="padding: 5px 20px 0px 20px;">
    <div class="col-xs-1 bg-col" style="text-align:left;border-top: 1px solid #D8D8D8;background-color: #f5f5f5;
        border-right: 1px solid #D8D8D8;border-bottom: 1px solid #D8D8D8;border-left: 1px solid #D8D8D8;padding: 0px;height:30px;">
        <h5 class="color" style="text-align: center;margin-top: 10px;"><?=lang('inv_at');?></h5>
    </div>
    <div class="col-xs-2 bg-col" style="text-align:left;border-top: 1px solid #D8D8D8;background-color: #f5f5f5;
        border-right: 1px solid #D8D8D8;border-bottom: 1px solid #D8D8D8;padding: 0px;height:30px;">
        <h5 class="color" style="text-align: center;margin-top: 10px;"><?=lang('inv_item');?> </h5>
    </div>
    <div class="col-xs-3 bg-col" style="text-align:left;border-top: 1px solid #D8D8D8;background-color: #f5f5f5;
        border-right: 1px solid #D8D8D8;border-bottom: 1px solid #D8D8D8;padding: 0px;height:30px;">
        <h5 class="color" style="text-align: center;margin-top: 10px;"><?=lang('inv_defect');?></h5>
    </div>
    
    <div class="col-xs-3 bg-col" style="text-align:left;border-top: 1px solid #D8D8D8;background-color: #f5f5f5;
        border-right: 1px solid #D8D8D8;border-bottom: 1px solid #D8D8D8;padding: 0px;height:30px;">
        <h5 class="color" style="text-align: center;margin-top: 10px;"><?=lang('inv_details');?></h5>
    </div>
    <div class="col-xs-1 bg-col" style="width: 12.5%; text-align:left;border-top: 1px solid #D8D8D8;background-color: #f5f5f5;
        border-right: 1px solid #D8D8D8;border-bottom: 1px solid #D8D8D8;padding: 0px;height:30px;">
        <h5 class="color" style="text-align: center;margin-top: 10px;"><?=lang('inv_advance');?></h5>
    </div>
    <div class="col-xs-2 bg-col" style="width: 12.5%; text-align:left;border-top: 1px solid #D8D8D8;background-color: #f5f5f5;
        border-right: 1px solid #D8D8D8;border-bottom: 1px solid #D8D8D8;padding: 0px;height:30px;">
        <h5 class="color" style="text-align: center;margin-top: 10px;"><?=lang('inv_price');?></h5>                   
    </div>
</div>
        <style type="text/css">
       /*@media only screen and (min-width : 768px) {*/
            .is-table-row {
                display: table;
            }
            .is-table-row [class*="col-"] {
                float: none;
                display: table-cell;
                vertical-align: top;
            }
            .row_item {
                word-wrap: break-word;
            }
        /*}*/
        </style>
            
        <div class="is-table-row col-md-12 col-sm-12 col-xs-12" style="table-layout: fixed;padding: 5px 20px 0px 20px;margin-top: -6px;">
            <div class="row_item col-xs-1" style="text-align:left;border-top: 1px solid #D8D8D8;
                border-right: 1px solid #D8D8D8;border-bottom: 1px solid #D8D8D8;border-left: 1px solid #D8D8D8;padding: 0px;">
                <h5 class="color" style="text-align: center;margin-top: 7px;padding-bottom: 125px;">1</h5>
            </div>
            <div class="row_item col-xs-2" style="text-align:left;border-top: 1px solid #D8D8D8;
                border-right: 1px solid #D8D8D8;border-bottom: 1px solid #D8D8D8;padding: 0px;">
                <h5 class="color" style="text-align: center;margin-top: 7px;padding-bottom: 125px;">
                    <?= $db['model_name'];?> <small><?= $db['imei'] ? '('.$db['imei'].')' : '';?></small>
                </h5>
            </div>
            <div class="row_item col-xs-3" style="text-align:left;border-top: 1px solid #D8D8D8;
                border-right: 1px solid #D8D8D8;border-bottom: 1px solid #D8D8D8;padding: 0px;">
                <h5 class="color" style="text-align: center;margin-top: 7px;padding-bottom: 125px;">
                    <?= $db['defect'];?>
                </h5>
            </div>
           
            <div class="row_item col-xs-3" style="text-align:left;border-top: 1px solid #D8D8D8;
                border-right: 1px solid #D8D8D8;border-bottom: 1px solid #D8D8D8;padding: 0px;">
                <h5 class="color" style="text-align: center;margin-top: 7px;padding-bottom: 125px;">
                    <?= $db['comment'];?>
                </h5>
            </div>

            <div class="row_item col-xs-1" style="width: 12.5%; text-align:left;border-top: 1px solid #D8D8D8;
                border-right: 1px solid #D8D8D8;border-bottom: 1px solid #D8D8D8;padding: 0px;">
                <h5 class="color" style="text-align: center;margin-top: 7px;padding-bottom: 125px;">
                  <?= $settings->currency;?> <?=number_format($db['advance'], 0, '', '');?>
                </h5>                   
            </div>
            <div class="row_item col-xs-1" style="width: 12.5%; text-align:left;border-top: 1px solid #D8D8D8;
                border-right: 1px solid #D8D8D8;border-bottom: 1px solid #D8D8D8;padding: 0px;">
                <h5 class="color" style="text-align: center;margin-top: 7px;padding-bottom: 125px;">
                  <?= $settings->currency;?> <?=number_format($db['grand_total'], 0, '', '');?>
                </h5>                   
            </div>
        </div>
        <div class="col-md-12 col-sm-12 col-xs-12" style="padding: 5px 20px 0px 20px;margin-top: -6px;">
            <div class="col-xs-1 bg-col" style="text-align:left;border-top: 1px solid #D8D8D8;background-color: #f5f5f5;
                border-bottom: 1px solid #D8D8D8;border-left: 1px solid #D8D8D8;padding: 0px;height:30px;">
                <h5 class="color" style="text-align: center;margin-top: 7px;"></h5>
            </div>
            <div class="col-xs-8 bg-col" style="text-align:left;border-top: 1px solid #D8D8D8;background-color: #f5f5f5;
                border-bottom: 1px solid #D8D8D8;padding: 0px;height:30px;">
                <h5 class="color" style="text-align: center;margin-top: 7px;"></h5>
            </div>
            <div class="col-xs-1 bg-col" style="width: 12.4%;text-align:left;border-top: 1px solid #D8D8D8;background-color: #f5f5f5;
                border-right: 1px solid #D8D8D8;border-bottom: 1px solid #D8D8D8;padding: 0px;height:30px;">
                <h5 class="color" style="text-align: right;padding-right:10px;margin-top: 7px;"><?=lang('inv_total_price');?></h5>
            </div>
            <div class="col-xs-1 bg-col"  style="width: 12.5%; text-align:left;border-top: 1px solid #D8D8D8;background-color: #f5f5f5;
                border-right: 1px solid #D8D8D8;border-bottom: 1px solid #D8D8D8;padding: 0px;height:30px;">
                <h5 class="color" style="text-align: center;margin-top: 7px;"><?= $settings->currency;?> <?=number_format((int)$db['grand_total'] - (int)$db['advance'], 0, '', '');?></h5>                   
            </div>
        </div>
        <?php if($db['warranty'] !== '' && $db['warranty'] !== '0'): ?>
        <span class="pull-left" style="margin-left: 20px;text-transform: uppercase;"><?=lang('warranty');?>: <?= lang($db['warranty']); ?></span>
        <?php endif; ?>

         <?php if($is_a4): ?>
            <div class="col-md-12 col-sm-12 col-xs-12" style="padding: 400px 20px 0px 80px;">
        <?php else: ?>
            <div class="col-md-12 col-sm-12 col-xs-12" style="padding: 40px 20px 0px 80px;">
        <?php endif;?>

            <div class="col-xs-6" style="text-align: left;padding: 0;">
                <h5 style="margin: 4px 1px 0px -52px;text-align: center;" class="color"><?=lang('sign_recipient');?> (.................................................)</h5>
            </div>
            <div class="col-xs-6" style="text-align: left;padding: 0;">
                <h5 style="margin: 4px 1px 0px -65px;text-align: center;" class="color"><?=lang('sign_client');?> (.................................................)</h5>
            </div>
        </div>
      </div>
      <?php if($two_copies): ?>
          <img src="<?=base_url();?>assets/images/cut.png" style="width: 27px;margin-top: -15px;margin-bottom: -100px;margin-left: -700px;">
          <div id="clone"></div>
      <?php endif;?>
    </div>
</center>

</body>
</html>
<script type="text/javascript">
    $( document ).ready(function() {
        <?php if($two_copies): ?>
            $('#copy').clone().appendTo('#clone');
            $('#copy').css('border-bottom', '#999999 1px dotted');
        <?php endif;?>
        setTimeout(function() {
            window.print();
        }, 3000);
        window.onafterprint = function(){
            setTimeout(function() {
                window.close();
            }, 10000);
        }
    });
</script>