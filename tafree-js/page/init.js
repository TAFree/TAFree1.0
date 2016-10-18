TAFree.namespace('TAFree.page.Init');

TAFree.page.Init = {
	
	frame: function () {
		
		// Dependencies
        var data = TAFree.page.Data,
		    dom = TAFree.util.Dom,

		    logo = document.createElement('img'),
		    link = document.createElement('a'),
		    text = document.createElement('p'),
		    list = document.createElement('li'),
		    unordered = document.createElement('ul'),
		    frag = document.createDocumentFragment(),
		    title, home, greeting, copyright, i, link_nav, list_nav;
		
		// Set title
		title = dom.getTag('title');
		title.innerHTML = data.getFrame('title');
		
		// Set logo and home link
		logo.src = data.getFrame('logo');
		logo.height = window.innerHeight * 0.08;
		home = link.cloneNode(true);
		home.href = data.getFrame('home');
		home.appendChild(logo);
		dom.getTag('header').appendChild(home);
		
		// Set links in navigator
		urls = data.getFrame('urls');
		for (i in urls) { 
			link_nav = link.cloneNode(true);
			link_nav.href = urls[i];
			link_nav.innerHTML = i;
			link_nav.id = 'NAV_A';
			list_nav = list.cloneNode(true);
			list_nav.appendChild(link_nav);
			unordered.appendChild(list_nav);
		}
		dom.getTag('nav').appendChild(unordered);

		// Set Copyright
		copyright = text.cloneNode(true); 
		copyright.innerHTML = data.getFrame('copyright');
		dom.getTag('footer').appendChild(copyright);
	},
    
    polygon: function () {
        
        // Dependencies
        var data = TAFree.page.Data,
            dom = TAFree.util.Dom,
            polygon = TAFree.asset.Polygon,
            
            svgs, i, poly_data, len, poly, j;
            
        svgs = dom.getClass('POLYGON_SVG');
            
        for (i = 0; i< svgs.length; i += 1) {
            
            poly_data = data.getPolygon(svgs[i].id);
            len = poly_data.getPolygon('urls').length;
            
            if (len === 1) { // Single problem
                poly = new polygon.Circle(poly_data);
                svgs[i].appendChild(poly);
            }
            else if (len === 2){ // Two problem
                poly = new polygon.Rectangle(poly_data);
                svgs[i].appendChild(poly);
            }
            else { // More than three problem
                for (j = 0; j < len; j += 1) {
                    poly = new polygon.Polygon(poly_data);
                    svgs[i].appendChild(poly);
                }
            }
                
        }
    },
    
    manRow: function () {
        // Dependencies
        var dom = TAFree.util.Dom,
            feature = TAFree.page.Feature,
            add_but;
            
        // Set add row
        add_but = dom.getId('ADD_BUTTON');
        add_but.addEventListener('click', feature.addRow);
            
    },
    
    manSepRow: function () {
        // Dependencies
        var dom = TAFree.util.Dom,
            feature = TAFree.page.Feature,
            add_prob_but, add_fac_but;
            
        // Set add row
        add_prob_but = dom.getId('ADMIN_PROB_BUTTON');
        add_prob_but.addEventListener('click', feature.addProbRow);
        add_fac_but = dom.getId('ADMIN_FAC_BUTTON');
        add_fac_but.addEventListener('click', feature.addFacRow);
            
    }
    
};

