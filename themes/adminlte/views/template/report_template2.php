
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <link rel="stylesheet" type="text/css" href="<?=$assets;?>dist/css/custom/table-print.css">
        <link rel="stylesheet" href="<?=$assets;?>bower_components/bootstrap/dist/css/bootstrap.min.css">
        <!-- <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet"> -->

        <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
        <script src="<?=$assets;?>bower_components/jquery/dist/jquery.min.js"></script>
        <!-- <script type="text/javascript" src="<?=base_url();?>assets/plugins/custom/jquery-barcode.min.js"></script>   -->
        <title><?=lang('report');?></title>
        <style type="text/css">
            *
            {
               font-family: 'Open Sans', sans-serif  !important;
               font-weight: bolder !important;
            }
        </style>
    </head>
<body>

<center>
    <div class="x_content">
        <?php if($is_a4): ?>
            <div id="copy" class="row" style="width: 21cm;height: 29.7cm;margin: auto;">
        <?php else: ?>
            <div id="copy" class="row" style="width: 21cm;height: 14.8cm;margin: auto;">
        <?php endif;?>
        <div class="col-md-12 col-sm-12 col-xs-12" style="padding: 0.5cm 21px 0px 21px;">
            <div class="col-xs-5" style="text-align:left;padding-left: 0;">
                <div class="text-muted well well-sm no-shadow head_left" style="background: #3d3d3d;border: 1px solid #2f2f2f;">
                    <h4 class="text-head1" style="margin-top: 0px;margin-bottom: 0px;color: #ffffff;"><?=lang('invoice');?> REPAIR<?=str_pad($db['id'], 4, '0', STR_PAD_LEFT); ?></h4>
                    <h6 class="text-head1" style="margin-top: 0px;margin-bottom: 0px;color: #ffffff;"><?=lang('invoice_subheading');?></h6>                   
                </div>        
                <h5 style="margin: 4px 1px;" class="color"><?=lang('report_code');?>: UNLOCK<?=str_pad($db['id'], 4, '0', STR_PAD_LEFT); ?>
 
                </h5>
                <h5 style="margin: 4px 1px;" class="color"><?=lang('report_client');?>:  <?= $client->name;?></h5>
                <h5 style="margin: 4px 1px;" class="color"><?=lang('report_telephone');?>: <?= $client->telephone;?> </h5>                
            </div>
            <div class="col-xs-7" style="padding-right: 0;">
                <h4 class="color" style="margin-top: 0px;margin-bottom: 0px;text-align: right;">
                    <img src="<?=base_url();?>assets/uploads/logos/<?=$settings->logo;?>" style="height: 70px;padding-bottom: 10px;;">
                </h4>
                <h4 class="color" style="margin-top: 0px;margin-bottom: 0px;text-align: right;"><?=$settings->title;?></h4>
                <h5 class="color" style="margin-top: 4px;margin-bottom: 0px;text-align: right;"><?=$settings->address;?></h5>
                <h5 class="color" style="margin-top: 4px;margin-bottom: 0px;text-align: right;"><?=lang('report_telephone');?>: <?=$settings->phone;?></h5>
            </div>
        </div>
        <div class="col-md-12 col-sm-12 col-xs-12" style="padding: 5px 20px 0px 20px;">
            <div class="col-xs-4 bg-col" style="text-align:left;border-top: 1px solid #D8D8D8;background-color: #f5f5f5;border-right: 1px solid #D8D8D8;border-bottom: 1px solid #D8D8D8;border-left: 1px solid #D8D8D8;padding: 10px;height:136px;">
                <h5 style="margin: 4px 1px;" class="color"><?=lang('report_equipment');?>: <?=$db['model_name'];?></h5>
                <h5 style="margin: 4px 1px;" class="color"><?=lang('report_Status');?>:  <?=$status->label;?></h5>
                <h5 style="margin: 4px 1px;" class="color"><?=lang('report_defect');?>:  <?=$db['defect'];?></h5>

            </div>
            <div class="col-xs-4 bg-col" style="text-align:left;border-top: 1px solid #D8D8D8;background-color: #f5f5f5;border-right: 1px solid #D8D8D8;border-bottom: 1px solid #D8D8D8;padding: 10px;height:136px;">
                <h5 style="margin: 4px 1px;" class="color"><?=lang('report_category');?>: <?=$db['category'];?></h5>
                <h5 style="margin: 4px 1px;" class="color"><?=lang('report_advance');?>: <?= $settings->currency;?> <?=number_format($db['advance'], 0, '', '');?></h5>
                <h5 style="margin: 4px 1px;" class="color"><?=lang('report_total');?>:  <?=$settings->currency;?> <?=number_format($db['grand_total'], 0, '', '');?></h5>
                <h5 style="margin: 4px 1px;" class="color">
                    <?=lang('report_date_opening');?> :  
                    <?=date('m/d/Y', strtotime($db['date_opening']));?>        
                </h5>            
            </div>
            <div class="col-xs-4 bg-col" style="text-align:left;border-top: 1px solid #D8D8D8;background-color: #f5f5f5;border-right: 1px solid #D8D8D8;border-bottom: 1px solid #D8D8D8;padding: 10px;height:136px;">
                <h5 style="margin: 4px 1px;" class="color"><?=lang('bc_management');?></h5>
                <h5 style="margin: 4px 1px;" class="color">
                    <div id="" style="margin-left: -10px; margin-top: -3px;margin-bottom: 9px;">
                        <?= $this->repairer->barcode($db['code'], 'code128', 20, false); ?>
                    </div>
                </h5>  
                        <h5 style="margin: 5px 7px;" class="color">
                        <div style="float: left;margin-top: 0px;margin-left: -7px;margin-right: 8px;">
                            <?= $this->repairer->qrcode('link', urlencode(base_url()), 1); ?>
                        </div>                  
                    </h5>
                    <h4 style="margin: 23px 1px 0px 0px;font-size:16px;" class="color"><?=lang('check_online');?></h4>
                    <h5 style="margin: 4px 1px;font-size:10px;" class="color">
                        <?=base_url();?>
                    </h5>
                            
            </div>
        </div>
        <div class="col-md-12 col-sm-12 col-xs-12" style="padding: 5px 20px 0px 20px;height: 200px;">
            <div class="col-xs-12" style="text-align: left;padding: 2;">
                <?=$settings->disclaimer; ?>
            </div>
        </div>
        <?php if($is_a4): ?>
            <div class="col-md-12 col-sm-12 col-xs-12" style="padding: 100px 20px 0px 80px;">
        <?php else: ?>
        <div class="col-md-12 col-sm-12 col-xs-12" style="padding: 5px 20px 0px 80px;">
        <?php endif;?>
            <div class="col-xs-6" style="text-align: left;padding: 0;">
                <h5 style="margin: 4px 1px 0px -52px;text-align: center;" class="color"><?=lang('Repairer');?>(.................................................)</h5>
                <h5 style="margin: 4px 1px;text-align: center;" class="color"><?= $settings->title;?></h5>
            </div>
            <div class="col-xs-6" style="text-align: left;padding: 0;">
                <h5 style="margin: 4px 1px 0px -65px;text-align: center;" class="color"><?=lang('sign_recipient');?> (.................................................)</h5>
                <h5 style="margin: 4px 1px;text-align: center;" class="color"><?=$user->first_name.' '.$user->last_name;?></h5>
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