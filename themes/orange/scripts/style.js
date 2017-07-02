/*** LASUHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for the Academic/Non Academic Staff Establishments of Lagos State University respectively . This Software has been tested on a remote server and is capable of encapsulating large information of the Lagos State University staff.
 * Copyright (C) 1983-2014 LASUHRM., http://www.lasu.edu.ng. Software Developed and re-engineered by OWOEYE OLUWATOBI MICHAEL, BSc. Computer Science.
 *
 *
 */

/* Style related JavaScript for orange theme */

/**
 * Draw a round border around div's with the given css class 
 * @param className Class Name of div's to be given a round border
 */
function roundBorder(className) {
	var innerClass = 'maincontent';
        var divContent = '';
    var elements = document.getElementsByTagName('div');
    for (i=0;i<getElementLength(elements.length);i++) {
        div = elements[i];
        if (div.className == className) {

			divContent = div.innerHTML;
			div.innerHTML = "";
			
            topdiv = document.createElement('div');
            topdiv.className = "top";
			div.appendChild(topdiv);
            topleft = document.createElement('div');
            topleft.className = "left";
            topdiv.appendChild(topleft);           
            topright = document.createElement('div');
            topright.className = "right";
            topdiv.appendChild(topright);            
            topmiddle = document.createElement('div');
            topmiddle.className = "middle";
            topdiv.appendChild(topmiddle);            			
			
			innerDiv = document.createElement('div');
			innerDiv.className = innerClass;
			innerDiv.innerHTML = divContent;			
			div.appendChild(innerDiv);
						
            bottomdiv = document.createElement('div');
            bottomdiv.className = "bottom";
            div.appendChild(bottomdiv);            
            bottomleft = document.createElement('div');
            bottomleft.className = "left";
            bottomdiv.appendChild(bottomleft);
            bottomright = document.createElement('div');
            bottomright.className = "right";
            bottomdiv.appendChild(bottomright);
            bottommiddle = document.createElement('div');
            bottommiddle.className = "middle";
            bottomdiv.appendChild(bottommiddle);                                    
        }
    }
}

/*
 * Function run when mouse moves over a button
 * Sets className of button to "className classNamehov" 
 */
function moverButton(button) {
	var btnClass = button.className;
	button.className =  btnClass + " " + btnClass + "hov"; 
}

/*
 * Function run when moves moves out of a button
 * Removes the 'hov' className added in moverButton function
 */
function moutButton(button) {
    var classes = button.className.split(" ");
    if (classes.length > 1) {
        button.className = classes[0];
    }
}

/*
 * Function will run when adding rounded borders to the template div tags
 * Reduce the nuber of div counts from 1 when browser version is IE
 */
function getElementLength(length){
    if(ieVersion()==9){
        return length-1;
    }
    return length;   
}

/*
 * Function will run when adding rounded borders to the template div tags
 * Function will return the current version of Internet Explorer in client side 
 */
function ieVersion(){
    var ua = window.navigator.userAgent;
    var msie = ua.indexOf ("MSIE ");
    if (msie > 0){
        return parseInt(ua.substring(msie+5, ua.indexOf(".", msie)));
    }
    return 0;         
}