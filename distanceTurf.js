/**
*   Snap marker to closest point on a line.
*
*   Based on Distance to line example by
*   Marcelo, maps.forum.nu - http://maps.forum.nu/gm_mouse_dist_to_line.html
*   Then
*   @ work of Björn Brala - Swis BV who wrapped the algorithm in a class operating on GMap Objects
*   And now
*   Bill Chadwick, who factored the basic algorithm out of the class (removing much intermediate storage of results)
*       and added distance along line to nearest point calculation
*   Followed by
*   Robert Crowe, who ported it to v3 of the Google Maps API and factored out the marker to make it more general.
*
*   Usage:
*
*   Create the class
*       var oSnap = new cSnapToRoute();
*
*   Initialize the subjects
*       oSnap.init(oMap, oPolyline);
*
**/


42.94253120859892,74.59209786109857,42.94253851902809,74.59355524949905,42.94259798548735,74.59452617938764,42.94196023317048,74.59556802734978,42.941691632536084,74.59665344327013,42.942267356271984,74.59702517007563,42.94207596753029,74.60160730225424,42.93991425115074,74.60196127397913,42.938079621622606,74.6025002002716,42.9368675843209,74.60235492902274,

42.94253120859892,74.59209786109857,42.94253851902809,74.59355524949905,42.94259798548735,74.59452617938764,42.94196023317048,74.59556802734978,42.941691632536084,74.59665344327013,42.942267356271984,74.59702517007563,42.94207596753029,74.60160730225424,42.93991425115074,74.60196127397913,42.938079621622606,74.6025002002716,42.9368675843209,74.60235492902274,



42.88660761613402,74.57155635034599,42.91687912417629,74.607619902598,42.904603868967705,74.60042306694834,42.84875498644637,74.56962833188174,42.821163519143056,74.54929628125558,42.81596539832553,74.5238041372055,42.82678935474531,74.53380896804322,

0 :42.88660761613402 74.57155635034599
userPage.php:627 1 :42.91687912417629 74.607619902598
userPage.php:627 2 :42.904603868967705 74.60042306694834
userPage.php:627 3 :42.84875498644637 74.56962833188174
userPage.php:627 4 :42.821163519143056 74.54929628125558
userPage.php:627 5 :42.81596539832553 74.5238041372055
userPage.php:627 6 :42.82678935474531 74.53380896804322


function cSnapToRoute() {

    this.routePoints = Array();
    this.routePixels = Array();
    this._oMap;
    this._oPolyline;

    /**
    *   @desc Initialize the objects.
    *   @param Map object
    *   @param GPolyline object - the 'route'
    **/
    this.init = function (oMap, oPolyline) {
        this._oMap = oMap;
        this._oPolyline = oPolyline;

        this.loadRouteData();   // Load needed data for point calculations
    }

    /**
    *   @desc internal use only, Load route points into RoutePixel array for calculations, do this whenever zoom changes
    **/
    this.loadRouteData = function () {
        this.routePixels = new Array();
        var proj = this._oMap.getProjection();
        for (var i = 0; i < this._oPolyline.getPath().getLength(); i++) {
            var Px = proj.fromLatLngToPoint(this._oPolyline.getPath().getAt(i));
            this.routePixels.push(Px);
        }
    }

    /**
    *   @desc Get closest point on route to test point
    *   @param GLatLng() the test point
    *   @return new GLatLng();
    **/
    this.getClosestLatLng = function (latlng) {
        var r = this.distanceToLines(latlng);
        var proj = this._oMap.getProjection();
        return proj.fromPointToLatLng(new google.maps.Point(r.x, r.y));
    }

    /**
    *   @desc Get distance along route in meters of closest point on route to test point
    *   @param GLatLng() the test point
    *   @return distance in meters;
    **/
    this.getDistAlongRoute = function (latlng) {
        var r = this.distanceToLines(latlng);
        return this.getDistToLine(r.i, r.fTo);
    }

    /**
    *   @desc internal use only, gets test point xy and then calls fundamental algorithm
    **/
    this.distanceToLines = function (thisLatLng) {
        var tm = this._oMap;
        var proj = this._oMap.getProjection();
        var thisPx = proj.fromLatLngToPoint(thisLatLng);
        var routePixels = this.routePixels;
        return getClosestPointOnLines(thisPx, routePixels);
    }

    /**
    *   @desc internal use only, find distance along route to point nearest test point
    **/
    this.getDistToLine = function (iLine, fTo) {

        var routeOverlay = this._oPolyline;
        var d = 0;
        for (var n = 1 ; n < iLine ; n++) {
            d += routeOverlay.getPath().getAt(n - 1).distanceFrom(routeOverlay.getPath().getAt(n));
        }
        d += routeOverlay.getPath().getAt(iLine - 1).distanceFrom(routeOverlay.getPath().getAt(iLine)) * fTo;

        return d;
    }


}

