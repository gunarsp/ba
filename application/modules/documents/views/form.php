<?php 
$this->load->view('dashboard/header'); 
$this->load->view('dashboard/jquery_date_picker');
?>



<div class="grid_10" id="content_wrapper">

	<div class="section_wrapper">

		<h3 class="title_black"><?php echo $this->lang->line('edit') . ' ' . $this->lang->line('document'); ?></h3>

		<?php $this->load->view('dashboard/system_messages'); ?>

		<div class="content toggle">

			<form method="post" action="<?php echo site_url($this->uri->uri_string()); ?>">
				
				<dl>
					<dt><label><?php echo $this->lang->line('type'); ?>: </label></dt>
					<dd>
						<select name="type" id="type">
					
							<?php foreach ($document_types as $document_type) { ?>
							<option value="<?php echo $document_type->value; ?>" <?php if($document_type->value == $this->mdl_documents->form_value('type')) { ?>selected="selected"<?php } ?>><?php echo $document_type->name; ?></option>
							<?php } ?>
						</select>
					</dd>
				</dl>
				
				<dl>
					<dt><label> <?php echo $this->lang->line('nr'); ?>: </label></dt>
					<dd><input type="text" name="nr" id="nr" value="<?php echo $this->mdl_documents->form_value('nr'); ?>" /></dd>
				</dl>
				
				<dl>
					<dt><label> <?php echo $this->lang->line('name'); ?>: </label></dt>
					<dd><input type="text" name="name" id="name" value="<?php echo $this->mdl_documents->form_value('name'); ?>" /></dd>
				</dl>

				<dl>
					<dt><label> <?php echo $this->lang->line('amount'); ?>: </label></dt>
					<dd><input type="text" name="amount" id="amount" value="<?php echo $this->mdl_documents->form_value('amount'); ?>" /></dd>
				</dl>
				
				<dl>
					<dt><label><?php echo $this->lang->line('currency'); ?>: </label></dt>
					<dd>
						<select name="currency" id="currency">
					
							<?php foreach ($currencies as $currency) { ?>
							<option value="<?php echo $currency->value; ?>" <?php if($currency->value == $this->mdl_documents->form_value('currency')) { ?>selected="selected"<?php } ?>><?php echo $currency->name; ?></option>
							<?php } ?>
						</select>
					</dd>
				</dl>
				
				<dl>
					<dt><label> <?php echo $this->lang->line('amount_base_curr'); ?>: </label></dt>
					<dd><input type="text" name="amount_base_curr" id="amount_base_curr" value="<?php echo $this->mdl_documents->form_value('amount_base_curr'); ?>" /></dd>
				</dl>
				
				<dl>
					<dt><label> <?php echo $this->lang->line('date'); ?>: </label></dt>
					<dd><input type="text" name="date" class="datepicker" value="<?php echo $this->mdl_documents->form_value('date'); ?>" /></dd>
				</dl>
					
				<dl>
					<dt><label> <?php echo $this->lang->line('notes'); ?>: </label></dt>
					<dd><input type="text" name="notes" id="notes" value="<?php echo $this->mdl_documents->form_value('notes'); ?>" /></dd>
				</dl>
				
				<dl>
					<dt><label><?php echo $this->lang->line('partner'); ?>: </label></dt>
					<dd>
						<select name="partner_id" id="partner_id">
					
							<?php foreach ($partners as $partner) { ?>
							<option value="<?php echo $partner->value; ?>" <?php if($partner->id == $this->mdl_documents->form_value('partner_id')) { ?>selected="selected"<?php } ?>><?php echo $partner->name; ?></option>
							<?php } ?>
						</select>
					</dd>
				</dl>
				
                <div style="clear: both;">&nbsp;</div>

				<input type="submit" id="btn_submit" name="btn_submit" value="<?php echo $this->lang->line('submit'); ?>" />
				<input type="submit" id="btn_cancel" name="btn_cancel" value="<?php echo $this->lang->line('cancel'); ?>" />

			</form>

		</div>

	</div>

</div>

<?php $this->load->view('dashboard/footer'); ?>