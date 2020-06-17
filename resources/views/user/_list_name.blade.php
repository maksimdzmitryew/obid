{
	data: '{!! $s_name !!}',
	sortable: false,
	render: function(data, type, row)
	{
		s_name	= '';
		s_id	= '';
		if (typeof row.user_name !== 'undefined')
		{
			s_name	= row.user_name;
		}
		else
		{
			if (typeof row.first_name !== 'undefined')
			{
				s_name	+= row.first_name;
			}
			if (typeof row.last_name !== 'undefined')
			{
				s_name	+= ' ' + row.last_name;
			}
		}

		if (typeof row.user_id !== 'undefined')
		{
			s_id	= row.user_id;
		}

		if (s_name != '' && s_name != ' ' && s_id != '')
		{
			s_link = `<a href="{!! route('admin.user.form', [':id']) !!}" class="btn btn-sm btn-primary  tooltip-helper" data-toggle="tooltip" data-placement="top" title="{!! trans('user/crud.button.edit.label') !!} {!! trans('user/user.names.btn_edit') !!}" data-trigger="hover">:name</a>`.replace(':name', s_name).replace(':id', s_id);
		}
		else
		{
			s_link = s_name;
		}
		return s_link;
	}
},
