<?php

namespace App\Http\Middleware;
use Illuminate\Support\Facades\Redis;
use Closure;

class RddLogin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $token=$request->input('token');
        $id=$request->input('id');
        if(empty($token)||empty($id)){
            $response=[
                'error'=>50326,
                'msg'=>'参数不完整'
            ];
            die(json_encode($response,JSON_UNESCAPED_UNICODE));
        }
        //判断是否能效
        $key='logintokens:id'.$request->input('id');
//        echo $key;'<br>';
        $token_login=Redis::get($key);
        //var_dump($token);
        if($token_login){
            if($token==$token_login){

            }else{
                $response=[
                    'error'=>40026,
                    'msg'=>'无效的token'
                ];
                die(json_encode($response,JSON_UNESCAPED_UNICODE));
            }
        }else{
            $response=[
                'error'=>40009,
                'msg'=>'请先登录'
            ];
            die(json_encode($response,JSON_UNESCAPED_UNICODE));
        }


        return $next($request);
    }
}
