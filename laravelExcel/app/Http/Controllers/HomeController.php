<?php
namespace App\Http\Controllers;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Storage;
use App\Http\Requests;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Input;
use Maatwebsite\Excel\Facades\Excel;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
class HomeController extends Controller{
    public function home(){
        return view("Home/home");
    }
    public function test(){
session_start();
        unset($_SESSION["excelPath"]);

    }
    /*
     * 上传Excel表到服务器
     */
    public function uploadExcel(Request $request){
        session_start();
        if ($request->isMethod('post')) {
            $file = $request->file("file");
            // 文件是否上传成功
            if ($file->isValid()) {

                $clientName = $file -> getClientOriginalName();//上传文件的全名.

                $tmpName = $file ->getFileName();

                $realPath = $file -> getRealPath();

                $entension = $file -> getClientOriginalExtension(); //上传文件的后缀.    

                $mimeTye = $file -> getMimeType();

                $newFile=substr($clientName,0,strrpos($clientName,".")).".";

                $fileName=substr($clientName,0,strrpos($clientName,"."));//不带后缀名的文件名

                $table_name=md5(date("is",time()).$clientName).$entension;


                $path = $file -> move(app_path().'/uploads',$table_name);
                $file=app_path().'/uploads/'.$table_name;
                if($entension=="xls"){//Excel  转变为 sql文件
                    $_SESSION["uploadExcel"]=$file;
                    $this->import($file,$table_name);
                    /*数据表创建完成*/

                    /*生成并导出sql后缀文件*/
                    $str=$this->create_sql($table_name,$newFile);
                    if($str=="success"){
                        echo "sql文件创建成功";
                    }
                }else if($entension=="sql"){//sql  文件转变为  Excel 文件
                    $_SESSION["uploadSql"]=$file;
                    if($this->uploadSql($file)){
                        if($this->export($fileName)){
                            echo "生成Excel成功";
                        }
                    }else{
                        return false;
                    }
                }
            }
        }
    }
    public function export($fileName){
        $title1=DB::select("select COLUMN_NAME from information_schema.COLUMNS where table_name = '$fileName' and table_schema = 'laravel'");//查询表头
        $title2=json_decode(json_encode($title1),true);
        foreach($title2 as $v){
            $title[]=$v['COLUMN_NAME'];
        }
        $users1=DB::select("select * from $fileName");
        $users=json_decode(json_encode($users1),true);
        $excelName=$fileName.".xls";
        $_SESSION["excelPath"]=storage_path()."/exports/".$excelName;
        //$data=array_merge($filed,$users) ;
        iconv('UTF-8', 'GBK', $fileName);
        Excel::create($fileName,function($excel) use ($users,$title){
            $excel->sheet('score', function($sheet) use ($users,$title){
                $sheet->appendRow($title);
                $sheet->rows($users);
            });
        })->store('xls')->export('xls');
        return true;
    }
    /*
     * 将sql文件导入到数据库
     */
    public function uploadSql($file){
        //读取文件内容
        $_sql = file_get_contents($file);

        $_arr = explode(';', $_sql);
        //print_r($_arr);exit;
        /*$_mysqli = new mysqli("127.0.0.1:3306","root","root","laravel");
        if (mysqli_connect_errno()) {
            exit('连接数据库出错');
        }*/
//执行sql语句
        $pdo = DB::connection()->getPdo();

        foreach ($_arr as $_value) {
            if(trim($_value)){
                $pdo->exec($_value.';');
            }
            //DB::statement();
        }
        /*$_mysqli->close();
        $_mysqli = null;*/
        return true;
    }
/*********************************************************下面是Excel转sql*****************************************************************************/

