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

	refactorData: function (e) {
		// Dependencies
		var dom = TAFree.util.Dom,
		    process = TAFree.util.Process,
	
		    titles, code_blocks, i, classname, lines, j, item, subitem, obj, xhr, stu_account, pkg;

		item = dom.getNameOne('item').value;
		subitem = dom.getNameOne('subitem').value;
		stu_account = dom.getNameOne('stu_account').value;
		titles = dom.getClass('TITLE_P');
		code_blocks = dom.getClass('WRITE_DIV');

		// Configure object 
		obj = {
			'item': item,
			'subitem': subitem,
			'stu_account': stu_account,
			'stu_source': []
		}

		for (i = 0; i < titles.length; i += 1) {
			
			pkg = {};
		
			// Add classname
			classname = titles[i].innerHTML;
			pkg.classname = classname;
			
			// Package source 
			if (code_blocks[i].children[0].tagName === 'DIV') { // blur_source or lock_source
				pkg.source = 'Locked';
			} 
			else {
				// Refactor look_source into array 
				container = [];
				lines = code_blocks[i].children;
				for (j = 0; j < lines.length; j += 1) {	
					switch (lines[j].tagName) {
						case 'TEXTAREA':
							container.push(lines[j].value);	
							break;
						case 'INPUT':
							container.push(lines[j].value);	
							break;
						case 'BR':
							break;
						default:
							break;
					}
				}
				pkg.source = container;
			}
			
			obj.stu_source.push(pkg);
		}

		// Send to server
    		xhr = new XMLHttpRequest;
		xhr.onreadystatechange = function () {
			if (this.readyState === 4 && this.status === 200) {
				if (this.response) {
					window.location = '../controllers/JudgeAdapter.php';
				}
			}
	    	};	
		xhr.open('POST', '../controllers/Handin.php');
		xhr.setRequestHeader('Content-Type', 'application/json; charset=UTF-8');
		xhr.send(JSON.stringify(obj)); 
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
