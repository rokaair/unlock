<script>
    $(document).ready(function () {
        var oTable = $('#dynamic-table').dataTable({
            "aaSorting": [[0, "desc"]],
            "aLengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
            "iDisplayLength": 10,
            'bProcessing': true, 'bServerSide': false,
            'sAjaxSource': '<?=base_url(); ?>panel/reports/getQuantityAlerts',
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
            null,
            ],
        });
    });
</script>

    <section class="content">
        <div class="row">
            <section class="panel">
                    <div class="panel-body">
                        <div class="adv-table">
                            <table class="display compact table table-bordered table-striped" id="dynamic-table">
                                <thead>
                                    <tr>
                                        <th><?= lang('product_name'); ?></th>
                                        <th><?= lang('product_code'); ?></th>
                                        <th><?= lang('quantity'); ?></th>
                                        <th><?= lang('alert_quantity'); ?></th>
                                    </tr>
                                </thead>
                        
                                <tfoot>
                                    <tr>
                                        <th><?= lang('product_name'); ?></th>
                                        <th><?= lang('product_code'); ?></th>
                                        <th><?= lang('quantity'); ?></th>
                                        <th><?= lang('alert_quantity'); ?></th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </section>
        </div>
    </section>
