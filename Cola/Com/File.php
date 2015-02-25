<?php
/**
 * 文件系统
 */
class Cola_Com_File  {

    /**
     * 文件后缀对应的文件类型
     * @var array
     */
    public static $mimetypes  = array(
        'ez' => 'application/andrew-inset',
        'hqx' => 'application/mac-binhex40',
        'cpt' => 'application/mac-compactpro',
        'doc' => 'application/msword',
        'bin' => 'application/octet-stream',
        'dms' => 'application/octet-stream',
        'lha' => 'application/octet-stream',
        'lzh' => 'application/octet-stream',
        'exe' => 'application/octet-stream',
        'class' => 'application/octet-stream',
        'so' => 'application/octet-stream',
        'dll' => 'application/octet-stream',
        'oda' => 'application/oda',
        'pdf' => 'application/pdf',
        'ai' => 'application/postscript',
        'eps' => 'application/postscript',
        'ps' => 'application/postscript',
        'smi' => 'application/smil',
        'smil' => 'application/smil',
        'mif' => 'application/vnd.mif',
        'xls' => 'application/vnd.ms-excel',
        'ppt' => 'application/vnd.ms-powerpoint',
        'wbxml' => 'application/vnd.wap.wbxml',
        'wmlc' => 'application/vnd.wap.wmlc',
        'wmlsc' => 'application/vnd.wap.wmlscriptc',
        'bcpio' => 'application/x-bcpio',
        'vcd' => 'application/x-cdlink',
        'pgn' => 'application/x-chess-pgn',
        'cpio' => 'application/x-cpio',
        'csh' => 'application/x-csh',
        'dcr' => 'application/x-director',
        'dir' => 'application/x-director',
        'dxr' => 'application/x-director',
        'dvi' => 'application/x-dvi',
        'spl' => 'application/x-futuresplash',
        'gtar' => 'application/x-gtar',
        'hdf' => 'application/x-hdf',
        'js' => 'application/x-javascript',
        'skp' => 'application/x-koan',
        'skd' => 'application/x-koan',
        'skt' => 'application/x-koan',
        'skm' => 'application/x-koan',
        'latex' => 'application/x-latex',
        'nc' => 'application/x-netcdf',
        'cdf' => 'application/x-netcdf',
        'sh' => 'application/x-sh',
        'shar' => 'application/x-shar',
        'swf' => 'application/x-shockwave-flash',
        'sit' => 'application/x-stuffit',
        'sv4cpio' => 'application/x-sv4cpio',
        'sv4crc' => 'application/x-sv4crc',
        'tar' => 'application/x-tar',
        'tcl' => 'application/x-tcl',
        'tex' => 'application/x-tex',
        'texinfo' => 'application/x-texinfo',
        'texi' => 'application/x-texinfo',
        't' => 'application/x-troff',
        'tr' => 'application/x-troff',
        'roff' => 'application/x-troff',
        'man' => 'application/x-troff-man',
        'me' => 'application/x-troff-me',
        'ms' => 'application/x-troff-ms',
        'ustar' => 'application/x-ustar',
        'src' => 'application/x-wais-source',
        'xhtml' => 'application/xhtml+xml',
        'xht' => 'application/xhtml+xml',
        'zip' => 'application/zip',
        'au' => 'audio/basic',
        'snd' => 'audio/basic',
        'mid' => 'audio/midi',
        'midi' => 'audio/midi',
        'kar' => 'audio/midi',
        'mpga' => 'audio/mpeg',
        'mp2' => 'audio/mpeg',
        'mp3' => 'audio/mpeg',
        'aif' => 'audio/x-aiff',
        'aiff' => 'audio/x-aiff',
        'aifc' => 'audio/x-aiff',
        'm3u' => 'audio/x-mpegurl',
        'ram' => 'audio/x-pn-realaudio',
        'rm' => 'audio/x-pn-realaudio',
        'rpm' => 'audio/x-pn-realaudio-plugin',
        'ra' => 'audio/x-realaudio',
        'wav' => 'audio/x-wav',
        'pdb' => 'chemical/x-pdb',
        'xyz' => 'chemical/x-xyz',
        'bmp' => 'image/bmp',
        'gif' => 'image/gif',
        'ief' => 'image/ief',
        'jpeg' => 'image/jpeg',
        'jpg' => 'image/jpeg',
        'jpe' => 'image/jpeg',
        'png' => 'image/png',
        'tiff' => 'image/tiff',
        'tif' => 'image/tiff',
        'djvu' => 'image/vnd.djvu',
        'djv' => 'image/vnd.djvu',
        'wbmp' => 'image/vnd.wap.wbmp',
        'ras' => 'image/x-cmu-raster',
        'pnm' => 'image/x-portable-anymap',
        'pbm' => 'image/x-portable-bitmap',
        'pgm' => 'image/x-portable-graymap',
        'ppm' => 'image/x-portable-pixmap',
        'rgb' => 'image/x-rgb',
        'xbm' => 'image/x-xbitmap',
        'xpm' => 'image/x-xpixmap',
        'xwd' => 'image/x-xwindowdump',
        'igs' => 'model/iges',
        'iges' => 'model/iges',
        'msh' => 'model/mesh',
        'mesh' => 'model/mesh',
        'silo' => 'model/mesh',
        'wrl' => 'model/vrml',
        'vrml' => 'model/vrml',
        'css' => 'text/css',
        'html' => 'text/html',
        'htm' => 'text/html',
        'asc' => 'text/plain',
        'txt' => 'text/plain',
        'rtx' => 'text/richtext',
        'rtf' => 'text/rtf',
        'sgml' => 'text/sgml',
        'sgm' => 'text/sgml',
        'tsv' => 'text/tab-separated-values',
        'wml' => 'text/vnd.wap.wml',
        'wmls' => 'text/vnd.wap.wmlscript',
        'etx' => 'text/x-setext',
        'xsl' => 'text/xml',
        'xml' => 'text/xml',
        'mpeg' => 'video/mpeg',
        'mpg' => 'video/mpeg',
        'mpe' => 'video/mpeg',
        'qt' => 'video/quicktime',
        'mov' => 'video/quicktime',
        'mxu' => 'video/vnd.mpegurl',
        'avi' => 'video/x-msvideo',
        'movie' => 'video/x-sgi-movie',
        'ice' => 'x-conference/x-cooltalk',
        'xlsx' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        'xltx' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.template',
        'potx' => 'application/vnd.openxmlformats-officedocument.presentationml.template',
        'ppsx' => 'application/vnd.openxmlformats-officedocument.presentationml.slideshow',
        'pptx' => 'application/vnd.openxmlformats-officedocument.presentationml.presentation',
        'sldx' => 'application/vnd.openxmlformats-officedocument.presentationml.slide',
        'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
        'dotx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.template',
        'xlam' => 'application/vnd.ms-excel.addin.macroEnabled.12',
        'xlsb' => 'application/vnd.ms-excel.sheet.binary.macroEnabled.12',
        'flv'=>'application/x-shockwave-flash',
        'mp4' => 'video/mp4',
    );

