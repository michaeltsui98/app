﻿jQuery(function ($) {

    $('div.seaNav div').not('div.active').hover(
        function () {
            $(this).addClass('active').find('a').addClass('whiteA');
        },
        function () {
            $(this).removeClass('active').find('a').removeClass('whiteA');
        }
    );
    $('#search').clearText();
    // 搜索
    $('#search').initSearch();
    //点击搜索跳转
    $("#a_search").unbind().bind("click", function () {
        if ($.trim($("#search").val()) != "") {
            window.location.href = '/search/key/' + $.trim($("#search").val()) + '/type/' + $("input[name='tstradio']:checked").val();
        }
        return false;
    });
    //点击获取搜索排名
    $("#search-hotword").unbind().bind("click", function () {
        var mian = this;
        AjaxForJson("/index/words", null, function (dataObj) {
            var resHTML = '';
            var keyIndex = 1;
            for (var key in dataObj) {
                var className = keyIndex <= 3 ? "hot" : "";
                resHTML += '<li class="associateCell"><a href="javascript:;" title="" keyName="' + key + '"><em class="' + className + '">' + keyIndex + '</em>' + key + '</a></li>';
                keyIndex++;
            }
            $("#suggest-search").show().html(resHTML);
            $("#suggest-search").find("li.associateCell").find("a").unbind().bind("click", function () {
                window.location.href = '/search/key/' + $(this).attr("keyName") + '/type/0';
                return false;
            });
        });
        return false;
    });
});

jQuery.fn.extend({
    initSearch: function () {
        if (this.length <= 0) {
            return false;
        }
        var id = this.attr('id');
        var main = this;
        main.extend({
            // 搜索建议容器
            suggest: jQuery('#suggest-' + id),
            // 搜索建议选项
            suggestItem: null,
            // 当前选中的搜索建议索引值
            currentIndex: null,
            currentItem: null,
            activeColor: '#F6F6F6',
            itemColor: '#FFFFFF',
            // 搜索建议
            showsuggest: function (keyword) {
                jQuery.getJSON('/index/suggest/key/' + keyword, null, function (data) {
                    if (data.length > 0) {
                        var html = '';
                        jQuery.each(data, function (item) {
                            html += '<li class="associateCell"><a href="javascript:;" title="">' + data[item] + '</a></li>';
                        });
                        main.suggestItem = main.suggest.html(html).show().find('li.associateCell');
                        main.suggestItem.bind({
                            click: function (e) {
                                // 设置输入框的值为选中的值
                                var value = jQuery(this).text();
                                main.val(value);
                                main.search(value);

                                // 隐藏预搜索
                                //main.preSearch(value);

                                // 隐藏搜索建议
                                main.suggest.hide();
                            }
                        }).hover(
                            function (e) {
                                this.style.backgroundColor = main.activeColor;
                            },
                            function (e) {
                                this.style.backgroundColor = main.itemColor;
                            }
                        );
                    };
                }, 'json')
            },
            // 选中上一个搜索建议
            selectPrev: function () {
                if (main.currentIndex == null || main.currentIndex <= 0) {
                    main.currentIndex = main.suggestItem.length;
                };
                main.currentIndex -= 1;
                main.focusCurrent();
            },
            // 选中上一个搜索建议
            selectNext: function () {
                if (main.currentIndex == null) {
                    main.currentIndex = -1;
                }
                main.currentIndex += 1;
                main.focusCurrent();
            },
            // 当前元素获取焦点
            focusCurrent: function () {
                main.currentItem = jQuery(main.suggestItem.get(main.currentIndex));
                main.val(main.currentItem.text());
                main.currentIndex %= main.suggestItem.length;
                main.suggestItem.css('backgroundColor', main.itemColor);
                main.currentItem.css('backgroundColor', main.activeColor);
            },
            // 预搜索
            preSearch: function (keyword) {
                jQuery.get(window.location.href, { 'keyword': keyword }, function (html) {
                    jQuery("div.SQserpCon").html(html);
                }, 'html');
            },
            search: function (keyword) {
                if (keyword.length > 1) {
                    window.location.href = '/search/key/' + keyword + '/type/' + $("input[name='tstradio']:checked").val();
                }
            }
        }).bind({
            keyup: function (e) {
                switch (e.keyCode) {
                    // 向下键
                    case 40:
                        main.selectNext();
                        break;
                        // 向上键
                    case 38:
                        main.selectPrev();
                        break;
                        // 回车键
                    case 13:
                        // 阻止回车提交事件
                        e.preventDefault();
                        if (main.currentIndex != null) {
                            main.search(main.currentItem.text());
                        }
                        break;
                    default:
                        var e_value = jQuery.trim(e.target.value);
                        if (e_value.length > 0) {
                            main.showsuggest(e_value);
                        }
                }

            }
        }).parent().bind({
            submit: function (e) {
                // 如果搜索的关键字长度过少则不提交
                if (main.val().length < 2) {
                    return false;
                }
            }
        });

        $('body').bind({
            click: function (e) {
                main.suggest.hide();
            }
        })
    }
});