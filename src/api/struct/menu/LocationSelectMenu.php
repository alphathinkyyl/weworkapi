<?php
/**
 * Author:  Yejia
 * Email:   ye91@foxmail.com
 */

namespace alphathinkyyl\WeWorkApi\api\struct\menu;


use alphathinkyyl\WeWorkApi\utils\Utils;

class LocationSelectMenu
{
    public $type = "location_select";
    public $name = null; // string
    public $key = null;  // string

    /**
     * LocationSelectMenu constructor.
     *
     * @param null $name
     * @param null $key
     * @param null $xxmenuArray
     */
    public function __construct($name = null, $key = null, $xxmenuArray = null)
    {
        $this->name = $name;
        $this->key = $key;
    }

    /**
     * @param $arr
     *
     * @return LocationSelectMenu
     */
    public static function Array2Menu($arr)
    {
        $menu = new LocationSelectMenu();

        $menu->type = Utils::arrayGet($arr, "type");
        $menu->name = Utils::arrayGet($arr, "name");
        $menu->key = Utils::arrayGet($arr, "key");

        return $menu;
    }
}