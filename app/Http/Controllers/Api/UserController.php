<?php

namespace App\Http\Controllers\Api;
use App\Model\NewModel;
use App\Model\UserModel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    //
    public function User(Request $request)
    {
        $list=UserModel::get()->ToArray();
        $rr= json_encode($list);
        var_dump($rr);exit;

    }

    //Curl
    public  function  texturl()
    {
        $url='www.baidu.com';
        $rr=curl_init($url);
        curl_exec($rr);
        curl_close($rr);
    }


    //加密
    public function base64Test()
    {
        $str='Hello baby';
        echo base64_encode($str);
    }
    //解密
    public function base64code(Request $request){
        $base64_str=$request->input('b64');
        echo 'Base64:'.$base64_str;
        echo base64_decode($base64_str);
    }
    //post请求
    public function testpost()
    {
        $aa=file_get_contents("php://input");
        var_dump($aa);
        echo __METHOD__;
        echo print_r($_POST);
    }
    //中间件规定日期
    public function request10time()
    {
        echo __METHOD__;
    }
    
}
