# APSC Blocks

This plugin registers block patterns and block styles for UBC's Faculty of Applied Science and its units such as Engineering, Nursing, SALA, and SCARP.

The block patterns are available when editing a post or page using the Block Editor (Gutenberg) by clicking the blue button towards the top left of the editor with a Plus (+) symbol on it which toggles the block inserter, and then selecting 'Pattenrs'. All APSC Patterns are available in one of several pattern categories such as Buttons, Cards, Heroes, and CTAs.

The block styles are registered for individual blocks which contains various styles within the Applied Science Design System and can be accessed by selecting an already-inserted a block (such as a button), selecting the 'Styles' tab, and then selecting one of the registered styles such as 'APSC Primary'.

This plugin is developed to go hand-in-hand with the APSC Site Settings plugin which adds additional theme options to the UBC CLF (2023) theme including automatically adjusting the colour palettes and gradients based on the chosen unit.

## Developer Documentation

The below docs are primarily for the APSC Brand/Communications team and are intended to help them understand how to register new patterns or styles.

### Registering a New Pattern

Each block pattern consists of 2 files

1. A PHP file named after the pattern i.e. `media-and-text-large.php` which contains the actual HTML of the pattern
2. A `pattern.json` file

To register a new pattern, create a new directory within `inc/patterns/` with the type of pattern this is, for example, if you're registering a new card pattern called "Media and Text Small" (for example) then you'd create the `inc/patterns/cards/media-and-text-small` directory, and within there you'd place two files, `media-and-text-small.php` and `pattern.json`.

The `pattern.json` file must contain 4 keys:

title - the title shown when someone is viewing the different pattern names. Spaces and Special characters are allowed.
slug - a unique string for this pattern. Only lowecase letters, numbers, and a hyphen symbol are allowed.
categories - an array of pattern categories this pattern should be visble from (see 'registered pattern categories' below). Must be one of the registered pattern categories (either registered by this plugin, or WordPress core)
description - A full description of this pattern. Not directly shown to users, but useful for developers to know precisely what the pattern is. Spaces and special characters are allowed.

So, for our example 'Media and Text Small' pattern, we might add a `pattern.json` which looked like this:

```json
{
  "title": "Media + Text (Small) Cards",
  "slug": "apsc-patterns/media-and-text-small-cards",
  "categories": ["apsc-patterns", "apsc-cards"],
  "description": "A detailed description of this pattern would go here..."
}
```

And the `media-and-text-small.php` file would contain the block-ready markup for this pattern. You may find it easier to create the pattern in the block editor itself first, and then copy and paste the block directly into this file.

Save these 2 files, and commit them to this repo. (Submit a pull request to this repo from your own clone, and we will code review and deploy)

Once the plugin has been deployed, the last thing you will need to do is clear the pattern cache.

### Clearing the Pattern Cache

Once a new pattern or style is registered, you will likely need to clear the pattern cache on the site you want this to be available from. This is something that doesn't have an 'interface' as it's designed to only be done once, and not something that might happen accidentally as it can be a fairly intensive process.

From the dashboard of your site, as an administrator, append ?apsc-clear-block-patterns-cache=1 to the URL. i.e. https://some-site.sites.olt.ubc.ca/wp-admin/?apsc-clear-block-patterns-cache=1 and you will be redirected back to the same page, but without the apsc-clear-block-patterns-cache=1 part. This will have cleared the cache and your new pattern(s) will be available on that site.

### Registered Pattern Categories

There are several registered pattern categories, see `init__register_apsc_block_pattern_category()` :

`APSC Cards` - Card Patterns
`APSC Buttons` - Button Patterns
`APSC Heroes` - Hero Patterns
`APSC Call to Actions` - Call to Action patterns
`APSC Footers` - Patterns specifically for the footer of a page or site
`APSC Blocks` - Designed for individual items that might be used as part of a pattern
`APSC Patterns` - Designed almost as a 'catch all' for most of the registered patterns
