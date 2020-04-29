<?php

declare(strict_types=1);

namespace Application\Controller;

use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\JsonModel;
use Laminas\Http\Request as HttpRequest;
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

    public function readAction()
    {
        return new JsonModel($this->service->read(
            $this->params('schema'),
            []
        ));
    }

    public function insertAction()
    {
        $id = $this->service->insert(
            $this->params('schema'),
            $this->params()->fromPost()
        );
        return new JsonModel($this->service->find(
            $this->params('schema'),
            $id
        ));
    }

    public function findAction()
    {
        return new JsonModel($this->service->find(
            $this->params('schema'),
            (int)$this->params('id')
        ));
    }

    public function updateAction()
    {
        $data = [];
        if ($this->getRequest()->isPost()) {
            $data = $this->params()->fromPost();
        }
        if ($this->getRequest()->isPut()) {
            parse_str(file_get_contents('php://input'), $data);
        }

        $data['id'] = (int)$this->params('id');
        $this->service->update(
            $this->params('schema'),
            $data
        );
        return new JsonModel($data);
    }

    public function deleteAction()
    {
        $id = (int)$this->params('id');
        $data = $this->service->find(
            $this->params('schema'),
            $id
        );
        $this->service->delete(
            $this->params('schema'),
            $id
        );
        return new JsonModel($data);
    }

    public function getRequest(): HttpRequest
    {
        return parent::getRequest();
    }
}
