<?php

namespace App\Http\Controllers;

use App\Http\Requests\ApplicationJobRequest;
use App\Http\Requests\ApplicationRequest;
use App\Http\Requests\itemReviewRequest;
use App\Models\Application;
use App\Models\ApplicationJob;
use App\Models\FakeMain;
use App\Models\FakeSection;
use App\Models\IndividualEdging;
use App\Models\IndividualRow;
use App\Models\IndividualZamsha;
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
use App\Models\ReviewItem;
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
    /**
     * @OA\Get(path="/api/",
     *   tags={"view"},
     *   operationId="viewIndex",
     *   summary="Информация про каталог",
     * @OA\Response(
     *    response=200,
     *    description="Возврощается полная информация про каталог",
     *   )
     * )
     */
    public function main()
    {
        $title = MainTitle::first();
        $slider = MainTitleSlider::all();
        $reviews = MainReview::all();
        $gallery = MainGallery::all();
        $contact = Title::first();
        $row = IndividualRow::all();
        foreach ($row as $block) {
            $block->image = $this->url.$block->image;
        }
        $zamsha = IndividualZamsha::all();
        foreach ($zamsha as $block) {
            $block->image = $this->url.$block->image;
        }
        $edging = IndividualEdging::all();
        foreach ($edging as $block) {
            $block->image = $this->url.$block->image;
        }
        $return = [
            'main_title' => $title,
            'slider' => $slider,
            'gallery' => $gallery,
            'review' => $reviews,
            'contact_data' => $contact,
            'rowcolor' => $row,
            'zamshacolor' => $zamsha,
            'edgingcolor' => $edging,
        ];
        return response($return, 200);
    }
    /**
     * @OA\Get(path="/api/partner",
     *   tags={"view"},
     *   operationId="viewpartner",
     *   summary="Информация про партнеров",
     * @OA\Response(
     *    response=200,
     *    description="Возврощается полная информация про партнеров",
     *   )
     * )
     */
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
    /**
     * @OA\Get(path="/api/gallery",
     *   tags={"view"},
     *   operationId="viewgallery",
     *   summary="Информация про галлерею",
     * @OA\Response(
     *    response=200,
     *    description="Возврощается галлерея",
     *   )
     * )
     */
    public function gallery()
    {
        return response(MainGallery::all(), 200);
    }
    /**
     * @OA\Get(path="/api/fake",
     *   tags={"view"},
     *   operationId="viewfake",
     *   summary="Информация про Отличии от подделок",
     * @OA\Response(
     *    response=200,
     *    description="Возврощается информоция про подделок",
     *   )
     * )
     */
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
    /**
     * @OA\Post(
     * path="/api/application",
     * summary="Заявка",
     * description="Заявка",
     * operationId="application",
     * tags={"application"},
     * @OA\RequestBody(
     *    required=true,
     *    description="Создание заявок",
     *    @OA\JsonContent(
     *       required={"name, phone"},
     *       @OA\Property(property="name", type="string", format="string", example="1"),
     *       @OA\Property(property="phone", type="string", format="string", example="1"),
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
    /**
     * @OA\Post(
     * path="/api/applicationjob",
     * summary="Заявка",
     * description="Заявка",
     * operationId="applicationjob",
     * tags={"application"},
     * @OA\RequestBody(
     *    required=true,
     *    description="Создание заявок",
     *    @OA\JsonContent(
     *       required={"name, phone, email"},
     *       @OA\Property(property="name", type="string", format="string", example="1"),
     *       @OA\Property(property="phone", type="string", format="string", example="1"),
     *       @OA\Property(property="email", type="string", format="string", example="1"),
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
    public function applicationjob(ApplicationJobRequest $request)
    {
        $application = ApplicationJob::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone
        ]);

        if ($application) {
            return response($application, 201);
        }
    }

    public function individual(Request $request) {

    }
}
