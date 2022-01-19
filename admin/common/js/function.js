/*
 * 관리자 공통 자바스크립트 함수파일
 */

// 글로벌 form id 및 action url 변수 정의
var FORM_ID, ACTION_URL;

// 등록 메소드 
function fnSubmit(frmId){
	if(!validate($("#"+frmId).get(0))){
		return;
	}

	$("#"+frmId).submit();
}

// 상세페이지 이동용 메소드
function fnAction(seq, seqName, action){
	if(FORM_ID){
		var form = $("#"+FORM_ID).get(0);
	
		if(!isNaN(seq)) $("#"+seqName).val(seq);
		if(action) form.action = action;
		
		form.submit();
	}
}

// 리스트 페이지 이동용 메소드
function goPage(page){
	if(FORM_ID){
		var form = $("#"+FORM_ID).get(0);
		
		$("#page").val(page);
		form.action = location.pathname;
		
		form.submit();
	}
}

//타겟 체크박스 전체 체크 또는 해제
function fnCheckAll(obj, elName){
	$("input[name='"+elName+"']").each(function(){
		if(obj.checked) this.checked = true;
		else this.checked = false;
	});
}

//yyyyMMdd 형태의 날짜 문자열을 원하는 분리 기호로 적용하여 표현
function fnChangeDateFormate(val, separator){
	var returnVal = "";
	
	if(val.trim().length < 8) return returnVal;
	if(!separator || separator.length < 1) return returnVal;
	
	return val.substring(0,4) + separator + val.substring(4,6) + separator + val.substring(6,8);
}

/*
 * 페이징블럭 제작 함수
 * @param(totalRecord) - Number : 전체 게시물 수
 * @param(pageSize) - Number : 페이지당 게시물 수
 * @param(blockSize) - Number : 페이징 블록 단위
 * @param(currentPage) - Number : 현재 페이지
 * @param(isMoveBlock) - Boolean : 블록단위 이동 버튼 여부
 * @param(isStartToEnd) - Boolean : 첫페이지 및 끝페이지 이동 버튼 여부
 */
function fnMakePaging(totalRecord, pageSize, blockSize, currentPage, isMoveBlock, isStartToEnd){
	if(isNaN(totalRecord) || isNaN(pageSize) || isNaN(blockSize) || isNaN(currentPage)){
		alert('페이징 처리 시 기본 정보가 잘못 되었습니다.');
		return;
	}
	
	if(totalRecord == 0) return; 
	
	if(typeof(isMoveBlock) == 'undefined') isMoveBlock = true;
	if(typeof(isStartToEnd) == 'undefined') isStartToEnd = false;
	
	var totalPage = Math.ceil(totalRecord / pageSize);
	var startPage = Math.floor(currentPage / blockSize) * blockSize + 1;
	
	// 현재 페이지가 블럭 마지막 페이지일 경우 startPage를 현재 블럭의 startPage로 변경
	var isBlockEndPage = ((currentPage % blockSize) == 0);
	if(isBlockEndPage) startPage -= 10;
	
	var endPage = startPage + blockSize - 1;
	endPage = (totalPage < endPage) ? totalPage : endPage;
	var html = '<span class="counter">Total '+totalRecord+' page <strong>'+currentPage+'</strong>/'+totalPage+'</span>';
	
	if(isStartToEnd){
		html += '<a href="javascript:goPage(1);" class="prev02">처음</a>';
	}
	
	if(isMoveBlock){
		if(currentPage > blockSize){
			html += '<a href="javascript:goPage('+(startPage - blockSize)+');" class="prev">이전</a>';
		} else {
			html += '<a href="javascript:goPage(1);" class="prev">이전</a>';
		}
	}
	
	for(var i=startPage; i<=endPage; i++){
		if(i == currentPage){
			// 현재 페이지
			html += '<a href="javascript:;" class="on">'+i+'</a>';
		}else{
			html += '<a href="javascript:goPage('+i+');">'+i+'</a>';
		}
	}
	
	if(isMoveBlock){
		if(totalPage > endPage){
			html += '<a href="javascript:goPage('+(startPage + blockSize)+');" class="next">다음</a>';
		} else {
			html += '<a href="javascript:;" class="next">다음</a>';
		}
	}
	
	if(isStartToEnd){
		html += '<a href="javascript:goPage('+totalPage+');" class="next02">마지막</a>';
	}
	
	document.write(html);
}

/**
 * Ajax Callback함수의 트랜잭션 결과를 나타내는 함수
 * @param {} response
 * @param {} isMessage(true:성공시 메시지 표현, false:성공시 메시지 표현 안함)
 * @param fnCallBack (성공 후 OK버튼 클릭하면 CallBack함수호출)
 * @return {}
 */
function FnResult(response) {
	/*console.log(response);
	console.log("//////////////////////////////////");*/
	response = response.resultMap;
	if(response==null)
		return true;
	var isMessage = (response.message==null)?"":response.message;
	if(isMessage!="")
		alert(isMessage);
	if(response.success==null || response.success){
		return true;
	}else{
		if(!response.success && (isMessage==""))
			alert("서버 Data 처리 중 에러가 발생하였습니다.");
		return response.success;
	}
}

/**
 * Ajax ResponseError 결과를 나타내는 함수
 */
function FnResponseErr(err) {
	if(err.status == 499){
		alert("로그인을 해주세요.")
		location.href = "/admin/login.do";
	}else{
		alert("서버 Data 처리 중 에러가 발생하였습니다.");
	}
}

//==============================================================
//* 페이지 처리
//@param trPage - page처리 할 tr ID
//@param currPage - 현재 page
//@param totPage - 총 페이지 수
//==============================================================
function fcSetPage(pageNavi, pageVo){
	var pageArea =document.getElementById(pageNavi);
	$(pageArea).empty();

	if(pageVo==null)
		return;
	var currPage = pageVo.currentPage;
	var totPage = pageVo.totalPage;
	
	if(totPage>0){
		var strHtml;
		var startPage, endPage, size=10;
		startPage = currPage - (currPage % size) + 1;
		if(currPage%size == 0)
			startPage -= size;
		endPage = startPage + size - 1;
		if(endPage > totPage)
			endPage = totPage;

		strHtml = '';
		if(startPage>1){
			strHtml += "<a href=\"javascript:goPage(1);\" class=\"btn_page_first\"><img src=\"/admin/images/util/btn_page_first.png\" alt=\"처음\"></a>";
			strHtml += "<a href=\"javascript:goPage("+(startPage-1)+");\" class=\"btn_page_prev\"><img src=\"/admin/images/util/btn_page_prev.png\" alt=\"이전\"></a>";
		}
		strHtml += "<ol>";
		for(var i=startPage;i<=endPage;i++){
			if(i==currPage)
				strHtml += "	<li><span href=\"javascript:void(0);\" class=\"current\">"+i+"</span></li>";
			
			else
				strHtml += "	<li><a href=\"javascript:goPage("+i+");\">"+i+"</a></li>";
		}
		strHtml += "</ol>";
		if(endPage<totPage){
			strHtml += "<a href=\"javascript:goPage("+(endPage+1)+");\" class=\"btn_page_next\"><img src=\"/admin/images/util/btn_page_next.png\" alt=\"다음\"></a>";
			
			strHtml += "<a href=\"javascript:goPage("+totPage+");\" class=\"btn_page_end\"><img src=\"/admin/images/util/btn_page_end.png\" alt=\"끝\"></a>";
		}
		$(pageArea).append(strHtml);
	}
}