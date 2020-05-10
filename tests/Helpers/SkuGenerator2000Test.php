<?php

namespace Tests\Helpers;

use App\Helpers\SkuGenerator2000;
use PHPUnit\Framework\TestCase;

class SkuGenerator2000Test extends TestCase
{
    public function testSku()
    {
        // Possible variants
        $variants = array(
            'brand' => array(
                // the first value in our array is our SKU identifier, this will be used to create our unqiue SKU code
                // the second value is a nice name, description if you will
                array('AP', 'Apple'),
                array('BA', 'Banana'),
                array('PE', 'Pear'),
            ),
            'color' => array(
                array('RE', 'Red'),
                array('GR', 'Green'),
                array('BL', 'Blue'),
            ),
        );

// Rules for combinations I dont want
        $disallow = array(
            array('brand' => 'AP', 'color' => 'GR'), // No green apples
            array('brand' => 'AP', 'color' => 'RE'), // No red apples
            array('brand' => 'PE', 'color' => 'BL'), // No blue pears
        );

// Create new class
        $skuGenerator = new SkuGenerator2000();

// Get me my skus!
        $skus = $skuGenerator->generate('PHONE1', $variants, $disallow);

        var_dump(array_keys($skus)); // Dump just the skus

// separate our data
        echo "\n\n";

// Now dump the entire result!
        var_dump($skus); // Dump it all
    }

}
