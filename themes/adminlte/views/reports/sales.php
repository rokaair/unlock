<?php
$v = "";
if ($this->input->get('date_range')) {
    $dr = explode(' - ', $this->input->get('date_range'));
    $v .= "&start_date=" . $dr[0];
    $v .= "&end_date=" . $dr[1];
}
?>

<script type="text/javascript">
    function row_status(x) {
        if(x == null) {
            return '';
        } else if(x == 'pending') {
            return '<div class="text-center"><span class="label label-warning">'+[x]+'</span></div>';
        } else if(x == 'completed' || x == 'paid' || x == 'sent' || x == 'received') {
            return '<div class="text-center"><span class="label label-success">'+[x]+'</span></div>';
        } else if(x == 'partial' || x == 'transferring' || x == 'ordered') {
            return '<div class="text-center"><span class="label label-info">'+[x]+'</span></div>';
        } else if(x == 'due' || x == 'returned') {
            return '<div class="text-center"><span class="label label-danger">'+[x]+'</span></div>';
        } else {
            return '<div class="text-center"><span class="label label-default">'+[x]+'</span></div>';
        }
    }


    function pay_status(x) {
        if(x == null) {
            return '';
        } else if(x == 'pending') {
            return '<div class="text-center"><span class="payment_status label label-warning">'+[x]+'</span></div>';
        } else if(x == 'completed' || x == 'paid' || x == 'sent' || x == 'received') {
            return '<div class="text-center"><span class="payment_status label label-success">'+[x]+'</span></div>';
        } else if(x == 'partial' || x == 'transferring' || x == 'ordered') {
            return '<div class="text-center"><span class="payment_status label label-info">'+[x]+'</span></div>';
        } else if(x == 'due' || x == 'returned') {
            return '<div class="text-center"><span class="payment_status label label-danger">'+[x]+'</span></div>';
        } else {
            return '<div class="text-center"><span class="payment_status label label-default">'+x+'</span></div>';
        }
    }
    function pqFormat(x) {
        if (x != null) {
            var d = '', pqc = x.split("___");
            for (index = 0; index < pqc.length; ++index) {
                var pq = pqc[index];
                var v = pq.split("__");
                d += v[0]+'<br>';
            }
            return d;
        } else {
            return '';
        }
    }

    function formatToMoney(x) {
        return '<span style="text-align:center">' + (parseFloat(x)).toFixed(0) + "<?=$settings->currency;?></span>";
    }
    function getFormattedDate(date){
        var dd = date.getDate();
        var mm = date.getMonth()+1;
        var yyyy = date.getFullYear();
        return mm +'/'+dd+'/'+yyyy;
    }

    $(document).ready(function () {
        $('.date').datepicker({ dateFormat: 'mm-dd-yy' });
        var oTable = $('#dynamic-table').dataTable({
            "aaSorting": [[0, "desc"]],
            "aLengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
            "iDisplayLength": 10,
            'bProcessing': true, 'bServerSide': true,
            'sAjaxSource': '<?= site_url('panel/reports/getAllSales/?v=1' . $v) ?>',
            'fnServerData': function (sSource, aoData, fnCallback) {
                aoData.push({
                    "name": "<?= $this->security->get_csrf_token_name() ?>",
                    "value": "<?= $this->security->get_csrf_hash() ?>"
                });
                $.ajax({'dataType': 'json', 'type': 'POST', 'url': sSource, 'data': aoData, 'success': fnCallback});
            }, 
            "aoColumns": [
                null,
                null,
                null,
                {mRender: pqFormat},
                {mRender: formatToMoney},
                {mRender: formatToMoney},
                {mRender: formatToMoney}, 
                {"mRender": pay_status},
                null,
            ],
            "fnFooterCallback": function (nRow, aaData, iStart, iEnd, aiDisplay) {
                var gtotal = 0, paid = 0, balance = 0;
                for (var i = 0; i < aaData.length; i++) {
                    gtotal += parseFloat(aaData[aiDisplay[i]][4]);
                    paid += parseFloat(aaData[aiDisplay[i]][5]);
                    balance += parseFloat(aaData[aiDisplay[i]][6]);
                }
                var nCells = nRow.getElementsByTagName('th');
                nCells[4].innerHTML = formatMoney(parseFloat(gtotal));
                nCells[5].innerHTML = formatMoney(parseFloat(paid));
                nCells[6].innerHTML = formatMoney(parseFloat(balance));
            }
        });
    });
</script>
<style type="text/css">
    .dataTable td:nth-child(6), .dataTable td:nth-child(5), .dataTable td:nth-child(7), .dataTable th:nth-child(6), .dataTable th:nth-child(5), .dataTable th:nth-child(7){
        text-align:center;

    }
</style>
<!-- Main content -->
<div class="pull-right">
    <div class="btn-group">
        <li class="btn btn-default" style="list-style-type: none;">
            <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                <i class="icon fa fa-tasks tip" data-placement="left" title="<?= ("actions") ?>"></i>
            </a>
            <ul class="dropdown-menu pull-right tasks-menus" role="menu" aria-labelledby="dLabel">
                <li>
                    <a href="#" id="xls" data-action="export_excel">
                        <i class="fa fa-file-excel-o"></i> <?= lang('export_to_excel') ?>
                    </a                        </li>
                <li>
                    <a href="#" id="pdf" data-action="export_pdf">
                        <i class="fa fa-file-pdf-o"></i> <?= lang('export_to_pdf') ?>
                    </a>
                </li>
            </ul>
        </li>
    </div>
</div>
        <section class="panel">
            <div class="panel-body">
                <form>
                    <div class="form-group">
                        <?= lang('date_range', 'date_range'); ?>
                        <input class="form-control" type="text" name="date_range" class="date_range" id="date_range" value='<?= $this->input->get('date_range'); ?>'>
                    </div>

                    <div class="form-group">
                        <div
                            class="controls"> <?php echo form_submit('submit_report', $this->lang->line("submit"), 'class="btn btn-primary"'); ?> </div>
                    </div>
                </form>
                <div class="table-responsive">
                    <table style="width: 100%;" class=" compact table table-bordered table-striped" id="dynamic-table">
                        <thead>
                            <tr>
                                <th><?= lang('sale_id'); ?></th>
                                <th><?= lang('date'); ?></th>
                                <th><?= lang('customer'); ?></th>
                                <th><?= lang('items'); ?></th>
                                <th><?= lang('total'); ?></th>
                                <th><?= lang('paid'); ?></th>
                                <th><?= lang('balance'); ?></th>
                                <th><?= lang("payment_status"); ?></th>
                                <th><?= lang('actions'); ?></th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th><?= lang('sale_id'); ?></th>
                                <th><?= lang('date'); ?></th>
                                <th><?= lang('customer'); ?></th>
                                <th><?= lang('items'); ?></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th><?= lang("payment_status"); ?></th>
                                <th><?= lang('actions'); ?></th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </section>
<script type="text/javascript">
    $(document).ready(function () {
        $('#pdf').click(function (event) {
            event.preventDefault();
            window.location.href = "<?=site_url('panel/reports/getAllSales/pdf/?v=1'.$v)?>";
            return false;
        });
        $('#xls').click(function (event) {
            event.preventDefault();
            window.location.href = "<?=site_url('panel/reports/getAllSales/0/xls/?v=1'.$v)?>";
            return false;
        });
        $('#date_range').daterangepicker({ format: 'YYYY/MM/DD' });
    });
</script>