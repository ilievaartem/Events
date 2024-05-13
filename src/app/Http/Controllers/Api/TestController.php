<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

class TestController extends Controller
{

    public function anagrams(Request $request)
    {

        $str1 = $request->input('str1');
        $str2 = $request->input('str2');
        $arr1 = str_split($str1);
        $arr2 = str_split($str2);

        sort($arr1, SORT_STRING);
        sort($arr2, SORT_STRING);
        if ($arr1 === $arr2) {
            return response()->json(['message' => 'True']);
        }
        return response()->json([
            'message' => 'False'
        ]);


    }
    public function maxElement(Request $request)
    {
        $str1 = $request->input('str1');
        $arr1 = str_split($str1);
        $arr1 = array_count_values($arr1);
        return response()->json(max($arr1));

    }
    public function uniqueNumbers(Request $request)
    {
        $arr1 = str_split($request->input('str1'));
        $result = array_unique($arr1);
        asort($result);
        return response()->json(implode(" ", $result));
    }
    public function putZeroToEnd(Request $request)
    {
        $arrNumber = explode(" ", $request->input('str1'));
        $arrCountValues = (array_count_values($arrNumber));
        $size = $arrCountValues['0'];
        $arrZero = [];
        $zero_keys = array_keys($arrNumber, "0");
        for ($i = 0; $i < $size; $i++) {
            unset($arrNumber[$zero_keys[$i]]);
            $arrZero[$i] = '0';
        }
        array_push($arrNumber, ...$arrZero);
        return response()->json(implode(" ", $arrNumber));
    }
    public function changeEachElementToProductOther(Request $request)
    {
        $givenArr1 = explode(" ", $request->input('str1'));
        $arrSize = count($givenArr1);

        for ($i = 0; $i < $arrSize; $i++) {
            if ($givenArr1[$i] != 0) {
                $newArr1[$i] = array_product($givenArr1) / $givenArr1[$i];
            } else {
                unset($givenArr1[$i]);
                $newArr1[$i] = array_product($givenArr1);
                array_unshift($givenArr1, 0);
            }
        }
        return response()->json(implode(" ", $newArr1));
    }
    public function maxDifferentWithDumbCondition(Request $request)
    {
        $givenArr1 = explode(" ", $request->input('str1'));
        // $givenArr1 = explode(" ", $line);
        $arrSize = count($givenArr1);
        $maxDifferent = $givenArr1[0] - $givenArr1[1];
        $biggerElement = 0;
        for ($i = 0; $i < $arrSize - 1; $i++) {
            $j = $i;
            if ($biggerElement >= $givenArr1[$i]) {
                if (($biggerElement - $givenArr1[++$j]) > $maxDifferent) {
                    $maxDifferent = $biggerElement - $givenArr1[$j++];
                }
            } else {
                $biggerElement = $givenArr1[$i];
                $diff = $biggerElement - $givenArr1[++$j];
                if ($diff > $maxDifferent) {
                    $maxDifferent = $diff;
                }

            }
        }
        // print_r($maxDifferent);

        return response()->json($maxDifferent);

    }
    public function MaxSumRowInArray(Request $request)
    {

        $line = $request->input('str1');
        $nums = explode(' ', $line);

        $numsCount = count($nums);

        $maxSumCurrent = $nums[0];
        $maxSumTotal = $nums[0];

        for ($i = 1; $i < $numsCount; $i++) {
            $num = $nums[$i];

            $maxSumCurrent += $num;

            if ($maxSumCurrent < $num) {
                $maxSumCurrent = $num;
            }

            if ($maxSumCurrent > $maxSumTotal) {
                $maxSumTotal = $maxSumCurrent;
            }
        }
        return response()->json($maxSumTotal);
    }
    public function LuckyTicket(Request $request)
    {
        $line1 = $request->input('str1');
        $line2 = $request->input('str2');

        $ticketsFrom = intval($line1);
        $ticketsTo = intval($line2);
        $size = $ticketsTo - $ticketsFrom;
        for ($i = 0; $i <= $size; $i++) {
            $firstPart = intval($ticketsFrom / 1000);
            $lastPart = $ticketsFrom % 1000;


            $firstPart = array_sum(str_split($firstPart));
            $lastPart = array_sum(str_split($lastPart));
            if ($firstPart == $lastPart) {
                echo $ticketsFrom . "\n";
            }
            $ticketsFrom++;
        }
    }
}
