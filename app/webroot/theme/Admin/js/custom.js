$(document).ready(function(e) {

	$ = jQuery;

	$('.wysiwyg').redactor({
		minHeight: 600,
		autoresize: true,
		imageGetJson: "/admin/redactor/finder.json",
		imageUpload: "/admin/redactor/imageUpload.json",
		fileUpload: "/admin/redactor/fileUpload.json"
	});

});