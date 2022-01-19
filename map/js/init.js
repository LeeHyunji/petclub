var wObj = {}, wFn = {}, gVal = {};
jQuery(function($) {
	var $csrf = $("meta[name=\"_csrf\"]");
	var $csrf_header = $("meta[name=\"_csrf_header\"]");
	gVal.url = $csrf.data("url");
	gVal.$loadTag = "<p class=\"text-center\"><span class=\"glyphicon glyphicon-refresh glyphicon-refresh-animate\"></span></p>";

	$(document).ajaxStart(function(){
		$("button[type=button]").prop("disabled", true);
	}).ajaxStop(function() {
		$("button[type=button]").prop("disabled", false);
	}).ajaxSend(function(event, xhr, options) {
		xhr.setRequestHeader("AJAX", true);
		xhr.setRequestHeader($csrf_header.attr("content"), $csrf.attr("content"));
	}).ajaxError(wFn.error);

	$("body").on("keyup", "[data-enter]", function(event) {
		wComm.eventDone(event);
		wComm.enter(event, wFn[$(this).data("enter")]);
	});
	$("body").on("keyup", "[data-number]", function(event) {
		wComm.eventDone(event);
		wComm.fmtNumberObj(this);
	});
	$("body").on("keyup", "[data-currency]", function(event) {
		wComm.eventDone(event);
		wComm.fmtCurrencyObj(this);
	});
	$("body").on("blur", "[data-email]", function(event){
		wComm.eventDone(event);
		if (!wComm.isEmail(this.value)) {
			this.value = "";
		}
	});
	$("body").on("blur", "[data-tel]", function(event){
		wComm.eventDone(event);
		if (!wComm.isPhone(this.value)) {
			this.value = "";
		}
	});
});
wFn.error = function(event, jqxhr, settings, thrownError) {
	if (jqxhr.status == 401) {
		wComm.alert("인증에 실패 했습니다. 로그인 페이지로 이동합니다.");
		wComm.move("");
		return;
	}
};

wFn.set = function($this) {
	document.frm.submit();
};