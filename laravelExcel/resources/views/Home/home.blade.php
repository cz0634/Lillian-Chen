<?php session_start(); ?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <link rel="shortcut icon"  href="{{asset('static/img/logo.ico')}}"/>
    <!--[if IE]>
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <![endif]-->
    <title>Lillian-莉莉安 （病毒借眼神传播）</title>
    <!-- BOOTSTRAP CORE STYLE CSS -->
    <link href="{{asset('static/css/bootstrap.css')}}" rel="stylesheet" />
    <!-- FONTAWESOME STYLE CSS -->
    <link href="{{asset('static/css/font-awesome.css')}}" rel="stylesheet" />
    <!-- CUSTOM STYLE CSS -->
    <link href="{{asset('static/css/style.css')}}" rel="stylesheet" />
    <link href="{{asset('static/css/webuploader.css')}}" rel="stylesheet" />
    <script src="{{asset('static/js/jquery-1.7.1.min.js')}}"></script>
    <script src="{{asset('static/js/jquery.form.js')}}"></script>
    <script src="{{asset('static/js/webuploader.min.js')}}"></script>
</head>
<body>


    <section class="header-section">
        <div class="container">
            <div class="row">
                <div class="col-md-2">
                    <img src="{{asset('static/img/logo.png')}}" class="img-circle img-responsive" />
                </div>
                <div class="col-md-5 text-center">
                    <h1>陈莉莉安</h1>
                    <h4>中二PHPer & 冰原狼</h4>
                </div>
                <div class="col-md-5">
                    <h3>WHO M I :</h3>

                    I am a cz,<i>Email:<strong>cz0634@126.com</strong></i>
                </div>
            </div>
        </div>
        <div style="position: absolute;top: 0;right: 0;height: 30px;line-height: 30px;width: 100px" id="color">
            <p id="a1" style="width: 20px;height: 20px;background: #23b7ff;border-radius: 5px;display: inline-block;cursor: pointer"></p>
            <p id="a2" style="width: 20px;height: 20px;background: #ffa5c4;border-radius: 5px;display: inline-block;cursor: pointer"></p>
            <p id="a3" style="width: 20px;height: 20px;background: #ab7fbb;border-radius: 5px;display: inline-block;cursor: pointer"></p>
        </div>
    </section>
    <div class="copyrights"><a href=""></a></div>
    <hr />
    <section>
        <div class="container">
            <div class="row">
                <div class="col-md-9">
                    <div>
                        <h3>Excel、sql文件转换</h3>
                        <form action="{{url("home/uploadExcel")}}" method="post" enctype="multipart/form-data" id="uploadExcel">
                            <input type="text" name="sql_name" placeholder="此处可为空（程序员不开心，该功能不能使）" disabled style="border-radius: 5px;width:280px"/><p style="display: inline-block;">（注：不填写生成的sql文件为Excel文件名。填写后sql文件会以所填内容命名）</p>
                            <div id="uploader" class="wu-example" style="margin-top: 30px">
                                <!--用来存放文件信息-->
                                <div id="thelist" class="uploader-list"></div>
                                <div class="btns">
                                    <div id="picker" style="display: inline-block;vertical-align: middle">选择xls/sql后缀文件</div>
                                    <button type="button" id="ctlBtn" class="btn btn-default" style="display: inline-block;margin-left: 20px">开始上传</button>
                                </div>
                            </div>
                        </form>

                        <a href="{{url("home/downloadSql")}}" @if(!empty($_SESSION["sqlPath"]) || !empty($_SESSION["excelPath"]))
                                                                    style="display: block;text-decoration-line: none"
                                                                  @else
                                                                  style="display: none;text-decoration-line: none"
                                                                @endif id="sqlDownload">点击下载文件</a>

                    </div>
                    <hr />
                    <div>
                        <h3><a style="cursor: pointer;text-decoration-line: none" onclick="show()">使用说明</a></h3>
                        <div style="display: none" id="show">
                        <h4><b>一、上传sql后缀的Mysql文件，获取带有数据的Excel文件</b></h4>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;sql文件必须为一张表的sql文件，如果是整个数据库的sql文件你也可以试一试。不过我还没试过<br/>
                        <b>示例图：(一张member表的sql文件)</b><br/>
                        <img src="{{asset('static/img/member.png')}}" alt="一张member表的sql文件"/>

                        <h4><b>二、上传xls后缀的Excel文件，获取带有数据的sql文件</b></h4>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Excel文件必须为xls后缀文件，内容要求：按照下图就不会出错<br/>
                        <b>示例图：(一张shop表的xls文件)</b><br/>
                        <img src="{{asset('static/img/error.png')}}" alt="错误示例" style="width: 85%"/>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <ul class="list-group">
                        <li class="list-group-item">
                            <strong>laravel文件上传教程</strong>
                        </li>
                        <li class="list-group-item">
                            <span class="badge">104</span>
                            文件上传类
                        </li>
                        <li class="list-group-item">
                            <span class="badge">34</span>
                            PHPExcel
                        </li>
                        <li class="list-group-item">
                            <span class="badge">10</span>
                            我快编不下去了
                        </li>
                        <li class="list-group-item">
                            <span class="badge">50</span>
                            其实
                        </li>
                        <li class="list-group-item">
                            <strong>Laravel数据库的导入和导出</strong>
                        </li>
                        <li class="list-group-item">
                            <span class="badge">104</span>
                            这些都是
                        </li>
                        <li class="list-group-item">
                            <span class="badge">34</span>
                            假的
                        </li>
                        <li class="list-group-item">
                            <span class="badge">10</span>
                            连接
                        </li>
                        <li class="list-group-item">
                            <span class="badge">50</span>
                            根本没有教程
                        </li>
                    </ul>
                    <br />
                </div>
            </div>
        </div>
    </section>
    <br/>
    <br/>
    <br/>
    <hr style="color: #204d74"/>
    <div class="container">
        <div class="row">
            <div class="col-md-12 text-center set-foot">
                &copy<a href="http://www.miitbeian.gov.cn" target="_blank" title="" style="text-decoration-line: none;color: #272525">豫ICP备17031656号</a>  （Excel、sql文件<b>转换站</b>）
            </div>
        </div>
    </div>

