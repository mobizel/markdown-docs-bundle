# Customizing menu

## Customizing positions of your pages

You can customize pages into a directory. Add a `pages.php` in this directory and just return a list of files.
This will apply the position you choose in that file.

### Example on the main directory
```php
<?php
// docs/pages.php

return [
    'my-first-page.md',
    'my-second-page.md',
];
```

### Example on a subdirectory
```php
<?php
// docs/bar/pages.php

return [
    'my-first-subdirectory-page.md',
    'my-second-subdirectory-page.md',
];
```

### Note
When a page is not on your custom list, it is placed after those on your `pages.php`.

## Adding icons

You can customize icons on the menu with the same `pages.php` you use to sort your pages into a directory.
Just add the attributes to set your icon

### Example
```php
<?php
// docs/pages.php

return [
    'chart.md' => [
        'icon' => ['data-feather' => 'bar-chart']
    ],
];
```

Then the following template will be added to your menu.

```html
<span data-feather="bar-chart"></span>
```

By default, [Feather icons](https://feathericons.com/) is added to the layout.
But you can also use the icons you want.
See the [Customizing templates](customizing-templates.md) to add stylesheets and scripts for your icon package.

### Example with Font-awesome
```php
<?php
// docs/pages.php

return [
    'cookbook.md' => [
        'icon' => ['class' => 'fas fa-book']
    ],
];
```

Then the following template will be added to your menu.

```html
<span class="fas fa-book"></span>
```
