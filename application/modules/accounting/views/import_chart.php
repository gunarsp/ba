<?php $this->load->view('dashboard/header'); ?>

	<div class="grid_10" id="content_wrapper">

		<div class="section_wrapper">
		
			<h3 class="title_black">Import chart</h3>
			
			<?php $this->load->view('dashboard/system_messages'); ?>
			
			<div class="content toggle">

				<form method="post" action="<?php echo site_url($this->uri->uri_string()); ?>" enctype="multipart/form-data">

					<div id="tab_client">

							<dl>
								<dt><?php echo $this->lang->line('file'); ?>: </dt>
								<dd><input type="file" name="file" id="file" value="<?php echo $this->input->post('file');?>" /></dd>
							</dl>
							
							<dl>
								<dt></dt>
								<dd><input type="submit" name="btn_submit" value="<?php echo $this->lang->line('submit'); ?>" /> <input type="submit" name="btn_cancel" value="<?php echo $this->lang->line('cancel'); ?>" /></dd>
							</dl>
						

					</div>

			</form>
				
			</div>

		</div>
		
		</form>
	
	<?php 
	
	
	
	?>
		
	</div>

<?php $this->load->view('dashboard/footer'); ?>