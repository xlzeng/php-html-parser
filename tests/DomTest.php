<?php

use PHPHtmlParser\Dom;

class DomTest extends PHPUnit_Framework_TestCase {

	public function testLoad()
	{
		$dom = new Dom;
		$dom->load('<div class="all"><p>Hey bro, <a href="google.com">click here</a><br /> :)</p></div>');
		$div = $dom->find('div', 0);
		$this->assertEquals('<div class="all"><p>Hey bro, <a href="google.com">click here</a><br /> :)</p></div>', $div->outerHtml);
	}

	public function testLoadSelfclosingAttr()
	{
		$dom = new Dom;
		$dom->load("<div class='all'><br  foo  bar  />baz</div>");
		$br = $dom->find('br', 0);
		$this->assertEquals('<br foo bar />', $br->outerHtml);
	}

	public function testLoadEscapeQuotes()
	{
		$dom = new Dom;
		$dom->load('<div class="all"><p>Hey bro, <a href="google.com" data-quote="\"">click here</a></p></div>');
		$div = $dom->find('div', 0);
		$this->assertEquals('<div class="all"><p>Hey bro, <a href="google.com" data-quote="\"">click here</a></p></div>', $div->outerHtml);
	}

	public function testLoadNoClosingTag()
	{
		$dom = new Dom;
		$dom->load('<div class="all"><p>Hey bro, <a href="google.com" data-quote="\"">click here</a></div><br />');
		$root = $dom->find('div', 0)->getParent();
		$this->assertEquals('<div class="all"><p>Hey bro, <a href="google.com" data-quote="\"">click here</a></p></div><br />', $root->outerHtml);
	}

	public function testLoadFromFile()
	{
		$dom = new Dom;
		$dom->loadFromFile('tests/small.html');
		$this->assertEquals('VonBurgermeister', $dom->find('.post-user font', 0)->text);
	}

	public function testLoadFromFileFind()
	{
		$dom = new Dom;
		$dom->loadFromFile('tests/small.html');
		$this->assertEquals('VonBurgermeister', $dom->find('.post-row div .post-user font', 0)->text);
	}

	public function testLoadUtf8()
	{
		$dom = new Dom;
		$dom->load('<p>Dzień</p>');
		$this->assertEquals('Dzień', $dom->find('p', 0)->text);
	}

	public function testLoadFileBig()
	{
		$dom = new Dom;
		$dom->loadFromFile('tests/big.html');
		$this->assertEquals(10, count($dom->find('.content-border')));
	}

	public function testToStringMagic()
	{
		$dom = new Dom;
		$dom->load('<div class="all"><p>Hey bro, <a href="google.com">click here</a><br /> :)</p></div>');
		$this->assertEquals('<div class="all"><p>Hey bro, <a href="google.com">click here</a><br /> :)</p></div>', (string) $dom);
	}

	public function testGetMagic()
	{
		$dom = new Dom;
		$dom->load('<div class="all"><p>Hey bro, <a href="google.com">click here</a><br /> :)</p></div>');
		$this->assertEquals('<div class="all"><p>Hey bro, <a href="google.com">click here</a><br /> :)</p></div>', $dom->innerHtml);
	}

	public function testFirstChild()
	{
		$dom = new Dom;
		$dom->load('<div class="all"><p>Hey bro, <a href="google.com" data-quote="\"">click here</a></div><br />');
		$this->assertEquals('<div class="all"><p>Hey bro, <a href="google.com" data-quote="\"">click here</a></p></div>', $dom->firstChild()->outerHtml);
	}

	public function testLastChild()
	{
		$dom = new Dom;
		$dom->load('<div class="all"><p>Hey bro, <a href="google.com" data-quote="\"">click here</a></div><br />');
		$this->assertEquals('<br />', $dom->lastChild()->outerHtml);
	}

	public function testGetElementById()
	{
		$dom = new Dom;
		$dom->load('<div class="all"><p>Hey bro, <a href="google.com" id="78">click here</a></div><br />');
		$this->assertEquals('<a href="google.com" id="78">click here</a>', $dom->getElementById('78')->outerHtml);
	}

	public function testGetElementsByTag()
	{
		$dom = new Dom;
		$dom->load('<div class="all"><p>Hey bro, <a href="google.com" id="78">click here</a></div><br />');
		$this->assertEquals('<p>Hey bro, <a href="google.com" id="78">click here</a></p>', $dom->getElementsByTag('p')[0]->outerHtml);
	}

	public function testGetElementsByClass()
	{
		$dom = new Dom;
		$dom->load('<div class="all"><p>Hey bro, <a href="google.com" id="78">click here</a></div><br />');
		$this->assertEquals('<p>Hey bro, <a href="google.com" id="78">click here</a></p>', $dom->getElementsByClass('all')[0]->innerHtml);
	}
}
