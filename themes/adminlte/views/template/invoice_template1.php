<?php
$tax = $db['tax'];
$price_without_tax = $db['total']; // PRICE WITHOUT TAX
$total = $db['grand_total']; // PRICE WITH TAX
$advance = $db['advance'];

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title><?= $this->lang->line('invoice');?></title>
        <link href="<?= $assets ?>dist/css/custom/invoice.css" rel="stylesheet">
        <!-- jQuery 2.2.3 -->
        <script src="<?= $assets ?>bower_components/jquery/dist/jquery.min.js"></script>
        <!-- Accounting.js -->
        <script src="<?= $assets ?>plugins/custom/accounting.min.js"></script>

        <script>

            function formatDecimal(x, d) {
                if (!d) { d = 2; }
                return parseFloat(accounting.formatNumber(x, d, ',', '.'));
                // return parseFloat(Math.round(x));
            }
        </script>
        <style type="text/css">
            table .no, table .total {
                background: <?= $settings->invoice_table_color; ?>
            }
        </style>
    </head>
    
    <body>
        <div id="editable_invoice"><?= $this->lang->line('editable_invoice');?></div>
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
            </div>
        </header>
    <main>
        <div id="details" class="clearfix">
            <div id="client" contentEditable="true">
                <div class="to"><?= $this->lang->line('client_title');?>:</div>
                <h2 class="name"><?=$db['name']; ?></h2>
                <div class="company"><?=($client ? $client->company : ''); ?></div>
                <div class="address"><?=($client ? $client->address : ''); ?></div>
                <div class="postal_code"><?=($client ? $client->city : ''); ?> <?=($client ? $client->postal_code : ''); ?></div>
                <div class="email"><a <?= $client ? 'href="mailto:'.$client->email.'"' : ''; ?> ><?=$client ? $client->email : ''; ?></a></div>
                <div class="telephone"><?=$client ? $client->telephone : ''; ?></div>
                <div class="vat">
                    <?php 
                        if(isset($client->vat)) {
                            echo $client->vat; 
                            $ve = 1;
                        }
                        if(isset($client->cf)) {
                            if($ve) echo ' / ';
                            echo $client->cf;
                        }
                    ?>
                </div>
            </div>
            <div id="invoice" contentEditable="true">
                <h1><?= $this->lang->line('invoice_n');?> <i><?=str_pad($db['id'], 4, '0', STR_PAD_LEFT); ?></i></h1>
                <div class="date"><?= $this->lang->line('date_opening');?>: <?= date_format(date_create($db['date_opening']),"Y/m/d"); ?></div>
            </div>
        </div>
        <h3><?php echo $this->lang->line('reparation_title').': '.$db['defect'].' '.$db['model_name']; ?></h3>
        <pre>
        </pre>
        <table border="0" cellspacing="0" cellpadding="0">
            <thead>
                <tr>
                    <th class="no">#</th>
                    <th class="desc"><?= $this->lang->line('description');?></th>
                    <th class="unit"><?= $this->lang->line('unit_price');?></th>
                    <th class="qty"><?= $this->lang->line('quantity');?></th>
                    <th class="total"><?= $this->lang->line('subtotal');?></th>
                </tr>
            </thead>
            <tbody contentEditable="true">
                <?php if($items): ?>
                <?php $a = 1; foreach ($items as $item): ?>
                    <tr>
                        <td class="no"><?=str_pad($a, 2, '0', STR_PAD_LEFT); ?></td>
                        <td class="desc"><h3><?php echo $item->product_name; ?></td>
                        <td class="unit"><?= $settings->currency ?> <?=number_format($item->unit_price, 2);?></td>
                        <td class="qty"><?=number_format($item->quantity, 1);?></td>
                        <td class="total"><?= $settings->currency ?> <?=number_format($item->subtotal, 2);?></td>
                    </tr>
                <?php $a++; endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td class="no"><?=str_pad(1, 2, '0', STR_PAD_LEFT); ?></td>
                        <td class="desc"><h3><?=lang('no_items_used');?></td>
                        <td class="unit"><?= $settings->currency ?> 0.00</td>
                        <td class="qty">0</td>
                        <td class="total">0.00</td>
                    </tr>
                <?php endif; ?>

                
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="2" rowspan="6" id="comment"><textarea id="comment" onkeyup="auto_grow(this)" contentEditable="true"><?=$db['comment']; ?></textarea></td>
                    <td colspan="2"><?= $this->lang->line('subtotal');?></td>
                    <td contentEditable="true"><?= $settings->currency ?> <?=number_format($price_without_tax, 2);?></td>
                </tr>
                <tr>
                    <td colspan="2"><?= $this->lang->line('reparation_service_charges');?></td>
                    <td contentEditable="true"><?= $settings->currency ?> <?= number_format($db['service_charges'], 2); ?></td>
                </tr>
                <tr>

                    <td colspan="2"><?= $this->lang->line('tax');?> <?= $tax_rate ? $tax_rate->name : '' ?></td>
                    <td contentEditable="true"><?= $settings->currency ?> <?=number_format($tax, 2);?></td>
                </tr>
                <tr>
                    <td colspan="2"><?= $this->lang->line('total');?></td>
                    <td contentEditable="true"><?= $settings->currency ?> <?=number_format($total, 2);?></td>
                </tr>
                <tr>
                    <td colspan="2"> <?= lang('reparation_advance'); ?> </td>
                    <td contentEditable="true"><?= number_format($advance, 2) ?> </td>
                </tr>
                <tr>
                    <td colspan="2"> <?= lang('payable'); ?> </td>
                    <td contentEditable="true"><?= number_format(($total - $advance), 2) ?> </td>
                </tr>
                
            </tfoot>
        </table>
        <hr>
        <?= $settings->disclaimer; ?>

    </main>
    
    <div id="print_button"><?= $this->lang->line('print');?></div>

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
<style type="text/css">
    @media print {
        html, body {
            height: 99%;    
        }
    }
</style>

</html>

