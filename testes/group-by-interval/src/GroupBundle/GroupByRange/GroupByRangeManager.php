<?php
/**
 * Created by PhpStorm.
 * User: bionicmaster
 * Date: 4/5/15
 * Time: 10:17 PM
 */

namespace GroupBundle\GroupByRange;

use GroupBundle\GroupByRange\Sorter;
use GroupBundle\GroupByRange\Grouper;


class GroupByRangeManager
{

    /**
     * @var \GroupBundle\GroupByRange\Sorter
     */
    protected $sorter;
    /**
     * @var \GroupBundle\GroupByRange\Grouper
     */
    protected $grouper;
    protected $sorted;
    protected $grouped;

    public function __construct(Sorter $sorter, Grouper $grouper)
    {
        $this->sorter = $sorter;
        $this->grouper = $grouper;
    }

    public function isInteger(Array $array)
    {
        return $this->all($array, 'is_int');
    }

    public function all(Array $array, $predicate)
    {
        return array_filter($array, $predicate) === $array;
    }

    public function sort_and_group(Array $array, $range)
    {
        if($this->isInteger($array))
        {
            $this->sorted = $this->sorter->sort($array);
            $this->grouper->setRange($range);
            $this->grouped = $this->grouper->group($this->sorted);
        }
        else
        {
            print_r($array);
            throw new \InvalidArgumentException('No todos los parametros son números enteros');
        }

    }

    /**
     * @return mixed
     */
    public function getSorted()
    {
        return $this->sorted;
    }

    /**
     * @return mixed
     */
    public function getGrouped()
    {
        return $this->grouped;
    }

}