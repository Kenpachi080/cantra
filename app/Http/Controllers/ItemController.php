<?php

namespace App\Http\Controllers;

use App\Http\Requests\ItemImageRequest;
use App\Http\Requests\itemReviewRequest;
use App\Models\Item;
use App\Models\ItemImage;
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

    /**
     * @OA\Post(
     * path="/api/items",
     * summary="Поиск по каталогу",
     * description="Поиск по каталогу",
     * operationId="item",
     * tags={"item"},
     * @OA\RequestBody(
     *    required=true,
     *    description="Поиск товаров",
     *    @OA\JsonContent(
     *       required={""},
     *       @OA\Property(property="id", type="string", format="string", example="1"),
     *       @OA\Property(property="order", type="string", format="string", example="DESC"),
     *       @OA\Property(property="type", type="string", format="string", example="Коплекты накидок"),
     *       @OA\Property(property="season", type="string", format="string", example="Зимние"),
     *  ),
     * ),
     * @OA\Response(
     *    response=200,
     *    description="CallBack с товаром",
     *    @OA\JsonContent(
     *       type="object",
     *        )
     *     )
     * )
     */
    public function items(Request $request)
    {
        /* Итерация с 1-ым спмском */
        if ($request->id) {
            $items = Item::where('id', '=', $request->id)->first();
            $items->image = $this->url . $items->image;
            $items->images = $this->image($request->id);
            $items->colors = $this->color($request->id);
        } else {
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
                $item->images = $this->image($item->id);
                $item->colors = $this->color($item->id);
            }
        }
        if (!$items) {
            return response(['message' => 'не найдено'], 404);
        }
        return response($items, 200);
    }

    /**
     * @OA\Post(
     * path="/api/items/review/create",
     * summary="СОздание отзывов",
     * description="Создание отзывов",
     * operationId="review_create",
     * tags={"item"},
     * @OA\RequestBody(
     *    required=true,
     *    description="Поиск товаров",
     *    @OA\JsonContent(
     *       required={"item_id, name, city, auto, color, message"},
     *       @OA\Property(property="item_id", type="string", format="string", example="1"),
     *       @OA\Property(property="name", type="string", format="string", example="DESC"),
     *       @OA\Property(property="city", type="string", format="string", example="Коплекты накидок"),
     *       @OA\Property(property="auto", type="string", format="string", example="Зимние"),
     *       @OA\Property(property="color", type="string", format="string", example="Зимние"),
     *       @OA\Property(property="message", type="string", format="string", example="Зимние"),
     *  ),
     * ),
     * @OA\Response(
     *    response=200,
     *    description="CallBack с отзывом",
     *    @OA\JsonContent(
     *       type="object",
     *        )
     *     )
     * )
     */
    public function item_review(itemReviewRequest $request)
    {
        $item = Item::where('id', '=', $request->item_id)->first();
        if (!$item) {
            return response(['message' => 'не найдено'], 404);
        }
        $images = '';
        $review = ReviewItem::create([
            'item_id' => $request->item_id,
            'name' => $request->name,
            'city' => $request->city,
            'auto' => $request->auto,
            'color' => $request->color,
            'message' => $request->message,
            'images' => $images
        ]);

        return response($review, 201);
    }

    /**
     * @OA\Post(
     * path="/api/items/review",
     * summary="Показать отзывы",
     * description="Показать отзывы",
     * operationId="review_view",
     * tags={"item"},
     * @OA\RequestBody(
     *    required=true,
     *    description="Поиск товаров",
     *    @OA\JsonContent(
     *       required={"item_id"},
     *       @OA\Property(property="item_id", type="string", format="string", example="1"),
     *  ),
     * ),
     * @OA\Response(
     *    response=200,
     *    description="CallBack с товаром",
     *    @OA\JsonContent(
     *       type="object",
     *        )
     *     )
     * )
     */

    public function review_view(Request $request)
    {
        $review = ReviewItem::where('item_id', '=', $request->item_id)->get();

        return response($review, 200);
    }

    /**
     * @OA\Post(
     * path="/api/items/item_image",
     * summary="Показать фотки товара",
     * description="Показать фотки товаров",
     * operationId="item_image",
     * tags={"item"},
     * @OA\RequestBody(
     *    required=true,
     *    description="Поиск фоток товаров",
     *    @OA\JsonContent(
     *       required={"item_id, color"},
     *       @OA\Property(property="item_id", type="string", format="string", example="1"),
     *       @OA\Property(property="color", type="string", format="string", example="1"),
     *  ),
     * ),
     * @OA\Response(
     *    response=200,
     *    description="CallBack с товаром",
     *    @OA\JsonContent(
     *       type="object",
     *        )
     *     )
     * )
     */
    public function item_image(ItemImageRequest $request)
    {
        $image = ItemImage::where('item_id', '=', $request->item_id)->where('color', '=', $request->color)->get();
        return response($image, 200);
    }

    private function color($id)
    {
        $color = ItemImage::leftjoin('colors', 'colors.id', '=', 'item_images.color')
            ->select('colors.logo', 'colors.name')
            ->where('item_images.item_id', '=', $id)->get();
        foreach ($color as $item) {
            $item->logo = $this->url . $item->logo;
        }
        return $color;
    }

    private function image($id)
    {
        $color = ItemImage::leftjoin('colors', 'colors.id', '=', 'item_images.color')
            ->where('item_images.item_id', '=', $id)->get();
        foreach ($color as $item) {
            $item->images = json_decode($item->images);
            $item->images = $this->multiimage($item->images);
            $item->logo = $this->url . $item->logo;
        }
        return $color;
    }

    private function multiimage($image)
    {
        $return = [];
        if ($image) {
            foreach ($image as $value) {
                $return[] = $this->url . $value;
            }
        } else {
            $return = [];
        }
        return $return;
    }
}
