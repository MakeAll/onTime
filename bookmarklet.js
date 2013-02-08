javascript:(
	function(e,a,g,h,f,c,b,d){
		if(!(f=e.jQuery)||g>f.fn.jquery||h(f)){
		c=a.createElement("script");
	c.type="text/javascript";c.src="//ajax.googleapis.com/ajax/libs/jquery/"+g+"/jquery.min.js";
	c.onload=c.onreadystatechange=function(){
		if(!b&&(!(d=this.readyState)||d=="loaded"||d=="complete")){
			h((f=e.jQuery).noConflict(1),b=1);f(c).remove()
		}
	};
	a.documentElement.childNodes[0].appendChild(c)}})
	(window,document,"1.9.0",function($,L){
	var project = window.prompt("Project Name","");
	var eventType = window.confirm("Ok for start, Cancel for stop.");
	if (eventType == true) {
		eventType = 'start';
	} else if (eventType == false) {
	eventType = 'stop';
} if (project != null && project != null) {
	$.ajax({
		type: "POST",
		url: "http://crisnoble.com/qs/ontime/nodes/timeEntry.php",
		data: {project: project, startstop: eventType}
		}).done(function(){
			alert('finished');
		});
	}
});