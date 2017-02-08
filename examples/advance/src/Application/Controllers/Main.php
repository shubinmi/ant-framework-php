<?php

namespace AntExample\Application\Controllers;

use AntExample\Application\Stories\MainStory;
use AntExample\Common\Factories\CoreController;

class Main extends CoreController
{
    /**
     * @var MainStory
     */
    private $mainStory;

    public function init()
    {
        $this->mainStory = new MainStory($this->getDi());
    }

    public function mainAction()
    {
        $name = $this->getRequestUriParam('name');

        if ($this->mainStory->isUserAuthSuccess()) {
            $this->mainStory->rewriteUserName($name);
        } else {
            $this->mainStory->createUser($name);
        }

        $elements = [
            // It means that {{body}} at layout.phtml (and at other view elements) will be
            // replaced to content from main.phtml
            'body' => [
                'path' => __DIR__ . '/../Views/main.phtml',
                'vars' => [
                    'name'  => $name,
                    'error' => $this->mainStory->getError(),
                    'log'   => $this->mainStory->getLog()
                ]
            ]
        ];

        return $this->getView()->addLayoutElements($elements);
    }
}