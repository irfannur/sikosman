<?php

namespace app\helpers;

use DateTime;

class DateUtils {

    public static function dateOnly($date, $format = 'Y-m-d') {
        return date($format, strtotime($date));
    }

    public static function dateAddDay($date, $add, $format = 'Y-m-d H:i:s') {
        $date = date($format, strtotime($date));
        $date = DateTime::createFromFormat($format, "$date");
        $date->modify("+$add day");
        return $date->format($format);
    }

}
