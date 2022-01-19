/**********************************
@ common
**********************************/
var common = {
	
	stageData					:	{_y : 0 , _w : 0 , _h : 0},			// page information data
	agent							:	null,										// check media(true:PC & false:MOBILE)
	btnTopFlag					:	false,										// button top flag
	LNB							:	null,
	HEADER						:	null,	
	
	//common init
    init: function () {		

		common.agent = common.checkMedia();			
		common.HEADER = $('#header');
		common.LNB = $('#lnb');

		/* 왼쪽 메뉴 셋팅 */
		common.LNB.find('> ul > li').each(function(){
			if($(this).find('.snb').length > 0) {
				$(this).find('> a').attr('href' , 'javascript:;');
				$(this).addClass('two_depth');
			}else{
				$(this).addClass('none');
			}
		});
		
		/* 왼쪽 메뉴 클릭 이벤트 등록 */
		common.LNB.find('> ul > li > a').click(function(){
			var _parent = $(this).parent();
			if(_parent.hasClass('open')){
				_parent.removeClass('open');
				if(_parent.hasClass('actived')){
					_parent.removeClass('close');
				}
			}else{
				_parent.addClass('open');
				if(_parent.hasClass('actived')){
					_parent.addClass('close');
				}
			}
		});


		this.setStageData();
		this.scroll();
		this.resize();
	},

	//common scroll
	scroll : function(){

		this.setStageData();		

	},
	
	//common resize
	resize : function(){

		this.setStageData();
		this.scroll();

	},

	//tab content sort
	tabSort : function(_t){
		var _target = $(_t);
		var _parent = _target.parents('.tab_content');
		_target.parent().addClass('actived').siblings().removeClass('actived');
		_parent.find('.tab_data > div').eq(_target.parent().index()).show().siblings().hide();

		return false;
	},
	
	//page scroll top move
	scrollTop : function(){
		$('html,body').stop().animate({ scrollTop: 0 }, 600);
	},

	//stage data set
	setStageData : function(){
		common.stageData._y = $(window).scrollTop();
		common.stageData._w = $(window).width();
		common.stageData._h = $(window).height();
	},

	//open Content Pop
	contentPopOpen : function(_class){
		var _target = $('.'+_class);
		_target.stop(true).fadeIn(350);
		
		if(_target.find('> div').innerHeight() > common.stageData._h){
			$('body').css({ 'padding-right' : common.getScrollBarWidth() + 'px' })
		}else{
			$('body').attr( 'style' , '' );
		}
		common.htmlAddFix();
	},

	//close Content Pop
	contentPopClose : function(_target){
		$(_target).parents('.pop_wrap').stop(true).fadeOut(350,function(){
			
			var _check = false;
			$('.pop_wrap').each(function(){
				
				if($(this).css('display') == 'block'){
					_check = true;
				}
			});

			if(!_check){	
				$('body').attr( 'style' , '' );
				common.htmlDelFix();
			}

		});
	},

	// html Fix Add
	htmlAddFix : function(){
		$('html').addClass('fix');
	},

	// html Fix Remove
	htmlDelFix : function(){
		$('html').removeClass('fix');
	},

	// accordion click content data sort
	accordionOpen : function(_obj){
		var target	=	$(_obj);
		var parent	=	target.parents('.accordion_list');

		parent.find('> li').each(function(){

			if($(this).index() == target.parent().index()){

				if($(this).hasClass('actived')){
					$(this).removeClass('actived');
					$(this).find('.data').hide();
				}else{
					$(this).addClass('actived');
					$(this).find('.data').stop(true).show();
				}						
			}else{
				//$(this).removeClass('actived');
				//$(this).find('.data').stop(true).hide();
			}

		});

	},

	// accordion content data sort
	accordionSort : function(_index){
		$('.accordion_list').find('> li').eq(_index).addClass('actived').find('.data').show();
	},

	//html parameter check (httpUrl?num=1&page=1)
	getParameter:function(key){
		var url = location.href;
		var spoint = url.indexOf("?");
		var query = url.substring(spoint, url.length);
		var keys = new Array;
		var values = new Array;
		var nextStartPoint = 0;
		while (query.indexOf("&", (nextStartPoint + 1)) > -1) {
			var item = query.substring(nextStartPoint, query.indexOf("&", (nextStartPoint + 1)));
			var p = item.indexOf("=");
			keys[keys.length] = item.substring(1, p);
			values[values.length] = item.substring(p + 1, item.length);
			nextStartPoint = query.indexOf("&", (nextStartPoint + 1));
		}
		item = query.substring(nextStartPoint, query.length);
		p = item.indexOf("=");
		keys[keys.length] = item.substring(1, p);
		values[values.length] = item.substring(p + 1, item.length);
		var value = "";
		for (var i = 0; i < keys.length; i++) {
			if (keys[i] == key) {
				value = values[i];
			}
		}
		return value;
	},

	//browser pc mobile check
	checkMedia:function(){
		var UserAgent = navigator.userAgent;
		var UserFlag = true;
		if (UserAgent.match(/iPhone|iPad|iPod|Android|Windows CE|BlackBerry|Symbian|Windows Phone|webOS|Opera Mini|Opera Mobi|POLARIS|IEMobile|lgtelecom|nokia|SonyEricsson/i) != null || UserAgent.match(/LG|SAMSUNG|Samsung/) != null) UserFlag = false
		return UserFlag
	},

	//get html scroll width
	getScrollBarWidth : function () {
		var inner = document.createElement('p');
		inner.style.width = "100%";
		inner.style.height = "200px";

		var outer = document.createElement('div');
		outer.style.position = "absolute";
		outer.style.top = "0px";
		outer.style.left = "0px";
		outer.style.visibility = "hidden";
		outer.style.width = "200px";
		outer.style.height = "150px";
		outer.style.overflow = "hidden";
		outer.appendChild (inner);

		document.body.appendChild (outer);
		var w1 = inner.offsetWidth;
		outer.style.overflow = 'scroll';
		var w2 = inner.offsetWidth;
		if (w1 == w2) w2 = outer.clientWidth;

		document.body.removeChild (outer);

		return (w1 - w2);
	},
	windowPopOpen : function(_url , _name , _width , _height){
		window.open(_url, _name , 'width='+_width+'px, height='+_height+'px, top=0, left=0, resizable=yes, scrollbars=yes, location=no,  toolbar=no, status=no, menubar=no');
	}
};


