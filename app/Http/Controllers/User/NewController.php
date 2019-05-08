<?php

namespace App\Http\Controllers\User;
use Illuminate\Support\Facades\Redis;
use Illuminate\Http\Request;
use App\Model\NewModel;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
class NewController extends Controller
{
    //注册
    public function reg(Request $request)
    {
        $pass1=$request->input('pass1');
        $pass2=$request->input('pass2');
        $email=$request->input('email');
        if ($pass1 !=$pass2){
            $response=[
                'error'=>50002,
                'msg'=>'两次输入密码不一致'
            ];
        die(json_encode($response,JSON_UNESCAPED_UNICODE));
        }
        //验证邮箱是否唯一
        $emi=NewModel::where(['email'=>$email])->first();
       //var_dump($emi);exit;
        if($emi){
            $response=[
                'error'=>50004,
                'msg'=>'邮箱已存在'
            ];
            die(json_encode($response,JSON_UNESCAPED_UNICODE));
        }
        //密码加密处理
        $pass=password_hash($pass1,PASSWORD_BCRYPT);

        $data=[
            'name'=>$request->input('name'),
            'email'=>$email,
            'pass'=>$pass,
            'age'=>$request->input('age'),
            'add_time'=>time()
        ];
        //存入数据库
        $niu=NewModel::insertGetId($data);
        if($niu){
            $response=[
                'error'=>6,
                'msg'=>'注册成功'
            ];
        }else{
            $response=[
                'error'=>50013,
                'msg'=>'注册失败'
            ];
        }
        die(json_encode($response,JSON_UNESCAPED_UNICODE));
    }




    //登录
    public function login(Request $request)
    {
        $email=$request->input('email');
        $pass=$request->input('pass');
        $u=NewModel::where(['email'=>$email])->first();
        if($u){
            if(password_verify($pass,$u->pass)){
                $token=$this->logintoken($u->id);
                $redis_token_key='logintokens:id'.$u->id;
                Redis::set($redis_token_key,$token);
                Redis::expire($redis_token_key,604800);

            //生成token
                $response=[
                    'error'=>0,
                    'msg'=>'OK',
                    'data'=>[
                        'token'=>$token,
                    ],
                ];

            }else{
                $response=[
                    'error'=>50014,
                    'msg'=>'密码不正确',
                ];
            }
            die(json_encode($response,JSON_UNESCAPED_UNICODE));
        }else{
            //用户存在不存在
            $response=[
                'error'=>50019,
                'msg'=>'用户不存在',
            ];
            die(json_encode($response,JSON_UNESCAPED_UNICODE));
        }
    }
    public function logintoken($id)
    {
        return substr(sha1($id.time().Str::random(10)),5,15);
    }
    //个人中心
    public function rddlogin(){
        echo __METHOD__;
    }
}
