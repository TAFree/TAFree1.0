TAFree.namespace('TAFree.asset.Polygon');

TAFree.asset.Polygon = {
    
	Circle: function (obj) {
            
        var svg_ns, xlink_ns, link, circle, text, x, y, r, c,
            item, url;
            
        svg_ns = 'http://www.w3.org/2000/svg';
        xlink_ns = 'http://www.w3.org/1999/xlink';
        x = 250;
        y = 250;
        r = 150;
        c = 30;
        
        // Set circle
        circle = document.createElementNS(svg_ns, 'circle');
        circle.setAttribute('cx', x);
        circle.setAttribute('cy', y);
        circle.setAttribute('stroke-width', 2);
        circle.setAttribute('stroke', '#000000');        
        circle.style.fill = '#2186C4';
       
        // Parse link hash table
	if (typeof obj.getPolygon !== 'undefined') { // Single problem
            
            circle.setAttribute('r', r);
        
	    circle.onmouseover = function() {
                this.style.fill = '#FFF6E5';
            }
            circle.onmouseout = function() {
                this.style.fill = '#2186C4';
            }
            
            url = obj.getPolygon('urls')[0];

            item = obj.getPolygon('name');
            
        }
        else { // Not for problem, but just for item
            
            circle.setAttribute('r', 55); // Compact circle
            
            url = null;
            
            item = obj.name;
            
        }
        
        // Set text
        text = document.createElementNS(svg_ns, 'text');
        text.setAttribute('font-size', c);
        text.setAttribute('text-anchor', 'middle');
        text.setAttribute('x', x);
        text.setAttribute('y', y + c / 2);
        text.textContent = item;
        
        // Set link
        link = document.createElementNS(svg_ns, 'a');
        
        if (url !== null) {
            link.setAttributeNS(xlink_ns, 'xlink:href', url);
        }
        link.appendChild(circle);
        link.appendChild(text);
        
        return link;
        
	},
    
    Polygon: function (obj) {
        
        var svg_ns, xlink_ns, frag, link, tri, text, circle, x, y, x_t, y_t, r, c, x_arr_pl, y_arr_pl, i, n,
        item, urls, send_obj;
        
        svg_ns = 'http://www.w3.org/2000/svg';
        xlink_ns = 'http://www.w3.org/1999/xlink';
        x = 250;
        y = 250;
        r = 240;
        c = 30;
         
        // Initialize points array of polygon
        n = obj.getPolygon('urls').length;
        x_arr_pl = [];
        y_arr_pl = [];
        for (i = 0; i < n; i += 1) {
            x += r * Math.cos(i * 2 * Math.PI / n);
            x_arr_pl.push(x);
            x = 250;
            y -= r * Math.sin(i * 2 * Math.PI / n);
            y_arr_pl.push(y);
            y = 250;
        }
        
        // Parse link hash table
        urls = obj.getPolygon('urls');
        item = obj.getPolygon('name');
        
        // Set polygon
        frag = document.createDocumentFragment();
        for (i = 0; i < n; i += 1) {
   
            // Set triangle
            tri = document.createElementNS(svg_ns, 'polygon');
            tri.setAttribute('stroke-width', 2);
            tri.setAttribute('stroke', '#000000');
            tri.style.fill = '#7ECEFC';
            tri.onmouseover = function(){
                this.style.fill = '#FFF6E5'
                
            };
            tri.onmouseout = function(){
                this.style.fill = '#7ECEFC';
                
            };
            
            // Set text
            text = document.createElementNS(svg_ns, 'text');
            text.setAttribute('font-size', c);
            text.setAttribute('text-anchor', 'middle');
            text.textContent = i + 1;
            
            if (i < n-1) {
                tri.setAttribute('points', TAFree.asset.Polygon.buildTriPts(x, y, x_arr_pl[i], y_arr_pl[i], x_arr_pl[i+1], y_arr_pl[i+1]));
                x_t = x / 3 + x_arr_pl[i] / 3 + x_arr_pl[i+1] / 3;
                y_t = y /3 + y_arr_pl[i] / 3 + y_arr_pl[i+1] / 3;
                text.setAttribute('x',x_t);
                text.setAttribute('y',y_t);
                
            }
            else {
                tri.setAttribute('points', TAFree.asset.Polygon.buildTriPts(x, y, x_arr_pl[i], y_arr_pl[i], x_arr_pl[0], y_arr_pl[0]));
                x_t = x / 3 + x_arr_pl[i] / 3 + x_arr_pl[0] / 3;
                y_t = y / 3 + y_arr_pl[i] / 3 + y_arr_pl[0] / 3;
                text.setAttribute('x',x_t);
                text.setAttribute('y',y_t);
            }
            
            // Set link
            link = document.createElementNS(svg_ns, 'a');
            link.setAttributeNS(xlink_ns, 'xlink:href', urls[i]);
            link.appendChild(tri);
            link.appendChild(text);
            
            frag.appendChild(link);

        }
        
        // Set circle
        send_obj = {
            name: item
        };
        
        circle = new TAFree.asset.Polygon.Circle(send_obj);
        frag.appendChild(circle);

        return frag;
    },
    
    Rectangle: function(obj) {
        
        var svg_ns, xlink_ns, frag, link1, link2, rect1, rect2, text1, text2, circle, x1, y1, x2, y2, x3, y3, x4, y4, c,
        item, urls, send_obj;
        
        svg_ns = 'http://www.w3.org/2000/svg';
        xlink_ns = 'http://www.w3.org/1999/xlink';
        x1 = 50;
        y1 = 50;
        x2 = 450;
        y2 = 50;
        x3 = 450;
        y3 = 450;
        x4 = 50;
        y4 = 450;
        c = 30;
        
        // Parse link hash table
        urls = obj.getPolygon('urls');
        item = obj.getPolygon('name');
        
        // Set rectangle
        frag = document.createDocumentFragment();
        rect1 = document.createElementNS(svg_ns, 'polygon');
        rect1.setAttribute('points', TAFree.asset.Polygon.buildRectPts(x1, y1, x1 / 2 + x2 / 2, y1, x3 / 2 + x4 / 2, y3, x4, y3, x1, y1));
        rect1.setAttribute('stroke-width', 2);
        rect1.setAttribute('stroke', '#000000');
        rect1.style.fill = '#7ECEFC';
        rect1.onmouseover = function(){
            this.style.fill = '#FFF6E5'
            
        };
        rect1.onmouseout = function(){
            this.style.fill = '#7ECEFC';
            
        };
        rect2 = document.createElementNS(svg_ns, 'polygon');
        rect2.setAttribute('points', TAFree.asset.Polygon.buildRectPts(x1 / 2 + x2 / 2, y2, x2, y2, x3, y3, x3 / 2 + x4 / 2, y3, x1 / 2 + x2 / 2, y2));
        rect2.setAttribute('stroke-width', 2);
        rect2.setAttribute('stroke', '#000000');
        rect2.style.fill = '#7ECEFC';
        rect2.onmouseover = function(){
            this.style.fill = '#FFF6E5'
            
        };
        rect2.onmouseout = function(){
            this.style.fill = '#7ECEFC';
            
        };

        // Set text
        text1 = document.createElementNS(svg_ns, 'text');
        text1.setAttribute('font-size', c);
        text1.setAttribute('text-anchor', 'middle');
        text1.setAttribute('x', x1 + x2 / 4 - x1 / 4);
        text1.setAttribute('y', y1 / 2 + y4 /2);
        text1.textContent = 1;
        text2 = document.createElementNS(svg_ns, 'text');
        text2.setAttribute('font-size', c);
        text2.setAttribute('text-anchor', 'middle');
        text2.setAttribute('x', x1 + x2 * 3 / 4 - x1 * 3 / 4);
        text2.setAttribute('y', y1 / 2 + y4 / 2);
        text2.textContent = 2;
        
        // Set link
        link1 = document.createElementNS(svg_ns, 'a');
        link1.setAttributeNS(xlink_ns, 'xlink:href', urls[0]);
        link1.appendChild(rect1);
        link1.appendChild(text1);
        link2 = document.createElementNS(svg_ns, 'a');
        link2.setAttributeNS(xlink_ns, 'xlink:href', urls[1]);
        link2.appendChild(rect2);
        link2.appendChild(text2);
        
        frag.appendChild(link1);
        frag.appendChild(link2);
        
        // Set circle
        send_obj = {
            name: item,
        };
        
        circle = new TAFree.asset.Polygon.Circle(send_obj);
        frag.appendChild(circle);
        
        return frag;
    },
    
    buildTriPts: function (x1, y1, x2, y2, x3, y3) { // Return string like '200,10 250,190 160,210'

        return String(x1) + ','  + String(y1) + ' ' + String(x2) + ',' + String(y2) + ' ' + String(x3) + ',' + String(y3);

    },

    buildRectPts: function (x1, y1, x2, y2, x3, y3, x4, y4) { 

        return String(x1) + ','  + String(y1) + ' ' + String(x2) + ',' + String(y2) + ' ' + String(x3) + ',' + String(y3) + ' ' + String(x4) + ',' + String(y4);

    }
    
};


