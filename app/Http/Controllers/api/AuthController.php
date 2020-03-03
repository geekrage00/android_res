<?php

namespace App\Http\Controllers\api;

use App\Merchant;
use App\Product;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use Laravel\Passport\Client;
use Illuminate\Http\Request;
use App\Http\Controllers\api\ResponseController as ResponseController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\User;
use Illuminate\Support\Facades\Validator;

class AuthController extends ResponseController
{
    private  $client;
    public function __construct()
    {
        $this->client = Client::find(2);
    }

    //
    public function signup(Request $r){
        $validator = Validator::make($r->all(),[
            'first_name'=>'bail|required|string',
            'last_name'=>'bail|required|string',
            'email'=>'bail|required|string|email|unique:users',
            'password'=>'required|min:8',
            'confirm_password'=>'required|same:password',
        ]);

        if($validator->fails()){
            return $this->sendError($validator->errors());
        }
        $input = $r->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);
        if($r->merchant_name){
            Merchant::create([
                'merchantName'=>$r->merchant_name,
                'merchantSlug'=>Str::slug($r->merchant_name),
                'user_id'=>$user->id
            ]);
        }

        $params = [
            'grant_type'=>'password',
            'client_id'=>$this->client->id,
            'client_secret'=>$this->client->secret,
            'username'=>request('email'),
            'password'=>request('password'),
            'scope'=>'*'
        ];

        $r->request->add($params);

        $proxy = Request::create('oauth/token','POST');

        return Route::dispatch($proxy);

       /* if($user){
            $response["code"]=200;
            $response['token']=$user->createToken('token')->accessToken;
            $response['message']="Registration Successfull";
            return $this->sendResponse($response);
        }else{
            $error = "Sorry! Registration is not successfull.";
            return $this->sendError($error, 401);
        }*/

    }

        public function login(Request $request)
        {
            $validator = Validator::make($request->all(), [
                'email' => 'required|string|email',
                'password' => 'required|min:8'
            ]);

            if($validator->fails()){
                return $this->sendError($validator->errors());
            }

            $scope = 'buy';

            $credentials = request(['email', 'password']);
            if(!Auth::attempt($credentials)){
                $error = "Unauthorized";
                return $this->sendError($error, 401);
            }
            else{
                $user = Auth::user();
                if($user->isMerchant){
                    $scope = 'do-anything';
                }
                else{
                    $scope = 'buy';
                }
            }

            $params = [
                'grant_type'=>'password',
                'client_id'=>$this->client->id,
                'client_secret'=>$this->client->secret,
                'username'=>request('email'),
                'password'=>request('password'),
                'scope'=>$scope
            ];

            $request->request->add($params);

            $proxy = Request::create('oauth/token','POST');

            return Route::dispatch($proxy);
        }

        //logout
        public function logout(Request $request)
        {
            $accessToken = Auth::user()->token();

            DB::table('oauth_refresh_tokens')
                ->where('access_token_id',$accessToken->id)
                ->update(['revoke'=>true]);

            $accessToken->revoke();

            return response()->json([],204);

        }

        public function refresh(Request $request){
            $validator = Validator::make($request->all(), [
               'refresh_token'=>'required'
            ]);

            if($validator->fails()){
                return $this->sendError($validator->errors());
            }

            $params = [
                'grant_type'=>'refresh_token',
                'client_id'=>$this->client->id,
                'client_secret'=>$this->client->secret,
                'username'=>request('email'),
                'password'=>request('password'),
                'scope'=>'*'
            ];

            $request->request->add($params);

            $proxy = Request::create('oauth/token','POST');

            return Route::dispatch($proxy);
        }

        //getuser
        public function getUser(Request $request)
        {
            //$id = $request->user()->id;
            $user = $request->user();
            if($user->isMerchant){
                $products = Product::where('merchantId',$user->merchant->merchantId)->get();
                $response =[
                    'code'=>200,
                    'user'=>$user,
                    'merchant'=>$user->merchant,
                    'products'=>$products
                    ];
                return $this->sendResponse($response);
            }
            elseif(!$user->isMerchant){
                return $this->sendResponse($user);
            }
            else{
                $error = "user not found";
                return $this->sendResponse($error);
            }
        }
}
