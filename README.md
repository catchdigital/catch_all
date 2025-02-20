# Catch All Profile

## Setup

A profile to quickly install and set up a vanilla project with basic configuration. This profile uses the following modules:

Note that a number of the modules only have dev versions availble that support Drupal 10. The versions of these contrib modules will need updating as more are updated.

````
"drupal/admin_toolbar": "^3.5",
"drupal/core-composer-scaffold": "^11.1",
"drupal/core-project-message": "^11.1",
"drupal/core-recommended": "^11.1",
"drupal/focal_point": "^2.1",
"drupal/field_group": "^3.6",
"drupal/imageapi_optimize": "^4.1@beta",
"drupal/imageapi_optimize_resmushit": "^2.1@beta",
"drupal/paragraphs": "^1.18",
"drupal/metatag": "^2.0",
"drupal/pathauto": "^1.13",
"drupal/rabbit_hole": "^2.0",
"drupal/redirect": "^1.10",
"drupal/seckit": "^2.0",
"drupal/simple_sitemap": "^4.2",
"drupal/smart_trim": "^2.2",
"drupal/stage_file_proxy": "^3.1",
"drupal/username_enumeration_prevention": "^1.4",
"drupal/linkit": "^7.0",
"drupal/google_tag": "^2.0",
"drupal/hook_event_dispatcher": "^4.2",
"drupal/webp": "^1.0",
"drupal/gin": "^3.0",
"drupal/gin_toolbar": "^1.0",
"drupal/paragraphs_ee": "^2.1"
````

## Setup

## Install
The recommended way to install this is to use the drush site-install command.
`drush si catch_all -y`

Other parameters you should consider using are:
- `--account-name`
- `--account-pass`
- `--site-mail`
- `--site-name`

## What's in the profile
### Content types
- Basic Page
- Content Page

### Media Types
This also has focal point and image optimisation set up out of the box for crops.
- Image
- File

### User Roles
- Administrator
- Product Owner
- Content Editor

### Modules
- admin_toolbar
- admin_toolbar_search
- admin_toolbar_tools
- big_pipe
- block
- breakpoint
- ckeditor
- config
- config_translation
- content_translation
- content_moderation
- contextual
- core_event_dispatcher
- crop
- ctools
- dynamic_page_cache
- dblog
- editor
- entity_reference_revisions
- field
- field_group
- field_ui
- file
- filter
- focal_point
- google_tag
- hook_event_dispatcher
- image
- imageapi_optimize
- imageapi_optimize_resmushit
- inline_form_errors
- language
- link
- linkit
- locale
- media
- media_library
- menu_link_content
- menu_ui
- metatag
- metatag_dc
- metatag_hreflang
- metatag_open_graph
- metatag_twitter_cards
- node
- options
- page_cache
- path
- path_alias
- preprocess_event_dispatcher
- quickedit
- rabbit_hole
- redirect
- redirect_404
- responsive_image
- rh_media
- rh_node
- roleassign
- seckit
- settings_tray
- simple_sitemap
- smart_trim
- syslog
- system
- text
- token
- toolbar
- update
- user
- username_enumeration_prevention
- views_ui
- workflows
- pathauto
- views
- paragraphs
- paragraphs_ee
- gin
- gin_toolbar
- webp

## Updating the profile
More information on creating a profile can be found here: https://www.drupal.org/docs/distributions/creating-distributions/how-to-write-a-drupal-installation-profile

1. Export your configuration.
2. Copy your configuration over to the profile `cp config/sync/* docroot/profiles/custom/catch_all/config/install`
3. Remove all UUIDs `find docroot/profiles/custom/catch_all/config/install -type f -exec sed -i '' '/^uuid:/d' {} \;`
4. Remove all _core `find docroot/profiles/custom/catch_all/config/install -type f -exec sed -i '' '/_core:/{N;d;}' {} \;`
5. Remove unneeded files `rm docroot/profiles/custom/catch_all/config/install/system.site.yml docroot/profiles/custom/catch_all/config/install/core.extension.yml`
6. Update catch_all.info.yml with any modules you have installed
