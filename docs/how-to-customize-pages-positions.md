# How to customize positions of your pages

You can customize pages into a directory. Add a `pages.php` in this directory and just return a list of files.
This will apply the position you choose in that file.

## Example on the main directory
```php
<?php
// docs/pages.php

return [
    'my-first-page.md',
    'my-second-page.md',
];
```

## Example on a subdirectory
```php
<?php
// docs/bar/pages.php

return [
    'my-first-subdirectory-page.md',
    'my-second-subdirectory-page.md',
];
```

## Note
When a page is not on your custom list, it is placed after those on your `pages.php`.
