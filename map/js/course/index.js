wFn.init = function() {
	wObj.$frm = jQuery("form[name=frm]");
	wObj.$parentMap = jQuery("div#map").parent();
	wObj.$searchList = jQuery("div#search-list");
    wObj.$leftSideTage = jQuery("div.left_side_tag");
    
    

	//마커 배열
	gVal.arrMarker = [];

	wFn.setSearchResultHeight();

	wObj.$searchList.on("mouseenter", "div.media", function(event) {
		wComm.eventDone(event);
		var no = jQuery(this).data("no") - 1;
		var $marker = gVal.arrMarker[no].marker;
		if ($marker != null) {
			wFn.toggleMarker($marker, no, true, true);
		}
	});

	wObj.$searchList.on("mouseleave", "div.media", function(event) {
		wComm.eventDone(event);
		var no = jQuery(this).data("no") - 1;
		var $marker = gVal.arrMarker[no].marker;
		if ($marker != null) {
			wFn.toggleMarker($marker, no, false, true);
		}
	});
};

//맵 선언
wFn.initMap = function() {
	wObj.$map = wFn.setMap("map");
	wFn.setMapCenter(wObj.$map, wFn.setPos(37.5106197, 127.0303278));

	wObj.$map.setSize(wFn.getNMapSize(wFn.getMapSize()));

	gVal.map = {
		marker: {
			 on: []
			, over : []
		}
	};

	var defaultMarker = null;

	for (var i = 1; i < 31; i++) {
		defaultMarker = {
			icon: {
				url:  "images/map/on/pin.png"
				, size: new naver.maps.Size(50, 50)
				, origin: new naver.maps.Point(0, 0)
				, anchor: new naver.maps.Point(25, 25)
			}
		};
		gVal.map.marker.on.push(defaultMarker);
		defaultMarker = null;

		defaultMarker = {
			icon: {
				url: "images/map/over/pin.png"
				, size: new naver.maps.Size(50, 50)
				, origin: new naver.maps.Point(0, 0)
				, anchor: new naver.maps.Point(25, 25)
			}
		};
		gVal.map.marker.over.push(defaultMarker);
		defaultMarker = null;
	}

	//지도 정보창
	wObj.$infoWindow = new naver.maps.InfoWindow();
	wFn.setInfoVisible(false);

	jQuery(window).resize(function() {
		wFn.setSearchResultHeight();
		wObj.$map.setSize(wFn.getNMapSize(wFn.getMapSize()));
	});
};

//맵 이벤트 설정
wFn.initMapEvent = function() {

	wObj.$recognizer = new MarkerOverlappingRecognizer({
		highlightRect: false,
		tolerance: 5
	});
	wObj.$recognizer.setMap(wObj.$map);

	naver.maps.Event.addListener(wObj.$map, "click", function(e) {
		wFn.setInfoVisible(false);
	});

	var overlapCoverMarker = null;

	naver.maps.Event.addListener(wObj.$recognizer, "overlap", function(list) {
		if (overlapCoverMarker) {
			wFn.unhighlightMarker(overlapCoverMarker);
		}

		overlapCoverMarker = list[0].marker;

		naver.maps.Event.once(overlapCoverMarker, "mouseout", function() {
			wFn.highlightMarker(overlapCoverMarker);
		});
	});

	naver.maps.Event.addListener(wObj.$recognizer, "clickItem", function(event) {
		wObj.$recognizer.hide();

		if (overlapCoverMarker) {
			wFn.unhighlightMarker(overlapCoverMarker);
			overlapCoverMarker = null;
		}
	});
	
};


//네이버 클래스로 사이즈 반환
wFn.getNMapSize = function(size) {
	return new naver.maps.Size(size.width, size.height);
};

