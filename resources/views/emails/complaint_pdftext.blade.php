{{-- @ component('mail::message') --}}

<html>

<head>
	<meta content="text/html; charset=UTF-8" http-equiv="content-type">
	<style type="text/css">
		@import url('https://themes.googleusercontent.com/fonts/css?kit=fpjTOVmNbO4Lz34iLyptLUXza5VhXqVC6o75Eld_V98');ul.lst-kix_5paxq7ds8o8c-0{list-style-type:none}ol.lst-kix_ib9b65tes8j2-7.start{counter-reset:lst-ctn-kix_ib9b65tes8j2-7 0}ul.lst-kix_5paxq7ds8o8c-1{list-style-type:none}ul.lst-kix_5paxq7ds8o8c-2{list-style-type:none}ol.lst-kix_ib9b65tes8j2-8{list-style-type:none}ul.lst-kix_5paxq7ds8o8c-3{list-style-type:none}ul.lst-kix_5paxq7ds8o8c-4{list-style-type:none}ol.lst-kix_ib9b65tes8j2-0.start{counter-reset:lst-ctn-kix_ib9b65tes8j2-0 0}ul.lst-kix_5paxq7ds8o8c-5{list-style-type:none}ul.lst-kix_5paxq7ds8o8c-6{list-style-type:none}.lst-kix_ib9b65tes8j2-0>li{counter-increment:lst-ctn-kix_ib9b65tes8j2-0}ul.lst-kix_5paxq7ds8o8c-7{list-style-type:none}.lst-kix_y3qaw3fkvyc2-3>li:before{content:"\0025cf  "}.lst-kix_y3qaw3fkvyc2-4>li:before{content:"\0025cb  "}.lst-kix_ib9b65tes8j2-6>li{counter-increment:lst-ctn-kix_ib9b65tes8j2-6}.lst-kix_ib9b65tes8j2-6>li:before{content:"" counter(lst-ctn-kix_ib9b65tes8j2-6,decimal) ". "}.lst-kix_ib9b65tes8j2-5>li:before{content:"" counter(lst-ctn-kix_ib9b65tes8j2-5,lower-roman) ". "}ul.lst-kix_5paxq7ds8o8c-8{list-style-type:none}.lst-kix_y3qaw3fkvyc2-2>li:before{content:"\0025a0  "}.lst-kix_y3qaw3fkvyc2-1>li:before{content:"\0025cb  "}.lst-kix_ib9b65tes8j2-8>li:before{content:"" counter(lst-ctn-kix_ib9b65tes8j2-8,lower-roman) ". "}.lst-kix_y3qaw3fkvyc2-0>li:before{content:"\0025cf  "}.lst-kix_ib9b65tes8j2-7>li{counter-increment:lst-ctn-kix_ib9b65tes8j2-7}.lst-kix_ib9b65tes8j2-7>li:before{content:"" counter(lst-ctn-kix_ib9b65tes8j2-7,lower-latin) ". "}.lst-kix_5paxq7ds8o8c-6>li:before{content:"-  "}.lst-kix_5paxq7ds8o8c-5>li:before{content:"-  "}ol.lst-kix_ib9b65tes8j2-1.start{counter-reset:lst-ctn-kix_ib9b65tes8j2-1 0}.lst-kix_5paxq7ds8o8c-4>li:before{content:"-  "}.lst-kix_ib9b65tes8j2-1>li:before{content:"" counter(lst-ctn-kix_ib9b65tes8j2-1,lower-latin) ". "}.lst-kix_5paxq7ds8o8c-2>li:before{content:"-  "}.lst-kix_ib9b65tes8j2-2>li:before{content:"" counter(lst-ctn-kix_ib9b65tes8j2-2,lower-roman) ". "}.lst-kix_5paxq7ds8o8c-1>li:before{content:"-  "}.lst-kix_5paxq7ds8o8c-3>li:before{content:"-  "}.lst-kix_idisgcgjreyr-0>li:before{content:"\0025cf  "}.lst-kix_ib9b65tes8j2-4>li:before{content:"" counter(lst-ctn-kix_ib9b65tes8j2-4,lower-latin) ". "}ul.lst-kix_idisgcgjreyr-0{list-style-type:none}.lst-kix_ib9b65tes8j2-3>li:before{content:"" counter(lst-ctn-kix_ib9b65tes8j2-3,decimal) ". "}ol.lst-kix_ib9b65tes8j2-8.start{counter-reset:lst-ctn-kix_ib9b65tes8j2-8 0}.lst-kix_idisgcgjreyr-1>li:before{content:"\0025cb  "}ul.lst-kix_idisgcgjreyr-2{list-style-type:none}.lst-kix_ib9b65tes8j2-5>li{counter-increment:lst-ctn-kix_ib9b65tes8j2-5}ul.lst-kix_idisgcgjreyr-1{list-style-type:none}ol.lst-kix_ib9b65tes8j2-4.start{counter-reset:lst-ctn-kix_ib9b65tes8j2-4 0}.lst-kix_ib9b65tes8j2-8>li{counter-increment:lst-ctn-kix_ib9b65tes8j2-8}ul.lst-kix_idisgcgjreyr-4{list-style-type:none}.lst-kix_idisgcgjreyr-2>li:before{content:"\0025a0  "}ul.lst-kix_idisgcgjreyr-3{list-style-type:none}.lst-kix_idisgcgjreyr-4>li:before{content:"\0025cb  "}.lst-kix_5paxq7ds8o8c-0>li:before{content:"-  "}ul.lst-kix_idisgcgjreyr-6{list-style-type:none}ul.lst-kix_idisgcgjreyr-5{list-style-type:none}ul.lst-kix_idisgcgjreyr-8{list-style-type:none}.lst-kix_idisgcgjreyr-3>li:before{content:"\0025cf  "}ul.lst-kix_idisgcgjreyr-7{list-style-type:none}ol.lst-kix_ib9b65tes8j2-2{list-style-type:none}ol.lst-kix_ib9b65tes8j2-3{list-style-type:none}ol.lst-kix_ib9b65tes8j2-0{list-style-type:none}.lst-kix_idisgcgjreyr-6>li:before{content:"\0025cf  "}ol.lst-kix_ib9b65tes8j2-1{list-style-type:none}.lst-kix_ib9b65tes8j2-0>li:before{content:"" counter(lst-ctn-kix_ib9b65tes8j2-0,decimal) ". "}ol.lst-kix_ib9b65tes8j2-6{list-style-type:none}ol.lst-kix_ib9b65tes8j2-7{list-style-type:none}.lst-kix_ib9b65tes8j2-2>li{counter-increment:lst-ctn-kix_ib9b65tes8j2-2}ol.lst-kix_ib9b65tes8j2-4{list-style-type:none}.lst-kix_idisgcgjreyr-5>li:before{content:"\0025a0  "}ol.lst-kix_ib9b65tes8j2-5{list-style-type:none}.lst-kix_idisgcgjreyr-7>li:before{content:"\0025cb  "}ul.lst-kix_y3qaw3fkvyc2-7{list-style-type:none}ul.lst-kix_y3qaw3fkvyc2-6{list-style-type:none}ul.lst-kix_y3qaw3fkvyc2-5{list-style-type:none}ul.lst-kix_y3qaw3fkvyc2-4{list-style-type:none}.lst-kix_idisgcgjreyr-8>li:before{content:"\0025a0  "}.lst-kix_ib9b65tes8j2-3>li{counter-increment:lst-ctn-kix_ib9b65tes8j2-3}ul.lst-kix_y3qaw3fkvyc2-8{list-style-type:none}ol.lst-kix_ib9b65tes8j2-5.start{counter-reset:lst-ctn-kix_ib9b65tes8j2-5 0}ol.lst-kix_ib9b65tes8j2-2.start{counter-reset:lst-ctn-kix_ib9b65tes8j2-2 0}.lst-kix_5paxq7ds8o8c-7>li:before{content:"-  "}.lst-kix_5paxq7ds8o8c-8>li:before{content:"-  "}.lst-kix_ib9b65tes8j2-4>li{counter-increment:lst-ctn-kix_ib9b65tes8j2-4}.lst-kix_ib9b65tes8j2-1>li{counter-increment:lst-ctn-kix_ib9b65tes8j2-1}.lst-kix_y3qaw3fkvyc2-6>li:before{content:"\0025cf  "}.lst-kix_y3qaw3fkvyc2-5>li:before{content:"\0025a0  "}.lst-kix_y3qaw3fkvyc2-7>li:before{content:"\0025cb  "}ul.lst-kix_y3qaw3fkvyc2-3{list-style-type:none}ul.lst-kix_y3qaw3fkvyc2-2{list-style-type:none}ol.lst-kix_ib9b65tes8j2-3.start{counter-reset:lst-ctn-kix_ib9b65tes8j2-3 0}ul.lst-kix_y3qaw3fkvyc2-1{list-style-type:none}ul.lst-kix_y3qaw3fkvyc2-0{list-style-type:none}.lst-kix_y3qaw3fkvyc2-8>li:before{content:"\0025a0  "}ol.lst-kix_ib9b65tes8j2-6.start{counter-reset:lst-ctn-kix_ib9b65tes8j2-6 0}ol{margin:0;padding:0}table td,table th{padding:0}.c11{color:#000000;font-weight:400;text-decoration:none;vertical-align:baseline;font-size:9.1pt;font-family:"Calibri";font-style:normal}.c0{background-color:#ffffff;color:#000000;font-weight:400;text-decoration:none;vertical-align:baseline;font-size:9.1pt;font-family:"Calibri";font-style:normal}.c9{background-color:#ffffff;color:#000000;font-weight:400;text-decoration:none;vertical-align:baseline;font-size:9.5pt;font-family:"Calibri";font-style:normal}.c1{padding-top:0pt;padding-bottom:0pt;line-height:1.15;orphans:2;widows:2;text-align:right}.c8{padding-top:0pt;padding-bottom:0pt;line-height:1.15;orphans:2;widows:2;text-align:left}.c3{padding-top:0pt;padding-bottom:0pt;line-height:1.15;orphans:2;widows:2;text-align:justify}.c6{padding-top:0pt;padding-bottom:0pt;line-height:1.15;orphans:2;widows:2;text-align:center}.c12{color:#000000;text-decoration:none;vertical-align:baseline;font-size:9.1pt;font-style:normal}.c19{color:#000000;text-decoration:none;vertical-align:baseline;font-style:normal}.c17{font-size:9.5pt;font-family:"Calibri";font-weight:400}.c5{background-color:#ffffff;font-size:9.5pt;font-family:"Calibri";font-weight:700}.c4{background-color:#ffffff;font-family:"Calibri";color:#20124d;font-weight:400}.c14{-webkit-text-decoration-skip:none;text-decoration:underline;text-decoration-skip-ink:none}.c22{background-color:#ffffff;max-width:499.5pt;padding:27pt 40.5pt 22.5pt 72pt}.c10{background-color:#ffffff;font-family:"Calibri";font-weight:700}.c13{background-color:#ffffff;font-family:"Calibri";font-weight:400}.c15{font-weight:400;font-family:"Arial"}.c16{color:#1155cc;font-size:9.5pt}.c7{color:inherit;text-decoration:inherit}.c21{color:#20124d}.c2{height:9.1pt}.c18{color:#1155cc}.c20{font-size:9.5pt}.title{padding-top:0pt;color:#000000;font-size:26pt;padding-bottom:3pt;font-family:"Arial";line-height:1.15;page-break-after:avoid;orphans:2;widows:2;text-align:left}.subtitle{padding-top:0pt;color:#666666;font-size:15pt;padding-bottom:16pt;font-family:"Arial";line-height:1.15;page-break-after:avoid;orphans:2;widows:2;text-align:left}li{color:#000000;font-size:9.1pt;font-family:"Arial"}p{margin:0;color:#000000;font-size:9.1pt;font-family:"Arial"}h1{padding-top:20pt;color:#000000;font-size:20pt;padding-bottom:6pt;font-family:"Arial";line-height:1.15;page-break-after:avoid;orphans:2;widows:2;text-align:left}h2{padding-top:18pt;color:#000000;font-size:16pt;padding-bottom:6pt;font-family:"Arial";line-height:1.15;page-break-after:avoid;orphans:2;widows:2;text-align:left}h3{padding-top:16pt;color:#434343;font-size:14pt;padding-bottom:4pt;font-family:"Arial";line-height:1.15;page-break-after:avoid;orphans:2;widows:2;text-align:left}h4{padding-top:14pt;color:#666666;font-size:12pt;padding-bottom:4pt;font-family:"Arial";line-height:1.15;page-break-after:avoid;orphans:2;widows:2;text-align:left}h5{padding-top:12pt;color:#666666;font-size:9.1pt;padding-bottom:4pt;font-family:"Arial";line-height:1.15;page-break-after:avoid;orphans:2;widows:2;text-align:left}h6{padding-top:12pt;color:#666666;font-size:9.1pt;padding-bottom:4pt;font-family:"Arial";line-height:1.15;page-break-after:avoid;font-style:italic;orphans:2;widows:2;text-align:left}
	</style>
</head>

<body class="c22">
	<hr>
	<p class="c6 c2"><span class="c0"></span></p>
	<p class="c6"><span style="overflow: hidden; display: inline-block; margin: 0.00px 0.00px; border: 0.00px solid #000000; transform: rotate(0.00rad) translateZ(0px); -webkit-transform: rotate(0.00rad) translateZ(0px); width: 368.00px; height: 40.00px;"><img alt="" src="http://{{ Request::getHost() }}/images/ngo-logo.png" width="368" height="40" style="width: 368.00px; height: 40.00px; margin-left: 0.00px; margin-top: 0.00px; transform: rotate(0.00rad) translateZ(0px); -webkit-transform: rotate(0.00rad) translateZ(0px);" title=""></span></p>
	<p class="c6">
		<span class="c10 c21">
			{{ $a_from[0]['s_title'] }}
		</span>
		<span class="c4">&nbsp;</span>
		<span class="c13"><br></span>
		<span class="c10">{{ $a_from[0]['s_legal'] }}, </span>
		<span class="c14 c10 c18"><a class="c7" href="mailto:{{ $a_from[0]['s_email'] }}">{{ $a_from[0]['s_email'] }}</a></span><span class="c12 c10">, {{ $a_from[0]['s_phone'] }}</span>
	</p>
	<hr>
	<p class="c6 c2"><span class="c12 c10"></span></p>

	@for ($i = 0; $i < count($a_to); $i++)
	<p class="c1">
		<span class="c5 c19">
			{{ $a_to[$i]['s_title'] }}
		</span>
	</p>
	<p class="c1">
		<span class="c9">
			{{ $a_to[$i]['s_address'] }}
		</span>
	</p>
	<p class="c1">
		@for ($j = 0; $j < count($a_to[$i]['a_email']); $j++)
		<span class="c14 c13 c16">
			<a class="c7" href="mailto:{{ $a_to[$i]['a_email'][$j] }}">{{ $a_to[$i]['a_email'][$j] }}</a></span>@if($j+1 < count($a_to[$i]['a_email']))<span class="c13 c20">, </span>@endif
		@endfor
	</p>
	<p class="c1 c2"><span class="c9"></span></p>
	@endfor

	<p class="c1">
		<span class="c5">
			Від: {{ $a_from[0]['a_position'] }}
			<br>
			{{ $a_from[0]['a_name'] }}
		</span>
		<span class="c13 c20">
			<br>
			{{ $a_from[0]['s_address'] }}
			<br>
		</span>
		<span class="c14 c13 c16">
			<a class="c7" href="mailto:{{ $a_from[0]['s_email'] }}">
				{{ $a_from[0]['s_email'] }}
			</a>
		</span>
			<span class="c9"></span>
	</p>
	<p class="c1 c2"><span class="c11"></span></p>
	<p class="c1"><span class="c17">{!! $s_date !!}</span></p>
	<p class="c1 c2"><span class="c11"></span></p>
	<p class="c6"><span class="c12 c10">ЗАЯВА</span></p>
	<p class="c2 c6"><span class="c10 c12"></span></p>
	<p class="c3">
		<span class="c0">
			В порядку ст. 40 Конституції України, ст. 21 Закону України «Про громадські об'єднання», Закону України «Про звернення громадян» звертаємось до вас з даною заявою (зверненням) про наступне.
		</span>
	</p>
	<p class="c3 c2"><span class="c0"></span></p>
	<p class="c3">
		<span class="c0">
			ГО «Дебати заради змін» відносить до своїх завдань розбудову громадянського суспільства, підвищення рівня захисту та реалізації прав людини в Україні. Досягнення цих цілей неможливе без рівного включення усіх членів українського суспільства до соціально-політичного життя, у тому числі без надання особам з інвалідністю можливості вести незалежний спосіб життя й усебічно брати участь у всіх аспектах соціально-політичного життя.
		</span>
	</p>
	<p class="c3 c2"><span class="c0"></span></p>
	<p class="c3">
		<span class="c0">
			У зв’язку з цим, наша організація реалізовує проект «ПРОВІДНИК: інтерактивна мапа для людей з інвалідністю» («ПРОВІДНИК») у партнерстві з Програмою Східного партнерства Європейського Союзу.
		</span>
	</p>
	<p class="c3 c2"><span class="c0"></span></p>
	<p class="c3">
		<span class="c10">
			Під час реалізації проекту «ПРОВІДНИК» нам стало відомо про наступні порушення ст. 9 Конвенції ООН про права осіб з інвалідністю, ст. ст. 4, 26-35 Закону України «Про основи соціальної захищеності осіб з інвалідністю в Україні»,  ДБН В.2.2-40:2018 «Інклюзивність будівель і споруд»,&nbsp;
		</span>
		<span class="c10 c14">
			у зв’язку з відсутністю належної інклюзивної інфраструктури (доступної для людей з інвалідністю) за наступною адресою</span><span class="c12 c10">:</span><span class="c11">.
		</span>
	</p>
	<p class="c3 c2"><span class="c0"></span></p>
	<p class="c3">
		<span class="c11">
			{{ $s_info }}.@if (!empty($s_issues))<span> Проблеми інфраструктури: {{ $s_issues }}.</span>@endif
		</span>
	</p>
	<p class="c3 c2"><span class="c0"></span></p>
	<p class="c3">
		<span class="c0">
			Вказаний стан інфраструктури призводить до порушення прав людей з інвалідністю та обмеженою мобільністю. Звертаємо окрему увагу, що створення реального безбар’єрного простору для людей з інвалідністю та інших маломобільних груп є однією із першочергових вимог у зв’язку з ратифікацією Україною Конвенції ООН про права осіб з інвалідністю та Угоди про Асоціацію з ЄС.
		</span>
	</p>
	<p class="c3 c2"><span class="c0"></span></p>
	<p class="c3">
		<span class="c12 c10">
			З огляду на вищевикладене, у межах наданої вам компетенції, просимо вжити відповідні заходи реагування для усунення вказаного вище порушення.
		</span>
	</p>
	<p class="c2 c8"><span class="c0"></span></p>
	<p class="c3">
		<span class="c13">
			Відповідь про результати розгляду даного звернення просимо надати у встановлені законом строки за наступними адресами: &nbsp;на електронну пошту&nbsp;
		</span>
		<span class="c14 c13 c18"><a class="c7" href="mailto:{{ $a_from[0]['s_email'] }}">{{ $a_from[0]['s_email'] }}</a></span>
		<span class="c13">
			&nbsp;та поштою на адресу {{ $a_from[0]['s_address'] }}.
		</span>
	</p>
	<table>
		<tr>
			<td>
				<p class="c8"><span class="c0">Заздалегідь вдячні за вашу відподь!</span></p>
				<p class="c8 c2"><span class="c11"></span><br /></p>
				<p class="c8 c2"><span class="c12 c15"></span><br /></p>
				<p class="c8"><span class="c0">З повагою,</span></p>
				<p class="c8 c2"><span class="c0"></span><br /></p>
				<p class="c8"><span class="c0">{{ $a_from[0]['a_name_who'] }}</span></p>
				<p class="c8"><span class="c0">{{ $a_from[0]['a_position_who'] }}</span></p>
			</td>
			<td style="padding-left: 50px;">
				<span style="overflow: hidden; display: inline-block; margin: 0.00px 0.00px; border: 0.00px solid #000000; transform: rotate(0.00rad) translateZ(0px); -webkit-transform: rotate(0.00rad) translateZ(0px); width: 148.00px; height: 128.00px;">
					<img alt="" src="http://{{ Request::getHost() }}/images/ngo-stamp.png" width="148" height="128" style="width: 148.00px; height: 128.00px; margin-top: 0.00px; transform: rotate(0.00rad) translateZ(0px); -webkit-transform: rotate(0.00rad) translateZ(0px);" title="">
				</span>
			</td>
		</tr>
	</table>
	<p class="c8 c2"><span class="c12 c15"></span></p>
</body>

</html>

{{-- @endcomponent--}}