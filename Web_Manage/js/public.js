// JavaScript Document
var public_ckecitor_chk = true;
var user_type_color = "label-success";

function getColorAry() {
    return ['007AFA', 'FA0300', '6BDC00', 'FF8F19', '7100DC', '000000'];
}

function openBox(links, width, height) {
    width = width || "80%";
    height = height || '80%';
    $.colorbox({
        href: links,
        iframe: true,
        innerWidth: width,
        innerHeight: height,
        scrolling: true,
        transition: 'fade',
        initialWidth: width,
        initialHeight: height,
        speed: 200
    });
}

function openBoxWithCB(links, callback) {
    width = "80%";
    height = '80%';
    callback = typeof (callback) === "function" ? callback : null;
    $.colorbox({
        href: links,
        iframe: true,
        innerWidth: width,
        innerHeight: height,
        scrolling: true,
        transition: 'fade',
        initialWidth: width,
        initialHeight: height,
        speed: 200,
        onClosed: callback
    });
}

function openVideo(links) {
    window.open(links);
}

function openPic(links) {
    width = "70%";
    height = '70%';
    $.colorbox({
        href: links,
        speed: 200,
        maxWidth: width,
        maxHeight: height,
        initialWidth: 100,
        initialHeight: 100,
        scrolling: true
    });
}

function closeBox() {
    $.colorbox.close();
}

function getTimeStamp() {
    var dt = new Date();
    return dt.getTime();
}

function none() {
}

function stripHTML(input) {
    var output = '';
    if (typeof (input) == 'string') {
        var output = input.replace(/(<([^>]+)>)/ig, "");
    }
    return output;
}

function resizeNicescroll() {
    try {
        //setTimeout(function(){$("html").getNiceScroll().resize();},300);
    } catch (e) {
    }
}

function ckeditorScrollFix() {

    CKEDITOR.on('instanceCreated', function (ev) {

        ev.editor.on('resize', function (reEvent) {
            resizeNicescroll();

        });
    });
    //
}

function pathToFile(str) {
    var nOffset = Math.max(0, Math.max(str.lastIndexOf('\\'), str.lastIndexOf('/')));
    var eOffset = str.lastIndexOf('.');
    if (eOffset < 0) {
        eOffset = str.length;
    }
    return {
        isDirectory: eOffset == str.length,
        path: str.substring(0, nOffset),
        name: str.substring(nOffset > 0 ? nOffset + 1 : nOffset, eOffset),
        extension: str.substring(eOffset > 0 ? eOffset + 1 : eOffset, str.length)
    };
}

function chkCkeditorScrollEvent() {
    if (public_ckecitor_chk == true) {
        resizeNicescroll();
        public_ckecitor_chk = false;
        setTimeout(function () {
            public_ckecitor_chk = true;
        }, 1000);
    }
}

function selectAll(nametag, selected) {
    $('body').find('input[name="' + nametag + '[]"]').prop('checked', selected);
    $('body').find('input[name="' + nametag + '"]').prop('checked', selected);
}

function JsonDateFormate(jsonDateTime, dateFormate) {
    dateFormate = dateFormate || "yyyy-MM-dd";

    return new Date(parseInt(jsonDateTime.substr(6))).f(dateFormate);
};

function dateValidationCheck(str) {
    var re = new RegExp("^([0-9]{4})[.-]{1}([0-9]{1,2})[.-]{1}([0-9]{1,2})$");
    var strDataValue;
    var infoValidation = true;

    if ((strDataValue = re.exec(str)) != null) {
        var i;
        i = parseFloat(strDataValue[1]);
        if (i <= 0 || i > 9999) { // 年
            infoValidation = false;
        }
        i = parseFloat(strDataValue[2]);
        if (i <= 0 || i > 12) { // 月
            infoValidation = false;
        }
        i = parseFloat(strDataValue[3]);
        if (i <= 0 || i > 31) { // 日
            infoValidation = false;
        }
    } else {
        infoValidation = false;
    }
    return infoValidation;
}

function isNumber(n) {
    return !isNaN(parseFloat(n)) && isFinite(n);
}


function showNotice(type, title, text) {
    var image = "";
    switch (type) {
        case "alert":
            image =  '../images/gitter/alert.png';
            break;
        case "ok" :
            image = '../images/gitter/ok.png';
            break;
        default:
            image = '../images/gitter/could.png';
            break;
    }
    $.gritter.add({
        title: title,
        text: text,
        image: image,
        sticky: false,
        time: ''
    });
}

