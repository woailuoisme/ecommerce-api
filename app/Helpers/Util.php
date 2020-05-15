<?php


namespace App\Helpers;


use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Validator;

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

    public function validator(array $data)
    {
        $data['date_of_birth'] = $data['day'].'-'.$data['month'].'-'.$data['year'];
        $current_year = Carbon::now()->year;
//        $hundred_years_ago     = (new Carbon("150 years ago"))->year;
        $hundred_years_ago = Carbon::now()->subYears(150)->year;

        return Validator::make($data, [
            'year'          => 'Required|Integer|Between:'.$hundred_years_ago.','.$current_year,
            'date_of_birth' => 'Required|Date',
        ]);
    }


    /**
     * Converts a long string of bytes into a readable format e.g KB, MB, GB, TB, YB
     * @param {Int} num The number of bytes.
     */
    function readableBytes($bytes)
    {
        $i = floor(log($bytes) / log(1024));
        $sizes = array('B', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB');

        return sprintf('%.02F', $bytes / pow(1024, $i)) * 1 .' '.$sizes[$i];
    }

    /**
     * Get Readable Integer Number
     *
     * @param  int  $input
     * @return string
     **/
    public static function getNumber(int $input): string
    {
        return number_format($input);
    }

    /**
     * Get Readable Social Number
     * @link  https://github.com/RaggiTech/laravel-readable
     * @param  int  $input
     * @param  bool  $showDecimal
     * @param  int  $decimals
     * @return string
     **/
    public static function getHumanNumber(int $input, bool $showDecimal = false, int $decimals = 0): string
    {
        $decimals = $showDecimal && $decimals == 0 ? 1 : $decimals;
        $floorNumber = 0;

        if ($input >= 0 && $input < 1000) {
            // 1 - 999
            $getFloor = floor($input);
            $suffix = '';
        } elseif ($input >= 1000 && $input < 1000000) {
            // 1k-999k
            $getFloor = floor($input / 1000);
            $floorNumber = 1000;
            $suffix = 'K';
        } elseif ($input >= 1000000 && $input < 1000000000) {
            // 1m-999m
            $getFloor = floor($input / 1000000);
            $floorNumber = 1000000;
            $suffix = 'M';
        } elseif ($input >= 1000000000 && $input < 1000000000000) {
            // 1b-999b
            $getFloor = floor($input / 1000000000);
            $floorNumber = 1000000000;
            $suffix = 'B';
        } elseif ($input >= 1000000000000) {
            // 1t+
            $getFloor = floor($input / 1000000000000);
            $floorNumber = 1000000000000;
            $suffix = 'T';
        }

        // Decimals
        if ($showDecimal && $floorNumber > 0) {
            $input -= ($getFloor * $floorNumber);
            if ($input > 0) {
                $input /= $floorNumber;
                $getFloor += $input;
            }
        }

        return !empty($getFloor.$suffix) ? number_format($getFloor, $decimals).$suffix : 0;
    }

}