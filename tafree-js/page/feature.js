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
			
            but, table, len, item, i, top_tr, bot_tr, svg;
	    
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
			
            but, table, len, item, i, top_tr, bot_tr, svg;
	    
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
	    
	}

};
