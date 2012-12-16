<?php
namespace Api\Mvc\Controller;

use Zend\Mvc\Controller\AbstractRestfulController,
    Zend\Stdlib\RequestInterface as Request,
    Zend\Json\Json,
    Zend\Mvc\MvcEvent;

class RestfulController extends AbstractRestfulController
{

    /**
     * Return list of resources
     *
     * @return mixed
     */
    public function getList()
    {
        return parent::getList();
    }

    /**
     * Return single resource
     *
     * @param  mixed $id
     * @return mixed
     */
    public function get($id)
    {
        return parent::get($id);
    }

    /**
     * Create a new resource
     *
     * @param  mixed $data
     * @return mixed
     */
    public function create($data)
    {
        return parent::create($data);
    }

    /**
     * Update an existing resource
     *
     * @param  mixed $id
     * @param  mixed $data
     * @return mixed
     */
    public function update($id, $data)
    {
        return parent::update($id, $data);
    }

    /**
     * Delete an existing resource
     *
     * @param  mixed $id
     * @return mixed
     */
    public function delete($id)
    {
        return parent::delete($id);
    }


    /**
     * Process post data and call create
     *
     * @param Request $request
     * @return mixed
     */
    public function processPostData(Request $request)
    {
        $contentType = $request->getHeaders('Content-Type')->getFieldValue();
        if ($contentType == 'application/json')
            return $this->create(Json::decode($request->getContent(), Json::TYPE_ARRAY));

        return $this->create($request->getPost()->toArray());
    }

    /**
     * Process put data and call update
     *
     * @param Request $request
     * @param $routeMatch
     * @return mixed
     * @throws Exception\DomainException
     */
    public function processPutData(Request $request, $routeMatch)
    {
        if (null === $id = $routeMatch->getParam('id')) {
            if (!($id = $request->getQuery()->get('id', false))) {
                throw new Exception\DomainException('Missing identifier');
            }
        }

        $contentType = $request->getHeaders('Content-Type')->getFieldValue();
        $content = $request->getContent();
        if ($contentType == 'application/json')
            $parsedParams = Json::decode($content, Json::TYPE_ARRAY);
        else
            parse_str($content, $parsedParams);

        return $this->update($id, $parsedParams);
    }
}
