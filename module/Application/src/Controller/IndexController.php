<?php

/**
 * @see       https://github.com/laminas/laminas-mvc-skeleton for the canonical source repository
 * @copyright https://github.com/laminas/laminas-mvc-skeleton/blob/master/COPYRIGHT.md
 * @license   https://github.com/laminas/laminas-mvc-skeleton/blob/master/LICENSE.md New BSD License
 */

declare(strict_types=1);

namespace Application\Controller;

use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;
use Laminas\View\Model\JsonModel;

class IndexController extends AbstractActionController
{
    public function indexAction()
    {
        return new ViewModel();
    }

    public function fetchAction()
    {
        return new JsonModel([
            'schema' => $this->params('schema'),
            'method' => 'fetch',
        ]);
    }

    public function createAction()
    {
        return new JsonModel([
            'schema' => $this->params('schema'),
            'method' => 'post',
        ]);
    }

    public function findAction()
    {
        return new JsonModel([
            'schema' => $this->params('schema'),
            'id'     => $this->params('id'),
            'method' => 'find',
        ]);
    }

    public function replaceAction()
    {
        return new JsonModel([
            'schema' => $this->params('schema'),
            'id'     => $this->params('id'),
            'method' => 'replace',
        ]);
    }

    public function deleteAction()
    {
        return new JsonModel([
            'schema' => $this->params('schema'),
            'id'     => $this->params('id'),
            'method' => 'delete',
        ]);
    }
}
