if (typeof routes == 'undefined')
{
	routes		= {
			'file': '{!! route('api.upload.file') !!}',
			'image': '{!! route('api.upload.image') !!}',
		};
}
