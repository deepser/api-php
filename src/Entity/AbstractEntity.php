<?php
/**
 * @copyright      Copyright (c) 2019
 */

namespace DeepDesk\Entity;

use DeepDesk\DeepDesk;
use DeepDesk\Framework\Data\Collection;

abstract class AbstractEntity extends \DeepDesk\Framework\DataObject
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
        return trim(DeepDesk::getAdapter()->getHost(), '/') . static::ENDPOINT;
    }

    public function getMultipleEndpoint(){
        return trim(DeepDesk::getAdapter()->getHost(), '/') . static::MULTIPLE_ENDPOINT;
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
            $response = DeepDesk::getAdapter()->get(
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
     * @param \DeepDesk\Entity\AbstractEntity $entity
     * @return $this
     */
    public function save(){
        if($this->isObjectNew()){
            $response = DeepDesk::getAdapter()->post(
                sprintf('%s', $this->getMultipleEndpoint()),
                $this->getData()
            );
        }else{
            $response = DeepDesk::getAdapter()->put(
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
        $response = DeepDesk::getAdapter()->delete(
            sprintf('%s/%d', $this->getEndpoint(), $this->getId())
        );

        return $this;
    }

    /**
     * @return Collection
     */
    public static function getCollection(){
        return new Collection(get_called_class());
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