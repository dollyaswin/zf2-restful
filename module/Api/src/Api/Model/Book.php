<?php
namespace Api\Model;

use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

class Book
{
    public $id;
    public $isbn;
    public $title;
    public $publisher;
    public $page;
    public $description;

    public function exchangeArray($data)
    {
    	$this->description = (isset($data['description'])) ? $data['description'] : null;
    	$this->publisher = (isset($data['publisher'])) ? $data['publisher'] : null;
    	$this->title = (isset($data['title'])) ? $data['title'] : null;
    	$this->isbn  = (isset($data['isbn'])) ? $data['isbn'] : null;
    	$this->page  = (isset($data['page'])) ? $data['page'] : null;
        $this->id = (isset($data['id'])) ? $data['id'] : $this->id;
    }
    
	public function getArrayCopy()
    {
        return get_object_vars($this);
    }
    
	public function setInputFilter(InputFilterInterface $inputFilter)
    {
        throw new \Exception("Not used");
    }

    public function getInputFilter()
    {
        if (!$this->inputFilter) {
            $inputFilter = new InputFilter();
            $factory     = new InputFactory();

            $inputFilter->add($factory->createInput(array(
                'name'     => 'id',
                'required' => true,
                'filters'  => array(
                    array('name' => 'Int'),
                ),
            )));

            $inputFilter->add($factory->createInput(array(
                'name'     => 'isbn',
                'required' => true,
                'filters'  => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                ),
                'validators' => array(
                    array('name'    => 'Isbn'),
                ),
            )));

            $inputFilter->add($factory->createInput(array(
                'name'     => 'publisher',
                'required' => true,
                'filters'  => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                ),
                'validators' => array(
                    array(
                        'name'    => 'StringLength',
                        'options' => array(
                            'encoding' => 'UTF-8',
                            'min'      => 1,
                            'max'      => 64,
                        ),
                    ),
                ),
            )));

            $inputFilter->add($factory->createInput(array(
                'name'     => 'title',
                'required' => true,
                'filters'  => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                ),
                'validators' => array(
                    array(
                        'name'    => 'StringLength',
                        'options' => array(
                            'encoding' => 'UTF-8',
                            'min'      => 1,
                            'max'      => 100,
                        ),
                    ),
                ),
            )));

            $inputFilter->add($factory->createInput(array(
                'name'     => 'page',
                'required' => true,
                'filters'  => array(
                    array('name' => 'Int'),
                ),
                'validators' => array(
                    array(
                        'name'    => 'GreaterThan',
                        'options' => array(
                            'min'      => 1,
                        ),
                    ),
                ),
            )));

            $this->inputFilter = $inputFilter;
        }

        return $this->inputFilter;
    }
}
