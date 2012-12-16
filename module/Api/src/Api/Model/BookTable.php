<?php
namespace Api\Model;

use Zend\Db\Adapter\Adapter,
    Zend\Db\ResultSet\ResultSet,
    Zend\Db\TableGateway\AbstractTableGateway,
    Api\Model\Book;

class BookTable extends AbstractTableGateway
{
    protected $table = 'book';

    public function __construct(Adapter $adapter)
    {
        $this->adapter = $adapter;
        $this->initialize();
    }

    public function fetchAll()
    {
        $resultSet = $this->select();
        return $resultSet;
    }

    public function find($id)
    {
        $id  = (int) $id;
        $rowset = $this->select(array('id' => $id));
        $row = $rowset->current();
        if (!$row) {
            throw new \Exception("Could not find book with id " . $id);
        }

        $book = new Book();
        $book->exchangeArray($row);
        return $book;
    }

    public function save(Book $book)
    {
        $data = array(
                      'description' => stripslashes($book->description),
                      'publisher' => stripslashes($book->publisher),
                      'title'  => stripslashes($book->title),
                      'page' => $book->page,
                      'isbn' => stripslashes($book->isbn),
                     );
        $id = (int) $book->id;
        if ($id == 0) {
            try {
                $this->insert($data);
            } catch (\Zend\Db\Adapter\Exception\InvalidQueryException $e) {
	            throw $e->getPrevious();
            }
        } else {
	        try {
                $this->update($data, array('id' => $id));
	        } catch (\Zend\Db\Adapter\Exception\InvalidQueryException $e) {
	            throw $e->getPrevious();
	        }
        }
    }

    public function remove($id)
    {
        $this->delete(array('id' => $id));
    }
}
