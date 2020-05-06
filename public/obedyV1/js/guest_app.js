$(function() {
	$('input[type="tel"]').mask('+38(099)999-99-99');

	function calc_subfilters_height() {
		if($(window).width()>1180) {
			$('#mib_content .subfilters .scroll_wrap').outerHeight(($('#mib_content').outerHeight() - $('#mib_content .filters').outerHeight() - 20));
			$('#mib_content .reviews_wrap').outerHeight($('#mib_content').outerHeight() -  $('#mib_content .choosen_filter').outerHeight());
			$('#mib_content .new_place_wrap').outerHeight($('#mib_content').outerHeight() + 30);
		} else {
			$('#mib_content .subfilters .scroll_wrap').outerHeight('auto');
			$('#mib_content .reviews_wrap').outerHeight('auto');
			$('#mib_content .new_place_wrap').outerHeight('auto');
		}
	}
	calc_subfilters_height();
	$( window ).resize(function() {
		calc_subfilters_height();
	});
	$('header .open_menu').click(function(){
		$('header nav').toggleClass('opened');
	});
	$('footer .open_filter_btn').click(function(){
		$(this).toggleClass('active');
		if($(this).hasClass('active')){
			$('#mib_content').addClass('opened');
		} else {
			$('#mib_content').removeClass('opened');
		}
	});
	$('.openpass').click(function(){
		var inp = $(this).parent().find('input');
		inp.toggleClass('psssview');
		if(inp.hasClass('psssview')){
			inp.attr('type','text');
		} else {
			inp.attr('type','password');
		}
	});


	$('.rating label').click( function(){
		var l_index = $(this).attr('data-index');
		$('.rating label').each(function() {
			if($(this).attr('data-index') <= l_index) {
				$(this).addClass('active');
			} else {
				$(this).removeClass('active');
			}
		});
	});
	$('.profile .tabs li').click( function(){
		var active = $(this).attr('data-tab');
		$('.profile .tab').removeClass('opened');
		$('#'+active).addClass('opened');
		$('.profile .tabs li').removeClass('active');
		$(this).addClass('active');
	});
/*
	setTimeout(function() {
		$('select').styler();
	}, 100)

	$.extend({
		uploadPreview : function (options) {
			var settings = $.extend({
				input_field: ".image-input",
				preview_box: ".image-preview",
				label_field: ".image-label",
				label_default: "Choose File",
				label_selected: "Change File",
				no_label: false,
				success_callback : null,
			}, options);
			if (window.File && window.FileList && window.FileReader) {
				if (typeof($(settings.input_field)) !== 'undefined' && $(settings.input_field) !== null) {
					$(settings.input_field).change(function() {
						var files = this.files;
						if (files.length > 0) {
							var file = files[0];
							var reader = new FileReader();
							reader.addEventListener("load",function(event) {
								var loadedFile = event.target;
								if (file.type.match('image')) {
									$(settings.preview_box).css("background-image", "url("+loadedFile.result+")");
									$(settings.preview_box).css("background-size", "cover");
									$(settings.preview_box).css("background-position", "center center");
									$(settings.preview_box).css("height", "155px");
									$(settings.preview_box).css("margin-bottom", "15px");
								} else if (file.type.match('audio')) {
									$(settings.preview_box).html("<audio controls><source src='" + loadedFile.result + "' type='" + file.type + "' />Your browser does not support the audio element.</audio>");
								} else {
									alert("This file type is not supported yet.");
								}
							});
							if (settings.no_label == false) {
								$(settings.label_field).html(settings.label_selected);
							}
							reader.readAsDataURL(file);
							if(settings.success_callback) {
								settings.success_callback();
							}
						} else {
							if (settings.no_label == false) {
								$(settings.label_field).html(settings.label_default);
							}
							$(settings.preview_box).attr("style", "");
							$(settings.preview_box + " audio").remove();
						}
					});
				}
			} else {
				alert("You need a browser with file reader support, to use this form properly.");
				return false;
			}
		}
	});

	$.uploadPreview({
		input_field: "#image-upload",   // Default: .image-upload
		preview_box: "#image-preview",  // Default: .image-preview
		label_field: "#image-label",    // Default: .image-label
		label_default: "Choose File",   // Default: Choose File
		label_selected: "Change File",  // Default: Change File
		no_label: false                 // Default: false
	});
*/
});
