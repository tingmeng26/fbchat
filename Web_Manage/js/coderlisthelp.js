//coderlisthelp.js v2.2
//v1.1  增加delete_note,刪除時的備註說明
//v2 增加filterinit
//v2.1 修正沒管理區時排序不會出現的BUG
//v2.2 修改filterform位置可與parent分離 (by khai)
//v2.2 多個table可共用一個filterform，新增自定義屬性form_name (by khai)
//v2.3 可拖曳排序，新增自定義屬性ordersortable (by khai)
(function ($) {
    $.fn.coderlisthelp = function (settings) {

        var _defaultSettings = {
            callback: null,
            listComplete: null,
            ajaxsrc: "",
            delsrc: "",
            editlink: "",
            ordersrc: "",
            ordersortable: "",
            excelsrc: "",
            page: 1,
            debug: false,
            delete_note: "",
            form_name: "",
            tableLog: "",
        };
        var _settings = $.extend(_defaultSettings, settings);

        return this.each(function () {

            var parent = $(this);
            var content = parent.find('tbody:first');
            var pagecontent = parent.find('#listtable_page');
            var form_name = _settings.form_name != "" ? _settings.form_name : parent.attr("id");

            //000000000000000000000000000000
            // var filterform = $("form#" + form_name + "filterform");
            var filterform = $("form[id='filterform']");
            //000000000000000000000000000000

            var message = "";
            var mutileselect = false;
            var manage = false;
            var tableLog = _settings.tableLog ? $(_settings.tableLog) : $('#tableLog');

            function init() {
                filterInit();
                linkInit();

                parent.find('th').each(function () {
                    var th = $(this);
                    //如果有mutileselect功能
                    if ($(this).attr('attr') === 'mutileselect') {
                        mutileselect = true;
                        var checked = $(this).prop('checked');
                        $(this).find('input[type="checkbox"]').click(function () {
                            parent.find('tbody tr td:eq(0)').prop('checked', checked);
                        });
                    }
                    //操作功能
                    else if ($(this).attr('attr') === 'manage') {
                        manage = true;
                    }
                    //排序功能
                    else if ($(this).attr('attr') === 'order') {
                        manage = true;
                        var sorttype = "";
                        if ($(this).attr('desc') === 'desc') {
                            sorttype = "sort-desc";
                        } else {
                            sorttype = "sort-asc";
                        }
                        var obj = $(this).find('a');
                        obj.attr('class', sorttype + ' sort-active');
                        obj.click(function (event) {
                            parent.find('th a.sort-active').prop('class', 'sort-asc sort-desc');
                            obj.attr('class', sorttype + ' sort-active');
                            showList();
                        });
                    } else {
                        //一般排序樣式處理
                        var obj = $(this).find('a');
                        var css = obj.attr('class');
                        if (css && css.indexOf('sort-') > -1) {
                            obj.click(function (event) {
                                var css = obj.attr('class');
                                if (css.indexOf('sort-active') < 0) { //非作用中
                                    parent.find('th a.sort-active').prop('class', 'sort-asc sort-desc');
                                    obj.attr('class', 'sort-asc sort-active');
                                } else { //作用中
                                    obj.prop('class', (css.indexOf('sort-asc') < 0) ? 'sort-asc sort-active' : 'sort-desc sort-active');
                                }
                                showList();
                            });
                        }
                    }
                });

                //搜尋鈕處理
                filterform.find('#submit').click(function () {
                    showList('submit');
                });
                parent.find('#refreshBtn').click(function () {
                    showList();
                });
                //複數刪除鈕處理
                parent.find('#mutileDelBtn').click(function () {
                    deleteChooseItem();
                });
                //拖曳排序
                if (_settings.ordersortable != '') {
                    parent.find('tbody').sortable({
                        opacity: 0.8, //設定拖動時的透明度
                        helper: "clone",
                        cancel: "a",
                        cursor: 'move', //拖動時的游標樣式
                        update: function (event, ui) {
                            ordersortableList(ui.item.attr('orderlink'), $(this).sortable('serialize'), '移動' + ui.item.attr('title'));
                        },
                    }).disableSelection();
                }

            }

            function filterInit() {
                //雙層下拉初始化
                filterform.find("div.myform-group[datatype=mutile_select]").each(function () {
                    $(this).coderfilter_mutileselect();
                });
            }

            function linkInit() {
                if (parent.attr('ajaxsrc')) {
                    _settings.ajaxsrc = parent.attr('ajaxsrc');
                    parent.removeAttr('ajaxsrc');
                }
                if (parent.attr('delsrc')) {
                    _settings.delsrc = parent.attr('delsrc');
                    parent.removeAttr('delsrc');
                }
                if (parent.attr('editlink')) {
                    _settings.editlink = parent.attr('editlink');
                    parent.removeAttr('editlink');
                }
                if (parent.attr('ordersrc')) {
                    _settings.ordersrc = parent.attr('ordersrc');
                    parent.removeAttr('ordersrc');
                }
                if (parent.attr('ordersortable')) {
                    _settings.ordersortable = parent.attr('ordersortable');
                    parent.removeAttr('ordersortable');
                }
                if (parent.attr('excelLink')) {
                    _settings.excelsrc = parent.attr('excelLink');
                    parent.removeAttr('excelLink');
                    //匯出XLS
                    parent.find('#excelBtn').click(function () {
                        exportXls();

                        var sum = false;

                        // setTimeout(function () {
                        //     //這邊寄信
                        //     if (sum == false) {
                        //         $.ajax({
                        //             url: 'SendMail/Index',
                        //             type: "POST",
                        //             data: {},
                        //             dataType: "json",
                        //             success: function (data) {
                        //                 if (data.result == true) {
                        //                     sum = true;
                        //                 } else {

                        //                 }

                        //             },
                        //             error: function (xhr, ajaxOptions, thrownError) {

                        //                 oops("讀取資料時發生錯誤,請梢候再試" + thrownError, xhr);
                        //                 stopload();
                        //             }
                        //         });
                        //     }

                        // }, 5000);
                    });
                }
                parent.find('#addBtn').colorbox({
                    iframe: true,
                    innerWidth: '80%',
                    innerHeight: '80%',
                    scrolling: true,
                    transition: 'none',
                    initialWidth: '80%',
                    initialHeight: '80%',
                    speed: 200,
                    overlayClose: false,
                    onClosed: function () {
                        parent.find('#refreshBtn').click();
                        tableLog.find('#refreshBtn').click();
                    },
                });
            }

            function deleteChooseItem() {
                var list = new Array();
                var listname = "";
                parent.find('tbody tr').each(function () {
                    var tr = $(this);
                    if (tr.find('td:eq(0) input[type="checkbox"]').prop("checked")) {
                        list[list.length] = tr.attr('delkey');
                        listname += '\r\n' + tr.attr('title');
                    }
                });
                if (list.length > 0) {
                    if (confirm(getDeleteStr(listname))) {
                        deleteList(list);
                    }
                } else {
                    alert('請先選擇要被刪除的項目');
                }
            }

            function deleteItem(id, title) {
                if (confirm(getDeleteStr(title))) {
                    var list = new Array();
                    list[0] = id;
                    deleteList(list);
                }
            }

            function getDeleteStr(title) {
                var str = '您確定要刪除這些項目嗎?' + title;
                if (_settings.delete_note != "") {
                    str = _settings.delete_note + "\r\n" + str;
                }
                return str;
            }

            function orderList(para, title) {
                startload();
                hideorder();
                var parent = this;
                $.ajax({
                    url: _settings.ordersrc,
                    cache: false,
                    type: "POST",
                    data: para,
                    dataType: "json",
                    success: function (data) {
                        if (data.result == true) {
                            showList();
                            showNotice('ok', '排序作業完成', '您己成功' + title);
                        } else {
                            showNotice('alert', '排序作業失敗', data.msg);
                        }
                        stopload();
                    }
                    , error: function (xhr, ajaxOptions, thrownError) {

                        oops("讀取資料時發生錯誤,請梢候再試" + thrownError, xhr);
                        stopload();
                    }
                });
            }

            function ordersortableList(_orderlink, _ids, title) {
                startload();
                hideorder();
                var parent = this;
                $.ajax({
                    url: _settings.ordersortable,
                    cache: false,
                    type: "POST",
                    data: _orderlink + '&' + _ids.replace(/\[\]/gi, "") + '&method=sortable',
                    dataType: "json",
                    success: function (data) {
                        if (data.result == true) {
                            showList();
                            showNotice('ok', '排序作業完成', '您己成功' + title);
                        } else {
                            showNotice('alert', '排序作業失敗', data.msg);
                        }
                        stopload();
                    }
                    , error: function (xhr, ajaxOptions, thrownError) {

                        oops("讀取資料時發生錯誤,請梢候再試" + thrownError, xhr);
                        stopload();
                    }
                });
            }

            function deleteList(list) {
                startload();
                var parent = this;
                $.ajax({
                    url: _settings.delsrc,
                    cache: false,
                    type: "POST",
                    data: {id: list},
                    dataType: "json",
                    success: function (data) {
                        if (data.result == true) {
                            showList();
                            showNotice('ok', '刪除作業完成', '您己成功刪除' + data.count + '筆資料');
                        } else {
                            showNotice('alert', '刪除作業失敗', data.msg);
                        }
                        stopload();
                    }
                    , error: function (xhr, ajaxOptions, thrownError) {
                        oops("讀取資料時發生錯誤,請梢候再試" + thrownError, xhr);
                        stopload();
                    }
                });
            }

            function showList(butType) {

                startload();
                var parent = this;
                var callback = _settings.callback;
                var listComplete = _settings.listComplete;
                $.ajax({
                    url: _settings.ajaxsrc,
                    cache: false,
                    type: "GET",
                    data: getPara(butType),
                    dataType: "json",
                    success: function (data) {
                        if (data) {
                            if (data['result'] == true) {
                                if (callback && typeof (callback) == 'function') {
                                    callback(content, data["data"], getSearchPara(), filterform);
                                }
                                showModifyContent();
                                showPage(data["page"]);
                                chkCkeditorScrollEvent();
                                if (listComplete && typeof (listComplete) == 'function') {
                                    listComplete();
                                }
                            } else {
                                oops(data['data']);
                            }
                        } else {
                            oops("回傳資料錯誤");
                        }
                        stopload();
                    }
                    , error: function (xhr, ajaxOptions, thrownError) {
                        oops("讀取資料時發生錯誤,請梢候再試" + thrownError, xhr);
                        stopload();
                    }
                });
            }

            function showModifyContent() {

                if (mutileselect) {
                    parent.find('tbody tr').each(function () {
                        $(this).prepend('<td><input type="checkbox"></td>');
                    })
                }
                if (manage) {


                    //是否排序作用中欄位判斷
                    var orderclass = 'disabled';
                    var ordertitle = '必須要用排序欄位排序才可使用';
                    var orderth = parent.find('th[attr="order"] a.sort-active');
                    if (orderth.index() > -1) {
                        orderclass = ' btn-info ';
                        ordertitle = '';
                        if (_settings.ordersortable != '') {
                            parent.find('tbody').sortable("enable")
                        }
                        ;//拖曳排序啟用
                    } else {
                        if (_settings.ordersortable != '') {
                            parent.find('tbody').sortable("disable")
                        }
                        ;//拖曳排序禁止
                    }
                    //畫各個按鈕
                    parent.find('tbody tr').each(function () {

                        var tr = $(this);
                        var title = tr.attr('title');
                        //排序按鈕

                        if (_settings.ordersrc != "" && tr.attr('orderlink') != '') {

                            var td = $('<td class=" text-center"></td>');
                            var up = $('<a class="btn btn-sm show-tooltip ' + orderclass + '" title="上移' + ordertitle + '" href="#"><i class="icon-angle-up"></i></a>');
                            up.click(function () {
                                orderList(tr.attr('orderlink') + '&method=up', '上移' + title);
                            });
                            td.append(up);
                            var down = $('<a class="btn btn-sm show-tooltip ' + orderclass + '" title="下移' + ordertitle + '" href="#"><i class="icon-angle-down"></i></a>');
                            down.click(function () {
                                orderList(tr.attr('orderlink') + '&method=down', '下移' + title);
                            });
                            td.append(down);
                            $(this).append(td);
                        }

                        //管理按鈕
                        if (_settings.editlink != "" || _settings.delsrc != "") {
                            var td = $('<td class="text-center"></td>');
                            if (_settings.editlink != "") {
                                var edit = $('<a class="btn btn-sm show-tooltip btn-inverse" title="修改' + title + '" href="javascript:void(0)"><i class="icon-edit"></i></a>');
                                edit.click(function () {
                                    $.colorbox({
                                        href: _settings.editlink + (_settings.editlink.indexOf('?') === -1 ? '?' : '&') + tr.attr('editlink'),
                                        iframe: true,
                                        innerWidth: '80%',
                                        innerHeight: '80%',
                                        scrolling: true,
                                        transition: 'none',
                                        initialWidth: '80%',
                                        initialHeight: '80%',
                                        speed: 200,
                                        onClosed: function () {
                                            parent.find('#refreshBtn').click();
                                            tableLog.find('#refreshBtn').click()
                                        },
                                        overlayClose: false
                                    });
                                });
                                td.append(edit);
                            }
                            if (_settings.delsrc != "") {
                                var del = $('<a class="btn btn-sm btn-danger show-tooltip" title="刪除' + title + '" href="javascript:void(0)"><i class="icon-trash"></i></a>');
                                del.click(function () {
                                    deleteItem(tr.attr('delkey'), title);
                                });
                                td.append(del);
                            }

                            $(this).append(td);
                        }
                    })
                }
            }

            function showPage(page) {
                pagecontent.html('');
                if (typeof page === 'object' && page['count'] > 0) {
                    var $left = $('<div style="float:left"></div>');
                    $left.append((page["begin"] + 1) + '-' + Math.min(page["show_num"], page["count"]) + ' of ' + page["count"] + ' &nbsp; Page: ' + page["page"] + "/" + page["pagecount"] + ' ');
                    $left.append("&nbsp;&nbsp; Rows per Page:");
                    $select = $("<select id=\"PageNum\" name=\"PageNum\" />");
                    //$select.append('<option value="1" >1</option>');
                    for (var i = 5; i < 31; i += 5) {
                        $select.append('<option value="' + i + '" ' + ((page["show_num"] == i + '') ? 'selected' : '') + '>' + i + '</option>');
                    }
                    $select.change(function (event) {
                        showList();
                    });
                    $left.append($select);
                    //$left.append('筆');
                    pagecontent.append($left);

                    var $right = $('<div style="float:right"></div>');
                    $right_content = $('<ul class="pagination"></ul>');

                    var _page = parseInt(page["page"]);
                    var page_start = parseInt(page["s_start"]);
                    var page_end = parseInt(page["s_end"]);


                    if (_page > page_start) {
                        $btn = $('<li><a href="javascript:void(0)">← Prev</a></li>');
                        bindPageClick($btn, _page - 1);
                        $right_content.append($btn);

                    }
                    for (var i = page_start; i <= page_end; i++) {
                        var $li = $('<li ' + (_page == i ? 'class="active"' : '') + '><a href="javascript:void(0)">' + i + '</a></li>');
                        bindPageClick($li, i);
                        $right_content.append($li);
                    }
                    if (_page < page_end) {
                        $btn = $('<li><a href="javascript:void(0)">Next → </a></li>');
                        bindPageClick($btn, _page + 1);
                        $right_content.append($btn);
                    }
                    $right.append($right_content);
                    pagecontent.append($right);
                }
            }

            function exportXls() {
                var para = getPara();
                var str = "";
                var separator = "?";
                for (var key in para) {
                    str += "&" + key + "=" + para[key];
                }
                if (_settings.excelsrc.indexOf("?") !== -1) {
                    separator = "&";
                }
                if (str != "") {
                    location.href = _settings.excelsrc + separator + str.substr(1);
                }
            }

            function bindPageClick($obj, ind) {
                $obj.click({ind: ind}, function (event) {
                    _settings.page = event.data.ind;
                    showList();
                });
            }

            function getPara(butType) {

                var orderobj = parent.find('th').find('a.sort-active');
                if (orderobj.index() < 0) {
                    orderobj = parent.find('th').find('a.sort-desc:eq(0)');
                }
                var orderkey = orderobj.attr("sortkey");
                var oderclass = orderobj.prop("class");
                var orderdesc = oderclass ? ((oderclass.indexOf('sort-asc') < 0) ? 'desc' : 'asc') : 'desc';

                var _page = _settings.page

                if (butType == 'submit') {
                    _page = 1;
                }

                var para = {
                    page: _page,
                    pagenum: parent.find('#PageNum').val(),
                    orderkey: orderkey,
                    orderdesc: orderdesc
                }
                $.extend(para, getSearchPara());
                // console.log(para);
                return para;

            }

            function getSearchPara() {
                message = "";
                var para = {};
                if (filterform != null && filterform != 'undefined') {

                    filterform.find(':input').each(function () {
                        var obj = $(this);
                        var otype = obj.getType();
                        switch (otype) {
                            case 'text':
                                para[obj.attr('id')] = checkFormat(obj) ? obj.val() : '';
                                break;
                            case 'hidden':
                                para[obj.attr('id')] = obj.val();
                                break;
                            case 'select':
                                para[obj.attr('id')] = obj.val();
                                break;
                            case 'checkbox':
                                if (obj.prop('checked')) {
                                    if (!para[obj.attr('id')]) {
                                        para[obj.attr('id')] = new Array();
                                    }
                                    para[obj.attr('id')][para[obj.attr('id')].length] = obj.val();
                                }
                                break;
                        }
                    })
                    if (message != "") {
                        showNotice('alert', '您的搜尋條件無法順利執行', '有些欄位格式不正確導致搜尋無法完全顯示,請檢查輸入條件是否正確!<br>' + message);
                    }

                }
                return para;

            }

            function checkFormat(obj) {
                var val = obj.val()
                //日期格式確認
                if (obj.hasClass("date-picker") && val != '') {
                    if (!dateValidationCheck(val)) {
                        obj.addClass('myform-error');
                        message += val + '必須為yyyy-mm-dd格式<br>';
                    } else {
                        obj.removeClass('myform-error');
                        return true;
                    }
                } else if (obj.attr("format") == "numeric") {
                    if (!isNumber(val) && val != '') {
                        obj.addClass('myform-error');
                        message += val + '必須為數字格式<br>';
                    } else {
                        obj.removeClass('myform-error');
                        return true;
                    }
                } else {
                    return true;
                }
            }

            function oops(msg, data) {
                showNotice('alert', '作業失敗', msg);
                if (_settings.debug == true) {
                    console.log(data);
                }
                stopload();
            }

            function startload() {
                parent.find('#filterloading').show();
            }

            function stopload() {
                parent.find('#filterloading').hide();
            }

            function hideorder() {
                parent.find('td a.btn-info').addClass('disabled').removeClass('btn-info');
            }

            _settings.page = 1;
            init();
            showList();

        });
    }


})(jQuery);