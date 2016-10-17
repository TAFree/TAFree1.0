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

