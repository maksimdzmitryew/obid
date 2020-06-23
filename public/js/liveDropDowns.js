$(document).ready(function ()
{
	initLiveDropdowns();
});

function initLiveDropdowns(){
	var selects = $(".select2");
	selects.each(function (i, item) {
		var select = $(item);
		select.select2({
			minimumResultsForSearch: Infinity,
			placeholder: select.data('placeholder'),
			width: '100%'
		});
	});

	var selects = $(".select2-dropdown");
	selects.each(function (i, item) {
		var select = $(item);
//console.log(select, select[0].id == 'place_id', select[0].baseURI);
		select.select2(settings({
			url: select.data('url'),
			filter: 'title'
		}));
	});
}

function formatRepo (repo) {
	if (repo.loading) return repo.text;
	var markup =
		'<div class="select2-result-repository clearfix">' +
			'<div class="select2-result-repository__meta">' +
				'<div class="select2-result-repository__title">' + repo.title + '</div>' +
			'</div>' +
		'</div>';

	return markup;
}

// Format selection
function formatRepoSelection (repo) {
	return repo.title || repo.text;
}

function settings(params){
	return {
		ajax: {
			url: params.url,
			dataType: 'json',
			delay: 250,
			data: function (settings) {
				let filters = {};

				filters[params.filter] = settings.term

				return {
					filters: filters
				};
			},
			processResults: function (data) {
				return {
					results: data.data,
				};
			},
			cache: true
		},
		escapeMarkup: function (markup) { return markup; },
		minimumInputLength: 0,
		templateResult: formatRepo,
		templateSelection: formatRepoSelection
	}
}
