<?php


namespace App\Helpers;


class Util
{
    public static function json_encode($str)
    {
        return json_encode($str, JSON_UNESCAPED_UNICODE);
    }

    public static function json_decode($str)
    {
        return json_decode($str, true);
    }


    /**
     * @link  https://stackoverflow.com/questions/6311779/finding-cartesian-product-with-php-associative-arrays
     * @param $input
     * @return array|array[]
     */
    public static function cartesian($input)
    {
        $result = array(array());
        foreach ($input as $key => $values) {
            $append = array();
            foreach ($result as $product) {
                foreach ($values as $item) {
                    $product[$key] = $item;
                    $append[] = $product;
                }
            }
            $result = $append;
        }

        return $result;
    }
}