<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\AuctionResource;
use App\Models\Auction;
use App\Models\Car;
use App\Models\Image;
use Illuminate\Http\Request;

class AuctionController extends Controller
{
    public function __construct(){
        $this->middleware('auth:api');
    }
    /**
     * @OA\Get(
     *      path="/api/auction",
     *      security={{ "api": {} }},
     *      operationId="app_index",
     *      tags={"2.Auction API"},
     *      summary="Get App",
     *      description="Hamma auctionlarni olish",
     *      @OA\Response(response=200,description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/Auction"),
     *      ),
     *      @OA\Response(response=404,description="Not found",
     *          @OA\JsonContent(ref="#/components/schemas/Error"),
     *      ),
     *
     *   )
     */
    public function index(){
        $models = Auction::all();

        return response()->json([
            'data' => AuctionResource::collection($models),
            'code' => 200,
        ]);
    }
}
