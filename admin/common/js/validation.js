/*
 * 입력폼 유효성 검사용
 * 반드시 common.js 파일과 같이 사용되어야 한다.
 */

// 에러메시지 포멧 정의 ///
var NO_BLANK_TEXT = "{name+을를} 입력해주세요.";
var NO_BLANK_SELECT = "{name+을를} 선택해주세요.";
var NO_BLANK_CHECK = "{name+을를} 확인해주세요.";
var NOT_VALID = "{name+이가} 올바르지 않습니다";
var NO_TAG = "{name}에는 '<' 나 '>'를 입력할 수 없습니다.";
var NO_SPECIAL = "{name}에는 한글이나 영문만 입력할 수 있습니다.";
var TOO_LONG = "{name}의 길이가 초과되었습니다 (최대 {maxbyte}바이트)";
var STRING_FR  = 6
var STRING_TO  = 10
var old_menu = '';
var old_cell = '';

String.prototype.hasFinalConsonant = function(str) {
	str = this != window ? this : str;
	var strTemp = str.substr(str.length-1);
	return ((strTemp.charCodeAt(0)-16)%28!=0);
}

/// 실질적 폼체크 함수 ///
function validate(form) {
	for (i = 0; i < form.elements.length; i++ ) {
		var el = form.elements[i];
		if (el.tagName == "FIELDSET" || el.tagName.toLowerCase() == "object") continue;
		if(el.tagName!="SELECT"){
			try{
				el.value = el.value.trim();
			}catch(e){}
		}
		/*
		if(el.tagName=="TEXTAREA" && el.style.display=="none"){
			if(el.value=="<p>&nbsp;</p>") el.value = "";
		}
		*/
		var require = el.getAttribute("REQUIRE");

		var fitbyte = el.getAttribute("FITBYTE");
		var minbyte = el.getAttribute("MINBYTE");
		var maxbyte = el.getAttribute("MAXBYTE");
		var option = el.getAttribute("OPTION");
		var match = el.getAttribute("MATCH");
		var glue = el.getAttribute('GLUE');

		if (require != null) {	//필수 사항에 대한 처리
			if (require == 'notempty' && el.value == '') {
				continue;
			}

			if(el.getAttribute("disabled")==true) continue;
			if (el.type == "radio" || el.type == "checkbox"){
				obj = eval("form." + el.name);
				bool = true;
				if(obj.length)
				{
					for(rad = 0; rad<obj.length; rad++){
						if(obj[rad].checked == true){
							bool = false;
						}
					}
				}
				else
				{
					if(obj.checked == true){
						bool = false;
					}
				}
				if(bool){
					if (el.type == "radio"){
						return doError(el,NO_BLANK_SELECT);
					}else{
						return doError(el,NO_BLANK_CHECK);
					}
				}
			}
			else{
				if(el.tagName=="SELECT") {
					var isSelected = false;	//el.options[el.selectedIndex].value;

					var objOptions = el.options;
					// if(el.selectedIndex > 0 && objOptions[el.selectedIndex].value) {
					if(objOptions[el.selectedIndex] !== undefined && objOptions[el.selectedIndex].value) {
						isSelected = true;
					}

					for(var n=0 ; n < objOptions.length ; n++) {
						if(objOptions[n].getAttribute("selected")!=null && objOptions[n].value) {
							isSelected = true;
							break;
						}
					}

					if (!isSelected) {
						return doError(el,NO_BLANK_SELECT,"sel");
					}
				}else{
					if (el.value == null || el.value == "") {
						return doError(el,NO_BLANK_TEXT);
					}
				}
			}
			if (fitbyte != null) { //문자열 길이 체크
				if (el.value.length != parseInt(fitbyte)) {
					return doError(el,"{name+은는} " + fitbyte + "자를 입력해야 합니다.");
				}
			}
			if (minbyte != null) {
				if (el.value.length < parseInt(minbyte)) {
					return doError(el,"{name+은는} 최소 "+minbyte+"자 이상 입력해야 합니다.");
				}
			}
			if (maxbyte != null && el.value != "") { //문자열 길이 체크
				var len = 0;
				if (el.value.length > parseInt(maxbyte)) {
					return doError(el,"{name}의 입력 가능한 최대 글자는 "+maxbyte+" Byte 입니다. 현재 " + el.value.bytes + " Byte 를 입력 하였습니다");
				}
			}
			if (match && (el.value != form.elements[match].value)) {
				return doError(el,"{name+이가} "+form.elements[match].getAttribute("hname")+"와 일치하지 않습니다");  //두개의 문자열 일치 체크
			}
			if (option != null && el.value != "") {   /// 특수 패턴 검사 함수 포워딩 ///
				if (el.getAttribute('SPAN') != null) {
					var _value = new Array();
					for (span=0; span<el.getAttribute('SPAN');span++ ) {
						_value[span] = form.elements[i+span].value;
					}
					var value = _value.join(glue == null ? '' : glue);
					if (!funcs[option](el,value)) return false;
				} else {
					if (!funcs[option](el)) return false;
				}
			}
		}
	}
	return true;
}
// Textarea 글자수 조절
// 입력예제 <textarea onKeyPress="fnChkRemark(this,'50')">  -- fnChkRemark(텍스트값, 자릿수)
function fnChkRemark(obj, strCnt) {
	var strtempRemark = obj.value;
	var len = 0;
	var tString = '';
	for(j=0; j< strtempRemark.length; j++) {
		var chr = strtempRemark.charAt(j);
		len += (chr.charCodeAt() > 128) ? 2 : 1;
		if (len <= strCnt)
			tString += chr;
	}
	if (len >= strCnt) {
		alert('확인','영문은 ' + strCnt + '자 이하, 한글은 '+ strCnt/2 + '자 이하로 입력해 주세요. ');
		obj.focus();
		obj.value = tString;
		return false;
	}
}
function josa(str,tail) {
	return (str.hasFinalConsonant()) ? tail.substring(0,1) : tail.substring(1,2);
}
function doError(el,type,action) { //에러 처리 함수
	var message = (msg = el.getAttribute("ERROR-MSG")) ? msg : "";
	if(message != ""){
		alert(message);
	}else{
		var pattern = /{([a-zA-Z0-9_]+)\+?([가-힝]{2})?}/;
		var name = (hname = el.getAttribute("HNAME")) ? hname : el.getAttribute("NAME");
		pattern.exec(type);
		var tail = (RegExp.$2) ? josa(eval(RegExp.$1),RegExp.$2) : "";
	
		alert(type.replace(pattern,eval(RegExp.$1) + tail));
	}
	
	if (action == "sel") {
		try{
			el.focus();
		}catch (e){}
	} else if (action == "del")	{
		el.value = "";
	}
	// 히든 필드, display:none, readonly 개체는 포커스시 에러나므로 에러처리 추가
	try{
		el.focus();
	}catch (e){}

	return false;
}
/// 특수 패턴 검사 함수 매핑 ///
var funcs = new Array();
funcs['email']		= isValidEmail;
funcs['phone']		= isValidPhone;
funcs['userid']		= isValidUserid;
funcs['pass']		= isValidPass;
funcs['hangul']		= hasHangul;
funcs['number']		= isNumeric;
funcs['engonly']	= alphaOnly;
funcs['alphaNum']	= isAlphaNumeric;
funcs['jumin']		= isValidJumin;
funcs['bizno']		= isValidBizNo;
funcs['domain']		= isValidDomain;
funcs['notag']		= isValidTag;
funcs['text']		= isValidText;
/// 패턴 검사 함수들 ///
function isValidEmail(el,value) {
	var value = value ? value : el.value;
	var pattern = /^[_a-zA-Z0-9-\.]+@[\.a-zA-Z0-9-]+\.[a-zA-Z]+$/;
	return (pattern.test(value)) ? true : doError(el,NOT_VALID);
}
function validChar(value){
	var alpbool = false;
	var numbool = false;

	for(z=-1 ; z<value.length-1; z++){
		if(isNaN(value.substr(z+1,1))){
			alpbool = true;
		} else {
			numbool = true;
		}
	}

	return (alpbool && numbool);
}
function isValidUserid(el) {
	var pattern = /^[a-zA-Z]{1}[a-zA-Z0-9_]{3,11}$/;
	return (pattern.test(el.value)) ? true : doError(el,"{name+은는} 첫 문자는 영문이어야 하며\n\n4자이상 12자 이하 영문 또는 영문/숫자 조합이어야 합니다");
}
function isValidPass(el) {
	var pattern = /^[a-zA-Z0-9~!@#$%^&*()_+{}|":?><]{5,10}$/;
	return (pattern.test(el.value) && validChar(el.value)) ? true :doError(el,"{name+은는} 6자이상 10자 이하이어야 하고,\n\n영문/숫자 조합이어야 합니다");
}
function hasHangul(el) {
	var pattern = /^[가-힝]+$/;
	return (pattern.test(el.value)) ? true : doError(el,"{name+은는} 반드시 한글로만 입력해야 합니다");
}
function alphaOnly(el) {
	var pattern = /^[a-zA-Z/ ]+$/;
	return (pattern.test(el.value)) ? true : doError(el,"{name+은는} 반드시 영문으로만 입력해야 합니다");
}
function isNumeric(el) {
	var pattern = /^[0-9]+$/;
	return (pattern.test(el.value)) ? true : doError(el,"{name+은는} 반드시 숫자로만 입력해야 합니다");
}
function isAlphaNumeric(el, value) {
	var value = value ? value : el.value;
	var pattern = /^[a-zA-Z0-9]+$/;
	return (pattern.test(el.value)) ? true : doError(el,"{name+은는} 반드시 영문/숫자로만 입력해야 합니다");
}
function isValidJumin(el,value) { //주민번호 체크
	var pattern = /^([0-9]{6})-?([0-9]{7})$/;
	var num = value ? value : el.value;
	if (!pattern.test(num)) return doError(el,NOT_VALID);
	num = RegExp.$1 + RegExp.$2;

	var sum = 0;
	var last = num.charCodeAt(12) - 0x30;
	var bases = "234567892345";
	for (var i=0; i<12; i++) {
		if (isNaN(num.substring(i,i+1))) return doError(el,NOT_VALID);
		sum += (num.charCodeAt(i) - 0x30) * (bases.charCodeAt(i) - 0x30);
	}
	var mod = sum % 11;
	return ((11 - mod) % 10 == last) ? true : doError(el,NOT_VALID);
}
function isValidBizNo(el, value) { //사업번호 체크
	var pattern = /([0-9]{3})-?([0-9]{2})-?([0-9]{5})/;
	var num = value ? value : el.value;
	if (!pattern.test(num)) return doError(el,NOT_VALID);
	num = RegExp.$1 + RegExp.$2 + RegExp.$3;
	var cVal = 0;
	for (var i=0; i<8; i++) {
		var cKeyNum = parseInt(((_tmp = i % 3) == 0) ? 1 : ( _tmp  == 1 ) ? 3 : 7);
		cVal += (parseFloat(num.substring(i,i+1)) * cKeyNum) % 10;
	}
	var li_temp = parseFloat(num.substring(i,i+1)) * 5 + '0';
	cVal += parseFloat(li_temp.substring(0,1)) + parseFloat(li_temp.substring(1,2));
	return (parseInt(num.substring(9,10)) == 10-(cVal % 10)%10) ? true : doError(el,NOT_VALID);
}
function isValidPhone(el,value) {//전화번호
	var pattern = /^(01[016789]{1}|02|0[3-9]{1}[0-9]{1})-?[0-9]{3,4}-?[0-9]{4}$/;
	var num = value ? value : el.value;
	if (num == null || num == "") {
		return doError(el,NO_BLANK);
	}
	else {
		return (pattern.test(num)) ? true : doError(el,NOT_VALID);
	}
}
function isValidDomain(el,value) { //도메인 체크
	var value = value ? value : el.value;
	var pattern = new RegExp("^(http://)?(www\.)?([가-힝a-zA-Z0-9-]+\.[a-zA-Z]{2,3}$)","i");
	if (pattern.test(value)) {
		el.value = RegExp.$3;
		return true;
	} else {
		return doError(el,NOT_VALID);
	}
}
function isValidTag(el,value) { //도메인 체크
	var value = value ? value : el.value;
	if (value.indexOf("<") < 0 && value.indexOf(">") < 0) {
		return true;
	} else {
		return doError(el,NO_TAG);
	}
}
function isValidText(el,value) { //텍스트 체크
	var value = value ? value : el.value;
	var pattern = /^[a-zA-Z가-힝\s]+$/;
	if (pattern.test(value)) {
		return true;
	} else {
		return doError(el,NO_SPECIAL);
	}
}
function isValidDate(el,value) { //날짜형식 체크
	var value = value ? value : el.value;
	var pattern = /([0-9]{4})-?([0-9]{2})-?([0-9]{2})/;
	return (pattern.test(value)) ? true : false;
}