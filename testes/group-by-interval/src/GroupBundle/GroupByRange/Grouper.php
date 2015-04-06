<?php
/**
 * Created by PhpStorm.
 * User: bionicmaster
 * Date: 4/6/15
 * Time: 6:49 AM
 */

namespace GroupBundle\GroupByRange;


class Grouper {

    /** @var int $range Rango de los agrupamientos */
    protected $range = 10;

    public function group(Array $array)
    {
        $groups   = [];
        $negative = [];
        $positive = [];
        $length   = count($array);
        if($length > 0 && $this->range > 0)
        {
            $bottom   = $array[0];
            $top      = $array[$length - 1];
            $min      = floor($bottom / $this->range) * $this->range;
            $max      = ceil($top / $this->range) * $this->range;
            $actual   = $min;
            $next     = $min + $this->range;
            for ($i = 0; $i < $length; $i++)
            {
                while (array_key_exists($i, $array))
                {
                    if ($array[$i] <= $next) {
                        $groups[$actual][] = $array[$i];
                        unset($array[$i]);
                    }
                    else
                    {
                        $next += $this->range;
                        $actual += $this->range;
                    }
                }

            }
        }
        return $groups;
    }

    /**
     * @return int
     */
    public function getRange()
    {
        return $this->range;
    }

    /**
     * @param int $range
     */
    public function setRange($range)
    {
        $this->range = (int) $range;
    }


}