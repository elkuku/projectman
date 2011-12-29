//function toggleContainer(name) {
//	var e = document.getElementById(name);// MooTools might not be available
											// ;)
//	e.style.display = (e.style.display == 'none') ? 'block' : 'none';
//}

var ProjectManager = new Class({
	  
	  //implements
	  Implements: [Options],

	  //options
	  options: {
	    yourOption: ''
	  },
	  
	  //initialization
	  initialize: function(options) {
	    //set options
	    this.setOptions(options);
	  },
	  
        toggle: function(id) {
            var container = document.id(id);
            container.style.display = (container.style.display == 'block') ? 'none' : 'block';
        },

	  refreshProject: function(id) {
		  var container = document.id('container-'+id);

		  var request = new Request({

		      url: 'index.php?view=details&task=refresh&format=raw&id='+id,

		      onRequest: function(){
		        container.set('text', 'Loading...');
		      },


		      onComplete: function(resp) {
console.log(resp);
		        container.empty();
		        container.set('html', resp);
		      },

		    }).send();
//		  this.loadProject(id);
	  },
	  
	  loadProject: function(id) {
//		  alert(id);
		  var container = document.id('container-'+id);
		  var command = document.id('command-'+id);
		  
		  if(container.style.display == 'block') {
			  container.style.display = 'none';
			  command.set('text', 'Show');
			  
			  return;
		  }
		  
		  container.style.display = 'block';
		  command.set('text', 'Hide');
		  
		  var request = new Request({

		      url: 'index.php?view=details&format=raw&id='+id,

		      onRequest: function(){
		        container.set('text', 'Loading...');
		      },


		      onComplete: function(resp) {
console.log(resp);
		        container.empty();
		        container.set('html', resp);
		      },

		    }).send();
	  }
	  
});

//once the DOM is ready
window.addEvent('domready', function() {
  ProjectMan = new ProjectManager({
    yourOption: 'yourValue'
  });
});
