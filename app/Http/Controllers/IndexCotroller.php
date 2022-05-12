<?php

namespace App\Http\Controllers;

use App\Http\Requests\ApplicationJobRequest;
use App\Http\Requests\ApplicationRequest;
use App\Models\Application;
use App\Models\ApplicationJob;
use App\Models\FakeMain;
use App\Models\FakeSection;
use App\Models\Item;
use App\Models\ItemImage;
use App\Models\MainGallery;
use App\Models\MainReview;
use App\Models\MainTitle;
use App\Models\MainTitleSlider;
use App\Models\PartnerBenefit;
use App\Models\PartnerBio;
use App\Models\PartnerCard;
use App\Models\PartnerCommand;
use App\Models\PartnerMain;
use App\Models\ReviewBiz;
use App\Models\Title;
use Illuminate\Http\Request;

class IndexCotroller extends Controller
{

    /**
     * @var string
     */
    private $url;

    public function __construct()
    {
        $this->url = env('APP_URL', 'http://127.0.0.1:8000');
        $this->url = $this->url . "/storage/";
    }

    public function main()
    {
        $title = MainTitle::first();
        $slider = MainTitleSlider::all();
        $reviews = MainReview::all();
        $gallery = MainGallery::all();
        $contact = Title::first();
        $return = [
            'main_title' => $title,
            'slider' => $slider,
            'gallery' => $gallery,
            'review' => $reviews,
            'contact_data' => $contact,

        ];
        return response($return, 200);
    }

    public function partner()
    {
        $main = PartnerMain::first();
        $bio = PartnerBio::first();
        $card = PartnerCard::all();
        $benefit = PartnerBenefit::first();
        $command = PartnerCommand::all();
        $review = MainReview::all();
        $review_biz = ReviewBiz::all();
        $return = [
            'main' => $main,
            'bio' => $bio,
            'card' => $card,
            'benefit' => $benefit,
            'review' => $review,
            'review_biz' => $review_biz,
            'command' => $command,
        ];

        return response($return, 200);
    }

    public function gallery()
    {
        return response(MainGallery::all(), 200);
    }

    public function fake()
    {
        $main = FakeMain::first();
        $sections = FakeSection::all();
        $return = [
            'main' => $main,
            'sections' => $sections,
        ];
        return response($return, 200);
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
        $items  = $items->get();
        foreach ($items as $item) {
            $item->image = $this->url . $item->image;
        }
        return response($items, 200);
    }


    public function application(ApplicationRequest $request)
    {
        $application = Application::create([
            'name' => $request->name,
            'phone' => $request->phone
        ]);

        if ($application) {
            return response($application, 201);
        }
    }

    public function applicationjob(ApplicationJobRequest $request)
    {
        $application = ApplicationJob::create([
            'name' => $request->name,
            'phone' => $request->phone
        ]);

        if ($application) {
            return response($application, 201);
        }
    }
}
