# CKEditor Templates

Drupal 8 custom module that implements Templates plugin in CKEditor.

## Quick start

Start using CKEditor Templates in three steps.

1. Download latest CKEditor Templates module from [Github][e452dcd7] or via
Composer and enable it as usual.
  ```sh
  composer require outlawplz/ckeditor_templates
  ```

2. Download the CKEditor Templates plug-in and copy it to the `libraries/`
folder found at Drupal root folder.
```sh
# Plug-in location
/libraries/templates/plugin.js
```

3. Edit a text format that uses CKEditor, and enable the Templates plug-in
dragging the icon from *Available buttons* to *Active toolbar*.

That's it. You're all set to start using CKEditor Templates.

  [e452dcd7]: https://github.com/OutlawPlz/ckeditor_templates "Github - CKEditor templates"

## Options

Once the plug-in is enabled, you can specify where to find your templates file
editing the plug-in settings. Available options are *Name*, *Path* and *Replace
content*.

- **Name:** The name of your templates set. In the example below the
templates name is `custom`.

- **Path:** The path to your template file. In the example below the path is
`/libraries/custom_templates/custom.templates.js`.

- **Replace content:** When inserting a template the content should be
replaced or not by default.

## Templates definition

Templates are defined in JS files. Save your templates file in `/libraries`
folder or `/sites/default/files` folder. In this example the file will be
created into `/libraries/custom_templates` folder.

```js
// The name of templates set is 'custom'.
CKEDITOR.addTemplates( 'custom', {

  // Path to the subfolder that contains the preview images.
  imagesPath: '/libraries/custom_templates/images/',

  // Template definition.
  templates: [
    {
      title: 'Custom template',
      image: 'custom.gif',
      description: 'Description of my custom template.',
      html:
        '<h2>Custom Template</h2>' +
        '<p>Your text...</p>'
    },
    {
      title: 'Custom template with image',
      image: 'custom_image.gif',
      description: 'Description of my custom template with image.',
      html:
        '<h2>Custom Template with Image</h2>' +
        '<p><img src="/image.png" /></p>',
        '<p>Your text...</p>'
    }
  ]
} );
```
