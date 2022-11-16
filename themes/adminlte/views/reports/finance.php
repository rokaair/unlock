<?php 
	$total = 0;
	for ($i = 1; $i <= 30; ++$i) {
	    $total += $list[$i];
	}
?>
	<!--main content start-->
			<!-- page start-->
			<div class="interno" id="morris">
				<div class="col-lg-12">
					<section class="panel">
						<header class="panel-heading">
				            <h3 class="pull-left"><?=$this->lang->line('months_earning_report');?>: <i><?=$list[32].'/'.$list[33]; ?></h3>
				            <h3 class="pull-right"><?=$this->lang->line('gross_revenue');?>: <?= ($total); ?></h3>
						</header>
						<div class="panel-body">
							<div id="hero-area" class="graph"></div>
						</div>
					</section>
				</div>
				<div class="col-lg-8 col-sm-6">
					<div class="box">
						<div class="box-body">
							<div class="form-group">
                            <?=lang('choose_month', 'choose_month');?>
                            <div class="input-group">
                                <div class="input-group-addon">
                            		<i class="fa fa-calendar"></i>
                                </div>
								<input type="text" readonly="" value="<?=$list[32].'/'.$list[33]; ?>" id="date" size="16" class="form-control">

                                <a class="submit_date btn btn-primary input-group-addon"><i class="fa fa-refresh"></i> <?=$this->lang->line('update');?></a> 
                            </div>
                        </div>
						</div>
					</div>
				</div>
				<div class="col-lg-3 col-xs-6">
		          <!-- small box -->
		          <div class="small-box bg-red">
		            <div class="inner">
		              <h3><?= $currency; ?> <?=($total);?></h3>
		              <p><?=$this->lang->line('this_month');?></p>
		            </div>
		            <div class="icon">
		              <i class="ion ion-pie-graph"></i>
		            </div>
		          </div>
		        </div>
			</div>
			<div class="clearfix"></div>
			<!-- page end-->
	<!--main content end-->

	<script>
		var Script = function() {

			jQuery(function() {
				Morris.Area({
					element: 'hero-area',
					data: [
					<?php if (count($list) <= 1): ?>
						  {period: '01', earnings: '0'}
					<?php else: ?>
					    <?php for ($i = 1; $i <= 30; ++$i):  ?>
					       {period: "<?= $list[33].'-'.$list[32].'-'.$i ?>", earnings: "<?= $list[$i]; ?>"},
					    <?php endfor; ?>
					<?php endif; ?>
		            
					],

					xkey: 'period',
					ykeys: ['earnings'],
					labels: ['<?=$this->lang->line('
						earnings_graph ');?>'
					],
					hideHover: 'auto',
					lineWidth: 1,
					pointSize: 2,
					lineColors: ['#33df33'],
					fillOpacity: 0.5,
					smooth: true,
					xLabelAngle: 0,
					xLabels: 'day',
					xLabelFormat: function(x) {
						return x.getUTCDate();
					},
					yLabelFormat: function(y) {
                        return "<?= $currency; ?>" + y.toString();
					}
				});
			});

		}();
		
		jQuery(document).ready(function () {
			jQuery('.submit_date').click(function (e) {
				var url = jQuery("#date").val();
				window.location = base_url+"panel/reports/finance/" + url;
			});
		});
		$(function(){
		    var datepicker = $.fn.datepicker.noConflict();
		    $.fn.bootstrapDP = datepicker;  
		    $("#date").bootstrapDP({
		    	 format: "mm/yyyy",
			    viewMode: "months", 
			    minViewMode: "months"
		    });    
		});
		
		
	</script>