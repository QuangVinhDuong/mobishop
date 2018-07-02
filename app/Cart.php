<?php

namespace App;

class Cart
{
	public $items = null;
	public $totalQty = 0;
	public $totalPrice = 0;

	public function __construct($oldCart) {
		if($oldCart){
			$this->items = $oldCart->items;
			$this->totalQty = $oldCart->totalQty;
			$this->totalPrice = $oldCart->totalPrice;
		}
	}

	public function add($item, $id) {
		$giohang = ['qty'=>0, 'price'=>0, 'item'=>null];
		if($this->items){
			if(array_key_exists($id, $this->items)){
				$giohang = $this->items[$id];
			}
		}
		$giohang['qty']++;
		$giohang['price'] = $item['attributes']['unit_price'] * $giohang['qty'];
		$giohang['item'] = $item;
		$this->items[$id] = $giohang;
		$this->totalQty++;
		$this->totalPrice += $item['attributes']['unit_price'];
	}
	//xóa 1
	public function reduceByOne($id) {
		$this->items[$id]['qty']--;
		$this->items[$id]['price'] -= $this->items[$id]['item']['price'];

		$this->totalQty--;		
		$this->totalPrice -= $this->items[$id]['item']['attributes']['unit_price'];
		if($this->items[$id]['qty']<=0){
			unset($this->items[$id]);
		}
	}
	//cộng 1
	public function increaseByOne($id) {
		$this->items[$id]['qty']++;
		$this->items[$id]['price'] += $this->items[$id]['item']['price'];
		
		$this->totalQty++;
		$this->totalPrice += $this->items[$id]['item']['attributes']['unit_price'];		
	}
	//xóa nhiều
	public function removeItem($id){
		$this->totalQty -= $this->items[$id]['qty'];
		$this->totalPrice -= $this->items[$id]['price'];
		unset($this->items[$id]);
	}
}