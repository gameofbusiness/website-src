<?php
	ini_set("zlib.output_compression", 1);

	session_start();

	include 'getToken.php';

	$_SESSION["cpid_error"]='false';

	include 'cacheHelper.php';
?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<!--Define charset.-->
 		<meta charset="utf-8"/>

 		<!--Provide a HTTP header for the info/value of the content attribute.-->
 		<meta http-equiv="content-type" content="text/html"/>

 		<!--
			Give browser instructions on how to control the page's dimensions and scaling.
			Set the width of the page to follow the screen-width of the device.
			Set the initial zoom level when the page is first loaded by the browser.
		-->
		<meta name="viewport" content="width=device-width, initial-scale=1.0"/>

		<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->

		<!--Define keywords for search engines.-->
		<meta name="Keywords" content="Sun Tzu Art of War business strategy PDF, Art of War, Sun Tzu, Sun Tzu Art of War, business strategy, business book, PDF, Game of Business, full version, transformed for business, leadership training, team training, strategy game, strategize, military strategy, leadership book, buy, Sun Tsu"/>

		<!--Define a description of the web page.-->
		<meta name="description" content="UPDATED Sun Tzu for success. Sun Tzu Art of War Business Strategy PDF — Game of Business. The Art of War Transformed for Business — Full Version. "/>

		<!--Define the author of the web page.-->
		<meta name="author" content="Sun Tzu"/>

		<meta name="application-name" content="Game of Business">

		<!-- Facebook Open Graph allows defining properties to create rich text: http://ogp.me/-->
		<meta property="og:site" content="Game of Business">
		<meta property="og:site_name" content="Game of Business"/> <!-- Show site name as root of navigation path -->
		<meta property="og:title" content="Sun Tzu Art of War Business Strategy PDF"/>
		<meta property="og:description" content="UPDATED Sun Tzu for success. Sun Tzu Art of War Business Strategy PDF — Game of Business. The Art of War Transformed for Business — Full Version. "/>
		<meta property="og:image" content="https://www.gameofbusiness.org/images/GB-logo.jpg"/>

		<title>Sun Tzu Art of War Business Strategy PDF</title>

		<!-- Bootstrap core CSS
		<link rel="stylesheet" href="scripts/bootstrap.min.css"/>-->

		<link rel="stylesheet" href="https://www.gameofbusiness.org/css/gob.css"/>

		<link rel="canonical" href="https://www.gameofbusiness.org/book-pdf.php"/>

		<script defer src="https://use.fontawesome.com/releases/v5.0.6/js/all.js"></script>

		<script src="https://www.gameofbusiness.org/scripts/jquery-2.1.4.min.js"></script>
		<script src="https://www.gameofbusiness.org/scripts/bootstrap.min.js"></script>
		<script src="https://www.gameofbusiness.org/scripts/jquery.cookie.js"></script>
		
		
		
		<!-- Latest compiled and minified CSS -->
		<!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.2/dist/css/bootstrap.min.css" rel="stylesheet"> -->

		<!-- Latest compiled JavaScript -->
		<!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.2/dist/js/bootstrap.bundle.min.js"></script> -->

		<script src="https://js.authorize.net/v1/Accept.js"></script> <!--change js.authorize to jstest.authorize for testing-->
		<script src="https://js.authorize.net/v3/acceptUI.js"></script> <!--change js.authorize to jstest.authorize for testing-->
		<script src="https://www.gameofbusiness.org/acceptJSCaller.js"></script>

		<script type="text/javascript">

			//console.log("START index.html <head> script");

			var baseUrl = "https://accept.authorize.net/customer/";
			//console.log("baseUrl = " + baseUrl);

			var onLoad = true;
			//console.log("onLoad = " + onLoad);

			tab = null;
			//console.log("tab = " + tab);

			function returnLoaded()
			{
				console.log("Return Page Called ! ");
				showTab(tab);
			}

			window.CommunicationHandler = {};
			//console.log("window.CommunicationHandler = " + window.CommunicationHandler);

			function parseQueryString(str)
			{
				var vars = [];
				var arr = str.split('&');
				var pair;
				for (var i = 0; i < arr.length; i++)
				{
					pair = arr[i].split('=');
					vars[pair[0]] = unescape(pair[1]);
				}
				return vars;
			}

			CommunicationHandler.onReceiveCommunication = function (argument)
			{
				console.log("START CommunicationHandler.onReceiveCommunication");
				console.log("argument: " + argument);

				console.log("argument, query string: " + argument.qstr);
			}

			function showTab(target)
			{
				//console.log("showTab(" + target + ")");

				//onLoad = true;
				//console.log("currTime: " + currTime);
				var currTime = sessionStorage.getItem("lastTokenTime");
				//console.log("currTime = " + currTime);

				if (currTime === null || (Date.now() - currTime) / 60000 > 15)
				{
					location.reload(true);
					onLoad = true;

					//console.log("location.reload(true)");
					//console.log("onLoad = true");
				}

				//console.log("onLoad: " + onLoad);

				if (onLoad)
				{
					//console.log("BEFORE setTimeout()");
					setTimeout(function()
					{
						//console.log("SETTING TIMEOUT");

						$("#send_token").attr({"action":baseUrl + "addPayment", "target":"add_payment"}).submit();
						//console.log("SUBMIT send_token, addPayment");

						//console.log("currHPTime: " + currHPTime);
						var currHPTime = sessionStorage.getItem("HPTokenTime");
						//console.log("currHPTime = " + currHPTime);
						if (currHPTime === null || (Date.now() - currHPTime) / 60000 > 5)
						{
							/*if(currHPTime === null)
							{
								console.log("currHPTime === null");
							}
							else
							{
								console.log("(Date.now() - currHPTime) / 60000 = (" + Date.now() + " - " + currHPTime + ") / 60000 > 5");
							}*/

							sessionStorage.setItem("HPTokenTime", Date.now());
							//console.log("SET HPTokenTime to " + Date.now());

							$("#getHPToken").load("getHostedPaymentForm.php");
							//console.log("LOAD getHostedPaymentForm.php");

							$("#HostedPayment").css({"height": "200px","background":"url(images/loader.gif) center center no-repeat"});
							//console.log("STYLE HostedPayment");

							$("#send_hptoken").submit();
							//console.log("SUBMIT send_hptoken");
						}
						sessionStorage.removeItem("HPTokenTime");
						//console.log("REMOVE HPTokenTime");
					}
					, 100);
					//console.log("AFTER setTimeout()");

					onLoad = false;
					//console.log("onLoad = false");
				}

				$("#iframe_holder iframe").hide();
				//console.log("HIDE iframe_holder iframe");

				//$("body").css("background",""); $("body").css("background","url('scripts/background.png')");
			}

			function refreshAcceptHosted()
			{
				console.log("REFRESH ACCEPT HOSTED");

				console.log("currHPTime: " + currHPTime);
				var currHPTime = sessionStorage.getItem("HPTokenTime");
				console.log("currHPTime = " + currHPTime);
				if (currHPTime === null || (Date.now() - currHPTime) / 60000 > 5)
				{
					sessionStorage.setItem("HPTokenTime", Date.now());
					$("#getHPToken").load("getHostedPaymentForm.php");
					$("#HostedPayment").css({"height": "200px","background":"url(images/loader.gif) center center no-repeat"});
					$("#send_hptoken").submit();
				}
				sessionStorage.removeItem("HPTokenTime");
			}

			$(function()
			{
				//console.log("tab: " + tab);

				$('a[data-toggle="tab"]').on('shown.bs.tab', function (e)
				{
					console.log("ACTIVATE TAB");
					tab = $(e.target).attr("href") // activated tab
					sessionStorage.setItem("tab", tab);
					showTab(tab);
				});

				onLoad = true;
				sessionStorage.setItem("lastTokenTime",Date.now());
				tab = sessionStorage.getItem("tab");

				if (tab === null)
				{
					//console.log("tab === null");

					$("[href='#pay']").parent().addClass("active");
					//console.log("SET PARENT");

					tab = "#pay";

					//console.log("tab = " + tab);
				}
				else
				{
					//console.log("tab !== null");

					$("[href='" + tab + "']").parent().addClass("active");
				}

				showTab(tab);

				//console.log("AFTER showTab()");

				vph = $(window).height();
				$("pay").css("margin-top",(vph/4)+'px');

				$(window).resize(function()
				{
					//console.log("RESIZE WINDOW");

					$('#pay').css({'margin-top':(($(window).height())/4)+'px'});
				});

				$(window).keydown(function(event)
				{
				  if(event.ctrlKey && event.keyCode == 69)
				  {
					event.preventDefault();
				  }
				});

				$(window).load(function()
				{
					$('#acceptUIPayButton').disabled = false; //or document.getElementById("acceptUIPayButton").setAttribute("disabled", "false"); or document.getElementById("acceptUIPayButton").disabled = false;

					//remove element
					var loadingSpinner = document.getElementById("loader");
					loadingSpinner.parentNode.removeChild(loadingSpinner);

					var payButton = document.getElementById("acceptUIPayButton");
					payButton.innerHTML = "Buy Now"; // alt: "Proceed to Checkout". "Download <em>Game of Business</em> E-Book (PDF)";
					payButton.style.fontWeight = 'bold';
					payButton.disabled = false;
				});

				//console.log("END variable function");
			});
		</script>

		<!--PositiveSSL TrustLogo-->
		<script type="text/javascript">
			/* <![CDATA[ */
				var tlJsHost = ((window.location.protocol == "https:") ? "https://secure.trust-provider.com/" : "http://www.trustlogo.com/");
				document.write(unescape("%3Cscript src='" + tlJsHost + "trustlogo/javascript/trustlogo.js' type='text/javascript'%3E%3C/script%3E"));
			/* ]]> */
		</script>

		<!--
		<script type="application/ld+json">
		{
			"@context": "https://schema.org",
			"@type": "Product",
			"name": "Game of Business Book PDF",
			"image": "https://gameofbusiness.org/images/GB-cover.gif",
			"description": "Game of Business uses the strategic principles from Sun Tzu Art of War to recommend a plan of action for your company.",
			"sku": "1",
			"mpn": "1",
			"brand":
			{
				"@type": "Thing",
				"name": "Game of Business"
			},
			"offers":
			{
				"@type": "offer",
				"url": "https://gameofbusiness.org/book-pdf.php",
				"priceCurrency": "USD",
				"price": "1.00",
				"availability": "https://schema.org/InStock",
				"seller":
				{
					"@type": "Organization",
					"name": "Game of Business"
				}
			}
		}
		</script>
		-->
		
		

	</head>

	<body> <!--class="gob-product-page-content"-->

		<!-- <div id="header"></div> -->
		<!-- Start Header -->
		<div class="gob-bar gob-theme gob-card-2 gob-wide gob-topnav" style="height:44px;">
			<a id="tabbtn-menu" title="Open|Close Menu" class="gob-bar-item gob-button gob-hover-white gob-fa gob-fa-menu" href="javascript:void(0)" onclick="gob_open_menu('menu-accordion', this)" style="display:inline-block;">
				<!-- <i class="fa">&#xf0c9;</i> --> <!--Instead of class='fas fa-bars', use Unicode for "font awesome" bars when menu collapses because window shrunk: &#xf0c9;-->
				<div class="bar1"></div>
				<div class="bar2"></div>
				<div class="bar3"></div>
			</a>
			<a id="tabbtn-logo" href='https://www.gameofbusiness.org' class="gob-bar-item gob-button gob-hover-white"><strong>Game of Business</strong></a>
			<a id="tabbtn-buy" class="gob-bar-item gob-button gob-hover-white" href="https://www.gameofbusiness.org/book-pdf.php" title="Sun Tzu Art of War Business Strategy PDF">Buy E-Book</a>
			<a id="tabbtn-summary" class="gob-bar-item gob-button gob-hover-white" href="https://www.gameofbusiness.org/the-art-of-war/summary.html" title="Game of Business and the Art of War Summary">See Summary</a>
			<a id="tabbtn-game" class="gob-bar-item gob-button gob-hover-white" href="https://www.gameofbusiness.org/sun-tzu/art-of-war/game.html" title="Game of Business and Sun Tzu Art of War Game">Play Game</a>
			<a id="tabbtn-pdf" class="gob-bar-item gob-button gob-hover-white" href="https://www.gameofbusiness.org/the-art-of-war/pdf.html" title="The Art of War PDF"><em>The Art of War</em> PDF</a>
			<a id="tabbtn-level" class="gob-bar-item gob-button gob-hover-white gob-display-right gob-barex" onclick="loadUserData()" href="https://www.gameofbusiness.org/sun-tzu/art-of-war/game.html" title="Game of Business and Sun Tzu Art of War Game">Level
				<span id="level">0</span>
			</a>
		</div>

		<div id='menu-accordion' class="gob-card-2 gob-light-grey gob-center" style="display:none;">
			<a title="Close Menu" href="javascript:void(0)" onclick="gob_close('menu-accordion')" class="gob-button gob-xlarge gob-right">&times;</a><br/>
			<div class="gob-container" style="padding-top:0;padding-bottom:32px;">
				<a href="https://www.gameofbusiness.org/book-pdf.php" class="gob-button gob-block gob-large gob-wide" title="Sun Tzu Art of War Business Strategy PDF">Buy E-Book</a>
				<a href="https://www.gameofbusiness.org/the-art-of-war/summary.html" class="gob-button gob-block gob-large gob-wide" title="Game of Business and the Art of War Summary">See Summary</a>
				<a href="https://www.gameofbusiness.org/sun-tzu/art-of-war/game.html" class="gob-button gob-block gob-large gob-wide" title="Game of Business and Sun Tzu Art of War Game">Play Game</a>
				<a href="https://www.gameofbusiness.org/the-art-of-war/pdf.html" class="gob-button gob-block gob-large gob-wide" title="The Art of War PDF"><em>The Art of War</em> PDF</a>
			</div>
		</div>
		<!-- End Header -->

		<div class="gob-main gob-main-content">

			<article>
			
				<div id="product-title-small" class="gob-row">
												
					<h1 style="padding:0;margin:0;font-size:28px;line-height:36px;">Game of Business: The Art of War for Business</h1>
					<h2 style="padding:0;margin:0;font-size:24px;line-height:32px;color:#565959;">Sun Tzu Art of War Business Strategy PDF</h2>
				
					<div class="gob-author" style="font-size:14px;line-height:20px;margin:0 0 14px 0;">by <a class="gob-product-page-link" href="https://www.gameofbusiness.org/the-art-of-war/pdf.html#aw-origin">Sun Tzu</a></div>

				</div>
						
				<div id="product-preview-photo" style="float:left;line-height:0;text-align:center;">
					<!--carousel-->
					<div id="preview-photo-carousel">
						
						<!-- Wrapper for slides -->
						<div class="gob-preview-photo-wrapper">
					
							<div>
								<a href="https://www.gameofbusiness.org/preview.php" title="Game of Business Preview">
									<div style="display:inline-block;">
										<img style="display:block;" id="look-inside-sticker" src="look-inside-sticker.png" alt="Look Inside" height="19px" width="288px"/>
										<img style="display:block;" src="https://www.gameofbusiness.org/images/GB-cover.gif" alt="Game of Business Book Cover" height="432px" width="288px" />
									</div>
								</a>
							</div>
						
							<!-- 
