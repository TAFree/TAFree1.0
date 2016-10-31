TAFree.namespace('TAFree.page.Addon');

TAFree.page.Addon = {
	
    codeLeft: function() {
        
        // Dependencies
        var dom = TAFree.util.Dom,
            
            content;
        
	content = dom.getTag('content');
        content.style.textAlign = 'left';
    }

};

