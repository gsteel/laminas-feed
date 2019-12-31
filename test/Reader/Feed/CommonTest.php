<?php

/**
 * @see       https://github.com/laminas/laminas-feed for the canonical source repository
 * @copyright https://github.com/laminas/laminas-feed/blob/master/COPYRIGHT.md
 * @license   https://github.com/laminas/laminas-feed/blob/master/LICENSE.md New BSD License
 */

namespace LaminasTest\Feed\Reader\Feed;

use Laminas\Feed\Reader;

/**
* @group Laminas_Feed
* @group Reader\Reader
*/
class CommonTest extends \PHPUnit_Framework_TestCase
{

    protected $feedSamplePath = null;

    public function setup()
    {
        Reader\Reader::reset();
        $this->feedSamplePath = dirname(__FILE__) . '/_files/Common';
    }

    /**
     * Check DOM Retrieval and Information Methods
     */
    public function testGetsDomDocumentObject()
    {
        $feed = Reader\Reader::importString(
            file_get_contents($this->feedSamplePath.'/atom.xml')
        );
        $this->assertTrue($feed->getDomDocument() instanceof \DOMDocument);
    }

    public function testGetsDomXpathObject()
    {
        $feed = Reader\Reader::importString(
            file_get_contents($this->feedSamplePath.'/atom.xml')
        );
        $this->assertTrue($feed->getXpath() instanceof \DOMXPath);
    }

    public function testGetsXpathPrefixString()
    {
        $feed = Reader\Reader::importString(
            file_get_contents($this->feedSamplePath.'/atom.xml')
        );
        $this->assertTrue($feed->getXpathPrefix() == '/atom:feed');
    }

    public function testGetsDomElementObject()
    {
        $feed = Reader\Reader::importString(
            file_get_contents($this->feedSamplePath.'/atom.xml')
        );
        $this->assertTrue($feed->getElement() instanceof \DOMElement);
    }

    public function testSaveXmlOutputsXmlStringForFeed()
    {
        $feed = Reader\Reader::importString(
            file_get_contents($this->feedSamplePath.'/atom.xml')
        );
        $expected = file_get_contents($this->feedSamplePath.'/atom_rewrittenbydom.xml');
        $expected = str_replace("\r\n", "\n", $expected);
        $this->assertEquals($expected, $feed->saveXml());
    }

    public function testGetsNamedExtension()
    {
        $feed = Reader\Reader::importString(
            file_get_contents($this->feedSamplePath.'/atom.xml')
        );
        $this->assertTrue($feed->getExtension('Atom') instanceof Reader\Extension\Atom\Feed);
    }

    public function testReturnsNullIfExtensionDoesNotExist()
    {
        $feed = Reader\Reader::importString(
            file_get_contents($this->feedSamplePath.'/atom.xml')
        );
        $this->assertEquals(null, $feed->getExtension('Foo'));
    }

    /**
     * @group Laminas-8213
     */
    public function testReturnsEncodingOfFeed()
    {
        $feed = Reader\Reader::importString(
            file_get_contents($this->feedSamplePath.'/atom.xml')
        );
        $this->assertEquals('UTF-8', $feed->getEncoding());
    }

    /**
     * @group Laminas-8213
     */
    public function testReturnsEncodingOfFeedAsUtf8IfUndefined()
    {
        $feed = Reader\Reader::importString(
            file_get_contents($this->feedSamplePath.'/atom_noencodingdefined.xml')
        );
        $this->assertEquals('UTF-8', $feed->getEncoding());
    }


}
