var produce = function() {
    function range(start, end) {
        var r = [];
        for(var i = start; i < end; i++) {
            r.push(i);
        }
        return r;
    }
    
    function liveOrDie(current, row, column) {
        switch(neighbors(current, row, column)) {
            case 0: case 1: case 4: return 0;
            case 2: return current[row][column];
        }
        return 1;
    }
    
    function neighbors(current, row, column) {
        var dirs = [[-1, 0], [-1, 1], [0, 1], [1, 1],
                    [1, 0], [1, -1], [0, -1], [-1, -1]];
        var count = 0;
        for(var i = 0; i < 8 && count < 4; i++) {
            var r = row + dirs[i][0];
            var c = column + dirs[i][1];
            if(r > -1 && r < current.length && 
               c > -1 && c < current[0].length && current[r][c]) {
                count++;
            }
        }
        return count;
    }
    
    return function(current) {
        return range(0, current.length).map(function(row) {
            return range(0, current[0].length).map(function(column) {
                return liveOrDie(current, row, column);
            });
        });
    };
}();

var draw = function(cells) {
    print('Status...\n');
    for(var row = 0; row < cells.length; row++) {
        for(var column = 0; column < cells[0].length; column++) {
            print(cells[row][column] ? '*' : '~');
        }
        print('\n');
    }
};

var isDifferent = function(current, next) {
    for(var row = 0; row < current.length; row++) {
        for(var column = 0; column < current[0].length; column++) {
            if(current[row][column] !== next[row][column]) {
                return true;
            }
        }
    }
    return false;
};

var current = [[0, 1, 0, 1, 0, 0, 0, 0, 1, 1],
               [0, 1, 0, 1, 0, 0, 0, 0, 1, 1],
               [0, 1, 0, 1, 0, 0, 0, 0, 1, 1],
               [0, 1, 1, 1, 0, 0, 1, 0, 1, 1],
               [0, 1, 1, 1, 0, 1, 0, 0, 1, 1],
               [0, 1, 0, 1, 1, 0, 0, 1, 1, 1],
               [0, 1, 0, 1, 0, 1, 0, 0, 1, 1],
               [0, 1, 0, 1, 0, 0, 1, 0, 1, 1],
               [0, 1, 0, 1, 0, 1, 0, 1, 1, 1],
               [0, 1, 0, 1, 1, 0, 0, 0, 1, 1]];

draw(current);
var next = produce(current)
while(isDifferent(current, next)) {
    current = next;
    draw(current);
    next = produce(next);
}
