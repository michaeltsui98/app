<?php

class Models_Test extends Cola_Model
{

    function pdf2img ($pdf_path)
    {
        if (! $pdf_path) {
            $pdf_path = "test/34.pdf";
        }
        $im = new Imagick();
        $im->setResolution(100, 100);
        $pdf = S_ROOT . $pdf_path;
        $im->readImage($pdf);
        $imgs = array();
        $pdf_name = pathinfo($pdf, PATHINFO_FILENAME);
        if (! is_dir('/tmp/png_tmp')) {
            mkdir('/tmp/png_tmp');
        }
        $im->setimageformat('jpeg');
        $im->setcompression(Imagick::COMPRESSION_JPEG);
        $im->setcompressionquality(100);
        foreach ($im as $key => $var) {
            $filename = S_ROOT . 'test/png_tmp/' . $pdf_name . "_" . $key .
                     '.jpeg';
            if ($var->writeImage($filename) == true) {
                $imgs[] = $filename;
            }
        }
        return $imgs;
    }
    
    function img2zip ()
    {
        $path = S_ROOT.'test/png_tmp/';
        $zip=new ZipArchive();
        $zip_file = $path.'images.zip';
        if($zip->open($path.'images.zip', ZipArchive::OVERWRITE)=== TRUE){
            $this->addFileToZip($path, $zip); //调用方法，对要打包的根目录进行操作，并将ZipArchive的对象传递给方法
            $zip->close(); //关闭处理的zip文件
        }
        //zip 上传到mogfils
        
        //清空png_tmp目录
        
    }
    
    function addFileToZip($path,$zip){
        $handler=opendir($path); //打开当前文件夹由$path指定。
        while(($filename=readdir($handler))!==false){
            if($filename != "." && $filename != ".."){//文件夹文件名字为'.'和‘..’，不要对他们进行操作
                if(is_dir($path."/".$filename)){// 如果读取的某个对象是文件夹，则递归
                    $this->addFileToZip($path."/".$filename, $zip);
                }else{ //将文件加入zip对象
                    $zip->addFile($path."/".$filename,$filename);
                }
            }
        }
        closedir($handler);
    }
}
