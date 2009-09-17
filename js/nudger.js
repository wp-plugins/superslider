var Nudger = new Class({
 
	Implements : [Options],
 
	options : {
		transition : Fx.Transitions.linear,
		duration : 400,
		amount : 20
	},
 
	initialize: function(selector, options){
		this.setOptions(options);
 
		this.elements = $$(selector);
 
		this.elements.each(function(el){
 
			var nudge = {
				'fx' :  new Fx.Morph(el,{ 
							duration: this.options.duration,  
							transition: this.options.transition,
							link:'cancel'}),
				'enter' : this.enter.bind(this,el),
				'leave' : this.leave.bind(this,el)
			};
 
			el.addEvents({
				'mouseenter' : nudge.enter,
				'mouseleave' : nudge.leave
			});
 
			el.store('nudge',nudge);
 
		},this);
	},
 
	enter : function(el){
		el.retrieve('nudge').fx.start({ 'padding-left' : this.options.amount});
	},
 
	leave : function(el){
		el.retrieve('nudge').fx.start({ 'padding-left' : 0});
	},
 
	destroy : function(){
		this.elements.each(function(el){
			var nudge = el.retrieve('nudge');
			el.removeEvents({
				'mouseenter' : nudge.enter,
				'mouseleave' : nudge.leave
			});
		});
	}
 
});
/*
Default options:
   transition: Fx.Transitions.linear. // easing transition 
   duration: 400. // duration of effect
   amount : 20 // amount of pixels to move
 
Usage:
 
var nudger = new Nudger('a.nudge');
 
// with amount changed
 
var nudger = new Nudger('a.nudge',{amount : 40 });
 
*/