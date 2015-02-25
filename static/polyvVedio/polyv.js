/*
 * js for TM.html
 */

$(function() {
  TM.popTM(); //弹幕设置
  TM.getData(); //获取并发送弹幕设置数据
});


var TM = {};
/*
 *popTM()弹幕设置
 */
TM.popTM = function() {
    var designDom = $(".TM-wrap"),
      btnDom = $(".TM-wrapinner"),
      popDom = $(".TM-pop"),
      TMbtnDom = $(".TM-btn");


    var Btnleft = "";

    popDom.hide();
    TMbtnDom.click(function(e) {
      e.stopPropagation();
      popDom.toggle();
    });


    $(".mask").click(function() { //遮罩层，点击则隐藏弹幕设置面板
      popDom.hide();
    });

    /* $("body").click(function(){
            popDom.hide();
        }); */


    designDom.click(function(e) {
      e.stopPropagation();

      Btnleft = btnDom.position().left;

      if (Btnleft == 0) { //开启弹幕

        j2s_showBarrage();

        btnDom.css("left", "28px");
        $(this).css("background-color", "#4a90d1");
      } else { //关闭弹幕

        j2s_hideBarrage();

        $(this).css("background-color", "#3d3d3d");
        btnDom.css("left", "0px");
      }
    });
  }
  /*
   *getData()
   *获取发送弹幕内容
   */
TM.getData = function() {
  var TMdata = {}; //TMdata为弹幕数据
  /**默认值**/
  TMdata.fontSize = $("#fontSize").val();
  TMdata.fontMode = $("#fontMode").val();
  TMdata.fontColor = $("#fontColor").val();
  TMdata.msg = $("#msg").val();
  TMdata.state
    /**选取的值**/
  $("#fontSize").change(function() {
    TMdata.fontSize = $(this).val();
  });
  $("#fontMode").change(function() {
    TMdata.fontMode = $(this).val();
  });
  $("#fontColor").change(function() {
    TMdata.fontColor = $(this).val();
  });
  $("#msg").change(function() {
    TMdata.msg = $(this).val();
  });

  $(".TM-send").click(function(e) { //点击发送按钮
    e.stopPropagation();

    var time = getPlayer("polyvplayer").GetCurrentTime(); //调用swf播放器函数
    var hour = Math.floor(time / 3600);
    var minute = Math.floor((time % 3600) / 60);
    var second = (time % 60) + 2;

    var timeformatted = hour + ":" + minute + ":" + second;

    var PostData = {
      //需要发送的数据
      vid: $(this).data("vid"),
      msg: TMdata.msg.replace(/"/g, "\\\""),
      time: timeformatted,
      fontSize: TMdata.fontSize,
      fontMode: TMdata.fontMode,
      fontColor: TMdata.fontColor,
      timestamp: timestamp()
    };

    var dummy = new iframeform('http://go.polyv.net/mu/add?');
    dummy.addParameter('vid', PostData.vid);
    dummy.addParameter('msg', PostData.msg);
    dummy.addParameter('time', PostData.time);
    dummy.addParameter('fontSize', PostData.fontSize);
    dummy.addParameter('fontMode', PostData.fontMode);
    dummy.addParameter('fontColor', PostData.fontColor);
    dummy.addParameter('timestamp', PostData.timestamp);
    dummy.send();

    j2s_reloadBarrageData();


    var comment_type = $("div[name='get_comment_list']").attr('comment_type');
    var comment_type_id = $("div[name='get_comment_list']").attr('comment_type_id');
    var comment_content = $("#msg").val();
    var datas = '';
    if ($.trim(comment_content).length == 0) {
      promptMessageDialog({
        icon: "warning",
        content: '内容不能为空!',
        time: 1000
      });
      return false;
    }

    //ajax请求
    $.get(commonParams.wenkuPath + "/Comment/addComment", {
      'comment_type': comment_type,
      'comment_type_id': comment_type_id,
      'comment_content': comment_content
    }, function(data) {
      try {
        datas = eval('(' + data + ')');
      } catch (e) {
        datas = data;
      }

      if (datas.type == 'login') {
        loginDialog();
        return false;
      } else if (datas.type == 'error') {
        promptMessageDialog({
          icon: "warning",
          content: '添加失败!',
          time: 1000
        });
        return false;
      } else {
        promptMessageDialog({
          icon: "finish",
          content: '添加成功!',
          time: 1000
        });
        $("div[name='all_comment']").find("ul").prepend(datas.data);
      }
    });


    /*alert(PostData.vid+"");
    $.post("http://go.polyv.net/mu/add?",PostData,function(){
       $("#msg").val("");
       j2s_reloadBarrageData();
    }); */
  });
}


