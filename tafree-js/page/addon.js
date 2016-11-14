TAFree.namespace('TAFree.page.Addon');

TAFree.page.Addon = {
	
    codeLeft: function() {
        
        // Dependencies
        var dom = TAFree.util.Dom,
            
            content;
        
	content = dom.getTag('content');
        content.style.textAlign = 'left';
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
   
    pattern: null
    
};

