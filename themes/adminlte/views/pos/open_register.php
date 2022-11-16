<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<style type="text/css">

  /* Hide HTML5 Up and Down arrows. */

  input[type="number"]::-webkit-outer-spin-button, input[type="number"]::-webkit-inner-spin-button {

      -webkit-appearance: none;

      margin: 0;

  }

   

  input[type="number"] {

      -moz-appearance: textfield;

  }

</style>

<script type="text/javascript">

jQuery(document).ready( function($) {

    // Disable scroll when focused on a number input.

    $('form').on('focus', 'input[type=number]', function(e) {

        $(this).on('wheel', function(e) {

            e.preventDefault();

        });

    });

 

    // Restore scroll on number inputs.

    $('form').on('blur', 'input[type=number]', function(e) {

        $(this).off('wheel');

    });

 

    // Disable up and down keys.

    $('form').on('keydown', 'input[type=number]', function(e) {

        if ( e.which == 38 || e.which == 40 )

            e.preventDefault();

    });  

      

});

</script>

<!-- Main content -->

<section class="content">

    <div class="row">

        <section class="panel">

            <div class="panel-body">
                    <?= validation_errors('<div class="alert alert-info">', '</div>'); ?>
                    <?php 
                    $attribs = array('id'=>'open_register_form');
                    echo form_open("panel/pos/open_register", $attribs); ?>
                    <div class="form-group">
                        <label><?= lang('cash_in_hand'); ?></label>
                        <input type="number" name="cash_in_hand" value="" id="cash_in_hand" class="form-control" readonly>
                    </div>
                    <div class="row">
                    <div class="col-lg-6">
                         <div class="contains">
                         <div class="form-group">
                           <div class="row">
                                <div class="col-lg-2">
                                <span><?= $this->mSettings->currency; ?>100</span>
                                </div>
                                <div class="col-lg-3">
                                <input type="number" min="0" class="form-control n100" name="n100"  onchange="countCash(100,100)" value="0">
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

                                <div class="col-lg-2">

                                <span><?= $this->mSettings->currency; ?>50</span>

                                </div>

                                <div class="col-lg-3">

                                <input type="number" min="0" class="form-control n50" min="0" name="n50" onchange="countCash(50,50)" value="0">

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

                                <div class="col-lg-2">

                                <span><?= $this->mSettings->currency; ?>20</span>

                                </div>

                                <div class="col-lg-3">

                                <input type="number" min="0" class="form-control n20" min="0" name="n20" onchange="countCash(20,20)" value="0">

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

                                <div class="col-lg-2">

                                <span><?= $this->mSettings->currency; ?>10</span>

                                </div>

                                <div class="col-lg-3">

                                <input type="number" min="0" class="form-control n10" min="0" name="n10" onchange="countCash(10,10)" value="0">

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

                                <div class="col-lg-2">

                                <span><?= $this->mSettings->currency; ?>5</span>

                                </div>

                                <div class="col-lg-3">

                                <input type="number" min="0" class="form-control n5" min="0" name="n5"  onchange="countCash(5,5)" value="0">

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

                                <div class="col-lg-2">

                                <span><?= $this->mSettings->currency; ?>1</span>

                                </div>

                                <div class="col-lg-3">

                                <input type="number" min="0" class="form-control n1" name="n1" onchange="countCash(1,1)" value="0">

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

                                <div class="col-lg-2">

                                <span><?= $this->mSettings->currency; ?>0.50</span>

                                </div>

                                <div class="col-lg-3">

                                <input type="number" min="0" class="form-control n050" min="0" name="n050" onchange="countCash('050',0.50)" value="0">

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

                                <div class="col-lg-2">

                                <span><?= $this->mSettings->currency; ?>0.25</span>

                                </div>

                                <div class="col-lg-3">

                                <input type="number" min="0" class="form-control n025" min="0" name="n025" onchange="countCash('025',0.25)" value="0">

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

                                <div class="col-lg-2">

                                <span><?= $this->mSettings->currency; ?>0.10</span>

                                </div>

                                <div class="col-lg-3">

                                <input type="number" min="0" class="form-control n010" min="0" name="n010" onchange="countCash('010',0.10)" value="0">

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

                                <div class="col-lg-2">

                                <span><?= $this->mSettings->currency; ?>0.05</span>

                                </div>

                                <div class="col-lg-3">

                                <input type="number" min="0" class="form-control n005" min="0" name="n005" onchange="countCash('005',0.05)" value="0">

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

                                <div class="col-lg-2">

                                <span><?= $this->mSettings->currency; ?>0.01</span>

                                </div>

                                <div class="col-lg-3">

                                <input type="number" class="form-control n001" min="0" name="n001"  onchange="countCash('001',0.01)" value="0">

                                </div>

                                <div class="col-lg-7">

                                  <div class="input-group">

                                       <span class="input-group-addon">$</span>

                                       <input type="text" class="form-control cash v001"  name="v001" onchange="countTotal('001',0.01)" value="0" readonly>

                                  </div>

                                </div>



                           </div>

                           </div> 



                         </div>

                        

                    </div> 

                    <?= form_submit('open_register', lang('open_register'), 'style="width:100%;" class="btn btn-primary btn-lg" id="open_register"'); ?>



                  </div>



                <?php echo form_close(); ?>

            </div>

        </section>

    </div>

</section>

<script type="text/javascript">

    $(document).ready(function() {
      $('#cash_in_hand').change(function(e) {
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
        $("#cash_in_hand").val(total.toFixed(2));
        return total;

    }

    $('#open_register_form').submit(function(e) {
      e.preventDefault();
      $('#open_register_form')[0].submit();
    })

</script>