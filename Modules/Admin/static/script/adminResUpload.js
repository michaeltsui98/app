var sid = $("input[name='param']").attr("data-sid")
var file_type = eval('(' + $("input[name='param']").attr("data-type") + ')');

var ajaxJSONP = function (url, data, callback) {
    $.ajax({
        type: "get",
        async: false,
        url: url,
        data: data,
        dataType: "jsonp",
        jsonp: "callback",//传递给请求处理程序或页面的，用以获得jsonp回调函数名的参数名(一般默认为:callback)
        success: function (json) {
            callback(json);
        },
        error: function () {
            alert('fail');
        }
    });
};

var resParams = {
    fileType: file_type,
    initUpload: function (options) {
        var settings = {
            path: '/static/',
            divId: 'demo2',
            formId: 'input2',
            tipId: 'tip2',
            upText: '上传资源',
            upMax: 1,//允许上传是文件数量 默认1个
            upMaxsize: 1024 * 1024 * 1000,
            upFilter: resParams.fileType[1],
            upImageFile: 1,//是否文件方式上传
            upUrl: commonParams.wenkuPath + '/Upload/resUpload?PHPSESSID=' + sid,
            upProgressTip: '已上传：{progress}',
            skin: '/static/syup/skin/green',
            upCallback: 'resParams.uploadCallback'
        }
        $.extend(settings, options || {});
        //加载上传flash
        new syup({
            path: settings.path,
            div_id: settings.divId,
            form_id: settings.formId,
            tip_id: settings.tipId,
            up_text: settings.upText,
            up_max: settings.upMax,//允许上传是文件数量 默认1个
            up_maxsize: settings.upMaxsize,
            up_filter: settings.upFilter,
            up_image_file: settings.upImageFile,//是否文件方式上传
            up_url: settings.upUrl,
            up_progress_tip: settings.upProgressTip,
            skin: settings.skin,
            up_callback: settings.upCallback
        }).show();
    },
    uploadCallback: function (up_obj, type, str) {
        if (type == 'file_select') {
            //document.getElementById(up_obj.form_id).value = str;
        }
        if (type == 'one_complete') {
            var data = eval('(' + str + ')');
            //for (var key in data) {
            //    document.getElementById(up_obj.form_id).value = key + "," + data[key];
            //    $("input[name='data[doc_title]']").val(data[key]);
            //}
            document.getElementById(up_obj.form_id).value = data.file_path + "," + data.file_name;
            document.getElementById("file_size").value = data.size;
            $("input[name='data[doc_title]").val(data.file_name);
            //var obj = document.getElementById(up_obj.tip_id);
            //obj.innerHTML = "上传成功";
        }
        if (type == 'progress') {
            //var obj = document.getElementById(up_obj.tip_id);
            //obj.innerHTML = str;
        }
        if (type == 'error') {
            //var obj = document.getElementById(up_obj.tip_id);
            //obj.innerHTML = str;
        }
        if (type == 'start') {

        }
    }
}

resParams.initUpload();
$("#cate_id").unbind().bind("change", function () {
    var typeId = $(this).find("option:selected").val();

    resParams.initUpload({ upFilter: resParams.fileType[typeId] });

    $("#tip2").next("div.info").css("display", "block");
    $("#tip2").next("div.info").find("span").html(resParams.fileType[typeId]);

    if (typeId == "5" || typeId == "6") {
        $("#div_vid").css("display", "block");
        $("#div_vid").find("#vid")[0].removeAttribute("ignore");
        $("#div_vid").find("#vid").attr("datatype", "*");
    }
    else {
        $("#div_vid").find("#vid")[0].removeAttribute("datatype");
        $("#div_vid").find("#vid").attr("ignore", "ignore");
        $("#div_vid").css("display", "none");
    }
});



//var swfu;

