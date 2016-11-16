TAFree.namespace('TAFree.page.Process');

TAFree.page.Process = {
	
	hideData: function () {
		// Dependencies
		var dom = TAFree.util.Dom,
	
		    titles, codes, i, classname, modified_source, hidden_div;

		titles = dom.getClass('TITLE_P');
		codes = dom.getClass('CODE_DIV');
		hidden_div = dom.getClass('HIDDEN_DIV')[0];

		for (i = 0; i < titles.length; i += 1) {
			// Collect hidden input for classname
			classname = document.createElement('input');
			classname.setAttribute('type', 'hidden');
			classname.setAttribute('name', 'classname[]');
			classname.setAttribute('value', titles[i].innerHTML);
			hidden_div.appendChild(classname);

			// Collect hidden input for modified_source
			modified_source = document.createElement('input');
			modified_source.setAttribute('type', 'hidden');
			modified_source.setAttribute('name', 'modified_source[]');
			modified_source.setAttribute('value', codes[i].innerHTML);
			hidden_div.appendChild(modified_source);

		}
	
	}

};
