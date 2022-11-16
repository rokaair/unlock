
  <div class="modal fade" id="newSizeBarcode">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title"><?=lang('Save Size Config');?></h4>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="form-group">
                  <div class="col-md-12">
                      <label class="control-label" for="newNameSize"><?=lang('Enter New Name for this Size');?></label>
                      <input class="form-control" id="newNameSize" placeholder="Name">
                  </div>
              </div>
          </div>
              
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal"><?=lang('close');?></button>
          <button type="button" id="btnAddNewSize"  class="btn btn-primary"><?=lang('save');?></button>
        </div>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
  <!-- /.modal -->

<link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Noto+Sans" rel="stylesheet">
<link rel="stylesheet" href="<?$assets;?>/dist/css/custom/barcodes.css">
<script type="text/javascript" src="<?=$assets;?>plugins/printThis.js"></script>
<script type="text/javascript" src="<?=$assets;?>plugins/jquery-barcode.min.js"></script>
<style type="text/css">
  .barcoderow {
    font-family: "Noto Sans", 'Prompt' !important;
    font-size: 12px;
    line-height: 1.42857143;
    color: #949494;
    /*background-color: #ffffff;*/
  }
  h4{
    font-size: 15px !important;
  }
  p{
    font-size: 12px !important;
  }

  .panel, .box {
     border-radius: 0; 
     padding: 0; 
  }
