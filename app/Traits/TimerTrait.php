<?php

namespace App\Traits;

trait TimerTrait
{
	private static $time_start     =   0;
	private static $time_end       =   0;
	private static $time_limit     =   0;
	private static $time_loop      =   0;
	public  static $time_exec      =   0;
	##
	# time measurements for scripts execution
	private static function microtime_float() : float
	{
		list($usec, $sec) = explode(' ', microtime());
		return ((float)$usec + (float)$sec);
	}
	/**
	 *
	 * @param Integer	$i_min			maximum minutes execution
	 * @param Integer	$i_limit		maximum minutes execution
	 * @param String	$s_title		[optional] title for log
	 *
	 * @return void
	 */
	public static function initInterval(Int $i_min, Int $i_buffer, String $s_title = '') : void
	{
		$i_limit	= self::calculateTimeLimit($i_min, $i_buffer);

		self::startInterval();
		self::setTimeLimit($i_limit);
		self::writeLog('info', sprintf('%-13s time limit=%ds.', 'Started \'' . (!empty($s_title) ? $s_title : self::$_signature).'\'', $i_limit));
	}
	public static function startInterval()
	{
		self::$time_start = self::microtime_float();
	}
	public static function stopInterval()
	{
		self::$time_end = self::microtime_float();
	}
	public static function setTimeLimit($i_time = NULL) : bool
	{
		if ($i_time < 0)
		{
			$i_time = 0;
		}
		return self::$time_limit = $i_time;
	}
	public static function startLoop() : void
	{
		self::$time_loop = self::microtime_float();
	}
	public static function getLoop(int $i_precision = 3) : float
	{
		return number_format((float) (self::microtime_float() - self::$time_loop) , $i_precision, '.', '');
	}
	public static function getTimeLimit() : bool
	{
		return self::$time_limit;
	}
	public static function checkTimeLimitOK($i_time_check = 0) : bool
	{
		return (self::getIntervalSeconds(FALSE) + $i_time_check < self::$time_limit);
	}
	public static function getIntervalSeconds($b_stop = TRUE) : float
	{
		$i_precision = 3;

		// NOT STARTED
		if (empty(self::$time_start))
			return 0;
		if ($b_stop) self::stopInterval();
		// NOT STOPPED

		if (empty(self::$time_end))
			$f_tmp = self::microtime_float();
		else
			$f_tmp = self::$time_end;

		if ($f_tmp - self::$time_start > 1)
			$i_precision = 1;

		$f_time = number_format((float) ($f_tmp - self::$time_start), $i_precision, '.', '');

		if (!empty(self::$time_end))
			self::$time_exec = $f_time;

		return $f_time;
	}
	# /time measurements

	/**
	 *	calculate time limit so it's no longer than required number of minutes and 00 seconds
	 */
	public static function calculateTimeLimit(Int $i_min = 1, Int $i_sleep = 3) : Int
	{
		$i_time_limit		= (60 - $i_sleep - date("s"));
		if ($i_time_limit < 0)
		{
			$i_time_limit = 0;
		}
		else
		{
			$i_time_limit += (($i_min - 1) * 60);
		}
		return $i_time_limit;
	}

	/**
	 * calculate per hour processing speed
	 *
	 * @param  Integer $i_run_time 		time spent processing items
	 * @param  Integer $i_qty 			how many items processed
	 *
	 * @return Integer 					per hour rate
	 */
	public static function getPerHourRate($i_run_time, $i_qty) : int
	{
		$i_res = 0;
		if ($i_run_time > 0)
			$i_res = round($i_qty/$i_run_time*60*60, 0);
		return $i_res;
	}

}
