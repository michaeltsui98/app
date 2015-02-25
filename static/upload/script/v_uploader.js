var wenkuCommonParams = {
    wenkuPath: "http://dev-wenku.dodoedu.com",
    otherParams: ""
};

function hasClass(obj, cls) {
    var obj_class = obj.className;
    if (obj_class && obj_class.length) {
        var obj_class_lst = obj_class.split(/\s+/);
        x = 0;
        for (x in obj_class_lst) {
            if (obj_class_lst[x] == cls) {
                return true;
            }
        }
    }
    return false;
}

var upload_version = "1.0";

function loadjscssfile(filename, filetype) {
    if (filetype == "js") { //判断文件类型 
        var fileref = document.createElement('script');//创建标签
        fileref.setAttribute("type", "text/javascript");//定义属性type的值为text/javascript
        fileref.setAttribute("src", filename + "?" + upload_version);//文件的地址
        var fileArr = filename.split("/");
        fileref.setAttribute("id", fileArr[fileArr.length - 1]);
    }
    else if (filetype == "css") { //判断文件类型 
        var fileref = document.createElement("link");
        fileref.setAttribute("rel", "stylesheet");
        fileref.setAttribute("type", "text/css");
        fileref.setAttribute("href", filename);
    }
    if (typeof fileref != "undefined") {
        document.getElementsByTagName("head")[0].appendChild(fileref);
    }
}

