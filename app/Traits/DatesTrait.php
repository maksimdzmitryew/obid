<?php

namespace App\Traits;

use Illuminate\Support\Carbon;

trait DatesTrait
{
    /**
     * Format date to be compliant with js parse date
     * @param  String $s_date date as stored in DB
     * @return String         in parseable format
     */
    private function getDateParsed($s_date)
    {
        return date("r", strtotime($s_date));
    }

    /**
     * Transform dates to specified format
     * @param  Array $dates to parse
     * @return Object          Collection of dates
     */
    private function getDatesFiltered($dates)
    {
        return $this->parseAllDates( $dates->toArray() );
    }

    /**
     * Get first and last dates to compatible format
     * @param  Collection $dates to parse
     * @return Array          Begin and End dates
     */
    private function getDatesRange($dates)
    {
        return  [
                    (new Carbon($dates->first()))->startOfDay(),
                    (new Carbon($dates->last()))->endOfDay()
                ];
    }

    /**
     * Transform items to specified format
     * @param  Array $a_data items to parse
     * @return Object          Collection of dates
     */
    private function parseAllDates($a_data)
    {
        foreach ($a_data as $k => $v)
        {
            $a_data[$k] = $this->getDateParsed($v);
        }
        return collect($a_data);
    }

    /**
     * Transform date to l10n format
     * @return String          date spelled
     */
    public function getSpellDate($s_date)
    {
		$date = new Carbon($s_date);
		$month = trans('month.name.' . $date->format('n'));
		return ($date->format('d') . trans('general.date-after'). ' ' . $month . $date->format(' Y'));
    }

    /**
     * Transform dates to specified format
     * @return Object          Collection of dates
     */
    private function getDatesRangeHoldings()
    {
        return $this->parseAllDates
        (
            [
                $this->festival->holdings()->min('date_from'),
                $this->festival->holdings()->max('date_from'),
            ]
        );
    }

    /**
     * Transform dates to specified format
     * @return Object          Collection of dates
     */
    private function getDatesRangePress()
    {
        return $this->parseAllDates
        (
            [
                $this->festival->presses()->where('published', 1)->min('published_at'),
                $this->festival->presses()->where('published', 1)->max('published_at'),
            ]
        );
    }

}