var CODER = CODER || {};
CODER.namespace = function () {
    var a = arguments, o = null, i, j, d;
    for (i = 0; i < a.length; i = i + 1) {
        d = a[i].split(".");
        o = CODER;
        for (j = (d[0] == "CODER") ? 1 : 0; j < d.length; j = j + 1) {
            o[d[j]] = o[d[j]] || {};
            o = o[d[j]];
        }
    }
    return o;
};
CODER.namespace('CODER.Util');

function errorpic(obj) {

    $this = $(obj);
    $this.addClass('error_pic');
    $this.attr("src", site_root + "Content/images/imgback.png");
}

function getUserTypeTrClass(code) {
    if (code == "0") {
        return "table-flag-green";
    }
    if (code == "1") {
        return "table-flag-orange";
    }
    if (code == "2") {
        return "table-flag-blue";
    }
    if (code == "3") {
        return "table-flag-red";
    }
    if (code == "999") {
        return "table-flag-pink";
    }
}

function getUserTypeColor(code) {
    if (code == "GT") {
        return "label-success";
    }
    if (code == "KA") {
        return "label-warning";
    }
    if (code == "HRC") {
        return "label-info";
    }
}

function getInternalTypeTrColor(code) {
    if (code == "0") {
        return "table-flag-green";
    }
    if (code == "1") {
        return "table-flag-blue";
    }
    if (code == "2") {
        return "table-flag-orange";
    }
    if (code == "3") {
        return "table-flag-pink";
    }
    if (code == "4") {
        return "table-flag-gray";
    }
}

function bindCheckBoxSelectChk(obj_name, all_val) {
    $('input[name=' + obj_name + ']').click(function () {
        checkBoxSelectAll(obj_name, all_val);
    })
    checkBoxSelectAll(obj_name, all_val);
}

//function bindChosenSelectInsert(obj_name) {
//    $('#btn_'+obj_name).click(function () {
//        var val = $('#insert_' + obj_name).val();
//        if (val == '') {
//            alert("請先輸入要新增的標籤");
//        }
//        else {
//            var obj = $('#' + obj_name);
//            if ($("#"+obj_name+" option[value='"+val+"']").length > 0) {
//                var newOption = $('<option value="-1">'+val+'</option>');
//                newOption.attr("selected", true);
//                obj.append(newOption);
//                obj.trigger("change");
//                obj.trigger("liszt:updated");
//            }

//        }
//    })

//}
//判斷checkbox全選值是否有選取,若選取清空其它選項,並把其它選項改唯讀,若無選取,取消其它選項的唯讀方式
function checkBoxSelectAll(obj_name, all_val) {
    var isall = $('input[name=' + obj_name + '][value="' + all_val + '"]').prop('checked');

    $("input[name='" + obj_name + "']").each(function () {
        if ($(this).val() != all_val) {
            if (isall == true) {
                $(this).prop('checked', false);
                $(this).prop('disabled', true);
            } else {
                $(this).removeAttr("disabled");
            }
        }

    });
}

//數字加上千分位符號
function number_format(n) {
    n += "";
    var arr = n.split(".");
    var re = /(\d{1,3})(?=(\d{3})+$)/g;
    return arr[0].replace(re, "$1,") + (arr.length == 2 ? "." + arr[1] : "");
}

//返回兩物件的差集物件
function getTwoObjChanges(prev, now) {
    var changes = {}, prop, pc;
    for (prop in now) {
        if (!prev || prev[prop] !== now[prop]) {
            if (typeof now[prop] == "object") {
                if (c = getTwoObjChanges(prev[prop], now[prop]))
                    changes[prop] = c;
            } else {
                changes[prop] = now[prop];
            }
        }
    }
    for (prop in changes)
        return changes;
    return false; // false when unchanged
}

function getNowTime() {//取得現在時間
    var timeDate = new Date();
    var tMonth = (timeDate.getMonth() + 1) > 9 ? (timeDate.getMonth() + 1) : '0' + (timeDate.getMonth() + 1);
    var tDate = timeDate.getDate() > 9 ? timeDate.getDate() : '0' + timeDate.getDate();
    var tHours = timeDate.getHours() > 9 ? timeDate.getHours() : '0' + timeDate.getHours();
    var tMinutes = timeDate.getMinutes() > 9 ? timeDate.getMinutes() : '0' + timeDate.getMinutes();
    var tSeconds = timeDate.getSeconds() > 9 ? timeDate.getSeconds() : '0' + timeDate.getSeconds();
    return timeDate = timeDate.getFullYear() + '-' + tMonth + '-' + tDate + ' ' + tHours + ':' + tMinutes + ':' + tSeconds;
}

$(document).on('cbox_open', function () {
    $('body').css({overflow: 'hidden'});
}).on('cbox_closed', function () {
    $('body').css({overflow: ''});
});