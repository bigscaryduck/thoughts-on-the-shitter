<div class="pagination-container clearfix">
	<?php /* ?>
	<div class="pagination-totals">
		<?php echo $this->Paginator->counter(array('format' => __('Page {:page} of {:pages}, Showing {:current} record(s) out of {:count} total'))) ?>
	</div>
	<?php */ ?>
	<?php echo $this->Paginator->numbers(array('class' => 'pull-right')); ?>
</div>