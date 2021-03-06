<?php
/**
 * This file is part of the QA-Tools library.
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 *
 * @copyright Alexander Obuhovich <aik.bold@gmail.com>
 * @link      https://github.com/qa-tools/qa-tools
 */

namespace tests\QATools\QATools\PageObject\Annotation;


use QATools\QATools\PageObject\Annotation\FindByAnnotation;

class FindByAnnotationTest extends \PHPUnit_Framework_TestCase
{

	/**
	 * @dataProvider selectorDataProvider
	 */
	public function testDirectSelector($property_name)
	{
		$annotation = new FindByAnnotation();
		$annotation->$property_name = 'test';

		$this->assertEquals(array($property_name => 'test'), $annotation->getSelector());
	}

	/**
	 * @dataProvider selectorDataProvider
	 */
	public function testHowAndUsingSelector($property_name)
	{
		$annotation = new FindByAnnotation();
		$annotation->how = $property_name;
		$annotation->using = 'test';

		$this->assertEquals(array($property_name => 'test'), $annotation->getSelector());
	}

	/**
	 * Provides test data for direct property assignment test.
	 *
	 * @return array
	 */
	public function selectorDataProvider()
	{
		return array(
			array('className'),
			array('css'),
			array('id'),
			array('linkText'),
			array('name'),
			array('partialLinkText'),
			array('tagName'),
			array('xpath'),
		);
	}

	/**
	 * @expectedException \QATools\QATools\PageObject\Exception\AnnotationException
	 * @expectedExceptionCode \QATools\QATools\PageObject\Exception\AnnotationException::TYPE_INCORRECT_USAGE
	 */
	public function testUnknownDirectSelector()
	{
		$annotation = new FindByAnnotation();
		$annotation->getSelector();
	}

	/**
	 * @expectedException \QATools\QATools\PageObject\Exception\AnnotationException
	 * @expectedExceptionCode \QATools\QATools\PageObject\Exception\AnnotationException::TYPE_INCORRECT_USAGE
	 */
	public function testUnknownHowSelector()
	{
		$annotation = new FindByAnnotation();
		$annotation->how = 'wrong';
		$annotation->using = 'test';

		$annotation->getSelector();
	}

}
