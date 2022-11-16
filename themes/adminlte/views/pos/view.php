<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title><?="Invoice " . lang("no") . ": " . $inv->id;?></title>
    <base href="<?=base_url()?>"/>
    <meta http-equiv="cache-control" content="max-age=0"/>
    <meta http-equiv="cache-control" content="no-cache"/>
    <meta http-equiv="expires" content="0"/>
    <meta http-equiv="pragma" content="no-cache"/>
    <link rel="stylesheet" href="<?= $assets ?>bower_components/bootstrap/dist/css/bootstrap.min.css">
        <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">

    <!-- <link rel="stylesheet" href="<?=base_url();?>assets/dist/css/theme.css" type="text/css"/> -->
    <style type="text/css" media="all">
        body { color: #000; }
        #wrapper { max-width: 480px; margin: 0 auto; padding-top: 20px; }
        .btn { border-radius: 0; margin-bottom: 5px; }
        .bootbox .modal-footer { border-top: 0; text-align: center; }
        h3 { margin: 5px 0; }
        .order_barcodes img { float: none !important; margin-top: 5px; }
        @media print {
            .no-print { display: none; }
            #wrapper { max-width: 480px; width: 100%; min-width: 250px; margin: 0 auto; }
            .no-border { border: none !important; }
            .border-bottom { border-bottom: 1px solid #ddd !important; }
            table tfoot { display: table-row-group; }
        }

        #print_button {
            height 25px;
            width: 25%;
            line-height: 25px;
            position: fixed;
            left: 25%;
            bottom: 0px;
            color: white;
            font-weight: bold;
            text-align: center;
            font-size: 17px;
            border-top-left-radius: 15px;
            border-top-right-radius: 15px;
            cursor: pointer;
            background-color: crimson;
            margin-bottom: 0; 

        }
        #print_button:hover {
            background-color: #3A3A3A;
        }

        #back_button {
            height 25px;
            width: 25%;
            line-height: 25px;
            position: fixed;
            left: 50%;
            bottom: 0px;
            color: white;
            font-weight: bold;
            text-align: center;
            font-size: 17px;
            border-top-left-radius: 15px;
            border-top-right-radius: 15px;
            cursor: pointer;
            background-color: green;
            margin-bottom: 0; 

        }

        #back_button:hover {
            background-color: #3A3A3A;
        }

        body {
            font-family: 'Open Sans', sans-serif  !important;
            font-weight: bolder !important;
        }
    </style>
