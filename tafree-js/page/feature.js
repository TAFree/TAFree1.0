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
	}

};
