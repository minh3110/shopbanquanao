<?php

namespace App\Models;

class Cart
{
    public $items = null;
    public $totalQty = 0;
    public $totalPrice = 0;

    public function __construct($oldCart)
    {
        if($oldCart){
            $this->items = $oldCart->items;
            $this->totalQty = $oldCart->totalQty;
            $this->totalPrice = $oldCart->totalPrice;
        }
    }

    public function add($item, $id, $color, $size){
        $storedItem = ['qty' => 0, 'price' => $item->price, 'item' => $item];
        if($this->items){
            if(array_key_exists($id . '_' . $color . '_' . $size, $this->items)){
                $storedItem = $this->items[$id . '_' . $color . '_' . $size];
            }
        }
        $storedItem['qty']++;
        $storedItem['price'] = $item->price * $storedItem['qty'];
        $this->items[$id . '_' . $color . '_' . $size] = $storedItem;
        $this->totalQty++;
        $this->totalPrice += $item->price;
    }

    public function deleteItem($id, $color, $size){
        $this->totalQty -= $this->items[$id . '_' . $color . '_' . $size]['qty'];
        $this->totalPrice -= $this->items[$id . '_' . $color . '_' . $size]['price'];
        unset($this->items[$id . '_' . $color . '_' . $size]);
    }

    public function changeQty($request)
    {
        $color = $request->color;
        $size = $request->size;
        if ((int) $this->items[$request->id . '_' . $color . '_' . $size]['qty'] < (int) $request->qty) {
            $currentQty = (int) $request->qty - (int) $this->items[$request->id . '_' . $color . '_' . $size]['qty'];
            $this->totalQty += $currentQty;
            $this->totalPrice += $currentQty * $this->items[$request->id . '_' . $color . '_' . $size]['item']['price'];
            $this->items[$request->id . '_' . $color . '_' . $size]['qty'] += (int) $currentQty;
        } else if ((int) $this->items[$request->id . '_' . $color . '_' . $size]['qty'] > (int) $request->qty) {
            $currentQty = (int) $this->items[$request->id . '_' . $color . '_' . $size]['qty'] - (int) $request->qty;
            $this->totalQty -= $currentQty;
            $this->totalPrice -= $currentQty * $this->items[$request->id . '_' . $color . '_' . $size]['item']['price'];
            $this->items[$request->id . '_' . $color . '_' . $size]['qty'] -= (int) $currentQty;
        }
        $this->items[$request->id . '_' . $color . '_' . $size]['price'] = (int) $request->qty * $this->items[$request->id . '_' . $color . '_' . $size]['item']['price'];
    }

    public function decreaseItemByOne($id){
        $this->items[$id]['qty']--;
        $this->items[$id]['price'] -= $this->items[$id]['item']['price'];
        $this->totalQty--;
        $this->totalPrice -= $this->items[$id]['item']['price'];
        if($this->items[$id]['qty'] <= 0){
            unset($this->items[$id]);
        }
    }

    public function increaseItemByOne($id){
        $this->items[$id]['qty']++;
        $this->items[$id]['price'] += $this->items[$id]['item']['price'];
        $this->totalQty++;
        $this->totalPrice += $this->items[$id]['item']['price'];
    }
}
