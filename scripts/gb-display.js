// switch between and opened and closed dropdown menu
function gob_open(element_id)
{
	var section_element = document.getElementById(element_id);

	//var log_msg = "section_element = " + section_element;
	//console.log(log_msg);

	if (section_element.style.display === 'none')
	{
		section_element.style.display = 'block';
		//console.log("Element Hidden: Show Element");
	}
	else
	{
		section_element.style.display = 'none';
		//console.log("Element Shown: Hide Element");
	}
}

function gob_open_menu(element_id, container)
{
	container.classList.toggle("change");
	
	var section_element = document.getElementById(element_id);

	//var log_msg = "section_element = " + section_element;
	//console.log(log_msg);

	if (section_element.style.display === 'none')
	{
		section_element.style.display = 'block';
		//console.log("Element Hidden: Show Element");
	}
	else
	{
		section_element.style.display = 'none';
		//console.log("Element Shown: Hide Element");
	}
}

// close dropdown menu
function gob_close(element_id)
{
	document.getElementById(element_id).style.display = "none";
}

// switch between and opened and closed dropdown menus
function gob_open_class(element_class)
{
	console.log("======Open Class======");
	var all_elements_in_class = document.getElementsByClassName(element_class);

	//var log = "Number of Elements in Class = " + all_elements_in_class.length.toString();
	//console.log(log);

	for (var i=0, len=all_elements_in_class.length|0; i<len; i=i+1|0)
	{
		//log = "Current Element ID = " + all_elements_in_class[i].id;
		//console.log(log);

		if (all_elements_in_class[i].style.display === 'none')
		{
			//console.log("Element Hidden: Show Element");
			all_elements_in_class[i].style.display = 'block';
		}
		else
		{
			//console.log("Element Shown: Hide Element");
			all_elements_in_class[i].style.display = 'none';
		}
	}

	if (element_class == 'gob-more-principles' )
	{
		var x = document.getElementById("more-less-principles");

		toggle_more_less(x);
	}
	else if (element_class == 'gob-more-strategies' )
	{
		var x = document.getElementById("more-less-strategies");

		toggle_more_less(x);
	}
}
function toggle_more_less(element)
{
	if (element.innerHTML == 'Show')
	{
		element.innerHTML = "Hide";
	}
	else
	{
		element.innerHTML = "Show";
	}
}

function gob_close_class(element_class)
{
	var all_elements_in_class = document.getElementsByClassName(element_class);

	for (var i=0, len=all_elements_in_class.length|0; i<len; i=i+1|0)
	{
		all_elements_in_class[i].style.display = "none";
	}
}

function gob_show_section(element_id)
{
	var x = document.getElementById(element_id);
	if (x.style.display === 'none')
	{
		x.style.display = 'block';
	}

	navigate_to_section(element_id);
}

function gob_show_sections(element_class, offset = 0)
{
	var all_elements_in_class = document.getElementsByClassName(element_class);
	for (var i=0, len=all_elements_in_class.length|0; i<len; i=i+1|0)
	{
		if (all_elements_in_class[i].style.display === 'none')
		{
			all_elements_in_class[i].style.display = 'block';
		}
	}

	if(offset)
	{
		all_elements_in_class[0].setAttribute("id", element_class)

		navigate_to_section(all_elements_in_class[0].id);
	}
	else
	{
		all_elements_in_class[0].parentNode.setAttribute("id", element_class)

		navigate_to_section(all_elements_in_class[0].parentNode.id);	
	}

	set_dropdown_status(element_class, "open");
}

function navigate_to_section(element_id)
{
	var element = document.createElement('a');
	var ref_element = "#" + element_id.toString();
	element.setAttribute('href', ref_element);
	element.style.display = 'none';
	document.body.appendChild(element);
	element.click();
	document.body.removeChild(element);
}

function show_contact_modal()
{
	var contact_msg = "Call (302) 336-8232 or email suntzu@gameofbusiness.org if you have questions about the book, game, company, or other related topics.";

	$('#contactBody').html(contact_msg);

	$('#contact-modal').modal('show');
}

function gob_open_dropdown(section_class)
{
	gob_open_class(section_class);

	set_dropdown_status(section_class, "switch");
}

function set_dropdown_status(element_class, status_cmd)
{
	console.log("======Set Dropdown Status======");

	var caret_elements = get_caret_elements(element_class);

	if (status_cmd == "switch")
	{
		switch_dropdown_status(caret_elements);
	}
	else if (status_cmd == "open")
	{
		open_dropdown_status(caret_elements);
	}
}

function get_caret_elements(section_class)
{
	console.log("======Get Caret Elements======");
	var all_elements_in_class = document.getElementsByClassName(section_class);

	//var toggler_div = all_elements_in_class[0].previousSibling.previousSibling;
	var toggler_div = all_elements_in_class[0].parentNode.getElementsByClassName('gob-displayer')[0];
	var log_msg = "First El 2xPrev Sib ID = " + toggler_div.id;
	console.log(log_msg);

	var toggler_element = toggler_div.getElementsByTagName("A")[0];
	log_msg = "Toggler Element ID = " + toggler_element.id;
	console.log(log_msg);

	var icon_elements = toggler_element.getElementsByTagName('svg');
	log_msg = "Num Icon Elements = " + icon_elements.length;
	console.log(log_msg);
	for(var i=0; i<icon_elements.length; i++)
	{
		log_msg = "Icon Element ID = " + icon_elements[i].id;
		console.log(log_msg);
	}

	var caret_down_element = icon_elements[0];
	var caret_up_element = icon_elements[1];

	var log_msg = "Caret Down Element ID = " + caret_down_element.id;
	console.log(log_msg);
	log_msg = "Caret Up Element ID = " + caret_up_element.id;
	console.log(log_msg);
	log_msg = "Num Child Elements = " + toggler_element.childNodes.length;
	console.log(log_msg);

	return [ caret_down_element, caret_up_element ];
}

function switch_dropdown_status(status_elements)
{
	console.log("======Switch Dropdown Status======");
	// if status element is a caret that switches up/down
	var caret_down_element = status_elements[0];
	var caret_up_element = status_elements[1];

	if (caret_down_element.style.display === 'none')
	{
		caret_down_element.style.display = 'inline';
		caret_up_element.style.display = 'none';
	}
	else
	{
		caret_down_element.style.display = 'none';
		caret_up_element.style.display = 'inline';
	}
}

function open_dropdown_status(status_elements)
{
	// if status element is a caret that switches up/down
	var caret_down_element = status_elements[0];
	var caret_up_element = status_elements[1];

	if (caret_up_element.style.display === 'none')
	{
		caret_up_element.style.display = 'inline';
		caret_down_element.style.display = 'none';
	}
}



//======Deprecated======
function gobOpen()
{
	var x = document.getElementById("myAccordion");
	if (x.style.display === 'none')
	{
		x.style.display = 'block';
	}
	else
	{
		x.style.display = 'none';
	}
}
function gobClose()
{
	document.getElementById("myAccordion").style.display = "none";
}

function showContactModal()
{
	var contactMsg = "Call (302) 336-8232 or email suntzu@gameofbusiness.org if you have questions about the book, game, company, or other related topics.";

	$('#contactBody').html(contactMsg);

	$('#contact-modal').modal('show');
}
