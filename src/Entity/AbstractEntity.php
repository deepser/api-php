<?php
/**
 * @copyright      Copyright (c) 2019
 */

namespace Deepser\Entity;

use Deepser\Deepser;
use Deepser\Framework\Data\Collection;

abstract class AbstractEntity extends \Deepser\Framework\DataObject
{
    /**
     * @var string
     */
    const ENDPOINT = '';

    /**
     * @var string
     */
    const MULTIPLE_ENDPOINT = '';

    /**
     * Name of object id field
     * @var string
     */
    protected $_idFieldName = 'entity_id';

    /**
     * @var bool
     */
    protected $_isObjectNew     = null;

    public function getEndpoint(){
        return trim(Deepser::getAdapter()->getHost(), '/') . static::ENDPOINT;
    }

    public function getMultipleEndpoint(){
        return trim(Deepser::getAdapter()->getHost(), '/') . static::MULTIPLE_ENDPOINT;
    }

    /**
     * Retrieve identifier field name for model
     *
     * @return string
     */
    public function getIdFieldName()
    {
        return $this->_idFieldName;
    }

    /**
     * Retrieve model object identifier
     *
     * @return mixed
     */
    public function getId()
    {
        $fieldName = $this->getIdFieldName();
        if ($fieldName) {
            return $this->_getData($fieldName);
        } else {
            return $this->_getData('id');
        }
    }

    public function isObjectNew($flag=null)
    {
        if ($flag !== null) {
            $this->_isObjectNew = $flag;
        }
        if ($this->_isObjectNew !== null) {
            return $this->_isObjectNew;
        }

        return !(bool)$this->getId();
    }

    /**
     * @param $id
     * @return $this
     */
    public function load($id, $field = null)
    {
        try{
            $response = Deepser::getAdapter()->get(
                sprintf('%s/%s/%s', $this->getEndpoint(), $id, $field)
            );

            $response = json_decode($response, true);
        }catch (\Exception $e){
            $response = [];
        }

        $this->addData($response);
        return $this;
    }

    /**
     * @param \Deepser\Entity\AbstractEntity $entity
     * @return $this
     */
    public function save(){
        if($this->isObjectNew()){
            $response = Deepser::getAdapter()->post(
                sprintf('%s', $this->getMultipleEndpoint()),
                $this->getData()
            );
        }else{
            $response = Deepser::getAdapter()->put(
                sprintf('%s/%d', $this->getEndpoint(), $this->getId()),
                $this->getData()
            );
        }

        $response = json_decode($response, true);

        $this->addData($response);
        return $this;
    }

    /**
     * @return $this
     */
    public function delete(){
        $response = Deepser::getAdapter()->delete(
            sprintf('%s/%d', $this->getEndpoint(), $this->getId())
        );

        return $this;
    }

    /**
     * @return Collection
     */
    public static function getCollection(){
        $collection = new Collection(get_called_class());
        return $collection;
    }

    /**
     * @param $id
     * @return Activity
     */
    public function loadActivity($id){
        $activity = $this->_createActivityEntity();
        $activity->load($id);
        return $activity;
    }

    /**
     * @return Activity
     */
    protected function _createActivityEntity(){
        $activity = new Activity();
        $activity->setEntity($this);
        return $activity;
    }

}
