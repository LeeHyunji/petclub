var wComm = {}, wObj = {}, wFn = {}, gVal = {};
jQuery(function($) {
    wObj.$body = $("body");

    wObj.$body.on("keyup" , "[data-currency]", function(event) {
        wComm.eventDone(event);
        wComm.fmtCurrencyObj(this);
    });

    wObj.$body.on("keyup", "[data-digit]", function(event){
		wComm.eventDone(event);
		this.value = wComm.fmtDigit(this.value);
	});
});

// 이벤트 종료
wComm.eventDone = function(event) {
    event.preventDefault();
    event.stopPropagation();
};
/**
 * 
 * 숫자형 자리수 체크
 */
wComm.fmtCurrencyObj = function(obj) {
	var $obj = jQuery(obj);
	$obj.val(wComm.fmtCurrency($obj.val()));
};
/**
 * 자리수 체크
 */
wComm.fmtCurrency = function(value) {
	var n = wComm.fmtNumber(value);
	var reg = /(^[+-]?\d+)(\d{3})/;
	n += "";
	while (reg.test(n)) {
		n = n.replace(reg, "$1" + "," + "$2");
	}
	return n;
};
/*
 * 숫자만 나오게 하기
 */
wComm.fmtDigit = function(val) {
	val += "";
	return val.replace(/\D/gi, "");
};
/**
 * 
 * 숫자형 파일. 
 */
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

/**
 * Null 체크
 */
 wComm.isEmpty = function(val) {
	if (val == undefined || val == null || jQuery.trim(val).length == 0 || val == "null") {
		return true;
	} else {
		return false;
	}
};

// null replace
wComm.nvl = function(str, def) {
	str = jQuery.trim(str);
	def = jQuery.trim(def);
	return wComm.isEmpty(str)?def:str;
};

/**
 * Session Check
 */
wComm.isSession = function(json) {
	if (typeof json == "string") {
		if (/#LOGOUT#/gi.test(json)) {
			alert("로그인을 다시 해주세요.!");
			wComm.move("/");
			return;
		}
	} else if (!json.login) {
		alert("로그인을 다시해주세요!");
		wComm.move("/");
		return;
	}
};
/**
 * Ajax Util
 * completeFn : function(data) {
 * 	var result = data.responseText;
 * }
 */
wComm.doS = function(param, url, beforeSendFn, completeFn) {
	if (!url) {
		url = param.url;
	}
	jQuery.ajax({
		type : "post"
		, url : url
		, data : param
		, cache: false
		, async: true
		, beforeSend : beforeSendFn
		, complete : completeFn
	});
};

wComm.getS = function(param, beforeSendFn, completeFn) {
	wComm.doS(param, param.url, beforeSendFn, completeFn);
};

/**
 * json type get ajax
 */
wComm.getSJson = function(param, beforeSendFn, completeFn, endFn) {
	wComm.doSJson(param, param.url, beforeSendFn, completeFn, endFn);
};

wComm.doSJson = function(param, url, beforeSendFn, completeFn, endFn) {
	var process = new Date();
	wComm.doS(
		param
		, url
		, beforeSendFn
		, function(data) {
			var json = null, msg = null;
			json = data.responseText;
			if (endFn) {
				endFn();
			}

			try {
				json = wComm.parseJs(json);
				msg = unescape(json.msg);
				msg = msg.replace(/\\n/gi, "\n");

				if (!json.login) {
					alert(msg);
					wComm.move("/");
				} else if (json.status) {
					completeFn(msg);
				} else {
					wComm.log(msg);
				}
			} catch(ex) {
				wComm.log(json + "\n 오류: " + ((new Date() - process) / 1000), ex.message);
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
		throw msg;
	}
	return msg;
};

wComm.fmtForm = function($obj) {
	return $obj.serialize();
};

wComm.fmtDBError = function(msg) {
	try {
		var reg = /#.*#/gi;
		msg = msg.match(reg);
		msg += "";
		msg = msg.replace(/#/gi, "");
	} catch(ex) {
		msg += "\n" + ex.message;
	}
	return msg;
};

// 로그인
wFn.setLogin = function($this) {
    var $obj = $("form[name=login]");
    var param = {
        "url" : "loginProc.php"
        , "user_id" : $obj.find("input[name=in_userid]").val()
        , "user_pw" : $obj.find("input[name=in_passwd]").val()

    };
    
    if (wComm.isEmpty(param.user_id)) {
        alert("아이디를 입력해주세요.");
        return;
    } else if(wComm.isEmpty(param.user_pw)) {
        alert("패스워드를 입력해주세요.");
        return;
    }    

    wComm.getS(
        param
        , function() {}
        , function(data) {
            var json = data.responseText;
            try {
                json = wComm.parseJs(json);
                var msg = unescape(json.msg);
                msg = msg.replace(/\\n/gi , "<br/>");
                                
                if (json.status) {
                    top.location.href = "main.php";
                } else {
                    alert(msg);
                    return;
                }
            } catch(ex) {
                json = json.replace(/\\n/gi , "<br/>")
                alert(json);
            }
        }
    );
};

/**
 * log
 */
 wComm.log = function(msg, err) {
	if (window.console) {
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
	alert(msg);
};