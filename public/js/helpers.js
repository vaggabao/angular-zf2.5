helpers = {
    
	ajaxGet: function(url, callback) {
		var xhr = window.XMLHttpRequest ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
		xhr.open('GET', url);
		xhr.onreadystatechange = function() {
			if (xhr.readyState > 3 && xhr.status === 200) {
				callback(xhr.responseText);
			}
		};
		xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
		xhr.send();

		return xhr;
	},
    
	ajaxPost: function(url, data, callback) {
		var params = typeof data == 'string' ? data : Object.keys(data).map(
				function(k){ return encodeURIComponent(k) + '=' + encodeURIComponent(data[k]); }
			).join('&');

		var xhr = window.XMLHttpRequest ? new XMLHttpRequest() : new ActiveXObject("Microsoft.XMLHTTP");
		xhr.open('POST', url);
		xhr.onreadystatechange = function() {
			if (xhr.readyState > 3 && xhr.status === 200) {
				callback(xhr.responseText);
			}
		};
		xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
		xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
		xhr.send(params);

		return xhr;
	},

	fadeIn: function(element, speed, callback) {
		if (!element.style.opacity) {
            element.style.opacity = 0;
            element.style.display = 'block';
        }
		
		var start = null;
		window.requestAnimationFrame(function animate(timestamp) {
			start = start || timestamp;
			var progress = timestamp - start;
			element.style.opacity = progress / speed;
			if (progress >= speed) {
				if (callback && typeof(callback) === "function") {
					callback();
				}
			} else {
				window.requestAnimationFrame(animate);
			}
		});
	},
    
	fadeOut: function(element, speed, callback) {
		if ( ! element.style.opacity) { element.style.opacity = 1; }

		var start = null;
		window.requestAnimationFrame(function animate(timestamp) {
			start = start || timestamp;
			var progress = timestamp - start;
			element.style.opacity = 1 - progress / speed;
			if (progress >= speed) {
                element.style.display = 'none';
				if (callback && typeof(callback) === "function") {
					callback();
				}
			} else {
				window.requestAnimationFrame(animate);
			}
		});
	},
}