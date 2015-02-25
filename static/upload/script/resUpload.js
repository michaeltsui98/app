var swfu;

uploadParams = {
    limitCount: 5,//文档上传限制
    loadingCount: 0,//正在上传的文档
    queuedCount: 0,//选择文件的个数
    formNum: 1//记录表单序号
}

window.onbeforeunload = function () {
    if ($("div.subFrom").find("form").length > 0 && $("div.subFrom").find("form").length != $("div.subFrom").find("form[subcomplete='completed']").length) {
        return "离开页面将导致数据丢失！";
    }
};

window.onunload = function () {
    var postParams = "";
    $("div.subFrom").find("form").each(function (i) {
        if (i == 0) {
            postParams += "?tmp[]=" + $(this).parents("div.formItem").find("input[name='data[file]']").val().split(",")[0];
        }
        else {
            postParams += "&tmp[]=" + $(this).parents("div.formItem").find("input[name='data[file]']").val().split(",")[0];
        }
    });
    $.ajax({
        url: "/upload/del_tmp" + postParams,
        async: false
    });
};

$(function () {
    swfu = new SWFUpload({
        upload_url: "/Upload/upload",
        flash_url: "/static/script/swfupload/swfupload.swf",
        file_size_limit: "50 MB",
        file_types: "*.doc;*.docx;*.ppt;*.pptx;*.xls;*.xlsx;*.vsd;*.pot;*.pps;*.rtf;*.wps;*.et;*.dps;*.pdf;*.txt;*.epub",
        file_types_description: "All Files",
        file_post_name: "file1",
        file_queue_limit: 5,

        button_placeholder_id: "spanSWFUploadButton",
        button_image_url: "/static/public/images/swfupload/click_add.jpg",
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
});


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
                    promptMessageDialog({
                        icon: "warning",
                        content: "上传列表中已存在" + file.name + "文件！",
                        time: 1000
                    });

                    this.cancelUpload(file.id);
                    return;
                }
            }
            if (filePostfix.toUpperCase() == "TXT" && file.size > 1024 * 1024 * 10) {
                promptMessageDialog({
                    icon: "warning",
                    content: "每份文档不超过20M（TXT不超过10M）",
                    time: 1000
                });
                this.cancelUpload(file.id);
                return;
            }

            swfu.setButtonImageURL("/static/public/images/swfupload/add_btn.jpg");
            swfu.setButtonDimensions(124, 40);

            $("div.uploadTips").css("display", "none");
            $("div.titForm").css("display", "block");
            $("a.allSub").css("display", "block");

            uploadParams.loadingCount++;
            uploadParams.queuedCount++;
            if (uploadParams.limitCount > 0) {
                this.startUpload();
            }
        },

        uploadComplete: function (file) {
            //递归实现自动批量上传
            this.startUpload();
        },

        uploadStart: function (file) {
            swfu.setPostParams({PHPSESSID: sid, frm_id: file.id});
            //开始上传此文件
            Uploader.updateStatus(file.id, "开始上传");
        },

        uploadProgress: function (file, bytesLoaded, bytesTotal) {
            var percent = Math.ceil((bytesLoaded / bytesTotal) * 100);
            //$("li#uploading").find("p.mL35").find("strong").html("正在上传文档:" + file.name);
            //$("li#uploading").find("div.progressBar").find("div").css("width", percent + "%");
            //$("li#uploading").find("span#percent").html(percent + "%");

            $("span.item-progress-inner").css("width", percent + "%");
            $("span.item-progress-text").html(percent + "%");
        },

        uploadSuccess: function (file, serverData) {
            try {
                var data = eval("(" + serverData + ")");
                if (data.type == "success") {
                    var formHTML = data.message;
                    $("ul.wk_uploadFileList").append('<li id="' + file.id + '" class="font14"><div class="loadingStatus loadingFinish"><a class="icon_delS floatL" href="" title="删除"></a><div class="progressBar floatL"><div class="whiteTxt">' + file.name + '</div></div><span class="icon_uploadFinish"></span></div><div class="clearFloat"></div></li>');
                    uploadParams.limitCount--;
                    uploadParams.loadingCount--;

                    uploadParams.limitCount = uploadParams.limitCount <= 0 ? -1 : uploadParams.limitCount;
                    swfu.setFileQueueLimit(uploadParams.limitCount);
                    $("div.subFrom").append(formHTML);
                    //设置form序号
                    $("div.num").each(function (n) {
                        $(this).html(n + 1);
                    });
                    //设置进度条
                    $("#item-message-all").find("span").find("b").html(uploadParams.queuedCount - uploadParams.loadingCount);
                    //var percent = Math.ceil((1 - uploadParams.loadingCount / uploadParams.queuedCount) * 100);
                    //$("span.item-progress-inner").css("width", percent + "%");
                    //$("span.item-progress-text").html(percent + "%");
                    //上传完成后改变图标状态
                    if (uploadParams.loadingCount == 0) {
                        $("#item-message-all").find("b.ic-status").addClass("status-ok");
                    }
                    else {
                        $("#item-message-all").find("b.ic-status").removeClass("status-ok");
                    }

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
                else {
                    promptMessageDialog({
                        icon: "warning",
                        content: data.message
                    });
                }
                return;
            }
            catch (e) {

            }
        },

        fileQueueError: function (file, errorCode, message) {
            if (errorCode == -100) {
                promptMessageDialog({
                    icon: "warning",
                    content: "最多一次添加5篇！",
                    time: 1000
                });
            }
            else if (errorCode == -110) {
                promptMessageDialog({
                    icon: "warning",
                    content: "每份文档不超过20M（TXT不超过10M）",
                    time: 1000
                });
            }
        }
    }
};

