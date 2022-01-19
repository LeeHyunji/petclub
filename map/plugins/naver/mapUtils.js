//지도 설정
wFn.setMap = function(id) {
	return new naver.maps.Map(id, {
        zoom: 13 //지도의 초기 줌 레벨
		, draggable: true
		, pinchZoom: true
		, scrollWheel: true
		, keyboardShortcuts: true
		, disableDoubleTapZoom: false
		, disableDoubleClickZoom: true
		, disableTwoFingerTapZoom: false
		, disableKineticPan: false
		, scaleControl: true
		, logoControl: false
		, mapDataControl: true
		, zoomControl: true
		, mapTypeControl: true
		, minZoom : 1
		, maxZoom: 19
		, zoomControlOptions: {
			position: naver.maps.Position.TOP_RIGHT
		}
	});
};

//좌표값 변환 반환
wFn.setPos = function(lati, lng) {
	return new naver.maps.LatLng(lati, lng);
};

wFn.setMapCenter = function($map, pos) {
	$map.setCenter(pos);
};
