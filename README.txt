=== WP Company ===
Contributors: Buooy
Tags: company, information, details, maintain
Requires at least: 3.5.1
Tested up to: 3.7.1
Stable tag: 1.1.1
Version:    1.1.1
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

WP Company is built to contain the information of the company that owns this WordPress Site

== Description ==

WP Company is built to contain the information of the company that owns this WordPress Site.

A large majority of WordPress sites are developed for company sites. However, WordPress by its default structure does not provide additional details of the site.

WP Company was set up to contain these information and to expose them on the website via shortcodes.

= Company information stored and exposed via shortcodes =
* Name
* Address 1
* Address 2
* Country
* City
* Postal
* Main Email
* Secondary Email
* Main Phone
* Secondary Phone
* Main Fax 
= Company Social Media stored and exposed via shortcodes =
* Facebook
* Twitter
* Google+
* Linkedin
* Pinterest
* Instagram
* Tumblr
* Vimeo
* YouTube

== Installation ==

1. Upload wp-company folder to the /wp-content/plugins/ directory
2. Activate the plugin through the 'Plugins' menu in WordPress

== Frequently Asked Questions ==

= How do I use the shortcodes =
You can utilize the following shortcodes:
= Company Information =
* Company Name 			:	[wp-company-option option='company_name']
* Company Address 1 		:	[wp-company-option option='company_address_1']
* Company Address 2 		:	[wp-company-option option='company_address_2']
* Company Country			:	[wp-company-option option='company_country']
* Company City			:	[wp-company-option option='company_city']
* Company Postal 			:	[wp-company-option option='company_postal']
* Company Main Phone 		:	[wp-company-option option='company_main_phone']
* Company Secondary Phone :	[wp-company-option option='company_secondary_phone']
* Company Main Email		:	[wp-company-option option='company_main_email']
* Company Secondary Email	:	[wp-company-option option='company_secondary_email']
* Company Main Fax 		:	[wp-company-option option='company_main_fax']

= Company Social Media =
* Company Facebook		:	[wp-company-option option='company_facebook']
* Company Twitter			:	[wp-company-option option='company_twitter']
* Company Google+			:	[wp-company-option option='company_googleplus']
* Company Linkedin 		:	[wp-company-option option='company_linkedin']
* Company Pinterest 		:	[wp-company-option option='company_pinterest']
* Company Instagram 		:	[wp-company-option option='company_instagram']
* Company Tumblr 			:	[wp-company-option option='company_tumblr']
* Company Vimeo  			:	[wp-company-option option='company_vimeo']
* Company YouTube 		:	[wp-company-option option='company_youtube'] 
= How do I use the shortcodes in PHP =
You can utilize it with do_shortcode as per Codex: http://codex.wordpress.org/Function_Reference/do_shortcode

e.g. echo do_shortcode('[wp-company-option option='company_name']');


== Screenshots ==

1. Main admin screen showing the different company information. This will be updated in future releases
2. Social Media Admin Panel
3. Help Section Admin Panel. Please donate!
4. Shortcodes in page editor
5. Shortcodes displayed in page. Can be used in footers and headers.


== Changelog ==

= 1.1.1 =
* New Feature: 	Added Main Phone - Suggested by Tommy Frössman
* New Feature: 	Added Secondary Phone
* New Feature: 	Added Main Email - Suggested by Tommy Frössman
* New Feature: 	Added Secondary Email
* New Feature: 	Added Main Fax
* New Feature: 	Added Instagram - Suggested by Tommy Frössman

Thanks Tommy Frössman for the suggestions

= 1.1.0 =
* New Feature: 	Added Social Network functions
* New Feature:	Added Help information
* Upgrade:		Spilt sections into tabs
* Security Fix:	Prevent shortcode from uploading or displaying non wp-company options
* New addition:	Added Donation links in Help tab

= 1.0.0 =
* First main upload to WordPress site
