/* Copyright 2003 Apis Networks
*  Please read the attached LICENSE
*  included within the distribution
*  for further restrictions.
*/
/*
 * the following functions are used
 * for the popup div on a mouseover of
 * a particular cell, feel free to modify 
 * the pop method for modify the div style
 */

var count = 0;
var hand = 0;
nav = (document.layers) ? true : false; 
ie  = (document.all) ? true : false;
if (nav) 
  skin = document.topdeck;
if (ie)
  skin = topdeck.style;
document.onmousemove = sustain;
if (nav) document.captureEvents(Event.MOUSEMOVE);

function pop(orientation,msg,header) {
	return;
	content="<table width=160 border=0 cellpadding=0 cellspacing=2 bgcolor=\"#666666\" style=\"border: 1px solid #000000;\"><tr><td>" +
	"<table width=\"100%\" border=0 cellpadding=0 cellspacing=0><tr><td class=tiny><center>" +
	header +"</center></td></tr></table><tr><td><table width=\"100%\" cellpadding=0 cellspacing=0 border=0><tr><td height=1 bgcolor=\"#666666\"><img src=\"/images/spacer.gif\" alt=\"\" height=1 width=1></td></tr></table></td></tr><tr><td><table width=\""+
	"100%\" border=0 cellpadding=2 cellspacing=0 bgcolor=\"#ffffff\"><tr><td>"
	+ msg + "</td></tr></table></td></tr></table>";
	if (nav) {
		var canvas = document.topdeck.document; 
		canvas.write(content); 
		canvas.close();
		skin.visibility = "show";
	} else {
		document.getElementById("topdeck").innerHTML = content;
		skin.visibility = "visible";
	}  
	hand = orientation;
}

function sustain(e) {
	/* 
		original
			var x = (nav) ? e.pageX : event.clientX+document.body.scrollLeft;
			var y = (nav) ? e.pageY : event.clientY+document.body.scrollTop;	
	*/
	var x = (nav) ? e.pageX : event.clientX+document.body.scrollLeft;
	var y = (nav) ? e.pageY : event.clientY+document.body.scrollTop;
	switch(hand) {
		case 0 :
			kill();
			break;
		case 1 :
			skin.left = x+10,  skin.top = y+10;
			break;
		case 2 : 
			skin.left = x-60,  skin.top = y+20;
			break;
		case 3 : 
			skin.left = x-135, skin.top = y+10;
			break;
		default: 
			skin.left = x+10,  skin.top = y+10;
			break;
	}
}

function kill() {
	if (count >= 1)
		var always = true;
	if (always == true) {
		hand = 0;
		skin.visibility = (nav) ? "hide" : "hidden";
	} else
		count++;
}

/*
 * rollon/rolloff affect the properties of moving the mouse over onto
 * the cell (changes styles, cheap hilighting effect)
 */
function rollon(a) {
	a.style.backgroundColor='#E6E6DC';
	a.style.border = '#748D4B solid 1px';
	a.style.cursor = 'default';
	a.style.color   = 'black';
}	

function rolloff(a) {
	a.style.backgroundColor='#ffffff';	
	a.style.border = '#ffffff solid 1px'; 
	a.style.color   = 'black';
}

function openwin(href, name, opt) {
	win = window.open(href,name, opt);
	win.focus();
}

/* because some customers exhibit problems */
function top(href) {
	self.parent.location = href;
}