/** Converts numeric degrees to radians */
if (typeof Number.prototype.toRadians == 'undefined') {
    Number.prototype.toRadians = function() {
        return this * Math.PI / 180;
    }
}


/** Converts radians to numeric (signed) degrees */
if (typeof Number.prototype.toDegrees == 'undefined') {
    Number.prototype.toDegrees = function() {
        return this * 180 / Math.PI;
    }
}

/** 
 * Formats the significant digits of a number, using only fixed-point notation (no exponential)
 * 
 * @param   {Number} precision: Number of significant digits to appear in the returned string
 * @returns {String} A string representation of number which contains precision significant digits
 */
if (typeof Number.prototype.toPrecisionFixed == 'undefined') {
    Number.prototype.toPrecisionFixed = function(precision) {

    // use standard toPrecision method
    var n = this.toPrecision(precision);

    // ... but replace +ve exponential format with trailing zeros
    n = n.replace(/(.+)e\+(.+)/, function(n, sig, exp) {
        sig = sig.replace(/\./, '');       // remove decimal from significand
        l = sig.length - 1;
        while (exp-- > l) sig = sig + '0'; // append zeros from exponent
        return sig;
    });

    // ... and replace -ve exponential format with leading zeros
    n = n.replace(/(.+)e-(.+)/, function(n, sig, exp) {
        sig = sig.replace(/\./, '');       // remove decimal from significand
        while (exp-- > 1) sig = '0' + sig; // prepend zeros from exponent
        return '0.' + sig;
    });

    return n;
  }
}

function LatLon(lat, lon, radius) {
    if (typeof(radius) == 'undefined') radius = 3440;  // earth's mean radius in km

    this.lat    = Number(lat);
    this.lon    = Number(lon);
    this.radius = Number(radius);
}

LatLon.prototype.distanceTo = function(point, precision) {
    // default 4 sig figs reflects typical 0.3% accuracy of spherical model
    if (typeof precision == 'undefined') precision = 4;
  
    var R = this.radius;
    var phi1 = this.lat.toRadians(),  psi1 = this.lon.toRadians();
    var phi2 = point.lat.toRadians(), psi2 = point.lon.toRadians();
    var dphi = phi2 - phi1;
    var dpsi = psi2 - psi1;

    var a = Math.sin(dphi/2) * Math.sin(dphi/2) +
            Math.cos(phi1) * Math.cos(phi2) *
            Math.sin(dpsi/2) * Math.sin(dpsi/2);
    var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a));
    var d = R * c;

    return d.toPrecisionFixed(Number(precision));
}

LatLon.prototype.bearingTo = function(point) {
    var phi1 = this.lat.toRadians(), phi2 = point.lat.toRadians();
    var lam = (point.lon-this.lon).toRadians();

    var y = Math.sin(lam) * Math.cos(phi2);
    var x = Math.cos(phi1)*Math.sin(phi2) -
            Math.sin(phi1)*Math.cos(phi2)*Math.cos(lam);
    var d = Math.atan2(y, x);
  
    return (d.toDegrees()+360) % 360;
}