<?php
/**
 * This file is part of the QA-Tools library.
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 *
 * @copyright Alexander Obuhovich <aik.bold@gmail.com>
 * @link      https://github.com/qa-tools/qa-tools
 */

namespace QATools\QATools\PageObject\Proxy;


use QATools\QATools\PageObject\Element\IWebElement;
use QATools\QATools\PageObject\ElementLocator\IElementLocator;
use QATools\QATools\PageObject\Element\WebElement;
use QATools\QATools\PageObject\IPageFactory;

/**
 * Class for lazy-proxy creation to ensure, that WebElements are really accessed only at moment, when user needs them.
 *
 * @method \Mockery\Expectation shouldReceive(string $name)
 *
 * @link http://bit.ly/14TbcR9
 */
class WebElementProxy extends AbstractProxy implements IWebElement
{

	/**
	 * Initializes proxy for WebElement.
	 *
	 * @param IElementLocator $locator      Element selector.
	 * @param IPageFactory    $page_factory Page factory.
	 */
	public function __construct(IElementLocator $locator, IPageFactory $page_factory = null)
	{
		$this->className = '\\QATools\\QATools\\PageObject\\Element\\WebElement';
		$this->elementClass = '\\QATools\\QATools\\PageObject\\Element\\IWebElement';

		parent::__construct($locator, $page_factory);
	}

	/**
	 * Returns class instance, that was placed inside a proxy.
	 *
	 * @return WebElement
	 */
	public function getObject()
	{
		if ( !$this->locatorUsed ) {
			// NodeElement + TargetElement(setContainer) = Proxy.
			$this->locatorUsed = true;
			/* @var $object IWebElement */

			if ( $this->isElementCollection() ) {
				$object = call_user_func(
					array($this->className, 'fromNodeElements'), $this->locateElements(), null, $this->pageFactory
				);
			}
			else {
				$object = call_user_func(
					array($this->className, 'fromNodeElement'), $this->locateElement(), $this->pageFactory
				);
			}

			$this[] = $object;
			$this->injectContainer();
		}

		return $this->getIterator()->current();
	}

}
