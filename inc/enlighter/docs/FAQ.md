
## Frequently Asked Questions ##

### Autooptimize compatibility settings ###
To use Enlighter together with **autooptimize** it's required to exclude the Enlighter resources from autooptimize (EnlighterJS is already optimized!)
Goto `Settings / Autooptimize / Javascript options / Exclude scripts from Autoptimize` and add `enlighter/resources/` to the end of the comma separated list.

### Can i use Enlighter togehter with Crayon ? ###
No, you can't use Enlighter together with the Crayon Syntax highlighter because it may take over the Enlighter elements.

### Should i use Shortcode`s or the Visual-Editor Integration ? ###
If possible, use the VisualEditpr mode! The use of Shortcode is only recommended when working in Text-Mode. By switching to the Visual-Editor-Mode whitespaces (linebreaks, indents, ..) within the shortcode will get removed by the editor - using Visual-Editor mode will avoid such problems.

### I am using shortcodes and random p/br tags are added to my code ###
This problem is caused by WordPress' `wpAutoP` filter - to fix this issue, go to "Enlighter Settings -> Advanced -> WpAutoP Filter Priority" and change this value to "Priority 12 (after shortcode). For cross-plugin-compatibility this feature is disabled by default.

### I can't see any style options within the Visual-Editor-Toolbar ###
You have to enable the full toolbar by clicking on the **Show/Hide Kitchen Sink** button (last icon on the toolbar)

### I get an "file permission" php error in my blog ###
The directory `/wp-content/plugins/enlighter/cache/` must be writable - the generated css files as well as some cached content will be stored there for performance reasons. Try to set chmod to `0644` or `0770`

### When using the ThemeCustomizer the Code appears in plain-text ###
The cache-directory `wp-content/plugins/enlighter/cache` have to be writable, the generated stylesheet will be stored there. Set the directory permission (chmod) to `0644` or `0777`

### Inline Styles are missing within the Visual Editor ###
This feature requires WordPress 3.9 (new TinyMCE Version) - but you can still use shortcodes for inline highlighting! 

### How can i enable the Theme-Customizer ? ###
To enable the Theme-Customizer you have to select the theme named *Custom* as default theme. The Theme-Customizer will appear immediately.

### Is it possible to point out special lines of code ? ###
Yes! since version 1.5 all shortcodes support the attribute ``highlight``.
Shortcode Example: highlight the lines 2,3,4,8 of the codeblock `[js highlight="2-4,8"]....some code..[/js]`
	
### Are the uncompressed EnlighterJS Javasscript and CSS sources available ? ###
The complete EnlighterJS project can be found on [GitHub](https://github.com/EnlighterJS "EnligherJS Project")

### Can i add custom Themes ? ###
Yes you can! - The simplest way is to download the [EnlighterJS CSS sources](https://github.com/EnlighterJS/EnlighterJS/tree/master/Source/Themes "EnligherJS Project") and modify one of the standard themes. Finally create a directory named `enlighter` into your WordPress theme and put the css file into it.

### There are no Enlighter features visible within the Frontend Editor ###
You have to enable the frontend editing function: `Enlighter Settings Page -> Advanced -> TinyMCE Integration (Visual Editor) -> Enable Frontend Integration`. This feature also requires a logged-in user with `edit_posts` and/or `edit_pages` [privileges](http://codex.wordpress.org/Function_Reference/current_user_can) and is only available for the `wp_editor` function - no third party editors are supported!

### I'am already using MooTools and my page throws Javascript-Errors ###
If you are already using MooTools on your page, you have to disable the automatic inclusion of MooTools by Enlighter. Goto the Enlighter options page -> Advanced and select "Not include" as MooTools source. 
**Note:** EnlighterJS requires MooTools > 1.4

### Can Enlighter by disabled on selected pages? ###
Of course, the filter hook [enlighter_startup](https://github.com/EnlighterJS/Plugin.WordPress/blob/master/docs/FilterHooks.md) can be used to terminate the plugin initialization

### Security Vulnerabilities ###
In case you found a security issue in this plugin - please write a message **directly** to [Andi Dittrich](https://about.andidittrich.com/contact.html) - __**DO NOT POST THIS ISSUE ON GITHUB OR WORDPRESS.ORG**__ - the issue will be public released if it is fixed!

### I miss some features / I found a bug ###
Write a message to [Andi Dittrich](https://about.andidittrich.com/contact.html) (andi DOT dittrich AT a3non DOT O R G) or open a [New Issue on GitHub](https://github.com/EnlighterJS/Plugin.WordPress/issues)
