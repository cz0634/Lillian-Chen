<?php
namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use Gregwar\Captcha\CaptchaBuilder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
class KitController extends Controller{
    public function index(){
        return view("Kit/index");
    }
    public function login(Request $request){
        session_start();
        $user_name=$request->input("user_name");
        $password=$request->input("password");
        if($request->input("verify")==$_SESSION["verify"]){
            $results=DB::select("select * from user where user_name=? and password=?",array($user_name,$password));
            if(empty($results)){
                echo "用户名或密码不正确";
            }else{

                echo "登陆成功";
            }
        }else{
            echo "验证码不正确";
        }
    }
    public function verify($num){
        session_start();
        ob_get_clean();
        $builder=new CaptchaBuilder;
        $builder->build($width=100,$height=40,$font=null);
        $phrase=$builder->getPhrase();
        $_SESSION["verify"]=$phrase;
        header("Cache-Control: no-cache, must-revalidate");
        header('Content-Type: image/jpeg');
        $builder->output();
    }
}