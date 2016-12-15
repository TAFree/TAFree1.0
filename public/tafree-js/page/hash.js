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
                 	init.enableZoom();
			init.enableModify();
			init.handout();
            	},	

                'stu_problem': function () {
                    	init.enableZoom();
			init.fetchBlur();
			addon.clearModify();
			init.handin();
            	},
		
		'result': function () {
			init.switchLayer();
		},

		'fac_display': function () {
                    	init.enableZoom();
			init.fetchBlur();
			addon.clearModify();
            	},
		
		'fac_coders': function () {
			process.countStatus();
		},
		
		'pending': function () {
			init.pollStatus();
			init.pending();
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