</body>
<script>
    var uploader = WebUploader.create({
        // swf文件路径
        swf: "{{asset('static/js/Uploader.swf')}}",

        // 文件接收服务端。
        server: "{{url("home/uploadExcel")}}",

        // 选择文件的按钮。可选。
        // 内部根据当前运行是创建，可能是input元素，也可能是flash.
        pick: '#picker',

        // 不压缩image, 默认如果是jpeg，文件上传前会压缩一把再上传！
        resize: false,
        method: 'POST'
    });
    uploader.on( 'fileQueued', function( file ) {
        $("#thelist").append( '<div id="' + file.id + '" class="item">' +
        '<h4 class="info">' + file.name + '</h4>' +
        '<p class="state">等待上传...</p>' +
        '</div>' );
    });
    uploader.on( 'uploadProgress', function( file, percentage ) {
        var $li = $( '#'+file.id ),
                $percent = $li.find('.progress .progress-bar');

        // 避免重复创建
        if ( !$percent.length ) {
            $percent = $('<div class="progress progress-striped active">' +
            '<div class="progress-bar" role="progressbar" style="width: 0%">' +
            '</div>' +
            '</div>').appendTo( $li ).find('.progress-bar');
        }

        $li.find('p.state').text('上传中');

        $percent.css( 'width', percentage * 100 + '%' );
    });
    uploader.on( 'uploadSuccess', function( file ) {
        $( '#'+file.id ).find('p.state').text('已上传');
    });

    uploader.on( 'uploadError', function( file ) {
        $( '#'+file.id ).find('p.state').text('上传出错');
    });

    uploader.on( 'uploadComplete', function( file ) {
        $( '#'+file.id ).find('.progress').fadeOut();
    });
    /*提交并显示下载连接*/
    $("#ctlBtn").click(function(){
        uploader.upload();

        begin=setInterval(state,1000)

    })
    function state(){
        if($(".state").html()=="等待上传..."){
            $("#sqlDownload").css("display","none")
            console.log('等待上传...')
        }else if($(".state").html()=="上传中"){
            $("#sqlDownload").css("display","none")
            console.log("上传中")
        }else if($(".state").html()=="已上传"){
            $("#sqlDownload").css("display","block")
            console.log("已上传")
            clearInterval(begin)
        }
    }
    $("#sqlDownload").click(function(){
        $("#sqlDownload").css("display","none")
        $(".state").html("已下载")
    })
    /*提交并显示下载连接end*/
    function show(){
        if($("#show").css("display")=="none"){
            $("#show").css("display","block");
        }else{
            $("#show").css("display","none");
        }
    }
</script>
</html>
