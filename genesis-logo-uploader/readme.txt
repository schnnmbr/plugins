=== Plugin Name ===
Contributors: surefirewebserv, daveshine (David Decker) 
Tags: Genesis, Genesis Framework, Logo, Upload, Genesis logo, Genesis logo upload
Requires at least: 3.0.1
Tested up to: 3.9.2
Stable tag: trunk
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

This is a plugin that will allow you to upload your logo via the WordPress Customizer for Genesis Child Themes.

== Description ==

This is a plugin that makes it incredibly easy to upload your logo to any Genesis Child Theme.  You basically use WordPress Customizer, upload your logo, and your done.  

It actually adds an image rather than an h1 tag and a background image, and also creates the class .site-logo.  Since Genesis 2.0 images are responsive, it’ll fill the space it’s in.  Meaning if you want it to shrink, you’ll have to adjust the width of the container in your css.

This is for Genesis 2.0 and up.


== Installation ==

**NOTE:** Only works with Genesis Framework version 2.0 or higher as the parent theme. This is a paid premium product by StudioPress/ Copyblogger Media LLC, available via studiopress.com.

= Installation Steps =
1. Installing alternatives:
 * *via Admin Dashboard:* Go to 'Plugins > Add New', search for “Genesis Logo Uploader”, click "install"
 * *OR via direct ZIP upload:* Upload the ZIP package via 'Plugins > Add New > Upload' in your WP Admin
 * *OR via FTP upload:* Upload `sf-logo-uploader` folder to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Go to the Genesis Settings and under “Header” choose “Image Logo”
 * * Make sure to have Custom Header Support OFF (in functions.php file)
4. Go To “Appearance > Customize” and upload your logo.

**Note:** The "Genesis Framework" in version 2.0 or higher is required for this plugin in order to work. If you don't own a copy it yet, this premium parent theme has to be bought. More info about that you'll find here: http://surefirewebservices.com/go/genesis

= Requirements =
* *Always recommended to run the latest versions of everything! :)*
* WordPress version 3.6 or higher
* Genesis Framework version 2.0 or higher (Note: paid premium product!)
* A Genesis child theme - both variants, XTHML and HTML5 child themes are supported

= Video of Plugin's Widget Options Walkthrough plus Demo: =
[vimeo https://vimeo.com/75219918]
[**original video link**](https://vimeo.com/75219918) *by Jonathan Perez*

== Frequently Asked Questions ==

= Why won’t my logo show? =
There are 2 things required to get your logo to show.  A lot of themes use the Custom Header theme support, so you have to make sure that’s removed from your functions.php file.  Also, a lot of themes use logos as background image, so in the CSS, under .site-title (or similar), there may be be an attribute called ‘text-indent’.  Remove that.

= Why didn’t you include styles to make the logo appear nice? =
Because every logo is different. It wouldn’t make sense to have a default style for a rectangle logo if you’re logo is round, etc. Adding a little padding, width, and margin in the style sheet should make every logo appear fine.


== Changelog ==

= 1.1 =
* Changed the logo link to use site_url() instead of ‘/‘ 

= 1.0 =
* Official WordPress Release

