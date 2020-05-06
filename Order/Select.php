<?php
/**
 * 选择排序
 * Select.php
 * User: sammy le
 * Time: 2020/5/5 17:17:55
 */

class Select
{
    public $array;

    public function __construct($array)
    {
        $this->array = $array;
    }

    //O(n^2)
    public function order()
    {
        if (empty($this->array)) {
            return [];
        }
        $length = count($this->array);
        for ($i = 0; $i <= $length - 1; $i++) {
            $miniKey = $i;
            for ($j = $i + 1; $j < $length; $j++) {
                if ($this->array[$j] < $this->array[$miniKey]) {
                    $miniKey = $j;
                }
            }
            $temp = $this->array[$i];
            $this->array[$i] = $this->array[$miniKey];
            $this->array[$miniKey] = $temp;
        }

        return $this->array;
    }
}

//test
$array = [2, 3, 1, 5, 6, 8, 9];
$o = new Select($array);
print_r($o->order());