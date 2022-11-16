<style type="text/css">
  .modal {
    overflow-y:auto;
  }
</style>
<script type="text/javascript">
    $(document).ready(function() {
        $('#total_cash_submitted').change(function(e) {
            if ($(this).val() && !is_numeric($(this).val())) {
                bootbox.alert("Unexpected Value");
                $(this).val('');
            }
        })
    });
    function countCash(class_cur, amount) {
        var total = amount * $(".n" + class_cur).val();
        $(".v" + class_cur).val(total.toFixed(2));
        getTotal();
    }

    function countTotal(class_cur, amount) {
        var round_amount = Math.round($(".v" + class_cur).val() / amount) * amount;
        $(".v" + class_cur).val(round_amount.toFixed(2));
        $(".n" + class_cur).val((round_amount.toFixed(2) / amount));
        getTotal();
    }

    function getTotal() {
        var total = 0;
        $('.cash').each(function(){
            total += parseFloat($(this).val());
        });
        $("#total_cash_submitted").val(total.toFixed(2));
        return total;
    }
</script>
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-2x">&times;</i>
            </button>
            <h5 class="modal-title"
                id="myModalLabel"><font color="black">
                  <h4><?=lang('register_closing_report');?></h4>
                  <?= sprintf(lang('register_closing_report_span'), (date('m-d-Y' ,strtotime($this->session->userdata('register_open_time')))), (date('H:i:s' ,strtotime($this->session->userdata('register_open_time')))), (date('m-d-Y')), (date('H:i:s'))); ?>
                </font></h5>
        </div>
        <?php $attrib = array('data-toggle' => 'validator', 'role' => 'form', 'id'=> 'close_register_form');
        echo form_open_multipart("panel/pos/close_register/" . $user_id, $attrib);
        ?>
        <div class="modal-body" style="padding: 15px;">
            <!-- <div id="alerts"></div> -->
            <table width="100%" class="table">
                <tr>
					<td style="border-bottom: 1px solid #EEE;"><h6><?= lang('opening_Cash'); ?>:</h6></td>
                    <td style="text-align:right; border-bottom: 1px solid #EEE;"><h6>
                            <span><?= $this->repairer->formatMoney($cash_in_hand ? $cash_in_hand : $this->session->userdata('cash_in_hand')); ?></span>
                        </h6></td>
                </tr>
                  <tr>
                      <td style="border-bottom: 1px solid #EEE;"><h6><?= lang('cash_sales'); ?>:</h6></td>
                      <td style="text-align:right; border-bottom: 1px solid #EEE;"><h6>
                              <span><?= $this->repairer->formatMoney($cashsales->paid ? $cashsales->paid : '0.00'); ?></span>
                          </h6></td>
                  </tr>
                <tr>
                    <td style="border-bottom: 1px solid #EEE;"><h6><?= lang('check_sales'); ?>:</h6></td>
                    <td style="text-align:right;border-bottom: 1px solid #EEE;"><h6>
                            <span><?= $this->repairer->formatMoney($chsales->paid ? $chsales->paid : '0.00'); ?></span>
                        </h6></td>
                </tr>
                <tr>
                    <td style="border-bottom: 1px solid #DDD;"><h6><?= lang('cc_sales'); ?>:</h6></td>
                    <td style="text-align:right;border-bottom: 1px solid #DDD;"><h6>
                            <span><?= $this->repairer->formatMoney($ccsales->paid ? $ccsales->paid : '0.00'); ?></span>
                        </h6></td>
                </tr>
                <tr>
                    <td style="border-bottom: 1px solid #DDD;"><h6><?= lang('pppsales'); ?>:</h6></td>
                    <td style="text-align:right;border-bottom: 1px solid #DDD;"><h6>
                            <span><?= $this->repairer->formatMoney($pppsales->paid ? $pppsales->paid : '0.00'); ?></span>
                        </h6></td>
                </tr>
                <tr>
                    <td style="border-bottom: 1px solid #DDD;"><h6><?= lang('othersales'); ?>:</h6></td>
                    <td style="text-align:right;border-bottom: 1px solid #DDD;"><h6>
                            <span><?= $this->repairer->formatMoney($othersales->paid ? $othersales->paid : '0.00'); ?></span>
                        </h6></td>
                </tr>
            
                <tr>
                    <td width="300px;" style="font-weight:bold;"><h6><?= lang('totalsales'); ?>:</h6></td>
                    <td width="200px;" style="font-weight:bold;text-align:right;"><h6>
                            <span><?= $this->repairer->formatMoney($totalsales->paid ? $totalsales->paid : '0.00'); ?></span>
                        </h6></td>
                </tr>
                <tr>
                    <td width="300px;" style="font-weight:bold;"><h4><strong><?= lang('total_cash'); ?></strong>:</h4>
                    </td>
                    <td style="text-align:right;"><h4>
                            <span><strong><?= $cashsales->paid ? $this->repairer->formatMoney($cashsales->paid + ($this->session->userdata('cash_in_hand'))) : $this->repairer->formatMoney($this->session->userdata('cash_in_hand')); ?></strong></span>
                        </h4></td>
                </tr>
            </table>

            
            <hr>
            
            <div class="row">
				<center><font size="5" color="white"><?= lang('cash_count_sheet'); ?></font></center>
			</div>
                   <br>
                    <div class="col-lg-6">

                         <div class="contains">
                         <div class="form-group">
                           <div class="row">
                                <div class="col-lg-2" align="right">
                                <span><?= $this->mSettings->currency; ?>100</span>
                                </div>
                                <div class="col-lg-3">
                                <input type="number" min="0" class="form-control n100" name="n100"  onchange="countCash(100,100)" placeholder="Quantity of $100 bills here." tabindex=4>
                                </div>
                                <div class="col-lg-7">
                                  <div class="input-group">
                                       <span class="input-group-addon">$</span>
                                       <input type="text" class="form-control cash v100" name="v100"  onchange="countTotal(100,100)" value="0" readonly>
                            
                                  </div>
                                </div>

                           </div>
                           </div>
                          
                            <div class="form-group">
                           <div class="row">
                                <div class="col-lg-2" align="right">
                                <span><?= $this->mSettings->currency; ?>50</span>
                                </div>
                                <div class="col-lg-3">
                                <input type="number" min="0" class="form-control n50" min="0" name="n50" onchange="countCash(50,50)" placeholder="Quantity of $50 bills here." tabindex=5>
                                </div>
                                <div class="col-lg-7">
                                  <div class="input-group">
                                       <span class="input-group-addon">$</span>
                                       <input type="text" class="form-control cash v50" name="v50"  onchange="countTotal(50,50)" value="0" readonly>
                            
                                  </div>
                                </div>

                           </div>
                           </div>
                            <div class="form-group">
                           <div class="row">
                                <div class="col-lg-2" align="right">
                                <span><?= $this->mSettings->currency; ?>20</span>
                                </div>
                                <div class="col-lg-3">
                                <input type="number" min="0" class="form-control n20" min="0" name="n20" onchange="countCash(20,20)" placeholder="Quantity of $20 bills here." tabindex=6>
                                </div>
                                <div class="col-lg-7">
                                  <div class="input-group">
                                       <span class="input-group-addon">$</span>
                                       <input type="text" class="form-control cash v20" name="v20"  onchange="countTotal(20,20)" value="0" readonly>
                            
                                  </div>
                                </div>

                           </div>
                           </div>
                            <div class="form-group">
                           <div class="row">
                                <div class="col-lg-2" align="right">
                                <span><?= $this->mSettings->currency; ?>10</span>
                                </div>
                                <div class="col-lg-3">
                                <input type="number" min="0" class="form-control n10" min="0" name="n10" onchange="countCash(10,10)" placeholder="Quantity of $10 bills here." tabindex=7>
                                </div>
                                <div class="col-lg-7">
                                  <div class="input-group">
                                       <span class="input-group-addon">$</span>
                                       <input type="text" class="form-control cash v10" name="v10" onchange="countTotal(10,10)" value="0" readonly>
                            
                                  </div>
                                </div>

                           </div>
                           </div>
                            <div class="form-group">
                           <div class="row">
                                <div class="col-lg-2" align="right">
                                <span><?= $this->mSettings->currency; ?>5</span>
                                </div>
                                <div class="col-lg-3">
                                <input type="number" min="0" class="form-control n5" min="0" name="n5"  onchange="countCash(5,5)" placeholder="Quantity of $5 bills here." tabindex=8>
                                </div>
                                <div class="col-lg-7">
                                  <div class="input-group">
                                       <span class="input-group-addon">$</span>
                                       <input type="text" class="form-control cash v5" name="v5"  onchange="countTotal(5,5)" value="0" readonly>
                            
                                  </div>
                                </div>

                           </div>
                           </div>
                            <div class="form-group">
                           <div class="row">
                                <div class="col-lg-2" align="right">
                                <span><?= $this->mSettings->currency; ?>1</span>
                                </div>
                                <div class="col-lg-3">
                                <input type="number" min="0" class="form-control n1" name="n1" onchange="countCash(1,1)" placeholder="Quantity of $1 bills here." tabindex=9>
                                </div>
                                <div class="col-lg-7">
                                  <div class="input-group">
                                       <span class="input-group-addon">$</span>
                                       <input type="text" class="form-control cash v1" name="v1" onchange="countTotal(1,1)" value="0" readonly>
                            
                                  </div>
                                </div>

                           </div>
                           </div>

                         </div>
                    </div>
                     <div class="col-lg-6">

                         <div class="form-group">
                           <div class="row">
                                <div class="col-lg-2" align="right">
                                <span><?= $this->mSettings->currency; ?>0.50</span>
                                </div>
                                <div class="col-lg-3">
                                <input type="number" min="0" class="form-control n050" min="0" name="n050" onchange="countCash('050',0.50)" placeholder="Quantity of Half Dollars Here" tabindex=10>
                                </div>
                                <div class="col-lg-7">
                                  <div class="input-group">
                                       <span class="input-group-addon">$</span>
                                       <input type="text" class="form-control cash v050"  name="v050" onchange="countTotal('050',0.50)" value="0" readonly>
                            
                                  </div>
                                </div>

                           </div>
                           </div>
                            <div class="form-group">
                           <div class="row">
                                <div class="col-lg-2" align="right">
                                <span><?= $this->mSettings->currency; ?>0.25</span>
                                </div>
                                <div class="col-lg-3">
                                <input type="number" min="0" class="form-control n025" min="0" name="n025" onchange="countCash('025',0.25)" placeholder="Quantity of Quarters Here" tabindex=11>
                                </div>
                                <div class="col-lg-7">
                                  <div class="input-group">
                                       <span class="input-group-addon">$</span>
                                       <input type="text" class="form-control cash v025" name="v025" onchange="countTotal('025',0.25)" value="0" readonly>
                            
                                  </div>
                                </div>

                           </div>
                           </div>
                            <div class="form-group">
                           <div class="row">
                                <div class="col-lg-2" align="right">
                                <span><?= $this->mSettings->currency; ?>0.10</span>
                                </div>
                                <div class="col-lg-3">
                                <input type="number" min="0" class="form-control n010" min="0" name="n010" onchange="countCash('010',0.10)" placeholder="Quantity of Dimes Here" tabindex=12>
                                </div>
                                <div class="col-lg-7">
                                  <div class="input-group">
                                       <span class="input-group-addon">$</span>
                                       <input type="text" class="form-control cash v010" name="v010" onchange="countTotal('010',0.10)" value="0" readonly>
                            
                                  </div>
                                </div>

                           </div>
                           </div>
                            <div class="form-group">
                           <div class="row">
                                <div class="col-lg-2" align="right">
                                <span><?= $this->mSettings->currency; ?>0.05</span>
                                </div>
                                <div class="col-lg-3">
                                <input type="number" min="0" class="form-control n005" min="0" name="n005" onchange="countCash('005',0.05)" placeholder="Quantity of Nickels Here" tabindex=13>
                                </div>
                                <div class="col-lg-7">
                                  <div class="input-group">
                                       <span class="input-group-addon">$</span>
                                       <input type="text" class="form-control cash v005" name="v005" onchange="countTotal('005',0.05)" value="0" readonly>
                            
                                  </div>
                                </div>

                           </div>
                           </div>
                            <div class="form-group">
                           <div class="row">
                                <div class="col-lg-2" align="right">
                                <span><?= $this->mSettings->currency; ?>0.01</span>
                                </div>
                                <div class="col-lg-3">
                                <input type="number" class="form-control n001" min="0" name="n001"  onchange="countCash('001',0.01)" placeholder="Quantity of Pennies Here" tabindex=14 >
                                </div>
                                <div class="col-lg-7">
                                  <div class="input-group">
                                       <span class="input-group-addon">$</span>
                                       <input type="text" class="form-control cash v001"  name="v001" onchange=countTotal('001',0.01)" value="0" readonly>
                            
                                  </div>
                                </div>

                           </div>
                           </div> 

                         </div>
                        <hr>
              <div class="row no-print">
                <div class="col-md-12"> 
                  <div class="col-sm-4">
                    <div class="form-group">
                        <label for="total_cash_submitted"><?= lang('total_value_cash'); ?></label>
                         <?php $total_cash = $cashsales->paid ? ($cashsales->paid + ($this->session->userdata('cash_in_hand'))) : ($this->session->userdata('cash_in_hand')); 

                         ?>
                        <?= form_hidden('total_cash', $total_cash); ?>
                        <?= form_input('total_cash_submitted', (isset($_POST['total_cash_submitted']) ? $_POST['total_cash_submitted'] : $total_cash), 'class="form-control input-tip" id="total_cash_submitted" required="required"  readonly tabindex=1'); ?>
                    </div>
                    </div>
                    <div class="col-sm-4">
                    <div class="form-group">
                        <label for="total_cheques_submitted"><?= lang('total_value_check'); ?></label>
                        <?= form_hidden('total_cheques', $chsales->total_cheques); ?>
                        <?= form_input('total_cheques_submitted', (isset($_POST['total_cheques_submitted']) ? $_POST['total_cheques_submitted'] : $chsales->total_cheques), 'class="form-control input-tip" id="total_cheques_submitted" required="required" tabindex=3'); ?>
                    </div>
                  </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label for="total_cc_slips_submitted"><?= lang('total_value_ccc'); ?></label>
                        <?= form_hidden('total_cc_slips', $ccsales->total_cc_slips); ?>
                        <?= form_input('total_cc_slips_submitted', (isset($_POST['total_cc_slips_submitted']) ? $_POST['total_cc_slips_submitted'] : $ccsales->total_cc_slips), 'class="form-control input-tip" id="total_cc_slips_submitted" required="required" tabindex=2'); ?>
                    </div>
                </div>
                </div>
                  
                
            </div>

        </div>
          <?= form_hidden('total_cc', $ccsales->paid); ?>
          <?= form_hidden('total_ppp', $pppsales->paid); ?>
          <?= form_hidden('total_others', $othersales->paid); ?>

        <div class="modal-footer no-print">
            <?= form_submit('close_register', "Close Register", 'id="close_register_button" class="btn btn-primary"'); ?>
        </div>
    </div>
    <?= form_close(); ?>
</div>