<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <script type="text/javascript" src="{{ asset('assets/js/client/geo.js') }}" charset='utf-8'></script>
    <script language="javascript" type="text/javascript">

        var Range = 10;
        var Heading = 0.0;
        var rad = 160;
        var sx0 = 165;
        var sy0 = 162;
        var center = new LatLon(30.0, 110.0);
        var ctx;

        var flights = [];

        function Flight(num, lat, lon, alt, hdg)
        {
            this.num = num;
            this.pos = new LatLon(lat, lon);
            this.alt = alt;
            this.hdg = hdg;
        }

        function FlightData(num, lat, lon, alt, hdg)
        {
            for(i=0; i<flights.length; i++)
                if(flights[i].num == num)
                {
                    flights[i].pos = new LatLon(lat,lon);
                    flights[i].alt = alt;
                    flights[i].hdg = hdg;
                    return;
                }

            var obj = new Flight(num, lat, lon, alt, hdg)
            flights.push(obj);
        }

        function draw_circle()
        {
            ctx.lineWidth=1;
            ctx.setLineDash([1,5]);
            ctx.strokeStyle="#FFFFCC";

            ctx.beginPath();
            ctx.arc(sx0,sy0,rad,0,2*Math.PI);
            ctx.stroke();

            ctx.beginPath();
            ctx.arc(sx0,sy0,rad*0.75,0,2*Math.PI);
            ctx.stroke();

            ctx.beginPath();
            ctx.arc(sx0,sy0,rad*0.5,0,2*Math.PI);
            ctx.stroke();

            ctx.beginPath();
            ctx.arc(sx0,sy0,rad*0.25,0,2*Math.PI);
            ctx.stroke();
        }

        function draw_self()
        {
            ctx.fillStyle="#FF00AA";
            ctx.beginPath();
            ctx.moveTo(sx0,sy0-7);
            ctx.lineTo(sx0-5,sy0+7);
            ctx.lineTo(sx0+5,sy0+7);
            ctx.closePath();
            ctx.fill();
        }

        function draw_flight()
        {
            ctx.font = "11px Arial";
            ctx.setLineDash([1,0]);
            ctx.lineWidth = 2;
            ctx.strokeStyle="#00CCFF";

            for(i=0; i<flights.length; i++)
            {
                r = center.bearingTo(flights[i].pos) - Heading;
                if(r<0) r+=360.0;
                r = r.toRadians();
                d = center.distanceTo(flights[i].pos,8) / Range * rad;

                dx =   Math.sin(r) * d;
                dy = - Math.cos(r) * d;

                xx = sx0 + dx;
                yy = sy0 + dy;

                dr = flights[i].hdg - Heading;
                if(dr<0) dr+=360.0;
                dr = dr.toRadians();
                hx = xx + Math.sin(dr) * 25;
                hy = yy - Math.cos(dr) * 25;

                ctx.fillStyle="#00CCFF";

                ctx.beginPath();
                ctx.moveTo(xx, yy);
                ctx.lineTo(hx, hy);
                ctx.stroke();

                ctx.beginPath();
                ctx.arc(xx,yy,5,0,2*Math.PI);
                ctx.fill();

                ctx.fillStyle="#FFFF00";
                if(flights[i].alt>=10000) t = "FL" + parseInt(flights[i].alt/100).toString();
                else t = "A" + flights[i].alt.toString();

                ctx.fillText(flights[i].num+" "+t, xx+8, yy+5);
            }
        }

        function update_radar()
        {
            ctx.clearRect(0,0,ctx.canvas.width,ctx.canvas.height);
            draw_circle();
            draw_self();
            draw_flight();

            ctx.fillStyle="#00FFFF";
            ctx.font = "13px Arial";
            ctx.fillText(Range.toString() + " 海里 / 4", ctx.canvas.width - 78, ctx.canvas.height - 12);
        }

        function UpdateFlight()
        {
            var m = document.getElementById('master').value;
            var s = document.getElementById('client').value;

            flights=[];

            t = m.split(":");
            center.lat = parseFloat(t[0]);
            center.lon = parseFloat(t[1]);
            Heading = parseFloat(t[2]);

            if(s!="")
            {
                var arr = s.split("=");

                for(i=0; i<arr.length; i++)
                {
                    t = arr[i].split(":");
                    FlightData(t[0],t[1],t[2],t[3],t[4]);
                }
            }

            update_radar();
        }

        var scales = [ 1, 2, 4, 8, 12, 16, 20, 40, 80, 160, 320];
        var scaleid = 3;

        function ZoomIn()
        {
            if(scaleid>0)
            {
                scaleid--;
                Range = scales[scaleid];
                update_radar();
            }
        }

        function ZoomOut()
        {
            if(scaleid<scales.length-1)
            {
                scaleid++;
                Range = scales[scaleid];
                update_radar();
            }
        }

        function update_hdg(val)
        {
            var deg = (-val).toString();
            //document.getElementById("div_map").style.webkitTransform = 'rotate(' + deg + 'deg)';
        }

        function init()
        {
            var c=document.getElementById("radar_screen");
            ctx=c.getContext("2d");
            resizeCanvasToDisplaySize(ctx.canvas);
            rad = ctx.canvas.width / 2 - 10;
            sx0 = ctx.canvas.width / 2;
            sy0 = ctx.canvas.height / 2;
            //document.location="#update";

            //setInterval( function() { document.location="#update"; }, 1000);
        }

        function resizeCanvasToDisplaySize(canvas) {
            // look up the size the canvas is being displayed
            const width = canvas.clientWidth;
            const height = canvas.clientHeight;

            // If it's resolution does not match change it
            if (canvas.width !== width || canvas.height !== height) {
                canvas.width = width;
                canvas.height = height;
                return true;
            }

            return false;
        }
    </script>

    <style type="text/css">

        .small_bt {
            border: solid 1px #333;
            box-sizing:border-box;
            padding: 3px;
        }

        .small_bt:hover {
            border: solid 1px #666;
            background-color: #333;
            cursor: pointer;
        }

    </style>

</head>

<body oncontextmenu="return false;" style="margin: 0px; background-image: url('{{ asset('assets/images/client/cfr/radar.png') }}'); background-color:#000; background-repeat: no-repeat;
    background-size: 100vw 100vh; overflow:hidden; cursor:crosshair;" onload="init();">
<div id="div_map" style="position: absolute; left: 0px; top: 0px; width: 100vw; height: 100vh; z-index:1">
    <canvas id="radar_screen" style="display: block; width: 100vw; height: 100vh;" />
</div>
<div class="" style="left: 3px; top: 0px; z-index: 2; font-size: 20px; color: #FFF;" > </div>
<div class="small_bt" style="position: absolute; right: 3px; top: 0px; z-index: 2; font-size: 12px; color: #FFF;" onclick="ZoomOut();"> 缩小 </div>
<div class="small_bt" style="position: absolute; right: 40px; top: 0px; z-index: 2; font-size: 12px; color: #FFF;" onclick="ZoomIn();"> 放大 </div>

<div style="display: none"><textarea id="master"></textarea><textarea id="client"></textarea></div>

</body>
</html>