<?php

namespace Kanboard\Plugin\VisualBlocking;

use Kanboard\Core\Plugin\Base;
use Kanboard\Core\Translator;

use Kanboard\Plugin\VisualBlocking\Filter\Blocked;

class Plugin extends Base
{
		public function initialize(){

		//Task Filter
		$this->container->extend('taskLexer', function($taskLexer, $c) {
			$taskLexer->withFilter(Blocked::getInstance()->setCurrentUserId($c['userSession']->getId())->setDatabase($c['db']));
			return $taskLexer;
		});
	}

    public function onStartup()
    {
        Translator::load($this->languageModel->getCurrentLanguage(), __DIR__.'/Locale');
    }

    public function getPluginName()
    {
        return 'Visual Blocking';
    }

    public function getPluginDescription()
    {
        return t('Indicators for blocked tasks in board view');
    }

    public function getPluginAuthor()
    {
        return 'Will Regelmann';
    }

    public function getPluginVersion()
    {
        return '1.0.0';
    }

    public function getPluginHomepage()
    {
        return 'https://github.com/wregelmann/kanboard-visual-blocking';
    }
}