</head>
<body>
    <div id="wrapper">
        <div id="receiptData">
            <div class="no-print">
                <?php
                if ($message) {
                    ?>
                    <div class="alert alert-success">
                        <button data-dismiss="alert" class="close" type="button">×</button>
                        <?=is_array($message) ? print_r($message, true) : $message;?>
                    </div>
                    <?php
                } ?>
            </div>
            <div id="receipt-data">
                <div class="text-center">
                    <?= '<img width="400px" src="'.base_url('assets/uploads/logos/'.$logo).'" alt="">' ?>
                    <h3 style="text-transform:uppercase;"><?=$biller->company != '-' ? $biller->company : $biller->name;?></h3>
                    <?php
                    echo "<p>" . $biller->address . "<br>" . lang("tel") . ": " . $biller->phone;
                    echo '</p>';
                    ?>
                </div>
               
                <?php
                
                echo "<p>" .lang("date") . ": " . date('d-m-Y', strtotime($inv->date)) . "<br>";
                echo lang("sale_no_ref") . ": " . sprintf("%04d", $inv->id) . "<br>";
                
                echo lang("sales_person") . ": " . $created_by->first_name." ".$created_by->last_name . "</p>";
                echo "<p>";
                echo lang("customer") . ": " . ($customer ? $customer->name : lang('walk_in')) . "<br>";
                echo "</p>";
                ?>
                <div style="clear:both;"></div>
                <table class="table table-striped table-condensed">
                    <thead>
                        <tr>
                            <th><?= lang('#'); ?></th>
                            <th><?= lang('product_name'); ?></th>
                            <th><?= lang('price'); ?></th>
                            <th><?= lang('quantity'); ?></th>
                            <th class="text-right"><?= lang('tax');?></th>
                            <th class="text-right"><?= lang('total');?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $r = 1;
                        foreach ($rows as $row) : ?>
                            <tr>
                                <td><?= $r; ?></td>
                                <td><?= product_name($row->product_name, null); ?></td>
                                <td><?= $this->repairer->formatMoney($row->unit_price); ?></td>
                                <td class="text-center"><?= $this->repairer->formatQuantity($row->quantity); ?></td>
                                <td class="text-right"><?= $this->repairer->formatMoney($row->item_tax); ?> (<?= ($row->tax_code ? '*'.$row->tax_code : ''); ?>)</td>
                                <td class="text-right"><?= $this->repairer->formatMoney($row->subtotal); ?></td>
                                
                            </tr>
                       <?php $r++; endforeach; ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan="5"><?=lang("total");?></th>
                            <th class="text-right"><?=$this->repairer->formatMoney(($inv->total + $inv->total_tax));?></th>
                        </tr>
                        <tr>
                            <th colspan="5"><?=lang("discount");?></th>
                            <th class="text-right"><?=$this->repairer->formatMoney($inv->total_discount);?></th>
                        </tr>
                        <tr>
                            <th colspan="5"><?=lang("grand_total");?></th>
                            <th class="text-right"><?=$this->repairer->formatMoney($inv->grand_total);?></th>
                        </tr>
                    </tfoot>
                </table>
                <?php
                if ($payments) {
                    $total_paid = 0;
                    echo '<table class="table table-striped table-condensed"><tbody>';
                    foreach ($payments as $payment) {
                        $total_paid += (float)$payment->amount;
                        echo '<tr>';
                        if (($payment->paid_by == 'cash') && $payment->pos_paid) {
                            echo '<td>' . lang("paid_by") . ': ' . lang($payment->paid_by) . '</td>';
                            echo '<td colspan="2">' . lang("amount") . ': ' . $this->repairer->formatMoney($payment->pos_paid == 0 ? $payment->amount : $payment->pos_paid). '</td>';
                            // echo '<td>' . lang("change") . ': ' . (($a < 0) ? ($a) : 0) . '</td>';
                            echo '<td class="text-right">' . lang("change") . ': ' . ($payment->pos_balance > 0 ? $this->repairer->formatMoney($payment->pos_balance) : 0) . '</td>';
                        } elseif (($payment->paid_by == 'CC' || $payment->paid_by == 'ppp') && $payment->cc_no) {
                            echo '<td>' . lang("paid_by") . ': ' . lang($payment->paid_by) . '</td>';
                            echo '<td>' . lang("amount") . ': ' . $this->repairer->formatMoney($payment->pos_paid) . '</td>';
                            echo '<td>' . lang("no") . ': ' . 'xxxx xxxx xxxx ' . substr($payment->cc_no, -4) . '</td>';
                            echo '<td>' . lang("name") . ': ' . $payment->cc_holder . '</td>';
                        } elseif ($payment->paid_by == 'Cheque' && $payment->cheque_no) {
                            echo '<td>' . lang("paid_by") . ': ' . lang($payment->paid_by) . '</td>';
                            echo '<td>' . lang("amount") . ': ' . $this->repairer->formatMoney($payment->pos_paid) . '</td>';
                            echo '<td>' . lang("cheque_no") . ': ' . $payment->cheque_no . '</td>';
                        } elseif ($payment->paid_by == 'other' && $payment->amount) {
                            echo '<td>' . lang("paid_by") . ': ' . lang($payment->paid_by) . '</td>';
                            echo '<td>' . lang("amount") . ': ' . $this->repairer->formatMoney($payment->pos_paid == 0 ? $payment->amount : $payment->pos_paid)  . '</td>';
                            echo $payment->note ? '</tr><td colspan="2">' . lang("payment_note") . ': ' . $payment->note . '</td>' : '';
                        }

                        echo '</tr>';
                    }
                    $a = $total_paid - $inv->grand_total ;

                    echo '<tr>';
                    echo '<td>Remaining Payments'.'</td>';
                    echo '<td colspan="2">' . '</td>';
                    echo '<td class="text-right">' . 'Total' . ': ' . ($a < 0 ? $a : 0) . '</td>';
                    echo '</tr>';

                    echo '</tbody></table>';
                }
                ?>
                <?= $inv->note ? '<p class="text-center">' . $this->repairer->decode_html($inv->note) . '</p>' : ''; ?>
                 <div class="well">
                    <div class="order_barcodes text-center">
                         <?= $this->repairer->barcode($inv->reference_no, 'code128', 74, false); ?>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
            <div style="clear:both;"></div>
        </div>

        <div id="buttons" style="padding-top:10px; text-transform:uppercase;" class="no-print">
            <hr>
            <?php
            if ($message) {
                ?>
                <div class="alert alert-success">
                    <button data-dismiss="alert" class="close" type="button">×</button>
                    <?=is_array($message) ? print_r($message, true) : $message;?>
                </div>
                <?php
            } ?>
            <button id="print_button" onclick="window.print();" class="btn btn-block btn-primary"><?=lang("print")?></button>
            <a id="back_button" href="<?= base_url('panel/pos'); ?>" class="btn btn-block btn-primary"><?= lang('back_to_pos'); ?></a>
            <div style="clear:both;"></div>
        </div>
    </div>
</body>
</html>
