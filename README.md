
# Nova Grid Layout

Tool responsible for allowing changing the sizes of fields. Inpired by codenco-dev/nova-grid-system


## Author

- [@felipereisdev](https://www.github.com/felipereisdev)


## Requirements

- PHP 8.0+

- Laravel Nova 4+

## Install

Install with composer

```bash
  composer require freis/nova-grid-layout
```

## Usage
In NovaServiceProvider.php, method tools(), add:

```php
new Freis\NovaGridLayout\NovaGridLayout
```

In resource:
```php
  Text::make('Email')
    ->stacked() // prefer stacked
    ->size('w-1/2') // inform the tailwind width class
    ->sortable()
```


## Licença

[MIT](https://choosealicense.com/licenses/mit/)

