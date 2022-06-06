// Start Header Scripts
$(function()
{
	$("#header").load("../sections/header.html");
	
	$.when( $.ajax( "../sections/header.html" ) )
		.then( load_header_vars );
});

function load_header_vars()
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

	//===Set GB PDF price===
	var gb_pdf_price_usd_value = "10";
	var gb_pdf_price_usd = " $" + gb_pdf_price_usd_value;

	$(".gob-pdf-price").each(function()
	{
		$(this).html(gb_pdf_price_usd);
	});
}

// function ajax1()
// {
// 	$("#header").load("../sections/header.html");
// 	
// 	return $.ajax();
// }
// End Header Scripts