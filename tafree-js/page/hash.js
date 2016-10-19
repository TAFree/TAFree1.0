TAFree.namespace('TAFree.page.Hash');

TAFree.page.Hash = (function () {
	
	// Private property
	// Dependencies
	var init = TAFree.page.Init,
	    addon = TAFree.page.Addon,
	    
	    content = { 
			
	    	'debug': function (){
        		// Markup controlled via php
           	},

            	'login': function (){
                	// Markup controlled via php
            	},

            	'about': function (){
                	// Markup controlled via php
            	},
            
            	'keep': function (){
                	// Markup controlled via php
            	},

            	'fac_index': function (){
                	// Markup controlled via php
            	},
            
            	'stu_index': function () {
                	// Markup controlled via php
                	addon.warnStu();
            	},
 
            	'fac_stu': function () {
                	// Markup controlled via php
                	addon.warnFac();
            	},
            
                'fac_prob': function () {
                	// Markup controlled via php
            	},
            
            	'stu_lab': function () {
                	// Markup controlled via php
                	init.polygon();
            	},
            
            	'stu_exam': function () {
                	// Markup controlled via php
                	init.polygon();
            	},
            
            	'fac_prob_assign': function () {
                	// Markup controlled via php
                	init.polygon();
            	},
            
            	'fac_prob_mark': function () {
                	// Markup controlled via php
                	init.polygon();
            	},
	    
            	'fac_prob_keygen': function () {
                	// Markup controlled via php
                	init.polygon();
            	},
                
            	'ass': function () {
                	// Markup controlled via php
                	init.manRow();
            	},
            	
                'admin': function () {
                	// Markup controlled via php
                	init.manSepRow();
            	},
                
                'fac_leave': function () {
                	// Markup controlled via php
            	},
                
                'stu_leave': function () {
                	// Markup controlled via php
            	},
                
                'mark': function () {
                	// Markup controlled via php
            	},
                
                'add_del_stu': function () {
                	// Markup controlled via php
                    init.manRow();
            	},
                
                'all': function () {
                	// Markup controlled via php
            	},
                
                'fac_score': function () {
                	// Markup controlled via php
            	},
                
                'stu_score': function () {
                	// Markup controlled via php
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
            	},

                'stu_res': function () {
                	// Markup controlled via php
            	},
                
                'keygen': function () {
                	// Markup controlled via php
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

