### Rewrite Rules Inspector 
Tags: reverse proxy
Tested up to: 4.2.2
Requires at least: 4.2.2
Stable tag: 1.0

Plugin for load external urls as though they originated from the current server 

### Description 

Tool for loading external site as though it originated from the current itself.
This plugin add rewrite rule for load such pages and mark all matched with external url links to load they in the same manner.

This plugin use:
1. Reverse proxy  https://github.com/chricke/php5rp_ng by 
    Christian "chricke" Beckmann < mail@christian-beckmann.net >
    drkibitz < info@drkibitz.com >
    Brian Nelson < mrpoundsign@gmail.com >
2. PHP Simple HTML DOM Parser (http://sourceforge.net/projects/simplehtmldom/) by S. C. Chen и John Schlick

### Installation 

This section describes how to install the plugin and get it working.

e.g.

1. Upload `reverse_proxy` to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Set options on plugin setup page
4. Use `<? external_site_link(); ?>` in your templates


### Changelog 

= 1.0 (June 9, 2015) =
* Load external site as though it originated from the current itself.
* Replace all src, href, form action, tag onclick from loaded external page to marked as reversed urls


### Copyright & License

    This software is licensed under the terms of the BSD license.

    Redistribution and use in source and binary forms, with or without
    modification, are permitted provided that the following conditions are
    met:

    *   Redistributions of source code must retain the above copyright
        notice, this list of conditions and the following disclaimer.

    *   Redistributions in binary form must reproduce the above copyright
        notice, this list of conditions and the following disclaimer in the
        documentation and/or other materials provided with the distribution.

    THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS
    IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED
    TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A
    PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT
    HOLDER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL,
    SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED
    TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR
    PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF
    LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING
    NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS
    SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
