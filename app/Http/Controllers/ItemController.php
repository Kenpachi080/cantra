<?php

namespace App\Http\Controllers;

use App\Http\Requests\itemReviewRequest;
use App\Models\Item;
use App\Models\ReviewItem;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    /**
     * @var mixed|string
     */
    private $url;

    public function __construct()
    {
        $this->url = env('APP_URL', 'http://127.0.0.1:8000');
        $this->url = $this->url . "/storage/";
    }
    
    public function items(Request $request)
    {
        /* Итерация с 1-ым спмском */
        if ($request->order == 'ASC' || $request->order == 'DESC') {
            $items = Item::orderBy('price', $request->order);
        } else if ($request->order == 'NEW') {
            $items = Item::orderBy('id', 'DESC');
        } else {
            $items = Item::orderBy('id', 'ASC');
        }
        /* Итерация с 2-ым и 3-им спмском */
        if ($request->type) {
            $items->where('type', '=', $request->type);
        }
        if ($request->season) {
            $items->where('season', '=', $request->season);
        }
        $items = $items->get();
        foreach ($items as $item) {
            $item->image = $this->url . $item->image;
        }
        return response($items, 200);
    }

    public function item_review(itemReviewRequest $request)
    {
        $item = Item::where('id', '=', $request->item_id)->first();
        if (!$item) {
            return response(['message' => 'не найдено'], 404);
        }

        $review = ReviewItem::create([
            'item_id' => $request->item_id,
            'name' => $request->name,
            'city' => $request->city,
            'auto' => $request->auto,
            'color' => $request->color,
            'message' => $request->message,
            'images' => $request->images
        ]);

        return response($review, 201);
    }
}
