$( document ).ready(function() {
	$("#address").suggestions({
	    token: "5eba447183215d9884ae28a8b17a027af1ac3751",
	    type: "ADDRESS",
	    onSelect: function(city) {
	       	data=city.data;
	        cityData={
	            city_fias_id:data.city_fias_id,
	            city_kladr_id:data.city_kladr_id,
	            city:data.city_with_type,
	            country:data.country,
	            region:data.region_with_type,
	            geo_lat:data.geo_lat,
	            geo_lon:data.geo_lon,
	            address:city.value
	        }
	    }
	});
})