function iframeform(url) //创建form和iframe
  {
    var object = this;
    object.time = new Date().getTime();

    object.addParameter = function(parameter, value) {
      $("<input type='hidden' />")
        .attr("name", parameter)
        .attr("value", value)
        .appendTo(object.form);
    };

    object.form = $('<form action="' + url + '" target="iframe' + object.time + '" style="display:none;" method="post"  id="form' + object.time + '" name="form' + object.time + '"></form>');

    /* object.form = $('<form action="'+url+'" target="iframe'+object.time+'" style="display:none;" method="post"  id="form'+object.time+'"></form>'); */



    object.send = function() {
      var iframe = $('<iframe data-time="' + object.time + '" style="display:none;" id="iframe' + object.time + '" name="iframe' + object.time + '"></iframe>');
      $("body").append(iframe);
      $("body").append(object.form);
      object.form.submit();
      iframe.load(function() {

        $('#form' + $(this).data('time')).remove();
        $(this).remove();
        j2s_reloadBarrageData();
        $("#msg").val("");

      });

    }
  }


// function saveReport(){
//  $("form").ajaxSubmit(function(message){
//    alert("jquery成功返回");
//  });
//  return false; 
// }

/****************定义*************/
function timestamp() {
  var timestamp = Date.parse(new Date());
  return timestamp;
}


function getPlayer(movieName) {
  if (navigator.appName.indexOf("Microsoft") != -1) {

    return $("#" + movieName)[0];
  } else {
    return document[movieName];
  }
}

function s2j_callOnBarrageUrl() {
  var vid = $(".TM-send").data("vid");
  return "http://go.polyv.net/mu/" + vid + ".json";

}

function j2s_showBarrage() {
  var player = thisMovie("polyvplayer");
  if (player != undefined && player.j2s_showBarrage != undefined) {
    player.j2s_showBarrage();
  }
}

function j2s_hideBarrage() {
  var player = thisMovie("polyvplayer");
  if (player != undefined && player.j2s_hideBarrage != undefined) {
    player.j2s_hideBarrage();
  }
}

function j2s_reloadBarrageData() {
  var player = thisMovie("polyvplayer");
  if (player != undefined && player.j2s_reloadBarrageData != undefined) {
    player.j2s_reloadBarrageData();
  }
}

function j2s_addBarrageMessage() {
  var player = thisMovie("polyvplayer");
  if (player != undefined && player.j2s_addBarrageMessage != undefined) {
    player.j2s_addBarrageMessage('[{"msg":"登登登登dedede!!!!","time":"0:0:16","fontSize":"big","fontColor":"0xffffff","fontMode":"roll"},{"msg":"等等等的呢嗯的呢!!!!","time":"0:0:16","fontSize":"big","fontColor":"0xffffff","fontMode":"roll"},{"msg":"苏打水苏打水!!!!","time":"0:0:16","fontSize":"big","fontColor":"0xffffff","fontMode":"roll"}]');
  }

}

function thisMovie(movieName) {
    if (navigator.appName.indexOf("Microsoft") != -1) {
      var reObj = window[movieName];
      //ie10下面是collection集合
      try {
        if (reObj.length > 0) {
          return reObj[0];
        }

      } catch (e) {

      }



      return;
    } else {
      return document[movieName];
    }
  }
  /*****************************/