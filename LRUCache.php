<?php
/**
 * php LRU
 * User: sammy le
 * Date: 2020-03-12
 * Time: 21:09
 */

class Node
{
    public $key;
    public $val;
    public $next;
    public $prev;

    public function __construct($key, $val)
    {
        $this->key = $key;
        $this->val = $val;
    }

    public function __get($val)
    {
        return $this->$val;
    }

    public function __set($key, $val)
    {
        return $this->$key = $val;
    }
}


class LRUCache
{
    private $capacity;
    private $hashMap;
    private $head;
    private $tail;

    public function __construct($capacity)
    {
        $this->capacity = $capacity;
        $this->hashMap = [];

        $this->initNode();
    }

    public function initNode()
    {
        $this->head = new Node(null, null);
        $this->tail = new Node(null, null);

        $this->head->next = $this->tail;
        $this->head->prev = null;

        $this->tail->prev = $this->head;
        $this->tail->next = null;
    }

    public function get($key)
    {
        if(!isset($this->hashMap[$key])){
            return -1;
        }
        $node = $this->hashMap[$key];

        // remove the node and move to the head
        $this->detach($node)->attach($node, new Node(null, null), $this->head);

        return $node->val;
    }

    public function put($key, $val)
    {
        $isFull = count($this->hashMap) >= $this->capacity;
        if(isset($this->hashMap[$key])){
            $node = $this->hashMap[$key];
            $node->val = $val;
            //remove the node and move to the head
            $this->detach($node)->attach($node, new Node(null, null), $this->head);
        }else{
            $node = new Node($key, $val);
            if($isFull){
                // remove the tail node
                $this->detach($this->tail);
            }
            // add to the head
            $this->attach($node, new Node(null, null), $this->head);
        }
        return $this;
    }

    public function attach(Node $newNode, Node $prevNode, Node $nextNode)
    {
        if(empty($this->hashMap)){
            $this->head = $newNode;
            $this->tail = $newNode;
        }else{
            if($nextNode == $this->head){
                $this->attachHead($newNode);
            } else if($prevNode == $this->tail){
                $this->attachTail($newNode);
            }else {
                $prevNode->next = $newNode;
                $nextNode->prev = $newNode;

                $newNode->next = $nextNode;
                $newNode->prev = $prevNode;
            }
        }
        $this->hashMap[$newNode->key] = $newNode;
        return $this;
    }

    public function attachTail(Node $node)
    {
        $node->prev = $this->tail;
        $node->next = null;
        $this->tail->next = $node;
        $this->tail = $node;

        return $this;
    }

    public function attachHead(Node $node)
    {
        $node->next = $this->head;
        $node->prev = null;
        $this->head->prev = $node;
        $this->head = $node;

        return $this;
    }

    public function detach(Node $node)
    {
        if(empty($this->hashMap)){
            return $this;
        }
        if($node == $this->head && $node == $this->tail) {

        } else if($node == $this->head){
            $node->next->prve = null;
            $this->head = $node->next;
        } else if($node == $this->tail) {
            $node->prev->next = null;
            $this->tail = $node->prev;
        }else{
            $node->prev->next = $node->next;
            $node->next->prev = $node->prev;
        }
        unset($this->hashMap[$node->key]);
        return $this;
    }

    public function show()
    {
        $node = $this->head;
        echo $node->key.':'.$node->val.'<br />';
        while ( ( $node->next) !== null ){
            $node = $node->next;
            echo $node->key.':'.$node->val.'<br />';
        }
    }

    public function test()
    {
        print_r($this->hashMap);
    }
}
