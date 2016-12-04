TAFree.namespace('TAFree.page.Addon');

TAFree.page.Addon = {
	
    codeLeft: function() {
      
        // Dependencies
        var dom = TAFree.util.Dom,
            
            content;
        
	content = dom.getTag('content');
        content.style.textAlign = 'left';
	content.style.padding = '2vw';
    },

    diggable: function (e) {

        // Dependencies
        var addon = TAFree.page.Addon,

	pattern, ele, parentEle, newEle;

	pattern = addon.pattern;
	ele = e.srcElement;

	switch (pattern) {
	case 'linePattern':
		newEle = document.createElement('input');
		newEle.setAttribute('type', 'text');
		newEle.className = 'MODIFY_LINE_INPUT';
		parentEle = ele.parentNode;
		parentEle.replaceChild(newEle, ele);
		return;
	case 'blockPattern':	
		newEle = document.createElement('textarea');
		newEle.className = 'MODIFY_BLOCK_TEXTAREA';
		parentEle = ele.parentNode;
		parentEle.replaceChild(newEle, ele);
		return;	
	case 'removePattern':
		parentEle = ele.parentNode;
		parentEle.removeChild(ele);
		return;
	default:
		return;
	}

    },
   
    pattern: null,
	    
    clearModify: function() {

	var dom = TAFree.util.Dom,

	    lines, i, content, new_line, code_block;

	    code_blocks = dom.getClass('WRITE_DIV');
	    
	    for (i = 0; i < code_blocks.length; i += 1) {
		lines = code_blocks[i].children;
		for (j = 0; j < code_blocks[i].children.length; j += 1) {
			if (lines[j].className === 'MODIFY_LINE_PRE') {
				content = lines[j].innerHTML;
				new_line = document.createElement('pre');
				new_line.innerHTML = content;
				new_line.className = 'LOOK_LINE_PRE';
				code_blocks[i].replaceChild(new_line, lines[j]);
			}
		}
	    }
		
    }
};

