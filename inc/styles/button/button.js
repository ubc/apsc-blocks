// APSC Default
wp.blocks.registerBlockStyle( 'core/button', {
    name: 'apsc-default',
    label: 'APSC Default'
} );

// APSC Primary
wp.blocks.registerBlockStyle( 'core/button', {
    name: 'apsc-primary',
    label: 'APSC Primary'
} );

// APSC Secondary
wp.blocks.registerBlockStyle( 'core/button', {
    name: 'apsc-secondary',
    label: 'APSC Secondary'
} );

// APSC Tertiary
wp.blocks.registerBlockStyle( 'core/button', {
    name: 'apsc-tertiary',
    label: 'APSC Tertiary'
} );

// APSC Inverse
wp.blocks.registerBlockStyle( 'core/button', {
    name: 'apsc-inverse',
    label: 'APSC Inverse'
} );

// Remove the fill and outline styles, to make things a little neater for people.
wp.domReady(() => {
    wp.blocks.unregisterBlockStyle('core/button', 'fill');
	wp.blocks.unregisterBlockStyle('core/button', 'outline');
} );
