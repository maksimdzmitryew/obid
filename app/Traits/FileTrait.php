<?php

namespace App\Traits;

use Carbon\Carbon;

trait FileTrait
{
	/**
	 * download files that contain texts of JD
	 * @param  String 	$s_url 				remote file link
	 *
	 * @return Array 	temporariry file downloaded, its size matches the remote
	 */
	public static function downloadFile($s_url, $s_prefix = '', $i_id = NULL)
	{
#$f_file_1 = Document::getIntervalSeconds(FALSE);
		$f_temp_image = tempnam(sys_get_temp_dir(), $s_prefix .'_temp-file-');
		set_time_limit(0);
		//This is the file where we save the    information
		$fp = fopen ($f_temp_image, 'w+');
		//Here is the file we are downloading, replace spaces with %20
		$ch = curl_init(str_replace(' ',"%20", $s_url));
		curl_setopt($ch, CURLOPT_TIMEOUT, 600);
		// write curl response to file
		curl_setopt($ch, CURLOPT_FILE, $fp);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
		curl_setopt($ch, CURLOPT_HEADER, FALSE);
		curl_setopt($ch, CURLOPT_FAILONERROR, true);
		#curl_setopt($ch, CURLOPT_ENCODING ,'');
		// get curl response
		$output = curl_exec($ch);
		$i_http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		$i_curl_code = curl_errno($ch);
		$s_curl_msg = curl_error($ch);
		$a_file_data = curl_getinfo($ch);
		curl_close($ch);
		fclose($fp);

		if ($i_http_code != 200) {
			\Log::info( 'downloadFile ('. (!is_null($i_id) ? 'id='.$i_id : '') . '): Error #' . $i_http_code);
			\Log::info( $s_curl_msg );
			\Log::info( $a_file_data['url'] );
		}
#$f_file_2 = Document::getIntervalSeconds(FALSE);
#$f_file_3 = $f_file_2 - $f_file_1;
#echo('File downloaded anew ' . ((int)$f_file_3) . ' seconds' . "<br>\n");
		return [
				's_temp_name'	=> $f_temp_image,
				# download_content_length returns -1
				'i_source_size'	=> $a_file_data['size_download'],
				'i_temp_size'	=> filesize($f_temp_image),
				'i_http_code'	=> $i_http_code,
				'i_curl_code'	=> $i_curl_code,
				's_curl_msg'	=> $s_curl_msg,
				];
	}


	/**
	 * Read file content
	 * @param String	$s_url_read		webpage URL
	 *
	 * @return String					content mdified for correct parsing
	 */
	public static function getFileContent(String $s_url_read) : String
	{
		$a_res		= self::downloadFile($s_url_read, 'provider_');
		$s_content	= '';

#self::writeLog('info', 'http_size='.(int)$a_res['i_source_size'].',tmp_size='.(int)$a_res['i_temp_size']);
#self::writeLog('info', 'http_code='.(int)$a_res['i_http_code'].',curl_code='.(int)$a_res['i_curl_code']);
		if (
			$a_res['i_http_code'] === 200 && $a_res['i_curl_code'] === 0
			&& (int)$a_res['i_source_size'] == (int)$a_res['i_temp_size']
			&& (int)$a_res['i_temp_size'] > 0
			&& file_exists($a_res['s_temp_name'])
			)
		{
			$s_file_path	= $a_res['s_temp_name'];
			$s_content		= file_get_contents($s_file_path);
			$s_meta			= mime_content_type($s_file_path);
			unlink($s_file_path);
		}
		/**
		 *	turn into a single line without line breaks
		 *	parsing works better on single lined’ string
		 */
		$s_content			= str_replace([chr(10), chr(13)], '', $s_content);

		do
		{
			$s_content		= str_replace('  ', ' ', $s_content);
		} while ( mb_strstr($s_content, '  ') );
		$s_content			= str_replace('> <', '><', $s_content);

		if (preg_match('/<meta charset="(.+?)">/', $s_content, $a_matches))
			#$s_content		= iconv($a_matches[1], 'UTF-8//IGNORE', $s_content);
			$s_content		= mb_convert_encoding($s_content, 'UTF-8', $a_matches[1]);

		return $s_content;
	}

	/**
	 * get filesize at remote http location
	 * @param  String 	$s_url 				remote file link
	 *
	 * @return Integer  file size
	 */
	public static function getOnlineFileSize($s_url)
	{
		$i_size = 0;
		$ch = curl_init(str_replace(' ',"%20", $s_url));
		curl_setopt( $ch, CURLOPT_NOBODY, TRUE );
		curl_setopt( $ch, CURLOPT_HEADER, FALSE );
		curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, TRUE );
		curl_setopt( $ch, CURLOPT_RETURNTRANSFER, FALSE );
		curl_exec($ch);
		$i_size = curl_getinfo($ch, CURLINFO_CONTENT_LENGTH_DOWNLOAD);
		curl_close($ch);
		return $i_size;
	}

	/**
	 * get modification time of file at remote http location
	 * @param  String 	$s_url 				remote file link
	 *
	 * @return Integer  file time
	 */
	public static function getOnlineFileTime($s_url)
	{
		$i_size = 0;
		$ch = curl_init(str_replace(' ',"%20", $s_url));
		curl_setopt( $ch, CURLOPT_NOBODY, TRUE );
		curl_setopt( $ch, CURLOPT_HEADER, FALSE );
		curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, TRUE );
		curl_setopt( $ch, CURLOPT_RETURNTRANSFER, FALSE );

		curl_setopt($ch, CURLOPT_FILETIME, true);

		curl_exec($ch);
		$i_time = curl_getinfo($ch, CURLINFO_FILETIME);
		curl_close($ch);
		return $i_time;
	}

}
