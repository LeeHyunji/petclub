jQuery(function($) {
	wObj.$popup = $("div#popup");

	if (wObj.$popup.length > -1) {
		wObj.$popDialog = wObj.$popup.children("div.modal-dialog");
		wObj.$popContent = wObj.$popDialog.children("div.modal-content");
		wObj.$popTitle = wObj.$popContent.children("div.modal-header").children("h4");
		wObj.$popBody = wObj.$popContent.children("div.modal-body");
		wObj.$popFooter = wObj.$popContent.children("div.modal-footer");
		wObj.$popButton = wObj.$popFooter.children("button.action");
		wObj.$load = wObj.$popDialog.find("div.loadingbox");
	}
});

/**
 * bootstrap popup
 */
var isPopup = false;
wComm.popShow = function() {
	if (!isPopup) {
		isPopup = true;
		wObj.$popup.modal("show");
	}
};
wComm.popHide = function() {
	if (isPopup) {
		isPopup = false;
		wObj.$popup.modal("hide");
	}
};
wComm.loading = function() {
	if (wObj.$load.hasClass("hidden")) {
		wObj.$load.removeClass("hidden");
		wObj.$popContent.addClass("hidden");
	}
	wComm.popShow();
};
wComm.setModalCompHide = function(sel) { //모달 버튼의 일부 컴포넌트를 숨김
	wObj.$popFooter.find(sel).hide();
};
wComm.setModalCompShow = function(sel) { //모달 버튼의 일부 컴포넌트를 숨김
	wObj.$popFooter.find(sel).show();
};
wComm.confirmNotBtn = function(title, content) {
	wObj.$popTitle.empty().html(title);
	if (!wObj.$popFooter.hasClass("hidden")) {
		wObj.$popFooter.addClass("hidden")
	}
	wComm.modal(content, "", null);
};
wComm.success = function(content, fn) {
	fn = fn?fn:wComm.popHide;
	wComm.confirm("성공", content, "success", fn);
};
wComm.alert = function(content, fn) {
	fn = fn?fn:wComm.popHide;
	wComm.confirm("알림", content, "info", fn);
};
wComm.error = function(content, fn) {
	fn = fn?fn:wComm.popHide;
	wComm.confirm("오류", content, "warning", fn);
};
wComm.confirmOne = function(title, content, fn) {
	fn = fn?fn:wComm.popHide;

	wComm.confirm(title, content, "info", fn);
}
wComm.confirm = function(title, content, classnm, fn) {
	wObj.$popTitle.empty().html(title);
	if (wObj.$popFooter.hasClass("hidden")) {
		wObj.$popFooter.removeClass("hidden")
	}
	wComm.modal(content, classnm, fn);
};
wComm.modal = function(content, classnm, fn) {
	var arrClass = null, i = null;

	arrClass = wObj.$popTitle.prop("class").split(" ");
	for (i in arrClass) {
		if (/^text-/gi.test(arrClass[i])) {
			wObj.$popTitle.removeClass(arrClass[i]);
		}
	}
	arrClass = wObj.$popButton.prop("class").split(" ");
	for (i in arrClass) {
		if (/^btn-/gi.test(arrClass[i])) {
			wObj.$popButton.removeClass(arrClass[i]);
		}
	}
	if (!wComm.isEmpty(classnm)) {
		wObj.$popTitle.addClass("text-" + classnm);
		wObj.$popButton.addClass("btn-" + classnm);
	}
	wObj.$popBody.empty().html(content);

	wObj.$popButton.one("click", fn);

	if (wObj.$popContent.hasClass("hidden")) {
		wObj.$load.addClass("hidden");
		wObj.$popContent.removeClass("hidden");
	}
	wComm.popShow();
};