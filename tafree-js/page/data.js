TAFree.namespace('TAFree.page.Data');

TAFree.page.Data = (function () {
	
	// Private property
	// Dependencies
	var dom = TAFree.util.Dom,
		
	    frame = { 
	    	
	    	title: 'TAFree Online Judge',            

	    	logo: './tafree-svg/logo.svg',

           	home: './Login.php',

            	urls: {
                	About: './About.php',
			Home: './Login.php',
			Instruction: './Instruction.php',
			Support: './Support.php',
			Discussion: './Discussion.php'
            	},
		
            	copyright: '&copy;2016 TAFree'
	    },

	    getFrame = function(arg) {
	        if (frame.hasOwnProperty(arg)) {
                	return frame[arg];
            	}
	    },

	    stu_leave = {
	    	
            	ele: dom.getId('STU_LEAVE'),
		
	    	check: true

	    },

	    getStu_leave = function(arg) {
	        if (stu_leave.hasOwnProperty(arg)) {
                	return stu_leave[arg];
            	}
	    },
	    
	    fac_leave = {
	    	
            	ele: dom.getId('FAC_LEAVE'),
		
	    	check: true

	    },

	    getFac_leave = function(arg) {
	        if (fac_leave.hasOwnProperty(arg)) {
                    	return fac_leave[arg];
                }
            },

	    zoom = {
	    	
            	in: './tafree-svg/zoom-in.svg',
            
	    	'out': './tafree-svg/zoom-out.svg'
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

		getStu_leave: getStu_leave,

		getFac_leave: getFac_leave,
        
	        getZoom: getZoom,
		
		storeSource: storeSource,
		
		getSource: getSource,

		getStatus_codes
	};

}());