</style>
<script type="text/javascript">
    $(document).ready(function () {
      first = 'cus';
      <?php foreach($barcode_configs as $config): ?>
        first = <?=$config->id;?>;
      <?php break; endforeach; ?>
      mainLoad.radioSet(4);
      mainLoad.viewPrint();
    });

    var mainLoad = {
      updateSet : function(id){
        // confirm
        bootbox.confirm({
          message: "<?=lang('r_u_sure');?>",
          callback: function(result) { if (result) {
            if ($('#chkName')[0].checked == true) {
              var chkNameSize = 1;
            }else{
              var chkNameSize = 0;
            }
            if ($('#chkBarcode')[0].checked == true) {
              var chkBarcodeSize = 1;
            }else{
              var chkBarcodeSize = 0;
            }
            if ($('#chkPrice')[0].checked == true) {
              var chkPriceSize = 1;
            }else{
              var chkPriceSize = 0;
            }
            if ($('#chkDetail')[0].checked == true) {
              var chkDetailSize = 1;
            }else{
              var chkDetailSize = 0;
            }

             $.ajax({
                url: '<?=base_url();?>panel/barcode/updateSizeBarcode',
                type: 'post',
                dataType: 'json',
                data: { 
                  id : id,
                  name : $('#newNameSize').val(),
                  m_top : $('#txtTop').val(),
                  width : $('#txtSticX').val(),
                  height : $('#txtSticY').val(),
                  m_width : $('#txtWidth').val(),
                  y_width : $('#txtHeight').val(),
                  num_x : $('#txtNumX').val(),
                  num_y : $('#txtNumY').val(),
                  ch_barcode : chkBarcodeSize,
                  ch_name : chkNameSize,
                  ch_detail : chkDetailSize,
                  ch_price : chkPriceSize,
                  ch_phone : 0,
                  ch_passcode : 0,
                  ch_date : 0,
                  ch_model : 0,
                },
            })
            .done(function(data) {
              toastr.success(data.msg);
              setTimeout(function() {
                  location.reload();
              }, 1000);
            })
            .fail(function() {
              console.log("error");
            });
        // confirm
        }}});
        // confirm
      },
      removeSet : function(id){
        // confirm
        bootbox.confirm({
          message: "<?=lang('r_u_sure');?>",
          callback: function(result) { if (result) {
          $.ajax({
              url: '<?=base_url();?>panel/barcode/removeSet',
              type: 'post',
              dataType: 'json',
              data: { 
                id : id,
              },
          })
          .done(function(data) {
              toastr.success(data.msg);
              window.location.reload();
          })
          .fail(function() {
              console.log('error');
          });
        // confirm
        }}});
        // confirm
      },
      btnShowHide : function(div){
        $('.'+div).toggle(500);
      },
      radioSet : function(data){
        <?php foreach ($barcode_configs as $config): ?>
                      
        if (data == '<?=$config->id;?>') {
          $('#txtTop').val('<?=$config->m_top;?>');
          $('#txtSticX').val('<?=$config->width;?>');
          $('#txtSticY').val('<?=$config->height;?>');
          $('#txtWidth').val('<?=$config->m_width;?>');
          $('#txtHeight').val('<?=$config->y_width;?>');
          $('#txtNumX').val('<?=$config->num_x;?>');
          $('#txtNumY').val('<?=$config->num_y;?>');

          if ('<?=$config->ch_barcode;?>' == 1) {
            $('#chkBarcode').prop('checked', true );
            $('#chkBarcode').closest('.checkbox').addClass('checked');
          }else{
            $('#chkBarcode').prop('checked', false );
            $('#chkBarcode').closest('.checkbox').removeClass('checked');
          }
          if ('<?=$config->ch_name;?>' == 1) {
            $('#chkName').prop('checked', true );
            $('#chkName').closest('.checkbox').addClass('checked');
          }else{
            $('#chkName').prop('checked', false );
            $('#chkName').closest('.checkbox').removeClass('checked');
          }
          if ('<?=$config->ch_price;?>' == 1) {
            $('#chkPrice').prop('checked', true );
            $('#chkPrice').closest('.checkbox').addClass('checked');
          }else{
            $('#chkPrice').prop('checked', false );
            $('#chkPrice').closest('.checkbox').removeClass('checked');
          }
          if ('<?=$config->ch_detail;?>' == 1) {
            $('#chkDetail').prop('checked', true );
            $('#chkDetail').closest('.checkbox').addClass('checked');
          }else{
            $('#chkDetail').prop('checked', false );
            $('#chkDetail').closest('.checkbox').removeClass('checked');
          }

        }
        <?php endforeach; ?>

        if (data == 'a7') {
          $('#txtTop').val('0.50');
          $('#txtSticX').val('3.8');
          $('#txtSticY').val('1.9');
          $('#txtWidth').val('0.29');
          $('#txtHeight').val('0.25');
          $('#txtNumX').val('5');
          $('#txtNumY').val('8');

          $('#chkName').prop('checked', true );
          $('#chkName').closest('.checkbox').addClass('checked');
          $('#chkBarcode').prop('checked', false );
          $('#chkBarcode').closest('.checkbox').removeClass('checked');
          $('#chkPrice').prop('checked', true );
          $('#chkPrice').closest('.checkbox').addClass('checked');
          $('#chkDetail').prop('checked', false );
          $('#chkDetail').closest('.checkbox').removeClass('checked');
        }
        if (data == 'a8') {
          $('#txtTop').val('0.19');
          $('#txtSticX').val('3.75');
          $('#txtSticY').val('2.50');
          $('#txtWidth').val('0.25');
          $('#txtHeight').val('0.29');
          $('#txtNumX').val('4');
          $('#txtNumY').val('8');

          $('#chkName').prop('checked', true );
          $('#chkName').closest('.checkbox').addClass('checked');
          $('#chkBarcode').prop('checked', true );
          $('#chkBarcode').closest('.checkbox').addClass('checked');
          $('#chkPrice').prop('checked', true );
          $('#chkPrice').closest('.checkbox').addClass('checked');
          $('#chkDetail').prop('checked', true );
          $('#chkDetail').closest('.checkbox').addClass('checked');
        }
        if (data == 'a9') {
          $('#txtTop').val('0.70');
          $('#txtSticX').val('5');
          $('#txtSticY').val('1.9');
          $('#txtWidth').val('0.25');
          $('#txtHeight').val('0.24');
          $('#txtNumX').val('3');
          $('#txtNumY').val('10');

          $('#chkName').prop('checked', true );
          $('#chkName').closest('.checkbox').addClass('checked');
          $('#chkBarcode').prop('checked', false );
          $('#chkBarcode').closest('.checkbox').removeClass('checked');
          $('#chkPrice').prop('checked', true );
          $('#chkPrice').closest('.checkbox').addClass('checked');
          $('#chkDetail').prop('checked', true );
          $('#chkDetail').closest('.checkbox').addClass('checked');
        }
        if (data == 'a9') {
          $('#txtTop').val('0.70');
          $('#txtSticX').val('5');
          $('#txtSticY').val('1.9');
          $('#txtWidth').val('0.25');
          $('#txtHeight').val('0.24');
          $('#txtNumX').val('3');
          $('#txtNumY').val('10');

          $('#chkName').prop('checked', true );
          $('#chkName').closest('.checkbox').addClass('checked');
          $('#chkBarcode').prop('checked', false );
          $('#chkBarcode').closest('.checkbox').removeClass('checked');
          $('#chkPrice').prop('checked', true );
          $('#chkPrice').closest('.checkbox').addClass('checked');
          $('#chkDetail').prop('checked', true );
          $('#chkDetail').closest('.checkbox').addClass('checked');
        }
        if (data == 'a10') {
          $('#txtTop').val('0.40');
          $('#txtSticX').val('5');
          $('#txtSticY').val('2.5');
          $('#txtWidth').val('0.25');
          $('#txtHeight').val('0.28');
          $('#txtNumX').val('3');
          $('#txtNumY').val('8');

          $('#chkName').prop('checked', true );
          $('#chkName').closest('.checkbox').addClass('checked');
          $('#chkBarcode').prop('checked', true );
          $('#chkBarcode').closest('.checkbox').addClass('checked');
          $('#chkPrice').prop('checked', true );
          $('#chkPrice').closest('.checkbox').addClass('checked');
          $('#chkDetail').prop('checked', true );
          $('#chkDetail').closest('.checkbox').addClass('checked');
        }
        if (data == 'a11') {
          $('#txtTop').val('0.80');
          $('#txtSticX').val('5.5');
          $('#txtSticY').val('2.80');
          $('#txtWidth').val('0.25');
          $('#txtHeight').val('0.28');
          $('#txtNumX').val('3');
          $('#txtNumY').val('7');

          $('#chkName').prop('checked', true );
          $('#chkName').closest('.checkbox').addClass('checked');
          $('#chkBarcode').prop('checked', true );
          $('#chkBarcode').closest('.checkbox').addClass('checked');
          $('#chkPrice').prop('checked', true );
          $('#chkPrice').closest('.checkbox').addClass('checked');
          $('#chkDetail').prop('checked', true );
          $('#chkDetail').closest('.checkbox').addClass('checked');
        }
        if (data == 'cus') {
          $('#txtTop').val('0.19');
          $('#txtSticX').val('3.75');
          $('#txtSticY').val('2.50');
          $('#txtWidth').val('0.25');
          $('#txtHeight').val('0.29');
          $('#txtNumX').val('5');
          $('#txtNumY').val('10');

          $('#chkName').prop('checked', true );
          $('#chkName').closest('.checkbox').addClass('checked');
          $('#chkBarcode').prop('checked', true );
          $('#chkBarcode').closest('.checkbox').addClass('checked');
          $('#chkPrice').prop('checked', true );
          $('#chkPrice').closest('.checkbox').addClass('checked');
          $('#chkDetail').prop('checked', true );
          $('#chkDetail').closest('.checkbox').addClass('checked');
        }
        mainLoad.viewPrint();
        mainLoad.viewPrintMulti();
      },
      viewPrintMulti : function(){
        // เปิดปุ่ม
        for (var i = 1; i < 11; i++) {
          $("#form"+i+"_5 :input").attr("disabled", false);
          $("#form"+i+"_4 :input").attr("disabled", false);
          $("#form"+i+"_3 :input").attr("disabled", false);
          $("#form"+i+"_2 :input").attr("disabled", false);
          $("#form"+i+"_1 :input").attr("disabled", false);

          $("#btnSlcStock"+i+"_1").prop("disabled", false);
        }
        //ความสูง
        var varTop = $('#txtTop').val() - 0.5;
        $('#divPrint').css('margin-top', varTop + 'cm');
        //สติ๊กเกอร์
        $('.printStic').css({
          width: $('#txtSticX').val() + 'cm',
          height: $('#txtSticY').val() + 'cm',
        });
        //ระยะห่างแนวนอน
        var varWidth = $('#txtWidth').val() / 2;
        $('.printStic').css('margin', '0px '+varWidth+'cm');
        //ระยะห่างแนวตั้ง
        $('.printY').css('margin-bottom', $('#txtHeight').val()+'cm');
        //จำนวนแนวนอน
        if ( $('#txtNumX').val() == '1' ) {
          $('.LineX1').css('display', 'block');
          $('.LineX2').css('display', 'none');
          $('.LineX3').css('display', 'none');
          $('.LineX4').css('display', 'none');
          $('.LineX5').css('display', 'none');

          for (var i = 1; i < 11; i++) {
            $("#form"+i+"_5 :input").attr("disabled", true);
            $("#form"+i+"_4 :input").attr("disabled", true);
            $("#form"+i+"_3 :input").attr("disabled", true);
            $("#form"+i+"_2 :input").attr("disabled", true);
            $("#btnSlcStock"+i+"_1").prop("disabled", false);
          }
        }
        if ( $('#txtNumX').val() == '2' ) {
          $('.LineX1').css('display', 'block');
          $('.LineX2').css('display', 'block');
          $('.LineX3').css('display', 'none');
          $('.LineX4').css('display', 'none');
          $('.LineX5').css('display', 'none');

          for (var i = 1; i < 11; i++) {
            $("#form"+i+"_5 :input").attr("disabled", true);
            $("#form"+i+"_4 :input").attr("disabled", true);
            $("#form"+i+"_3 :input").attr("disabled", true);
            $("#btnSlcStock"+i+"_1").prop("disabled", false);
          }
        }
        if ( $('#txtNumX').val() == '3' ) {
          $('.LineX1').css('display', 'block');
          $('.LineX2').css('display', 'block');
          $('.LineX3').css('display', 'block');
          $('.LineX4').css('display', 'none');
          $('.LineX5').css('display', 'none');

          for (var i = 1; i < 11; i++) {
            $("#form"+i+"_5 :input").attr("disabled", true);
            $("#form"+i+"_4 :input").attr("disabled", true);
            $("#btnSlcStock"+i+"_1").prop("disabled", false);
          }
        }
        if ( $('#txtNumX').val() == '4' ) {
          $('.LineX1').css('display', 'block');
          $('.LineX2').css('display', 'block');
          $('.LineX3').css('display', 'block');
          $('.LineX4').css('display', 'block');
          $('.LineX5').css('display', 'none');

          for (var i = 1; i < 11; i++) {
            $("#form"+i+"_5 :input").attr("disabled", true);
            $("#btnSlcStock"+i+"_1").prop("disabled", false);
          }
        }
        if ( $('#txtNumX').val() == '5' ) {
          $('.LineX1').css('display', 'block');
          $('.LineX2').css('display', 'block');
          $('.LineX3').css('display', 'block');
          $('.LineX4').css('display', 'block');
          $('.LineX5').css('display', 'block');
        }
        //จำนวนแนวตั้ง
        if ( $('#txtNumY').val() == '1' ) {
          $('.LineY1').css('display', 'inline-flex');
          $('.LineY2').css('display', 'none');
          $('.LineY3').css('display', 'none');
          $('.LineY4').css('display', 'none');
          $('.LineY5').css('display', 'none');
          $('.LineY6').css('display', 'none');
          $('.LineY7').css('display', 'none');
          $('.LineY8').css('display', 'none');
          $('.LineY9').css('display', 'none');
          $('.LineY10').css('display', 'none');

          for (var i = 1; i < 6; i++) {
            $("#form10_"+i+" :input").attr("disabled", true);
            $("#form9_"+i+" :input").attr("disabled", true);
            $("#form8_"+i+" :input").attr("disabled", true);
            $("#form7_"+i+" :input").attr("disabled", true);
            $("#form6_"+i+" :input").attr("disabled", true);
            $("#form5_"+i+" :input").attr("disabled", true);
            $("#form4_"+i+" :input").attr("disabled", true);
            $("#form3_"+i+" :input").attr("disabled", true);
            $("#form2_"+i+" :input").attr("disabled", true);
          }
        }
        if ( $('#txtNumY').val() == '2' ) {
          $('.LineY1').css('display', 'inline-flex');
          $('.LineY2').css('display', 'inline-flex');
          $('.LineY3').css('display', 'none');
          $('.LineY4').css('display', 'none');
          $('.LineY5').css('display', 'none');
          $('.LineY6').css('display', 'none');
          $('.LineY7').css('display', 'none');
          $('.LineY8').css('display', 'none');
          $('.LineY9').css('display', 'none');
          $('.LineY10').css('display', 'none');

          for (var i = 1; i < 6; i++) {
            $("#form10_"+i+" :input").attr("disabled", true);
            $("#form9_"+i+" :input").attr("disabled", true);
            $("#form8_"+i+" :input").attr("disabled", true);
            $("#form7_"+i+" :input").attr("disabled", true);
            $("#form6_"+i+" :input").attr("disabled", true);
            $("#form5_"+i+" :input").attr("disabled", true);
            $("#form4_"+i+" :input").attr("disabled", true);
            $("#form3_"+i+" :input").attr("disabled", true);
          }
        }
        if ( $('#txtNumY').val() == '3' ) {
          $('.LineY1').css('display', 'inline-flex');
          $('.LineY2').css('display', 'inline-flex');
          $('.LineY3').css('display', 'inline-flex');
          $('.LineY4').css('display', 'none');
          $('.LineY5').css('display', 'none');
          $('.LineY6').css('display', 'none');
          $('.LineY7').css('display', 'none');
          $('.LineY8').css('display', 'none');
          $('.LineY9').css('display', 'none');
          $('.LineY10').css('display', 'none');

          for (var i = 1; i < 6; i++) {
            $("#form10_"+i+" :input").attr("disabled", true);
            $("#form9_"+i+" :input").attr("disabled", true);
            $("#form8_"+i+" :input").attr("disabled", true);
            $("#form7_"+i+" :input").attr("disabled", true);
            $("#form6_"+i+" :input").attr("disabled", true);
            $("#form5_"+i+" :input").attr("disabled", true);
            $("#form4_"+i+" :input").attr("disabled", true);
          }
        }
        if ( $('#txtNumY').val() == '4' ) {
          $('.LineY1').css('display', 'inline-flex');
          $('.LineY2').css('display', 'inline-flex');
          $('.LineY3').css('display', 'inline-flex');
          $('.LineY4').css('display', 'inline-flex');
          $('.LineY5').css('display', 'none');
          $('.LineY6').css('display', 'none');
          $('.LineY7').css('display', 'none');
          $('.LineY8').css('display', 'none');
          $('.LineY9').css('display', 'none');
          $('.LineY10').css('display', 'none');

          for (var i = 1; i < 6; i++) {
            $("#form10_"+i+" :input").attr("disabled", true);
            $("#form9_"+i+" :input").attr("disabled", true);
            $("#form8_"+i+" :input").attr("disabled", true);
            $("#form7_"+i+" :input").attr("disabled", true);
            $("#form6_"+i+" :input").attr("disabled", true);
            $("#form5_"+i+" :input").attr("disabled", true);
          }
        }
        if ( $('#txtNumY').val() == '5' ) {
          $('.LineY1').css('display', 'inline-flex');
          $('.LineY2').css('display', 'inline-flex');
          $('.LineY3').css('display', 'inline-flex');
          $('.LineY4').css('display', 'inline-flex');
          $('.LineY5').css('display', 'inline-flex');
          $('.LineY6').css('display', 'none');
          $('.LineY7').css('display', 'none');
          $('.LineY8').css('display', 'none');
          $('.LineY9').css('display', 'none');
          $('.LineY10').css('display', 'none');

          for (var i = 1; i < 6; i++) {
            $("#form10_"+i+" :input").attr("disabled", true);
            $("#form9_"+i+" :input").attr("disabled", true);
            $("#form8_"+i+" :input").attr("disabled", true);
            $("#form7_"+i+" :input").attr("disabled", true);
            $("#form6_"+i+" :input").attr("disabled", true);
          }
        }
        if ( $('#txtNumY').val() == '6' ) {
          $('.LineY1').css('display', 'inline-flex');
          $('.LineY2').css('display', 'inline-flex');
          $('.LineY3').css('display', 'inline-flex');
          $('.LineY4').css('display', 'inline-flex');
          $('.LineY5').css('display', 'inline-flex');
          $('.LineY6').css('display', 'inline-flex');
          $('.LineY7').css('display', 'none');
          $('.LineY8').css('display', 'none');
          $('.LineY9').css('display', 'none');
          $('.LineY10').css('display', 'none');

          for (var i = 1; i < 6; i++) {
            $("#form10_"+i+" :input").attr("disabled", true);
            $("#form9_"+i+" :input").attr("disabled", true);
            $("#form8_"+i+" :input").attr("disabled", true);
            $("#form7_"+i+" :input").attr("disabled", true);
          }
        }
        if ( $('#txtNumY').val() == '7' ) {
          $('.LineY1').css('display', 'inline-flex');
          $('.LineY2').css('display', 'inline-flex');
          $('.LineY3').css('display', 'inline-flex');
          $('.LineY4').css('display', 'inline-flex');
          $('.LineY5').css('display', 'inline-flex');
          $('.LineY6').css('display', 'inline-flex');
          $('.LineY7').css('display', 'inline-flex');
          $('.LineY8').css('display', 'none');
          $('.LineY9').css('display', 'none');
          $('.LineY10').css('display', 'none');

          for (var i = 1; i < 6; i++) {
            $("#form10_"+i+" :input").attr("disabled", true);
            $("#form9_"+i+" :input").attr("disabled", true);
            $("#form8_"+i+" :input").attr("disabled", true);
          }
        }
        if ( $('#txtNumY').val() == '8' ) {
          $('.LineY1').css('display', 'inline-flex');
          $('.LineY2').css('display', 'inline-flex');
          $('.LineY3').css('display', 'inline-flex');
          $('.LineY4').css('display', 'inline-flex');
          $('.LineY5').css('display', 'inline-flex');
          $('.LineY6').css('display', 'inline-flex');
          $('.LineY7').css('display', 'inline-flex');
          $('.LineY8').css('display', 'inline-flex');
          $('.LineY9').css('display', 'none');
          $('.LineY10').css('display', 'none');

          for (var i = 1; i < 6; i++) {
            $("#form10_"+i+" :input").attr("disabled", true);
            $("#form9_"+i+" :input").attr("disabled", true);
          }
        }
        if ( $('#txtNumY').val() == '9' ) {
          $('.LineY1').css('display', 'inline-flex');
          $('.LineY2').css('display', 'inline-flex');
          $('.LineY3').css('display', 'inline-flex');
          $('.LineY4').css('display', 'inline-flex');
          $('.LineY5').css('display', 'inline-flex');
          $('.LineY6').css('display', 'inline-flex');
          $('.LineY7').css('display', 'inline-flex');
          $('.LineY8').css('display', 'inline-flex');
          $('.LineY9').css('display', 'inline-flex');
          $('.LineY10').css('display', 'none');

          for (var i = 1; i < 6; i++) {
            $("#form10_"+i+" :input").attr("disabled", true);
          }
        }
        if ( $('#txtNumY').val() == '10' ) {
          $('.LineY1').css('display', 'inline-flex');
          $('.LineY2').css('display', 'inline-flex');
          $('.LineY3').css('display', 'inline-flex');
          $('.LineY4').css('display', 'inline-flex');
          $('.LineY5').css('display', 'inline-flex');
          $('.LineY6').css('display', 'inline-flex');
          $('.LineY7').css('display', 'inline-flex');
          $('.LineY8').css('display', 'inline-flex');
          $('.LineY9').css('display', 'inline-flex');
          $('.LineY10').css('display', 'inline-flex');
        }
      },
      viewPrint : function(){
        //ความสูง


        var varTop = $('#txtTop').val() - 0.5;
        $('#divPrint').css('margin-top', varTop + 'cm');
        //สติ๊กเกอร์
        $('.printStic').css({
          width: $('#txtSticX').val() + 'cm',
          height: $('#txtSticY').val() + 'cm',
        });
        //ระยะห่างแนวนอน
        var varWidth = $('#txtWidth').val() / 2;
        $('.printStic').css('margin', '0px '+varWidth+'cm');
        //ระยะห่างแนวตั้ง
        $('.printY').css('margin-bottom', $('#txtHeight').val()+'cm');
        //จำนวนแนวนอน
        if ( $('#txtNumX').val() == '1' ) {
          $('.LineX1').css('display', 'block');
          $('.LineX2').css('display', 'none');
          $('.LineX3').css('display', 'none');
          $('.LineX4').css('display', 'none');
          $('.LineX5').css('display', 'none');
        }
        if ( $('#txtNumX').val() == '2' ) {
          $('.LineX1').css('display', 'block');
          $('.LineX2').css('display', 'block');
          $('.LineX3').css('display', 'none');
          $('.LineX4').css('display', 'none');
          $('.LineX5').css('display', 'none');
        }
        if ( $('#txtNumX').val() == '3' ) {
          $('.LineX1').css('display', 'block');
          $('.LineX2').css('display', 'block');
          $('.LineX3').css('display', 'block');
          $('.LineX4').css('display', 'none');
          $('.LineX5').css('display', 'none');
        }
        if ( $('#txtNumX').val() == '4' ) {
          $('.LineX1').css('display', 'block');
          $('.LineX2').css('display', 'block');
          $('.LineX3').css('display', 'block');
          $('.LineX4').css('display', 'block');
          $('.LineX5').css('display', 'none');
        }
        if ( $('#txtNumX').val() == '5' ) {
          $('.LineX1').css('display', 'block');
          $('.LineX2').css('display', 'block');
          $('.LineX3').css('display', 'block');
          $('.LineX4').css('display', 'block');
          $('.LineX5').css('display', 'block');
        }
        //จำนวนแนวตั้ง
        if ( $('#txtNumY').val() == '1' ) {
          $('.LineY1').css('display', 'inline-flex');
          $('.LineY2').css('display', 'none');
          $('.LineY3').css('display', 'none');
          $('.LineY4').css('display', 'none');
          $('.LineY5').css('display', 'none');
          $('.LineY6').css('display', 'none');
          $('.LineY7').css('display', 'none');
          $('.LineY8').css('display', 'none');
          $('.LineY9').css('display', 'none');
          $('.LineY10').css('display', 'none');
        }
        if ( $('#txtNumY').val() == '2' ) {
          $('.LineY1').css('display', 'inline-flex');
          $('.LineY2').css('display', 'inline-flex');
          $('.LineY3').css('display', 'none');
          $('.LineY4').css('display', 'none');
          $('.LineY5').css('display', 'none');
          $('.LineY6').css('display', 'none');
          $('.LineY7').css('display', 'none');
          $('.LineY8').css('display', 'none');
          $('.LineY9').css('display', 'none');
          $('.LineY10').css('display', 'none');
        }
        if ( $('#txtNumY').val() == '3' ) {
          $('.LineY1').css('display', 'inline-flex');
          $('.LineY2').css('display', 'inline-flex');
          $('.LineY3').css('display', 'inline-flex');
          $('.LineY4').css('display', 'none');
          $('.LineY5').css('display', 'none');
          $('.LineY6').css('display', 'none');
          $('.LineY7').css('display', 'none');
          $('.LineY8').css('display', 'none');
          $('.LineY9').css('display', 'none');
          $('.LineY10').css('display', 'none');
        }
        if ( $('#txtNumY').val() == '4' ) {
          $('.LineY1').css('display', 'inline-flex');
          $('.LineY2').css('display', 'inline-flex');
          $('.LineY3').css('display', 'inline-flex');
          $('.LineY4').css('display', 'inline-flex');
          $('.LineY5').css('display', 'none');
          $('.LineY6').css('display', 'none');
          $('.LineY7').css('display', 'none');
          $('.LineY8').css('display', 'none');
          $('.LineY9').css('display', 'none');
          $('.LineY10').css('display', 'none');
        }
        if ( $('#txtNumY').val() == '5' ) {
          $('.LineY1').css('display', 'inline-flex');
          $('.LineY2').css('display', 'inline-flex');
          $('.LineY3').css('display', 'inline-flex');
          $('.LineY4').css('display', 'inline-flex');
          $('.LineY5').css('display', 'inline-flex');
          $('.LineY6').css('display', 'none');
          $('.LineY7').css('display', 'none');
          $('.LineY8').css('display', 'none');
          $('.LineY9').css('display', 'none');
          $('.LineY10').css('display', 'none');
        }
        if ( $('#txtNumY').val() == '6' ) {
          $('.LineY1').css('display', 'inline-flex');
          $('.LineY2').css('display', 'inline-flex');
          $('.LineY3').css('display', 'inline-flex');
          $('.LineY4').css('display', 'inline-flex');
          $('.LineY5').css('display', 'inline-flex');
          $('.LineY6').css('display', 'inline-flex');
          $('.LineY7').css('display', 'none');
          $('.LineY8').css('display', 'none');
          $('.LineY9').css('display', 'none');
          $('.LineY10').css('display', 'none');
        }
        if ( $('#txtNumY').val() == '7' ) {
          $('.LineY1').css('display', 'inline-flex');
          $('.LineY2').css('display', 'inline-flex');
          $('.LineY3').css('display', 'inline-flex');
          $('.LineY4').css('display', 'inline-flex');
          $('.LineY5').css('display', 'inline-flex');
          $('.LineY6').css('display', 'inline-flex');
          $('.LineY7').css('display', 'inline-flex');
          $('.LineY8').css('display', 'none');
          $('.LineY9').css('display', 'none');
          $('.LineY10').css('display', 'none');
        }
        if ( $('#txtNumY').val() == '8' ) {
          $('.LineY1').css('display', 'inline-flex');
          $('.LineY2').css('display', 'inline-flex');
          $('.LineY3').css('display', 'inline-flex');
          $('.LineY4').css('display', 'inline-flex');
          $('.LineY5').css('display', 'inline-flex');
          $('.LineY6').css('display', 'inline-flex');
          $('.LineY7').css('display', 'inline-flex');
          $('.LineY8').css('display', 'inline-flex');
          $('.LineY9').css('display', 'none');
          $('.LineY10').css('display', 'none');
        }
        if ( $('#txtNumY').val() == '9' ) {
          $('.LineY1').css('display', 'inline-flex');
          $('.LineY2').css('display', 'inline-flex');
          $('.LineY3').css('display', 'inline-flex');
          $('.LineY4').css('display', 'inline-flex');
          $('.LineY5').css('display', 'inline-flex');
          $('.LineY6').css('display', 'inline-flex');
          $('.LineY7').css('display', 'inline-flex');
          $('.LineY8').css('display', 'inline-flex');
          $('.LineY9').css('display', 'inline-flex');
          $('.LineY10').css('display', 'none');
        }
        if ( $('#txtNumY').val() == '10' ) {
          $('.LineY1').css('display', 'inline-flex');
          $('.LineY2').css('display', 'inline-flex');
          $('.LineY3').css('display', 'inline-flex');
          $('.LineY4').css('display', 'inline-flex');
          $('.LineY5').css('display', 'inline-flex');
          $('.LineY6').css('display', 'inline-flex');
          $('.LineY7').css('display', 'inline-flex');
          $('.LineY8').css('display', 'inline-flex');
          $('.LineY9').css('display', 'inline-flex');
          $('.LineY10').css('display', 'inline-flex');
        }

        //ยัดข้อมูลลง สติ๊กเกอร์
        if ($('#chkName')[0].checked == true) {
          $('.namePrint').css('display', 'block');
          $('.namePrint').html($('#txtName').val());
        }else{
          $('.namePrint').css('display', 'none');
        }
        if ($('#chkBarcode')[0].checked == true) {
          $('.barcodeNamePrint').css('display', 'block');
          $('.barcodePrint').barcode($('#txtBarcode').val(), "code128");
          $('.barcodeNamePrint').html($('#txtBarcode').val());
        }else{
          $('.barcodePrint').barcode($('#txtBarcode').val(), "code128");
          $('.barcodeNamePrint').css('display', 'none');
        }
        if ($('#chkPrice')[0].checked == true) {
          $('.pricePrint').css('display', 'block');
          $('.pricePrint').html("<?=lang('reparation_price');?> : "+$('#txtPrice').val());
        }else{
          $('.pricePrint').css('display', 'none');
        }
        if ($('#chkDetail')[0].checked == true) {
          $('.detailPrint').css('display', 'block');
          $('.detailPrint').html($('#txtDetail').val());
        }else{
          $('.detailPrint').css('display', 'none');
        }
      },
    }
