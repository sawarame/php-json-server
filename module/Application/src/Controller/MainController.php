<?php

declare(strict_types=1);

namespace Application\Controller;

use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\JsonModel;
use Domain\Service\MainService;

class MainController extends AbstractActionController
{
    /**
     * Constructor.
     */
    public function __construct(
        MainService $service
    ) {
        $this->service = $service;
    }

    public function fetchAction()
    {
        return new JsonModel($this->service->read(
            $this->params('schema'),
            []
        ));
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
