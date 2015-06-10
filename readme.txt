=== Rewrite Rules Inspector ===
Contributors: (this should be a list of wordpress.org userid's)
Tags: reverse proxy
Tested up to: 4.2.2
Requires at least: 4.2.2
Stable tag: 1.0

Plugin for load external urls as though they originated from the current server 

== Description ==

Tool for loading external site as though it originated from the current itself.
This plugin add rewrite rule for load such pages and mark all matched with external url links to load they in the same manner.

This plugin use:
1. Reverse proxy  https://github.com/chricke/php5rp_ng by 
    Christian "chricke" Beckmann < mail@christian-beckmann.net >
    drkibitz < info@drkibitz.com >
    Brian Nelson < mrpoundsign@gmail.com >
2. PHP Simple HTML DOM Parser (http://sourceforge.net/projects/simplehtmldom/) by S. C. Chen и John Schlick


== Installation ==

This section describes how to install the plugin and get it working.

e.g.

1. Upload `reverse_proxy` to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Set options on plugin setup page
4. Use '<? external_site_link(); ?>' in your templates


== Changelog ==

= 1.0 (June 9, 2015) =
* Load external site as though it originated from the current itself.
* Replace all src, href, form action, tag onclick from loaded external page to marked as reversed urls

