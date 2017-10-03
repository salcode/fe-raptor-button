<?php
/**
 * Default: Template for Raptor Button Plugin.
 *
 * Note: The trigger element must have the data-attribute
 * data-fe-raptor="trigger"
 *
 * @var $btn_txt The text to display in the button.
 *
 * @package fe-raptor-button
 */

?>
<button data-fe-raptor="trigger">
<?php echo esc_html( $btn_txt ); ?>
</button>