//fileChange Event
function fileChange(_target){
	var _t = $(_target);
	var _val = _t.val();
	_t.siblings("input[type='text']").val(_val);
}

/* 첨부파일 추가 */
function addInputFile(t){
	var _parent = $(t).parents('.file_parent'),
		 _txt = "",
		 _total = 10;

	if(_parent.find('.add_input').length <= _total){
		//10개보다 작으면 생성
        _txt += '<li class="add_input">';
		_txt += '<div class="file_cell">';
		_txt += '<input type="file" name="mulityFile'+($("input:file").length)+'" title="파일 업로드" onchange="fileChange(this);">';
		_txt += '<input type="text" name="mulityFileTxt'+($("input:file").length)+'" readonly="" value="" title="업로드된 파일 경로">';
		_txt += '<button class="btn_small type_03 btn_file">파일찾기</button>';
		_txt += '<button class="btn_fild_del" onclick="addDeleteFile(this);"></button>';
		_txt += '</div>';
		_txt += '</li>';
		_parent.append(_txt);
	}else{
		alert('첨부파일은 10개까지만 가능합니다.');
	}
}

/* 첨부파일 삭제 */
function addDeleteFile(t){
	$(t).parents('.add_input').remove();
}


/******************************************************
@ Init
******************************************************/
$(function () {

	common.init();

});



/******************************************************
@ Document Ready
******************************************************/
$(document).ready(function () {	

});



/******************************************************
@ Window Load
******************************************************/
$(window).on("load",function () {

});



/******************************************************
@ Window Scroll
******************************************************/
$(window).on("scroll",function () {
	
	common.scroll();
	
});



/******************************************************
@ Window Resize
******************************************************/
$(window).on("resize",function () {

	common.resize();

});
/******************************************************
@ 스마트 에디터 사용 방식 변경
******************************************************/
$.fn.smartEditor = function() {
	var editors = [];
	var id = $(this).prop("id");
	nhn.husky.EZCreator.createInIFrame({
		oAppRef: editors,
		elPlaceHolder: id,
//		sSkinURI: "/smarteditor/SmartEditor2Skin.html",
		sSkinURI: "smarteditor/SmartEditor2Skin.html",
		htParams : {
			bUseToolbar : true,				// 툴바 사용 여부 (true:사용/ false:사용하지 않음)
			bUseVerticalResizer : true,		// 입력창 크기 조절바 사용 여부 (true:사용/ false:사용하지 않음)
			bUseModeChanger : true,			// 모드 탭(Editor | HTML | TEXT) 사용 여부 (true:사용/ false:사용하지 않음)
			//aAdditionalFontList : aAdditionalFontSet,		// 추가 글꼴 목록
			fOnBeforeUnload : function(){
				//alert("완료!");
			}
		}, //boolean
		fCreator: "createSEditor2"
		, fOnAppLoad:function(){
			// onEditorLoad() 가 정의되어있다면 실행
			if(typeof(onEditorLoad) != "undefined") {
				onEditorLoad();
			}
		}
	});
	
	// editor 값 반환, 지정
	this.val = function (value) {
		if (value) {
			alert([value]);
			editors.getById[id].exec("SET_IR", [""]);
			editors.getById[id].exec("PASTE_HTML", [value]);
		} else {
			return editors.getById[id].getIR();
		}
	};
	
	// 수정 되었는지 여부
	this.update = function() {
		return editors.getById[id].exec("UPDATE_CONTENTS_FIELD", [])
	};
	
	return this;
};
