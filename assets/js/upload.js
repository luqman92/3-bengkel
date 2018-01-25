$(document).ready(function(){
	$('form').on('submit', function(event){
		event.preventDefault();

		var formData  = new formData($('form')[0]);

		/*$.ajax({
			xhr : function(){
				var xhr =  new window.XMLHttpRequest();

				xhr.upload.addEventListener('progress', function(e){

					if(e.lengthComputable){

						console.log('Bytes Loaded: ' + e.loaded);
						console.log('Total size: ' + e.total);
						console.log('Percentage Uploaded: ' + (e.loaded / e.total)

					}
				});

				return xhr;
			},*/
			type : 'POST',
			url : 'admin/act_addvod',
			data : formData,
			proccessData : false,
			contentType : false,
			success : function(){
				alert('file upoaded!');
			}
		});
	});
});