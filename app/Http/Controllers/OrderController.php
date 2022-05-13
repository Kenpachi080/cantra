<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderCreateRequest;
use App\Models\Item;
use App\Models\ItemImage;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function create(OrderCreateRequest $request)
    {
        $order = Order::create([
            'fio' => $request->fio,
            'phone' => $request->phone,
            'email' => $request->email,
            'message' => $request->message,
            'promo' => $request->promo,
            'type_payment' => $request->type_payment,
        ]);
        $return = [];
        $return['Order'] = $order;
        $return['Order_items'] = [];
        $endcount = 0;
        foreach ($request->items as $key => $value) {
            $item = Item::where('id', '=', $key)->first();
            $item_color = ItemImage::where('item_id', '=', $key)->where('color', '=', $value)->first();
            if (!$item || !$item_color) {
                continue;
            }
            $endcount = $endcount + $item->price;
            $orderItem = OrderItem::create([
                'order_id' => $order->id,
                'item' => $key,
                'color' => $value,
                'price' => $item->price
            ]);
            array_push($return['Order_items'], $orderItem);
        }
        if (!$return['Order_items'] && count($return['Order_items']) > 0) {
            return response(['message' => 'Товары с данными характеристиками не были найдены'], 404);
        }
        return response($return, 201);

    }
}