</script> 

<div class="row barcoderow">
  <div class="col-md-12">
    <div>
      <div class="panel-body" style="padding: 0;">
        <div class="col-md-12 form-horizontal" style="padding: 0;">
          <div class="col-md-4 col-sm-12 col-xs-12" style="padding: 0px 20px 0px 0px;">
            <div class="panel panel-default" style="height: 580px;">
              <div class="panel-heading">
                <div class="panel-title"><h4><?=lang('Set_page');?> <small><?=lang('Paper_size_set');?></small></h4></div>
              </div>
              <div class="panel-body" style="padding: 15px 35px 15px 35px;">
                <div class="form-group">
                  <label class="control-label"><?=lang('paper_size_set_by_system');?></label>
                  <div class="radio col-md-12">
                    <div class="radio radio-replace">
                      <input class="radioSet" type="radio" value="a11" id="radio_11" onclick="mainLoad.radioSet(this.value);" name="radioSet">
                      <label for="radio_11" style="top: -6px;padding-left: 0px;"><?=lang('A11');?></label>
                    </div>
                    <div class="radio radio-replace">
                      <input class="radioSet" type="radio" value="a10" id="radio_10" onclick="mainLoad.radioSet(this.value);" name="radioSet">
                      <label for="radio_10" style="top: -6px;padding-left: 0px;"><?=lang('A10');?></label>
                    </div>
                    <div class="radio radio-replace">
                      <input class="radioSet" type="radio" value="a9" id="radio_a9" onclick="mainLoad.radioSet(this.value);" name="radioSet">
                      <label for="radio_a9" style="top: -6px;padding-left: 0px;"><?=lang('A9');?></label>
                    </div>
                    <div class="radio radio-replace">
                      <input class="radioSet" type="radio" value="a8" id="radio_a8" onclick="mainLoad.radioSet(this.value);" name="radioSet">
                      <label for="radio_a8" style="top: -6px;padding-left: 0px;"><?=lang('A8');?></label>
                    </div>
                    <div class="radio radio-replace">
                      <input class="radioSet" type="radio" value="a7" id="radio_a7" onclick="mainLoad.radioSet(this.value);" name="radioSet">
                      <label for="radio_a7" style="top: -6px;padding-left: 0px;"><?=lang('A7');?></label>
                    </div>
                    <div class="radio radio-replace">
                      <input class="radioSet" type="radio" value="cus" id="radio_cus" onclick="mainLoad.radioSet(this.value);" name="radioSet" checked>
                      <label for="radio_cus" style="top: -6px;padding-left: 0px;"><?=lang('Custom');?></label>
                    </div>
                    <label class="control-label"><?=lang('Custom Barcode Configs');?></label>
                    <?php $i = 1; foreach ($barcode_configs as $config): ?>
                      <div class="radio radio-replace">
                        <input <?=$i==1?'checked':'';?> class="radioSet" type="radio" value="<?=$config->name;?>" id="radio_<?=$config->name;?>" onclick="mainLoad.radioSet(<?=$config->id;?>);" name="radioSet">
                        <label for="radio_<?=$config->name;?>" style="top: -6px;padding-left: 0px;"><?=$config->name;?></label> <a href="javascript:;" onclick="mainLoad.updateSet(<?=$config->id;?>)" style="color: green;"><b><i class="fas fa-sync"></i></b></a> <a href="javascript:;" onclick="mainLoad.removeSet(<?=$config->id;?>)" style="color: red;"><b><i class="fas fa-trash"></i></b></a> 
                      </div>
                    <?php $i++; endforeach; ?>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="col-md-4 col-sm-12 col-xs-12" style="padding: 0px 20px 0px 0px;">
            <div class="panel panel-default" style="height: 580px;">
              <div class="panel-heading">
                <div class="panel-title"><h4><?=lang('Detailed section');?> <small><?=lang('Product Description');?></small></h4></div>
              </div>
              <div class="panel-body" style="padding: 15px 35px 15px 35px;">
                <div class=" col-md-12">
                  <div class="form-group">
                    <div class="checkbox checkbox-replace">
                      <input onclick="mainLoad.viewPrint();" type="checkbox" id="chkName" checked>
                      <label for="chkName" style="top: -6px;padding-left: 0px;"><?=lang('ProductName');?></label>
                    </div>
                    <input onkeyup="mainLoad.viewPrint();" id="txtName" type="text" class="form-control" placeholder="<?=lang('ProductNamePlaceholder');?>" value="<?= $item['name'];?>" />
                  </div>
                  <div class="form-group">
                    <div class="checkbox checkbox-replace">
                      <input onclick="mainLoad.viewPrint();" type="checkbox" id="chkBarcode" checked>
                      <label for="chkBarcode" style="top: -6px;padding-left: 0px;"><?=lang('BarCode');?></label>
                    </div>
                    <input onkeyup="mainLoad.viewPrint();" id="txtBarcode" type="text" class="form-control" placeholder="<?=lang('BarcodePlaceholder');?>" value="<?= $item['code'];?>" />
                  </div>
                  <div class="form-group">
                    <div class="checkbox checkbox-replace">
                      <input onclick="mainLoad.viewPrint();" type="checkbox" id="chkPrice" checked>
                      <label for="chkPrice" style="top: -6px;padding-left: 0px;"><?=lang('Price');?></label>
                    </div>
                    <input onkeyup="mainLoad.viewPrint();" id="txtPrice" type="text" class="form-control" placeholder="<?=lang('PricePlaceholder');?>" value="<?= number_format($item['price']);?> <?=$settings->currency;?>" />
                  </div>
                  <div class="form-group">
                    <div class="checkbox checkbox-replace">
                      <input onclick="mainLoad.viewPrint();" type="checkbox" id="chkDetail" checked>
                      <label for="chkDetail" style="top: -6px;padding-left: 0px;"><?=lang('ProductDescription');?> </label>
                    </div>
                    <textarea onkeyup="mainLoad.viewPrint();" id="txtDetail" class="form-control" rows="5" placeholder="<?=lang('ProductDescription');?>"><?= ($item['details']);?></textarea>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="col-md-4 col-sm-12 col-xs-12" style="padding: 0;">
            <div class="panel panel-default" style="height: 580px;">
              <div class="panel-heading">
                <div class="panel-title"><h4><?=lang('barcode_size_box');?></h4></div>
              </div>
              <div class="panel-body" style="padding: 15px 35px 15px 35px;">
                <div class="form-group">
                  <label class="control-label"><?=lang('barcode_header_spacing');?> </label>
                  <input id="txtTop" onkeyup="mainLoad.viewPrint();" type="number" class="form-control" value="0.10" placeholder="<?=lang('unit_cm_placeholder');?>" />
                </div>
                <div class="form-group">
                  <label class="control-label"><?=lang('barcode_paper_width');?></label>
                  <input id="txtSticX" onkeyup="mainLoad.viewPrint();" type="number" class="form-control" value="3.75"  placeholder="<?=lang('unit_cm_placeholder');?>" />
                </div>
                <div class="form-group">
                  <label class="control-label"><?=lang('barcode_paper_height');?></label>
                  <input id="txtSticY" onkeyup="mainLoad.viewPrint();" type="number" class="form-control" value="2.50" placeholder="<?=lang('unit_cm_placeholder');?>" />
                </div>
                <div class="form-group">
                  <label class="control-label"><?=lang('barcode_Horizontal_spacing');?></label>
                  <input id="txtWidth" onkeyup="mainLoad.viewPrint();" type="number" class="form-control" value="0.25"  placeholder="<?=lang('unit_cm_placeholder');?>" />
                </div>
                <div class="form-group">
                  <label class="control-label"><?=lang('barcode_Vertical_distance');?></label>
                  <input id="txtHeight" onkeyup="mainLoad.viewPrint();" type="number" class="form-control" value="0.29"  placeholder="<?=lang('unit_cm_placeholder');?>" />
                </div>
                <div class="form-group">
                  <label class="control-label"><?=lang('barcode_Sticker_horizontal');?> </label>
                  <input id="txtNumX" onkeyup="mainLoad.viewPrint();" type="number" class="form-control" value="1" placeholder="<?=lang('unit_cm_placeholder');?>" />
                </div>
                <div class="form-group">
                  <label class="control-label"><?=lang('barcode_Sticker_vertical');?></label>
                  <input id="txtNumY" onkeyup="mainLoad.viewPrint();" type="number" class="form-control" value="1" placeholder="<?=lang('unit_cm_placeholder');?>" />
                </div>
                <div class="clearfix"></div>
              </div>
                <div class="clearfix"></div>
            </div>
                <div class="clearfix"></div>

          </div>
                <div class="clearfix"></div>

          <div class="col-md-12 col-sm-12 col-xs-12" style="padding: 0px 0px 0px 0px;">
            <div class="panel panel-default" style="height: 118px;">
              <div class="panel-heading">
                <div class="panel-title"><h4><?=lang('barcode_manager_box');?></h4></div>
              </div>
              <div class="panel-body" style="padding: 15px 35px 15px 35px;">
                <div class="form-group">
                  <button data-toggle="modal" data-target="#newSizeBarcode" type="button" class="btn btn-info" style="font-size: 15px;margin-right: 20px;float: right;"><i class="entypo-cog"></i> <?=lang('Save Barcode Configuration');?></button>

                  <button id="btnPrint" type="button" class="btn btn-danger" style="width: 250px;font-size: 15px;"><i class="entypo-print"></i> <?=lang('print_barcode_now');?></button>
                </div>
              </div>
            </div>
          </div>

          <div class="col-md-12 col-sm-12 col-xs-12" style="padding: 0px 0px 0px 0px;">
            <div class="panel panel-default">
              <div class="panel-heading">
                <div class="panel-title"><h4><?=lang('display_window_barcode');?></h4></div>
              </div>
              <div class="panel-body" style="padding: 15px 35px 15px 35px;">
                <div class="form-group">
                  <!-- <center> -->
                    <div style="width: 21.3cm;margin-left:0.25cm;background: #2c3e50;">
                    <div style="width: 21cm;margin-left:0.25cm;height: 0.5cm;background: #2c3e50;"></div>
                    <div id="divPrint" style="width: 21cm;height: 29cm;margin-top:-0.25cm;margin-left:0.25cm;background: #2c3e50;">
                      <!-- <center> -->


                        <div class="LineY1 printY div50" style="display: inline-flex;margin-bottom: 0.25cm;">
                          <div class="printStic LineX1" style="width: 3.8cm;height: 2.5cm;margin: 0 0.10cm 0 0.10cm;background: white;">
                            <h4 class="text-left namePrint" style="margin: 3px 0px 0px 5px;"><?=lang('ProductName');?></h4>
                            <div class="text-left barcodePrint" style="margin: 3px 0px 0px -4px;"></div>
                            <p class="text-left barcodeNamePrint" style="margin: 0px 0 0 5px;"></p>
                            <p class="text-left detailPrint" style="margin: 0px 0 0 5px;line-height: 1;"><?=lang('ProductName');?></p>
                            <h4 class="text-left pricePrint" style="margin: 0px 0 0 5px;">0 <?=$settings->currency;?></h4>
                          </div>
                          <div class="display" id="break_page" style='page-break-after:always'></div>
                          <div class="printStic LineX2" style="width: 3.8cm;height: 2.5cm;margin: 0 0.10cm 0 0.10cm;background: white;">
                            <h4 class="text-left namePrint" style="margin: 3px 0px 0px 5px;"><?=lang('ProductName');?></h4>
                            <div class="text-left barcodePrint" style="margin: 3px 0px 0px -4px;"></div>
                            <p class="text-left barcodeNamePrint" style="margin: 0px 0 0 5px;"></p>
                            <p class="text-left detailPrint" style="margin: 0px 0 0 5px;line-height: 1;"><?=lang('ProductName');?></p>
                            <h4 class="text-left pricePrint" style="margin: 0px 0 0 5px;">0 <?=$settings->currency;?></h4>
                          </div>
                          <div class="display" id="break_page" style='page-break-after:always'></div>

                          <div class="printStic LineX3" style="width: 3.8cm;height: 2.5cm;margin: 0 0.10cm 0 0.10cm;background: white;">
                            <h4 class="text-left namePrint" style="margin: 3px 0px 0px 5px;"><?=lang('ProductName');?></h4>
                            <div class="text-left barcodePrint" style="margin: 3px 0px 0px -4px;"></div>
                            <p class="text-left barcodeNamePrint" style="margin: 0px 0 0 5px;"></p>
                            <p class="text-left detailPrint" style="margin: 0px 0 0 5px;line-height: 1;"><?=lang('ProductName');?></p>
                            <h4 class="text-left pricePrint" style="margin: 0px 0 0 5px;">0 <?=$settings->currency;?></h4>
                          </div>
                          <div class="printStic LineX4" style="width: 3.8cm;height: 2.5cm;margin: 0 0.10cm 0 0.10cm;background: white;">
                            <h4 class="text-left namePrint" style="margin: 3px 0px 0px 5px;"><?=lang('ProductName');?></h4>
                            <div class="text-left barcodePrint" style="margin: 3px 0px 0px -4px;"></div>
                            <p class="text-left barcodeNamePrint" style="margin: 0px 0 0 5px;"></p>
                            <p class="text-left detailPrint" style="margin: 0px 0 0 5px;line-height: 1;"><?=lang('ProductName');?></p>
                            <h4 class="text-left pricePrint" style="margin: 0px 0 0 5px;">0 <?=$settings->currency;?></h4>
                          </div>
                          <div class="printStic LineX5" style="width: 3.8cm;height: 2.5cm;margin: 0 0.10cm 0 0.10cm;background: white;">
                            <h4 class="text-left namePrint" style="margin: 3px 0px 0px 5px;"><?=lang('ProductName');?></h4>
                            <div class="text-left barcodePrint" style="margin: 3px 0px 0px -4px;"></div>
                            <p class="text-left barcodeNamePrint" style="margin: 0px 0 0 5px;"></p>
                            <p class="text-left detailPrint" style="margin: 0px 0 0 5px;line-height: 1;"><?=lang('ProductName');?></p>
                            <h4 class="text-left pricePrint" style="margin: 0px 0 0 5px;">0 <?=$settings->currency;?></h4>
                          </div>
                        </div>
                        <p style="padding: 0;margin: 0;"></p>
                        <div class="LineY2 printY div50" style="display: inline-flex;margin-bottom: 0.25cm;">
                          <div class="printStic LineX1" style="width: 3.8cm;height: 2.5cm;margin: 0 0.10cm 0 0.10cm;background: white;">
                            <h4 class="text-left namePrint" style="margin: 3px 0px 0px 5px;"><?=lang('ProductName');?></h4>
                            <div class="text-left barcodePrint" style="margin: 3px 0px 0px -4px;"></div>
                            <p class="text-left barcodeNamePrint" style="margin: 0px 0 0 5px;"></p>
                            <p class="text-left detailPrint" style="margin: 0px 0 0 5px;line-height: 1;"><?=lang('ProductName');?></p>
                            <h4 class="text-left pricePrint" style="margin: 0px 0 0 5px;">0 <?=$settings->currency;?></h4>
                          </div>
                          <div class="printStic LineX2" style="width: 3.8cm;height: 2.5cm;margin: 0 0.10cm 0 0.10cm;background: white;">
                            <h4 class="text-left namePrint" style="margin: 3px 0px 0px 5px;"><?=lang('ProductName');?></h4>
                            <div class="text-left barcodePrint" style="margin: 3px 0px 0px -4px;"></div>
                            <p class="text-left barcodeNamePrint" style="margin: 0px 0 0 5px;"></p>
                            <p class="text-left detailPrint" style="margin: 0px 0 0 5px;line-height: 1;"><?=lang('ProductName');?></p>
                            <h4 class="text-left pricePrint" style="margin: 0px 0 0 5px;">0 <?=$settings->currency;?></h4>
                          </div>
                          <div class="printStic LineX3" style="width: 3.8cm;height: 2.5cm;margin: 0 0.10cm 0 0.10cm;background: white;">
                            <h4 class="text-left namePrint" style="margin: 3px 0px 0px 5px;"><?=lang('ProductName');?></h4>
                            <div class="text-left barcodePrint" style="margin: 3px 0px 0px -4px;"></div>
                            <p class="text-left barcodeNamePrint" style="margin: 0px 0 0 5px;"></p>
                            <p class="text-left detailPrint" style="margin: 0px 0 0 5px;line-height: 1;"><?=lang('ProductName');?></p>
                            <h4 class="text-left pricePrint" style="margin: 0px 0 0 5px;">0 <?=$settings->currency;?></h4>
                          </div>
                          <div class="printStic LineX4" style="width: 3.8cm;height: 2.5cm;margin: 0 0.10cm 0 0.10cm;background: white;">
                            <h4 class="text-left namePrint" style="margin: 3px 0px 0px 5px;"><?=lang('ProductName');?></h4>
                            <div class="text-left barcodePrint" style="margin: 3px 0px 0px -4px;"></div>
                            <p class="text-left barcodeNamePrint" style="margin: 0px 0 0 5px;"></p>
                            <p class="text-left detailPrint" style="margin: 0px 0 0 5px;line-height: 1;"><?=lang('ProductName');?></p>
                            <h4 class="text-left pricePrint" style="margin: 0px 0 0 5px;">0 <?=$settings->currency;?></h4>
                          </div>
                          <div class="printStic LineX5" style="width: 3.8cm;height: 2.5cm;margin: 0 0.10cm 0 0.10cm;background: white;">
                            <h4 class="text-left namePrint" style="margin: 3px 0px 0px 5px;"><?=lang('ProductName');?></h4>
                            <div class="text-left barcodePrint" style="margin: 3px 0px 0px -4px;"></div>
                            <p class="text-left barcodeNamePrint" style="margin: 0px 0 0 5px;"></p>
                            <p class="text-left detailPrint" style="margin: 0px 0 0 5px;line-height: 1;"><?=lang('ProductName');?></p>
                            <h4 class="text-left pricePrint" style="margin: 0px 0 0 5px;">0 <?=$settings->currency;?></h4>
                          </div>
                        </div>
                        <p style="padding: 0;margin: 0;"></p>
                        <div class="LineY3 printY div50" style="display: inline-flex;margin-bottom: 0.25cm;">
                          <div class="printStic LineX1" style="width: 3.8cm;height: 2.5cm;margin: 0 0.10cm 0 0.10cm;background: white;">
                            <h4 class="text-left namePrint" style="margin: 3px 0px 0px 5px;"><?=lang('ProductName');?></h4>
                            <div class="text-left barcodePrint" style="margin: 3px 0px 0px -4px;"></div>
                            <p class="text-left barcodeNamePrint" style="margin: 0px 0 0 5px;"></p>
                            <p class="text-left detailPrint" style="margin: 0px 0 0 5px;line-height: 1;"><?=lang('ProductName');?></p>
                            <h4 class="text-left pricePrint" style="margin: 0px 0 0 5px;">0 <?=$settings->currency;?></h4>
                          </div>
                          <div class="printStic LineX2" style="width: 3.8cm;height: 2.5cm;margin: 0 0.10cm 0 0.10cm;background: white;">
                            <h4 class="text-left namePrint" style="margin: 3px 0px 0px 5px;"><?=lang('ProductName');?></h4>
                            <div class="text-left barcodePrint" style="margin: 3px 0px 0px -4px;"></div>
                            <p class="text-left barcodeNamePrint" style="margin: 0px 0 0 5px;"></p>
                            <p class="text-left detailPrint" style="margin: 0px 0 0 5px;line-height: 1;"><?=lang('ProductName');?></p>
                            <h4 class="text-left pricePrint" style="margin: 0px 0 0 5px;">0 <?=$settings->currency;?></h4>
                          </div>
                          <div class="printStic LineX3" style="width: 3.8cm;height: 2.5cm;margin: 0 0.10cm 0 0.10cm;background: white;">
                            <h4 class="text-left namePrint" style="margin: 3px 0px 0px 5px;"><?=lang('ProductName');?></h4>
                            <div class="text-left barcodePrint" style="margin: 3px 0px 0px -4px;"></div>
                            <p class="text-left barcodeNamePrint" style="margin: 0px 0 0 5px;"></p>
                            <p class="text-left detailPrint" style="margin: 0px 0 0 5px;line-height: 1;"><?=lang('ProductName');?></p>
                            <h4 class="text-left pricePrint" style="margin: 0px 0 0 5px;">0 <?=$settings->currency;?></h4>
                          </div>
                          <div class="printStic LineX4" style="width: 3.8cm;height: 2.5cm;margin: 0 0.10cm 0 0.10cm;background: white;">
                            <h4 class="text-left namePrint" style="margin: 3px 0px 0px 5px;"><?=lang('ProductName');?></h4>
                            <div class="text-left barcodePrint" style="margin: 3px 0px 0px -4px;"></div>
                            <p class="text-left barcodeNamePrint" style="margin: 0px 0 0 5px;"></p>
                            <p class="text-left detailPrint" style="margin: 0px 0 0 5px;line-height: 1;"><?=lang('ProductName');?></p>
                            <h4 class="text-left pricePrint" style="margin: 0px 0 0 5px;">0 <?=$settings->currency;?></h4>
                          </div>
                          <div class="printStic LineX5" style="width: 3.8cm;height: 2.5cm;margin: 0 0.10cm 0 0.10cm;background: white;">
                            <h4 class="text-left namePrint" style="margin: 3px 0px 0px 5px;"><?=lang('ProductName');?></h4>
                            <div class="text-left barcodePrint" style="margin: 3px 0px 0px -4px;"></div>
                            <p class="text-left barcodeNamePrint" style="margin: 0px 0 0 5px;"></p>
                            <p class="text-left detailPrint" style="margin: 0px 0 0 5px;line-height: 1;"><?=lang('ProductName');?></p>
                            <h4 class="text-left pricePrint" style="margin: 0px 0 0 5px;">0 <?=$settings->currency;?></h4>
                          </div>
                        </div>
                        <p style="padding: 0;margin: 0;"></p>
                        <div class="LineY4 printY div50" style="display: inline-flex;margin-bottom: 0.25cm;">
                          <div class="printStic LineX1" style="width: 3.8cm;height: 2.5cm;margin: 0 0.10cm 0 0.10cm;background: white;">
                            <h4 class="text-left namePrint" style="margin: 3px 0px 0px 5px;"><?=lang('ProductName');?></h4>
                            <div class="text-left barcodePrint" style="margin: 3px 0px 0px -4px;"></div>
                            <p class="text-left barcodeNamePrint" style="margin: 0px 0 0 5px;"></p>
                            <p class="text-left detailPrint" style="margin: 0px 0 0 5px;line-height: 1;"><?=lang('ProductName');?></p>
                            <h4 class="text-left pricePrint" style="margin: 0px 0 0 5px;">0 <?=$settings->currency;?></h4>
                          </div>
                          <div class="printStic LineX2" style="width: 3.8cm;height: 2.5cm;margin: 0 0.10cm 0 0.10cm;background: white;">
                            <h4 class="text-left namePrint" style="margin: 3px 0px 0px 5px;"><?=lang('ProductName');?></h4>
                            <div class="text-left barcodePrint" style="margin: 3px 0px 0px -4px;"></div>
                            <p class="text-left barcodeNamePrint" style="margin: 0px 0 0 5px;"></p>
                            <p class="text-left detailPrint" style="margin: 0px 0 0 5px;line-height: 1;"><?=lang('ProductName');?></p>
                            <h4 class="text-left pricePrint" style="margin: 0px 0 0 5px;">0 <?=$settings->currency;?></h4>
                          </div>
                          <div class="printStic LineX3" style="width: 3.8cm;height: 2.5cm;margin: 0 0.10cm 0 0.10cm;background: white;">
                            <h4 class="text-left namePrint" style="margin: 3px 0px 0px 5px;"><?=lang('ProductName');?></h4>
                            <div class="text-left barcodePrint" style="margin: 3px 0px 0px -4px;"></div>
                            <p class="text-left barcodeNamePrint" style="margin: 0px 0 0 5px;"></p>
                            <p class="text-left detailPrint" style="margin: 0px 0 0 5px;line-height: 1;"><?=lang('ProductName');?></p>
                            <h4 class="text-left pricePrint" style="margin: 0px 0 0 5px;">0 <?=$settings->currency;?></h4>
                          </div>
                          <div class="printStic LineX4" style="width: 3.8cm;height: 2.5cm;margin: 0 0.10cm 0 0.10cm;background: white;">
                            <h4 class="text-left namePrint" style="margin: 3px 0px 0px 5px;"><?=lang('ProductName');?></h4>
                            <div class="text-left barcodePrint" style="margin: 3px 0px 0px -4px;"></div>
                            <p class="text-left barcodeNamePrint" style="margin: 0px 0 0 5px;"></p>
                            <p class="text-left detailPrint" style="margin: 0px 0 0 5px;line-height: 1;"><?=lang('ProductName');?></p>
                            <h4 class="text-left pricePrint" style="margin: 0px 0 0 5px;">0 <?=$settings->currency;?></h4>
                          </div>
                          <div class="printStic LineX5" style="width: 3.8cm;height: 2.5cm;margin: 0 0.10cm 0 0.10cm;background: white;">
                            <h4 class="text-left namePrint" style="margin: 3px 0px 0px 5px;"><?=lang('ProductName');?></h4>
                            <div class="text-left barcodePrint" style="margin: 3px 0px 0px -4px;"></div>
                            <p class="text-left barcodeNamePrint" style="margin: 0px 0 0 5px;"></p>
                            <p class="text-left detailPrint" style="margin: 0px 0 0 5px;line-height: 1;"><?=lang('ProductName');?></p>
                            <h4 class="text-left pricePrint" style="margin: 0px 0 0 5px;">0 <?=$settings->currency;?></h4>
                          </div>
                        </div>
                        <p style="padding: 0;margin: 0;"></p>
                        <div class="LineY5 printY div50" style="display: inline-flex;margin-bottom: 0.25cm;">
                          <div class="printStic LineX1" style="width: 3.8cm;height: 2.5cm;margin: 0 0.10cm 0 0.10cm;background: white;">
                            <h4 class="text-left namePrint" style="margin: 3px 0px 0px 5px;"><?=lang('ProductName');?></h4>
                            <div class="text-left barcodePrint" style="margin: 3px 0px 0px -4px;"></div>
                            <p class="text-left barcodeNamePrint" style="margin: 0px 0 0 5px;"></p>
                            <p class="text-left detailPrint" style="margin: 0px 0 0 5px;line-height: 1;"><?=lang('ProductName');?></p>
                            <h4 class="text-left pricePrint" style="margin: 0px 0 0 5px;">0 <?=$settings->currency;?></h4>
                          </div>
                          <div class="printStic LineX2" style="width: 3.8cm;height: 2.5cm;margin: 0 0.10cm 0 0.10cm;background: white;">
                            <h4 class="text-left namePrint" style="margin: 3px 0px 0px 5px;"><?=lang('ProductName');?></h4>
                            <div class="text-left barcodePrint" style="margin: 3px 0px 0px -4px;"></div>
                            <p class="text-left barcodeNamePrint" style="margin: 0px 0 0 5px;"></p>
                            <p class="text-left detailPrint" style="margin: 0px 0 0 5px;line-height: 1;"><?=lang('ProductName');?></p>
                            <h4 class="text-left pricePrint" style="margin: 0px 0 0 5px;">0 <?=$settings->currency;?></h4>
                          </div>
                          <div class="printStic LineX3" style="width: 3.8cm;height: 2.5cm;margin: 0 0.10cm 0 0.10cm;background: white;">
                            <h4 class="text-left namePrint" style="margin: 3px 0px 0px 5px;"><?=lang('ProductName');?></h4>
                            <div class="text-left barcodePrint" style="margin: 3px 0px 0px -4px;"></div>
                            <p class="text-left barcodeNamePrint" style="margin: 0px 0 0 5px;"></p>
                            <p class="text-left detailPrint" style="margin: 0px 0 0 5px;line-height: 1;"><?=lang('ProductName');?></p>
                            <h4 class="text-left pricePrint" style="margin: 0px 0 0 5px;">0 <?=$settings->currency;?></h4>
                          </div>
                          <div class="printStic LineX4" style="width: 3.8cm;height: 2.5cm;margin: 0 0.10cm 0 0.10cm;background: white;">
                            <h4 class="text-left namePrint" style="margin: 3px 0px 0px 5px;"><?=lang('ProductName');?></h4>
                            <div class="text-left barcodePrint" style="margin: 3px 0px 0px -4px;"></div>
                            <p class="text-left barcodeNamePrint" style="margin: 0px 0 0 5px;"></p>
                            <p class="text-left detailPrint" style="margin: 0px 0 0 5px;line-height: 1;"><?=lang('ProductName');?></p>
                            <h4 class="text-left pricePrint" style="margin: 0px 0 0 5px;">0 <?=$settings->currency;?></h4>
                          </div>
                          <div class="printStic LineX5" style="width: 3.8cm;height: 2.5cm;margin: 0 0.10cm 0 0.10cm;background: white;">
                            <h4 class="text-left namePrint" style="margin: 3px 0px 0px 5px;"><?=lang('ProductName');?></h4>
                            <div class="text-left barcodePrint" style="margin: 3px 0px 0px -4px;"></div>
                            <p class="text-left barcodeNamePrint" style="margin: 0px 0 0 5px;"></p>
                            <p class="text-left detailPrint" style="margin: 0px 0 0 5px;line-height: 1;"><?=lang('ProductName');?></p>
                            <h4 class="text-left pricePrint" style="margin: 0px 0 0 5px;">0 <?=$settings->currency;?></h4>
                          </div>
                        </div>
                        <p style="padding: 0;margin: 0;"></p>
                        <div class="LineY6 printY div50" style="display: inline-flex;margin-bottom: 0.25cm;">
                          <div class="printStic LineX1" style="width: 3.8cm;height: 2.5cm;margin: 0 0.10cm 0 0.10cm;background: white;">
                            <h4 class="text-left namePrint" style="margin: 3px 0px 0px 5px;"><?=lang('ProductName');?></h4>
                            <div class="text-left barcodePrint" style="margin: 3px 0px 0px -4px;"></div>
                            <p class="text-left barcodeNamePrint" style="margin: 0px 0 0 5px;"></p>
                            <p class="text-left detailPrint" style="margin: 0px 0 0 5px;line-height: 1;"><?=lang('ProductName');?></p>
                            <h4 class="text-left pricePrint" style="margin: 0px 0 0 5px;">0 <?=$settings->currency;?></h4>
                          </div>
                          <div class="printStic LineX2" style="width: 3.8cm;height: 2.5cm;margin: 0 0.10cm 0 0.10cm;background: white;">
                            <h4 class="text-left namePrint" style="margin: 3px 0px 0px 5px;"><?=lang('ProductName');?></h4>
                            <div class="text-left barcodePrint" style="margin: 3px 0px 0px -4px;"></div>
                            <p class="text-left barcodeNamePrint" style="margin: 0px 0 0 5px;"></p>
                            <p class="text-left detailPrint" style="margin: 0px 0 0 5px;line-height: 1;"><?=lang('ProductName');?></p>
                            <h4 class="text-left pricePrint" style="margin: 0px 0 0 5px;">0 <?=$settings->currency;?></h4>
                          </div>
                          <div class="printStic LineX3" style="width: 3.8cm;height: 2.5cm;margin: 0 0.10cm 0 0.10cm;background: white;">
                            <h4 class="text-left namePrint" style="margin: 3px 0px 0px 5px;"><?=lang('ProductName');?></h4>
                            <div class="text-left barcodePrint" style="margin: 3px 0px 0px -4px;"></div>
                            <p class="text-left barcodeNamePrint" style="margin: 0px 0 0 5px;"></p>
                            <p class="text-left detailPrint" style="margin: 0px 0 0 5px;line-height: 1;"><?=lang('ProductName');?></p>
                            <h4 class="text-left pricePrint" style="margin: 0px 0 0 5px;">0 <?=$settings->currency;?></h4>
                          </div>
                          <div class="printStic LineX4" style="width: 3.8cm;height: 2.5cm;margin: 0 0.10cm 0 0.10cm;background: white;">
                            <h4 class="text-left namePrint" style="margin: 3px 0px 0px 5px;"><?=lang('ProductName');?></h4>
                            <div class="text-left barcodePrint" style="margin: 3px 0px 0px -4px;"></div>
                            <p class="text-left barcodeNamePrint" style="margin: 0px 0 0 5px;"></p>
                            <p class="text-left detailPrint" style="margin: 0px 0 0 5px;line-height: 1;"><?=lang('ProductName');?></p>
                            <h4 class="text-left pricePrint" style="margin: 0px 0 0 5px;">0 <?=$settings->currency;?></h4>
                          </div>
                          <div class="printStic LineX5" style="width: 3.8cm;height: 2.5cm;margin: 0 0.10cm 0 0.10cm;background: white;">
                            <h4 class="text-left namePrint" style="margin: 3px 0px 0px 5px;"><?=lang('ProductName');?></h4>
                            <div class="text-left barcodePrint" style="margin: 3px 0px 0px -4px;"></div>
                            <p class="text-left barcodeNamePrint" style="margin: 0px 0 0 5px;"></p>
                            <p class="text-left detailPrint" style="margin: 0px 0 0 5px;line-height: 1;"><?=lang('ProductName');?></p>
                            <h4 class="text-left pricePrint" style="margin: 0px 0 0 5px;">0 <?=$settings->currency;?></h4>
                          </div>
                        </div>
                        <p style="padding: 0;margin: 0;"></p>
                        <div class="LineY7 printY div50" style="display: inline-flex;margin-bottom: 0.25cm;">
                          <div class="printStic LineX1" style="width: 3.8cm;height: 2.5cm;margin: 0 0.10cm 0 0.10cm;background: white;">
                            <h4 class="text-left namePrint" style="margin: 3px 0px 0px 5px;"><?=lang('ProductName');?></h4>
                            <div class="text-left barcodePrint" style="margin: 3px 0px 0px -4px;"></div>
                            <p class="text-left barcodeNamePrint" style="margin: 0px 0 0 5px;"></p>
                            <p class="text-left detailPrint" style="margin: 0px 0 0 5px;line-height: 1;"><?=lang('ProductName');?></p>
                            <h4 class="text-left pricePrint" style="margin: 0px 0 0 5px;">0 <?=$settings->currency;?></h4>
                          </div>
                          <div class="printStic LineX2" style="width: 3.8cm;height: 2.5cm;margin: 0 0.10cm 0 0.10cm;background: white;">
                            <h4 class="text-left namePrint" style="margin: 3px 0px 0px 5px;"><?=lang('ProductName');?></h4>
                            <div class="text-left barcodePrint" style="margin: 3px 0px 0px -4px;"></div>
                            <p class="text-left barcodeNamePrint" style="margin: 0px 0 0 5px;"></p>
                            <p class="text-left detailPrint" style="margin: 0px 0 0 5px;line-height: 1;"><?=lang('ProductName');?></p>
                            <h4 class="text-left pricePrint" style="margin: 0px 0 0 5px;">0 <?=$settings->currency;?></h4>
                          </div>
                          <div class="printStic LineX3" style="width: 3.8cm;height: 2.5cm;margin: 0 0.10cm 0 0.10cm;background: white;">
                            <h4 class="text-left namePrint" style="margin: 3px 0px 0px 5px;"><?=lang('ProductName');?></h4>
                            <div class="text-left barcodePrint" style="margin: 3px 0px 0px -4px;"></div>
                            <p class="text-left barcodeNamePrint" style="margin: 0px 0 0 5px;"></p>
                            <p class="text-left detailPrint" style="margin: 0px 0 0 5px;line-height: 1;"><?=lang('ProductName');?></p>
                            <h4 class="text-left pricePrint" style="margin: 0px 0 0 5px;">0 <?=$settings->currency;?></h4>
                          </div>
                          <div class="printStic LineX4" style="width: 3.8cm;height: 2.5cm;margin: 0 0.10cm 0 0.10cm;background: white;">
                            <h4 class="text-left namePrint" style="margin: 3px 0px 0px 5px;"><?=lang('ProductName');?></h4>
                            <div class="text-left barcodePrint" style="margin: 3px 0px 0px -4px;"></div>
                            <p class="text-left barcodeNamePrint" style="margin: 0px 0 0 5px;"></p>
                            <p class="text-left detailPrint" style="margin: 0px 0 0 5px;line-height: 1;"><?=lang('ProductName');?></p>
                            <h4 class="text-left pricePrint" style="margin: 0px 0 0 5px;">0 <?=$settings->currency;?></h4>
                          </div>
                          <div class="printStic LineX5" style="width: 3.8cm;height: 2.5cm;margin: 0 0.10cm 0 0.10cm;background: white;">
                            <h4 class="text-left namePrint" style="margin: 3px 0px 0px 5px;"><?=lang('ProductName');?></h4>
                            <div class="text-left barcodePrint" style="margin: 3px 0px 0px -4px;"></div>
                            <p class="text-left barcodeNamePrint" style="margin: 0px 0 0 5px;"></p>
                            <p class="text-left detailPrint" style="margin: 0px 0 0 5px;line-height: 1;"><?=lang('ProductName');?></p>
                            <h4 class="text-left pricePrint" style="margin: 0px 0 0 5px;">0 <?=$settings->currency;?></h4>
                          </div>
                        </div>
                        <p style="padding: 0;margin: 0;"></p>
                        <div class="LineY8 printY div50" style="display: inline-flex;margin-bottom: 0.25cm;">
                          <div class="printStic LineX1" style="width: 3.8cm;height: 2.5cm;margin: 0 0.10cm 0 0.10cm;background: white;">
                            <h4 class="text-left namePrint" style="margin: 3px 0px 0px 5px;"><?=lang('ProductName');?></h4>
                            <div class="text-left barcodePrint" style="margin: 3px 0px 0px -4px;"></div>
                            <p class="text-left barcodeNamePrint" style="margin: 0px 0 0 5px;"></p>
                            <p class="text-left detailPrint" style="margin: 0px 0 0 5px;line-height: 1;"><?=lang('ProductName');?></p>
                            <h4 class="text-left pricePrint" style="margin: 0px 0 0 5px;">0 <?=$settings->currency;?></h4>
                          </div>
                          <div class="printStic LineX2" style="width: 3.8cm;height: 2.5cm;margin: 0 0.10cm 0 0.10cm;background: white;">
                            <h4 class="text-left namePrint" style="margin: 3px 0px 0px 5px;"><?=lang('ProductName');?></h4>
                            <div class="text-left barcodePrint" style="margin: 3px 0px 0px -4px;"></div>
                            <p class="text-left barcodeNamePrint" style="margin: 0px 0 0 5px;"></p>
                            <p class="text-left detailPrint" style="margin: 0px 0 0 5px;line-height: 1;"><?=lang('ProductName');?></p>
                            <h4 class="text-left pricePrint" style="margin: 0px 0 0 5px;">0 <?=$settings->currency;?></h4>
                          </div>
                          <div class="printStic LineX3" style="width: 3.8cm;height: 2.5cm;margin: 0 0.10cm 0 0.10cm;background: white;">
                            <h4 class="text-left namePrint" style="margin: 3px 0px 0px 5px;"><?=lang('ProductName');?></h4>
                            <div class="text-left barcodePrint" style="margin: 3px 0px 0px -4px;"></div>
                            <p class="text-left barcodeNamePrint" style="margin: 0px 0 0 5px;"></p>
                            <p class="text-left detailPrint" style="margin: 0px 0 0 5px;line-height: 1;"><?=lang('ProductName');?></p>
                            <h4 class="text-left pricePrint" style="margin: 0px 0 0 5px;">0 <?=$settings->currency;?></h4>
                          </div>
                          <div class="printStic LineX4" style="width: 3.8cm;height: 2.5cm;margin: 0 0.10cm 0 0.10cm;background: white;">
                            <h4 class="text-left namePrint" style="margin: 3px 0px 0px 5px;"><?=lang('ProductName');?></h4>
                            <div class="text-left barcodePrint" style="margin: 3px 0px 0px -4px;"></div>
                            <p class="text-left barcodeNamePrint" style="margin: 0px 0 0 5px;"></p>
                            <p class="text-left detailPrint" style="margin: 0px 0 0 5px;line-height: 1;"><?=lang('ProductName');?></p>
                            <h4 class="text-left pricePrint" style="margin: 0px 0 0 5px;">0 <?=$settings->currency;?></h4>
                          </div>
                          <div class="printStic LineX5" style="width: 3.8cm;height: 2.5cm;margin: 0 0.10cm 0 0.10cm;background: white;">
                            <h4 class="text-left namePrint" style="margin: 3px 0px 0px 5px;"><?=lang('ProductName');?></h4>
                            <div class="text-left barcodePrint" style="margin: 3px 0px 0px -4px;"></div>
                            <p class="text-left barcodeNamePrint" style="margin: 0px 0 0 5px;"></p>
                            <p class="text-left detailPrint" style="margin: 0px 0 0 5px;line-height: 1;"><?=lang('ProductName');?></p>
                            <h4 class="text-left pricePrint" style="margin: 0px 0 0 5px;">0 <?=$settings->currency;?></h4>
                          </div>
                        </div>
                        <p style="padding: 0;margin: 0;"></p>
                        <div class="LineY9 printY div50" style="display: inline-flex;margin-bottom: 0.25cm;">
                          <div class="printStic LineX1" style="width: 3.8cm;height: 2.5cm;margin: 0 0.10cm 0 0.10cm;background: white;">
                            <h4 class="text-left namePrint" style="margin: 3px 0px 0px 5px;"><?=lang('ProductName');?></h4>
                            <div class="text-left barcodePrint" style="margin: 3px 0px 0px -4px;"></div>
                            <p class="text-left barcodeNamePrint" style="margin: 0px 0 0 5px;"></p>
                            <p class="text-left detailPrint" style="margin: 0px 0 0 5px;line-height: 1;"><?=lang('ProductName');?></p>
                            <h4 class="text-left pricePrint" style="margin: 0px 0 0 5px;">0 <?=$settings->currency;?></h4>
                          </div>
                          <div class="printStic LineX2" style="width: 3.8cm;height: 2.5cm;margin: 0 0.10cm 0 0.10cm;background: white;">
                            <h4 class="text-left namePrint" style="margin: 3px 0px 0px 5px;"><?=lang('ProductName');?></h4>
                            <div class="text-left barcodePrint" style="margin: 3px 0px 0px -4px;"></div>
                            <p class="text-left barcodeNamePrint" style="margin: 0px 0 0 5px;"></p>
                            <p class="text-left detailPrint" style="margin: 0px 0 0 5px;line-height: 1;"><?=lang('ProductName');?></p>
                            <h4 class="text-left pricePrint" style="margin: 0px 0 0 5px;">0 <?=$settings->currency;?></h4>
                          </div>
                          <div class="printStic LineX3" style="width: 3.8cm;height: 2.5cm;margin: 0 0.10cm 0 0.10cm;background: white;">
                            <h4 class="text-left namePrint" style="margin: 3px 0px 0px 5px;"><?=lang('ProductName');?></h4>
                            <div class="text-left barcodePrint" style="margin: 3px 0px 0px -4px;"></div>
                            <p class="text-left barcodeNamePrint" style="margin: 0px 0 0 5px;"></p>
                            <p class="text-left detailPrint" style="margin: 0px 0 0 5px;line-height: 1;"><?=lang('ProductName');?></p>
                            <h4 class="text-left pricePrint" style="margin: 0px 0 0 5px;">0 <?=$settings->currency;?></h4>
                          </div>
                          <div class="printStic LineX4" style="width: 3.8cm;height: 2.5cm;margin: 0 0.10cm 0 0.10cm;background: white;">
                            <h4 class="text-left namePrint" style="margin: 3px 0px 0px 5px;"><?=lang('ProductName');?></h4>
                            <div class="text-left barcodePrint" style="margin: 3px 0px 0px -4px;"></div>
                            <p class="text-left barcodeNamePrint" style="margin: 0px 0 0 5px;"></p>
                            <p class="text-left detailPrint" style="margin: 0px 0 0 5px;line-height: 1;"><?=lang('ProductName');?></p>
                            <h4 class="text-left pricePrint" style="margin: 0px 0 0 5px;">0 <?=$settings->currency;?></h4>
                          </div>
                          <div class="printStic LineX5" style="width: 3.8cm;height: 2.5cm;margin: 0 0.10cm 0 0.10cm;background: white;">
                            <h4 class="text-left namePrint" style="margin: 3px 0px 0px 5px;"><?=lang('ProductName');?></h4>
                            <div class="text-left barcodePrint" style="margin: 3px 0px 0px -4px;"></div>
                            <p class="text-left barcodeNamePrint" style="margin: 0px 0 0 5px;"></p>
                            <p class="text-left detailPrint" style="margin: 0px 0 0 5px;line-height: 1;"><?=lang('ProductName');?></p>
                            <h4 class="text-left pricePrint" style="margin: 0px 0 0 5px;">0 <?=$settings->currency;?></h4>
                          </div>
                        </div>
                        <p style="padding: 0;margin: 0;"></p>
                        <div class="LineY10 printY div50" style="display: inline-flex;margin-bottom: 0.25cm;">
                          <div class="printStic LineX1" style="width: 3.8cm;height: 2.5cm;margin: 0 0.10cm 0 0.10cm;background: white;">
                            <h4 class="text-left namePrint" style="margin: 3px 0px 0px 5px;"><?=lang('ProductName');?></h4>
                            <div class="text-left barcodePrint" style="margin: 3px 0px 0px -4px;"></div>
                            <p class="text-left barcodeNamePrint" style="margin: 0px 0 0 5px;"></p>
                            <p class="text-left detailPrint" style="margin: 0px 0 0 5px;line-height: 1;"><?=lang('ProductName');?></p>
                            <h4 class="text-left pricePrint" style="margin: 0px 0 0 5px;">0 <?=$settings->currency;?></h4>
                          </div>
                          <div class="printStic LineX2" style="width: 3.8cm;height: 2.5cm;margin: 0 0.10cm 0 0.10cm;background: white;">
                            <h4 class="text-left namePrint" style="margin: 3px 0px 0px 5px;"><?=lang('ProductName');?></h4>
                            <div class="text-left barcodePrint" style="margin: 3px 0px 0px -4px;"></div>
                            <p class="text-left barcodeNamePrint" style="margin: 0px 0 0 5px;"></p>
                            <p class="text-left detailPrint" style="margin: 0px 0 0 5px;line-height: 1;"><?=lang('ProductName');?></p>
                            <h4 class="text-left pricePrint" style="margin: 0px 0 0 5px;">0 <?=$settings->currency;?></h4>
                          </div>
                          <div class="printStic LineX3" style="width: 3.8cm;height: 2.5cm;margin: 0 0.10cm 0 0.10cm;background: white;">
                            <h4 class="text-left namePrint" style="margin: 3px 0px 0px 5px;"><?=lang('ProductName');?></h4>
                            <div class="text-left barcodePrint" style="margin: 3px 0px 0px -4px;"></div>
                            <p class="text-left barcodeNamePrint" style="margin: 0px 0 0 5px;"></p>
                            <p class="text-left detailPrint" style="margin: 0px 0 0 5px;line-height: 1;"><?=lang('ProductName');?></p>
                            <h4 class="text-left pricePrint" style="margin: 0px 0 0 5px;">0 <?=$settings->currency;?></h4>
                          </div>
                          <div class="printStic LineX4" style="width: 3.8cm;height: 2.5cm;margin: 0 0.10cm 0 0.10cm;background: white;">
                            <h4 class="text-left namePrint" style="margin: 3px 0px 0px 5px;"><?=lang('ProductName');?></h4>
                            <div class="text-left barcodePrint" style="margin: 3px 0px 0px -4px;"></div>
                            <p class="text-left barcodeNamePrint" style="margin: 0px 0 0 5px;"></p>
                            <p class="text-left detailPrint" style="margin: 0px 0 0 5px;line-height: 1;"><?=lang('ProductName');?></p>
                            <h4 class="text-left pricePrint" style="margin: 0px 0 0 5px;">0 <?=$settings->currency;?></h4>
                          </div>
                          <div class="printStic LineX5" style="width: 3.8cm;height: 2.5cm;margin: 0 0.10cm 0 0.10cm;background: white;">
                            <h4 class="text-left namePrint" style="margin: 3px 0px 0px 5px;"><?=lang('ProductName');?></h4>
                            <div class="text-left barcodePrint" style="margin: 3px 0px 0px -4px;"></div>
                            <p class="text-left barcodeNamePrint" style="margin: 0px 0 0 5px;"></p>
                            <p class="text-left detailPrint" style="margin: 0px 0 0 5px;line-height: 1;"><?=lang('ProductName');?></p>
                            <h4 class="text-left pricePrint" style="margin: 0px 0 0 5px;">0 <?=$settings->currency;?></h4>
                          </div>
                        </div>
                      <!-- </center> -->
                    </div>
                  </div>
                  <!-- </center> -->
                </div>
              </div>
            </div>

