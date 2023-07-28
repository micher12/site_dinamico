$(function(){

	function initMap() {
		const myLatLng = { lat: -16.74200379827739, lng:  -49.27701353718103 };
		const map = new google.maps.Map(document.getElementById("map"), {
		  zoom: 18,
		  center: myLatLng,
		  disableDefaultUI: true,
		  zoomControl: true,
		  streetViewControl: true,
		  mapId: 'b76f3850ba04b3e2',
		});

		const image = 'img/icon.svg';

		const contentString =
		'<div class="container">' +
			'<div id="siteNotice">' +
			"</div>" +
			'<h1 id="firstHeading" class="firstHeading">Buriti Shopping</h1>' +
			'<div id="bodyContent">' +
				"<p><b>Buriti Shopping</b>, Inaugurado em 1996 com diversas expansões, o shopping é consolidado e uma referência em centro de compras da região. Atualmente com grande parte de suas lojas em operação, as melhores marcas do varejo e um mix de opções bastante variadas. Um shopping que se tornou um espaço ideal para além de compras, um lugar de encontros, conexões e experiências. O Buriti conta com o total de 204 lojas sendo 10 âncoras, entre elas C&A, Renner e Riachuelo e 06 salas de cinema. Com 2.034 vagas de estacionamento para carros e motos." +
				"</p>" +
			"</div>" +
		"</div>";

		const infowindow = new google.maps.InfoWindow({
			content: contentString,
			ariaLabel: "Uluru",
		});
		
		

		var marker = new google.maps.Marker({
			position: myLatLng,
			map,
			title: "Hello World!",
			icon: image,
		});

		marker.addListener("click", () => {
			infowindow.open({
			  anchor: marker,
			  map,
			});
		});

		marker.setMap(map);
	}
	
	

	initMap();


	//-16.74200379827739, -49.27701353718103
})