<?php
/**
 * 所有视图的基类
 * @category   H2O
 * @package    base
 * @author     Xujinzhang <xjz1688@163.com>
 * @version    0.1.0
 */
namespace H2O\base;
use H2O;
class View
{
	/**
	 * @var string 模板依耐的控制器
	 */
	private $_controller;
	/**
	 * @var string 模板目录
	 */
	private $_templatePath;
	/**
	 * @var string 模板文件
	 */
	private $_templateFile;
	/**
	 * @var string 主操作模块内容
	 */
	private $_content;
	/**
	 * 设置模板文件
	 * @param string $tpl 文件名，注意不用写文件后缀名，默认后缀名为.php
	 */
	public function setFile($tpl)
	{
		$this->_templateFile = $tpl;
	}
	/**
	 * 设置依耐控制器
	 * @param object $o 控制器对象
	 */
	public function setController($o)
	{
		$this->_controller = $o;
	}
	/**
	 * @return Object 返回当前的控制器对象
	 */
	public function getController()
	{
		return $this->_controller;
	}
	/**
	 * 设置模板目录
	 * @param string $path 模板目录
	 */
	public function setPath($path)
	{
		$path = \H2O::getAlias($path);
		$this->_templatePath = $path;
	}
	/**
	 * 返回模板目录
	 */
	public function getPath()
	{
		return rtrim($this->_templatePath,DS);
	}
	/**
	 * 检查文件是否存在
	 * @param string $tpl 模板文件
	 * @throws Exception
	 */
	private function _checkFile($tpl)
	{
		$tpl = \H2O::getAlias($tpl);
		if(!file_exists($tpl)){
			throw new \Exception($tpl.':template is not found!');
		}
	}
	/**
	 * 返回模板文件
	 */
	public function getFile()
	{
		return $this->getPath().DS.$this->_templateFile.'.php';
	}
	/**
	 * 设置主模块缓存
	 * @param string $content 主模块内容
	 */
	public function setContent($content)
	{
		$this->_content = $content;
	}
	/**
	 * 布局页面中显示主内容区
	 * @return string
	 */
	public function getContent()
	{
		echo $this->_content;
	}
	/**
	 * 返回包含模板
	 * @param string $url 例如 message.list
	 * @param string $namespace 命名空间
	 */
	public function loadModule($url,$namespace = '')
	{
		echo $this->_controller->loadModule($url,$namespace);
	}
	/**
	 * 模板解析和渲染
	 * @param array $vars 控制层需要传递给模板的变量
	 */
	public function render($vars)
	{
		$tpl = $this->getFile();
		$this->_checkFile($tpl);
		ob_start();
		foreach($vars as $k=>$v) $$k = $v; //设置模板变量
		include($tpl);
		$data = ob_get_contents();
		ob_end_clean();
		return $data;
	}
}
