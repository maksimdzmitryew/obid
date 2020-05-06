{
	data: '{!! $s_name !!}',
	render: function(data){
		return moment(data).format('LLL');
	}
},
