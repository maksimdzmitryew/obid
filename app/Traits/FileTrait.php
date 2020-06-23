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
#dd($a_file_data);
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
				'i_source_size'	=> $a_file_data['download_content_length'],
				'i_temp_size'	=> filesize($f_temp_image),
				'i_http_code'	=> $i_http_code,
				'i_curl_code'	=> $i_curl_code,
				's_curl_msg'	=> $s_curl_msg,
				];
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