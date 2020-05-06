/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId]) {
/******/ 			return installedModules[moduleId].exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, {
/******/ 				configurable: false,
/******/ 				enumerable: true,
/******/ 				get: getter
/******/ 			});
/******/ 		}
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "/";
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 6);
/******/ })
/************************************************************************/
/******/ ({

/***/ 6:
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(7);


/***/ }),

/***/ 7:
/***/ (function(module, exports) {

$(document).ready(function () {

	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	});

	$('body').tooltip({
		selector: '.tooltip-helper'
	});
	//$('.tooltip-helper').tooltip({
		//trigger: $(this).data('trigger')
	//});

	// if bootstrap_multiselect is loaded
	if (typeof $.fn.multiselect != 'undefined')
		$('.multi-select').multiselect();

	Noty.overrideDefaults({
		layout: 'topRight'
	});

	window.notify = function (message) {
		var type = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : 'success';
		var timeout = arguments[2];


		var class_name = ' alert alert-success bg-success alert-styled-left p-0';

		if (type === 'success') {
			class_name = ' alert alert-success bg-success alert-styled-left p-0';
		} else if (type === 'info') {
			class_name = ' alert alert-info bg-info alert-styled-left p-0';
		} else if (type === 'primary') {
			class_name = ' alert alert-primary bg-info alert-styled-primary p-0';
		} else if (type === 'warning') {
			class_name = ' alert alert-warning bg-warning alert-styled-left p-0';
		} else if (type === 'danger') {
			class_name = ' alert alert-danger bg-danger alert-styled-left p-0';
		}

		var noty = new Noty({
			theme: class_name,
			text: message,
			type: type,
			timeout: timeout || 3000
		});

		noty.show();

		return noty;
	};

	$('.switcher').bootstrapSwitch();

});

/***/ })

/******/ });
