<?php
namespace Api\Controller;

use Api\Mvc\Controller\RestfulController,
    Zend\View\Model\JsonModel,
    Zend\Json\Json,
    Api\Model\Book;

class BookController extends RestfulController
{
    protected $bookTable;

    public function get($id)
    {
        try {
            $book = $this->getBookTable()->find($id);
    	    return new JsonModel(array('book' => $book->getArrayCopy()));
        } catch (\Exception $e) {
            $this->getResponse()->setStatusCode(404);
    	    return new JsonModel(array('message' => $e->getMessage()));
        }
    }

    public function getList()
    {
        $books = $this->getBookTable()->fetchAll()->toArray();
    	return new JsonModel(array(
                                   'books' => $books,
                                   '_metadata' => array('count' => count($books))
                                   )
                                );
    }

    public function create($data)
    {
        //$data = Json::decode($this->getRequest()->getContent(), Json::TYPE_ARRAY);
        //print_r($data);
        //exit;
        $book = new Book();
        $book->exchangeArray($data);
        try {
            $this->getBookTable()->save($book);
            $this->getResponse()->setStatusCode(201);
    	    return new JsonModel(array('book' => $data));
        } catch (\Exception $e) {
            $this->getResponse()->setStatusCode(403);
    	    return new JsonModel(array('message' => $e->getMessage()));
        }
    }

    public function update($id, $data)
    {
        try {
            $book = $this->getBookTable()->find($id);
        } catch (\Exception $e) {
            $this->getResponse()->setStatusCode(404);
    	    return new JsonModel(array('message' => $e->getMessage()));
        }

        // new values
        $book->exchangeArray($data);
        try {
            $this->getBookTable()->save($book);
        } catch (\PDOException $e) {
            $this->getResponse()->setStatusCode(304);
    	    return new JsonModel(array('message' => $e->getMessage()));
        }

    	return new JsonModel(array('book' => $data));
    }

    public function delete($id)
    {
        try {
            $book = $this->getBookTable()->find($id);
        } catch (\Exception $e) {
            $this->getResponse()->setStatusCode(404);
    	    return new JsonModel(array('message' => $e->getMessage()));
        }

        try {
            $this->getBookTable()->remove($id);
        } catch (Exception $e) {
            $this->getResponse()->setStatusCode(304);
    	    return new JsonModel(array('message' => $e->getMessage()));
        }

    	return new JsonModel();
    }

	public function getBookTable()
    {
        if (!$this->bookTable) {
            $sm = $this->getServiceLocator();
            $this->bookTable = $sm->get('Api\Model\BookTable');
        }

        return $this->bookTable;
    }
}
