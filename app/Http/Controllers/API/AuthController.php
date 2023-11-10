<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\ValidatorResponse;
use App\Models\Admin;
use App\Models\User;
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
     *      operationId="auth_admin_login",
     *      tags={"1.Auth API"},
     *      summary="Login Admin",
     *      description="Login Parol yordamida kirish Adminlar uchun",
     *       @OA\RequestBody(required=true, description="lesson save",
     *           @OA\MediaType(mediaType="multipart/form-data",
     *              @OA\Schema(type="object", required={"username", "password"},
     *                 @OA\Property(property="username", type="string", format="username", example="@admin123"),
     *                 @OA\Property(property="password", type="string", format="password", example="admin123"),
     *              )
     *          )
     *      ),
     *      @OA\Response(response=200, description="Success",
     *          @OA\JsonContent(ref="#/components/schemas/Admin"),
     *      ),
     *      @OA\Response(response=404,description="Not found",
     *          @OA\JsonContent(ref="#/components/schemas/Error"),
     *      ),
     * )
     */
    public function login(Request $request)
    {
        $rules = [
            'username' => 'required|string',
            'password' => 'required|string',
        ];
        $validator = new ValidatorResponse();
        $validator->check($request, $rules);
        if ($validator->fails) {
            return response()->json([
                'message' => $validator->response,

            ], 400);
        }

        $model = Admin::where('username', $request->username)->first();
        if ($model) {
            if (Hash::check($request->password, $model->password)) {
                $credentials = $request->only('username', 'password');
                $token = auth('api')->attempt($credentials);
                $admin = auth('api')->user();
                return response()->json([
                    'admin' => $admin,
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
                'message' => 'Admin not found',
            ], 404);
        }
    }


    /**
     * @OA\Post(
     *      path="/api/logout",
     *      security={{"api":{}}},
     *      operationId="auth_admin_logout",
     *      tags={"1.Auth API"},
     *      summary="Logout Admin",
     *      description="Foydalanuvchini tizimdan chiqishi",
     *
     *      @OA\Response(response=200, description="Success",
     *          @OA\JsonContent(ref="#/components/schemas/Admin"),
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
//     *      operationId="auth_admin_register",
//     *      tags={"1.Auth API"},
//     *      summary="Register Admin",
//     *      description="Foydalanuvchilarni ro'yxatdan o'tkazish",
//     *       @OA\RequestBody(required=true, description="lesson save",
//     *           @OA\MediaType(mediaType="multipart/form-data",
//     *              @OA\Schema(type="object", required={"firstname", "lastname", "username", "password"},
//     *                 @OA\Property(property="firstname", type="string", format="text", example="Temurbek"),
//     *                 @OA\Property(property="lastname", type="string", format="text", example="Nuriddinov"),
//     *                 @OA\Property(property="username", type="string", format="username", example="@admin123"),
//     *                 @OA\Property(property="password", type="string", format="password", example="admin123"),
//     *              )
//     *          )
//     *      ),
//     *      @OA\Response(response=200, description="Success",
//     *          @OA\JsonContent(ref="#/components/schemas/Admin"),
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
            'username' => 'required|string|max:255',
            'password' => 'required|string|min:6',
        ];
        $validator = new ValidatorResponse();
        $validator->check($request, $rules);
        if ($validator->fails) {
            return response()->json([
                'message' => $validator->response,
            ], 400);
        }

        Admin::create([
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
            'username' => $request->username,
            'password' => Hash::make($request->password),
        ]);

        $credentials = $request->only('username', 'password');
        $token = auth('api')->attempt($credentials);
        $user = auth('api')->user();

        return response()->json([
            'data' => $user,
            'authorization' => [
                'token' => $token,
                'type' => 'bearer',
            ],
        ], 200  );
    }
}
