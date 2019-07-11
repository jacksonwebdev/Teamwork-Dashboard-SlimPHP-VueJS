<?php

namespace App\Controller\Utility;

class TimeController
{
    /**
     * Count Days
     *
     * @param Int $year
     * @param Int $month
     * @param Array $ignore
     * @return integer
     */
    public static function countDays( Int $year = 2019, Int $month = 1, Array $ignore = array( 0, 6 ) ) {
        $count = 0;
        $counter = mktime(0, 0, 0, $month, 1, $year);
        while (date("n", $counter) == $month) {
            if (in_array(date("w", $counter), $ignore) == false) {
                $count++;
            }
            $counter = strtotime("+1 day", $counter);
        }
        return $count;
    }
    
    /**
     * decimalHours
     *
     * @param Time $time
     * @return string
     */
    public static function decimalHours( Time $time )
    {
        $hms = explode(":", $time);
        $decimal_time = ($hms[0] + ($hms[1]/60));
        return $decimal_time;
    }

}