//맵 사이즈 반환
wFn.getMapSize = function() {
	var size = wComm.getSize("window");
	var height = size.height;
	if (size.width < 768) { //초소형 기기(모바일) {
		height = 400;
        wObj.$frm.find("input[name=keyword]").val("");
	} else {
        if (height < 1000) {
            height = 1000;
        }
        wObj.$frm.find("input[name=small_keyword]").val("");
	}
	return new naver.maps.Size(wObj.$parentMap.width(), height);
};

//검색 결과 창 사이즈
wFn.setSearchResultHeight = function() {
	var size = wComm.getSize("window");
	var height = size.height;
	if (size.width < 768) {
		height = 400;
	} else {
        if (height < 1000) {
            height = 1000;
        }
    }
	wObj.$leftSideTage.height(height);
};

/**
 * 오버레이 객체 지우기
 */
wFn.removeMarker = function() {
	var marker = null;
	while(gVal.arrMarker.length > 0) {
		marker = gVal.arrMarker.pop().marker;
		if (marker != null) {
			wObj.$recognizer.remove(marker);
			marker.setMap(null);
		}
	}
	gVal.map.marker.circle.setMap(null);
	wFn.setInfoVisible(false);
};

wFn.removeMarkerOne = function(marker) {
	var i = 0, cnt = gVal.arrMarker.length;
	var isOk = false;
	for (; i < cnt; i++) {
		if (marker == gVal.arrMarker[i].marker) {
			isOk = true;
			break;
		}
	}
	if (isOk) {
		marker = gVal.arrMarker[i].marker;
		if (marker != null) {
			wObj.$recognizer.remove(marker);
			marker.setMap(null);
			gVal.arrMarker.splice(i, 1);
		}
	}
	gVal.map.marker.circle.setMap(null);
};
//마커 세팅
wFn.setMarker = function(json, $marker, isEvent) {
	if ($marker != null) {
		var pos = wFn.setPos(json.lati, json.lng);
		$marker.setTitle(json.customName);
		$marker.setVisible(true);
		$marker.setPosition(pos);
		$marker.setMap(wObj.$map);

		wFn.setMapCenter(wObj.$map, pos);

		if (isEvent) {
			wFn.setMarkEvent($marker, json);
		}
		wObj.$recognizer.add($marker);
	}

	gVal.arrMarker.push({"marker": $marker, "data": json});
};

//마케 이벤트 설정
wFn.setMarkEvent = function($marker, json) {

	$marker.addListener("click", function(event) {
		var marker = event.overlay;
		wFn.setInfoVisible(false);
        var pos = wFn.setPos(json.lati, json.lng);
		wFn.setMapCenter(wObj.$map, pos);

		var title = marker.title;

		var tag = '\
		<div class="mapLayer">\
			<div class="header t_center" style="min-height:30px">\
				<h3 class="t_center" style="color:black">' + title + '</h3>\
			</div>\
			<div class="body">\
			' + json.tag + '\
			</div>\
		</div>\
		';

		wObj.$infoWindow.setContent(tag);
		wFn.setInfoVisible(true, marker);
	});

	/**
	 * 마커위 마우스 인
	 */
	$marker.addListener("mouseover", function (event) {
		wFn.highlightMarker(event.overlay);
	});

	/**
	 * 마커위 마우스 아웃
	 */
	$marker.addListener("mouseout", function(event) {
		wFn.unhighlightMarker(event.overlay);
	});
};

wFn.highlightMarker = function($marker) {
	$marker.setZIndex(1000);
	for (var i = 0, cnt = gVal.arrMarker.length; i < cnt ; i++) {
		if ($marker == gVal.arrMarker[i].marker) {
			wFn.toggleMarker($marker, i, true, false);
		}
	}
};

wFn.unhighlightMarker = function($marker) {
	$marker.setZIndex(100);
	for (var i = 0, cnt = gVal.arrMarker.length; i < cnt ; i++) {
		if ($marker == gVal.arrMarker[i].marker) {
			wFn.toggleMarker($marker, i, false, false);
		}
	}
};

