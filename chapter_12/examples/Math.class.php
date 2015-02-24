<?php
/**
 * Math methods
 */
class Math
{
    /**
     * Return the sum of all values in an array
     * 
     * @param array $values An array of values to sum
     * @return int
     */
    public static function add($values)
    {
        return array_sum($values);
    }
    /**
     * Return the product of all values in an array
     * 
     * @param array $values An array of values to multiply
     * @return int
     */
    public static function multiply($values)
    {
        return array_product($values);
    }
}
?>