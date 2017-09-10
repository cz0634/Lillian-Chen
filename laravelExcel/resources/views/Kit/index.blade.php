<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>注册页面</title>
    <style>
        p>label{
            text-align-last: justify;
        }
    </style>
</head>
<body>
<form action="{{url("Kit/login")}}" method="get">
    <p><label for="">用户名：</label><input type="text" name="user_name"/></p>
    <p><label for="">密码：</label><input type="password" name="password"/></p>
    <p><label for="">验证码:</label><input type="text" name="verify"/><img src="{{url("Kit/verify/1")}}" alt="" onclick="javascript:this.src='{{url("Kit/verify")}}/'+Math.random(0,3)"/></p>

    <p><input type="submit" value="提交"/></p>
</form>
</body>
</html>