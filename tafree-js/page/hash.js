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
			init.colorItem();
			init.setup();
			init.here();
            	},
            	
		'stu_chooser': function () {
                	init.polygon('stu');
			init.jumpItem();
            	},
            
            	'fac_assign': function () {
			init.manGenRow();
			init.otherJudge();
            	},
		
                'admin': function () {
                	init.manSepRow();
            	}, 
                
                'fac_add_del_stu': function () {
                  	init.deleteRow();
			init.manRow();
			
            	},
                
                'modify': function () {
			addon.codeLeft();
                 	init.enableZoom();
			init.enableModify();
			init.handout();
            	},	

                'stu_prob': function () {
                    	addon.codeLeft();
                    	init.enableZoom();
			addon.clearModify();
			init.handin();
            	},
                
		'fac_look': function () {
			addon.codeLeft();
                    	init.enableZoom();
			init.clearModify();
            	},
                
		'fac_prob': function () {
                    	init.beInUsed();
            	},
		
		'instruction': function () {	
                        addon.codeLeft();
		},

		'support': function () {	
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

