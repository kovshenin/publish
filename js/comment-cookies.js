jQuery(document).ready(function($) {
	
	// Create cookies before submit
	$('#commentform').submit(function() {
		var author = $('#author').val();
		var email = $('#email').val();
		var url = $('#url').val();
		
		createCookie('comment_author_' + comment_cookies.cookiehash, author, 300);
		createCookie('comment_author_email_' + comment_cookies.cookiehash, email, 300);
		createCookie('comment_author_url_' + comment_cookies.cookiehash, url, 300);
	});
	
	// Restore field values from cookies
	var author = readCookie('comment_author_' + comment_cookies.cookiehash);
	var email = readCookie('comment_author_email_' + comment_cookies.cookiehash);
	var url = readCookie('comment_author_url_' + comment_cookies.cookiehash);
	
	$('#author').val(author);
	$('#email').val(email);
	$('#url').val(url);
	
	// Create a cookie
	function createCookie(name,value,days) {
		if (days) {
			var date = new Date();
			date.setTime(date.getTime()+(days*24*60*60*1000));
			var expires = "; expires="+date.toGMTString();
		}
		else var expires = "";
		document.cookie = name+"="+value+expires+"; path=" + comment_cookies.cookiepath + "; domain=" + comment_cookies.cookie_domain;
	}

	// Read a cookie
	function readCookie(name) {
		var nameEQ = name + "=";
		var ca = document.cookie.split(';');
		for(var i=0;i < ca.length;i++) {
			var c = ca[i];
			while (c.charAt(0)==' ') c = c.substring(1,c.length);
			if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
		}
		return null;
	}

	// Delete a cookie
	function eraseCookie(name) {
		createCookie(name,"",-1);
	}
});