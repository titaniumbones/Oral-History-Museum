<?php
/*
	Snippet Name: GoogleMap
	Short Desc: Outputs one or multiple Google maps with on-the-fly geocoding of addresses, or for predefined map points.	

	Created By: Mark Croxton (mcroxton@hallmark-design.co.uk)
	- 1.1   Bug fixes
	- 1.2   Modifed to allow lat/lng passing, added large control option and bubbletpl option
	- 1.3   Rewrite - now outputs multiple maps with accurate geocoding
	- 1.3.1 Tweaked address search behaviour to allow multiple geocoder passes
	- 1.3.2 Fixed js bug - thanks Bruno

	Last modified: 19/09/2008
	Version: 1.3.2
	Google Map API Version: 2.0
	MODx version: 0.9.6.1+
*/
$key = isset($key)? "$key" : '';
$maps = isset($maps)? "$maps" : '';
$phmode = isset($phmode)? "$phmode" : '';

$jMaps = null;
$aMaps = array();

# cleanup
$maps =  str_replace(array("\r\n", "\r", "\n", "\t"), '',$maps);

if ($maps !='') {
	# parse the paramaters
	$givenParams = explode("||",$maps);
	$i=0;
	foreach ($givenParams as $parameterString) {
		$paramPair = explode("|",$parameterString);
		foreach ($paramPair as $value) {
			$param = explode(":",$value);
			$aMaps[$i][trim($param[0])] = trim($param[1]);
		}
		$i++;
	}

	# construct json string to pass to js
	$jMaps .= '{"maps":[';
	
	for ($i=0; $i<count($aMaps); $i++ ) {
		
		# bubble template
		$tpl= isset($aMaps[$i]['bubbletpl'])? $aMaps[$i]['bubbletpl']:'';
		if ($tpl != '') {
			$bubbletpl = $modx->getChunk($tpl);
		} else {  // default
			$bubbletpl = '
			<h4>[+maptitle+]</h4>
			<p>[+mapaddress+]</p>
			';
		}
		# remove new lines, tabs and escape quotes
		$bubbletpl =  str_replace(array("\r\n", "\r", "\n", "\t"), '',$bubbletpl);
		
		# format map title
		$maptitle= isset($aMaps[$i]['title'])? $aMaps[$i]['title'] : '';
		// format a nice address string
		$mapaddress = "";
		$mapaddress.= isset($aMaps[$i]['address1']) && $aMaps[$i]['address1'] !='' ? $aMaps[$i]['address1'].'<br />' : '';
		$mapaddress.= isset($aMaps[$i]['address2']) && $aMaps[$i]['address2'] !='' ? $aMaps[$i]['address2'].'<br />' : '';
		$mapaddress.= isset($aMaps[$i]['city'])     && $aMaps[$i]['city']     !='' ? $aMaps[$i]['city'].'<br />' : '';
		$mapaddress.= isset($aMaps[$i]['state'])    && $aMaps[$i]['state']    !='' ? $aMaps[$i]['state'] : '';
		$mapaddress.= isset($aMaps[$i]['zip'])      && $aMaps[$i]['zip']      !='' ? ' '.$aMaps[$i]['zip'] : '';
		$mapaddress.= "<br /><br />";

		# replace placeholder values
		$fields = array('[+maptitle+]','[+mapaddress+]');
		$values = array($maptitle,$mapaddress);
		$bubbletpl = str_replace($fields,$values,$bubbletpl);

		$jMaps.='{';
		$jMaps.= isset($aMaps[$i]['mapid'])? '"mapid":"'.$aMaps[$i]["mapid"].'",' : '';
		$jMaps.= isset($aMaps[$i]['title'])? '"title":"'.addslashes($aMaps[$i]["title"]).'",' : '';
		$jMaps.= isset($aMaps[$i]['lng'])? '"lng":"'.$aMaps[$i]["lng"].'",' : '';
		$jMaps.= isset($aMaps[$i]['lat'])? '"lat":"'.$aMaps[$i]["lat"].'",' : '';
		$jMaps.= isset($aMaps[$i]['address1'])? '"address1":"'.addslashes($aMaps[$i]["address1"]).'",' : '';
		$jMaps.= isset($aMaps[$i]['address2'])? '"address2":"'.addslashes($aMaps[$i]["address2"]).'",' : '';
		$jMaps.= isset($aMaps[$i]['city'])? '"city":"'.addslashes($aMaps[$i]["city"]).'",' : '';
		$jMaps.= isset($aMaps[$i]['zip'])? '"zip":"'.addslashes($aMaps[$i]["zip"]).'",' : '';
		$jMaps.= isset($aMaps[$i]['zoom'])? '"zoom":"'.$aMaps[$i]["zoom"].'",' : '"zoom":"15",';
		$jMaps.= isset($aMaps[$i]['type'])? '"type":"'.$aMaps[$i]["type"].'",' : '"type":"normal",';
		$jMaps.= isset($aMaps[$i]['control'])? '"control":"'.$aMaps[$i]["control"].'",' : '"control":"small",';
		$jMaps.= isset($aMaps[$i]['typecontrol'])? '"typecontrol":"'.$aMaps[$i]["typecontrol"].'",' : '"typecontrol":"0",';
		$jMaps.= isset($aMaps[$i]['showbubble'])? '"showbubble":"'.$aMaps[$i]["showbubble"].'",' : '"showbubble":"1",';
		$jMaps.= '"bubbletpl":"'.addslashes($bubbletpl).'"';
		$jMaps.='}';
		
		if ($i<count($aMaps)-1) {
			$jMaps.=',';
		}	
	}
	$jMaps .= ']}';
}

