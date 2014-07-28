<div class="section_wrapper">

	<h3 class="title_black"><?php echo $this->lang->line('chart'); ?></h3>

	<ul class="quicklinks content toggle">
	
		<li class="first"><?php echo anchor('accounting/chart/chart_account_form/', $this->lang->line('add') . ' ' . $this->lang->line('account')); ?></li>
		<li><?php echo anchor('accounting/fidavista/view', $this->lang->line('view') . ' ' . $this->lang->line('fidavista')); ?></li>
		<li class="last"><?php echo anchor('accounting/accounting_import/chart', $this->lang->line('import') . ' ' . $this->lang->line('chart')); ?></li>
	</ul>

</div>