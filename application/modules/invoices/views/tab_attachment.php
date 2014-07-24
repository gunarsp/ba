
<script type="text/javascript">
	
	function showFilemanager(id, win)
	{
		tinyfck_field = id;
		tinyfck = null;
		
		eval("window.SetUrl=function(value){document.getElementById('"+id+"').value=value; return true;}");
	    var connector = "<?php echo base_url(); ?>assets/tiny_mce/filemanager/browser.html?Connector=connectors/php/connector.php";
	    window.open(connector, "tinyfck", "modal,width=600,height=400");
	}
	
</script>
	
			<table>
				<tr>
					<th scope="col" class="first"><?php echo $this->lang->line('file'); ?></th>
					<th scope="col"><?php echo $this->lang->line('notes'); ?></th>
					<th scope="col" class="last"><?php echo $this->lang->line('actions'); ?></th>
				</tr>
				<?php foreach ($attachments as $attachment) { ?>
				<tr class="hoverall">
					<td class="first"><?php echo $attachment->attachment_id; ?></td>
					<td><?php echo $attachment->attachment_file; ?></td>
					<td><?php echo $attachment->attachment_note; ?></td>
					<td class="last">
						<a href="<?php echo site_url('classifiers/form/id/' . $attachment->attachment_id); ?>" title="<?php echo $this->lang->line('edit'); ?>">
							<?php echo icon('edit'); ?>
						</a>
						<a href="<?php echo site_url('classifiers/delete/id/' . $attachment->attachment_id); ?>" title="<?php echo $this->lang->line('delete'); ?>" onclick="javascript:if(!confirm('<?php echo $this->lang->line('confirm_delete'); ?>')) return false">
							<?php echo icon('delete'); ?>
						</a>
					</td>
				</tr>
				<?php } ?>
			</table>
	
	<dl>
		<dt><?php echo $this->lang->line('file'); ?>: </dt>
		<dd><input type="text" name="attachment_file" id="attachment_file" value="<?php echo $this->input->post('attachment_file');?>" />
		<a href="#" onclick="showFilemanager('attachment_file', this.window); return false;">
		<?php echo $this->lang->line('browse'); ?>
		</a>
		</dd>
	</dl>
	<dl>
		<dt><label><?php echo $this->lang->line('notes'); ?>: </label></dt>
		<dd><textarea name="attachment_notes" id="attachment_notes" rows="2" cols="40"><?php echo $invoice->invoice_notes; ?></textarea></dd>
	</dl>
	
	<input type="submit" id="btn_submit" name="btn_submit_attachment" value="<?php echo $this->lang->line('submit'); ?>" />

	<div style="clear: both;">&nbsp;</div>
	