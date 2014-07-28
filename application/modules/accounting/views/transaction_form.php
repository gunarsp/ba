<?php 
$this->load->view('dashboard/header'); 
$this->load->view('dashboard/jquery_date_picker');
?>



<div class="grid_10" id="content_wrapper">

	<div class="section_wrapper">

		<h3 class="title_black"><?php echo $this->lang->line('edit') . ' ' . $this->lang->line('transaction'); ?></h3>

		<?php $this->load->view('dashboard/system_messages'); ?>

		<div class="content toggle">

			<form method="post" action="<?php echo site_url($this->uri->uri_string()); ?>">
				
				<dl>
					<dt><label> <?php echo $this->lang->line('account'); ?>: </label></dt>
					<dd><input type="text" name="account" id="account" value="<?php echo $this->mdl_journal->form_value('account'); ?>" /></dd>
				</dl>
				
				<dl>
					<dt><label><?php echo $this->lang->line('type'); ?>: </label></dt>
					<dd>
						<select name="debit_credit" id="debit_credit">
					
							<?php foreach ($debit_credit as $dc) { ?>
							<option value="<?php echo $dc->value; ?>" <?php if($dc->value == $this->mdl_journal->form_value('debit_credit')) { ?>selected="selected"<?php } ?>><?php echo $dc->name; ?></option>
							<?php } ?>
						</select>
					</dd>
				</dl>
				
				<dl>
					<dt><label> <?php echo $this->lang->line('amount'); ?>: </label></dt>
					<dd><input type="text" name="amount" id="amount" value="<?php echo $this->mdl_journal->form_value('amount'); ?>" /></dd>
				</dl>
				
				<dl>
					<dt><label> <?php echo $this->lang->line('date'); ?>: </label></dt>
					<dd><input type="text" name="date" class="datepicker" value="<?php echo $this->mdl_journal->form_value('date'); ?>" /></dd>
				</dl>
						
				<dl>
					<dt><label> <?php echo $this->lang->line('notes'); ?>: </label></dt>
					<dd><input type="text" name="notes" id="notes" value="<?php echo $this->mdl_journal->form_value('notes'); ?>" /></dd>
				</dl>
				
                <div style="clear: both;">&nbsp;</div>

				<input type="submit" id="btn_submit" name="btn_submit" value="<?php echo $this->lang->line('submit'); ?>" />
				<input type="submit" id="btn_cancel" name="btn_cancel" value="<?php echo $this->lang->line('cancel'); ?>" />

			</form>

		</div>

	</div>

</div>

<?php $this->load->view('dashboard/footer'); ?>