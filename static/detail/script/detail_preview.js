//初始化播放器
jQuery.fn.extend({
    fileView: function (containerId, videoStar) {
        var mian = this;
        if (perview_type == "isTxt") {
            $('#' + containerId).FlexPaperViewer({
                config: {
                    jsDirectory: commonParams.wenkuPath + '/static/flexpaper',
                    cssDirectory: commonParams.wenkuPath + '/static/flexpaper',
                    SWFFile: commonParams.jcStsticPath + '/wenku/' + swf_key,

                    Scale: 1,
                    ZoomTransition: 'easeOut',
                    ZoomTime: 0.5,
                    ZoomInterval: 0.2,
                    FitPageOnLoad: true,
                    FullScreenAsMaxWindow: false,
                    MinZoomSize: 0.2,
                    MaxZoomSize: 5,
                    SearchMatchAll: false,
                    InitViewMode: 'Portrait',
                    RenderingOrder: 'flash,html',
                    //StartAtPage: mark_page,

                    FitWidthOnLoad: true,
                    ProgressiveLoading: true,
                    ViewModeToolsVisible: true,
                    ZoomToolsVisible: true,
                    NavToolsVisible: true,
                    CursorToolsVisible: true,
                    SearchToolsVisible: true,
                    WMode: 'transparent',
                    localeChain: 'zh_CN'
                }
            });

            $.ajaxJSONP(commonParams.wenkuPath + "/info/views/id/" + id, null, function () { });
        }
        else if (perview_type == "isPpt") {
            var objHeight = document.getElementById(containerId).offsetHeight;
            var objWidth = document.getElementById(containerId).offsetWidth;
            if (document.getElementById(containerId).offsetWidth / document.getElementById(containerId).offsetHeight > 4 / 3) {
                objWidth = document.getElementById(containerId).offsetHeight * 4 / 3;
            }
            else {
                objHeight = document.getElementById(containerId).offsetWidth * 3 / 4;
            }
            new syPPT({
                width: objWidth,
                height: objHeight,
                swf_id: containerId,//上传flash元素id
                file_url: commonParams.jcStsticPath + '/wenku/' + swf_key,
                botton_hidden: 0,
                skin: commonParams.wenkuPath + '/static/fpaper/skin/comp'
            }, objWidth, objHeight).show();

            $.ajaxJSONP(commonParams.wenkuPath + "/info/views/id/" + id, null, function () { });
            setTimeout(function () {
                $('#' + containerId).css("border", "1px solid #96b9cf");
            }, 1);
        }
        else if (perview_type == "isVideo") {
            var ifStar = videoStar ? "1" : "0";
            var studyTime = 0;
            if ($("div[name='data']").length > 0) {
                studyTime = parseInt($("div[name='data']").attr("study_record_time"));
            }
            //var logoImg = subject.toLowerCase() == "xl" ? commonParams.jcDevPath + "/static/ckplayer/xlLogo.png" : commonParams.jcDevPath + "/static/ckplayer/smLogo.png";
            var flashvars = {
                f: commonParams.jcStsticPath + '/resource/' + file_key,
                a: '',//调用时的参数，只有当s>0的时候有效
                s: '0',//调用方式，0=普通方法（f=视频地址），1=网址形式,2=xml形式，3=swf形式(s>0时f=网址，配合a来完成对地址的组装)
                p: ifStar,//视频默认0是暂停，1是播放
                //i: commonParams.wenkuPath + '/static/images/videoLogo.jpg',
                h: '4',//播放http视频流时采用何种拖动方法，=0不使用任意拖动，=1是使用按关键帧，=2是按时间点，=3是自动判断按什么(如果视频格式是.mp4就按关键帧，.flv就按关键时间)，=4也是自动判断(只要包含字符mp4就按mp4来，只要包含字符flv就按flv来)
                e: '0',//视频结束后的动作，0是调用js函数，1是循环播放，2是暂停播放并且不调用广告，3是调用视频推荐列表的插件，4是清除视频流并调用js功能和1差不多，5是暂停播放并且调用暂停广告
                v: 50,
                g: studyTime,//视频直接g秒开始播放
                h: 0,
                c: 0
                //my_title: $("dl.learnDes dt strong").html(),//视频标题
                //my_summary: $("#desc_all").text(),//视频介绍，请保持在一行文字，不要换行
                //my_url: encodeURIComponent(window.location.href)
            };
            var params = { bgcolor: '#FFF', allowFullScreen: true, allowScriptAccess: 'always', wmode: "transparent" };//这里定义播放器的其它参数如背景色（跟flashvars中的b不同），是否支持全屏，是否支持交互
            var attributes = { id: 'ckplayer_a1', name: 'ckplayer_a1', menu: 'false' };
            //下面一行是调用播放器了，括号里的参数含义：（播放器文件，要显示在的div容器，宽，高，需要flash的版本，当用户没有该版本的提示，加载初始化参数，加载设置参数如背景，加载attributes参数，主要用来设置播放器的id）
            var objHeight = document.getElementById(containerId).offsetHeight;
            var objWidth = document.getElementById(containerId).offsetWidth;
            if (document.getElementById(containerId).offsetWidth / document.getElementById(containerId).offsetHeight > 16 / 9) {
                objWidth = document.getElementById(containerId).offsetHeight * 16 / 9;
            }
            else {
                objHeight = document.getElementById(containerId).offsetWidth * 9 / 16;
            }

            if ($("#documentDiv").length > 0) {
                $("#documentDiv").css("top", ($("#documentDiv").parent().height() - objHeight) / 2 + "px");
            }

            swfobject.embedSWF(commonParams.wenkuPath + '/static/ckplayer/ckplayer.swf', containerId, objWidth, objHeight, '10.0.0', commonParams.wenkuPath + '/static/ckplayer/expressInstall.swf', flashvars, params, attributes);

        }
    }
});

