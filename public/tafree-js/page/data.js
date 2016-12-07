TAFree.namespace('TAFree.page.Data');

TAFree.page.Data = (function () {
	
	// Private property
	// Dependencies
	var dom = TAFree.util.Dom,
		
	    frame = {         

	    	logo: '../public/tafree-svg/logo.svg',

            	urls: {
                	About: '../views/About.php',
			Instruction: '../views/Instruction.php',
			Support: '../views/Support.php',
			Discussion: '../views/Discussion.php'
            	},

		home: '../views/Login.php',

            	copyright: '&copy;2016 TAFree'
	    },

	    getFrame = function(arg) {
	        if (frame.hasOwnProperty(arg)) {
                	return frame[arg];
            	}
	    },

	    stu_mail = {
	    	
            	ele: dom.getId('STU_MAIL'),
		
	    	check: true

	    },

	    getStu_leave = function(arg) {
	        if (stu_leave.hasOwnProperty(arg)) {
                	return stu_mail[arg];
            	}
	    },
	    
	    fac_mail = {
	    	
            	ele: dom.getId('FAC_MAIL'),
		
	    	check: true

	    },

	    getFac_mail = function(arg) {
	        if (fac_mail.hasOwnProperty(arg)) {
                    	return fac_mail[arg];
                }
            },

	    zoom = {
	    	
            	in: '../public/tafree-svg/zoom-in.svg',
            
	    	'out': '../public/tafree-svg/zoom-out.svg'
	    },

	    getZoom = function(arg) {
	        if (zoom.hasOwnProperty(arg)) {
                	return zoom[arg];
            	}
            },
	    
	    source = {
		
	    },

	    storeSource = function(title, code) {
		source[title] = code;
	    },

	    getSource = function(title) {
		return source[title];
	    },

 	    status_code = [
		'AC',
		'NA',
		'WA', 
		'TLE',
		'MLE',
		'OLE',
		'RE',
		'RF',
		'CE',
		'SE'
	    ],
			
 	    getStatus_codes = function() {
		return status_code;
	    };
	    

	// Reveal public API
	return {

		getFrame: getFrame,

		getStu_mail: getStu_mail,

		getFac_mail: getFac_mail,
        
	        getZoom: getZoom,
		
		storeSource: storeSource,
		
		getSource: getSource,

		getStatus_codes
	};

}());

