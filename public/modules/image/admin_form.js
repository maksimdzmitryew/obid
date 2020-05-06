$(document).ready(function(){
/*
    let tpl 		= $('#preview-tpl').html()
                            // TODO refactoring
                            // 1) we need to hide the template's src="${img}" by commenting it output
                            // 2) otherwise there will be 404 not found error in browser logs:
                            // when the page first load into a browser
                            // e.g. GET /poland/$%7Bimage%7D HTTP/1.1 404
                            .replace('<!--', '')
                            .replace('-->', '');
*/
	function options(ext, field){
		let route = routes[field],
			s_single_var = 'b_' + field + '_single'
			;

		if (typeof(window[s_single_var]) == 'undefined')
			return {};

		return {
			url:        route,
			multiple:   (window[s_single_var] == 0),
			fieldName:  field,
			dataType:   'json',
			extraData:  {},
			extFilter:  ext,
			onNewFile: function(id, file){

			    let reader = new FileReader(),
			        container = $(this).closest('.field-body').find('#previews'),
			        _self = $(this),
			        lang = $(this).closest('.field-body').data('lang'),
			        field_name = _self.data('type') === 'image' ? 'image_ids[]' : 'file_id',
			        tpl_type = _self.data('type') === 'image' ? 'image' : 'file';

				if (typeof lang != 'undefined')
				{
					field_name = lang + '[' + field_name + ']';
				}

			    reader.onload = function(e) {

					viewUploadedFile({
						'id': id,
						'tpl': tpl_type,
						'name': file.name,
						'size': (file.size / 1024 / 1024).toFixed(2),
						'field_name': field_name,
						'src': _self.data('type') === 'image' ? e.target.result : _self.data('preview')
					}, id, container);
			    }

			    reader.readAsDataURL(file);
			},
			onUploadProgress: function(id, percent){
			    $('#preview-' + id).find('.file-thumb-progress').removeClass('kv-hidden').find('.progress .progress-bar').css('width', percent + '%');
			},
			onUploadSuccess: function(id, data){
				let file_id = data.file ? data.file.id : data.image.id;
				$('#preview-' + id).attr('data-id', file_id).data('id', file_id);
				$('#preview-' + id).find('.file-thumb-progress').addClass('kv-hidden');
				$('#preview-' + id).html(
					$('#preview-' + id).html()
						.replace(/uploaded_image_id/g, file_id)
						.replace(/disabled="disabled"/g, '')
				);
				if (typeof data.image == 'object')
					$('#preview-' + id).find('img').attr('src', data.image.small_image_url);
				$('#preview-' + id).find('.data input').val(file_id).removeAttr('disabled');
			},
			onUploadError: function(id, message){
			    notify(message, 'danger', 2000);
			},
		}
	}

	$('.file-uploader').dmUploader(options(['pdf', 'doc', 'docx'], 'file'));
	$('.archive-uploader').dmUploader(options(['zip', 'rar', '7z'], 'file'));
	$('.image-uploader').dmUploader(options(['png', 'jpg', 'jpeg', 'gif'], 'image'));
/*
    $('.uniform-uploader').dmUploader({
        url:            routes.image,
        multiple:       false,
        fieldName:      'image',
        dataType:       'json',
        extraData:      {},
        allowedTypes:   'image/*',
        onNewFile: function(id, file){
            let reader = new FileReader();

            reader.onload = function(e) {
            	console.log(e);
                viewUploadedImage({
                    'id': id,
                    'name': file.name,
                    'size': (file.size / 1024 / 1024).toFixed(2),
                    'src': e.target.result,
//                    'field_name': 'image_id',
                }, id);
            }

            reader.readAsDataURL(file);
        },
        onUploadProgress: function(id, percent){
            $('#preview-' + id).find('.file-thumb-progress').removeClass('kv-hidden').find('.progress .progress-bar').css('width', percent + '%');
        },
        onUploadSuccess: function(id, data){
            $('#preview-' + id).find('img').attr('src', data.image.url);

            $('#preview-' + id).find('.file-thumb-progress').addClass('kv-hidden');
            $('#preview-' + id).find('.data input').val(data.image.id).removeAttr('disabled');
            $('#preview-' + id).attr('data-id', data.image.id).data('id', data.image.id);
            $('#preview-' + id).html(
                $('#preview-' + id).html()
                    .replace(/uploaded_image_id/g, data.image.id)
                    .replace(/disabled="disabled"/g, '')
            );

            //$('#preview-' + id).closest('.image_id').find('input.image_copyright').prop('disabled', false);
        },
        onUploadError: function(id, message){
            notify(message, 'danger', 2000);
        },
    });
*/
    $(document).on('click', '.kv-image-remove', (e) => {
        let image = $(e.target).closest('.file-preview-frame');
        deleteImage(image);
    });
/*
    function viewUploadedImage(data, id){
        if (b_image_single)
        {
            $('#previews').html('');
        }
        $.tmpl(tpl, data).appendTo('#previews');

        //$('#previews').html($.tmpl($('#preview-tpl').html(), data));
        //$('#preview-' + id).find('.data input').val(id).removeAttr('disabled');
    }
*/
    function deleteImage(image){
        image.remove();
    }


	$(document).on('click', '.kv-file-remove', (e) => {
		let file = $(e.target).closest('.file-preview-frame');

		deleteFile(file);
	});

	function viewUploadedFile(data, id, container){
		if (data.tpl == 'image' && b_image_single)
		{
			container.html('');
		}

		$.tmpl(
			$('#preview-tpl-' + data['tpl']).html()
				// TODO refactoring
				// 1) we need to hide the template's src="${img}" by commenting it output
				// 2) otherwise there will be 404 not found error in browser logs:
				// when the page first load into a browser
				// e.g. GET /poland/$%7Bimage%7D HTTP/1.1 404
				.replace('<!--', '')
				.replace('-->', '')
				.replace('field_name', data.field_name)
			, data).appendTo(container);
		$('#preview-' + id).find('.data input').val(id).removeAttr('disabled');
	}

	function deleteFile(file){
		file.remove();
	}

});