TAFree.namespace('TAFree.page.Hash');

TAFree.page.Hash = (function () {
	
	// Private property
	// Dependencies
	var init = TAFree.page.Init,
	    feature = TAFree.page.Feature,
	    addon = TAFree.page.Addon,
	    process = TAFree.page.Process,
	    
	    content = { 
            
            	'fac_problems': function () {
			init.polygon('fac');
			init.jumpThree();
			init.colorItem();
			init.setup();
			init.here();
            	},
            	
		'stu_problems': function () {
                	init.polygon('stu');
			init.jumpItem();
            	},
            
            	'fac_assign': function () {
			feature.beInUsed();
			init.manGenRow();
			init.otherJudge();
            	},
		
                'admin': function () {
                	init.manSepRow();
            	}, 
                
                'fac_students': function () {
                  	init.deleteRow();
			init.manRow();			
            	},
                
                'modify': function () {
			addon.codeLeft();
                 	init.enableZoom();
			init.enableModify();
			init.handout();
            	},	

                'stu_problem': function () {
                    	addon.codeLeft();
                    	init.enableZoom();
			addon.clearModify();
			init.handin();
            	},
		
		'result': function () {
			addon.codeLeft();
			init.switchLayer();
		},

                'sourcewatch': function () {
                    	addon.codeLeft();
		},

		'fac_display': function () {
			addon.codeLeft();
                    	init.enableZoom();
			addon.clearModify();
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
		},
		
		'about': function () {
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

