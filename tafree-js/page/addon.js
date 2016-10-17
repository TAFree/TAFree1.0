TAFree.namespace('TAFree.page.Addon');

TAFree.page.Addon = {
	
	warnStu: function () {
		
		// Dependencies
        	var data = TAFree.page.Data,	
		    svg, big_cir, small_cir;
		
		svg = data.getStu_leave('ele');
		
		if (data.getStu_leave('check')) {
			big_cir = svg.children[0];
			small_cir = svg.children[1];
			small_cir.setAttribute('class', 'WARN_SMALL_CIRCLE');
			big_cir.setAttribute('class', 'WARN_BIG_CIRCLE');
		}
	},

	warnFac: function () {
		
		// Dependencies
        	var data = TAFree.page.Data,	
		    a;
		
		a = data.getFac_leave('ele');
		
		if (data.getFac_leave('check')) {
			a.setAttribute('class', 'WARN_FAC_A');
		}

	}

};

