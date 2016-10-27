TAFree.namespace('TAFree.page.Hash');

TAFree.page.Hash = (function () {
	
	// Private property
	// Dependencies
	var init = TAFree.page.Init,
	    addon = TAFree.page.Addon,
	    
	    content = { 
            
            	'chooser': function () {
                	// Markup controlled via php
                	init.polygon();
            	},
            
            	'fac_assign': function () {
                	// Markup controlled via php
                	init.manRow();
            	},
            	
                'admin': function () {
                	// Markup controlled via php
                	init.manSepRow();
            	}, 
                
                'fac_add_del_stu': function () {
                	// Markup controlled via php
                  	init.deleteRow();
			init.manRow();
			
            	},
                
                'fill_in': function () {
                    	// Markup controlled via php
                    	addon.codeLeft();
                 	init.enableZoom();
               		init.enableFillInAss();
            	},
                
                'stu_prob': function () {
                   	 // Markup controlled via php
                    	addon.codeLeft();
                    	init.enableZoom();
            	}

	    },
            
	    getContent = function(arg) {
	        if (content.hasOwnProperty(arg)) {
                	return content[arg];
		}
            };

	// Reveal public API
	return {
		getContent: getContent
	};

}());

