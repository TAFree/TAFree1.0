TAFree.namespace('TAFree.util.Dom');

TAFree.util.Dom = {

	getTag: function(tag) {
		return document.getElementsByTagName(tag)[0];	
	},

	getId: function(id) {
		return document.getElementById(id);
	},
	
	getClass: function(classname) {
        	return document.getElementsByClassName(classname);
	},
    
    	getClassOne: function(classname) {
        	return document.getElementsByClassName(classname)[0];
    	},

	getNameOne: function(name) {
		return document.getElementsByName(name)[0];
	}
	
};
