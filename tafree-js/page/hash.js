TAFree.namespace('TAFree.page.Hash');

TAFree.page.Hash = (function () {
	
	// Private property
	// Dependencies
	var init = TAFree.page.Init,
	    addon = TAFree.page.Addon,
	    process = TAFree.page.Process,
	    
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

                'sourcewatch': function () {
                    	addon.codeLeft();
		},

		'fac_look': function () {
			addon.codeLeft();
                    	init.enableZoom();
			addon.clearModify();
            	},
                
		'fac_prob': function () {
                    	init.beInUsed();
            	},
		
		'fac_coders': function () {
			process.countStatus();
		},
		
		'instruction': function () {	
                        addon.codeLeft();
		},

		'support': function () {	
                        addon.codeLeft();
		},
		
		'discussion': function () {	
			addon.codeLeft();
			init.talk();
                        init.pullMsg();
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

