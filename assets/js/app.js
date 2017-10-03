jQuery(document).ready(function($) {

    // feRaptorConfig should exist but just in case we fallback gracefull.
    // feRaptorConfig is passed in using wp_localize_script().
    // See more at https://salferrarello.com/wp-localize-script-explanation/.
    if ( 'undefined' === typeof feRaptorConfig ) {
        feRaptorConfig = {};
    }

    $('[data-fe-raptor="trigger"]').raptorize( feRaptorConfig );

});
