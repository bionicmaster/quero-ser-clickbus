<?php
/** Funcion de Ordenamiento por diferentes métodos
 * Created by PhpStorm.
 * User: bionicmaster
 * Date: 4/5/15
 * Time: 10:25 PM
 */

namespace GroupBundle\GroupByRange;


class Sorter {

    /** Funcion de ordenamiento de tipo inserción, bastante rápida en arreglos pequeños
     *
     * @param array $array
     * @return array
     */

    public static function insertionSort(Array $array)
    {
        $length = count($array);
        for ($i = 1; $i < $length; $i++)
        {
            $element = $array[$i];
            $j = $i;
            while ($j > 0 && $array[$j - 1] > $element)
            {
                // Mover el valor a la derecha y la llave al valor anterior
                $array[$j] = $array[$j - 1];
                $j--;
            }
            //Se pone al elemento en el indice j
            $array[$j] = $element;
        }
        return $array;
    }

    /** Funcion de ordenamiento de tipo quicksort, rapida para el resto de los elementos
     *
     * @param array $array
     * @return array
     */

    public static function quickSort(Array $array)
    {
        $length = count($array);
        if ($length < 2)
            return $array;
        $low   = [];
        $high  = [];
        $pivot = $array[0];
        for ($i = 1; $i < $length; $i++)
        {
            if ($array[$i] < $pivot)
            {
                $low[] = $array[$i];
            }
            else
            {
                $high[] = $array[$i];
            }
        }
        return array_merge(self::quickSort($low), array($pivot), self::quickSort(($high)));
    }

    /** Funcion que define que método se ha de utilizar, si insertion o quicksort
     * @param array $array
     * @return array
     */
    public function sort(Array $array)
    {
        $length = count($array);
        // Si el arreglo es menor a 30, entonces usa insertion;
        if($length < 30)
            return self::insertionSort($array);
        return self::quickSort(($array));
    }
}