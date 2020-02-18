<?php
namespace App\Http\Controllers\API;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Support\Facades\Auth;
use Validator;
class UserController extends Controller
{
public $successStatus = 200;
/**
     * login api
     *
     * @return \Illuminate\Http\Response
     */
    public function login(){
        if(Auth::attempt(['email' => request('email'), 'password' => request('password')])){
            $user = Auth::user();
            $success['token'] =  $user->createToken('MyApp')-> accessToken;
            return response()->json(['success' => $success], $this-> successStatus);
        }
        else{
            return response()->json(['error'=>'Unauthorised'], 401);
        }
    }
/**
     * Register api
     *
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'c_password' => 'required|same:password',
        ]);
        if ($validator->fails()) {
                    return response()->json(['error'=>$validator->errors()], 401);
                }
        $input = $request->all();
                $input['password'] = bcrypt($input['password']);
                $user = User::create($input);
                $success['token'] =  $user->createToken('MyApp')-> accessToken;
                $success['name'] =  $user->name;
return response()->json(['success'=>$success], $this-> successStatus);
    }
/**
     * details api
     *
     * @return \Illuminate\Http\Response
     */
    public function details()
    {
        $user = Auth::user();
        return response()->json(['success' => $user], $this-> successStatus);
    }


//    private function CurlCommerce($endpoint ,$body, $header, $method){
//
//    }


    private function getProdutos($page){
        $ch = curl_init();
        $url='https://192.168.1.30/allprint/wp-json/wc/v3/products?page='.$page;
        $username='ck_6e9acc4725d6cfbad340e3144e60f8e97c5ffec6';
        $password='cs_bda2d8d9f18dc4de1ac30d83f28e256e307b1146';
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_USERPWD, "$username:$password");
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $output = curl_exec($ch);
        $info = curl_getinfo($ch);
        curl_close($ch);
        return $output;
    }

    public function testeProdutos($page){
        $data = array();
        $prd = $this->getProdutos($page);

        foreach(json_decode($prd) as $produto)
        {

            $tag=array();

            foreach($produto->tags as $ta)
            {
                if($ta->id == '122') array_push($tag,$ta);
            }
            array_push($data,array('id'=>$produto->sku,
                'name'=>$produto->name,
                'price'=>$produto->price,
                'category'=>'cenas',
                'image'=>str_replace('https://localhost/','http://188.82.110.18/',$produto->images[0]->src)));
        }
        return $data;
    }

//    public function testeProdutos($page){
//        $data = array();
//        $prd = $this->getProdutos($page);
//
//        foreach(json_decode($prd) as $produto)
//        {
//
//            $tag=array();
//
//            foreach($produto->tags as $ta)
//            {
//                if($ta->id == '122') array_push($tag,$ta);
//            }
//            array_push($data,array('id'=>$produto->id,
//                'name'=>$produto->name,
//                'status'=>$produto->status,
//                'sku'=>$produto->sku,
//                'tags'=>$tag,
//                'images'=>$produto->images));
//        }
//        return $data;
//    }
}