//var Uploader = {
//    getFileSize: function (num) {
//        if (isNaN(num)) {
//            return false;
//        }
//        num = parseInt(num);
//        var units = [" B", " KB", " MB", " GB"];
//        for (var i = 0; i < units.length; i += 1) {
//            if (num < 1024) {
//                num = num + "";
//                if (num.indexOf(".") != -1 && num.indexOf(".") != 3) {
//                    num = num.substring(0, 4);
//                } else {
//                    num = num.substring(0, 3);
//                }
//                break;
//            } else {
//                num = num / 1024;
//            }
//        }
//        return num + units[i];
//    },

//    updateStatus: function (fileId, html) {
//        fileId;
//        html;
//    },

//    updateOpt: function (fileId, html) {
//        fileId;
//        html;
//    },

//    Handler: {
//        fileQueued: function (file) {

//            this.startUpload();
//        },

//        uploadComplete: function (file) {
//            //递归实现自动批量上传
//            this.startUpload();
//        },

//        uploadStart: function (file) {
//            //alert(file.name);
//            var title = file.name;
//            swfu.setPostParams({
//                writetoken: writetoken,
//                cataid: '1411522972608',
//                "JSONRPC": '{"Filedata.filename":"' + title + '", "tag": "", "description": ""}'
//            });
//            //开始上传此文件
//            Uploader.updateStatus(file.id, "开始上传");
//        },

//        uploadProgress: function (file, bytesLoaded, bytesTotal) {
//            var percent = Math.ceil((bytesLoaded / bytesTotal) * 100);

//            $("#tip2").html(percent + "%");
//        },

//        uploadSuccess: function (file, serverData) {
//            var typeId = $("#cate_id").find("option:selected").val();
//            if (typeId == "5" || typeId == "6") {
//                $("#vid_info").val(serverData);
//                var dataObj = eval("(" + serverData + ")");
//                $("#doc_title").val(dataObj.data[0].title);
//            }
//            else {
//                try {
//                    var data = eval("(" + serverData + ")");
//                    $("#doc_title").val(data.file_name);
//                    $("#" + up_obj.form_id).val(data.file_path + "," + data.file_name);
//                    $("#file_size").val(data.size);
//                    return;
//                }
//                catch (e) {


//                }
//            }

//        },

//        fileQueueError: function (file, errorCode, message) {

//        }
//    }
//};

//var swfSettings = {
//    upload_url: commonParams.wenkuPath + '/Upload/resUpload?PHPSESSID=' + sid,
//    flash_url: commonParams.wenkuPath + "/static/script/swfupload/swfupload.swf",
//    file_size_limit: "100 MB",
//    file_types: file_type[1],
//    file_types_description: "All Files",
//    file_queue_limit: 1,

//    button_placeholder_id: "demo2",
//    button_image_url: commonParams.wenkuPath + "/static/public/images/swfupload/star_flash_bg.png",
//    button_width: 200,
//    button_height: 42,
//    button_text_left_padding: 30,
//    button_text_top_padding: 2,
//    button_cursor: SWFUpload.CURSOR.HAND,
//    button_window_mode: "transparent",

//    file_queued_handler: Uploader.Handler.fileQueued,
//    file_queue_error_handler: Uploader.Handler.fileQueueError,
//    upload_complete_handler: Uploader.Handler.uploadComplete,
//    upload_start_handler: Uploader.Handler.uploadStart,
//    upload_progress_handler: Uploader.Handler.uploadProgress,
//    upload_success_handler: Uploader.Handler.uploadSuccess
//}

//$(document).ready(function () {
//    swfu = new SWFUpload(swfSettings);
//});

//$("#cate_id").unbind().bind("change", function () {
//    var typeId = $(this).find("option:selected").val();
//    if (typeId == "5" || typeId == "6") {
//        $("#parent_demo").html('<div id="demo2"></div>');
//        var settings = {
//            upload_url: 'http://v.polyv.net/uc/services/rest?method=uploadfile',
//            file_types: file_type[typeId],
//            file_types_description: file_type[typeId]
//        }
//        $.extend(swfSettings, settings || {});
//        swfu = new SWFUpload(swfSettings);
//    }
//});