TAFree.namespace('TAFree.page.Addon');

TAFree.page.Addon = {
	
    codeLeft: function() {
        
        // Dependencies
        var dom = TAFree.util.Dom,
            
            content;
        
	content = dom.getTag('content');
        content.style.textAlign = 'left';
    },

    linePattern: function (code) { 
        // Dependencies
        var dom = TAFree.util.Dom,
            addon = TAFree.page.Addon,

	    content, lines, j;
        
        // Split content and make it pickable on line pattern
        content = code.innerHTML;
	code.removeChild(code.children[0]);
	code.innerHTML = '';
	lines = content.split('\n');
    	for (j = 0; j < lines.length; j += 1) {
		lines[j] = '<pre class=\'MODIFY_LINE_PRE\'>' + lines[j] + '</pre>';
		code.innerHTML += lines[j];
    	}   
    	
	// Add onclick event listener on each line
	addon.diggable('linePattern');
    
     },

    charPattern: function (code) {
        // Dependencies
        var dom = TAFree.util.Dom,
	    addon = TAFree.page.Addon,

            content, chars, j;
        
        // Split content and make it pickable on char pattern
        content = code.innerHTML;
	code.removeChild(code.children[0]);
	code.innerHTML = '';
	chars = content;
	for (j = 0; j < chars.length; j += 1) {
		code.innerHTML += '<p class=\'MODIFY_CHAR_P\'>' + chars.charAt(j) + '</p>';
    	}   
    	
	// Add onclick event listener on each char
	addon.diggable('charPattern');

    },
    
    groupPattern: function (code) {
        // Dependencies
        var dom = TAFree.util.Dom,
	    addon = TAFree.page.Addon,

            content, lines, j, groupSwitch;
        
        // Split content and make it pickable on line pattern
        content = code.innerHTML;
	code.removeChild(code.children[0]);
	code.innerHTML = '';
	lines = content.split('\n');
    	for (j = 0; j < lines.length; j += 1) {
		lines[j] = '<pre class=\'MODIFY_GROUP_PRE\' title=\'' + j + '\'>' + lines[j] + '</pre>';
		code.innerHTML += lines[j];
    	}   
    	
	// Add onclick event listener on each line
	groupSwitch = function (e) {
		var ele, numLine, groupeds, k, parentEle;
		
		// Check group state: open or close
		if (code.style.cursor.includes('close')) {
			// Collect grouped lines 
			groupeds = dom.getClass('MODIFY_GROUP_PRE');
			parentEle = groupeds[0].parentNode;
			for (k = 0; k < groupeds.length; k += 1) {
				if (groupeds[k].style.backgroundColor === 'red') {
					console.log(groupeds[k].title);
					parentEle.removeChild(groupeds[k]);
				}
			}
			// Change cursor
			code.style.cursor = 'url(\'tafree-cur/open.cur\'), auto';
			// Remove onmouseover event listener on the other lines
			addon.groupable(0, false);
			return;
		}
		else {
			// Change cursor
			code.style.cursor = 'url(\'tafree-cur/close.cur\'), auto';
			// Get line number
			ele = e.srcElement;
			numLine = ele.title;
			// Change color of current line
			ele.style.backgroundColor = 'pink';
			// Add onmouseover event listener on the other lines
			addon.groupable(numLine, true);
		}
	}
	
	addon.diggable('groupPattern', groupSwitch);

    },
    
    groupable: function (numStart, on) {
        // Dependencies
        var dom = TAFree.util.Dom,

            lines, i, groupMock, j, numLine, k;
	
	lines = dom.getClass('MODIFY_GROUP_PRE');
	
	// Compare numbers of start line and end line for grouping mock
	groupMock = function (e) {
		var ele, numEnd, min, max;
		
		// Clear color on previous grouping mock 
		for (k = 0; k < lines.length; k += 1) {
			lines[k].style.backgroundColor = 'transparent';
		}
		
		// Draw color on current grouping mock
		ele = e.srcElement;
		numStart = Number(numStart);
		numEnd = Number(ele.title);
		if (numStart > numEnd) {
			max = numStart;
			min = numEnd;
		}
		else{
			max = numEnd;
			min = numStart;
		}
		for (j = 0; j < lines.length; j += 1) {
			numLine = lines[j].title;
			if (numLine >= min && numLine <= max) {
				console.log(min+':'+ numLine+':'+ max);
				lines[j].style.backgroundColor = 'red';
			}
		}
	};
	
	// Check if lines can be grouped or not
	if (!on) {
		for (i = 0; i < lines.length; i += 1) {
        		lines[i].removeEventListener('mouseover', groupMock);
		}
		return;
	}

	for (i = 0; i < lines.length; i += 1) {
        	lines[i].addEventListener('mouseover', groupMock);
	}

    },
    
    diggable: function (pattern, callback) {
        // Dependencies
        var dom = TAFree.util.Dom,
	    data = TAFree.page.Data,

            units, i, plainClass, diggedClass, maxlength;
        
        plainClass = data.matchUnit(pattern).plain;
        diggedClass = data.matchUnit(pattern).digged;	
	maxlength = data.matchUnit(pattern).max;
	units = dom.getClass(plainClass);
	
	// Set default callback that replace unit with input
	if (typeof callback !== 'function') {
		callback = function(e){
			var ele, 
			    parentEle,
			    newEle;
 			
			newEle = document.createElement('input');
			newEle.setAttribute('type', 'text');
			newEle.setAttribute('maxlength', maxlength);
			newEle.className = diggedClass;
			ele = e.srcElement;
			parentEle = ele.parentNode;
			parentEle.replaceChild(newEle, ele);

		}
	}
	
	// Add onclick event listener on each unit
	for (i = 0; i < units.length; i += 1) {
		units[i].addEventListener('click', callback);
        }

    }
};

