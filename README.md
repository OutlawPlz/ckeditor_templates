# CKEditor Templates

Drupal 8 custom module that implements Templates plugin in CKEditor. Install the
module [as usual](https://www.drupal.org/documentation/install/modules-themes/modules-8).

## Configuration

Navigate to `http://examp.le/admin/config/content/formats`, then click
*Configure* on a text format which has CKEditor enabled. In the *Toolbar
configuration* section drag the Templates button from *Available buttons* to
*Active toolbar*. Finally edit plugin settings, specifying the name of your
templates set and the file path where templates are defined. Available options
are *Name*, *Path* and *Replace content*.

- *Name:* The name of your templates set. In the example below the
templates name is 'custom'.
- *Path:* The path to your template file. In the example below the path is
`/sites/default/files/ckeditor_templates/custom.templates.js`.
- *Replace content:* When inserting a template the content should be replaced
or not by default.

## Templates definition

Templates are defined in JS files. Save your templates file in `/libraries`
folder or `/sites/default/files` folder. In this example the file will be
created into `/sites/default/files/ckeditor_templates` folder.

```js
// The name of templates set is 'custom'.
CKEDITOR.addTemplates( 'custom', {

  // Path to the subfolder that contains the preview images.
  imagesPath: '/sites/default/files/ckeditor_templates/images/',

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
