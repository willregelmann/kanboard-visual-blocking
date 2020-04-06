<?php

namespace Kanboard\Plugin\VisualBlocking;

use Kanboard\Core\Plugin\Base;
use Kanboard\Core\Translator;

class Plugin extends Base
{
    public function initialize()
    {
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

