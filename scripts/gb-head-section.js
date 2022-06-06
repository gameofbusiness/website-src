// load header separate from other sections bc should run in head section of page
//
// we know header much faster to load inline than ext doc. then why fcns or scripts load same inline as in external doc?

function highlight_tab()
{
	//===Highlight Current Tab===
	// this will get the full URL at the address bar
	var url = window.location.href;

	//console.log("url: " + url);

	// passes on every "a" tag
	$(".gob-topnav a").each(function()
	{
		// checks if its the same on the address bar
		if (url == (this.href))
		{
			$(this).addClass("active");
		}
	});
}

function load_header(xhttp)
{
	document.getElementById("header").outerHTML = xhttp.responseText;

	//load_gb_header_vars();

	highlight_tab();
}

function load_doc(url, c_function)
{
	var xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function()
	{
		if (this.readyState == 4 && this.status == 200)
		{
			c_function(this);
		}
	};
	xhttp.open("GET", url, true);
	xhttp.send();
}

$(function()
{
	// var header_url = "https://www.gameofbusiness.org/sections/header.html";
// 
// 	load_doc(header_url, load_header);

	highlight_tab()
});



