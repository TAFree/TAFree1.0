TAFree.namespace('TAFree.page.Feature');

TAFree.page.Feature = {
	
	addRow: function () {
		
		// Dependencies
        var dom = TAFree.util.Dom,
			
            tbody, hid_row, new_row, sub_but;
            
            tbody = dom.getTag('tbody'); 
            hid_row = dom.getClassOne('HIDDEN_TR');
            new_row = hid_row.cloneNode(true);
            new_row.className = 'SHOW_TR';
            sub_but = new_row.children[0].children[0];
            sub_but.onclick = function () {
                this.parentNode.parentNode.parentNode.removeChild(this.parentNode.parentNode);
            };
            tbody.appendChild(new_row);
	},
    
	addProbRow: function (e) {
		
		// Dependencies
        var dom = TAFree.util.Dom,
			
            table, hid_row, new_row, sub_but;
            
            table = e.srcElement.parentNode.parentNode.parentNode.parentNode; 
            if (table.tagName === 'TBODY') {
		table = table.parentNode;	
	    }
	    hid_row = dom.getClassOne('HIDDEN_PROB');
            new_row = hid_row.cloneNode(true);
            new_row.className = 'ADMIN_SHOW_TR';
            sub_but = new_row.children[0].children[0];
            sub_but.onclick = function () {
                this.parentNode.parentNode.parentNode.removeChild(this.parentNode.parentNode);
            };
            table.appendChild(new_row);
	},
    
	addFacRow: function (e) {
		
		// Dependencies
        var dom = TAFree.util.Dom,
			
            table, hid_row, new_row, sub_but;
            
            table = e.srcElement.parentNode.parentNode.parentNode.parentNode; 
            if (table.tagName === 'TBODY') {
		table = table.parentNode;	
	    }
	    hid_row = dom.getClassOne('HIDDEN_FAC');
            new_row = hid_row.cloneNode(true);
            new_row.className = 'ADMIN_SHOW_TR';
            sub_but = new_row.children[0].children[0];
            sub_but.onclick = function () {
                this.parentNode.parentNode.parentNode.removeChild(this.parentNode.parentNode);
            };
            table.appendChild(new_row);
	},

	delRow: function (e) {
		
		// Dependencies
        var dom = TAFree.util.Dom,
			
            but, tr, hidden;
	    
	    but = e.srcElement;
	    if (but.tagName === 'B') {
		but = but.parentNode;	
	    }     
            tr = but.parentNode.parentNode;
	    hidden = tr.children[4].children[0];
	    hidden.setAttribute('name', 'del_account[]');
	    tr.style.display='none';
	},

	pre: function (e) {
		
		// Dependencies
        var dom = TAFree.util.Dom,
			
            but, table, len, item, i, top_tr, bot_tr;
	    
	    but = e.srcElement;
	    item = but.parentNode.children[1].id;
	    
	    table = but.parentNode.parentNode.parentNode;
	    len = table.children.length;
	    // Disappear all
	    for (i = 0; i < len; i += 2) {
	        top_tr = table.children[i];
		bot_tr = table.children[i + 1];
		top_tr.style.display = 'none';
		bot_tr.style.display = 'none';
	    }
	   // Show only one 
	   for (i = 0; i < len; i += 2) {
	        top_tr = table.children[i];
		bot_tr = table.children[i + 1];
		if (top_tr.children[1].children[1].id === item) {
			if (i - 2 > 0) {
				table.children[i - 2].style.display = 'block';
				table.children[i - 2 + 1].style.display = 'block';
				break;
			}
			else {
				i = len;
				table.children[i - 2].style.display = 'block';
				table.children[i - 2 + 1].style.display = 'block';
				break;
			}
		}
	    }
	    
	},

	next: function (e) {
		
		// Dependencies
        var dom = TAFree.util.Dom,
			
            but, table, len, item, i, top_tr, bot_tr;
	    
	    but = e.srcElement;
	    item = but.parentNode.children[1].id;
	    
	    table = but.parentNode.parentNode.parentNode;
	    len = table.children.length;
	    // Disappear all
	    for (i = 0; i < len; i += 2) {
	        top_tr = table.children[i];
		bot_tr = table.children[i + 1];
		top_tr.style.display = 'none';
		bot_tr.style.display = 'none';
	    }
	   // Show only one 
	   for (i = 0; i < len; i += 2) {
	        top_tr = table.children[i];
		bot_tr = table.children[i + 1];
		if (top_tr.children[1].children[1].id === item) {
			if (i < len - 2) {
				table.children[i + 2].style.display = 'block';
				table.children[i + 2 + 1].style.display = 'block';
				break;
			}
			else {
				i = 0;
				table.children[i].style.display = 'block';
				table.children[i + 1].style.display = 'block';
				break;
			}
		}
	    }
	    
	},

	preI: function (e) {
		
		// Dependencies
        var dom = TAFree.util.Dom,
			
            but, table, len, item, i, tr;
	    
	    but = e.srcElement;
	    item = but.parentNode.children[1].id;
	    table = but.parentNode.parentNode.parentNode;
	    len = table.children.length;
	    // Disappear all
	    for (i = 0; i < len; i += 1) {
	        tr = table.children[i];
		tr.style.display = 'none';
	    }
	   // Show only one 
	   for (i = 0; i < len; i += 1) {
	        tr = table.children[i];
		if (tr.children[0].children[1].id === item) {
			if (i > 0) {
				table.children[i - 1].style.display = 'block';
				break;
			}
			else {
				i = len;
				table.children[i - 1].style.display = 'block';
				break;
			}
		}
	    }
	    
	},

	nextI: function (e) {
		
		// Dependencies
        var dom = TAFree.util.Dom,
			
            but, table, len, item, i, tr;
	    
	    but = e.srcElement;
	    item = but.parentNode.children[1].id;
	    table = but.parentNode.parentNode.parentNode;
	    len = table.children.length;
	    // Disappear all
	    for (i = 0; i < len; i += 1) {
	        tr = table.children[i];
		tr.style.display = 'none';
	    }
	   // Show only one 
	   for (i = 0; i < len; i += 1) {
	        tr = table.children[i];
		if (tr.children[0].children[1].id === item) {
			if (i < len - 1) {
				table.children[i + 1].style.display = 'block';
				break;
			}
			else {
				i = 0;
				table.children[i].style.display = 'block';
				break;
			}
		}
	    }
	    
	},

	setup: function (e) {
		// Dependencies
        var dom = TAFree.util.Dom,
			
            but, td, showup, closeup, backup, item, xhr, i, pres_table, pres_len, pres_tr, closeup_td, present_checkbox, present_img;
            
            but = e.srcElement;
	    td = but.parentNode;
	    
	    // Get times
	    showup = td.children[0].value + ' ' + td.children[1].value + ':' + td.children[2].value + ':' + '59';
	    closeup = td.children[5].value + ' ' + td.children[6].value + ':' + td.children[7].value + ':' + '59';
	    backup = td.children[10].value + ' ' + td.children[11].value + ':' + td.children[12].value + ':' + '59';

	    // Get item
	    item = td.nextSibling.children[1].id;

	    // Check empty time field
	    if (!showup.includes('-') || !closeup.includes('-') || !backup.includes('-')) {
		confirm('Forgot to choose date...');
		return;
	    }
	    
            // Send showup & backup time to server 
	    xhr = new XMLHttpRequest();
	    xhr.onreadystatechange = function () {
		// Show faked closeup time in page when server response is ready
		if (this.readyState === 4 && this.status === 200) {
			pres_table = td.parentNode.nextSibling.children[0].children[0];
			pres_len = pres_table.children[0].children.length;
			// First row is th
			for (i = 1; i < pres_len; i += 1) {
				pres_tr = pres_table.children[0].children[i];
				closeup_td = pres_tr.children[2];
				present_checkbox = closeup_td.nextSibling.children[0];
				present_img = present_checkbox.nextSibling;
				if (closeup_td.innerHTML === '') {
					closeup_td.innerHTML = closeup;
					present_checkbox.checked = false;
					present_img.src='./tafree-svg/unknown.svg';
				}
			}
		}
	    }	
	    xhr.open('POST', 'Setup.php', true);
	    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
	    xhr.send('showup=' + showup + '&backup=' + backup + '&item=' + item);
	},

	here: function (e) {
		// Dependencies
        var dom = TAFree.util.Dom,
			
            box, td, top_tr, closeup, account, item;
            
            box = e.srcElement;
	    td = box.parentNode;
		
            // Get account
	    account = td.previousSibling.previousSibling.innerHTML;
	    // Get item
	    top_tr = td.parentNode.parentNode.parentNode.parentNode.parentNode.previousSibling;
	    item = top_tr.children[1].children[1].id;

	   		
	    if(box.checked === true) {
		// Get closeup time
		closeup = td.previousSibling.innerHTML;
	  	// Check empty time field
		if(closeup === '') {
			confirm('Should do setup first...');
			box.checked = false;
			return;
		}
		// Send someone's closeup time to server 
		xhr = new XMLHttpRequest();
		xhr.onreadystatechange = function () {
		    // Show checked image in page when server response is ready
		    td.children[1].src = './tafree-svg/right.svg';   
		}
		xhr.open('POST', 'Present.php', true);
		xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
	        xhr.send('closeup=' + closeup + '&account=' + account + '&item=' + item);  
            }	
	    else {
		// Unset closeup time
		closeup = null;
		
		// Send someone's closeup time to server 
		xhr = new XMLHttpRequest();
		xhr.onreadystatechange = function () {
		    // Show checked image in page when server response is ready
		    td.children[1].src = './tafree-svg/unknown.svg';   
		}
		xhr.open('POST', 'Present.php', true);
		xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
	        xhr.send('closeup=' + closeup + '&account=' + account + '&item=' + item);  
	    }
	},

	modify: function(e) { 
		// Dependencies
        var dom = TAFree.util.Dom,
	    addon = TAFree.page.Addon,
			
            img, press, code, modify;
            
	    // Press img effect
            img = e.srcElement;
	    img.style.backgroundColor='#D8D8D8';
	    press = setInterval(function (){
		if (img.style.backgroundColor === '#FFF6E5') {
			clearInterval(press);
		}
		else{
			img.style.backgroundColor = '#FFF6E5';
		}
	    }, 800);
	    // Change cursor
	    code = img.parentNode.parentNode.parentNode.parentNode.parentNode.parentNode.children[1];	 
	    modify = img.src;
	    modify = modify.substring(modify.lastIndexOf('/') + 1);
	    switch(modify) {
	    case 'line.svg':
		code.style.cursor='url(\'./tafree-cur/scissors.cur\'), auto';
		addon.linePattern(code);
		break;
	    case 'char.svg':
		code.style.cursor='url(\'./tafree-cur/scissors.cur\'), auto';
		addon.charPattern(code);
		break;
	    case 'group.svg':
		code.style.cursor='url(\'./tafree-cur/open.cur\'), auto';
		addon.groupPattern(code);
		break;
	    case 'scissors.svg':
		code.style.cursor='url(\'./tafree-cur/scissors.cur\'), auto';
		break;
	    case 'undo.svg':
		code.style.cursor='url(\'./tafree-cur/eraser.cur\'), auto';
		break;
	    case 'mock.svg':
		code.style.cursor='url(\'./tafree-cur/pen.cur\'), auto';
		break;
	    case 'lock.svg':
		code.innerHTML = '<div class=\'MODIFY_LOCK_DIV\'><img height=\'50\' width=\'50\' src=\'tafree-svg/lock.svg\'>We already prepared for you.</div>';
		code.style.cursor='auto';
	    	break;
	    case 'all.svg':
		code.innerHTML = '<textarea class=\'MODIFY_ALL_TEXTAREA\'></textarea>';
		code.style.cursor='auto';
	        break;
	    default:
		code.style.cursor='auto';
	    }
	}
};
