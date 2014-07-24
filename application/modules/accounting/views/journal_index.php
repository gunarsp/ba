<?php $this->load->view('dashboard/header'); ?>

<div class="grid_7" id="content_wrapper">

	<div class="section_wrapper">

		<h3 class="title_black"><?php echo $this->lang->line('journal'); ?>
		
		</h3>

		<?php $this->load->view('dashboard/system_messages'); ?>

		<div class="content toggle no_padding">
			
			<table>
				<tr>
					<th scope="col" class="first"><?php echo $this->lang->line('id'); ?></th>
					<th scope="col"><?php echo $this->lang->line('account'); ?></th>
					<th scope="col"><?php echo $this->lang->line('type'); ?></th>
					<th scope="col"><?php echo $this->lang->line('amount'); ?></th>
					
					<th scope="col"><?php echo $this->lang->line('date'); ?></th>
					<th scope="col"><?php echo $this->lang->line('document'); ?></th>
					<th scope="col"><?php echo $this->lang->line('notes'); ?></th>
					<th scope="col" class="last"><?php echo $this->lang->line('actions'); ?></th>
				</tr>
				<?php foreach ($entries as $entry) { print_r($entry); ?>
				<tr class="hoverall">
					<td class="first"><?php echo $entry->transaction_id; ?></td>
					<td><?php echo $entry->account; ?></td>
					<td><?php echo $this->mdl_classifiers->getValueByName($entry->debit_credit); ?></td>
					<td><?php echo $entry->transaction_amount; ?></td>
					
					<td><?php echo format_date($entry->transaction_date); ?></td>
					<td><?php echo (isset($entry->document_nr) ? $entry->document_nr : ''); ?></td>
					<td><?php echo $entry->transaction_notes; ?></td>
					<td class="last">
						<a href="<?php echo site_url('accounting/journal/transaction_form/id/' . $entry->id); ?>" title="<?php echo $this->lang->line('edit'); ?>">
							<?php echo icon('edit'); ?>
						</a>
						<a href="<?php echo site_url('accounting/journal/delete/id/' . $entry->id); ?>" title="<?php echo $this->lang->line('delete'); ?>" onclick="javascript:if(!confirm('<?php echo $this->lang->line('confirm_delete'); ?>')) return false">
							<?php echo icon('delete'); ?>
						</a>
					</td>
				</tr>
				<?php } ?>
			</table>

			<?php if ($this->mdl_journal->page_links) { ?>
			<div id="pagination">
				<?php echo $this->mdl_journal->page_links; ?>
			</div>
			<?php } ?>

		</div>

	</div>

</div>

<?php $this->load->view('dashboard/sidebar', array('side_block'=>array('accounting/journal_sidebar'))); ?>

<?php $this->load->view('dashboard/footer'); ?>