<script type="text/javascript">
    $('#btnPrint').on('click', function(event) {
      // $("#divPrint, #break_page").printThis({
      //   debug: true,        
      //   importCSS: true,     
      //   importStyle: true,   
      //   printContainer: true,
      //   pageTitle: "",       
      //   removeInline: false, 
      //   printDelay: 333,     
      //   header: null,        
      //   footer: null,        
      //   base: false ,        
      //   formValues: true,    
      //   canvas: false,       
      //   doctypeString: "",
      //   removeScripts: false,
      //   copyTagClasses: false
      // });
    printContent('page');

    });

function printContent(div_id){
        $("#loadingmessage").show();
        var contents = $("#divPrint").html();
        var frame1 = $('<iframe />');
        frame1[0].name = "frame1";
        frame1.css({ "position": "absolute", "top": "-1000000px" });
        $("body").append(frame1);
        var frameDoc = frame1[0].contentWindow ? frame1[0].contentWindow : frame1[0].contentDocument.document ? frame1[0].contentDocument.document : frame1[0].contentDocument;
        frameDoc.document.open();
        //Create a new HTML document.
        frameDoc.document.write('<html><head><title>Print Barcode</title>');
        frameDoc.document.write('</head><body>');
        //Append the external CSS file.
        // frameDoc.document.write('<html><head><title>Print Barcode</title>');
        frameDoc.document.write('<style type="text/css" media="print"></style><html><head><title>Print Barcodes</title>');
        frameDoc.document.write('<link rel="stylesheet" href="<?= base_url(); ?>assets/bower_components/bootstrap/dist/css/bootstrap.min.css">');
        // frameDoc.document.write('<link rel="stylesheet" href="<?=$assets;?>dist/css/custom/rbarcode_print.css">');
        frameDoc.document.write('<link href="https://fonts.googleapis.com/css?family=Noto+Sans" rel="stylesheet">');

        frameDoc.document.write('<style type="text/css">@page {margin-top: 0cm;} table tr td {font-size:12px;}table > thead > tr >th , table> tbody > tr > td {font-size:10px}  #dontprint{display:none} .dontshow{display:display} body {font-family: "Noto Sans", \'Prompt\' !important;font-size: 12px;line-height: 1.42857143;font-weight: bold;}h4{font-size: 15px !important;}p{font-size: 12px !important;} </style>');
        //Append the DIV contents.
        frameDoc.document.write(contents);
        frameDoc.document.write('</body></html>');
        frameDoc.document.close();
        setTimeout(function () {
            $("#loadingmessage").hide();
            window.frames["frame1"].focus();
            window.frames["frame1"].print();
            frame1.remove();
        }, 3000);
}

