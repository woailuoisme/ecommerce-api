<?php

namespace Tests\Helpers;

use App\helpers\Util;
use PHPUnit\Framework\TestCase;

class UtilTest extends TestCase
{
    public function testCartesianProduct(): void
    {

        $sets = array(
            array('白色', '黑色', '红色'),
            array('透气', '防滑'),
            array('37码', '38码', '39码'),
            array('男款', '女款'),
        );

        $result = Util::cartesianProduct($sets);
        print_r($result);
    }

    public function testCartesian()
    {

        $sku_options = collect([
            [
                'name'    => '屏幕尺寸',
                'en_name' => 'size',
                'values'  => ['5.0', '6.0'],
            ],
            [
                'name'    => '颜色',
                'en_name' => 'color',
                'values'  => ['black', 'white'],
            ],
            [
                'name'    => '内存大小',
                'en_name' => 'memory',
                'values'  => ['4g', '6g'],
            ],
        ]);
        $result = $sku_options->mapWithKeys(function ($op) {
            return [$op['en_name'] => $op['values']];
        });
//        print_r($result->toArray());

//        $input = ['color' => ['black', 'white'], 'size' => ['5.0', '6.0'], 'memory' => ['4g', '6g']];
//        echo json_encode($result->toArray());
//        echo '\n';
//        echo json_encode($input);
        $re = Util::cartesian($result);
//        $re =Util::cartesian($result->toArray());
        echo count($re);
        print_r(json_encode($re));
        print_r($re);
    }

}