var reload = false;
//加载文件，知道jquery加载完毕再加载其他js文件
if (!window.jQuery) {
    loadjscssfile(wenkuCommonParams.wenkuPath + "/static/script/jquery.js", "js");
    reload = true;
}
if (reload) {
    if (!v_uploader) {
        loadjscssfile(wenkuCommonParams.wenkuPath + "/static/upload/script/v_uploader.js", "js");
        v_uploader = true;
    }
}
else {
    loadjscssfile(wenkuCommonParams.wenkuPath + "/static/upload_pop/css/index.css", "css");

    $(document).ready(function() {
        $("input.v_upload_btn").each(function() {
            var paramsObj = $(this).parent().attr("data-param");
            if (paramsObj) {
                var dataObj = eval('(' + paramsObj + ')');
                if (dataObj.init_btn != "true") {
                    $(this).remove();
                } else {
                    for (var key in dataObj) {
                        if (key == "init_btn") {
                            continue;
                        } else {
                            wenkuCommonParams.otherParams = dataObj;
                        }
                    }
                }
            }
        });
    });

    //点击按钮调出弹框
    $("input.v_upload_btn").die().live("click", function () {
        var objId = $(this).parent().attr("data-id");
        var objType = $(this).parent().attr("data-type");
        var cusId = $(this).parent().attr("data-cus_id");

        var that = this;
        //检测是否登陆
        $.ajaxJSONP(wenkuCommonParams.wenkuPath + "/upload/isLogin?is_jsonp=1", null, function (data) {
            if (data.status == "0") {
                uploadPromptMessageDialog({ icon: "warning", content: data.msg });//成功finish；警告warning；错误error；提示hint；疑问query
            }
            else if (data.status == "1") {
                var swfu;
                var uploadHTML = '<div class="f-fl width252 f-fs14 f-pt5"><div class="tab-resource m-resource-upload-tab"><ul><li id="itemLi"><a href="javascript:;" class="current">上传资源</a></li><li id="listLi"><a href="javascript:;">资源列表</a></li></ul><div class="clear"></div></div> </div><div class="clear"></div><div class="subFrom m-resource-upload-subFrom"><div class="formItem" name="vform_item"><div class="content" style="height:300px;padding:20px"><a href="javascript:;" id="spanSWFUploadButton" title="点击上传"></a><span id="percentText"></span></div></div><div class="listFrom m-resource-upload-listFrom" name="vlist_from" style="display:none;"></div></div>';
                uploadStyledialog.initDialogHTML({
                    title: "上传文件",
                    content: uploadHTML,
                    width: 760,
                    confirm: {
                        show: false,
                        name: "确定"
                    },
                    cancel: {
                        show: false,
                        name: "取消"
                    }
                });
                uploadStyledialog.initContent("提示", uploadHTML, function () {
                    //初始化上传按钮
                    function initUpload() {
                        var Uploader = {
                            getFileSize: function (num) {
                                if (isNaN(num)) {
                                    return false;
                                }
                                num = parseInt(num);
                                var units = [" B", " KB", " MB", " GB"];
                                for (var i = 0; i < units.length; i += 1) {
                                    if (num < 1024) {
                                        num = num + "";
                                        if (num.indexOf(".") != -1 && num.indexOf(".") != 3) {
                                            num = num.substring(0, 4);
                                        } else {
                                            num = num.substring(0, 3);
                                        }
                                        break;
                                    } else {
                                        num = num / 1024;
                                    }
                                }
                                return num + units[i];
                            },

                            updateStatus: function (fileId, html) {
                                fileId;
                                html;
                            },

                            updateOpt: function (fileId, html) {
                                fileId;
                                html;
                            },

                            Handler: {
                                fileQueued: function (file) {
                                    var filePostfix = file.name.split(".")[file.name.split(".").length - 1];
                                    var loadingListLen = $("ul.wk_uploadFileList").find("div.progressBar").find("div.whiteTxt").length;
                                    for (var i = 0; i < loadingListLen; i++) {
                                        if (file.name == $("ul.wk_uploadFileList").find("div.progressBar").find("div.whiteTxt")[i].innerHTML) {
                                            uploadPromptMessageDialog({
                                                icon: "warning",
                                                content: "上传列表中已存在" + file.name + "文件！",
                                                time: 1000
                                            });

                                            this.cancelUpload(file.id);
                                            return;
                                        }
                                    }
                                    if (filePostfix.toUpperCase() == "TXT" && file.size > 1024 * 1024 * 10) {
                                        uploadPromptMessageDialog({
                                            icon: "warning",
                                            content: "每份文档不超过20M（TXT不超过10M）",
                                            time: 1000
                                        });
                                        this.cancelUpload(file.id);
                                        return;
                                    }

                                    $("div.uploadTips").css("display", "none");
                                    $("div.titForm").css("display", "block");
                                    $("a.allSub").css("display", "block");

                                    this.startUpload();
                                },

                                uploadComplete: function (file) {
                                    //递归实现自动批量上传
                                    //this.startUpload();
                                },

                                uploadStart: function (file) {
                                    var dataObj=$.extend({},{ is_jsonp: 1, obj_id: objId, obj_type: objType, cus_id: cusId, PHPSESSID: data.sid },wenkuCommonParams.otherParams);
                                    swfu.setPostParams(dataObj);
                                    //开始上传此文件
                                    Uploader.updateStatus(file.id, "开始上传");
                                },

                                uploadProgress: function (file, bytesLoaded, bytesTotal) {
                                    var percent = Math.ceil((bytesLoaded / bytesTotal) * 100);

                                    $("#percentText").html(percent + "%");
                                },

                                uploadSuccess: function (file, serverData) {
                                    try {
                                        var dataObj = eval("(" + serverData + ")");
                                        if (dataObj.type == "success") {
                                            var formHTML = dataObj.message;

                                            $("div[name='vform_item']").html(formHTML);

                                            $(".btn-category").mulitSelect();//多级下拉框
                                            $("input.inputBoxStyle").changeStyle();//自定义输入框获取焦点时样式
                                            $("textarea.textareaStyle").changeStyle();
                                            $("textarea.textareaStyle").clearText();//获取焦点时清空默认文本
                                            $("textarea.textareaStyle").checkMaxLen();//检验输入的最大长度

                                            $("a[name='btn_get_tag']").unbind().bind("click", function () {
                                                var formObj = $(this).parents("form");
                                                var titleStr = formObj.find("input[name='file_info[doc_title]']").val();
                                                var infoStr = formObj.find("span[name='span_ct_name']").html() + (formObj.find("span[name='span_kn_name']").html() == "请选择" ? "" : formObj.find("span[name='span_kn_name']").html()) + (formObj.find("span[name='span_type_name']").html() == "请选择" ? "" : formObj.find("span[name='span_type_name']").html());
                                                var contentStr = formObj.find("textarea[name='file_info[doc_summery]']").val() == "非必填项，最多200字。" ? "" : formObj.find("textarea[name='file_info[doc_summery]']").val();
                                                formObj.find("div[name='tag_content']").getTokenize(titleStr + infoStr + contentStr, "5");
                                                return false;
                                            });
                                        }
                                        return;
                                    }
                                    catch (e) {

                                    }
                                },

                                fileQueueError: function (file, errorCode, message) {
                                    if (errorCode == -100) {
                                        uploadPromptMessageDialog({
                                            icon: "warning",
                                            content: "最多一次添加5篇！",
                                            time: 1000
                                        });
                                    }
                                    else if (errorCode == -110) {
                                        uploadPromptMessageDialog({
                                            icon: "warning",
                                            content: "每份文档不超过20M（TXT不超过10M）",
                                            time: 1000
                                        });
                                    }
                                }
                            }
                        };

                        swfu = new SWFUpload({
                            upload_url: wenkuCommonParams.wenkuPath + "/upload/vupload",
                            flash_url: wenkuCommonParams.wenkuPath + "/static/script/swfupload/swfupload.swf",
                            file_size_limit: "50 MB",
                            file_types: "*.doc;*.docx;*.ppt;*.pptx;*.xls;*.xlsx;*.vsd;*.pot;*.pps;*.rtf;*.wps;*.et;*.dps;*.pdf;*.txt;*.epub",
                            file_types_description: "All Files",
                            file_post_name: "file1",
                            file_queue_limit: 5,

                            button_placeholder_id: "spanSWFUploadButton",
                            button_image_url: wenkuCommonParams.wenkuPath + "/static/public/images/swfupload/click_add.jpg",
                            button_width: 194,
                            button_height: 40,
                            button_text_left_padding: 30,
                            button_text_top_padding: 2,
                            button_cursor: SWFUpload.CURSOR.HAND,
                            button_window_mode: "transparent",

                            file_queued_handler: Uploader.Handler.fileQueued,
                            file_queue_error_handler: Uploader.Handler.fileQueueError,
                            upload_complete_handler: Uploader.Handler.uploadComplete,
                            upload_start_handler: Uploader.Handler.uploadStart,
                            upload_progress_handler: Uploader.Handler.uploadProgress,
                            upload_success_handler: Uploader.Handler.uploadSuccess
                        });
                    }
                    //加载flash文件完成
                    $.cachedScript(wenkuCommonParams.wenkuPath + "/static/script/swfupload/swfupload.js").done(function () {
                        initUpload();
                    });
                    //表单提交事件
                    $("div.popbutn a[name='confirm']").die().live("click", function () {
                        var form = $("form[name='v_upload_from']");
                        $.ajaxJSONP(form.attr("action"), form.serialize(), function (data) {
                            if (data.status == "0") {
                                uploadPromptMessageDialog({
                                    icon: "warning",
                                    content: data.msg,
                                    time: 1000
                                });
                            }
                            else if (data.status == "1") {
                                //提交成功后切换到文件列表页，并初始化上传按钮
                                $("#listLi").trigger("click");
                                $("div[name='vform_item']").html('<div class="content" style="height:300px;padding:20px"><a href="javascript:;" id="spanSWFUploadButton" title="点击上传"></a><span id="percentText"></span></div>');
                                initUpload();
                            }

                            $(that).trigger("uploadend", data);
                        });
                        return false;
                    });

                    $("div.popbutn a[name='cancel']").die().live("click",function(){
                        uploadStyledialog.closeDialog();
                        return false;
                    });
                    //切换到文件上传页面
                    $("#itemLi").unbind().bind("click", function () {
                        var main = this;
                        $(main).parent().find("li").find("a").removeClass("current");
                        $(main).find("a").addClass("current");
                        $("div[name='vlist_from']").css("display", "none");
                        $("div[name='vform_item']").css("display", "block");
                        return false;
                    });
                    //切换到文件列表页
                    $("#listLi").unbind().bind("click", function () {
                        var main = this;
                        function getList(requestUrl) {
                            $.ajaxJSONP(requestUrl, null, function (data) {
                                $(main).parent().find("li").find("a").removeClass("current");
                                $(main).find("a").addClass("current");
                                $("div[name='vform_item']").css("display", "none");
                                $("div[name='vlist_from']").css("display", "block");
                                $("div[name='vlist_from']").html(data);

                                $("#frm_vlist").find("a[name='confirm']").die().live("click", function () {
                                    var form = $("#frm_vlist");
                                    $.ajaxJSONP(wenkuCommonParams.wenkuPath + "/upload/vlist?obj_id=" + objId + "&obj_type=" + objType + "&cus_id=" + cusId + "&key=" + form.find("input[name='key']").val(), null, function (dataPage) {
                                        $("div[name='vlist_from']").html(dataPage);
                                    });

                                    return false;
                                });

                                $("#frm_vlist").find("a[name='returnlist']").die().live("click", function () {
                                    $("#listLi").trigger("click");
                                    return false;
                                });

                                $("#m-pageNum").find("div.pages").find("a").unbind().bind("click", function () {
                                    var data_url = $(this).attr("data-url");
                                    getList(data_url);
                                    return false;
                                });

                                $("#frm_vlist").find("input[name='key']").unbind().bind("keydown", function (e) {
                                    if (e.keyCode == 13) {
                                        $.ajaxJSONP(wenkuCommonParams.wenkuPath + "/upload/vlist?obj_id=" + objId + "&obj_type=" + objType + "&cus_id=" + cusId + "&key=" + $("#frm_vlist").find("input[name='key']").val(), null, function (dataPage) {
                                            $("div[name='vlist_from']").html(dataPage);
                                        });
                                        return false;
                                    }
                                });
                            });
                        }

                        getList(wenkuCommonParams.wenkuPath + "/upload/vlist?obj_id=" + objId + "&obj_type=" + objType + "&cus_id=" + cusId);
                        return false;
                    });
                });
            }
        });
        return false;
    });
    //弹框方法
    var uploadStyledialog = {
        initDialogHTML: function (settings) {
            this.settings = {
                title: "",
                content: "",
                width: 710,
                url: "",
                confirm: {
                    show: true,
                    name: "确认",
                    disablie: false
                },
                cancel: {
                    show: false,
                    name: "取消"
                },
                button: {
                    show: false,
                    html: ""
                }
            }
            $.extend(this.settings, settings || {});
            if (this.settings.url) {
                var responseObj = $.ajax({
                    url: this.settings.url,
                    async: false
                }).responseText;
                try {
                    this.settings.content = eval('(' + responseObj + ')');
                    if (this.settings.content.type == "login") {
                        loginDialog();
                        return;
                    }
                }
                catch (e) {
                    this.settings.content = responseObj;
                }
            }
            var dialogConHtml = '<div class="m-upload" style="margin:0;width:' + this.settings.width + 'px;" id="PopupsFra"><h5 class="hd"><a class="icon-close f-fr upload-close" href="javascript:;" title="关闭"></a><strong>' + this.settings.title + '</strong></h5><div id="editFraCon" name="editFraCon"><div class="W-form" style="width:' + this.settings.width + 'px;">' + this.settings.content;
            if (this.settings.button.show || this.settings.confirm.show || this.settings.cancel.show) {
                dialogConHtml += '<div class="m-ftc">';

                dialogConHtml += '<div id="PopupsFunc" class="w-btn">';
                if (this.settings.button.show) {
                    dialogConHtml += this.settings.button.html;
                }
                if (this.settings.confirm.show) {
                    dialogConHtml += '<input name="confirm" type="button" class="customBtn colourDarkGreen customBtnNormal f-mr10 " value="' + this.settings.confirm.name + '">';
                }
                if (this.settings.cancel.show) {
                    dialogConHtml += '<input name="cancel" type="button" class="customBtn colourLightGray customBtnNormal" value="' + this.settings.cancel.name + '">';
                }
                dialogConHtml += '</div>';
                dialogConHtml += '</div>';
            }
            dialogConHtml += '</div></div></div><div id="divBg" class="pageBg"><iframe style="position: absolute;width: 100%;height: 100%;z-index:-1;"></iframe></div>';
            $("body").eq(0).append(dialogConHtml);

            $("#divBg").css("display", "block");
            $("#PopupsFra").css("display", "block");
            var main = this;
            $("#PopupsFra h5 .icon-close").bind("click", function () {
                main.closeDialog();
                return false;
            });
            $("#PopupsFunc input[name='cancel']").bind("click", function () {
                main.closeDialog();
                return false;
            });
            this.initContent();
        },
        initContent: function (tittleCon, contentHTML, eventFun) {

            var windowWidth, windowHeight;
            if (document.documentElement.clientWidth == 0) {
                windowWidth = document.documentElement.offsetWidth;
            } else {
                windowWidth = document.documentElement.clientWidth;
            }
            if (document.documentElement.clientHeight == 0) {
                windowHeight = document.documentElement.offsetHeight;
            } else {
                windowHeight = document.documentElement.clientHeight;
            }
            var bodyScrollTop = 0;
            var bodyScrollLeft = 0;
            if (document.documentElement && document.documentElement.scrollTop) {
                bodyScrollTop = document.documentElement.scrollTop;
                bodyScrollLeft = document.documentElement.scrollLeft;
            } else if (document.body) {
                bodyScrollTop = document.body.scrollTop;
                bodyScrollLeft = document.body.scrollLeft;
            }
            var documentHeight = document.documentElement.clientHeight + document.documentElement.scrollHeight;
            var documentWidth = document.documentElement.clientWidth + document.documentElement.scrollWidth;
            var dialogHeight = $("#PopupsFra")[0].clientHeight;
            var dialogWidth = $("#PopupsFra")[0].clientWidth;
            $("#divBg").css({
                "width": document.body.offsetWidth,
                "height": document.body.offsetHeight < $(window).height() ? $(window).height() : document.body.offsetHeight
            });
            var PopupsFraTop = windowHeight / 2 - dialogHeight / 2 + bodyScrollTop >= 0 ? windowHeight / 2 - dialogHeight / 2 + bodyScrollTop : 0;
            var PopupsFraLfet = windowWidth / 2 - dialogWidth / 2 + bodyScrollLeft >= 0 ? windowWidth / 2 - dialogWidth / 2 + bodyScrollLeft : 0;
            $("#PopupsFra").css({
                "top": PopupsFraTop,
                "left": PopupsFraLfet
            });

            if (eventFun != null) {
                eventFun();
            }
        },
        closeDialog: function () {
            document.body.parentNode.style.overflow = "";
            $("#PopupsFra").remove();
            $("#divBg").remove();
        }
    };

    //提示弹框
    function uploadPromptMessageDialog(settings) {
        this.settings = {
            icon: "warning",
            content: "数据返回出现异常！",
            time: 1000
        }
        $.extend(this.settings, settings || {});
        var iconName = this.settings.icon == "finish" || this.settings.icon == "success" ? "finish" : this.settings.icon;
        var dialogContent = '<div class="customTipsSuccessfulOperation" style="display:inline-block;*display:inline;*zoom:1;padding:12px 20px;text-align:center;color:#fff;font-size:18px;border:1px solid #b3b3b3;background-color:#b3b3b3;border:1px solid rgba(178,178,178,0.5);border-radius:3px;box-shadow:0 2px 3px rgba(178,178,178,0.5);background-color:rgba(0,0,0,0.5);_background-color:#b3b3b3;"><i class="icon_' + iconName + '"></i>' + this.settings.content + '</div>';

        $("body").eq(0).append(dialogContent);

        var windowWidth = document.documentElement.clientWidth;
        var windowHeight = document.documentElement.clientHeight;
        var bodyScrollTop = 0;
        if (document.documentElement && document.documentElement.scrollTop) {
            bodyScrollTop = document.documentElement.scrollTop;
        } else if (document.body) {
            bodyScrollTop = document.body.scrollTop;
        }
        var documentHeight = document.documentElement.clientHeight + document.documentElement.scrollHeight;
        var documentWidth = document.documentElement.clientWidth + document.documentElement.scrollWidth;
        var dialogHeight = $(".customTipsSuccessfulOperation")[0].clientHeight;
        var dialogWidth = $(".customTipsSuccessfulOperation")[0].clientWidth;
        var editFraTop = windowHeight / 2 - dialogHeight / 2 + bodyScrollTop >= 0 ? windowHeight / 2 - dialogHeight / 2 + bodyScrollTop : 0;
        var editFraLfet = windowWidth / 2 - dialogWidth / 2 >= 0 ? windowHeight / 2 - dialogHeight / 2 + bodyScrollTop : 0;
        $(".customTipsSuccessfulOperation").css({
            "top": editFraTop,
            "left": windowWidth / 2 - dialogWidth / 2,
            "position": "absolute",
            "z-index": "950"
        });
        setTimeout(function () {
            $(".customTipsSuccessfulOperation").remove();
        }, this.settings.time);
    }

    //改进jquery动态加载js方法
    //定义一个全局script的标记数组，用来标记是否某个script已经下载到本地
    var scriptsArray = new Array();
    $.cachedScript = function (url, options) {
        //循环script标记数组
        for (var s in scriptsArray) {
            //如果某个数组已经下载到了本地
            if (scriptsArray[s] == url) {
                return {  //则返回一个对象字面量，其中的done之所以叫做done是为了与下面$.ajax中的done相对应
                    done: function (method) {
                        if (typeof method == 'function') {  //如果传入参数为一个方法
                            method();
                        }
                    }
                };
            }
        }
        //这里是jquery官方提供类似getScript实现的方法，也就是说getScript其实也就是对ajax方法的一个拓展
        options = $.extend(options || {}, {
            dataType: "script",
            url: url,
            cache: true //其实现在这缓存加与不加没多大区别
        });
        scriptsArray.push(url); //将url地址放入script标记数组中
        return $.ajax(options);
    };

    //ajax跨域请求方法
    jQuery.extend({
        ajaxJSONP: function (url, data, callback, errorCallback, successPar) {
            $.ajax({
                type: "get",
                async: false,
                url: url,
                data: data,
                dataType: "jsonp",
                jsonp: "callback",//传递给请求处理程序或页面的，用以获得jsonp回调函数名的参数名(一般默认为:callback)
                success: function (json) {
                    callback(json, successPar);
                },
                error: function (e) {
                    e;
                    alert('fail');
                }
            });
        }
    });

    //单选和多选下拉框
    jQuery.fn.extend({
        //自定义多选下拉框
        mulitSelect: function () {
            if (this.length <= 0) {
                return false;
            }
            var main = this;
            $(main).each(function () {
                var that = this;
                var formObj = $(that).parents("div.formItem");

                function getCateContent(thisObj, fid) {
                    //获取子类型选项
                    $.ajaxJSONP(wenkuCommonParams.wenkuPath + "/upload/echoNodeHtml?id=" + fid, null, function (obj) {
                        data = obj;
                        var thisIndex = thisObj.index();
                        while (thisObj.parent().find("li").eq(thisIndex + 1).length > 0) {
                            thisObj.parent().find("li").eq(thisIndex + 1).remove();
                        }

                        thisObj.after(data);
                        //绑定新出现的子类型选项点击事件
                        formObj.find("div[name='wkCategory']").find("ul").find("li").find("p").each(function () {
                            $(this).unbind("click").bind("click", function () {
                                $(this).parent().find("p").removeClass("selected");
                                $(this).addClass("selected");
                                $(this).parent().find("p").attr("check", "no");
                                $(this).attr("check", "yes");
                                var fid = $(this).attr("data-cid");
                                if ($(this).attr("class").indexOf("last") > -1) {
                                    var cateVal = '';
                                    formObj.find("div[name='wkCategory']").find("ul").find("li").find("p[check='yes']").each(function (n) {
                                        if (n == 0) {
                                            cateVal += $(this).html();
                                            if (parseInt($(this).attr("data-cid")) <= 3) {
                                                formObj.find("tr[name='tr_cate']").css("display", "");
                                            }
                                            else {
                                                formObj.find("tr[name='tr_cate']").css("display", "none");
                                            }
                                        }
                                        else {
                                            cateVal += '>' + $(this).html();
                                        }
                                    });
                                    formObj.find("span.category-text").html(cateVal);
                                    formObj.find("input[name='data[node_id]']").val($("div[name='wkCategory']").find("ul").find("li").find("p[check='yes']").eq($("div[name='wkCategory']").find("ul").find("li").find("p[check='yes']").length - 1).attr("data-cid"));
                                    formObj.find("div[name='wkCategory']").find("ul").css("display", "none");
                                }
                                else {
                                    getCateContent($(this).parent(), fid);
                                }

                                return false;
                            });
                            $(this).unbind("mouseover").bind("mouseover", function () {
                                $(this).addClass("selected");
                            });
                            $(this).unbind("mouseleave").bind("mouseleave", function () {
                                if ($(this).attr("check") != "yes") {
                                    $(this).removeClass("selected");
                                }
                            });
                        });
                    });
                }
                //点击出现隐藏下拉框
                $(this).unbind().bind("click", function (e) {
                    e = window.event || e;
                    obj = $(e.srcElement || e.target);

                    if ($(this).parents("div.form").find("div[name='wkCategory']").find("ul").css("display") == "none") {
                        $(this).parents("div.form").find("div[name='wkCategory']").find("ul").css("display", "block");
                    }
                    else {
                        if (this.className == obj[0].className) {
                            $(this).parents("div.form").find("div[name='wkCategory']").find("ul").css("display", "none");
                        }
                    }
                });
                //绑定选择类型事件
                formObj.find("div[name='wkCategory']").find("ul").find("li").find("p").each(function () {
                    $(this).unbind("click").bind("click", function () {
                        $(this).parent().find("p").removeClass("selected");
                        $(this).addClass("selected");
                        $(this).parent().find("p").attr("check", "no");
                        $(this).attr("check", "yes");
                        var fid = $(this).attr("data-cid");

                        if ($(this).attr("class").indexOf("last") > -1) {
                            var cateVal = '';
                            formObj.find("div[name='wkCategory']").find("ul").find("li").find("p[check='yes']").each(function (n) {
                                if (n == 0) {
                                    cateVal += $(this).html();
                                    if (parseInt($(this).attr("data-cid")) <= 3) {
                                        formObj.find("tr[name='tr_cate']").css("display", "");
                                    }
                                    else {
                                        formObj.find("tr[name='tr_cate']").css("display", "none");
                                    }
                                }
                                else {
                                    cateVal += '>' + $(this).html();
                                }
                            });
                            formObj.find("span.category-text").html(cateVal);
                            formObj.find("input[name='data[node_id]']").val($("div[name='wkCategory']").find("ul").find("li").find("p[check='yes']").eq($("div[name='wkCategory']").find("ul").find("li").find("p[check='yes']").length - 1).attr("data-cid"));
                            formObj.find("div[name='wkCategory']").find("ul").css("display", "none");
                        }
                        else {
                            getCateContent($(this).parent(), fid);
                        }

                        return false;
                    });
                    $(this).unbind("mouseover").bind("mouseover", function () {
                        $(this).addClass("selected");
                    });
                    $(this).unbind("mouseleave").bind("mouseleave", function () {
                        if ($(this).attr("check") != "yes") {
                            $(this).removeClass("selected");
                        }
                    });
                });
            });
            //点击页面隐藏下拉框
            $(document).click(function (e) {
                e = window.event || e;
                obj = $(e.srcElement || e.target);
                if ($(obj).is("span.btn-category,span.btn-category *,div[name='wkCategory'] *")) {
                    return;
                }
                else {
                    main.parents("div.form").find("div[name='wkCategory']").find("ul").css("display", "none");
                }
            });
        }
    });
}
//判断页面中是否有上传按钮，如果有就不初始化
var hasbutton = false;
for (var i in document.all) {
    if (hasClass(document.all[i], "v_upload_btn")) {
        hasbutton = true;
        break;
    }
}
//初始化页面上传按钮
document.write("<input type='button' class='v_upload_btn' value='上传资源'>");

var v_uploader = true;