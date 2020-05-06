{
	data: '{!! $s_name !!}',
	render: function (data, type, row) {
		let status = Number(data) ? '{!! trans('user/crud.table.enabled') !!}' : '{!! trans('user/crud.table.disabled') !!}',
			className = Number(data) ? 'success' : 'secondary';
		return `<span class="badge badge-${className}">${status}</span>`;
	},
	className: 'text-center'
},
