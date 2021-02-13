<?php

/**
 * @see       https://github.com/sawarame/php-json-server for the canonical source repository
 * @copyright https://github.com/sawarame/php-json-server/blob/master/COPYRIGHT.md
 * @license   https://github.com/sawarame/php-json-server/blob/master/LICENSE.md New BSD License
 */

declare(strict_types=1);

namespace Application\Controller;

use Laminas\Mvc\Controller\AbstractRestfulController;
use Laminas\View\Model\JsonModel;
use Laminas\Http\Request as HttpRequest;
use Laminas\Http\PhpEnvironment\Response as HttpResponse;
use Laminas\Http\Headers;
use Domain\Service\DataService;

class MainController extends AbstractRestfulController
{

    /**
     *
     * @var DataService
     */
    private $dataService = null;

    /**
     * Constructor.
     */
    public function __construct(
        DataService $dataService
    ) {
        $this->dataService = $dataService;
    }

    public function create($data)
    {
        return new JsonModel($this->dataService->insert(
            $this->params('schema'),
            $data
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
        return new JsonModel(parent::deleteList($data));
    }

    public function get($id)
    {
        return new JsonModel($this->dataService->find(
            $this->params('schema'),
            intval($id)
        ));
    }

    public function getList()
    {
        $result = $this->dataService->read(
            $this->params('schema'),
            $this->params()->fromQuery()
        );
        $this->getResponse()->setHeaders(Headers::fromString(
            'PJS-Total: ' . $result['total'] . "\r\n" .
            'PJS-pages: ' . $result['pages'] . "\r\n" .
            'PJS-Rows: ' . $result['results']
        ));
        return new JsonModel($result['data']);
    }

    public function head($id = null)
    {
        return new JsonModel(parent::head($id));
    }

    public function options()
    {
        return new JsonModel(parent::options());
    }

    public function patch($id, $data)
    {
        return new JsonModel(parent::patch($id, $data));
    }

    public function replaceList($data)
    {
        return new JsonModel(parent::replaceList($data));
    }

    public function patchList($data)
    {
        return new JsonModel(parent::patchList($data));
    }

    public function update($id, $data)
    {
        $data['id'] = intval($id);
        return new JsonModel($this->dataService->update(
            $this->params('schema'),
            $data
        ));
    }

    public function notFoundAction()
    {
        return new JsonModel(parent::notFoundAction());
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
