<style type="text/css">
	
	#uploadimage .submit {
	    display: none;
	}
	.radio-sms label > input {
	    visibility: hidden;
	    position: absolute;
	}

	.radio-sms label > input + img{ /* IMAGE STYLES */
	    cursor:pointer;
	    opacity: 0.3;
	    max-width: 100%;
	}

	.radio-sms  label {
	    width: 100%;
	}

	.radio-sms  label > input:checked + img{/* (RADIO CHECKED) IMAGE STYLES */
	    opacity: 1;
	    margin: auto;
	    display: block;
	}
	.skebby-info, .twilio-info {
	    opacity: 0.2;
	}

	span.label {
	    width: 100%;
	    display: inline-block;
	}

</style>
<?php
$wm = array('0' => lang('no'), '1' => lang('yes'));
$ps = array('0' => lang("disable"), '1' => lang("enable"));
?>
<script type="text/javascript">
	jQuery(document).ready(function () {
        $('.my-colorpicker1').colorpicker();
$('#settingsTab a:first').tab('show')
        

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
        var url = "";
        var dataString = "";

        url = base_url + "panel/settings/save_settings";
        var dataString = $('#settings_form').serialize() + "&token=<?=$_SESSION['token'];?>";

        jQuery.ajax({
            type: "POST",
            url: url,
            data: dataString,
            cache: false,
            success: function (data) {
                toastr['success']("<?=lang('system_settings');?>", "<?=lang('settings_updated');?>");
                $("#black").fadeIn(100);
                window.location.reload();
            }
        });
        return false;
    });

        $(".nav-tabs a").click(function() {
            $(this).tab('show');
        });

        if(window.location.hash) {
            hashe = window.location.hash;
            link = hashe.split('__');
            $('.nav-tabs a[href="'+link[0]+'"]').tab('show') // Select tab by name
        }

        $('.more-list li a').on('click', function (e) {
            var link = $(this).attr('href');
            var link = link.substring(link.indexOf('#')+1);
            $('.nav-tabs a[href="#'+link+'"]').tab('show') // Select tab by name
            window.scrollTo(0, 0);
        });

        $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
          var target = $(e.target).attr("href") // activated tab
          if (target === '#appearance') {
            $('#logo_upload_div').show();
          }else{
            $('#logo_upload_div').hide();
          }
        });
    jQuery(document).on("click", "#skebby", function () {

        jQuery(".skebby-info").fadeTo( 120 , 1);
        jQuery(".twilio-info").fadeTo( 120 , 0.3);

    });

    jQuery(document).on("click", "#twilio", function () {

        jQuery(".twilio-info").fadeTo( 120 , 1);
        jQuery(".skebby-info").fadeTo( 120 , 0.3);

    });


    $("#t_mode").select2({placeholder: "Twilio Mode"});

	$("#category").select2({tags: true, tokenSeparators: [','],});

    $("#custom_fields").select2({tags: true, tokenSeparators: [',']});


    $(".nav-tabs a").click(function() {
        $(this).tab('show');
    });


    if(window.location.hash) {
        $('.nav-tabs a[href="'+window.location.hash+'"]').tab('show') // Select tab by name
    }


    $("#logo_upload").change(function() {
        $("#error_message").empty(); // To remove the previous error message
        var file = this.files[0];
        var imagefile = file.type;
        var match= ["image/jpeg","image/png","image/jpg"];
        if(!((imagefile==match[0]) || (imagefile==match[1]) || (imagefile==match[2])))
        {
            $('#preview_logo').attr('src','<?=site_url('img').'/'.$settings->logo;?>');
            toastr['error']("<?=lang('image_upload');?>", "<?=lang('error');?>");
            return false;
        }
        else
        {
            toastr['info']("<?=lang('info');?>", "<?=lang('uploading_image');?>");
            var reader = new FileReader();
            reader.onload = imageIsLoaded;
            reader.readAsDataURL(this.files[0]);
            $( "#uploadimage .submit" ).trigger( "click" );
        }
    });


   
    $('#uploadimage').submit(function(event){
        event.preventDefault();
        var formData = new FormData($(this)[0]);            

        var request = $.ajax({
            type: 'POST',
            url: base_url + 'panel/settings/upload_image',
            data: formData,
            contentType: false,
            processData: false,
            success: function(data){   
                if(data != 'true') {
                    toastr['success']("<?=lang('upload_success');?>", "<?=lang('image');?>");
                } else {
                    toastr['error']("<?=lang('error');?>", "");
                }
            }
        });             
    });

    $('#uploadBackground').submit(function(event){
        event.preventDefault();
        var formData = new FormData($(this)[0]);            

        var request = $.ajax({
            type: 'POST',
            url: base_url + 'panel/settings/upload_background',
            data: formData,
            contentType: false,
            processData: false,
            success: function(data){   
                if(data != 'true') {
                    toastr['success']("<?=lang('upload_success');?>", "<?=lang('image');?>");
                } else {
                    toastr['error']("<?=lang('error');?>", "");
                }
            }
        });             
    });
    

    $("#background_upload").change(function() {
            $("#error_message").empty(); // To remove the previous error message
            var file = this.files[0];
            var imagefile = file.type;
            var match= ["image/jpeg","image/png","image/jpg"];
            if(!((imagefile==match[0]) || (imagefile==match[1]) || (imagefile==match[2])))
            {
                    $('#preview_background').attr('src','<?=site_url('img').'/'.$settings->background;?>');
                    toastr['error']("<?=lang('image_upload');?>", "<?=lang('error');?>");
                    return false;
            }
            else
            {
                toastr['info']("<?=lang('info');?>", "<?=lang('uploading_image');?>");
                var reader = new FileReader();
                reader.onload = BGimageIsLoaded;
                reader.readAsDataURL(this.files[0]);
                $( "#uploadBackground .submit" ).trigger( "click" );
            }
    });


    function BGimageIsLoaded(e) {
            $('#preview_background').attr('src', e.target.result);
    };

    function imageIsLoaded(e) {
        $('#preview_logo').attr('src', e.target.result);
    };

    $.fn.realVal = function(){
        var $obj = $(this);
        var val = $obj.val();
        var type = $obj.attr('type');
        if (type && type==='checkbox') {
            var un_val = $obj.attr('data-unchecked');
            if (typeof un_val==='undefined') un_val = '';
            return $obj.prop('checked') ? val : un_val;
        } else {
            return val;
        }
    };

    var addRule = function(sheet, selector, styles) {
        if (sheet.insertRule) return sheet.insertRule(selector + " {" + styles + "}", sheet.cssRules.length);
        if (sheet.addRule) return sheet.addRule(selector, styles);
    };
});

