var wComm = {};
/**
 * Ajax Util
 * successFn : function(responseText) {
 * }
 */
wComm.getS = function(param, beforeSendFn, endFn, successFn) {
	wComm.doS(param, param.url, beforeSendFn, endFn, successFn);
};
wComm.doS = function(param, url, beforeSendFn, endFn, successFn) {
	if (url == undefined || url == null  || url == "") {
		url = param.url;
	}
	var type = "post";
	if (param._method) {
		type = param._method;
	}

	jQuery.ajax({
		type : type
		, url : url
		, data : param
		, cache: false
		, async: true
		, beforeSend : beforeSendFn
		, complete : function(result) {
			if (endFn) {
				endFn();
			}
			if (successFn) {
				successFn(result);
			}
		}
	});
};
wComm.parseJs = function(msg) {
	try {
		if ((typeof msg).toLowerCase() == "string") {
			msg = jQuery.parseJSON(msg);
		}
	} catch(ex) {
		msg += "\n";
		msg += ex.message;
	}
	return msg;
};
/**
 * Event 종료
 */
wComm.eventDone = function(event) {
	event.preventDefault();
	event.stopPropagation();
};
wComm.isEmpty = function(val) {
	if (val == undefined || val == null || jQuery.trim(val).length == 0 || val == "null") {
		return true;
	} else {
		return false;
	}
};
wComm.nvl = function(str, def) {
	str = jQuery.trim(str);
	def = jQuery.trim(def);
	return wComm.isEmpty(str)?def:str;
};
wComm.fmtDigit = function(val) {
	val += "";
	return val.replace(/\D/gi, "");
};
wComm.fmtNumber = function(val) {
	val += "";
	val = val.replace(/[^0-9\-\.]/gi, "");
	if (!/\.$/gi.test(val)) {
		val = Number(val);
		if (!val) {
			val = "0";
		}
	}
	val += "";
	return val;
};
wComm.fmtNumberObj = function(obj) {
	var $obj = jQuery(obj);
	$obj.val(wComm.fmtNumber($obj.val()));
};
wComm.fmtCurrencyObj = function(obj) {
	var $obj = jQuery(obj);
	$obj.val(wComm.fmtCurrency($obj.val()));
};
/**
 * 천단위 쉼표
 */
wComm.fmtCurrency = function(value) {
	var no = wComm.fmtNumber(value);
	var reg = /(^[+-]?\d+)(\d{3})/;
	no += "";
	while (reg.test(no)) {
		no = no.replace(reg, "$1" + "," + "$2");
	}
	return no;
};
/**
 * 이메일 확인
 */
wComm.isEmail = function(str) {
	var filter = /^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i;
	return filter.test(str);
};
/**
 * 전화번호 확인
 * @param value
 * @returns {boolean}
 */
wComm.isPhone = function(value) {
	value = wComm.fmtDigit(value);
	var filter = /(^0[1-9][0-9]?)([1-9][0-9]{2,3})([0-9]{4})$/gi;
	return filter.test(value);
};
/**
 * input focus and blur event function
 */
wComm.setInput = function($obj, type, val) {
	if (type == "IN" && $obj.val() == val) {
		$obj.val("");
	} else if (type == "OUT" && $obj.val() == "") {
		$obj.val(val);
	}
};
/**
 * 범용 구분자 추가
 */
wComm.fmtSD = function(str, def){
	if (wComm.isEmpty(str)) {
		return "";
	}
	str += "";
	def += "";
	var sLen = str.length;
	var dLen = def.length;

	if(dLen > 0){
		switch(sLen){
			case 2 : str = str.substr(0, 1) + def + str.substr(1, 1); break;
			case 3 : str = str.substr(0, 1) + def + str.substr(1, 2); break;
			case 4 : str = str.substr(0, 2) + def + str.substr(2, 2); break;
			case 6 : str = str.substr(0, 2) + def + str.substr(2, 2) + def + str.substr(4, 2); break;
			case 8 : str = str.substr(0, 4) + def + str.substr(4, 2) + def + str.substr(6, 2); break;
		}
	}
	return str;
};

/**
 * 글씨의 왼쪽에 원하는 길이만큼 숫자를 채움
 * s:대상문자열
 * d:패딩문자
 * n:전체자릿수
 */
wComm.lpad = function(str, def, no){
	str += "";
	def += "";
	no -= 0;
	if(str && def && no && str.length < no){
		while(str.length < no) {
			str = def + str;
		}
	}
	return str;
};

wComm.reverse = function(str) {
	str += "";
	return str.split("").reverse().join("");
};

/**
 * window, etc size
 */
wComm.getSize = function(type, id) {
	var size = {
		"width" : 0
		, "height" : 0
	};
	if (type == "window") {
		size.width = $(window).width();
		if (!size.width) {
			size.width = $(window).attr("screen").width;
			if (document.getElementsByTagName("body")[0].clientWidth) {
				size.width = document.getElementsByTagName("body")[0].clientWidth;
			}
		}
		size.height = $(window).height();
		if (!size.height) {
			size.height = $(window).attr("screen").height;
			if (document.getElementsByTagName("body")[0].clientHeight) {
				size.height = document.getElementsByTagName("body")[0].clientHeight;
			}
		}
	} else if (type == "ele") {
		size.width = jQuery("div#" + id).width();
		if (!size.width && document.getElementsById(id).offsetWidth) {
			size.width = document.getElementsById(id).offsetWidth;
		}
		size.height = jQuery("div#" + id).height();
		if (!size.height && document.getElementsById(id).offsetHeight) {
			size.height = document.getElementsById(id).offsetHeight;
		}
	}
	return size;
};
/**
 * 화면 이동
 */
wComm.move = function(url) {
	document.location.href = gVal.url + url;
};
/**
 * Enter
 */
wComm.enter = function(event, fn) {
	if (event.keyCode == 13) {
		fn();
	}
};
/**
 * log
 */
wComm.log = function(msg, err) {
	if (console) {
		if (msg) {
			console.log(msg);
		}
		if (err) {
			console.log(err);
		}
	}
	if (err) {
		msg = msg + "\n" + err;
	}
	wComm.alert(msg);
};