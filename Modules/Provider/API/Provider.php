<?php

namespace Modules\Provider\API;

use                                  App\Traits\FileTrait;
use                   Modules\Provider\Database\Provider as Model;

class Provider extends Model
{
	use FileTrait;

	public $translationModel = '\Modules\Provider\Database\ProviderTranslation';

	/**
	 * Parse provider’s web-page for updates in menu
	 * @param Request	$request		Data from request
	 *
	 * @return Response	json instance of
	 */
	public static function parse()
	{
		$s_url_read	= 'http://obed.in.ua/menu/ponedelnik/index.php';
		$i_id		= 0;
		$a_res		= self::downloadFile(
								$s_url_read,
								'provider_',
								$i_id
							);

#self::writeLog('info', 'http_size='.(int)$a_res['i_source_size'].',tmp_size='.(int)$a_res['i_temp_size']);
#self::writeLog('info', 'http_code='.(int)$a_res['i_http_code'].',curl_code='.(int)$a_res['i_curl_code']);

		if (
			$a_res['i_http_code'] === 200 && $a_res['i_curl_code'] === 0
#							&& (int)$a_res['i_source_size'] == (int)$a_res['i_temp_size']
			&& (int)$a_res['i_temp_size'] > 0
			&& file_exists($a_res['s_temp_name'])
			)
		{
			$s_file_path	= $a_res['s_temp_name'];
			$s_content		= file_get_contents($s_file_path);
			$s_meta			= mime_content_type($s_file_path);
			unlink($s_file_path);
		}
		$s_content = iconv("windows-1251", "UTF-8//IGNORE", $s_content);


		$i_pos = strpos($s_content, '<!DOCTYPE xhtml><html><head></head><body>');
		if ($i_pos === FALSE) return null;
		$s_text = substr($s_content, $i_pos);
		$i_pos = strpos($s_text, '</table></body></html>');
		if ($i_pos === FALSE) return null;
		$i_pos += strlen('</table></body></html>');
		$s_text = trim(substr($s_text, 0, $i_pos), '/');
dump($s_text);


$s_regexps	= '<table widht="1000" align="center">
<tr>
<td align="right">
<h2 class="h2class">Меню на .+?</h2>
</td>
<td align="right">
<h2 class="h2class">
(.*?)</h2>
</td>
</tr>
</table>'
				;
		preg_match_all('~' . $s_regexps . '~iu', $s_content, $a_matches);

$s_date = $a_matches[1][0];

$s_regexps	= '<tr>'
				. '<td class="ttdd1s">(\d+)</td>'
				. '<td class="ttdd2s">(.*?)</td>'
				. '<td class="ttdd3s">(.*?)\s*?\[(\d+)\]</td>'
				. '<td class="ttdd4s".+?value="(.+?)".+?/td>'
				. '<td class="ttdd5s".+?value="(\d+?)".+?/td>'
				. '.*?</tr>'
				;

#		$s_regexps	= '((\b\w{1,}|\b\w{1,}\s{1,}\w{1,}|\b\w{1,}\s{1,}\w{1,}\s{1,}\w{1,})\sУкраїни|цього Кодексу)';
		preg_match_all('~' . $s_regexps . '~iu', $s_text, $a_matches);


#<tr><td class="ttdd1s">1</td><td class="ttdd2s">Салаты</td><td class="ttdd3s">Салат из свежих овощей с маслом растительным (огурец, помидор, масло раст.)  [591]</td><td class="ttdd4s" align="center"><input class="input1" readonly type="text" value="150"></td><td class="ttdd5s" align="center"><input readonly class="input1" type="text" id="c11" value="22" align="center" onkeyup="document.getElementById('result1').innerHTML = (parseFloat(this.value)||0) * (parseFloat(document.getElementById('x11').value)||0); "></td><td class="ttdd6s" align="center"><input style="text-align:center; background: #CCCCCC;" class="mokrec" type="text" size="2" name="1" id="x11" onkeyup="document.getElementById('result1').innerHTML = (parseFloat(this.value)||0) * (parseFloat(document.getElementById('c11').value)||0)"></td><td class="ttdd7s" align="center" style="font-weight:bold;" name="result1" id="result1"></td></tr>
echo '<pre>';
var_dump($a_matches);
echo '</pre>';

for ($i = 0; $i < count($a_matches[0]); $i++)
{
	$i_num		= (int)$a_matches[1][$i];
	$s_type		= $a_matches[2][$i];
	$s_name		= $a_matches[3][$i];
	$i_id		= (int)$a_matches[4][$i];
	$i_weight	= (int)$a_matches[5][$i];
	$i_price	= (int)$a_matches[6][$i];
	$s_format	= 'num=%s type=%s name=%s id=%d weight=%s price=%d<br />';
	$res = sprintf($s_format,
		$i_num,
		$s_type,
		$s_name,
		$i_id,
		$i_weight,
		$i_price
	);
	echo $res;

}
die();




dd($s_text, $s_content);
		die('ok');
	}

}