/* desc Static function. Find point on lines nearest test point
   test point pXy with properties .x and .y
   lines defined by array aXys with nodes having properties .x and .y
   return is object with .x and .y properties and property i indicating nearest segment in aXys
   and property fFrom the fractional distance of the returned point from aXy[i-1]
   and property fTo the fractional distance of the returned point from aXy[i]   */


function getClosestPointOnLines(pXy, aXys) {

    var minDist;
    var fTo;
    var fFrom;
    var x;
    var y;
    var i;
    var dist;

    if (aXys.length > 1) {

        for (var n = 1 ; n < aXys.length ; n++) {

            if (aXys[n].x != aXys[n - 1].x) {
                var a = (aXys[n].y - aXys[n - 1].y) / (aXys[n].x - aXys[n - 1].x);
                var b = aXys[n].y - a * aXys[n].x;
                dist = Math.abs(a * pXy.x + b - pXy.y) / Math.sqrt(a * a + 1);
            }
            else
                dist = Math.abs(pXy.x - aXys[n].x)

            // length^2 of line segment
            var rl2 = Math.pow(aXys[n].y - aXys[n - 1].y, 2) + Math.pow(aXys[n].x - aXys[n - 1].x, 2);

            // distance^2 of pt to end line segment
            var ln2 = Math.pow(aXys[n].y - pXy.y, 2) + Math.pow(aXys[n].x - pXy.x, 2);

            // distance^2 of pt to begin line segment
            var lnm12 = Math.pow(aXys[n - 1].y - pXy.y, 2) + Math.pow(aXys[n - 1].x - pXy.x, 2);

            // minimum distance^2 of pt to infinite line
            var dist2 = Math.pow(dist, 2);

            // calculated length^2 of line segment
            var calcrl2 = ln2 - dist2 + lnm12 - dist2;

            // redefine minimum distance to line segment (not infinite line) if necessary
            if (calcrl2 > rl2)
                dist = Math.sqrt(Math.min(ln2, lnm12));

            if ((minDist == null) || (minDist > dist)) {
                if (calcrl2 > rl2) {
                    if (lnm12 < ln2) {
                        fTo = 0;//nearer to previous point
                        fFrom = 1;
                    }
                    else {
                        fFrom = 0;//nearer to current point
                        fTo = 1;
                    }
                }
                else {
                    // perpendicular from point intersects line segment
                    fTo = ((Math.sqrt(lnm12 - dist2)) / Math.sqrt(rl2));
                    fFrom = ((Math.sqrt(ln2 - dist2)) / Math.sqrt(rl2));
                }
                minDist = dist;
                i = n;
            }
        }

        var dx = aXys[i - 1].x - aXys[i].x;
        var dy = aXys[i - 1].y - aXys[i].y;

        x = aXys[i - 1].x - (dx * fTo);
        y = aXys[i - 1].y - (dy * fTo);

    }
                             

    return { 'x': x, 'y': y, 'i': i, 'fTo': fTo, 'fFrom': fFrom };
}
