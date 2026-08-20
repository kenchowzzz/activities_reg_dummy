var image = {
	select: {
		setPreview: function(data, previewImgId) {
	        if (data.files && data.files[0]) {
	            var reader = new FileReader();            
	            reader.onload = function (e) {
	                $('#' + previewImgId).attr('src', e.target.result);
	            };
	            
	            reader.readAsDataURL(data.files[0], true);
	        }
		}
	}
};