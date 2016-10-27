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

    deleteRow: function () {
	// Dependencies
	var dom = TAFree.util.Dom,
	    feature = TAFree.page.Feature,
	    del_buts, i;
	// Set delete row
	del_buts = dom.getClass('SUB_ADD_DEL_BUTTON');
	for (i = 0; i < del_buts.length; i += 1) {
		del_buts[i].addEventListener('click', feature.delRow);
	}
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
            
    },
    
    enableZoom: function () {
        // Dependencies
        var dom = TAFree.util.Dom,
            data = TAFree.page.Data,
            
            zooms, zooms_len, i, block, code, j, blocks, blocks_len;
            
        zooms = dom.getClass('ZOOM_IMG');
        zooms_len = zooms.length;
        for (i = 0; i < zooms_len; i += 1) {
            zooms[i].src = data.getZoom('in');
            zooms[i].onclick = function() {
                block = this.parentNode.parentNode;
                code = block.children[1];
                if (this.src.toString().includes('in')) { 
                    blocks = dom.getClass('BLOCK_DIV');
                    blocks_len = blocks.length;
                    for (j = 0; j < blocks_len; j += 1) {
                        blocks[j].style.display = 'none';
                    }
                    block.style.display = 'block';
                    this.src = data.getZoom('out');
                    block.style.width='90vw';
                    block.style.height='90vh';
                    code.style.fontSize='30px';
                }
                else {
                    blocks = dom.getClass('BLOCK_DIV');
                    blocks_len = blocks.length;
                    for (j = 0; j < blocks_len; j += 1) {
                        blocks[j].style.display = 'block';
                    }
                    this.src = data.getZoom('in');
                    block.style.width='350px';
                    block.style.height='270px';
                    code.style.fontSize='16px';
                }
            }
        }

    },
    
    enableFillInAss: function (){ 
        // Dependencies
        var dom = TAFree.util.Dom,
            codes, code, i, lines, j, text, br;
        
        // Split code and make it pickable for fill-in assignment
        codes=dom.getClass('CODE_DIV');
        for (i = 0; i < codes.length; i += 1) {
            code = codes[i].children[0].innerHTML;
            codes[i].removeChild(codes[i].children[0]);
            lines = code.split('\n');
            for (j = 0; j < lines.length; j += 1) {
                text = document.createElement('text');
                text.className = 'PICKABLE';
                text.innerHTML = lines[j];
                text.onclick = function (e) {
                    TAFree.page.Init.cutout(e.srcElement);
                };
                codes[i].appendChild(text);
                br = document.createElement('br');
                codes[i].appendChild(br);
            }
        }
    },

    cutout: function (tag) { 
        if (tag.getAttribute('class') == 'PICKABLE') {
            tag.className='CUTOUT';
        }
        else if (tag.getAttribute('class') == 'CUTOUT') {
            tag.className='PICKABLE';
        }
    }
    
};

