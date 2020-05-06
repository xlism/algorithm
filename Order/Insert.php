<?php
/**
 * 插入排序
 * Insert.php
 * User: sammy le
 * Time: 2020/5/5 18:14:45
 */

class Insert
{
    public $array;
    private $length;

    public function __construct($array)
    {
        $this->array = $array;
        $this->length = count($this->array);
    }

    public function order()
    {
        if (empty($this->array)) {
            return [];
        }
        for ($i = 1; $i < $this->length; $i++) {
            $insertItem = $this->array[$i];
            for ($j = $i - 1; $j >= 0 && $this->array[$j] > $insertItem; $j--) {
                $this->array[$j + 1] = $this->array[$j];
            }
            $this->array[$j + 1] = $insertItem;
        }

        return $this->array;
    }
}

//test
$array = [2, 5, 1, 4, 9, 8];
$order = new Insert($array);
print_r($order->order());