function customPrint() {
    // var rightSide = document.getElementById("content-wrapper");
    // var oldMargin = rightSide.style.marginLeft;
    // rightSide.style.marginLeft = "0";
    // window.print();
    printContent('page');
    // rightSide.style.marginLeft = oldMargin;
}


$('#btnAddNewSize').on('click', function(event) {
    if ($('#newNameSize').val() == '') {
      $('#newNameSize').closest('.form-group').addClass('has-error');
      $('#newNameSize').focus();
      return false;
    }else{
      $('#newNameSize').closest('.form-group').removeClass('has-error');
    }
    // confirm
    bootbox.confirm({
      message: "<?=lang('r_u_sure');?>",
      callback: function(result) { if (result) {
    // confirm
      $('#btnAddNewSize').prop('disabled', true);
      if ($('#chkName')[0].checked == true) {
        var chkNameSize = 1;
      }else{
        var chkNameSize = 0;
      }
      if ($('#chkBarcode')[0].checked == true) {
        var chkBarcodeSize = 1;
      }else{
        var chkBarcodeSize = 0;
      }
      if ($('#chkPrice')[0].checked == true) {
        var chkPriceSize = 1;
      }else{
        var chkPriceSize = 0;
      }
      if ($('#chkDetail')[0].checked == true) {
        var chkDetailSize = 1;
      }else{
        var chkDetailSize = 0;
      }

      $.ajax({
          url: '<?=base_url();?>panel/barcode/newSizeBarcode',
          type: 'post',
          dataType: 'json',
          data: { 
            name : $('#newNameSize').val(),
            m_top : $('#txtTop').val(),
            width : $('#txtSticX').val(),
            height : $('#txtSticY').val(),
            m_width : $('#txtWidth').val(),
            y_width : $('#txtHeight').val(),
            num_x : $('#txtNumX').val(),
            num_y : $('#txtNumY').val(),
            ch_barcode : chkBarcodeSize,
            ch_name : chkNameSize,
            ch_detail : chkDetailSize,
            ch_price : chkPriceSize,
            ch_phone : 0,
            ch_passcode : 0,
            ch_date : 0,
            ch_model : 0,
          },
      })
      .done(function(data) {
        console.log(data);
        $('#btnAddNewSize').prop('disabled', false);
        $('#newSizeBarcode').modal('hide');
        toastr.success(data.msg);
        setTimeout(function() {
            location.reload();
        }, 1000);
      })
      .fail(function() {
        console.log("error");
      });
    }}});
  });
</script>
