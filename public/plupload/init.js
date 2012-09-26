var uploader = new plupload.Uploader({
	//runtimes : 'gears,html5,flash,silverlight,browserplus',
        runtimes : 'html5,flash',
	browse_button : 'pickfiles',
	container: 'container',
	max_file_size : '1024mb',
        chunk_size : '1mb',
	url : '/admin/pluploader/',
	resize : {width : 320, height : 240, quality : 90},
	flash_swf_url : '/public/plupload/js/plupload.flash.swf',
	silverlight_xap_url : '/public/plupload/js/plupload.silverlight.xap',
	filters : [
		/*{title : "Image files", extensions : "jpg,gif,png"},
		{title : "Zip files", extensions : "zip"}*/
	]
});

var filesUploads = [];
var mimeUploads = [];

uploader.bind('Init', function(up, params) {
	//document.getElementById('filelist').innerHTML = "<div>Current runtime: " + params.runtime + "</div>";
        $('#filelist').html('');
});

uploader.bind('FilesAdded', function(up, files) {
	for (var i in files) {
            $('#filelist').append('<div id="' + files[i].id + '">' + files[i].name + ' (' + plupload.formatSize(files[i].size) + ') <b>0%</b></div>');
	}
});

uploader.bind('FileUploaded', function(up, file, info) {
    var php = JSON.parse(info.response);    
    var r = php.result.split("@");
    filesUploads.push(r[0]);
    mimeUploads.push(r[1]);
    $('#'+file.id).attr('filePath',r[0]).attr('mimeType',r[1]);
    $('#'+file.id+' b').replaceWith('<a class="excluir" title="excluir" href="javascript:excluirTemporario(\''+file.id+'\')">excluir</a>');
});

uploader.bind('UploadProgress', function(up, file) {
	var f = document.getElementById(file.id);
        $(f).children('b').html('<span>' + file.percent + "%</span>");
        
});

uploader.bind('UploadComplete', function(up, file) {    
	if (up.files.length === (up.total.uploaded + up.total.failed)) {
            $('#filesUploads').val(filesUploads.join(','));
            $('#mimeUploads').val(mimeUploads.join(','));
        }        
});

$('#uploadfiles').click(function() {
	uploader.start();
	return false;
});

uploader.init();