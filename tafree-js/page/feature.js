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
            hid_row = dom.getClassOne('HIDDEN_PROB');
            new_row = hid_row.cloneNode(true);
            new_row.className = 'SHOW_TR';
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
            hid_row = dom.getClassOne('HIDDEN_FAC');
            new_row = hid_row.cloneNode(true);
            new_row.className = 'ADDMIN_SHOW_TR';
            sub_but = new_row.children[0].children[0];
            sub_but.onclick = function () {
                this.parentNode.parentNode.parentNode.removeChild(this.parentNode.parentNode);
            };
            table.appendChild(new_row);
	}

};
