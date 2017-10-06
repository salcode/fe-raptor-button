# Raptor Button WordPress Plugin

This plugin adds a button to your website that when clicked triggers the appearance of a Raptor using the jQuery plugin [Raptorize](https://zurb.com/playground/jquery-raptorize).

This plugin is extensible in a number of ways.

For brevity I'm using anonymous functions in my examples, which means this code requires a minimum PHP version of `5.3`.

## Ways to Extend This Plugin

### Button Text Filter

By default, the button text is "Get Raptor".  This can be modified using the `fe_raptor_btn_txt` filter.

The following code can be added to your theme's `functions.php`, a custom plugin, or a file in the `mu-plugins` directory.

```
add_filter( 'fe_raptor_btn_txt', function( $btn_txt ) {
    return 'Click for a surprise!';
});
```

### jQuery Plugin Configuration

The configuration for the jQuery plugin Raptorize is created in PHP and passed through the filter `fe_raptor_plugin_config`. We can use this to modify the settings for the jQuery Raptorize plugin.

The following code can be added to your theme's `functions.php`, a custom plugin, or a file in the `mu-plugins` directory.

```
// Enable sound for the raptorize plugin.
add_filter( 'fe_raptor_plugin_config', function( $js_config ) {
	$js_config['enableSound'] = true;
	return $js_config;
});
```

### Action fe_before_raptor_btn_template

There is an action directly before the button is displayed.  We can use this to add our own content before the button.

The following code can be added to your theme's `functions.php`, a custom plugin, or a file in the `mu-plugins` directory.

```
add_action( 'fe_before_raptor_btn_template', function() {
?>
<div class="alert alert-danger alert-dismissible" role="alert" style="margin: 10px;">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <strong>Warning!</strong> Clicking this button could be scary.
</div>
<?php
});
```

### Modify action for button

By default, the `fe_raptor()` function is attached to the `wp_footer` action.  We can change this.  The hooks available for display are going to depending on the theme you're using.  I'm a big fan of the [Genesis theme](), which provides the hook `genesis_before_loop`.

I can move the button to this hook with the following code in the theme's `functions.php` file.

```
remove_action( 'wp_footer', 'fe_raptor' );
add_action( 'genesis_before_loop', 'fe_raptor' );
```

__Modification if the code appears in a plugin or mu-plugin__

In the case of a plugin or an mu-plugin, we can run into the problem of trying to modify the hook where `fe_raptor()` is called __before__ the plugin sets `fe_raptor()` to it's original hook (`wp_footer`).

In this case, we delay our code to make certain the Raptor Button plugin has fully loaded, before we try to change anything.

```
add_action( 'plugins_loaded', function() {
    remove_action( 'wp_footer', 'fe_raptor' );
    add_action( 'genesis_before_loop', 'fe_raptor' );
});
```

### Override Templates

The default template for the button is found in this plugin at `templates/btn.php`.

This template can be overriden by placing a template in the active theme at `fe-raptor-button/btn.php`. (e.g. if your theme is `bootstrap-genesis`, your custom template would be at `wp-content/themes/bootstrap-genesis/fe-raptor-button/btn.php`)

A good way to get started is to copy `templates/btn.php` from this plugin and put it in you theme.  Then you can modify the template in your theme.

## Credits

- [Zurb](https://zurb.com/) Team's jQuery Plugin [Raptorize](https://zurb.com/playground/jquery-raptorize)
- [Sal Ferrarello](https://salferrarello.com/) / [@salcode](https://twitter.com/salcode)