wFn.setInfoVisible = function(bool, marker) {
	if (bool && !wObj.$infoWindow.getMap()) {
		wObj.$infoWindow.open(wObj.$map, marker);
	} else if (!bool) {
		wObj.$infoWindow.close();
	}
};

wFn.clearSearch = function() {
	wObj.$searchList.empty().removeData();
};

wFn.tagList = function(json) {
};

//방문, 미등록 마커
wFn.setVisitMarker = function(json) {
	var $marker = null;
	if (json.lati != 0) {
		$marker = new naver.maps.Marker(gVal.map.marker.on[(json.no - 1)]);
	}

	/**
	 * 검색된 내용 안에서도 마커 이벤트
	*/
	wObj.$searchList.on("click", "div.no_" + json.no, function(event) {
		var marker = event.overlay;
		wFn.setInfoVisible(false);
        var pos = wFn.setPos(json.lati, json.lng);	
		wFn.setMapCenter(wObj.$map, pos);

		var title = $marker.title;
		var tag = '\
		<div class="mapLayer">\
			<div class="header t_center" style="min-height:30px">\
				<h3 class="t_center" style="color:black;">' + title + '</h3>\
			</div>\
			<div class="body">\
			' + json.tag + '\
			</div>\
		</div>\
		';

		wObj.$infoWindow.setContent(tag);
		wFn.setInfoVisible(true, $marker);
	});

	wFn.setMarker(json, $marker, true);
};

//마커 이미지 변경
wFn.toggleMarker = function($marker, no, isOn, isMap) {
	var $img = wObj.$searchList.find("div.media").eq(no);
	if ($img.length == 0) {
		return;
	}
	$img = $img.children("div.media-left").children("img");
	if (isOn) {
		$img.prop("src", gVal.map.marker.over[no].icon.url);
	 	$marker.setIcon(gVal.map.marker.over[no].icon);
	 	if (isMap) {
			wFn.setMapCenter(wObj.$map, $marker.getPosition());
		}
	} else {
		$img.prop("src", gVal.map.marker.on[no].icon.url);
		$marker.setIcon(gVal.map.marker.on[no].icon);
	}
};

wFn.getScrollBarWidth =  function () {
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
}

//open Content Pop
wFn.contentPopOpen = function(_class, customname, time_start, address, phone, park, src, time_end) {
    var _target = $('.'+_class);
    _target.stop(true).fadeIn(350);
    /*
    alert(json.customname);
    _target.find(".address").html(json.address);
    _target.find(".title").html(json.customname);
    _target.find(".time").html(json.time);
    _target.find(".phone").html(json.phone);
    _target.find(".park").html(json.park);
	$("img.pop_img").prop("src", src);
	*/

    if (!wComm.isEmpty(time_end)) {
        var time = "<br/> 주중:" + time_start + "  주말:" + time_end;
        _target.find(".time").html(time);
    } else {
        _target.find(".time").html(time_start);
    }


    _target.find(".header_title").html(customname);
    _target.find(".address").html(address);
    _target.find(".phone").html(phone);
    _target.find(".park").html("<b>ㆍ주차가능여부 :</b>" + park);
    $("img.pop_img").prop("src", src);
	

    if(_target.find('> div').innerHeight() > $(window).height()){
        $('body').css({ 'padding-right' : wFn.getScrollBarWidth() + 'px' })
    }else{
        $('body').attr( 'style' , '' );
    }
    $('html').addClass('fix');
}

//close Content Pop
wFn.contentPopClose = function(_target){
    $(_target).parents('.pop_wrap').stop(true).fadeOut(350,function(){
        var _check = false;
        $('.pop_wrap').each(function(){
            
            if($(this).css('display') == 'block'){
                _check = true;
            }
        });
        if(!_check){	
            $('body').attr( 'style' , '' );
            $('html').addClass('fix');
        }
    });
}
