<?php


namespace App\Helpers;


class SkuGenerator2000
{

    public function generate($productId, array $variants, array $disallow)
    {
        // First lets get all of the different permutations = cartesian product
        $permutations = $this->permutate($variants);

        // Now lets get rid of the pesky combinations we don't want
        $filtered = $this->squelch($permutations, $disallow);

        // Finally we can generate some SKU codes using the $productId as the prefix
        // this assumes you want to reuse this code for different products
        $skus = $this->skuify($productId, $filtered);

        return $skus;
    }

    public function permutate(array $variants)
    {
        // filter out empty values
        // This is the cartesian product code
        $input = array_filter($variants);
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

    public function squelch(array $permutations, array $rules)
    {
        // We need to loop over the differnt permutations we have generated
        foreach ($permutations as $per => $values) {
            $valid = true;
            $test = array();
            // Using the values, we build up a comparison array to use against the rules
            foreach ($values as $id => $val) {
                // Add the KEY from the value to the test array, we're trying to make an
                // array which is the same as our rule
                $test[$id] = $val[0];
            }
            // Now lets check all of our rules against our new test array
            foreach ($rules as $rule) {
                // We use array_diff to get an array of differences, then count this array
                // if the count is zero, then there are no differences and our test matches
                // the rule exactly, which means our permutation is invalid
                if (count(array_diff($rule, $test)) <= 0) {
                    $valid = false;
                }
            }
            // If we found it was an invalid permutation, we need to remove it from our data
            if (!$valid) {
                unset($permutations[$per]);
            }
        }

        // return the permutations, with the bad combinations removed
        return $permutations;
    }

    public function skuify($productId, array $variants)
    {
        // Lets create a new array to store our codes
        $skus = array();

        // For each of the permutations we generated
        foreach ($variants as $variant) {
            $ids = array();
            // Get the ids (which are the first values) and add them to an array
            foreach ($variant as $vals) {
                $ids[] = $vals[0];
            }

            // Now we create our SKU code using the ids we got from our values. First lets use the
            // product id as our prefix, implode will join all the values in our array together using
            // the separator argument givem `-`. This creates our new SKU key, and we store the original
            // variant as its value
            $skus[$productId.'-'.implode('-', $ids)] = $variant;
            // The bit above can be modified to generate the skues in a different way. It's a case of
            // dumping out our variant data and trying to figure what you want to do with it.
        }

        // finall we return our skus
        return $skus;
    }
}