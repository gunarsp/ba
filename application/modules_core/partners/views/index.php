<?php $this->load->view('dashboard/header'); ?>

<div class="grid_7" id="content_wrapper">

	<div class="section_wrapper">

		<h3 class="title_black"><?php echo $this->lang->line('partners'); ?>
		
		</h3>

		<?php $this->load->view('dashboard/system_messages'); ?>

		<div class="content toggle no_padding">
			
			<table>
				<tr>
					<th scope="col" class="first"><?php echo $this->lang->line('date_from'); ?></th>
					<th scope="col"><?php echo $this->lang->line('date_to'); ?></th>
					<th scope="col"><?php echo $this->lang->line('type'); ?></th>
					<th scope="col"><?php echo $this->lang->line('name'); ?></th>
					<th scope="col"><?php echo $this->lang->line('notes'); ?></th>
					<th scope="col" class="last"><?php echo $this->lang->line('actions'); ?></th>
				</tr>
				<?php foreach ($partners as $partner) { ?>
				<tr class="hoverall">
					<td class="first"><?php echo format_date($partner->date_from); ?></td>
					<td><?php echo format_date($partner->date_to); ?></td>
					<td><?php 
							echo (1==$partner->supplier?$this->lang->line('supplier').'; ':'');
							echo (1==$partner->buyer?$this->lang->line('buyer').'; ':'');
						?></td>
					<td><?php echo $partner->name; ?></td>
					<td><?php echo $partner->notes; ?></td>
					<td class="last">
						<a href="<?php echo site_url('partners/form/id/' . $partner->id); ?>" title="<?php echo $this->lang->line('edit'); ?>">
							<?php echo icon('edit'); ?>
						</a>
						<a href="<?php echo site_url('partners/delete/id/' . $partner->id); ?>" title="<?php echo $this->lang->line('delete'); ?>" onclick="javascript:if(!confirm('<?php echo $this->lang->line('confirm_delete'); ?>')) return false">
							<?php echo icon('delete'); ?>
						</a>
					</td>
				</tr>
				<?php } ?>
			</table>

			<?php if ($this->mdl_partners->page_links) { ?>
			<div id="pagination">
				<?php echo $this->mdl_partners->page_links; ?>
			</div>
			<?php } ?>

		</div>

	</div>

</div>

<?php $this->load->view('dashboard/sidebar', array('side_block'=>array('partners/sidebar'))); ?>

<?php $this->load->view('dashboard/footer'); ?>