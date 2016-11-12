TAFree.namespace('TAFree.page.Hash');

TAFree.page.Hash = (function () {
	
	// Private property
	// Dependencies
	var init = TAFree.page.Init,
	    addon = TAFree.page.Addon,
	    
	    content = { 
            
            	'fac_chooser': function () {
			init.polygon('fac');
			init.jumpThree();
			init.setup();
			init.here();
            	},
            	
		'stu_chooser': function () {
                	init.polygon('stu');
			init.jumpItem();
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
                
                'fac_modify': function () {
                    	addon.codeLeft();
                 	init.enableZoom();
               		//init.enableFillInAss();
			init.enableModify();
            	},
                
                'stu_prob': function () {
                    	addon.codeLeft();
                    	init.enableZoom();
            	},
		
		'instruction': function () {	
                        addon.codeLeft();
		},

		'language': function () {	
                        addon.codeLeft();
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