    /*
     * 读取Excel表内的数据
     */
    public function import($file,$table_name){
        $filePath = $file;
        /*Excel::load($filePath, function($reader) {
            $data = $reader->all();
            dd($data);
        });*/
        Excel::load($filePath, function($reader) use($table_name){
            //$data = $reader->all();

            //获取excel的第几张表
            $reader = $reader->getSheet(0);
            //获取表中的数据
            $data = $reader->toArray();
            //var_dump($data);exit;
            $this->create_table($table_name,$data);
        });
    }
    /*
     * 创建MySQL数据表并将 数据存入数据表
     */
    public function create_table($table_name,$arr_field)
    {

        $tmp = $table_name;
        $va = $arr_field;
        Schema::create("$tmp", function(Blueprint $table) use ($tmp,$va)
        {
            $fields = $va[0];  //列字段
            //$fileds_count =  0; //列数

            foreach($fields as $key => $value){
                if($key == 0){
                    $table->increments($fields[$key]);//->unique(); 唯一
                }else{
                    $table->string($fields[$key])->nullable();
                }
                //$fileds_count = $fileds_count + 1;
            }

        });

        $value_str= array();
        foreach($va as $key => $value){
            if($key != 0){

                $content = implode(",",$value);
                $content2 = explode(",",$content);
                foreach ( $content2 as $key => $val ) {
                    $value_str[] = "'$val'";
                }
                $news = implode(",",$value_str);
                $news = $news;
                DB::insert("insert into $tmp values ($news)");
                //$value_str = '';
                $value_str= array();

            }
        }
        return 1;
    }
    /*
     * 生成sql后缀文件
     */
    public function create_sql($table_name,$newFile){
        header("Content-type:text/html;charset=utf-8");
        //配置信息
        $cfg_dbhost = '127.0.0.1';
        $cfg_dbname = 'laravel';
        $cfg_dbuser = 'root';
        $cfg_dbpwd = 'root';
        $cfg_db_language = 'utf8';
        $to_file_name = app_path().'/sqls/'.$newFile.'sql';
        $_SESSION['sqlPath']=$to_file_name;
        if(!is_file($to_file_name)){
            if(!touch($to_file_name)){
                die("sql文件创建失败");
            }
        }
        // END 配置
        //链接数据库
        $link =@mysql_connect($cfg_dbhost,$cfg_dbuser,$cfg_dbpwd);
        mysql_select_db($cfg_dbname);
        //选择编码
        mysql_query("set names ".$cfg_db_language);
        //数据库中有哪些表
        // = @mysql_list_tables($cfg_dbname); --------------------!!!!!!!!!!
        //将这些表记录到一个数组
        $tabList = array();
        /*while($row = mysql_fetch_row($tables)){
            $tabList[] = $row[0];
        }-------------------------------------------------!!!!!!!!!!!!!!!!*/
        $tabList[]=$table_name;
        //echo "运行中，请耐心等待...<br/>";
        $info = "-- ----------------------------\r\n";
        $info .= "-- 日期：".date("Y-m-d H:i:s",time())."\r\n";
        $info .= "-- ----------------------------\r\n\r\n";
        file_put_contents($to_file_name,$info,FILE_APPEND);
        //将每个表的表结构导出到文件
        foreach($tabList as $val){
            $sql = "show create table ".$val;
            $res = mysql_query($sql,$link);
            $row = mysql_fetch_array($res);
            $info = "-- ----------------------------\r\n";
            $info .= "-- Table structure for `".$val."`\r\n";
            $info .= "-- ----------------------------\r\n";
            $info .= "DROP TABLE IF EXISTS `".$val."`;\r\n";
            $sqlStr = $info.$row[1].";\r\n\r\n";
            //追加到文件
            file_put_contents($to_file_name,$sqlStr,FILE_APPEND);
            //释放资源
            mysql_free_result($res);
        }
        //将每个表的数据导出到文件
        foreach($tabList as $val){
            $sql = "select * from ".$val;
            $res = mysql_query($sql,$link);
            //如果表中没有数据，则继续下一张表
            if(mysql_num_rows($res)<1) continue;
            //
            $info = "-- ----------------------------\r\n";
            $info .= "-- Records for `".$val."`\r\n";
            $info .= "-- ----------------------------\r\n";
            file_put_contents($to_file_name,$info,FILE_APPEND);
            //读取数据
            while($row = mysql_fetch_row($res)){
                $sqlStr = "INSERT INTO `".$val."` VALUES (";
                foreach($row as $zd){
                    $sqlStr .= "'".$zd."', ";
                }
                //去掉最后一个逗号和空格
                $sqlStr = substr($sqlStr,0,strlen($sqlStr)-2);
                $sqlStr .= ");\r\n";
                file_put_contents($to_file_name,$sqlStr,FILE_APPEND);
            }
            //释放资源
            mysql_free_result($res);
            file_put_contents($to_file_name,"\r\n",FILE_APPEND);
        }
        return $str="success";
    }
    public function downloadSql(){
        session_start();
        if(isset($_SESSION["sqlPath"])){
            $filename=$_SESSION["sqlPath"];
        }else{
            $filename=$_SESSION["excelPath"];
        }
        header("Content-Disposition:attachment;filename=".basename($filename));
//指定作为附件处理，并设置文件名
        header("Content-Length:".filesize($filename));  //指定文件的大小
        readfile($filename); //将内容输出下载
        unlink($filename);
        if(isset($_SESSION["sqlPath"])){//excelPath
            unlink($_SESSION["uploadExcel"]);
            unset($_SESSION["sqlPath"]);
        }else{
            unlink($_SESSION["uploadSql"]);
            unset($_SESSION["excelPath"]);
        }


    }
}
