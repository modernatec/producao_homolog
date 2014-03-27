function Upload(args){
	var that = this;
	this.idModulo = (args.idModulo)?args.idModulo:'';
	this.resize_width = (args.resize_width)?args.resize_width:600;
	this.resize_height = (args.resize_height)?args.resize_height:600;
	this.isMultiple = (args.isMultiple)?true:false;
	this.callback = args.callback;
	this.execCallback = false;
	//console.log('!this.callback = '+(!this.callback))
	if(!this.callback){
		this.callback = function(fileName){
			var idthumb = $('#cntUplds_'+that.idModulo).attr('data-idthumb');
			$('#'+idthumb).attr('src','application/upload/'+fileName);
		}
	}
	
	if(this.idModulo){
		var uploader = new plupload.Uploader({
			runtimes : 'html5',
			browse_button : 'pickfiles_'+that.idModulo,
			container: 'cntUplds_'+that.idModulo,
			max_file_size : '10mb',
			resize : {width : that.resize_width, height : that.resize_height, quality : 100},
			url : base_url + 'admin/pluploader/',
			multi_selection:that.isMultiple,
			filters : [
				{title : "Image files", extensions : "jpg,gif,png"}
			]
		});
		uploader.bind('Init', function(up, params) {
			$("#pickfiles_"+that.idModulo).fadeIn();
			$('#clearfiles_'+that.idModulo).click(function(event) {
				event.stopPropagation();
				if(confirm('Este comando poderá cancelar algum\n upload que não foi completado.\n Deseja continuar"?')){
					$("#filelist_"+that.idModulo).html('');
				}
			});
		});
		uploader.bind('FilesAdded', function(up, files) {
			if(uploader.state!=2 & files.length>0){		
				if(that.isMultiple == false){
					$("#filelist_"+that.idModulo).html('');
					//$("#pickfiles_"+that.idModulo).fadeOut();
				}
				for (var i in files) {
					//console.log(that.isMultiple);
					if(that.isMultiple == false){
						$('#filelist_'+that.idModulo).append('<span class="delFiles" id="'+files[i].id+'">'+files[i].name+'('+plupload.formatSize(files[i].size)+')<b></b> <a href="javascript:;" onclick="removeFile(\''+files[i].id+'\')">X</a> </span>').append('<input type="hidden" id="'+that.idModulo+'" name="'+that.idModulo+'" value="'+files[i].name+'"/>');
					}else{
						$('#filelist_'+that.idModulo).append('<span class="delFiles" id="'+files[i].id+'">'+files[i].name+'('+plupload.formatSize(files[i].size)+')<b></b> <a href="javascript:;" onclick="removeFile(\''+files[i].id+'\')">X</a> </span>');
					}
				}		
				$('#uploadfiles_'+that.idModulo).click(function(event) {
					event.stopPropagation();
					uploader.start();
					$('#trocar_'+that.idModulo).fadeIn();
					return false;
				}).fadeIn();
				$('#trocar_'+that.idModulo).click(function(event) {
					event.stopPropagation();
					$("#filelist_"+that.idModulo).html('');
					$('#uploadfiles_'+that.idModulo+', #trocar_'+that.idModulo).fadeOut();
					$('#pickfiles_'+that.idModulo).fadeIn();
				}).fadeIn();

			}
		});
		uploader.bind('UploadProgress', function(up, file) {
			$("#"+file.id+" b").html(file.percent + "%");			
		});
		uploader.bind('FileUploaded', function(up, file, info) {			
			var php = JSON.parse(info.response);    
			//console.log('FileUploaded');
			that.execCallback = true;
			that.callback(php.result);
		});
		return uploader;
	}		
}