<?php
/**
 * Author:  Yejia
 * Email:   ye91@foxmail.com
 */

namespace alphathinkyyl\WeWorkApi\api\struct\CheckinOption;

use alphathinkyyl\WeWorkApi\utils\Utils;

class SpeOffDays
{
    public $timestamp = null;   // uint
    public $notes = null;       // string
    public $checkintime = null; // CheckinTime array

    /**
     * @param $arr
     *
     * @return SpeOffDays
     */
    public static function ParseFromArray($arr)
    {
        $info = new SpeOffDays();

        $info->timestamp = Utils::arrayGet($arr, "timestamp");
        $info->notes = Utils::arrayGet($arr, "notes");

        foreach ($arr["checkintime"] as $item) {
            $info->checkintime[] = CheckinTime::ParseFromArray($item);
        }

        return $info;
    }
}