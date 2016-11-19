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
    
    polygon: function (who) {
        
        // Dependencies
        var data = TAFree.page.Data,
            dom = TAFree.util.Dom,
            polygon = TAFree.asset.Polygon,
            
            svgs, i, poly_data, nums, k, poly, j, fir;
            
        // Capitalize who
	who = who.toLowerCase();
	fir = who.substring(0, 1).toUpperCase();
	who = fir + who.substring(1, who.length);
	
	svgs = dom.getClass('POLYGON_SVG');
        nums = dom.getClass('NUMBER_SUBITEM_HIDDEN');
        
	for (i = 0; i< svgs.length; i += 1) {
            
            poly_data = {
            
                name: svgs[i].id,
                
                getPolygon: function(arg) {
                    if (this.hasOwnProperty(arg)) {
                        return this[arg];
                    }
                }
            };

	    poly_data.urls = [];
	    for (k = 1; k <= nums[i].value; k += 1) {
		poly_data.urls.push('./' + who + '_prob.php?item=' + svgs[i].id + '&subitem=' + k);
	    }
            
	    if (nums[i].value === '1') { // Single problem
		poly = new polygon.Circle(poly_data);
                svgs[i].appendChild(poly);
            }
            else if (nums[i].value === '2'){ // Two problem
                poly = new polygon.Rectangle(poly_data);
                svgs[i].appendChild(poly);
            }
            else { // More than three problem
                for (j = 0; j < nums[i].value; j += 1) {
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
    
    manGenRow: function () {
        // Dependencies
        var dom = TAFree.util.Dom,
            feature = TAFree.page.Feature,
            add_buts, del_buts, i;
            
        // Set add row
        add_buts = dom.getClass('ADD_BUTTON');
        for (i = 0; i < add_buts.length; i += 1) {
		add_buts[i].addEventListener('click', feature.addGenRow);
	}
    },
    
    enableZoom: function () {
        // Dependencies
        var dom = TAFree.util.Dom,
            data = TAFree.page.Data,
            
            zooms, zooms_len, i, block, j, blocks, blocks_len, k, sub_blocks, sub_blocks_len, imgs, imgs_len, l;
            
        zooms = dom.getClass('ZOOM_IMG');
        zooms_len = zooms.length;
        for (i = 0; i < zooms_len; i += 1) {
            zooms[i].src = data.getZoom('in');
            zooms[i].onclick = function() {
                block = this.parentNode.parentNode;
                if (this.src.toString().includes('in')) { 
		    // Enlarge all modify button images 
		    imgs = dom.getClass('MODIFY_BUTTON_IMG');
		    imgs_len = imgs.length;
		    for(l = 0; l < imgs_len; l += 1) {
			imgs[l].style.height = '4vh';
			imgs[l].style.width = '4vh';
		    }
		    // Hide other blocks
		    blocks = dom.getClass('BLOCK_DIV');
                    blocks_len = blocks.length;
                    for (j = 0; j < blocks_len; j += 1) {
                        blocks[j].style.display = 'none';
                    }
                    block.style.display = 'block';
                    // Change zoom image into zoom-out.svg
		    this.src = data.getZoom('out');
		    this.style.height = '4vh';
		    this.style.width = '4vh';
		    // Enlarge current block
                    block.style.width='80vw';
                    block.style.height='80vh';
		    // Enlarge font size
		    sub_blocks = block.children;
		    sub_blocks_len = sub_blocks.length;
		    for(k = 0; k < sub_blocks_len; k += 1) {
			if(sub_blocks[k].className === 'TITLE_DIV') {
				sub_blocks[k].style.fontSize = '5vh';
			}
			else {
				sub_blocks[k].style.fontSize = '3vh';
			}
		    }	            	
                }
                else {
		    // Shrink all modify button images 
		    imgs = dom.getClass('MODIFY_BUTTON_IMG');
		    imgs_len = imgs.length;
		    for(l = 0; l < imgs_len; l += 1) {
			imgs[l].style.height = '14px';
			imgs[l].style.width = '14px';
		    }
                    // Show all blocks
                    blocks = dom.getClass('BLOCK_DIV');
                    blocks_len = blocks.length;
                    for (j = 0; j < blocks_len; j += 1) {
                        blocks[j].style.display = 'block';
                    }
                    // Change zoom image into zoom-in.svg
                    this.src = data.getZoom('in');
                    this.style.height = '14px';
		    this.style.width = '14px';
		    // Shrink current block
		    block.style.width='350px';
                    block.style.height='270px';
		    // Shrink font size
                    sub_blocks = block.children;
		    sub_blocks_len = sub_blocks.length;
		    for(k = 0; k < sub_blocks_len; k += 1) {
			sub_blocks[k].style.fontSize = '14px';
		    }
                }
            }
        }

    },
    
    enableModify: function () {
        // Dependencies
        var dom = TAFree.util.Dom,
            feature = TAFree.page.Feature,
            data = TAFree.page.Data,
	    addon = TAFree.page.Addon,

	    imgs, i, pre, j, code, lines, k, titles, codes;
            
        // Set modify button
        imgs = dom.getClass('MODIFY_BUTTON_IMG');
        for (i = 0; i < imgs.length; i += 1) {
        	imgs[i].addEventListener('click', feature.modify);
        }
	// Make original source code diggable and store them
	titles = dom.getClass('TITLE_DIV'); 
	codes = dom.getClass('CODE_DIV');
	for (j = 0; j < codes.length; j += 1) {
		code = codes[j].children[0].innerHTML;
		codes[j].innerHTML = '';
		title = titles[j].children[0].innerHTML;
		lines = code.split('\n');
    		for (k = 0; k < lines.length; k += 1) {
			lines[k] = '<pre class=\'MODIFY_LINE_PRE\'>' + lines[k] + '</pre>';
			codes[j].innerHTML += lines[k];
		}	
		// Add onclick event listener on each line
		for (l = 0; l < codes[j].children.length; l += 1) {
			codes[j].children[l].addEventListener('click', addon.diggable);
		}
		// Store original source
		data.storeSource(title, codes[j].innerHTML);
	} 
	 
    },
    
    handout: function () {
        // Dependencies
        var dom = TAFree.util.Dom,
            process = TAFree.page.Process,

	    but;
	
	but = dom.getId('HANDOUT_INPUT');
        but.addEventListener('click', function(e) {
	        var dom = TAFree.util.Dom,
		    modify_form, item_status, item;
		
		// Collect data as hidden input and form submission
		modify_form = dom.getId('MODIFY_FORM');
		process.hideData();	
		modify_form.submit();
	}); 
    },

    jumpThree: function () {
        // Dependencies
        var dom = TAFree.util.Dom,
            feature = TAFree.page.Feature,
            pre, next, i;
            
        // Set previous & next
        nexts = dom.getClass('NEXT_IMG');
	pres = dom.getClass('PRE_IMG');
        for (i = 0; i < pres.length; i += 1) {
        	pres[i].addEventListener('click', feature.pre);
        	nexts[i].addEventListener('click', feature.next);
        }
    },

    jumpItem: function () {
        // Dependencies
        var dom = TAFree.util.Dom,
            feature = TAFree.page.Feature,
            pre, next, i;
            
        // Set previous & next
        nexts = dom.getClass('NEXT_IMG');
	pres = dom.getClass('PRE_IMG');
        for (i = 0; i < pres.length; i += 1) {
        	pres[i].addEventListener('click', feature.preI);
        	nexts[i].addEventListener('click', feature.nextI);
        }
    },
    
    colorItem () {
        // Dependencies
        var dom = TAFree.util.Dom,

	imgs, i;

	imgs = dom.getClass('ITEM_STATUS_IMG');

	for (i = 0; i < imgs.length; i += 1) {
		switch(imgs[i].title) {
		case 'Uninitialized':
			imgs[i].src = './tafree-svg/status_yellow.svg';
		break;
		case 'In used':
			imgs[i].src = './tafree-svg/status_red.svg';
		break;
		case 'Available':
			imgs[i].src = './tafree-svg/status_green.svg';
		break;
		default:
			imgs[i].src = './tafree-svg/wrong.svg';
		}
	}
    },

    setup: function () {
        // Dependencies
        var dom = TAFree.util.Dom,
            feature = TAFree.page.Feature,
            buts, i;
            
        // Set previous & next
        buts = dom.getClass('SETUP_BUTTON');

        for (i = 0; i < buts.length; i += 1) {
		buts[i].addEventListener('click', feature.setup);
        }
    },

    here: function () {
        // Dependencies
        var dom = TAFree.util.Dom,
            feature = TAFree.page.Feature,
            boxs, i;
            
        // Set previous & next
        boxs = dom.getClass('HERE_CHECKBOX');

        for (i = 0; i < boxs.length; i += 1) {
		boxs[i].addEventListener('click', feature.here);
        }
    },

    otherJudge: function () {
        // Dependencies
        var dom = TAFree.util.Dom,
		
	    select, input;
            
            select = dom.getId('JUDGE_SELECT');
	    input = dom.getId('OTHER_INPUT');

	if (select.value !== 'other') {
		input.style.display = 'none';
	}
	select.addEventListener('change',function () {
		if (select.value !== 'other') {
			input.style.display = 'none';
		}
		else {
			input.style.display = 'inline';
		}
	});
    },

    beInUsed: function () {
        // Dependencies
        var dom = TAFree.util.Dom,
      	    feature = TAFree.page.Feature,
		
	    buts, i;

	buts = dom.getClass('FAC_A');
	for (i = 0; i < buts.length; i += 1) {
		if (buts[i].href.includes('assign')) {
			buts[i].addEventListener('click', feature.beInUsed);
		}
	}
    },

    handin: function () {
        // Dependencies
        var dom = TAFree.util.Dom,
            process = TAFree.page.Process,

	    but;
	
	but = dom.getId('HANDIN_INPUT');
        but.addEventListener('click', function(e) {
	        var dom = TAFree.util.Dom,
		    handin_form, item_status, item;
		
		// Refactor data as hidden input and form submission
		handin_form = dom.getId('HANDIN_FORM');
		process.refactorData();	
		handin_form.submit();
	}); 
    },

};

