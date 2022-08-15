// Start Sections Scripts
$(function()
{
	// we know header much faster to load inline than ext doc. then why fcns or scripts load same inline as in external doc?
	highlight_tab()
	
	//var header_url = "https://www.gameofbusiness.org/sections/header.html";
	var footer_url = "https://www.gameofbusiness.org/sections/footer.html";
	var contact_modal_url = "https://www.gameofbusiness.org/sections/contact-modal.html";

	//load_doc(header_url, load_header);

	load_doc(footer_url, load_footer);

	load_doc(contact_modal_url, load_contact_modal);

	// $(".dropdown").on("hide.bs.dropdown", function()
	// {
	// 	$(".btn").html('<span class="caret"></span> Preface');
	// });
	// $(".dropdown").on("show.bs.dropdown", function()
	// {
	// 	$(".btn").html('<span class="caret caret-up"></span> Preface');
	// });
	
	load_gb_price();
});

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

function load_gb_price()
{
	//===Set GB PDF price===
	var gb_pdf_price_usd = "10";
	// var gb_pdf_price_usd = " $" + gb_pdf_price_usd_value;

	$(".gob-pdf-price").each(function()
	{
		$(this).html(gb_pdf_price_usd);
	});
}

function load_current_year()
{
	var d = new Date();
	var cur_yr = d.getFullYear();
	
	document.getElementById("current_year").innerHTML = cur_yr;
}

//===Put all variables to load for gb page
//currently only price var, but will also be level of user in gb
function load_gb_header_vars()
{
	//load_gb_price();

	//load_gb_level();
}

function load_gb_footer_vars()
{
	load_current_year();
}

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

// currently only loading gb price,
// later could load features depending on which page currently viewing
function load_footer(xhttp)
{
	document.getElementById("footer").outerHTML = xhttp.responseText;

	load_gb_footer_vars();
}

function load_contact_modal(xhttp)
{
	document.getElementById("contact-modal").outerHTML = xhttp.responseText;

	var request_path = document.getElementById("current-path");
	if (request_path != null)
	{
		request_path.innerHTML = window.location.pathname; // for error pages to show request uri
	}
}
// End Sections Scripts
