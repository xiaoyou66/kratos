Enlighter Plugin Notifications
============================================

Enlighter may throw some notifications/warnings/error on the top of the Enlighter settings page - these notifications are indicating some **possible issues** with your hosting environment or WordPress installation/configuration any **should taken serious!**

## WARNING: Option `use_balanceTags` is enabled ##

The `use_balanceTags` options is a legacy feature of WordPress core to "fix" invalid/bad `xhtml` syntax - it may sound helpful but in real-world-scenarios in causes more issues as it resolves - especially the Gutenberg or Classic Editor produces bullet-proofed xhtml markup and its not needed anymore it has been removed from WordPress v2.

In case you have a very "old" (updated) WordPress installation this feature might be still active and causes random content inserted into Enlighter sourcecode.

Reference: https://core.trac.wordpress.org/changeset/3223

Notice: This setting is not longer available within the standard WordPress settings menu. You have to open the raw settings editor on `<yoursite>/wp-admin/options.php` to alter the option (or within WordPress wp_options database table).

## WARNING: Option `use_smilies` is enabled ##

WordPress automatically recognizes smiley sequences like `:)` or `:(` and transforms them into images. Due to an error within the parsing function in WordPress, this feature also transforms these sequences within sourcecode - especially `pre` and `code` tags which also affects Enlighter. It causes html fragments to be inserted into the codeblock. To avoid such issues there is currently only one workaround: disable smileys globally.

A ticket for WordPress Core [has been created](https://core.trac.wordpress.org/ticket/44278) including a fix which will maybe released soon.

Notice: This setting is not available within the standard WordPress settings menu. You have to open the raw settings editor on `<yoursite>/wp-admin/options.php` to alter the option (or within WordPress wp_options database table).

## ERROR: Plugin "Crayon Syntax Highlighter" is enabled ##

Crayon Syntax Highlighter won't work together with Enlighter. In case you use both in parallel, the Crayon content parser will take over all Enlighter `<pre>` code elements and disables the Enlighter highlighting. You have to choose between the plugins.

## ERROR: The cache-directory is not writable ##

Enlighter requires a writable cache directory in `wp-content/plugins/enlighter/cache/` to store custom themes and the editor styles. In case the directory is not writable please change the directory permission to `0744` or `0777` depending on your hosting environment. Otherwise the Theme-Customizer as well as the Visual Editor Plugns won't work!

## ERROR: The plugin is located within an invalid path ## 

In case you may have uploaded the plugin manually this error will be thrown: the `enlighter/` directory name is **mandatory** - normally the plugin will be located in `wp-content/plugins/enlighter/`. You have to change the plugin location - otherwise Enlighter wont't work!