$(document).ready(function () {
    $('#documentViewer').fileView("documentViewer");

    $("#fav").toCollect();
    $("#remark").toRemark();
    $("li.downLoadWrap").find("a.btn3").toDownload();

    $("span.tag").bind({
        mouseover: function () {
            $(this).find("div.tag_dia").css("display", "block");
        },
        mouseout: function () {
            $(this).find("div.tag_dia").css("display", "none");
        }
    });
});

var rateStarParams = {
    zsIndex: null,
    tyIndex: null
};

//浏览页面的相关操作
jQuery.fn.extend({
    //收藏
    toCollect: function () {
        var mian = this;
        return $(mian).unbind().bind("click", function () {
            if ($(mian).attr("data-uid") == "") {
                loginDialog();
            }
            else {
                $.ajaxJSONP(commonParams.wenkuPath + "/info/fav/id/" + $(mian).attr("data-id"), null, function (data) {
                    if (data.status == -1) {
                        promptMessageDialog({
                            icon: "warning",
                            content: data.msg,
                            time: 1000
                        });
                    }
                    else {
                        promptMessageDialog({
                            icon: "finish",
                            content: data.msg,
                            time: 1000
                        });
                    }
                });
            }
            return false;
        });
    },
    //评分操作
    toRemark: function () {
        var mian = this;
        return (function () {
            $(mian).unbind().bind("click", function () {
                //$("div.ratePopUps").css("display", "block");
                if ($(mian).attr("data-uid") == "") {
                    loginDialog();
                }

                else {
                    styledialog.initDialogHTML({
                        title: "评分",
                        url: commonParams.wenkuPath + "/info/remark",
                        width: 330,
                        confirm: {
                            show: true,
                            name: "确认"
                        },
                        cancel: {
                            show: true,
                            name: "取消"
                        }
                    });
                    styledialog.initContent("评分", "", function () {
                        $("li#li_zs").rateControl(new Array('完全没用', '有点用，但是没写完', '用处一般', '内容丰富，比较有帮助', '内容非常饱满，表达清晰有亮点', ''), "zsIndex");
                        $("li#li_ty").rateControl(new Array('格式错乱，没法读', '部分内容可读', '能读，但体验不好', '清晰可读', '超赞，适合在线阅读', ''), "tyIndex");

                        $("#PopupsFunc input[name='confirm']").unbind().bind("click", function () {
                            var zs = rateStarParams.zsIndex ? rateStarParams.zsIndex + 1 : 0;
                            var ty = rateStarParams.tyIndex ? rateStarParams.tyIndex + 1 : 0;
                            $.ajaxJSONP(commonParams.wenkuPath + "/info/mark_post/id/" + $(mian).attr("data-id") + "/zs/" + zs + "/ty/" + ty, null, function (data) {
                                if (data.status == 1) {
                                    styledialog.closeDialog();
                                    promptMessageDialog({
                                        icon: "finish",
                                        content: data.msg,
                                        time: 1000
                                    });
                                }
                                else if (data.status == -1) {
                                    styledialog.closeDialog();
                                    promptMessageDialog({
                                        icon: "warning",
                                        content: data.msg,
                                        time: 1000
                                    });
                                }
                            });
                            return false;
                        });
                    });
                }
                return false;
            });
        })();
    },
    //滑动评分插件
    rateControl: function (arrMark, starIndex) {
        var rateStarIndex = null;
        var main = this;
        var markAr = arrMark;
        if (this.length <= 0) {
            return false;
        }
        $(main).each(function () {
            var rateStarIcon = $(main).find("i");
            var rateStarLevel = $(main).find("span.orangeTxt");
            var markAr = arrMark;
            rateStarIcon.css("cursor", "pointer");
            rateStarIcon.bind({
                mouseover: function () {
                    var index = rateStarIcon.index($(this));
                    for (var n = 0; n < index + 1; n++) {
                        rateStarIcon[n].className = "icon_tc3";
                    }
                    rateStarLevel.html(markAr[index]);
                },
                mouseout: function () {
                    rateStarIcon.attr("class", "icon_tc2");
                    rateStarLevel.html(markAr[5]);
                },
                click: function () {
                    switch (starIndex) {
                        case "zsIndex":
                            rateStarParams.zsIndex = rateStarIcon.index($(this));
                            break;
                        case "tyIndex":
                            rateStarParams.tyIndex = rateStarIcon.index($(this));
                            break;
                        default:
                            break;
                    }
                    rateStarIndex = rateStarIcon.index($(this));
                    $("div.ratePopUps").find("a[name='a_confirm']").attr("class", "btnStyle1");
                    return false;
                }
            });
            $(this).find("span[name='i_stars']").bind("mouseleave", function () {
                if (rateStarIndex != null) {
                    for (var n = 0; n < rateStarIndex + 1; n++) {
                        rateStarIcon[n].className = "icon_tc3";
                    }
                    rateStarLevel.html(markAr[rateStarIndex]);
                }
            });
        });
    },
    //下载操作
    toDownload: function () {
        var mian = this;
        return $(mian).unbind().bind("click", function () {
            if ($(mian).attr("data-uid") == "") {
                loginDialog();
            }
            else {
                fileDownDialog(commonParams.wenkuPath + "/info/down?id=" + $(this).attr("data-url"));
            }
            return false;
        });
    }
});