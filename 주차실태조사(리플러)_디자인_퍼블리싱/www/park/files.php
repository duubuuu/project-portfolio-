<?

include_once("./_common.php");
include_once("./head.php");


?>


<!doctype html>
<html>
    <head>
        <title>js-shapefile-to-geojson Demo Page</title>
        <style>
            html, body {
                height: 100%;
                width: 100%;
            }
            #map {
                height: 400px;
                background-color: #eee;
            }
        </style>
    </head>
    <body>
         <a href="http://github.com/wavded/js-shapefile-to-geojson"><img style="position: absolute; top: 0; right: 0; border: 0;" src="http://s3.amazonaws.com/github/ribbons/forkme_right_darkblue_121621.png" alt="Fork me on GitHub" /></a>
        <h2>js-shapefile-to-geojson Demo Page</h2>
        <p>Pure client-side JavaScript (no server side code) parsing of shapefiles and dbase files to GeoJSON format displayed using OpenLayers.</p>
        <div id="map"></div>
        <p>View project at <a href="http://github.com/wavded/js-shapefile-to-geojson">http://github.com/wavded/js-shapefile-to-geojson</a>.
        <script src="https://rs1.adc4gis.com/js/openlayers/2.9.1/OpenLayers-Proj4.js"></script>

        <script type="text/javascript">
            OpenLayers._getScriptLocation = function(){
                return "https://rs1.adc4gis.com/js/openlayers/2.9.1/";
            };

            var map = new OpenLayers.Map("map",{allOverlays: true}),
                parser = new OpenLayers.Format.GeoJSON(),
                vector = new OpenLayers.Layer.Vector("Converted")

            map.addLayer(vector);

            var onchange = function(e) {
                var shpFile = document.getElementById('shp').files[0];
                var dbfFile = document.getElementById('dbf').files[0];
                if (shpFile) {
                    var opts = { shp: shpFile };
                    if (dbfFile) {
                        opts['dbf'] = dbfFile;
                    }
                    shapefile = new Shapefile(opts, function(data){
                        var features = parser.read(data.geojson);
                        vector.addFeatures(features);
                        map.zoomToExtent(vector.getDataExtent());
                        console.log(data);
                    });
                }
            }

            document.body.onload = function(){
                document.getElementById('shp').addEventListener('change', onchange, false);
                document.getElementById('dbf').addEventListener('change', onchange, false);
            }
        </script>
        <br>
        <br>
        .shp <input id="shp" type="file" name=".shp" />
        .dbf <input id="dbf" type="file" name=".dbf" />
    </body>
</html>