$gmapjs = '
<script src="http://maps.google.com/maps?file=api&amp;v=2&amp;key='.$key.'" type="text/javascript" charset="utf-8"></script>
<script type="text/javascript">
//<![CDATA[
	var geocoder = null; // global scope
	var maps = null; // map object

	function initGmap(obj) {
		maps = obj.maps;
    	geocoder = new GClientGeocoder();
    	for (i=0;i<maps.length;i++) {
    		GloadMap(i);
    	}
	}

	function GloadMap(i) {
		maps[i].mapCanvas = new GMap2(document.getElementById(maps[i].mapid)); // local scope
		maps[i].found = 0; // default
		if(window.maps[i].lng !== undefined && window.maps[i].lat !== undefined) {
			point = new GLatLng(window.maps[i].lat, window.maps[i].lng);
			doPoint(point,i)
		} else {
			//geocode address
			showAddress(i);
		}
	} 

	function doPoint(point,i) {
		if (!point) { //not found
			maps[i].found++;
			if (maps[i].found>0 && maps[i].zip !== undefined && maps[i].city !== undefined) { 
				if (maps[i].found==1) { // first fail
					if (maps[i].address2 !== undefined) { // try second address line
						maps[i].address = maps[i].address2+", "+maps[i].city+", "+maps[i].zip;
					} else {
						maps[i].address = maps[i].zip; // try zip only
						maps[i].found++; // ensure next fail is final
					}
					showAddress(i);		
				} else if(maps[i].found==2) { // second fail, try zip only
					maps[i].address = maps[i].zip;
					showAddress(i);
				} else { // fail
					alert(maps[i].address + " not found");
				}
			} else { // fail
				alert(maps[i].address + " not found");
			}	
		} else {
			// centre and zoom
			maps[i].mapCanvas.setCenter(point, parseInt(maps[i].zoom));
			// add zoom control
			if (maps[i].control == "large") {
				maps[i].mapCanvas.addControl(new GLargeMapControl());
			} else {
				maps[i].mapCanvas.addControl(new GSmallMapControl());
			}
			// add type control
			if (maps[i].typecontrol == "1") {
				maps[i].mapCanvas.addControl(new GMapTypeControl());
			}
			// set map type
			var type = G_NORMAL_MAP;
			if (maps[i].type=="satellite") type = G_SATELLITE_MAP;
			if (maps[i].type=="hybrid") type = G_HYBRID_MAP;
			maps[i].mapCanvas.setMapType(type);
			// create marker and bubble
			var marker = new GMarker(point);
			maps[i].mapCanvas.addOverlay(marker);
			var myMarkerContent = maps[i].bubbletpl;
			// show bubble on load?
			if (maps[i].showbubble == 1) {
				marker.openInfoWindowHtml(myMarkerContent);
			}
			// add onclick event handler for bubble
			GEvent.addListener(marker, "click", function() {
				marker.openInfoWindowHtml(myMarkerContent);
			});
		}
	}

	function showAddress(i) {
		if (geocoder) {	
			//format address
			if (maps[i].address === undefined) {
				if (maps[i].address1 !== undefined && maps[i].city !== undefined && maps[i].zip !== undefined) {
					maps[i].address = maps[i].address1 + ", " + maps[i].city + ", " + maps[i].zip;
				} else if(maps[i].address1 !== undefined && maps[i].zip) {
					maps[i].address = maps[i].address1 + ", " + maps[i].zip;
				} else {
					maps[i].address=null;
				}
			}
			if (maps[i].address !=null) {
				geocoder.getLatLng(
					maps[i].address, function(point) { 
						doPoint(point, i); 
					}
        		);
        	} else {
        		alert("Error: one or more of the following parameters are missing: address1, city or zip");
        	}
		}
	}

	// init
	window.onload = function() {
		if (GBrowserIsCompatible()) {
			initGmap('.$jMaps.');
		}
	}
	// clean up
	window.onunload = function() {
		if (GBrowserIsCompatible()) {
			GUnload();
		}
	}
//]]>
</script>
';
# put the js in the <head>
$modx->regClientStartupScript($gmapjs, true);

# output map canvases
for ($i=0; $i<count($aMaps); $i++ ) {
	$gmap = '<div id="'.$aMaps[$i]['mapid'].'" style="width: '.$aMaps[$i]['width'].'px; height: '.$aMaps[$i]['height'].'px"></div>';
	if ($phmode) {
		$modx->setPlaceholder($aMaps[$i]['mapid'], $gmap);
	} else {
		echo $gmap;
	}
}
return;
?>