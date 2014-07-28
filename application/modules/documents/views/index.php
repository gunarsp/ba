<?php $this->load->view('dashboard/header'); ?>

<div class="grid_7" id="content_wrapper">

	<div class="section_wrapper">

		<h3 class="title_black"><?php echo $this->lang->line('documents'); ?>
		
		</h3>

		<?php $this->load->view('dashboard/system_messages'); ?>

		<div class="content toggle no_padding">
			
			<table>
				<tr>
					<th scope="col" class="first"><?php echo $this->lang->line('type'); ?></th>
					<th scope="col"><?php echo $this->lang->line('nr'); ?></th>
					<th scope="col"><?php echo $this->lang->line('name'); ?></th>
					<th scope="col"><?php echo $this->lang->line('amount'); ?></th>
					<th scope="col"><?php echo $this->lang->line('currency'); ?></th>
					<th scope="col"><?php echo $this->lang->line('amount_base_currency'); ?></th>
					<th scope="col"><?php echo $this->lang->line('date'); ?></th>
					<th scope="col"><?php echo $this->lang->line('partner'); ?></th>
					<th scope="col"><?php echo $this->lang->line('notes'); ?></th>
					<th scope="col" class="last"><?php echo $this->lang->line('actions'); ?></th>
				</tr>
				<?php foreach ($documents as $document) { ?>
				<tr class="hoverall">
					<td class="first"><?php echo $this->mdl_classifiers->getNameById($document->type); ?></td>
					<td><?php echo $document->nr; ?></td>
					<td><?php echo $document->name; ?></td>
					<td><?php echo $document->amount; ?></td>
					<td><?php echo $this->mdl_classifiers->getNameById($document->currency); ?></td>
					<td><?php echo $document->amount_base_curr; ?></td>
					<td><?php echo format_date($document->date); ?></td>
					<td><?php echo $this->mdl_partners->getNameById($document->currency); ?></td>
					<td><?php echo $document->notes; ?></td>
					<td class="last">
						<a href="<?php echo site_url('documents/form/id/' . $document->id); ?>" title="<?php echo $this->lang->line('edit'); ?>">
							<?php echo icon('edit'); ?>
						</a>
						<a href="<?php echo site_url('documents/delete/id/' . $document->id); ?>" title="<?php echo $this->lang->line('delete'); ?>" onclick="javascript:if(!confirm('<?php echo $this->lang->line('confirm_delete'); ?>')) return false">
							<?php echo icon('delete'); ?>
						</a>
					</td>
				</tr>
				<?php } ?>
			</table>

			<?php if ($this->mdl_documents->page_links) { ?>
			<div id="pagination">
				<?php echo $this->mdl_documents->page_links; ?>
			</div>
			<?php } ?>

		</div>

	</div>

</div>

<?php $this->load->view('dashboard/sidebar', array('side_block'=>array('documents/sidebar'))); ?>

<?php $this->load->view('dashboard/footer'); ?>