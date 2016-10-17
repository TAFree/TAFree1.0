TAFree.namespace('TAFree.page.Data');

TAFree.page.Data = (function () {
	
	// Private property
	// Dependencies
	var dom = TAFree.util.Dom,
		
	    frame = { 
	    	
	    title: 'Here is title',            

	    logo: './tafree-svg/logo.svg',

            home: 'www.google.com',

            urls: {
                About: 'www.google.com',
                Hack: 'www.google.com',
                Login: 'www.google.com',
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
        
        polygons = [
            
            {
            
                name: 'Lab01',
            
                urls: [
                    'http://www.google.com'
                ],
                
                getPolygon: function(arg) {
                    if (this.hasOwnProperty(arg)) {
                        return this[arg];
                    }
                }
            },
            
            {
            
                name: 'Lab02',
            
                urls: [
                    'http://www.google.com',
                    'http://www.google.com'
                ],
                
                getPolygon: function(arg) {
                    if (this.hasOwnProperty(arg)) {
                        return this[arg];
                    }
                }
            },
            
            {
            
                name: 'Quiz01',
            
                urls: [
                    'http://www.google.com',
                    'http://www.google.com',
                    'http://www.google.com'
                ],
                
                getPolygon: function(arg) {
                    if (this.hasOwnProperty(arg)) {
                        return this[arg];
                    }
                }
            },
            
            {
            
                name: 'Final',
            
                urls: [
                    'http://www.google.com',
                    'http://www.google.com',
                    'http://www.google.com',
                    'http://www.google.com',
                    'http://www.google.com',
                    'http://www.google.com'
                ],
                
                getPolygon: function(arg) {
                    if (this.hasOwnProperty(arg)) {
                        return this[arg];
                    }
                }
            }
            
        ],
        
        getPolygon = function(arg) {
            var i;
            for (i = 0; i < polygons.length; i += 1) {
                if (arg.toLowerCase() === polygons[i].name.toLowerCase()) {
                        return polygons[i];
                }
            }
        };

	// Reveal public API
	return {

		getFrame: getFrame,

		getStu_leave: getStu_leave,

		getFac_leave: getFac_leave,
        
        getPolygon: getPolygon
	};

}());

