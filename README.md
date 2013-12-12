PHP Html Parser
==========================

Version 1.6.0

PHPHtmlParser is a simple, flexible, html parser which allows you to select tags using any css selector, like jQuery. The goal is to assiste in the development of tools which require a quick, easy way to scrap html, whether it's valid or not! This project was original supported by [sunra/php-simple-html-dom-parser](https://github.com/sunra/php-simple-html-dom-parser) but the support seems to have stopped so this project is my adaptation of his previous work.

Install
-------

This package can be found on [packagist](https://packagist.org/packages/paquettg/php-html-parser) and is best loaded using [composer](http://getcomposer.org/). It does require php 5.4 or higher, so keep that in consideration. 

Usage
-----

You can find many examples of how to use the dom parser and any of its parts (which you will most likely never touch) in the tests directory. The tests are done using PHPUnit and are very small, a few lines each, and are a great place to start. Given that, I'll still be showing a few examples of how the package should be used. The following example is a very simplistic usage of the package.

```php
use PHPHtmlParser\Dom;

$dom = new Dom;
$dom->load('<div class="all"><p>Hey bro, <a href="google.com">click here</a><br /> :)</p></div>');
$a = $dom->find('a')[0];
echo $a->text; // "click here"
```

The above will output "click here". Simple no? There are many ways to get the same result from the dome, such as $dom->getElementsbyTag('a')[0] or $dom->find('a', 0) which can all be found in the tests or in the code itself.

Example With Files
------------------

You may also seamlessly load a file into the dom instead of a string, which is much more convinient and is how I except most developers will be loading the html. The following example is taken from our test and uses the "big.html" file found there.

```php
use PHPHtmlParser\Dom;

$dom = new Dom;
$dom->loadFromFile('tests/big.html');
$contents = $dom->find('.content-border');
echo count($contents); // 10

foreach ($contents as $content)
{
	// get the class attr
	$class = $content->getAttribute('class');
	
	// do something with the html
	$html = $content->innerHtml;

	// or refine the find some more
	$child   = $content->firstChild();
	$sibling = $child->nextSibling();
}
```

This example loads the html from big.html, a real page found online, and gets all the content-border classes to process. It also shows a few things you can do with a node but it is not an exhaustive list of methods that a node has avaiable.
