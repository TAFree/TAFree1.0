TAFree.namespace('TAFree.util.Init');

TAFree.util.Init = {
	
    match: function (identifier) {
		
        // Dependencies
        var init = TAFree.page.Init,
	        hash = TAFree.page.Hash,
		    
            handler = function (e) {
                // Initialize frame
                init.frame();
                // Initialize content
                if (typeof hash.getContent(identifier) === 'function') {
			hash.getContent(identifier)();
		}
            };
                    
        if (document.addEventListener) { 
            window.addEventListener('load', handler, false);
        }	 
        else {
            window.onload = handler;
        }
		
	}
	
};




