<?php

namespace Kanboard\Plugin\VisualBlocking;

use Kanboard\Core\Plugin\Base;
use Kanboard\Core\Translator;

use Kanboard\Plugin\VisualBlocking\Filter\Blocked;

class Plugin extends Base
{
		public function initialize(){

        $blockHelper;

		$this->hook->on('template:layout:css', array('template' => 'plugins/VisualBlocking/css/style.css'));

		//Task Filter
		$this->container->extend('taskLexer', function($taskLexer, $c) {
            global $blockHelper;
            $blockHelper = $c['db'];
			$taskLexer->withFilter(Blocked::getInstance()->setCurrentUserId($c['userSession']->getId())->setDatabase($c['db']));
			return $taskLexer;
		});

        //Lock icon on task card
        //$this->template->hook->attach('template:board:public:task:before-title', 'VisualBlocking:lock');
        $this->template->hook->attachCallable('template:board:private:task:before-title', 'VisualBlocking:lock',function(){
          global $blockHelper;
          return ['database'=>$blockHelper];
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

