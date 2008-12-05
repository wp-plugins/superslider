=== SuperSlider Show ===
Contributors: twincascos
Plugin URI: http://wp-superslider.com/
Tags:animation, animated, gallery, slideshow, mootools 1.2, mootools, slider, superslider
Requires at least: 2.6
Tested up to: 2.7
Stable tag: 1.0

Animated Gallery slideshow uses Mootools 1.2 javascript replaces wordpress gallery with a slideshow. 

== Description ==

This is your Animated show plugin that uses Mootools 1.2 javascript to replace your gallery with a Slideshow. Highly configurable, theme based design, css based animations.



== Installation ==

 - Unpackage contents to wp-content/plugins/ so that the files are in a superslider-show directory. 
 - Activate the plugin, 
 - Configure plugin under > settings > SuperSlider-show
 - Create post ,Add WordPress Gallery shortcode, or slideshow shortcode.
 - (optional) move plugin sub folder plugin-data to your wp-content folder,
	under  > settings > SuperSlider-show > option group, File Storage - Loading Options
	select "Load css from plugin-data folder, see side note. (Recommended)". This will
	prevent plugin uploads from over writing any css changes you may have made.


== OPTIONS AND CONFIGURATIONS ==

Available under > settings > SuperSlider-show
	* theme css files to use
	* shortcode tag to use (gallery or slideshow)
	* transition type
	* opacity transition
	* transition speed
	* transition type
	* lightbox on images on or off
	* to load or not Mootools.js
	* css files storage loaction

	*many more Advanced options

Available in the shortcode tag:

	* show_class="family" 
	* first_slide="0" 
	* show_type="kenburns/push/fold/default" 
	* height="400" 
	* width="200" 
	* transition="elastic:In:Out" 
	* thumbnails="true" 
	* image_size="thumbnail/medium/large/full" 
	* delay="milliseconds" 
	* duration="milliseconds" 
	* center="true" 
	* resize="true" 
	* overlap="true" 
	* random="true" 
	* loop="true" 
	* linked="true" 
	* thumbnails="true" 
	* fast="true" 
	* captions="true" 
	* controller="true" 
	* paused ="true"


== Themes ==

Create your own graphic and animation theme based on one of these provided

	* Available themes
		* default (Thumbs set to 150px x 150px)
		* blue (Thumbs set to 50px x 150px)
		* black (Thumbs set to 150px x 150px)
		* custom (Thumbs set to 150px x 150px)

== To Do ==

	* Enqueue javascript files
	* fix known bugs:
				- no thumbnails in the short code fails
				- lightbox fails
				

== Report Bugs Request / Options / Functions ==

* for now please use the comments system at http://wp-superslider.com
	

== Frequently Asked Questions ==	

=  How do I change the style of the slideshow? =
  
  I recommend that you move the folder plugin-data to your wp-content folder
  if you already have a plugin-data folder there, just move the superslider folder.
  remember to change the css location option in the settings page for this plugin.
  Or edit directly: 
  wp-content/plugins/superslider-show/plugin-data/superslider/ssshow/custom.css.
  Alternatively, you can copy those rules into your WordPress themes, style file. 
  Then remember to change the css location option in the settings page for this plugin.
  

= The stylesheet doesn't seem to be having any effect? =
 
  Check this url in your browser:
  http://yourblogaddress/wp-content/plugins/superslider-show/plugin-data/superslider/ssShow/custom.css
  If you don't see a plaintext file with css style rules, there may be
  something wrong with your .htaccess file (mod_rewrite). If you don't know
  how to fix this, you can copy the style rules there into your themes style
  file.

= How do I use different graphics and symbols for collapsing and expanding? =

You can upload your own images to
http://yourblogaddress/wp-content/plugins/superslider-show/plugin-data/superslider/ssShow/img_custom

== Screenshots ==

1. a SlideShow
2. plugin settings screen 

== Demo ==

This plugin is in use here at 
	* <http://wp-superslider.com>
	* <http://portfolio.daivmowbray.com>

== CAVEAT ==

Currently this plugin relies on Javascript to create the slide show.
If a user's browser doesn't support javascript the gallery will display normally.

== HISTORY ==
* 1.0 rc (2008/12/04)
	- fixed shortcode transition type
	- fixed no thumbs option
	- fixed Milkbox option


* 0.7.0_beta (2008/12/01)
	- fixed lightbox pop over (works with built in lightbox)
	- changed the theme structure to be easier to grow.
	- added more options to the image resize option

* 0.6.0_beta (2008/12/01)
	- added full short code support
	- added multiple shows per page/post
	- more code refinement

* 0.3.0_beta (2008/11/15)
	- reduced database calls
	- cleaned code

* 0.1.0_beta (2008/10/26)

    * first public launch

---------------------------------------------------------------------------