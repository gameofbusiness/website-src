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
		<meta name="Keywords" content="Sun Tzu Art of War business strategy PDF, Art of War, Sun Tzu, Sun Tzu Art of War, business strategy, business book, PDF, Game of Business, full version, transformed for business, leadership training, team training, strategy game, strategize, military strategy, leadership book, buy, Sun Tsu, preview"/>

		<!--Define a description of the web page.-->
		<meta name="description" content="Preview UPDATED Sun Tzu for success. Sun Tzu Art of War Business Strategy PDF — Game of Business. The Art of War Transformed for Business — Full Version. "/>

		<!--Define the author of the web page.-->
		<meta name="author" content="Sun Tzu"/>

		<meta name="application-name" content="Game of Business">

		<!-- Facebook Open Graph allows defining properties to create rich text: http://ogp.me/-->
		<meta property="og:site" content="Game of Business">
		<meta property="og:site_name" content="Game of Business"/> <!-- Show site name as root of navigation path -->
		<meta property="og:title" content="Sun Tzu Art of War Business Strategy PDF Preview"/>
		<meta property="og:description" content="Preview UPDATED Sun Tzu for success. Sun Tzu Art of War Business Strategy PDF — Game of Business. The Art of War Transformed for Business — Full Version. "/>
		<meta property="og:image" content="https://www.gameofbusiness.org/images/GB-logo.jpg"/>

		<title>Sun Tzu Art of War Business Strategy PDF Preview</title>

		<!-- Bootstrap core CSS
		<link rel="stylesheet" href="scripts/bootstrap.min.css"/>-->

		<link rel="stylesheet" href="https://www.gameofbusiness.org/css/gob.css"/>

		<link rel="canonical" href="https://www.gameofbusiness.org/book-pdf.php"/>

		<script defer src="https://use.fontawesome.com/releases/v5.0.6/js/all.js"></script>

		<script src="https://www.gameofbusiness.org/scripts/jquery-2.1.4.min.js"></script>
		<script src="https://www.gameofbusiness.org/scripts/bootstrap.min.js"></script>
		<script src="https://www.gameofbusiness.org/scripts/jquery.cookie.js"></script>

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

		<div class="gob-row">

			<article>
				
				<section>
				
					<div class="gob-row gob-reader">
					
						<div class="gob-local-nav gob-sticky gob-row" style="padding:0 10px;top: 0;background-color:#000;opacity:0.9;">
						
							<h1 class="gob-local-nav-title">Product Preview</h1>
						
							<div class="gob-local-nav-item">
			
								<a id="tabbtn-close-preview" 
									href="https://www.gameofbusiness.org/book-pdf.php" 
									title="Sun Tzu Art of War Business Strategy PDF"
									style="text-decoration:none;font-size:13px;line-height:16px;color:#fbfbfd;"><span style="display:inline-block;vertical-align:middle;">Close&nbsp;</span><span style="font-size:30px;display:inline-block;vertical-align:middle;">&times;</span></a>
					
							</div>
						</div>
				
						<div class="gob-center preview-content-large">
				
							<img src="https://www.gameofbusiness.org/images/pages/gb-page1.jpg" alt="Game of Business Cover" width="580px" height="751px"/>
							<img src="https://www.gameofbusiness.org/images/pages/gb-page2.jpg" alt="Game of Business Page 1" width="580px" height="751px"/>
							<img src="https://www.gameofbusiness.org/images/pages/gb-page3.jpg" alt="Game of Business Page 2" width="580px" height="751px"/>
							<img src="https://www.gameofbusiness.org/images/pages/gb-page4.jpg" alt="Game of Business Page 3" width="580px" height="751px"/>
							<img src="https://www.gameofbusiness.org/images/pages/gb-page5.jpg" alt="Game of Business Page 4" width="580px" height="751px"/>
							<img src="https://www.gameofbusiness.org/images/pages/gb-page6.jpg" alt="Game of Business Page 5" width="580px" height="751px"/>
							<img src="https://www.gameofbusiness.org/images/pages/gb-page7.jpg" alt="Game of Business Page 6" width="580px" height="751px"/>

						</div>
						
						<div class="preview-buy-box gob-sticky gob-row" style="z-index:1;">
							
							<div>
						
								<div class="buy-box-book-section-inner" style="display:flex;line-height: 19px;">
							
									<img alt="Game of Business" class="buy-box-book-cover" src="https://www.gameofbusiness.org/images/GB-cover.gif" style="padding:0 10px 0 0;align-self: flex-start;min-width: 20%;max-width: 25%;height: auto;max-height: 100%;"/>
								
									<div class="buy-box-book-info" style="padding:0;display:flex;flex-direction: column;max-width:385px;min-width:0;">
									
										<h2 class="gob-title" style="font-size:16px;margin:0 0 2px 0;line-height: 18px;"><strong>Game of Business</strong></h2>
									
										<h3 class="gob-sub-title" style="font-size:14px;margin:0 0 2px 0;line-height: 18px;color:#565959;">Sun Tzu Art of War Business Strategy PDF</h3>
									
										<div class="gob-author" style="font-size:12px;line-height:19px;padding:0;margin:0;">by <a class="gob-product-page-link" href="https://www.gameofbusiness.org/the-art-of-war/pdf.html#aw-origin">Sun Tzu</a></div>
									
									</div>
								
								</div>
							
							</div>
							
							<div class="buy-box-price-section">
						
								<div class="gob-row buy-box-price" style="font-size:14px;line-height:20px;">
									<div style="padding:0;margin:5px 0;"><strong>E-Book PDF:</strong><span style="display:inline-block;margin:0 0 0 10px;"><span style="display:inline-block;font-size:10px;position:relative;top:-0.9em;">$</span><span class="gob-pdf-price" style="font-size:24px;"></span><span style="font-size:10px;position:relative;top:-0.9em;">&nbsp;00</span></span></div>
								</div>
																			
								<div id="acceptUIPayDiv" >
									<button id="acceptUIPayButton"
											class="AcceptUI gob-btn gob-center gob-button-text gob-pay-button"
											style="border-radius:20px;box-shadow:0 2px 5px 0 rgb(213 217 217 / 50%);background-color:#FFA41C;border:1px solid #FF8F00;margin-bottom:12px;"
											type="button"
											data-billingAddressOptions='{"show":true, "required":true}'
											data-apiLoginID="3T6t9Q48UfGz"
											data-clientKey="26PUqPCjpfcNK4dAXqQXv3929Vdh8d7QryEuTjVnrmN4HG6tZtM3388LbVyg8CKD"
											data-acceptUIFormBtnTxt="Place Your Order, $10"
											data-acceptUIFormHeaderTxt="Game of Business E-Book PDF"
											data-paymentOptions='{"showCreditCard":true, "showBankAccount":false}'
											data-responseHandler="responseHandler"
											disabled="disabled">

										<img style="height:24px;z-index:9999;position:relative;margin:auto;vertical-align:middle" id="loader" class="gob-loader" src="https://www.gameofbusiness.org/images/Loader.gif" alt="Loading" height="24px"/>
									</button>
								</div>
								
							</div>

						</div>
						
						<div class="gob-row">
							<div class="gob-center preview-content-small">
					
								<img src="https://www.gameofbusiness.org/images/pages/gb-page1.jpg" alt="Game of Business Cover" width="580px" height="751px"/>
								<img src="https://www.gameofbusiness.org/images/pages/gb-page2.jpg" alt="Game of Business Page 1" width="580px" height="751px"/>
								<img src="https://www.gameofbusiness.org/images/pages/gb-page3.jpg" alt="Game of Business Page 2" width="580px" height="751px"/>
								<img src="https://www.gameofbusiness.org/images/pages/gb-page4.jpg" alt="Game of Business Page 3" width="580px" height="751px"/>
								<img src="https://www.gameofbusiness.org/images/pages/gb-page5.jpg" alt="Game of Business Page 4" width="580px" height="751px"/>
								<img src="https://www.gameofbusiness.org/images/pages/gb-page6.jpg" alt="Game of Business Page 5" width="580px" height="751px"/>
								<img src="https://www.gameofbusiness.org/images/pages/gb-page7.jpg" alt="Game of Business Page 6" width="580px" height="751px"/>
						
							</div>
						</div>
 
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

		<script src="https://www.gameofbusiness.org/scripts/gb-sections.js"></script>
		<script src="https://www.gameofbusiness.org/scripts/gb-display.js"></script>

	</body>
</html>
