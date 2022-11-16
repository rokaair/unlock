<?php
$tax = $db['tax'];
$price_without_tax = $db['total']; // PRICE WITHOUT TAX
$total = $db['grand_total']; // PRICE WITH TAX
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title><?= $this->lang->line('report');?></title>
        <link href="<?= $assets ?>dist/css/custom/invoice2.css" rel="stylesheet">
        <!-- jQuery 2.2.3 -->

        <script src="<?= $assets ?>bower_components/jquery/dist/jquery.min.js"></script>

        <!-- Accounting.js -->

        <script src="<?= $assets ?>plugins/custom/accounting.min.js"></script>
        <style type="text/css">
            #invoice-POS {
              box-shadow: 0 0 1in -0.25in rgba(0, 0, 0, 0.5);
              padding: 2mm;
              margin: 0 auto;
              width: 80mm;
              background: #FFF;
            }
            @media print {
                body * { visibility: hidden; }
                #invoice-POS * { visibility: visible; }
            }
            @page  
            { 
                size: auto;   /* auto is the initial value */ 
                margin: 0;  
            } 
        </style>
      </head>

    <body>
        <div id="editable_invoice"><?= $this->lang->line('editable_invoice');?></div>
        <div class="halfinvoice" id="invoice-POS">
            <header class="clearfix">
              <div id="logo">
                    <img src="<?= base_url(); ?>assets/uploads/logos/<?= $settings->logo; ?>">
                </div>
                <div id="company" contentEditable="true">

                   <h2 class="name"><?= $settings->title; ?></h2>
                   <div><?= $settings->invoice_name; ?></div>
                   <div><?= $settings->address; ?></div>
                   <div><?= $settings->phone; ?></div>
                   <div><a href="mailto:<?= $settings->invoice_mail; ?>"><?= $settings->invoice_mail; ?></a></div>
                   <div><?= $settings->vat; ?></div>
               </div>
          </header>
            <div style="text-align: center">
                <?= $this->repairer->barcode($db['code'], 'code128', 40, false); ?>
            </div>
            <div style="text-align: center"><?=$db['telephone']; ?></div>
            <main>
                <div id="details" class="clearfix">
                    <div id="client" contentEditable="true">
                    <!-- DESCRIPTION REMOVED <div <h2><?= $this->lang->line('report').' '.$db['model_name'];?></h2> </div> -->
                        <div class="to"><?= $this->lang->line('client_title');?>:</div>
                        <h2 class="name"><?=$db['name'];?></h2>
                      </div>
                  </div>

                <div id="dati">
                    <div class="col"><b><?= $this->lang->line('date_opening');?>:</b> <?= date_format(date_create($db['date_opening']),"d/m/Y"); ?></div>
                    <div class="col"><b><?= $this->lang->line('date_opening2');?>:</b><?php $data = $db['expected_close_date']; $data = $data ? strtotime($data) : strtotime($data. ' + 15 days'); echo date(' d/m/Y', $data);?></div>
                    <div class="col"><b><?= $this->lang->line('model_name');?>:</b> <?=$db['model_name'];?></div>
                    <div class="col"><b><?= $this->lang->line('reparation_category');?>:</b> <?=$db['category'];?></div>
                    <div class="col"><b><?= $this->lang->line('reparation_defect');?>:</b> <?=$db['defect'];?></div>
                    <div class="col"><b><?= $this->lang->line('reparation_advance');?>:</b> <?=$this->repairer->formatDecimal($db['advance']);?>€</div>
                    <div class="col"><b><?= $this->lang->line('grand_total');?>:</b> <?=$this->repairer->formatDecimal($db['grand_total']);?>€</div>
                    <div class="col"><b><?= $this->lang->line('id');?>:</b> <?=$db['id'];?></div> <!--ID ADDED -->
                    <div class="col"><b><?= $this->lang->line('code');?>:</b> <?=$db['code'];?></div>
                    <div class="col"><b><?= $this->lang->line('reparation_imei');?>:</b> <?=$db['imei'];?></div>
                    <?php $custom_fields = explode(',', $settings->custom_fields);
                        if (!empty(array_filter($custom_fields))) {
                            $value = json_decode($db['custom_field'], true);
                            foreach($custom_fields as $line){
                                 if(!empty(array_filter($value))): ?>
                                    <div class="col"><b> <?= $line; ?> :</b> <?= $value[bin2hex($line)]; ?></div>
                        <?php
                                endif;
                            }
                        }
                    ?>
                    <div class="col txt"><textarea id="comment" onkeyup="auto_grow(this)" contentEditable="true"><?=$db['comment']; ?></textarea></div>
                    <div style="clear: both;"></div>
                </div>
                <?= $settings->disclaimer; ?>
            </main>

            <div id="print_button"><?= $this->lang->line('print');?></div>
        </div>
    </body>

    <script>
        jQuery(document).on("click", "#print_button", function() {
            window.print();
            setInterval(function() {
                window.close();
            }, 500);
        });
        function auto_grow(element) {
            element.style.height = "5px";
            element.style.height = (element.scrollHeight)+"px";
        }
        auto_grow(document.getElementById("comment"));
    </script>

</html>
