<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\AuctionResource;
use App\Http\Resources\BidResource;
use App\Models\Auction;
use App\Models\Bid;
use App\Models\Car;
use App\Models\Image;
use Illuminate\Http\Request;
use function PHPUnit\Framework\isEmpty;

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

    /**
     * @OA\Get(
     *      path="/api/auction/{id}",
     *      security={{ "api": {} }},
     *      operationId="auction_show",
     *      tags={"2.Auction API"},
     *      summary="Auction id orqali dealerlarni olish",
     *      description="Id boyicha dealerlarni ko'rish",
     *      @OA\Parameter(name="id",description="ID kiritring",required=true,in="path",
     *          @OA\Schema(type="integer",format="number",example="2")
     *      ),
     *      @OA\Response(response=200,description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/Auction"),
     *      ),
     *      @OA\Response(response=404,description="Not found",
     *          @OA\JsonContent(ref="#/components/schemas/Error"),
     *      ),
     *
     *   )
     */

    public function getDealer($id){
        $models = Bid::where('auction_id', $id)->get();
        if($models->isEmpty()){
            return response()->json([
                'message' => 'Big not found'
            ], 404);
        }
        return response()->json([
            'data' => BidResource::collection($models),
        ], 200);
    }
}
