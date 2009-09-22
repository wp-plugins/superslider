Element.implement({expose:function(){if(this.getStyle("display")!="none"){return $empty}var b={};var a={visibility:"hidden",display:"block",position:"absolute"};$each(a,function(d,c){b[c]=this.style[c]||""},this);this.setStyles(a);return(function(){this.setStyles(b)}).bind(this)},getDimensions:function(a){a=$merge({computeSize:false},a);var f={};function d(g,e){return(e.computeSize)?g.getComputedSize(e):g.getSize()}if(this.getStyle("display")=="none"){var b=this.expose();f=d(this,a);b()}else{try{f=d(this,a)}catch(c){}}return $chk(f.x)?$extend(f,{width:f.x,height:f.y}):$extend(f,{x:f.width,y:f.height})},getComputedSize:function(a){a=$merge({styles:["padding","border"],plains:{height:["top","bottom"],width:["left","right"]},mode:"both"},a);var c={width:0,height:0};switch(a.mode){case"vertical":delete c.width;delete a.plains.width;break;case"horizontal":delete c.height;delete a.plains.height;break}var b=[];$each(a.plains,function(g,f){g.each(function(h){a.styles.each(function(i){b.push((i=="border")?i+"-"+h+"-width":i+"-"+h)})})});var e=this.getStyles.apply(this,b);var d=[];$each(a.plains,function(g,f){c["total"+f.capitalize()]=0;c["computed"+f.capitalize()]=0;g.each(function(h){c["computed"+h.capitalize()]=0;b.each(function(k,j){if(k.test(h)){e[k]=e[k].toInt();if(isNaN(e[k])){e[k]=0}c["total"+f.capitalize()]=c["total"+f.capitalize()]+e[k];c["computed"+h.capitalize()]=c["computed"+h.capitalize()]+e[k]}if(k.test(h)&&f!=k&&(k.test("border")||k.test("padding"))&&!d.contains(k)){d.push(k);c["computed"+f.capitalize()]=c["computed"+f.capitalize()]-e[k]}})})});if($chk(c.width)){c.width=c.width+this.offsetWidth+c.computedWidth;c.totalWidth=c.width+c.totalWidth;delete c.computedWidth}if($chk(c.height)){c.height=c.height+this.offsetHeight+c.computedHeight;c.totalHeight=c.height+c.totalHeight;delete c.computedHeight}return $extend(e,c)}});Element.implement({isVisible:function(){return this.getStyle("display")!="none"},toggle:function(){return this[this.isVisible()?"hide":"show"]()},hide:function(){var b;try{if("none"!=this.getStyle("display")){b=this.getStyle("display")}}catch(a){}this.store("originalDisplay",b||"block");this.setStyle("display","none");return this},show:function(a){original=this.retrieve("originalDisplay")?this.retrieve("originalDisplay"):this.get("originalDisplay");this.setStyle("display",(a||original||"block"));return this},swapClass:function(a,b){return this.removeClass(a).addClass(b)},fxOpacityOk:function(){return !Browser.Engine.trident4}});Fx.Reveal=new Class({Extends:Fx.Morph,options:{styles:["padding","border","margin"],transitionOpacity:true,mode:"vertical",heightOverride:null,widthOverride:null},dissolve:function(){try{if(!this.hiding&&!this.showing){if(this.element.getStyle("display")!="none"){this.hiding=true;this.showing=false;this.hidden=true;var c=this.element.getComputedSize({styles:this.options.styles,mode:this.options.mode});var f=this.element.style.height===""||this.element.style.height=="auto";this.element.setStyle("display","block");if(this.element.fxOpacityOk()&&this.options.transitionOpacity){c.opacity=1}var a={};$each(c,function(g,e){a[e]=[g,0]},this);var d=this.element.getStyle("overflow");this.element.setStyle("overflow","hidden");this.$chain=this.$chain||[];this.$chain.unshift(function(){if(this.hidden){this.hiding=false;$each(c,function(g,e){c[e]=g},this);this.element.setStyles($merge({display:"none",overflow:d},c));if(f){this.element.setStyle("height","auto")}}this.fireEvent("onHide",this.element);this.callChain()}.bind(this));this.start(a)}else{this.callChain.delay(10,this);this.fireEvent("onComplete",this.element);this.fireEvent("onHide",this.element)}}else{if(this.options.link=="chain"){this.chain(this.dissolve.bind(this))}else{if(this.options.link=="cancel"&&!this.hiding){this.cancel();this.dissolve()}}}}catch(b){this.hiding=false;this.element.hide();this.callChain.delay(10,this);this.fireEvent("onComplete",this.element);this.fireEvent("onHide",this.element)}return this},reveal:function(){try{if(!this.showing&&!this.hiding){if(this.element.getStyle("display")=="none"||this.element.getStyle("visiblity")=="hidden"||this.element.getStyle("opacity")==0){this.showing=true;this.hiding=false;this.hidden=false;var b=this.element.getStyles("visibility","display","position");this.element.setStyles({visibility:"hidden",display:"block",position:"absolute"});var g=this.element.style.height===""||this.element.style.height=="auto";if(this.element.fxOpacityOk()&&this.options.transitionOpacity){this.element.setStyle("opacity",0)}var d=this.element.getComputedSize({styles:this.options.styles,mode:this.options.mode});this.element.setStyles(b);$each(d,function(h,e){d[e]=h},this);if($chk(this.options.heightOverride)){d.height=this.options.heightOverride.toInt()}if($chk(this.options.widthOverride)){d.width=this.options.widthOverride.toInt()}if(this.element.fxOpacityOk()&&this.options.transitionOpacity){d.opacity=1}var a={height:0,display:"block"};$each(d,function(h,e){a[e]=0},this);var f=this.element.getStyle("overflow");this.element.setStyles($merge(a,{overflow:"hidden"}));this.start(d);if(!this.$chain){this.$chain=[]}this.$chain.unshift(function(){if(!this.options.heightOverride&&g){if(["vertical","both"].contains(this.options.mode)){this.element.setStyle("height","auto")}if(["width","both"].contains(this.options.mode)){this.element.setStyle("width","auto")}}if(!this.hidden){this.showing=false}this.element.setStyle("overflow",f);this.callChain();this.fireEvent("onShow",this.element)}.bind(this))}else{this.callChain();this.fireEvent("onComplete",this.element);this.fireEvent("onShow",this.element)}}else{if(this.options.link=="chain"){this.chain(this.reveal.bind(this))}else{if(this.options.link=="cancel"&&!this.showing){this.cancel();this.reveal()}}}}catch(c){this.element.setStyles({display:"block",visiblity:"visible",opacity:1});this.showing=false;this.callChain.delay(10,this);this.fireEvent("onComplete",this.element);this.fireEvent("onShow",this.element)}return this},toggle:function(){try{if(this.element.getStyle("display")=="none"||this.element.getStyle("visiblity")=="hidden"||this.element.getStyle("opacity")==0){this.reveal()}else{this.dissolve()}}catch(a){this.show()}return this}});Element.Properties.reveal={set:function(a){var b=this.retrieve("reveal");if(b){b.cancel()}return this.eliminate("reveal").store("reveal:options",$extend({link:"cancel"},a))},get:function(a){if(a||!this.retrieve("reveal")){if(a||!this.retrieve("reveal:options")){this.set("reveal",a)}this.store("reveal",new Fx.Reveal(this,this.retrieve("reveal:options")))}return this.retrieve("reveal")}};Element.Properties.dissolve=Element.Properties.reveal;Element.implement({reveal:function(a){this.get("reveal",a).reveal();return this},dissolve:function(a){this.get("reveal",a).dissolve();return this}});Element.implement({nix:function(){var a=Array.link(arguments,{destroy:Boolean.type,options:Object.type});this.get("reveal",a.options).dissolve().chain(function(){this[a.destroy?"destroy":"dispose"]()}.bind(this));return this}});var MultipleOpenAccordion=new Class({Implements:[Options,Events,Chain],options:{togglers:[],elements:[],openAll:true,firstElementsOpen:[0],fixedHeight:false,fixedWidth:false,height:true,opacity:true,width:false},togglers:[],elements:[],initialize:function(a,b){this.setOptions(b);this.container=$(a);elements=$$(b.elements);$$(b.togglers).each(function(d,c){this.addSection(d,elements[c],c)},this);if(this.togglers.length){if(this.options.openAll){this.showAll()}else{this.toggleSections(this.options.firstElementsOpen,false,true)}}this.openSections=this.showSections.bind(this);this.closeSections=this.hideSections.bind(this)},addSection:function(d,c,g){d=$(d);c=$(c);var f=this.togglers.contains(d);var b=this.togglers.length;this.togglers.include(d);this.elements.include(c);if(b&&(!f||g)){g=$pick(g-1,b-1);d.inject(this.elements[g],"after");c.inject(d,"after")}else{if(this.container&&!f){d.inject(this.container);c.inject(this.container)}}var a=this.togglers.indexOf(d);d.addEvent("click",this.toggleSection.bind(this,a));var e;if(this.options.height&&this.options.width){e="both"}else{e=(this.options.height)?"vertical":"horizontal"}c.store("reveal",new Fx.Reveal(c,{transitionOpacity:this.options.opacity,mode:e,heightOverride:this.options.fixedHeight,widthOverride:this.options.fixedWidth}));return this},onComplete:function(a,b){this.fireEvent(this.elements[a].isVisible()?"onActive":"onBackground",[this.togglers[a],this.elements[a]]);this.callChain();return this},showSection:function(a,b){this.toggleSection(a,b,true)},hideSection:function(a,b){this.toggleSection(a,b,false)},toggleSection:function(a,d,b,e){var f=b?"reveal":$defined(b)?"dissolve":"toggle";e=$pick(e,true);var c=this.elements[a];if($pick(d,true)){c.retrieve("reveal")[f]().chain(this.onComplete.bind(this,[a,e]))}else{if(f=="toggle"){c.togglek()}else{c[f=="reveal"?"show":"hide"]()}this.onComplete(a,e)}return this},toggleAll:function(b,a){var d=a?"reveal":$chk(a)?"disolve":"toggle";var c=this.elements.getLast();this.elements.each(function(f,e){this.toggleSection(e,b,a,f==c)},this);return this},toggleSections:function(c,b,a){last=c.getLast();this.elements.each(function(e,d){this.toggleSection(d,b,c.contains(d)?a:!a,d==last)},this);return this},showSections:function(b,a){b.each(function(c){this.showSection(c,a)},this)},hideSections:function(b,a){b.each(function(c){this.hideSection(c,a)},this)},showAll:function(a){return this.toggleAll(a,true)},hideAll:function(a){return this.toggleAll(a,false)}});