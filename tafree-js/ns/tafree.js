var TAFree = TAFree || {};

TAFree.namespace = function (ns_string) {
	
	var parts = ns_string.split('.'),
	    father = TAFree,
	    i;
	
	if (parts[0] === 'TAFree') {
		parts = parts.slice(1);
	}
	
	for (i = 0; i < parts.length; i += 1) {
		// Create property if it doesn't exist
		if (typeof father[parts[i]] === 'undefined') {
			father[parts[i]] = {};
		}
		father = father[parts[i]];
	}
	
	return father;

}

TAFree.require = function (file, callback) {
    
    var scripts = document.scripts,
        i = scripts.length, fst_js, new_js;
    
    fst_js = scripts[0];
    
    // Check if file existed
    while (i--) {
        if (scripts[i] === file) {
            return;
        }
    }
    
    // Create file as new script
    new_js = document.createElement('script');
    
    // Trigger callback when new script is loaded
    new_js.onload = function () {
        if (typeof callback !== 'undefined') {
            callback();
        }
    };
        
    new_js.src = file;
        
    fst_js.parentNode.insertBefore(new_js, fst_js);
        
};



