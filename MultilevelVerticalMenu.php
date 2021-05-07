<?php

/**
 * @copyright Copyright &copy; Marc Oliveras, 2015
 * @package yii2-multilevel-vertical-menu
 * @version 1.0  
 */

namespace host33\multilevelverticalmenu;

use Yii;
use yii\web\View;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\base\InvalidConfigException;
use yii\base\Widget;

/**
 * A multilevel vertical menu extension. SMenu based.
 * 
 * @see https://github.com/host33/yii2-multilevel-vertical-menu
 * @author Marc Oliveras http://www.oligalma.com
 * @link http://tympanus.net/codrops/2013/04/19/responsive-multi-level-menu
 * @since 1.0
 */
class MultilevelVerticalMenu extends Widget {
	/**
	 * The transition effect. To choose between 1,2,3,4 and 5.
	 * @var integer
	 */
	public $transition;

	/**
	 * The menu items' data
	 * @var array
	 */
	private $_menu;

	/**
	 * The html output of the widget
	 * @var String
	 */
	private $_html;
	/**
	 * The assets url
	 * @var String
	 */
	private $_baseUrl;

	/**
	 * Gets the html output of the widget
	 * @return String
	 */
	public function getHtml() {
		return $this -> _html;
	}

	/**
	 * Sets the menu data
	 * @param array $menu
	 *
	 */
	public function setMenu($menu) {
		if (is_array($menu)) {
			$this -> _menu = $menu;
		} else {
			throw new CException('Menu must be an array');
		}
	}

	/**
	 * Execute the widget
	 */
	public function run() {
		if (empty($this->_menu) || !is_array($this->_menu)) {
			 throw new InvalidConfigException("Menu is not set or it's empty.");
		}
				
		$this -> registerClientScripts();
		$this -> createMarkup();
	}

	/**
	 * Registers the clientside widget files (css & js)
	 */
	public function registerClientScripts() {
		$resources = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'assets';
		$this -> _baseUrl = Yii::$app->getAssetManager()->publish($resources);
		$this->getView()->registerJsFile($this -> _baseUrl[1] . '/jquery.dlmenu.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
		$this->getView()->registerJsFile($this -> _baseUrl[1] . '/modernizr.custom.js', ['position' => View::POS_HEAD]);
		$this->getView()->registerJs('
	    $(\'#dl-menu\').dlmenu({
	        animationClasses : { classin : \'dl-animate-in-' . $this -> transition . '\', classout : \'dl-animate-out-' . $this -> transition . '\' }
	    });
		', View::POS_END, 'menuscript');
		$this->getView()->registerCssFile($this -> _baseUrl[1] . '/component.css', [], 'vertical-menu-css');
	}

	/**
	 * Creates the html markup needed by the widget
	 */
	public function createMarkUp() {
		$this -> _html = '<div class="dl-container"><div id="dl-menu" class="dl-menuwrapper">';
		$this -> _html .= '<ul class="dl-menu">';
		$this -> _createMenu($this -> _menu);
		$this -> _html .= '</ul>';
		$this -> _html .= '</div></div>';

		echo $this -> _html;
	}

	/**
	 * Creates the menu unordered list
	 * @param array $menu : The menu array
	 * @param if we're on a sub menu or not $rec
	 */
	private function _createMenu($menu, $sub = false) {
		if (is_array($menu)) {
			foreach ($menu as $data) {
				isset($data['disabled']) ? $disabled = true : $disabled = false;
				isset($data['url']['params']) ? $params = $data['url']['params'] : $params = array();
				isset($data['url']['htmlOptions']) ? $htmlOptions = $data['url']['htmlOptions'] : $htmlOptions = array();
				isset($data['label']) ? $label = $data['label'] : $label = '';
				if ($this -> _isMenuItem($data)) {
					$url = $this -> _createUrl($data);
					if (!$this -> hasChild($data)) {
						$this -> _html .= "<li>";
						$this -> _html .= Html::a($label, $url, $htmlOptions);
						$this -> _html .= "</li>\n";
					} else {
						$this -> _html .= "<li>";
						$this -> _html .= Html::a($label, $url, $htmlOptions);
						$this -> _html .= "<ul class=\"dl-submenu\">\n";
						$this -> _html .= $this -> _createMenu($data, true);
						$this -> _html .= "</ul>\n";
					}
				}
			}
		}
	}

	/**
	 * Checks if there's a menu item to display
	 * $data must be an array with a label key
	 * and if the key visible is set it must be true
	 * @param array $data
	 * @return true if there's a menu item
	 */
	private function _isMenuItem($data) {
		isset($data['label']) ? $label = $data['label'] : $label = '';
		if (is_array($data) && $label && (!isset($data['visible']) || $data['visible'])) {
			return true;
		}

		return false;
	}

	/**
	 * Create the url link
	 * @param array $data
	 */
	private function _createUrl($data) {
		isset($data['url']['route']) ? $route = $data['url']['route'] : $route = '';
		isset($data['disabled']) ? $disabled = $data['disabled'] : $disabled = '';
		isset($data['url']['params']) ? $params = $data['url']['params'] : $params = array();
		isset($data['url']['link']) ? $link = $data['url']['link'] : $link = '';
		if (($route != '' || $data['url'] != array()) && !$disabled) {
			if ($route) {
				$array = array();
				$array[] = $route;
				$url = Url::to(array_merge($array, $params));
			} else {
				$url = $link;
			}
		} else {
			$url = null;
		}

		return $url;
	}

	/**
	 * Checks if this menu array has a submenu
	 * @param array $arr
	 * @return true if there's a submenu
	 */
	private function hasChild($arr) {
		if (!is_array($arr)) {
			return false;
		}
		foreach ($arr as $title => $value) {
			if (!$title == 'url') {
				if (is_array($value)) {
					return true;
				}
			}
		}
		return false;
	}

	private function set($param) {
		isset($param) ? $param = $param : $param = '';
	}

}