(function () {
    $("textarea.textareaStyle").clearText();//获取焦点时清空默认文本

    //单个表单的展开收起
    $("a.hide").die().live("click", function () {
        var that = this;
        var parentObj = $(that).parents("div.formItem");

        parentObj.find("table[name='tbl1']").find("tr").each(function (n) {
            if (n > 0) {
                parentObj.find("table[name='tbl1']").find("tr").eq(n).css("display", "");
            }
        });
        parentObj.find("table[name='tbl2']").css("display", "block");
        return false;
    });
    $("a.open").die().live("click", function () {
        var that = this;
        var parentObj = $(that).parents("div.formItem");

        parentObj.find("table[name='tbl1']").find("tr").each(function (n) {
            if (n > 0) {
                parentObj.find("table[name='tbl1']").find("tr").eq(n).css("display", "none");
            }
        });
        parentObj.find("table[name='tbl2']").css("display", "none");
        return false;
    });
    //移除表单
    $("a.close").die().live("click", function () {
        var that = this;
        var parentObj = $(that).parents("div.formItem");
        AjaxForJson("/upload/del_tmp?tmp[]=" + parentObj.find("input[name='data[file]']").val().split(",")[0], null, function (data) {
            parentObj.remove();
        });
        return false;
    });
    //提交单个表单
    $("a[name='a_submit']").die().live("click", function () {
        var that = this;
        var formObj = $(that).parents("form");
        if (formObj.attr("subcomplete") == "completed") {
            return;
        }
        submitForm(formObj);
        return false;
    });
    //提交全部表单
    $("a.allSub").unbind().bind("click", function () {
        $("div.formItem").find("form").each(function () {
            if ($(this).attr("subcomplete") == "completed") {
                return;
            }
            submitForm($(this));
        });

        return false;
    });

    //提交表单的公共方法
    function submitForm(formObj) {
        if ($.trim(formObj.find("input[name='data[doc_title]']").val()) == "") {
            promptMessageDialog({
                icon: "warning",
                content: "资源标题不能为空！"
            });
            return;
        }
        else if (formObj.find("input[name='data[node_id]']").val() == "") {
            promptMessageDialog({
                icon: "warning",
                content: "资源分类不能为空！"
            });
            return;
        }
        else if (formObj.find("input[name='data[cate_id]']").val() == "") {
            promptMessageDialog({
                icon: "warning",
                content: "资源类型不能为空！"
            });
            return;
        }
        formObj.parents("div.formItem").find("div.content").prepend('<div class="reloadingImg"></div>');
        formObj.find("a[name='a_submit']").css("display", "none");
        AjaxForJson(formObj.attr("action"), formObj.serialize() + "&sid=" + sid, function (dataObj) {
            if (dataObj.status == "1") {
                formObj.attr("subcomplete", "completed");
                var parentObj = formObj.parents("div.formItem");
                var titleVal = $("input[name='data[doc_title]']").val();
                parentObj.find("form").html('<table cellpadding="0" cellspacing="0" width=""><tbody><tr><td class="formTit">资源标题<span>*</span>：</td><td><div style="color: #333;">' + titleVal + '</div><span class="ico_uploadStatus_ok"><i></i>提交成功！感谢您共享此文档，分享让知识更有力量。</span></td></tr></tbody></table>');

            }
            else {
                formObj.find("a[name='a_submit']").css("display", "block");
                promptMessageDialog({
                    icon: "warning",
                    content: dataObj.msg
                });
            }
            formObj.parents("div.formItem").find("div.content").find("div.reloadingImg").remove();

            if ($("div.subFrom").find("form").length == $("div.subFrom").find("form[subcomplete='completed']").length) {
                window.location.href = commonParams.wenkuPath + "/user"
            }
        });
    }
})();

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
                AjaxForJson("/upload/echoNodeHtml?id=" + fid, null, function (obj) {
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