<?php

$multiple = isset($multiple) ? (bool)$multiple : true;
if ($files = $this->request->data('files')) {
	if (!is_array($files)) {
		$files = false;
	}
}
?>
<div class="progress-upload">
	<span class="btn btn-default btn-sm fileinput-button" <?php if ($files && !$multiple) echo 'style="display:none;"'; ?>>
	    <span class="glyphicon glyphicon-plus"></span>
	    <span style="padding-left:5px;"><?php echo __('Select Files'); ?>...</span>
	    <input id="fileupload" type="file" name="files" multiple />
	</span>
	<div id="files">
	<input type="hidden" name="files" value="" />
	<?php 
	if ($files):
		foreach ($files as $key => $file): 
			if (empty($file['url'])) {
				continue;	
			}	
		?>
		<div class="file clearfix col-xs-10 col-sm-5" id="file-upload-<?php echo $key; ?>">
			<div class="overview success">
				<a href="<?php echo $file['url']; ?>" target="_blank"><?php echo $file['name']; ?></a>
				<input type="hidden" name="files[<?php echo $key; ?>][url]" value="<?php echo $file['url']; ?>" />
				<input type="hidden" name="files[<?php echo $key; ?>][name]" value="<?php echo $file['name']; ?>" />
				<?php if (!empty($file['id'])): ?>
				<input type="hidden" name="files[<?php echo $key; ?>][id]" value="<?php echo $file['id']; ?>" />
				<?php endif; ?>
			</div>
			<div class="actions">
				<a href="#" class="remove">
					<span class="glyphicon glyphicon-trash"></span>
					<?php echo __('Remove'); ?>
				</a>
			</div>
		</div>
		<?php endforeach; ?>
	<?php endif; ?>
	</div>
</div>





<?php $this->append('scriptBottom'); ?>
<?php echo $this->Html->css('/js/jquery_file_upload/css/jquery.fileupload-ui.css'); ?>
<?php echo $this->Html->script('jquery_file_upload/js/vendor/jquery.ui.widget.js') . "\n"; ?>
<?php echo $this->Html->script('jquery_file_upload/js/load-image.min.js') . "\n"; ?>
<?php echo $this->Html->script('jquery_file_upload/js/canvas-to-blob.min.js') . "\n"; ?>
<?php echo $this->Html->script('jquery_file_upload/js/jquery.iframe-transport.js') . "\n"; ?>
<?php echo $this->Html->script('jquery_file_upload/js/jquery.fileupload.js') . "\n"; ?>
<?php echo $this->Html->script('jquery_file_upload/js/jquery.fileupload-process.js') . "\n"; ?>
<?php echo $this->Html->script('jquery_file_upload/js/jquery.fileupload-image.js') . "\n"; ?>
<?php echo $this->Html->script('jquery_file_upload/js/jquery.fileupload-audio.js') . "\n"; ?>
<?php echo $this->Html->script('jquery_file_upload/js/jquery.fileupload-video.js') . "\n"; ?>
<?php echo $this->Html->script('jquery_file_upload/js/jquery.fileupload-validate.js') . "\n"; ?>
<?php echo $this->Html->script('jquery_file_upload/js/jquery.fileupload-ui.js') . "\n"; ?>
<!--[if gte IE 8]>
<?php echo $this->Html->script('jquery_file_upload/js/cors/jquery.xdr-transport.js'); ?>
<![endif]-->

	<script type="text/javascript">
	$(function() {

		var $fileInputBtn = $('#fileupload');
		
		$fileInputBtn.fileupload({
			url: '<?php echo Router::url("/media/upload"); ?>',
			add: function (e, data) {
				<?php if (!$multiple): ?>
				$('.fileinput-button').hide();
				<?php endif; ?>
				data.upload_id = new Date().getTime();
				$.each(data.files, function (index, file) {
					$('#files').append([
						'<div class="file clearfix col-xs-10 col-sm-5" id="file-upload-'+ data.upload_id +'">',
							'<div class="overview">',
								file.name,
							'</div>',
							'<div class="actions">',
								'<div class="progress progress-striped"><div class="progress-bar progress-bar-success"></div></div>',
							'</div>',
						'</div>',
					].join(''));					
				});
				data.submit();	
			},
			dataType: 'json', 
			progress: function (e, data) {
				console.log(data);
				var progress = parseInt(data.loaded / data.total * 100, 10);
				$('#file-upload-'+ data.upload_id +' .progress .progress-bar').css('width', progress + '%');
			},               
			done: function (e, data) {
				$.each(data.result.files, function (index, file) {
					window.setTimeout(function() {
						$('#file-upload-'+ data.upload_id +' .progress').fadeOut(200, function() { 
							var parent = $(this).parent().empty();
							if (file.error) {
								parent.siblings().addClass('error').prepend('<span class="glyphicon glyphicon-warning-sign"></span> ' + file.error + ' - ');
							} else {
								parent.siblings().addClass('success').html('<span class="glyphicon glyphicon-ok"></span><a href="'+ file.url +'" target="_blank">'+ data.files[index]['name'] +'</a>');
								parent.append('<input type="hidden" name="files[' + data.upload_id + '][url]" value="' + file.url + '" >');
								parent.append('<input type="hidden" name="files[' + data.upload_id + '][name]" value="' + data.files[index]['name'] + '" >');
							}	
							parent.append('<a href="#" data-delete-url="'+ file.delete_url +'" class="remove"><span class="glyphicon glyphicon-trash"></span>Remove</a>');						
						});				
					}, 700);
				});
			},
			fail: function (e, data) {
				console.log(data.errorThrown);
				console.log(data.textStatus);
				console.log(data.jqXHR);

			}
		});
		
	    // Enable iframe cross-domain access via redirect option:
	    $fileInputBtn.fileupload(
	        'option',
	        'redirect',
	        window.location.href.replace(
	            /\/[^\/]*$/,
	            '<?php echo Router::url("/js/jquery_file_upload/cors/result.html", true); ?>'
	        )
	    );
	    
		$('#files').on('click', '.remove', function() {
			$(this).parent().parent().fadeOut(200, function() {
				$(this).remove();
				<?php if (!$multiple): ?>
				$('.fileinput-button').show();
				<?php endif; ?>
			});
			var delete_url = $(this).data('delete-url');
			if (delete_url) {
				$.ajax(delete_url, { type : 'DELETE', dataType : 'json' });		
			}
			return false;
		});	    		
	
	});
	</script>
<?php $this->end(); ?>



    