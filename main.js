
(function($){  
	$(document).ready(function(){
		var sys = arbor.ParticleSystem(1000, 600, 0.5) // create the system with sensible repulsion/stiffness/friction
		sys.parameters({gravity:true, dt:0.005}) // use center-gravity to make the graph settle nicely (ymmv)
		sys.renderer = Renderer("#viewport") // our newly created renderer will have its .init() method called shortly by sys...


		$("#show-all-labels").click(sys.renderer.toggleLabels);

		$.get("friends.php", function(data) {
			data = $.parseJSON(data);
				var friends = data.data;
				for (var i = 0; i< friends.length;i++) {
					var friend = friends[i];
					sys.addNode(friend.id, {label: friend.name, showLabel: false});
				}
				
				addMfs(0, friends, sys);
		}).fail(function() {
			console.log("Error caught");
		});
	});

})(this.jQuery);

function addMfs(index, friends, sys) {
	var friend = friends[index];
	$("#log-box > .progress > .bar").css('width', Math.round((index/friends.length)*100) + "%");
	if(index >= friends.length) {
		$("#log-box").fadeOut();
		return;
	}
	
	
	$.post("friends.php", {id: friend.id}, function(data) {
		data = $.parseJSON(data);
			var mf = data.data;
			for (var i = 0; i < mf.length; i++) {
				sys.addEdge(friend.id, mf[i].id);
			}
			addMfs(index+1, friends, sys);
	}).fail(function() {
		console.log("Error caught");
		addMfs(index, friends, sys);
	});

}
