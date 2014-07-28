<div class="section_wrapper">

	<h3 class="title_black"><?php echo $this->lang->line('journal'); ?></h3>

	<ul class="quicklinks content toggle">
	
		<li class="last"><?php echo anchor('accounting/journal/transaction_form', $this->lang->line('add') . ' ' . $this->lang->line('transaction')); ?></li>
		<li class="last"><?php echo anchor('accounting/accounting_import/journal', $this->lang->line('import') . ' ' . $this->lang->line('journal')); ?></li>
	</ul>

</div>