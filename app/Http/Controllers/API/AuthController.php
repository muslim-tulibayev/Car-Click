<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\ValidatorResponse;
use App\Models\Operator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }

    /**
     * @OA\Post(
     *      path="/api/login",
     *      security={{"api":{}}},
     *      operationId="auth_operator_login",
     *      tags={"1.Auth API"},
     *      summary="Login Operator",
     *      description="Login Parol yordamida kirish Operatorlar uchun",
     *       @OA\RequestBody(required=true, description="lesson save",
     *           @OA\MediaType(mediaType="multipart/form-data",
     *              @OA\Schema(type="object", required={"contact", "password"},
     *                 @OA\Property(property="contact", type="string", format="contact", example="998998765678"),
     *                 @OA\Property(property="password", type="string", format="password", example="12345678"),
     *              )
     *          )
     *      ),
     *      @OA\Response(response=200, description="Success",
     *          @OA\JsonContent(ref="#/components/schemas/Operator"),
     *      ),
     *      @OA\Response(response=404,description="Not found",
     *          @OA\JsonContent(ref="#/components/schemas/Error"),
     *      ),
     * )
     */
    public function login(Request $request)
    {
        $rules = [
            'contact' => 'required|string',
            'password' => 'required|string',
        ];
        $validator = new ValidatorResponse();
        $validator->check($request, $rules);
        if ($validator->fails) {
            return response()->json([
                'message' => $validator->response,

            ], 400);
        }

        $model = Operator::where('contact', 'like', "%$request->contact%")->first();
        if ($model) {
            if (Hash::check($request->password, $model->password)) {
                $credentials = $request->only('contact', 'password');
                $token = auth('api')->attempt($credentials);
                $operator = auth('api')->user();
                return response()->json([
                    'operator' => $operator,
                    'authorization' => [
                        'token' => $token,
                        'type' => 'bearer',
                    ],
                ], 200);
            } else {
                return response()->json([
                    'message' => 'Password incorrect',
                ], 400);
            }
        } else {
            return response()->json([
                'message' => 'Operator not found',
            ], 404);
        }
    }


    /**
     * @OA\Post(
     *      path="/api/logout",
     *      security={{"api":{}}},
     *      operationId="auth_operator_logout",
     *      tags={"1.Auth API"},
     *      summary="Logout Operator",
     *      description="Foydalanuvchini tizimdan chiqishi",
     *
     *      @OA\Response(response=200, description="Success",
     *          @OA\JsonContent(ref="#/components/schemas/Operator"),
     *      ),
     *      @OA\Response(response=404,description="Not found",
     *          @OA\JsonContent(ref="#/components/schemas/Error"),
     *      ),
     * )
     */
    public function logout()
    {
        Auth::logout();
        return response()->json([
            'message' => 'Successfully logged out',
            'code' => 200
        ]);
    }

    //    /**
    //     * @OA\Post(
    //     *      path="/api/register",
    //     *      security={{"api":{}}},
    //     *      operationId="auth_operator_register",
    //     *      tags={"1.Auth API"},
    //     *      summary="Register Operator",
    //     *      description="Foydalanuvchilarni ro'yxatdan o'tkazish",
    //     *       @OA\RequestBody(required=true, description="lesson save",
    //     *           @OA\MediaType(mediaType="multipart/form-data",
    //     *              @OA\Schema(type="object", required={"firstname", "lastname", "contact", "password"},
    //     *                 @OA\Property(property="firstname", type="string", format="text", example="Temurbek"),
    //     *                 @OA\Property(property="lastname", type="string", format="text", example="Nuriddinov"),
    //     *                 @OA\Property(property="contact", type="string", format="contact", example="998998765678"),
    //     *                 @OA\Property(property="password", type="string", format="password", example="12345678"),
    //     *              )
    //     *          )
    //     *      ),
    //     *      @OA\Response(response=200, description="Success",
    //     *          @OA\JsonContent(ref="#/components/schemas/Operator"),
    //     *      ),
    //     *      @OA\Response(response=404,description="Not found",
    //     *          @OA\JsonContent(ref="#/components/schemas/Error"),
    //     *      ),
    //     * )
    //     */
    public function register(Request $request)
    {
        $rules = [
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'contact' => 'required|string|max:255',
            'password' => 'required|string|min:6',
        ];
        $validator = new ValidatorResponse();
        $validator->check($request, $rules);
        if ($validator->fails) {
            return response()->json([
                'message' => $validator->response,
            ], 400);
        }

        Operator::create([
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
            'contact' => $request->contact,
            'password' => Hash::make($request->password),
        ]);

        $credentials = $request->only('contact', 'password');
        $token = auth('api')->attempt($credentials);
        $user = auth('api')->user();

        return response()->json([
            'data' => $user,
            'authorization' => [
                'token' => $token,
                'type' => 'bearer',
            ],
        ], 200);
    }
}
