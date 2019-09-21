Actions and Events
======================================================

EVENT::enlighter_init
------------------------------------------------------

**Description:** Triggered after Plugin initialization

#### Example - fetch a list of active themes ####

```php
$themes = array();
function do_after_ejs_init(){
    $themes = Enlighter::getAvailableThemes();
}

// the Theme-List become available after the plugin is initialized!
// prior calls will throw an internal error
add_action('enlighter_init', 'do_after_ejs_init');
```