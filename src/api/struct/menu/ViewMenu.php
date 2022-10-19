<?php
/**
 * Author:  Yejia
 * Email:   ye91@foxmail.com
 */

namespace alphathinkyyl\WeWorkApi\api\struct\menu;


use alphathinkyyl\WeWorkApi\utils\Utils;

class viewMenu
{
    public $type = "view";
    public $name = null; // string
    public $url = null;  // string

    /**
     * viewMenu constructor.
     *
     * @param null $name
     * @param null $url
     */
    public function __construct($name = null, $url = null)
    {
        $this->name = $name;
        $this->url = $url;
    }

    /**
     * @param $arr
     *
     * @return viewMenu
     */
    public static function Array2Menu($arr)
    {
        $menu = new viewMenu();

        $menu->type = "view";
        $menu->name = Utils::arrayGet($arr, "name");
        $menu->url = Utils::arrayGet($arr, "url");

        return $menu;
    }
}