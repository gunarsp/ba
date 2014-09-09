<?php $this->load->view('dashboard/header'); 
$this->load->view('dashboard/jquery_date_picker');
?>

<div class="grid_7" id="content_wrapper">

	<div class="section_wrapper">

		<h3 class="title_black"><?php echo $this->lang->line('ledger'); ?>
		
		</h3>

		<?php $this->load->view('dashboard/system_messages'); ?>

		<div class="content toggle">
			
			<form method="post" action="<?php echo site_url($this->uri->uri_string()); ?>">
				
				<dl>
					<dt><label> <?php echo $this->lang->line('date_from'); ?>: </label></dt>
					<dd><input type="text" name="date_from" class="datepicker" value="" /></dd>
				</dl>
				
				<dl>
					<dt><label> <?php echo $this->lang->line('date_to'); ?>: </label></dt>
					<dd><input type="text" name="date_to" class="datepicker" value="" /></dd>
				</dl>
				
                <div style="clear: both;">&nbsp;</div>

				<input type="submit" id="btn_submit" name="btn_submit" value="<?php echo $this->lang->line('submit'); ?>" />
				<input type="submit" id="btn_cancel" name="btn_cancel" value="<?php echo $this->lang->line('cancel'); ?>" />

			</form>
			
		</div>

	</div>

</div>

<?php $this->load->view('dashboard/sidebar', array('side_block'=>array('accounting/ledger_sidebar'))); ?>

<?php $this->load->view('dashboard/footer'); ?>