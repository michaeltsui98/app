var resParams = {
	    fileType: file_type,
	    initUpload: function (options) {
	        var settings = {
	            path: commonParams.wenkuPath + '/static/',
	            divId: 'demo2',
	            formId: 'input2',
	            tipId: 'tip2',
	            upText: '选择文件',
	            upMax: 1,//允许上传是文件数量 默认1个
	            upMaxsize: 1024 * 1024 * 200,
	            upFilter: resParams.fileType[1],
	            upImageFile: 1,//是否文件方式上传
	            upUrl: commonParams.wenkuPath + '/Upload/resUpload?PHPSESSID=' + sid,
	            upProgressTip: '已上传：{progress}',
	            skin: commonParams.wenkuPath + '/static/syup/skin/green',
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
	            //document.getElementById(up_obj.form_id).value = data.file_path + "," + data.file_name;
                document.getElementById("file_path").value = data.file_path;
                document.getElementById("file_name").value = data.file_name;
	            document.getElementById("file_size").value = data.size;
	            $("input[name='data[doc_title]']").val(getFileName(data.file_name));
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


$(document).ready(function () {
	//删除资源
    $("a.del").unbind().bind("click", function () {
        var mian = this;
        var requestUrl = $(mian).attr("data-url");
        cueDialog(function () {
            AjaxForJson(requestUrl, null, function (dataObj) {
                if (dataObj.type == "success") {
                    $(mian).parents("li").remove();
                }
                promptMessageDialog({
                    icon: dataObj.type,
                    content: dataObj.message,
                    time: 1000
                });
            });
        }, mian, false, "您确定要删除此资源吗？");

        return false;
    });
    //修改资源
    $("a.updata").unbind().bind("click", function () {
        var mian = this;
        styledialog.initDialogHTML({
            title: "资源修改",
            url: $(mian).attr("data-url"),
            width: 1000,
            confirm: {
                show: false,
                name: "确定"
            },
            cancel: {
                show: true,
                name: "取消"
            }
        });
        styledialog.initContent("资源修改", null, function () {
            //上传资源
            resParams.initUpload();
            //初始化多级下拉框
            $(".btn-category").mulitSelect();//多级下拉框
        });
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
                $.post("/upload/echoNodeHtml?id=" + fid, function (obj) {
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
    AjaxForJson(formObj.attr("action"), formObj.serialize(), function (dataObj) {
        if (dataObj.type == "success") {
            formObj.attr("subcomplete", "completed");
            var parentObj = formObj.parents("div.formItem");
            var titleVal = $("input[name='data[doc_title]']").val();
            parentObj.find("form").html('<table cellpadding="0" cellspacing="0" width=""><tbody><tr><td class="formTit">资源标题<span>*</span>：</td><td><div style="color: #333;">' + titleVal + '</div><span class="ico_uploadStatus_ok"><i></i>提交成功！感谢您共享此文档，分享让知识更有力量。</span></td></tr></tbody></table>');

        }
        else {
            formObj.find("a[name='a_submit']").css("display", "block");
            promptMessageDialog({
                icon: "warning",
                content: dataObj.message
            });
        }
        formObj.parents("div.formItem").find("div.content").find("div.reloadingImg").remove();
    });
}



