<?php

namespace Modules\Provider\API;

use                                  App\Traits\FileTrait;
use                   Modules\Provider\Database\Provider as Model;

class Provider extends Model
{
	public $translationModel = '\Modules\Provider\Database\ProviderTranslation';

	/**
	 * Parse provider’s web-page for updates in menu
	 * @param Request	$request		Data from request
	 *
	 * @return Response	json instance of
	 */
	public static function parse()
	{
		$a_res		= self::downloadFile(
								$s_url_read,
								'source_',# . $o_doc->source_id,
								$o_doc->id
							);

#						self::writeLog('info', $s_log, 'loop');

#self::writeLog('info', 'http_size='.(int)$a_res['i_source_size'].',tmp_size='.(int)$a_res['i_temp_size']);
#self::writeLog('info', 'http_code='.(int)$a_res['i_http_code'].',curl_code='.(int)$a_res['i_curl_code']);

		if (
			$a_res['i_http_code'] === 200 && $a_res['i_curl_code'] === 0
#							&& (int)$a_res['i_source_size'] == (int)$a_res['i_temp_size']
			&& (int)$a_res['i_temp_size'] > 0
			&& file_exists($a_res['s_temp_name'])
			)
		{
			$s_file_path = $a_res['s_temp_name'];
			$s_content	= file_get_contents($s_file_path);
			$o_doc->{'s_' . $o_item_params->s_type_source . '_meta'} = mime_content_type($s_file_path);
			unlink($s_file_path);

		die('ok');
	}

}
