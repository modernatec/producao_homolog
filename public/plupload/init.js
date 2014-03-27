var uploader = new plupload.Uploader({
	//runtimes : 'gears,html5,flash,silverlight,browserplus',
    runtimes : 'html5,flash',
	browse_button : 'pickfiles',
	container: 'container',
	max_file_size : '1024mb',
    //chunk_size : '1mb',
    chunk_size : '500kb',
	url : base_url + 'admin/pluploader/',
	//resize : {width : 320, height : 240, quality : 90},
	flash_swf_url : base_url + '/public/plupload/js/plupload.flash.swf',
	silverlight_xap_url : base_url + '/public/plupload/js/plupload.silverlight.xap',
	filters : [
	/*{title : "Image files", extensions : "jpg,gif,png"},
	{title : "Zip files", extensions : "zip"}*/
	]
});

var filesUploads = [];
var mimeUploads = [];
var formUp;

uploader.bind('Init', function(up, params) {
	formUp = $('form');
});

uploader.bind('FilesAdded', function(up, files) {
	for (var i in files) {
		$('#filelist').append('<div id="' + files[i].id + '" class="delFiles">'+
			'<a class="excluir" title="excluir" href="javascript:excluirTemporario(\''+files[i].id+'\')">excluir</a> '
			+ files[i].name + ' (' + plupload.formatSize(files[i].size) + ') <b></b></div>');
	}
});

uploader.bind('FileUploaded', function(up, file, info) {
    var php = JSON.parse(info.response);    
    var r = php.result.split("@");
    filesUploads.push(r[0]);
    mimeUploads.push(r[1]);
    $('#'+file.id).attr('filePath',r[0]).attr('mimeType',r[1]);
    $('#'+file.id+' b').replaceWith('<a class="active" title="Upload OK">Upload OK</a>');
});

uploader.bind('UploadProgress', function(up, file) {
    $('#'+file.id+' b').html(file.percent+"%"); 
});

uploader.bind('UploadComplete', function(up, file) {    
    if (up.files.length === (up.total.uploaded + up.total.failed)) {
        $('#filesUploads').val(filesUploads.join(','));
        $('#mimeUploads').val(mimeUploads.join(','));
        //$.jGrowl("Upload concluído com sucesso.",{position:'bottom-right',sticky: true});
		if(formUp){
			formUp.submit();
		}
    }        
});

$('#uploadfiles').click(function() {
	uploader.start();
	return false;
});

$('#excluirTodos').click(function() {
    if(confirm('Deseja realmente excluir todos os arquivos?')){
        if($('.delFiles').size() > 0){
            $('.delFiles').each(function(){
                excluirTemporario($(this).attr('id'));
            });
        }else{
            alert('Nenhum arquivo à excluir!');
        }
    }
});

uploader.init();


/***melhorar***
var uploader_url = new Upload({idModulo:'url',
 callback:function(nameFile){
  //$('#tmb_url').attr('src','../application/upload/'+nameFile);
  $('#filesUploads_url').val(nameFile);  
  $("#filelist_url span").remove();
  $("#frmCreateUsers").submit();
 }})
uploader_url.init();
**/