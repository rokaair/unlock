<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<style>
    .table td:first-child {
        font-weight: bold;
    }

    label {
        margin-right: 10px;
    }
    
</style>
<section class="panel">
    <div class="panel-body">
        <div class="col-lg-12">
            <p class="introtext"><?= lang("set_permissions"); ?></p>

            <?php if (!empty($p)) {
                if ($p->group_id != 1) {
                echo form_open("panel/auth/permissions/" . $id); 
            ?>
                <div class="table-responsive">
                    <table id="perms" class="table table-bordered table-hover table-striped">

                        <thead>
                        <tr>
                            <th colspan="6"
                                class="text-center"><?php echo $group->description . ' ( ' . $group->name . ' ) ' . $this->lang->line("group_permissions"); ?></th>
                        </tr>
                        
                        <tr>
                            <th class="text-center"><?= lang('activity'); ?></th>
                            <th class="text-center"><?= lang("view"); ?></th>
                            <th class="text-center"><?= lang("add"); ?></th>
                            <th class="text-center"><?= lang("edit"); ?></th>
                            <th class="text-center"><?= lang("delete"); ?></th>
                            <th class="text-center"><?= lang("misc"); ?></th>
                        </tr>
                        </thead>
                        <tbody>
                           <tr>
                               
                                <td colspan="6"><center><h3><?= lang('general_permissions'); ?></h3></center></td>
                            </tr>
                            <tr>
                                <td>Repairs</td>
                                <td class="text-center">
                                    <input type="checkbox" value="1" class="checkbox" name="repair-index" <?php echo $p->{'repair-index'} ? "checked" : ''; ?>>
                                </td>
                                <td class="text-center">
                                    <input type="checkbox" value="1" class="checkbox" name="repair-add" <?php echo $p->{'repair-add'} ? "checked" : ''; ?>>
                                </td>
                                <td class="text-center">
                                    <input type="checkbox" value="1" class="checkbox" name="repair-edit" <?php echo $p->{'repair-edit'} ? "checked" : ''; ?>>
                                </td>
                                <td class="text-center">
                                    <input type="checkbox" value="1" class="checkbox" name="repair-delete" <?php echo $p->{'repair-delete'} ? "checked" : ''; ?>>
                                </td>
                                <td>
                                    <span style="inline-block">
                                        <input type="checkbox" value="1" class="checkbox" id="repair-view_repair" name="repair-view_repair" <?php echo $p->{'repair-view_repair'} ? "checked" : ''; ?>>
                                        <label for="repair-view_repair" class="padding05">View a Repair</label>
                                    </span>
                                    <span style="inline-block">
                                        <input type="checkbox" value="1" class="checkbox" id="reparation-print_barcodes" name="reparation-print_barcodes" <?php echo $p->{'reparation-print_barcodes'} ? "checked" : ''; ?>>
                                        <label for="reparation-print_barcodes" class="padding05">Print Repair Barcodes</label>
                                    </span>
                                </td>
                            </tr>

                            <tr>
                                <td>Customers</td>
                                <td class="text-center">
                                    <input type="checkbox" value="1" class="checkbox" name="customers-index" <?php echo $p->{'customers-index'} ? "checked" : ''; ?>>
                                </td>
                                <td class="text-center">
                                    <input type="checkbox" value="1" class="checkbox" name="customers-add" <?php echo $p->{'customers-add'} ? "checked" : ''; ?>>
                                </td>
                                <td class="text-center">
                                    <input type="checkbox" value="1" class="checkbox" name="customers-edit" <?php echo $p->{'customers-edit'} ? "checked" : ''; ?>>
                                </td>
                                
                                <td class="text-center">
                                    <input type="checkbox" value="1" class="checkbox" name="customers-delete" <?php echo $p->{'customers-delete'} ? "checked" : ''; ?>>
                                </td>
                                <td>
                                    <span style="inline-block">
                                        <input type="checkbox" value="1" class="checkbox" id="customers-view_customer" name="customers-view_customer" <?php echo $p->{'customers-view_customer'} ? "checked" : ''; ?>>
                                        <label for="customers-view_customer" class="padding05">View a Customer</label>
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td>Inventory</td>
                                <td class="text-center">
                                    <input type="checkbox" value="1" class="checkbox" name="inventory-index" <?php echo $p->{'inventory-index'} ? "checked" : ''; ?>>
                                </td>
                                <td class="text-center">
                                    <input type="checkbox" value="1" class="checkbox" name="inventory-add" <?php echo $p->{'inventory-add'} ? "checked" : ''; ?>>
                                </td>
                                <td class="text-center">
                                    <input type="checkbox" value="1" class="checkbox" name="inventory-edit" <?php echo $p->{'inventory-edit'} ? "checked" : ''; ?>>
                                </td>
                                
                                <td class="text-center">
                                    <input type="checkbox" value="1" class="checkbox" name="inventory-delete" <?php echo $p->{'inventory-delete'} ? "checked" : ''; ?>>
                                </td>
                                <td>
                                    <span style="inline-block">
                                        <input type="checkbox" value="1" class="checkbox" id="inventory-print_barcodes" name="inventory-print_barcodes" <?php echo $p->{'inventory-print_barcodes'} ? "checked" : ''; ?>>
                                        <label for="inventory-print_barcodes" class="padding05">Print Barcodes</label>
                                    </span>
                                    <span style="inline-block">
                                        <input type="checkbox" value="1" class="checkbox" id="inventory-product_actions" name="inventory-product_actions" <?php echo $p->{'inventory-product_actions'} ? "checked" : ''; ?>>
                                        <label for="inventory-product_actions" class="padding05">Misc Actions</label>
                                    </span>
                                    
                                </td>
                            </tr>
                            <tr>
                                <td>Suppliers</td>
                                <td class="text-center">
                                    <input type="checkbox" value="1" class="checkbox" name="inventory-suppliers" <?php echo $p->{'inventory-suppliers'} ? "checked" : ''; ?>>
                                </td>
                                <td class="text-center">
                                    <input type="checkbox" value="1" class="checkbox" name="inventory-add_supplier" <?php echo $p->{'inventory-add_supplier'} ? "checked" : ''; ?>>
                                </td>
                                <td class="text-center">
                                    <input type="checkbox" value="1" class="checkbox" name="inventory-edit_supplier" <?php echo $p->{'inventory-edit_supplier'} ? "checked" : ''; ?>>
                                </td>
                                
                                <td class="text-center">
                                    <input type="checkbox" value="1" class="checkbox" name="inventory-delete_supplier" <?php echo $p->{'inventory-delete_supplier'} ? "checked" : ''; ?>>
                                </td>
                                <td>
                                    
                                </td>
                            </tr>
                            <tr>
                                <td>Models</td>
                                <td class="text-center">
                                    <input type="checkbox" value="1" class="checkbox" name="inventory-models" <?php echo $p->{'inventory-models'} ? "checked" : ''; ?>>
                                </td>
                                <td class="text-center">
                                    <input type="checkbox" value="1" class="checkbox" name="inventory-add_model" <?php echo $p->{'inventory-add_model'} ? "checked" : ''; ?>>
                                </td>
                                <td class="text-center">
                                    <input type="checkbox" value="1" class="checkbox" name="inventory-edit_model" <?php echo $p->{'inventory-edit_model'} ? "checked" : ''; ?>>
                                </td>
                                
                                <td class="text-center">
                                    <input type="checkbox" value="1" class="checkbox" name="inventory-delete_model" <?php echo $p->{'inventory-delete_model'} ? "checked" : ''; ?>>
                                </td>
                                <td>
                                    
                                </td>
                            </tr>
                            <tr>
                                <td>Purchases</td>
                                <td class="text-center">
                                    <input type="checkbox" value="1" class="checkbox" name="purchases-index" <?php echo $p->{'purchases-index'} ? "checked" : ''; ?>>
                                </td>
                                <td class="text-center">
                                    <input type="checkbox" value="1" class="checkbox" name="purchases-add" <?php echo $p->{'purchases-add'} ? "checked" : ''; ?>>
                                </td>
                                <td class="text-center">
                                    <input type="checkbox" value="1" class="checkbox" name="purchases-edit" <?php echo $p->{'purchases-edit'} ? "checked" : ''; ?>>
                                </td>
                                
                                <td class="text-center">
                                    <input type="checkbox" value="1" class="checkbox" name="purchases-delete" <?php echo $p->{'purchases-delete'} ? "checked" : ''; ?>>
                                </td>
                                <td>
                                    
                                </td>
                            </tr>
                            <tr>
                                <td>Users</td>
                                <td class="text-center">
                                    <input type="checkbox" value="1" class="checkbox" name="auth-index" <?php echo $p->{'auth-index'} ? "checked" : ''; ?>>
                                </td>
                                <td class="text-center">
                                    <input type="checkbox" value="1" class="checkbox" name="auth-create_user" <?php echo $p->{'auth-create_user'} ? "checked" : ''; ?>>
                                </td>
                                <td class="text-center">
                                    <input type="checkbox" value="1" class="checkbox" name="auth-edit_user" <?php echo $p->{'auth-edit_user'} ? "checked" : ''; ?>>
                                </td>
                                
                                <td class="text-center">
                                    <input type="checkbox" value="1" class="checkbox" name="auth-delete_user" <?php echo $p->{'auth-delete_user'} ? "checked" : ''; ?>>
                                </td>
                                <td>
                                    
                                </td>
                            </tr>

                            <tr>
                                <td>User Groups</td>
                                <td class="text-center">
                                    <input type="checkbox" value="1" class="checkbox" name="auth-user_groups" <?php echo $p->{'auth-user_groups'} ? "checked" : ''; ?>>
                                </td>
                                <td class="text-center">
                                    <input type="checkbox" value="1" class="checkbox" name="auth-create_group" <?php echo $p->{'auth-create_group'} ? "checked" : ''; ?>>
                                </td>
                                <td class="text-center">
                                    <input type="checkbox" value="1" class="checkbox" name="auth-edit_group" <?php echo $p->{'auth-edit_group'} ? "checked" : ''; ?>>
                                </td>
                                
                                <td class="text-center">
                                    <input type="checkbox" value="1" class="checkbox" name="auth-delete_group" <?php echo $p->{'auth-delete_group'} ? "checked" : ''; ?>>
                                </td>
                                <td>
                                    <span style="inline-block">
                                        <input type="checkbox" value="1" class="checkbox" id="auth-permissions" name="auth-permissions" <?php echo $p->{'auth-permissions'} ? "checked" : ''; ?>>
                                        <label for="auth-permissions" class="padding05">Permissions</label>
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td>Tax Rates</td>
                                <td class="text-center">
                                    <input type="checkbox" value="1" class="checkbox" name="tax_rates-index" <?php echo $p->{'tax_rates-index'} ? "checked" : ''; ?>>
                                </td>
                                <td class="text-center">
                                    <input type="checkbox" value="1" class="checkbox" name="tax_rates-add" <?php echo $p->{'tax_rates-add'} ? "checked" : ''; ?>>
                                </td>
                                <td class="text-center">
                                    <input type="checkbox" value="1" class="checkbox" name="tax_rates-edit" <?php echo $p->{'tax_rates-edit'} ? "checked" : ''; ?>>
                                </td>
                                <td class="text-center">
                                    <input type="checkbox" value="1" class="checkbox" name="tax_rates-delete" <?php echo $p->{'tax_rates-delete'} ? "checked" : ''; ?>>
                                </td>
                                <td>
                                    
                                </td>
                            </tr>
                            <tr>
                                <td>Categories</td>
                                <td class="text-center">
                                    <input type="checkbox" value="1" class="checkbox" name="categories-index" <?php echo $p->{'categories-index'} ? "checked" : ''; ?>>
                                </td>
                                <td class="text-center">
                                    <input type="checkbox" value="1" class="checkbox" name="categories-add" <?php echo $p->{'categories-add'} ? "checked" : ''; ?>>
                                </td>
                                <td class="text-center">
                                    <input type="checkbox" value="1" class="checkbox" name="categories-edit" <?php echo $p->{'categories-edit'} ? "checked" : ''; ?>>
                                </td>
                                <td class="text-center">
                                    <input type="checkbox" value="1" class="checkbox" name="categories-delete" <?php echo $p->{'categories-delete'} ? "checked" : ''; ?>>
                                </td>
                                <td>
                                    
                                </td>
                            </tr>

                            <tr>
                                <td>Manufacturers</td>
                                <td class="text-center">
                                    <input type="checkbox" value="1" class="checkbox" name="inventory-manufacturers" <?php echo $p->{'inventory-manufacturers'} ? "checked" : ''; ?>>
                                </td>
                                <td class="text-center">
                                    <input type="checkbox" value="1" class="checkbox" name="inventory-add_manufacturer" <?php echo $p->{'inventory-add_manufacturer'} ? "checked" : ''; ?>>
                                </td>
                                <td class="text-center">
                                    <input type="checkbox" value="1" class="checkbox" name="inventory-edit_manufacturer" <?php echo $p->{'inventory-edit_manufacturer'} ? "checked" : ''; ?>>
                                </td>
                                <td class="text-center">
                                    <input type="checkbox" value="1" class="checkbox" name="inventory-delete_manufacturer" <?php echo $p->{'inventory-delete_manufacturer'} ? "checked" : ''; ?>>
                                </td>
                                <td>
                                    
                                </td>
                            </tr>

                             <tr>
                                <td>Repair Statuses</td>
                                <td class="text-center">
                                    <input type="checkbox" value="1" class="checkbox" name="repair_statuses-index" <?php echo $p->{'repair_statuses-index'} ? "checked" : ''; ?>>
                                </td>
                                <td class="text-center">
                                    <input type="checkbox" value="1" class="checkbox" name="repair_statuses-add" <?php echo $p->{'repair_statuses-add'} ? "checked" : ''; ?>>
                                </td>
                                <td class="text-center">
                                    <input type="checkbox" value="1" class="checkbox" name="repair_statuses-edit" <?php echo $p->{'repair_statuses-edit'} ? "checked" : ''; ?>>
                                </td>
                                <td class="text-center">
                                    <input type="checkbox" value="1" class="checkbox" name="repair_statuses-delete" <?php echo $p->{'repair_statuses-delete'} ? "checked" : ''; ?>>
                                </td>
                                <td>
                                    <span style="inline-block">
                                        <input type="checkbox" value="1" class="checkbox" id="repair_statuses-sort" name="repair_statuses-sort" <?php echo $p->{'repair_statuses-sort'} ? "checked" : ''; ?>>
                                        <label for="repair_statuses-sort" class="padding05">Repair Statuses Sort</label>
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td>View Reports</td>
                                <td colspan="5">
                                    <span style="inline-block">
                                        <input type="checkbox" value="1" class="checkbox" id="reports-stock" name="reports-stock" <?php echo $p->{'reports-stock'} ? "checked" : ''; ?>>
                                        <label for="reports-stock" class="padding05">Stock Chart</label>
                                    </span>

                                    <span style="inline-block">
                                        <input type="checkbox" value="1" class="checkbox" id="reports-finance" name="reports-finance" <?php echo $p->{'reports-finance'} ? "checked" : ''; ?>>
                                        <label for="reports-finance" class="padding05">Finance Chart</label>
                                    </span>

                                    <span style="inline-block">
                                        <input type="checkbox" value="1" class="checkbox" id="reports-quantity_alerts" name="reports-quantity_alerts" <?php echo $p->{'reports-quantity_alerts'} ? "checked" : ''; ?>>
                                        <label for="reports-quantity_alerts" class="padding05">Quantity Alerts</label>
                                    </span>

                                </td>
                            </tr>

                            <tr>
                                <td>Utilities</td>
                                <td colspan="5">
                                    <span style="inline-block">
                                        <input type="checkbox" value="1" class="checkbox" id="utilities-index" name="utilities-index" <?php echo $p->{'utilities-index'} ? "checked" : ''; ?>>
                                        <label for="utilities-index" class="padding05">View</label>
                                    </span>

                                    <span style="inline-block">
                                        <input type="checkbox" value="1" class="checkbox" id="utilities-backup_db" name="utilities-backup_db" <?php echo $p->{'utilities-backup_db'} ? "checked" : ''; ?>>
                                        <label for="utilities-backup_db" class="padding05">Backup DB</label>
                                    </span>

                                    <span style="inline-block">
                                        <input type="checkbox" value="1" class="checkbox" id="utilities-restore_db" name="utilities-restore_db" <?php echo $p->{'utilities-restore_db'} ? "checked" : ''; ?>>
                                        <label for="utilities-restore_db" class="padding05">Restore DB</label>
                                    </span>
                                    <span style="inline-block">
                                        <input type="checkbox" value="1" class="checkbox" id="utilities-remove_db" name="utilities-remove_db" <?php echo $p->{'utilities-remove_db'} ? "checked" : ''; ?>>
                                        <label for="utilities-remove_db" class="padding05">Remove DB</label>
                                    </span>


                                </td>
                            </tr>
                            <tr>
                                <td>Settings</td>
                                <td colspan="5">
                                    <span style="inline-block">
                                        <input type="checkbox" value="1" class="checkbox" id="settings-general" name="settings-general" <?php echo $p->{'settings-general'} ? "checked" : ''; ?>>
                                        <label for="settings-general" class="padding05">General Settings</label>
                                    </span>
                                    <span style="inline-block">
                                        <input type="checkbox" value="1" class="checkbox" id="settings-orders" name="settings-orders" <?php echo $p->{'settings-orders'} ? "checked" : ''; ?>>
                                        <label for="settings-orders" class="padding05">Order &amp; Reparations</label>
                                    </span>
                                    <span style="inline-block">
                                        <input type="checkbox" value="1" class="checkbox" id="settings-invoice" name="settings-invoice" <?php echo $p->{'settings-invoice'} ? "checked" : ''; ?>>
                                        <label for="settings-invoice" class="padding05">Invoice</label>
                                    </span>
                                    <span style="inline-block">
                                        <input type="checkbox" value="1" class="checkbox" id="settings-sms" name="settings-sms" <?php echo $p->{'settings-sms'} ? "checked" : ''; ?>>
                                        <label for="settings-sms" class="padding05">SMS</label>
                                    </span>
                                    <span style="inline-block">
                                        <input type="checkbox" value="1" class="checkbox" id="settings-appearance" name="settings-appearance" <?php echo $p->{'settings-appearance'} ? "checked" : ''; ?>>
                                        <label for="settings-appearance" class="padding05">Appearance</label>
                                    </span>

                                    <span style="inline-block">
                                        <input type="checkbox" value="1" class="checkbox" id="settings-upload_logo" name="settings-upload_logo" <?php echo $p->{'settings-upload_logo'} ? "checked" : ''; ?>>
                                        <label for="settings-upload_logo" class="padding05">Upload Logo</label>
                                    </span>
                                    <span style="inline-block">
                                        <input type="checkbox" value="1" class="checkbox" id="settings-upload_background" name="settings-upload_background" <?php echo $p->{'settings-upload_background'} ? "checked" : ''; ?>>
                                        <label for="settings-upload_background" class="padding05">Upload Login Background</label>
                                    </span>
                                    
                                </td>
                            </tr>
                            <tr>
                                <td>Miscellanous</td>
                                <td colspan="5">
                                    <span style="inline-block">
                                        <input type="checkbox" value="1" class="checkbox" id="dashboard-qemail" name="dashboard-qemail" <?php echo $p->{'dashboard-qemail'} ? "checked" : ''; ?>>
                                        <label for="dashboard-qemail" class="padding05">Quick Email</label>
                                    </span>
                                    <span style="inline-block">
                                        <input type="checkbox" value="1" class="checkbox" id="dashboard-qsms" name="dashboard-qsms" <?php echo $p->{'dashboard-qsms'} ? "checked" : ''; ?>>
                                        <label for="dashboard-qsms" class="padding05">Quick SMS</label>
                                    </span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="form-actions">
                    <button type="submit" class="btn btn-primary"><?=lang('update')?></button>
                </div>
                <?php echo form_close();
            } else {
                echo $this->lang->line("group_x_allowed");
            }
        } else {
            echo $this->lang->line("group_x_allowed");
        } ?>
    </div>
</section>

<script src="<?= base_url(); ?>assets/plugins/floatThead/jquery.floatThead.min.js"></script>
<script type="text/javascript">
$(document).ready(function(){
    $('input[type=checkbox]').iCheck({
        checkboxClass: 'icheckbox_flat',
        radioClass: 'iradio_flat'
    });
});

</script>