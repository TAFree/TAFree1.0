TAFree.namespace('TAFree.page.Process');

TAFree.page.Process = {
	
	hideData: function () {
		// Dependencies
		var dom = TAFree.util.Dom,
		    process = TAFree.util.Process,
	
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
		
	},

	refactorData: function () {
		// Dependencies
		var dom = TAFree.util.Dom,
		    process = TAFree.util.Process,
	
		    titles, code_blocks, i, classname, stu_source, pure_source, hidden_div, lines, j;

		titles = dom.getClass('TITLE_P');
		code_blocks = dom.getClass('WRITE_DIV');
		hidden_div = dom.getClass('HIDDEN_DIV')[0];
		pure_source += '';

		for (i = 0; i < titles.length; i += 1) {
			// Collect hidden input for classname
			classname = document.createElement('input');
			classname.setAttribute('type', 'hidden');
			classname.setAttribute('name', 'classname[]');
			classname.setAttribute('value', titles[i].innerHTML);
			hidden_div.appendChild(classname);

			// Refactor look_source into pure_source 
			lines = code_blocks.children;
			for (j = 0; j < lines.length; j += 1) {	
				if (lines[j].tagName === 'TEXTAREA' || lines[j].tagName === 'INPUT') {
					pure_source += lines[j].value;	
				}
				else {
					pure_source += lines[j].innerHTML;
				}
			}
			stu_source = document.createElement('input');
			stu_source.setAttribute('type', 'hidden');
			stu_source.setAttribute('name', 'stu_source[]');
			stu_source.setAttribute('value', pure_source);
			hidden_div.appendChild(stu_source);

		}
		
	},

	countStatus: function () {
		// Dependencies
		var dom = TAFree.util.Dom,
		    data = TAFree.page.Data,

		    statuss, category, map, i, status_table, sum, per;
		
		category = data.getStatus_codes();

		map = {};

		for (i = 0; i < category.length; i += 1) {
			map[category[i]] = 0;
		}

		statuss = dom.getClass('STATUS_CODE_P');
		
		sum = 0;
		
		for (i = 0; i < statuss.length; i += 1) {
			map[statuss[i].innerHTML] += 1;
			sum += 1;
		}

		status_table = dom.getId('STATUS_TABLE');

		for (i = 0; i < category.length; i += 1) {
			per = (map[category[i]] / sum) * 100;
			per = per.toFixed(2);
			status_table.innerHTML += '<tr><td class=\'CONTENT_TD\'>' + category[i] + '</td><td class=\'CONTENT_TD\'>' + per + '</td></tr>';			
		}
	}
};
