<form action="<?=base_url();?>panel/reparation" method="get" class="sidebar-form">
	<div class="input-group">
	  <input type="text" name="q" class="form-control" placeholder="Search Reparations..." value="<?=$this->input->get('q');?>">
	  <span class="input-group-btn">
	        <button type="submit" name="search" id="search-btn" class="btn btn-flat">
	          <i class="fa fa-search"></i>
	        </button>
	      </span>
	</div>
</form>