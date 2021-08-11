# PHP-WordWrap
![GitHub](https://img.shields.io/github/license/kayw-geek/php-wordwrap)![php-standard-style](https://img.shields.io/badge/code%20style-standard-brightgreen.svg)![GitHub top language](https://img.shields.io/github/languages/top/kayw-geek/php-wordwrap)

Word wrapping, with a few features.

- force-break option
- wraps hypenated words
- multilingual - wraps any language that uses whitespace for word separation.
- custom symbol wrap mode
- chain call
- multi-format return

## Install

 ```shell
composer require kayw-geek/php-wordwrap
 ```

## Synopsis

Wrap some text in a 20 character column.

```php
> $wrap = new \KaywGeek\WordWrap();

> $text = "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.";

> $result = $wrap->text($text)->width(20)->wrap();
```

`result` now looks like this:
```
Lorem ipsum dolor
sit amet,
consectetur
adipiscing elit, sed
do eiusmod tempor
incididunt ut labore
et dolore magna
aliqua.
```

By default, long words will not break. Unless you set the `break` option.
```php
> $text = "https://github.com/kayw-geek/php-wordwrap"

> $wrap->text($text)->width(28)->break(false)->wrap();
  https://github.com/kayw-geek/php-wordwrap

> $wrap->text($text)->width(28)->break()->wrap();
  https://github.com/kayw-geek
  /php-wordwrap
```

Punctuation wrap mode

```php
> $text = "Of course,the first example appears to be the nicest one (or perhaps the fourth),but you may find that being able to use empty expressions in for loops comes in handy in many occasions.";


> $wrap->text($text)->lfEnable()->wrap();
```

`result`

```
Of course,
the first example appears to be the nicest one (or perhaps the fourth),
but you may find that being able to use empty expressions in for loops comes in handy in many occasions.
```

Format data

```php
> $text = "Of course,the first example appears to be the nicest one (or perhaps the fourth),but you may find that being able to use empty expressions in for loops comes in handy in many occasions.";

/**
* Format List
* \KaywGeek\WordWrap::FORMAT_JSON
* \KaywGeek\WordWrap::FORMAT_STRING
* \KaywGeek\WordWrap::FORMAT_ARRAY
*/
> $wrap->text($text)
    ->lfEnable()
    ->responseFormat(\KaywGeek\WordWrap::FORMAT_JSON)
    ->wrap();
```

## Inspiration

[wordwrapjs](https://github.com/75lb/wordwrapjs)