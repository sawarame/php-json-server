<?php

declare(strict_types=1);

namespace Application\Controller;

use Laminas\Mvc\Controller\AbstractRestfulController;
use Laminas\View\Model\JsonModel;
use Laminas\Http\Request as HttpRequest;
use Laminas\Http\PhpEnvironment\Response as HttpResponse;
use Laminas\Http\Headers;
use Domain\Service\MainService;

class MainController extends AbstractRestfulController
{
    /**
     * Constructor.
     */
    public function __construct(
        MainService $service
    ) {
        $this->service = $service;
    }

    public function create($data)
    {
        $id = $this->service->insert(
            $this->params('schema'),
            $data
        );
        return new JsonModel($this->service->find(
            $this->params('schema'),
            $id
        ));
    }

    public function delete($id)
    {
        $id = intval($id);
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

    public function deleteList($data)
    {
        $this->getResponse()->setStatusCode(405);

        return new JsonModel([
            'content' => 'Method Not Allowed',
        ]);
    }

    public function get($id)
    {
        return new JsonModel($this->service->find(
            $this->params('schema'),
            (int)$this->params('id')
        ));
    }

    public function getList()
    {
        $result = $this->service->read(
            $this->params('schema'),
            $this->params()->fromQuery()
        );
        $this->getResponse()->setHeaders(Headers::fromString(
            'Rest-Api-Total: ' . $result['total'] . "\r\n" .
            'Rest-Api-pages: ' . $result['pages'] . "\r\n" .
            'Rest-Api-Rows: ' . $result['rows']
        ));
        return new JsonModel($result['data']);
    }

    public function head($id = null)
    {
        $this->getResponse()->setStatusCode(405);

        return new JsonModel([
            'content' => 'Method Not Allowed',
        ]);
    }

    public function options()
    {
        $this->getResponse()->setStatusCode(405);

        return new JsonModel([
            'content' => 'Method Not Allowed',
        ]);
    }

    public function patch($id, $data)
    {
        $this->getResponse()->setStatusCode(405);

        return new JsonModel([
            'content' => 'Method Not Allowed',
        ]);
    }

    public function replaceList($data)
    {
        $this->getResponse()->setStatusCode(405);

        return new JsonModel([
            'content' => 'Method Not Allowed',
        ]);
    }

    public function patchList($data)
    {
        $this->getResponse()->setStatusCode(405);

        return new JsonModel([
            'content' => 'Method Not Allowed',
        ]);
    }

    public function update($id, $data)
    {
        $data['id'] = intval($id);
        $this->service->update(
            $this->params('schema'),
            $data
        );
        return new JsonModel($this->service->find(
            $this->params('schema'),
            $data['id']
        ));
    }

    public function notFoundAction()
    {
        $this->getResponse()->setStatusCode(404);

        return new JsonModel([
            'content' => 'Page not found',
        ]);
    }

    public function getRequest(): HttpRequest
    {
        return parent::getRequest();
    }

    public function getResponse(): HttpResponse
    {
        return parent::getResponse();
    }
}
