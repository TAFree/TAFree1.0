TAFree.namespace('TAFree.page.Hash');

TAFree.page.Hash = (function () {
	
	// Private property
	// Dependencies
	var init = TAFree.page.Init,
	    addon = TAFree.page.Addon,
	    
	    content = { 
            
            	'fac_chooser': function () {
			init.polygon('fac');
			init.jumpItem();
            	},
            	
		'stu_chooser': function () {
                	init.polygon('stu');
            	},
            
            	'fac_assign': function () {
                	init.manRow();
            	},
            	
                'admin': function () {
                	init.manSepRow();
            	}, 
                
                'fac_add_del_stu': function () {
                  	init.deleteRow();
			init.manRow();
			
            	},
                
                'fill_in': function () {
                    	addon.codeLeft();
                 	init.enableZoom();
               		init.enableFillInAss();
            	},
                
                'stu_prob': function () {
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