    private $_config = null;

    private $_mogilefs = null;

    public static function factory($config){
        return new self($config);
    }

    /**
     * 文件下载
     */
    public function download($file, $filename){
        $mogilefs = new Cola_Com_Mogilefs($this->_mogilefs['domain'], $this->_mogilefs['class'], $this->_mogilefs['trackers']);

        if($mogilefs->exists($file)){
            $fileInfo = $mogilefs->fileinfo($file);
            $pathinfo = pathinfo($file);
            $mimetypes = self::$mimetypes;
            //根据文件后缀获取文件类型
            header("Content-type:{$mimetypes[strtolower($pathinfo['extension'])]}");
            header("Accept-Ranges:bytes");
            header("Accept-Length:{$fileInfo['length']}");
            header("Content-Disposition:attachment;filename={$filename}");

            //注意这里一定要使用echo输出，否则下载的文件为空
            echo $mogilefs->get($file);
        } else {
            die('文件不存在');
        }
    }

    /**
     * 删除附件
     * @param $file
     * @return bool
     */
    public function delete($file){
        $mogilefs = new Cola_Com_Mogilefs($this->_mogilefs['domain'], $this->_mogilefs['class'], $this->_mogilefs['trackers']);
        try{
            return $mogilefs->delete($file);
        }catch (Exception $e){
            // 记录错误以后，仍返回成功
            $this->_logError($e);
            return true;
        }
    }

    /**
     * 文件上传
     * @param array $file
     * @param $dir
     */
    public function upload(array $file, $dir, $fileinfo = NULL){
        $uploader = $this->getUploader();

        if($fileinfo === NULL){
            $fileinfo = $this->_makeFilename($file, $dir);
        }

        // 如果上传成功,则返回附件的名称
        if($uploader->saveToMogilefs($file, $fileinfo['url'])){

            return $fileinfo;

            // 如果上传失败则显示错误信息，同时终止执行不在将数据写入数据库
        } else {
            $this->_logError(current($uploader->error()));
            return false;
        }
    }

    public function getImageSize($filename){
        $uploader = $this->getUploader();
        return $uploader->getImageSize($filename);
    }

    private function getUploader(){
        static $uploader = NULL;
        if(!$uploader){
            $uploader = new Cola_Com_Upload($this->_config);
        }
        return $uploader;
    }

    /**
     * 生成文件名称
     * @param $file
     * @param $dir
     * @return array
     */
    private function _makeFilename($file, $dir){
        $fileinfo = pathinfo($file['name']);
        $url = uniqid();
        return array(
            'url' => $dir.'/'.$url.'.'.$fileinfo['extension'],
            'filename' => $fileinfo['basename'],
            'ext' => $fileinfo['extension'],
        );
    }

    /**
     * 获取配置信息
     * @param $config
     */
    private function __construct($config){
        $this->_mogilefs = $this->_config = Cola::getInstance()->getConfig($config);
        if(isset($this->_config['mogilefs'])){
            $this->_mogilefs = $this->_config['mogilefs'];
        }
    }
}