</script>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="box">
            <?php if($this->Admin || ($this->GP['settings-general'] || $this->GP['settings-orders'] || $this->GP['settings-invoice'] || $this->GP['settings-sms'] || $this->GP['settings-appearance'])): ?>
            <form id="settings_form">
                <div class="box-body">
                   <!-- Nav tabs -->
                    <ul class="nav nav-tabs" role="tablist" id="settingsTab">
                        <?php if($this->Admin || $this->GP['settings-general']): ?>
                            <li role="presentation" class="active"><a href="#general" aria-controls="home" role="tab" data-toggle="tab"><?= lang('general_settings_title'); ?></a></li>
                        <?php endif; ?>
                        <?php if($this->Admin || $this->GP['settings-orders']): ?>
                            <li role="presentation"><a href="#orders" aria-controls="profile" role="tab" data-toggle="tab"><?= lang('reparation');?></a></li>
                        <?php endif; ?>
                        <?php if($this->Admin || $this->GP['settings-invoice']): ?>
                            <li role="presentation"><a href="#invoice" aria-controls="messages" role="tab" data-toggle="tab"><?= lang('invoice_title'); ?></a></li>
                        <?php endif; ?>
                        <?php if($this->Admin || $this->GP['settings-sms']): ?>
                            <li role="presentation"><a href="#sms" aria-controls="settings" role="tab" data-toggle="tab"><?= lang('sms_title'); ?></a></li>
                        <?php endif; ?>
                        <?php if($this->Admin || $this->GP['settings-appearance']): ?>
                            <li role="presentation"><a href="#appearance" aria-controls="appearance" role="tab" data-toggle="tab"><?= lang('appearance'); ?></a></li>
                        <?php endif; ?>
                    </ul>

                    <!-- Tab panes -->
                    <div class="tab-content">
                        <?php if($this->Admin || $this->GP['settings-general']): ?>
                        <div role="tabpanel" class="tab-pane active" id="general">
                            <h3><?=lang('general_settings_title');?></h3>
                    		<div class="col-lg-12">
                    			<div class="form-group">
                    				<?=lang('company_title', 'title');?>
                    				<div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fa  fa-quote-left"></i>
                                        </div>
                    					<input id="title" name="title" type="text" class="validate form-control" value="<?= $settings->title; ?>">
                    				</div>
                    			</div>
                    		</div>
                    		<div class="col-lg-4">
                    			<div class="form-group">
                                    <?=lang('language', 'language');?>
                                    <?php $scanned_lang_dir = array_map(function ($path) {
                                        return basename($path);
                                    }, glob(APPPATH . 'language/*', GLOB_ONLYDIR));
                                    ?>
                    				<select id="language" name="language" data-num="1" class="form-control m-bot15" style="width: 100%">
                    					<?php foreach ($scanned_lang_dir as $dir):
                    						$language = basename($dir); ?>
                                            <option value="<?= $language; ?>" <?= ($language == $settings->language) ? 'selected' : '' ?>><?= $language; ?></option>
                    					<?php endforeach; ?>
                    				</select>
                    			</div>
                    		</div>
                    		<div class="col-lg-4">
                    			<div class="form-group">
                                    <?=lang('currency', 'currency');?>
                    				<input id="currency" name="currency" type="text" class="validate form-control" value="<?= $settings->currency; ?>">
                    			</div>
                    		</div>
                    		<div class="col-md-4">
                                <div class="form-group">
                                    <label class="control-label" for="product_discount"><?= lang("product_level_discount"); ?></label>
                                    <div class="controls">
                                        <?php
                                        echo form_dropdown('product_discount', $ps, $settings->product_discount, 'id="product_discount" class="form-control tip" required="required" style="width:100%;"');
                                        ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="control-label"
                                           for="purchase_prefix"><?= lang("purchase_prefix"); ?></label>

                                    <?= form_input('purchase_prefix', $settings->purchase_prefix, 'class="form-control tip" id="purchase_prefix"'); ?>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="control-label"
                                           for="reference_format"><?= lang("reference_format"); ?></label>

                                    <div class="controls">
                                        <?php
                                        $ref = array(1 => lang('prefix_year_no'), 2 => lang('prefix_month_year_no'), 3 => lang('sequence_number'));
                                        echo form_dropdown('reference_format', $ref, $settings->reference_format, 'class="form-control tip" required="required" id="reference_format" style="width:100%;"');
                                        ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="control-label" for="decimals"><?= lang("decimals"); ?></label>

                                    <div class="controls"> <?php
                                        $decimals = array(0 => lang('disable'), 1 => '1', 2 => '2', 3 => '3', 4 => '4');
                                        echo form_dropdown('decimals', $decimals, $settings->decimals, 'class="form-control tip" id="decimals"  style="width:100%;" required="required"');
                                        ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="control-label" for="qty_decimals"><?= lang("qty_decimals"); ?></label>

                                    <div class="controls"> <?php
                                        $qty_decimals = array(0 => lang('disable'), 1 => '1', 2 => '2', 3 => '3', 4 => '4');
                                        echo form_dropdown('qty_decimals', $qty_decimals, $settings->qty_decimals, 'class="form-control tip" id="qty_decimals"  style="width:100%;" required="required"');
                                        ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <?= lang("product_tax", "tax_rate"); ?>
                                    <?php $tr['0'] = lang("disable");
                                    foreach ($tax_rates as $rate) {
                                        $tr[$rate['id']] = $rate['name'];
                                    }
                                    echo form_dropdown('tax_rate', $tr, $settings->default_tax_rate, 'class="form-control tip" id="tax_rate" required="required" style="width:100%;"');
                                    ?>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <?= lang("invoice_tax", "tax_rate2"); ?>
                                    <?php $tr['0'] = lang("disable");
                                    foreach ($tax_rates as $rate) {
                                        $tr[$rate['id']] = $rate['name'];
                                    }
                                    echo form_dropdown('tax_rate2', $tr, $settings->default_tax_rate2, 'id="tax_rate2" class="form-control tip" required="required" style="width:100%;"'); ?>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <?= lang('update_cost_with_purchase', 'update_cost'); ?>
                                    <?= form_dropdown('update_cost', $wm, $settings->update_cost, 'class="form-control" id="update_cost" required="required"'); ?>
                                </div>
                            </div>
                             <div class="col-md-4">
                                <div class="form-group">
                                    <label class="control-label" for="bc_fix"><?= lang("bc_fix"); ?></label>
                                    <?= form_input('bc_fix', $settings->bc_fix, 'class="form-control tip" required="required" id="bc_fix"'); ?>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="control-label" for="disable_editing"><?= lang("disable_editing"); ?></label>
                                    <?= form_input('disable_editing', $settings->disable_editing, 'class="form-control tip" id="disable_editing" required="required"'); ?>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="control-label" for="model_based_search"><?= lang("model_based_search"); ?></label>
                                    <?= form_dropdown('model_based_search', $wm, $settings->model_based_search, 'class="form-control" id="model_based_search" required="required"'); ?>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="control-label" for="image_size"><?= lang("image_size"); ?> (Width :
                                        Height) *</label>

                                    <div class="row">
                                        <div class="col-xs-6">
                                            <?= form_input('iwidth', $settings->iwidth, 'class="form-control tip" id="iwidth" placeholder="image width" required="required"'); ?>
                                        </div>
                                        <div class="col-xs-6">
                                            <?= form_input('iheight', $settings->iheight, 'class="form-control tip" id="iheight" placeholder="image height" required="required"'); ?></div>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="control-label" for="thumbnail_size"><?= lang("thumbnail_size"); ?>
                                        (Width : Height) *</label>

                                    <div class="row">
                                        <div class="col-xs-6">
                                            <?= form_input('twidth', $settings->twidth, 'class="form-control tip" id="twidth" data-parsley-type="number" placeholder="thumbnail width" required="required"'); ?>
                                        </div>
                                        <div class="col-xs-6">
                                            <?= form_input('theight', $settings->theight, 'class="form-control tip" id="theight" data-parsley-type="number" placeholder="thumbnail height" required="required"'); ?>
                                        </div>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <?= lang('watermark', 'watermark'); ?>
                                    <?php
                                        echo form_dropdown('watermark', $wm, (isset($_POST['watermark']) ? $_POST['watermark'] : $settings->watermark), 'class="tip form-control" required="required" id="watermark" style="width:100%;"');
                                    ?>
                                </div>
                            </div>

                             <div class="col-md-4">
                                <div class="form-group">
                                    <?php
                                    $rows_per_page = array(
                                        -1 => "All",
                                        10 => "10",
                                        25 => "25",
                                        50 => "50",
                                        100 => "100",
                                    ); 

                                    ?>
                                    <label class="control-label" for="rows_per_page"><?= lang("rows_per_page"); ?></label>
                                    <?= form_dropdown('rows_per_page', $rows_per_page,$settings->rows_per_page, 'class="form-control tip" id="rows_per_page" required="required"'); ?>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <?= lang('enable_recaptcha', 'enable_recaptcha'); ?>
                                    <?= form_dropdown('enable_recaptcha', $wm, $settings->enable_recaptcha, 'class="form-control" id="enable_recaptcha" required="required"'); ?>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <?=lang('google_site_key', 'google_site_key');?>
                                    <input name="google_site_key" id="google_site_key" type="text" class="validate form-control" value="<?= $settings->google_site_key; ?>">
                                </div>
                            </div>

                            <div class="col-lg-4">
                                <div class="form-group">
                                    <?=lang('google_secret_key', 'google_secret_key');?>
                                    <input name="google_secret_key" id="google_secret_key" type="text" class="validate form-control" value="<?= $settings->google_secret_key; ?>">
                                </div>
                            </div>

                            <div class="col-lg-4">
                                <div class="form-group">
                                    <?=lang('google_api_key', 'google_api_key');?>
                                    <input name="google_api_key" id="google_api_key" type="text" class="validate form-control" value="<?= $settings->google_api_key; ?>">
                                </div>
                            </div>
                            <?php 
                                $templates = array(
                                    1 => lang('BasicTemplate'),
                                    2 => lang('ProTemplate'),
                                    3 => lang('RecieptTemplate'),
                                );
                            ?>

                            <div class="col-lg-4">
                                <div class="form-group">
                                    <?=lang('invoice_template', 'invoice_template');?>
                                    <?= form_dropdown('invoice_template', $templates, $settings->invoice_template, 'class="form-control m-bot15" style="width: 100%"'); ?>
                                </div>
                            </div>

                            <div class="col-lg-4">
                                <div class="form-group">
                                    <?=lang('report_template', 'report_template');?>
                                    <?= form_dropdown('report_template', $templates, $settings->report_template, 'class="form-control m-bot15" style="width: 100%"'); ?>
                                </div>
                            </div>

                            <div class="col-lg-4">
                                <div class="form-group">
                                    <?=lang('show_settings_menu', 'show_settings_menu');?>
                                    <?= form_dropdown('show_settings_menu', $wm, $settings->show_settings_menu, 'class="form-control m-bot15" style="width: 100%"'); ?>
                                </div>
                            </div>
                        </div>
                        <?php endif; ?>
                        <?php if($this->Admin || $this->GP['settings-orders']): ?>
                        <div role="tabpanel" class="tab-pane" id="orders"><h3><?=lang('reparation'); ?></h3>
                    		<div class="col-lg-12">
                    			<div class="form-group">
                                    <?=lang('categories', 'category');?>
                    				<select id="category" name="category[]" class="form-control m-bot15 select2-hidden-accessible" multiple="" width="100%" tabindex="-1" aria-hidden="true" style="width: 100%">
                    					<?php
                                        foreach(explode(",", $settings->category) as $line){
                                            if($line){
                                                echo '<option data-select2-tag="true" selected value="'.$line.'">'.$line.'</option>';
                                            }
                                        } 
                    					?>
                    				</select>
                    			</div>
                    		</div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <?=lang('custom_fields', 'custom_fields');?>

                                    <select id="custom_fields" name="custom_fields[]" class="form-control m-bot15 select2-hidden-accessible" multiple="" width="100%" tabindex="-1" aria-hidden="true" style="width: 100%">
                                    <?php
                                        foreach(explode(",", $settings->custom_fields) as $line){
                                            if($line){
                                                echo '<option data-select2-tag="true" selected value="'.$line.'">'.$line.'</option>';
                                            }
                                        } 
                    					?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <?php endif; ?>
                        <?php if($this->Admin || $this->GP['settings-invoice']): ?>
                        <div role="tabpanel" class="tab-pane" id="invoice">
                        	<h3><?=lang('invoice_title');?></h3>
                    		<div class="col-lg-6">
                    			<div class="row">
                    				<div class="col-lg-6">
                    					<div class="form-group">
                                            <?=lang('invoice_name', 'invoice_name');?>
                    						<div class="input-group">
                                                <div class="input-group-addon">
                                                    <i class="fa  fa-user"></i>
                                                </div>
                    							<input name="invoice_name" id="invoice_name" type="text" class="validate form-control" value="<?= $settings->invoice_name; ?>">
                    						</div>
                    						
                    					</div>
                    				</div>
                    				<div class="col-lg-6">
                    					<div class="form-group">
                                            <?=lang('invoice_email', 'invoice_mail');?>
                    						
                    						<div class="input-group">
                                                <div class="input-group-addon">
                                                    <i class="fa  fa-quote-left"></i>
                                                </div>
                    							<input name="invoice_mail" id="invoice_mail" type="text" class="validate form-control" value="<?= $settings->invoice_mail; ?>">
                    						</div>
                    					</div>
                    				</div>
                    				<div class="col-lg-12">
                    					<div class="form-group">
                                            <?=lang('invoice_address', 'invoice_address');?>
                    						<div class="input-group">
                                                <div class="input-group-addon">
                                                    <i class="fa fa-street-view"></i>
                                                </div>
                    							<input id="invoice_address" name="invoice_address" type="text" class="validate form-control" value="<?= $settings->address; ?>">
                    						</div>
                    					</div>
                    				</div>
                    			</div>
                    		</div>
                    		<div class="col-lg-6">
                    			<div class="row">
                    				<div class="col-lg-12">
                    					<div class="form-group">
                                            <?=lang('invoice_phone', 'invoice_phone');?>
                    						<div class="input-group">
                                                <div class="input-group-addon">
                                                    <i class="fa fa-phone"></i>
                                                </div>
                    							<input id="invoice_phone" name="invoice_phone" type="text" class="validate form-control" value="<?= $settings->phone; ?>">
                    						</div>
                    					</div>
                    				</div>
                    				<div class="col-lg-12">
                    					<div class="form-group">
                                            <?=lang('invoice_vat', 'invoice_vat');?>
                    						<div class="input-group">
                                                <div class="input-group-addon">
                                                    <i class="fa fa-certificate"></i>
                                                </div>
                    							<input id="invoice_vat" name="invoice_vat" type="text" class="validate form-control" value="<?= $settings->vat; ?>">
                    						</div>
                    					</div>
                    				</div>
                    			</div>
                    		</div>
                    		<div class="col-lg-6">
                    			<div class="form-group">
                                    <?=lang('invoice_disclaimer', 'disclaimer');?>
                    				<textarea class="form-control" id="disclaimer" name="disclaimer" style="height: 107px" maxlength="370" rows="6"><?= $settings->disclaimer; ?></textarea>
                    			</div>
                    		</div>
                        </div>
                        <?php endif; ?>
                        <?php if($this->Admin || $this->GP['settings-sms']): ?>
                        <div role="tabpanel" class="tab-pane" id="sms">
                           <h3><?= $this->lang->line('sms_title');?></h3>
                            <div class="col-lg-6 nexmo-info radio-sms" <?php if($settings->usesms == 1 ) echo 'style="opacity: 1;"'; ?>>
                                <label>
                                    <input type="radio" id="nexmo" name="usesms" value="1" <?php if($settings->usesms == 1 ) echo 'checked'; ?> />
                                    <img style="width: 48%" src="<?= site_url(); ?>assets/images/nexmo.png">
                                </label>
                    			<div class="form-group">
                    				<label class="title">
                                        <?=lang('nexmo');?>
                    				</label>
                    				<input name="n_api_key" id="n_api_key" type="text" class="validate form-control" placeholder="Nexmo <?=lang('api_key')?>" value="<?= $settings->nexmo_api_key ?>">
                    				<input name="n_api_secret" id="n_api_secret" type="text" class="validate form-control" placeholder="Nexmo <?=lang('api_secret')?>" value="<?= $settings->nexmo_api_secret ?>">
                    				
                    			</div>
                    		</div>
                            <div class="col-lg-6 twilio-info radio-sms" <?php if($settings->usesms == 2 ) echo 'style="opacity: 1;"'; ?>>
                                <label>
                                    <input type="radio" id="twilio" name="usesms" value="2" <?php if($settings->usesms == 2 ) echo 'checked'; ?> />
                                    <img style="width: 48%" src="<?= site_url(); ?>assets/images/twilio.jpg">
                                </label>
                    			<div class="form-group">
                    				<label class="title">
                                        <?=lang('twilio');?>
                    				</label>
                    				<select name="t_mode" id="t_mode" data-num="1" class="form-control m-bot15" style="width: 100%">
                    					<option <?php if($settings->twilio_mode == 'sandbox' ) echo 'selected'; ?>>sandbox</option>
                                        <option <?php if($settings->twilio_mode == 'prod' ) echo 'selected'; ?>>prod</option>
                    				</select>
                    				<input name="t_account_sid" id="t_account_sid" type="text" class="validate form-control" placeholder="<?=lang('sid');?>" value="<?= $settings->twilio_account_sid; ?>">
                    				<input name="t_token" id="t_token" type="text" class="validate form-control" placeholder="<?=lang('token');?>" value="<?= $settings->twilio_auth_token; ?>">
                    				<input name="t_number" id="t_number" type="text" class="validate form-control" placeholder="Twilio <?=lang('number');?>" value="<?= $settings->twilio_number; ?>">
                    			</div>
                    		</div>
                            
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="title">
                                       <?=lang('email_smtp');?>
                                    </label>
                                    <input name="smtp_host" id="smtp_host" type="text" class="validate form-control" placeholder="<?=lang('smtp_host');?>" value="<?= $settings->smtp_host; ?>">
                                    <input name="smtp_user" id="smtp_user" type="text" class="validate form-control" placeholder="<?=lang('smtp_user');?>" value="<?= $settings->smtp_user; ?>">
                                    <input name="smtp_pass" id="smtp_pass" type="text" class="validate form-control" placeholder="<?=lang('smtp_pass');?>" value="<?= $settings->smtp_pass; ?>">
                                    <input name="smtp_port" id="smtp_port" type="text" class="validate form-control" placeholder="<?=lang('smtp_port');?>" value="<?= $settings->smtp_port; ?>">
                                </div>
                            </div>
                        </div>
                        <?php endif; ?>
                        <?php if($this->Admin || $this->GP['settings-appearance']): ?>
                            <div role="tabpanel" class="tab-pane" id="appearance">
                                <h3><?=lang('appearance'); ?></h3>
                                <div class="col-lg-12">
                                    <div class="row">
                                         <div class="col-md-4">
                                            <div class="form-group">
                                                <label class=""><?= lang("use_dark_theme"); ?></label>
                                                <div class="controls"> <?php
                                                    echo form_dropdown('use_dark_theme', $wm, $settings->use_dark_theme, 'class="form-control tip" id="use_dark_theme"  style="width:100%;" required="required"');
                                                    ?>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="control-label"><?= lang("use_topbar"); ?></label>
                                                <div class="controls"> <?php
                                                    echo form_dropdown('use_topbar', $wm, $settings->use_topbar, 'class="form-control tip" id="use_topbar"  style="width:100%;" required="required"');
                                                    ?>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="control-label"><?= lang("body_font"); ?></label>
                                                <div class="controls"> <?php
                                                    $body_font = array(13 => "13px", 14 => "14px", 15 => '15px');
                                                    echo form_dropdown('body_font', $body_font, $settings->body_font, 'class="form-control tip" id="body_font"  style="width:100%;" required="required"');
                                                    ?>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label class="control-label"><?=lang('appearance_bg');?></label>
                                                <div class="input-group colorpicker-component my-colorpicker1" title="Using horizontal option">
                                                    <input type="text" name="bg_color" class="form-control input-lg"  value="<?=set_value('bg_color', $settings->bg_color);?>"/>
                                                    <span class="input-group-addon"><i></i></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">

                                                <label><?=lang('appearance_header');?></label>
                                                <div class="input-group colorpicker-component my-colorpicker1" title="Using horizontal option">
                                                    <input type="text" name="header_color" class="form-control input-lg"  value="<?=set_value('header_color', $settings->header_color);?>"/>
                                                    <span class="input-group-addon"><i></i></span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-4">
                                            <div class="form-group">

                                                <label><?=lang('appearance_menu');?></label>
                                                <div class="input-group colorpicker-component my-colorpicker1" title="Using horizontal option">
                                                    <input type="text" name="menu_color" class="form-control input-lg"  value="<?=set_value('menu_color', $settings->menu_color);?>"/>
                                                    <span class="input-group-addon"><i></i></span>
                                                </div>
                                            </div>
                                        </div>
                                         
                                         <div class="col-lg-4">
                                            <div class="form-group">

                                                <label><?=lang('appearance_menu_Active');?></label>
                                                <div class="input-group colorpicker-component my-colorpicker1" title="Using horizontal option">
                                                    <input type="text" name="menu_active_color" class="form-control input-lg"  value="<?=set_value('menu_active_color', $settings->menu_active_color);?>"/>
                                                    <span class="input-group-addon"><i></i></span>
                                                </div>
                                            </div>
                                        </div>
                                         
                                        
                                        <div class="col-lg-4">
                                            <div class="form-group">

                                                <label><?=lang('menu_text_color');?></label>
                                                <div class="input-group colorpicker-component my-colorpicker1" title="Using horizontal option">
                                                    <input type="text" name="menu_text_color" class="form-control input-lg"  value="<?=set_value('menu_text_color', $settings->menu_text_color);?>"/>
                                                    <span class="input-group-addon"><i></i></span>
                                                </div>
                                            </div>
                                        </div>
                                         
                                        
                                        <div class="col-lg-4">
                                            <div class="form-group">

                                                <label><?=lang('mmenu_text_color');?></label>
                                                <div class="input-group colorpicker-component my-colorpicker1" title="Using horizontal option">
                                                    <input type="text" name="mmenu_text_color" class="form-control input-lg"  value="<?=set_value('mmenu_text_color', $settings->mmenu_text_color);?>"/>
                                                    <span class="input-group-addon"><i></i></span>
                                                </div>
                                            </div>
                                        </div>
                                         
                                        
                                        <div class="col-lg-4">
                                            <div class="form-group">

                                                <label><?=lang('bg_text_color');?></label>
                                                <div class="input-group colorpicker-component my-colorpicker1" title="Using horizontal option">
                                                    <input type="text" name="bg_text_color" class="form-control input-lg"  value="<?=set_value('bg_text_color', $settings->bg_text_color);?>"/>
                                                    <span class="input-group-addon"><i></i></span>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="col-lg-4">
                                            <div class="form-group">

                                                <label><?=lang('invoice_table_color');?></label>
                                                <div class="input-group colorpicker-component my-colorpicker1" title="Using horizontal option">
                                                    <input type="text" name="invoice_table_color" class="form-control input-lg"  value="<?=set_value('invoice_table_color', $settings->invoice_table_color);?>"/>
                                                    <span class="input-group-addon"><i></i></span>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label><?=lang('warranty_ribbon_color');?></label>
                                                <div class="input-group colorpicker-component my-colorpicker1" title="Using horizontal option">
                                                    <input type="text" name="warranty_ribbon_color" class="form-control input-lg"  value="<?=set_value('warranty_ribbon_color', $settings->warranty_ribbon_color);?>"/>
                                                    <span class="input-group-addon"><i></i></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">

                                                <label><?=lang('logo_text_color');?></label>
                                                <div class="input-group colorpicker-component my-colorpicker1" title="Using horizontal option">
                                                    <input type="text" name="logo_text_color" class="form-control input-lg"  value="<?=set_value('logo_text_color', $settings->logo_text_color);?>"/>
                                                    <span class="input-group-addon"><i></i></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
                <button id='submit' class='btn btn-success'><i class="fa fa-save"></i>
                    <?= lang('save'); ?>
                </button>
            </form>
            <?php endif; ?>

            <br><br>
            <div class="clearfix"></div>
            <div class="box-footer">
                <?php if($this->Admin || $this->GP['settings-upload_logo']): ?>
                    <div class="row">
                        <div class="col-lg-12">
                            <h3> <?= lang('logo_upload_title'); ?> </h3>
                            <div class="col-lg-12">
                                <div class="row form-group">
                                    <div class="col-lg-12 well">
                                        <img id="preview_logo" width="120px" src="<?= base_url(); ?>assets/uploads/logos/<?= $settings->logo;?>">
                                    </div>
                                    <div class="col-lg-12">
                                        <label id="error_message"></label>
                                            <span><?= lang('upload_label'); ?></span>
                                        <div class="input-group logo_upload">
                                            <form name="uploadImage" id="uploadimage" action="<?=site_url('panel/settings/upload_image');?>" method="post" enctype="multipart/form-data">   
                                                <input id="logo_upload" type="file" data-browse-label="Browse" name="logo_upload" data-show-upload="false" data-show-preview="false" accept="image/*" class="form-control file">
                                                <input type="submit" value="<?= lang('upload_label'); ?>" class="submit" style="display: none;">
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endif;?>
                <?php if($this->Admin || $this->GP['settings-upload_background']): ?>
                    <div class="row">
                        <div class="col-lg-12">
                            <h3> <?= lang('background_upload_title'); ?> </h3>
                            <div class="col-lg-12">
                                    <div class="row form-group">
                                            <?php if($settings->background) :?>
                                                <div class="col-lg-12 well">
                                                        <img id="preview_background" width="120px" src="<?= base_url(); ?>assets/uploads/backgrounds/<?= $settings->background;?>">
                                                </div>
                                            <?php endif; ?>
                                            <div class="col-lg-12">
                                                    <label id="error_message"></label>
                                                            <span><?= lang('upload_label'); ?></span>
                                                    <div class="input-group background_upload">
                                                            <form name="uploadBackground" id="uploadBackground" action="<?=site_url('panel/settings/upload_background');?>" method="post" enctype="multipart/form-data">
                                                                    <input id="background_upload" type="file" data-browse-label="Browse" name="background_upload" data-show-upload="false" data-show-preview="false" accept="image/*" class="form-control file">
                                                                    <input type="submit" value="<?= lang('upload_label'); ?>" class="submit" style="display: none;">
                                                            </form>
                                                    </div>
                                            </div>
                                    </div>
                            </div>
                        </div>
                    </div>
                <?php endif;?>
            </div>
        </div>
    </div>
</section>