<div class="carousel-item">
								<img src="images/transforms/GB-transform-1-2-1.png" alt="Transforming Principle 1-2.1" height="432px" width="288px" >
							</div>
						
							<div class="carousel-item">
								<img src="images/transforms/GB-transform-1-2-1.png" alt="Transforming Principle 1-2.1" height="432px" width="288px" >
							</div>
 -->
						
						</div>
						
						<div id="image-block-thumbs" class="buy-image-thumbnails gob-row" style="font-size:14px;line-height:20px;margin:4px 0;">
							<div class="gob-image-thumbs-wrapper">
								<a id="image-thumbs" href="https://www.gameofbusiness.org/see-images.html">
									<!--4 cols-->
									<div >
										<div class="gob-image-thumb">
											<img src="https://www.gameofbusiness.org/images/GB-cover.gif" alt="Transforming Principle 1-2.1">
										</div>
										<div class="gob-image-thumb">
											<img src="images/transforms/GB-transform-1-2-1.png" alt="Transforming Principle 1-2.1">
										</div>
										<div class="gob-image-thumb">
											<img src="images/transforms/GB-transform-1-2-2.png" alt="Transforming Principle 1-2.1">
										</div>
										<div class="gob-image-thumb" style="margin-right:0;">
											<img src="images/transforms/GB-transform-1-2-4.png" alt="Transforming Principle 1-2.1">
										</div>
									</div>
								</a>
							</div>
						</div>

					
						<a id="see-images-link" style="font-size:14px;line-height:20px;margin:0 0 20px 0;display:block;clear:both;" class="gob-product-page-link" href="https://www.gameofbusiness.org/see-images.html">See all images</a>
					
					</div>
					
				</div>
				
				<div id="product-formats-small" class="gob-book-format gob-spacing-large" style="padding:5px 10px 5px 11px;display:inline-block;border:1px solid #e77600;border-radius:3px;background-color:#fef8f2;">
					<div style="font-size:13px;"><strong>E-Book PDF</strong></div>
					<div style="color:#B12704;font-size:14px;"><strong>$<span class="gob-pdf-price"></span>.00</strong></div>
				</div>
				
				<div id="product-info-large" style="float:left;padding-right:40px;">
					<div id="product-title-large">
						<h1 style="padding:0;margin:0;font-size:28px;line-height:36px;">Game of Business: The Art of War for Business</h1>
						<h2 style="padding:0;margin:0;font-size:24px;line-height:32px;color:#565959;">Sun Tzu Art of War Business Strategy PDF</h2>
						<div id="gob-author" style="border-bottom:1px solid #ddd;font-size:14px;line-height:20px;padding:0 0 7px 0;margin:0 0 14px 0;">by <a class="gob-product-page-link" href="https://www.gameofbusiness.org/the-art-of-war/pdf.html#aw-origin">Sun Tzu</a></div>
					</div>
					
					<div id="product-formats-large" class="gob-book-format gob-spacing-large" style="padding:5px 10px 5px 11px;display:inline-block;border:1px solid #e77600;border-radius:3px;background-color:#fef8f2;">
						<div style="font-size:13px;"><strong>E-Book PDF</strong></div>
						<div style="color:#B12704;font-size:14px;"><strong>$<span class="gob-pdf-price"></span>.00</strong></div>
					</div>
					
					<div class="bookDescription_feature_div">
						<p><em>Game of Business</em> is the continuation of Sun Tzu's work, <em>the Art of War</em>, for the world of business. </p>
						<p><em>Game of Business</em> is the recommendation system that helps guide you on a journey of learning business strategy. </p>
						<p>Use <em>Game of Business</em> to see how each strategy in the <em>Art of War</em> can be applied to your business practices. </p>
						<p>Beside each strategy in <em>Game of Business</em> is the original <em>Art of War</em> strategy, in parallel, so you can see how each strategy in <em>Game of Business</em> is derived from its counterpart in <em>the Art of War</em>. </p>
					</div>
				</div>
				
				<div id="price-line-small" class="gob-book-price gob-row" style="line-height:1;">$<span class="gob-pdf-price"></span><span style="font-size:16px;position:relative;bottom:10px;">&nbsp;00</span></div>
				
				<div class="product-buy gob-row" style="top:0;">
				
					<div class="product-buy-wrapper">
				
						<div id="price-lines-large" class="gob-row gob-price-lines-large" style="font-size:14px;line-height:20px;margin-bottom:16px;">
							<div style="padding:10px 0;"><strong>E-Book PDF:</strong><span style="float:right;clear:both;color:#B12704;">$<span class="gob-pdf-price"></span>.00</span></div>
						</div>
										
						<div id="acceptUIPayDiv" style="margin-top:12px;">
							<button id="acceptUIPayButton"
									class="AcceptUI gob-btn gob-center gob-button-text gob-pay-button"
									style="border-radius:20px;box-shadow:0 2px 5px 0 rgb(213 217 217 / 50%);background-color:#FFA41C;border:1px solid #FF8F00;margin-bottom:12px;"
									type="button"
									data-billingAddressOptions='{"show":true, "required":true}'
									data-apiLoginID="3T6t9Q48UfGz"
									data-clientKey="26PUqPCjpfcNK4dAXqQXv3929Vdh8d7QryEuTjVnrmN4HG6tZtM3388LbVyg8CKD"
									data-acceptUIFormBtnTxt="Place Your Order, $10"
									data-acceptUIFormHeaderTxt="Game of Business E-Book PDF."
									data-paymentOptions='{"showCreditCard":true, "showBankAccount":false}'
									data-responseHandler="responseHandler"
									disabled="disabled">

								<img style="height:24px;z-index:9999;position:relative;margin:auto;vertical-align:middle" id="loader" class="gob-loader" src="https://www.gameofbusiness.org/images/Loader.gif" alt="Loading" height="24px"/>
							</button>
						</div>


						<!-- bootstrap 2 --> <!-- alt onclick='$(&quot;#secure-popover&quot;).popover(&quot;hide&quot;);'-->
						<div id="secure-transaction-large" class="gob-secure-transaction" style="box-sizing:border-box;">
							<span style="box-sizing:border-box;">
								<a 	id="secure-popover"
									class="gob-secure-link" 
									href="javascript://" 
									data-toggle="popover" 
									data-placement="bottom" 
									data-html="true"
									data-trigger="click"
									data-title="<button type='button' style='background-color:#fbfbfd;color:#1d1d1f;top:0;right:0;border:none;float:right;clear:both;' id='close' class='gob-close-popover' onclick='$(&quot;#secure-popover&quot;).click();'>&times;</button><br/>Your transaction is secure " 
									data-content="Our payment security system encrypts your information during transmission. We do not see your credit card details. <a class='gob-product-page-link' href='https://www.gameofbusiness.org/about/about-privacy.html' title='About Privacy' target='_blank'>Learn more</a>">
									<span style="vertical-align:middle;box-sizing:border-box;">					
										<img id="secure-transaction-icon" src="https://www.gameofbusiness.org/images/secure-transaction-icon.png" style="height:15px!important;box-sizing:border-box;"/>
									</span>
									<span style="display:inline-block;"></span>
									<span>Secure Transaction</span>
								</a>
							</span>
						</div>
						
					</div>
					
					<div id="product-info-medium" class="gob-row">
				
						<div id="product-formats-medium" class="gob-book-format gob-spacing-large" style="padding:5px 10px 5px 11px;display:inline-block;border:1px solid #e77600;border-radius:3px;background-color:#fef8f2;">
							<div style="font-size:13px;"><strong>E-Book PDF</strong></div>
							<div style="color:#B12704;font-size:14px;"><strong>$<span class="gob-pdf-price"></span>.00</strong></div>
						</div>
					
						<div class="bookDescription_feature_div">
							<p><em>Game of Business</em> is the continuation of Sun Tzu's work, <em>the Art of War</em>, for the world of business. </p>
							<p><em>Game of Business</em> is the recommendation system that helps guide you on a journey of learning business strategy. </p>
							<p>Use <em>Game of Business</em> to see how each strategy in the <em>Art of War</em> can be applied to your business practices. </p>
							<p>Beside each strategy in <em>Game of Business</em> is the original <em>Art of War</em> strategy, in parallel, so you can see how each strategy in <em>Game of Business</em> is derived from its counterpart in <em>the Art of War</em>. </p>
						</div>
					</div>

				</div>
				
				<div id="secure-transaction-small" class="gob-secure-transaction" style="box-sizing:border-box;">
					<span style="box-sizing:border-box;">
						<a 	id="secure-popover-small"
							class="gob-secure-link" 
							href="javascript://" 
							data-toggle="popover" 
							data-placement="bottom" 
							data-html="true"
							data-trigger="click"
							data-title="<button type='button' style='background-color:#fbfbfd;color:#1d1d1f;top:0;right:0;border:none;float:right;clear:both;' id='close' class='gob-close-popover' onclick='$(&quot;#secure-popover-small&quot;).click();'>&times;</button><br/>Your transaction is secure " 
							data-content="Our payment security system encrypts your information during transmission. We do not see your credit card details. <a class='gob-product-page-link' href='https://www.gameofbusiness.org/about/about-privacy.html' title='About Privacy' target='_blank'>Learn more</a>">
							<span style="vertical-align:middle;box-sizing:border-box;">					
								<img id="secure-transaction-icon" src="https://www.gameofbusiness.org/images/secure-transaction-icon.png" style="height:15px!important;box-sizing:border-box;"/>
							</span>
							<span style="display:inline-block;"></span>
							<span>Secure Transaction</span>
						</a>
					</span>
				</div>
				
				
				
				<div id="product-info-small" class="gob-row gob-margin-bottom gob-padding">
					
					<div class="bookDescription_feature_div">
						<p><em>Game of Business</em> is the continuation of Sun Tzu's work, <em>the Art of War</em>, for the world of business. </p>
						<p><em>Game of Business</em> is the recommendation system that helps guide you on a journey of learning business strategy. </p>
						<p>Use <em>Game of Business</em> to see how each strategy in the <em>Art of War</em> can be applied to your business practices. </p>
						<p>Beside each strategy in <em>Game of Business</em> is the original <em>Art of War</em> strategy, in parallel, so you can see how each strategy in <em>Game of Business</em> is derived from its counterpart in <em>the Art of War</em>. </p>
					</div>
				</div>
				
				<div id="buy-btn-divider" class="gob-row" style="top:55px;">
					<hr style="border-top:1px solid #e7e7e7;line-height:19px;margin-top:0;margin-bottom:14px;"/>
				</div>
				
				<section>

					<div id="preview-gb" class="gob-row gob-center gob-xlarge-margin-bottom">
			
						<h3 class="gob-xxlarge"><strong>Compare <em>the Art of War</em> and <em>Game of Business</em></strong>: See each strategy in <em>the Art of War</em> transform to <em>Game of Business</em>. </h3>

					</div>
				
				</section>
				
				<section>

					<div class="gob-row gob-center gob-xlarge-margin-bottom">
										
						<h3 class="gob-card-2 gob-padding gob-xxlarge gob-text-red gob-xlarge-margin-bottom"><strong>The Most Precise Transformation of <em class="gob-nowrap">the Art of War</em> for Business</strong></h3>
						
						<h3 class="gob-card-2 gob-padding gob-xxlarge gob-text-red gob-xlarge-margin-bottom"><strong>The Most Thoroughly Tested Leadership Principles and Strategies</strong></h3>
				
						<!--<h4 class="gob-xxlarge gob-xlarge-margin-bottom"><strong><em>Game of Business</em> is the most precise transformation of <em class="gob-nowrap">the Art of War</em> for business. </strong></h4>-->
						
						<h5 class="gob-card-2 gob-padding gob-xlarge"><q>In the practical Game of <strong>Business</strong>, the best <strong>strategy</strong> of all is to remain intact rather than allowing damage.</q> <br/><span class="gob-nowrap">–<em>Game of Business</em>,</span> <span class="gob-nowrap">Principle 3-1</span> <span class="gob-nowrap">(Chapter 3,</span> <span class="gob-nowrap">Principle 1) </span></h5>

					</div>
					
				</section>
				
				<h3><strong>Book Description</strong></h3>
				<div class="gob-section2 gob-row gob-xlarge-margin-bottom">
			
					<p>Game of Business transforms the principles in <em>Sun Tzu Art of War</em> from military strategy to business strategy, so that <em>Art of War</em>'s framework to master basic strategy for military can be used to master basic strategy for business. To make the mastery of basic, business strategy a fun and useful experience, each set of principles in Game of Business forms a unique, business strategy skill. </p>
					<p>Example Skill (Chapter 13: Using Intelligence)—Use foreknowledge to achieve extraordinary success: No relationships are more intimate than those with discoverers of useful information. No rewards should be more generous than those for discovering useful information. Hence, enlightened mentors and wise leaders use the highest intelligence for investigation, and thereby achieve great results (see Chapter 13; Principles 5, 10, 11, and 24). </p>

				</div>
				
				<section>

					<h3><strong>Product Details</strong></h3>
					<div class="gob-product-details gob-row gob-section2">

						<table>
							<tr>
								<td>Author:</td>
								<td><a href="https://www.gameofbusiness.org/the-art-of-war/pdf.html#aw-origin" title="The Art of War Origin Story" target="_blank">Sun Tzu</a></td>
							</tr>
							<tr>
								<td>Translator:</td>
								<td><a href="https://www.gameofbusiness.org/about/about.html" title="About Game of Business" target="_blank">Game of Business</a></td>
							</tr>
							<tr>
								<td>Publisher:</td>
								<td><a href="https://www.gameofbusiness.org/about/about.html" title="About Game of Business" target="_blank">Game of Business</a></td>
							</tr>
							<tr>
								<td>Reference Translations:</td>
								<td>
									<a href="https://www.gameofbusiness.org/about/about.html#about-giles-translation" target="_blank" title="About Giles Translation of the Art of War">Lionel Giles</a>, 
									<a href="https://www.gameofbusiness.org/about/about.html#about-griffith-translation" target="_blank" title="About Griffith Translation of the Art of War">Samuel B. Griffith</a>, 
									<a href="https://www.gameofbusiness.org/about/about.html#about-wing-translation" target="_blank" title="About Wing Translation of the Art of War">R.L. Wing</a>, 
									<a href="https://www.gameofbusiness.org/about/about.html#about-sawyer-translation" target="_blank" title="About Sawyer Translation of the Art of War">Ralph D. Sawyer</a>, 
									<a href="https://www.gameofbusiness.org/about/about.html#about-wee-translation" target="_blank" title="About Wee Translation of the Art of War">Chow Hou Wee</a>, 
									<a href="https://www.gameofbusiness.org/about/about.html#about-cleary-translation" target="_blank" title="About Cleary Translation of the Art of War">Thomas Cleary</a>, 
									<a href="https://www.gameofbusiness.org/about/about.html#about-ames-translation" target="_blank" title="About Ames Translation of the Art of War">Roger T. Ames</a>, 
									<a href="https://www.gameofbusiness.org/about/about.html#about-minford-translation" target="_blank" title="About Minford Translation of the Art of War">John Minford</a>, 
									<a href="https://www.gameofbusiness.org/about/about.html#about-mair-translation" target="_blank" title="About Mair Translation of the Art of War">Victor Mair</a>, 
									<a href="https://www.gameofbusiness.org/about/about.html#about-cc-low-translation" target="_blank" title="About C. C. Low & Associates Translation of the Art of War">C. C. Low & Associates</a>
								</td>
							</tr>
							<tr>
								<td>Format:</td>
								<td>Electronic Book, Portable Document Format (E-Book, PDF)</td>
							</tr>
							<tr>
								<td>Main Content:</td>
								<td>103 pages</td>
							</tr>
							<tr>
								<td>Supplementary Content:</td>
								<td>161 pages</td>
							</tr>
							<tr>
								<td>Language:</td>
								<td>English</td>
							</tr>
							<tr>
								<td>ISBN-X:</td>
								<td>978-0-9999998-0-5</td>
							</tr>
							<tr>
								<td>File Format:</td>
								<td><a href="https://edu.gcfglobal.org/en/basic-computer-skills/what-is-a-pdf-file/1/" target="_blank" title="About PDF Files">PDF</a> is a file format that provides an electronic image of text or text and graphics that looks like a printed document and can be viewed, printed, and electronically transmitted.</td>
							</tr>
							<tr>
								<td>Download Location:</td>
								<td>"Game-of-Business.pdf" will be downloaded to your default or chosen, downloads folder, which is likely called "Downloads." If you cannot find the book file ("Game-of-Business.pdf") in your computer's filesystem, email support@gameofbusiness.org with your transaction ID.</td>
							</tr>
						</table>
					</div>
					
				</section>

			</article>

			<div id="getHPToken">
				<?php include 'getHostedPaymentForm.php'; ?>
			</div>

			<div id="contact-modal"></div>

			<div id="acceptJSReceiptModal0" class="gob-modal fade" role="dialog">
				<div class="gob-modal-dialog" style="display: inline-block; vertical-align: middle;">
					<div class="modal-content">
						<div class="modal-header" id="acceptJSReceiptHeader">
							<h4 class="modal-title">Game of Business Receipt</h4>
						</div>
						<div class="modal-body" id="acceptJSReceiptBody"></div>
					</div>
				</div>
			</div>

			<!-- Modal -->
			<div id="acceptJSPayModal" class="gob-modal fade" role="dialog">
				<div class="gob-modal-dialog" style="display: inline-block; vertical-align: middle;">

					<!-- Modal content-->
					<div class="modal-content">

						<div class="modal-header">
							<h4 class="modal-title"></h4>
						</div>

						<div class="modal-body" id="acceptJSPayBody">
							<!--form role="form"-->
							<div class="form-group col-xs-8">
								<label for="creditCardNumber"></label>
								<input type="tel" class="form-control" id="creditCardNumber" placeholder="4111111111111111" value="4111111111111111" autocomplete="off"/>
							</div>
							<div class="form-group col-xs-4">
								<label for="cvv"></label>
								<input type="text" class="form-control" id="cvv" placeholder="123" autocomplete="off"/>
							</div>

							<!--div class="form-group col-xs-6 col-xs-offset-1" style="margin-bottom: 2px; border: 2px solid; border-color: #ccc; border-radius: 3px">
								<span style="color: #999; font-weight: 550;">Expiry Date</span>
							</div>
							<div class="form-group col-xs-5" style="margin-bottom: 7px;">
								<span style="opacity: 0">Filler</span>
							</div-->

							<div>
								<div class="form-group col-xs-5">
									<label for="expiryDateYY"></label>
									<input type="text" class="form-control" id="expiryDateYY" placeholder="YYYY"/>
								</div>

								<div class="form-group col-xs-3">
									<label for="expiryDateMM" style="opacity: 0"></label>
									<input type="text" class="form-control" id="expiryDateMM" placeholder="MM"/>
								</div>

								<div class="form-group col-xs-4">
									<label for="amount"></label>
									<input type="text" class="form-control" id="amount" placeholder="0.5"/>
								</div>
							</div>

							<!--/form-->
							<div style="text-align: center; margin-top: 20%;">
								<button type="button" id="submitButton" class="btn btn-primary" style="width: 95%;"></button>
							</div>
						</div>
					</div>
				</div>
			</div>

			<!--causes popups, which are blocked by Chrome, when removed-->
			<div  id="iframe_holder" class="center-block" style="width:100%;max-width: 1000px">
				<iframe id="load_payment" class="embed-responsive-item" name="load_payment" width="100%" height="650px" frameborder="0" scrolling="no" hidden="true">
				</iframe>

				<iframe id="load_profile" class="embed-responsive-item" name="load_profile" width="100%" height="1150px" frameborder="0" scrolling="no" hidden="true">
				</iframe>

				<iframe id="add_payment" class="embed-responsive-item panel" name="add_payment" width="100%"  frameborder="0" scrolling="no" hidden="true">
				</iframe>

				<iframe id="edit_payment" class="embed-responsive-item panel" name="edit_payment" width="100%"  frameborder="0" scrolling="no" hidden="true">
				</iframe>

				<form id="send_token" action="" method="post" target="load_profile" >
					<input type="hidden" name="token" value="<?php echo $response->token ?>" />
					<input type="hidden" name="paymentProfileId" value="" />
					<input type="hidden" name="shippingAddressId" value="" />
				</form>
				<form id="send_hptoken" action="https://accept.authorize.net/payment/payment" method="post" target="load_payment" >
					<input type="hidden" name="token" value="<?php echo $hostedPaymentResponse->token ?>" />
				</form>
			</div>

			<div class="tab-content panel-group" style="display:none">
				<div class="tab-pane" id="pay" hidden="true"></div>
			</div>

			<div class="gob-modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
				<div class="gob-modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
							<h4 class="modal-title" id="myModalLabel" style="font-weight: bold">Edit </h4>
						</div>
						<div class="modal-body">
							<iframe id="add_shipping" class="embed-responsive-item" name="add_shipping" width="100%"  frameborder="0" scrolling="no" hidden="true" ></iframe>
							<iframe id="edit_shipping" class="embed-responsive-item" name="edit_shipping" width="100%"  frameborder="0" scrolling="no" hidden="true"></iframe>
						</div>
					</div>
				</div>
			</div>

			<div class="gob-modal fade" id="HPConfirmation" role="dialog">
				<div class="gob-modal-dialog" style="display: inline-block; vertical-align: middle;">
					<div class="modal-content">
						<div class="modal-header">
							<button id="closeAcceptConfirmationHeaderBtn" type="button" class="close" data-dismiss="modal">&times;</button>
							<h4 class="modal-title"><b>Payment Confirmation</b></h4>
						</div>
						<div class="modal-body" style="background-color: antiquewhite">
							<p style="font-size: 16px; font-style: italic; padding:10px; color: #444; text-align: center"></p>
						</div>
						<div class="modal-footer">
							<button id="closeAcceptConfirmationFooterBtn" type="button" class="btn btn-success" data-dismiss="modal">Close</button>
						</div>
					</div>
				</div>
			</div>
		</div> <!--end main-->

		<div id="footer"></div>
		
		<script src="https://www.gameofbusiness.org/scripts/gb-sections.js"></script>
		<script src="https://www.gameofbusiness.org/scripts/gb-display.js"></script>
		
		<!-- 
<script>
			// when user clicks div, open popup
			function popupFunction()
			{
				var popup = document.getElementById("secure-popup");
				popup.classList.toggle("show");
			}
			
		</script>
 -->

 
 		<script>
		$(document).ready(function(){
			$('[data-toggle="popover"]').popover();   
			
			$('body').on('click', function (e) {
				$('[data-toggle=popover]').each(function () {
					// hide any open popovers when anywhere else in the body is clicked
					if (!$(this).is(e.target) && $(this).has(e.target).length === 0 && $('.popover').has(e.target).length === 0) {
						// $(this).popover('hide');
						if ($(this).next('.popover').is(':visible')){
							// $('#secure-popover').click();
							$(this).click();
							// $('#buy-btn-divider hr').css("border-color","#e7e7e7");
						}
					}
				});
			});
			
			// $('#secure-popover-small').on('click', function () {
// 				// hide line when popover opened and show line when closed
// 				$('#buy-btn-divider hr').css("border-color","#fbfbfd");
// 			});
		});
		
		</script>

	</body>
</html>
