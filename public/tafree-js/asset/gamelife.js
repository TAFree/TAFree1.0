TAFree.namespace('TAFree.asset.GameLife');

TAFree.asset.GameLife = {

    produce: function (current) {
	    var range, liveOrDie, neighbors;

	    range = function (start, end) {
		var r, i;
		
		    r = [];
		for(i = start; i < end; i += 1) {
		    r.push(i);
		}
		return r;
	    };
	    
	    liveOrDie = function (current, row, column) {
		switch(neighbors(current, row, column)) {
		    case 0: case 1: case 4: return 0;
		    case 2: return current[row][column];
		}
		return 1;
	    };
	    
	    neighbors = function (current, row, column) {
		var dirs, count, i, r, c;
		   
		    dirs = [[-1, 0], [-1, 1], [0, 1], [1, 1],
			    [1, 0], [1, -1], [0, -1], [-1, -1]];
		    count = 0;
		
		    for(i = 0; i < 8 && count < 4; i++) {
		    r = row + dirs[i][0];
		    c = column + dirs[i][1];
		    if(r > -1 && r < current.length && 
		       c > -1 && c < current[0].length && current[r][c]) {
			count++;
		    }
		}
		return count;
	    };
	    
	    return function(current) {
		return range(0, current.length).map(function(row) {
		    return range(0, current[0].length).map(function(column) {
			return liveOrDie(current, row, column);
		    });
		});
	    };
    },

    create: function(cells) {
         // Dependencies
	 var dom = TAFree.util.Dom,

	 row, column, svg_ns, svg, frag;
   
	 svg_ns = 'http://www.w3.org/2000/svg';
	 svg = dom.getTag('SVG');
	 frag = document.createDocumentFragment();

	 for(row = 0; row < cells.length; row += 1) {
		for(column = 0; column < cells[0].length; column += 1) {
			// Set rectangle
			rect = document.createElementNS(svg_ns, 'rect');
			rect.setAttribute('id', 'C' + row * cells.length + column);
			rect.setAttribute('x', row * 10);
			rect.setAttribute('y', column * 10);
			rect.setAttribute('width', 10);	
			rect.setAttribute('height', 10);	
			rect.setAttribute('stroke-width', 1);
			rect.setAttribute('stroke', '#3196C4');
			rect.style.fill = '#000000';
			frag.appendChild(rect);
		}
	}
	svg.appendChild(frag);
		 
    },

    isDifferent: function(current, next) {
	    var row,
	        column;

	    for(row = 0; row < current.length; row += 1) {
		for(column = 0; column < current[0].length; column += 1) {
		    if(current[row][column] !== next[row][column]) {
			return true;
		    }
		}
	    }
	    return false;
    },

    draw: function (current) {
         // Dependencies
	 var dom = TAFree.util.Dom,
	     row, column, rect, id;

	     for(row = 0; row < current.length; row += 1) {
		for(column = 0; column < current[0].length; column += 1) {
	     		id = row * current[0].length + column;
			rect = dom.getId('C' + id);
			rect.style.fill = (current[id] === 0) ? '#000000' : '#3196C4';		
		}
	     } 
    },

    init: function () { 
             // Dependencies
	     var dom = TAFree.util.Dom,
		 gamelife = TAFree.asset.GameLife,
		 
		 current, next, i, j, row;
                 
		 // Randomly generate 2D array
		 current = [];
		 for (i = 0; i < 10; i += 1) {
			row = [];
			for (j = 0; j < 10; j += 1) {
				row.push((Math.random() >= 0.5) ? 1 : 0);
			}
		 }
		 
		 // Create Rect elements
                 gamelife.create(current);
                 gamelife.draw(current);
                 
		 // Compute next generation from current generation
		 next = gamelife.produce(current);

		 // Change colors of Rect elements
                 while(gamelife.isDifferent(current, next)) {
                     current = next;
                     gamelife.draw(current);
                     next = gamelife.produce(next);
                 }
    }

};
