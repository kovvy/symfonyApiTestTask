<?php

namespace ApiBundle\Repository;


class RequestRepository extends \Doctrine\ORM\EntityRepository
{

    public function find($id, $lockMode = null, $lockVersion = null)
    {
        return $this->iterator(parent::find($id, $lockMode, $lockVersion));
    }

    public function findAll()
    {
        $records = array();

        foreach (parent::findAll() as $record) {
            $records[] = $this->iterator($record);
        }

        return $records;
    }

    public function getRecord($records)
    {
        foreach ($records as $record) {
            return $this->iterator($record);
        }
    }

    private function iterator($record)
    {
        $array = array();
        $module = new $this->_entityName;

        foreach ($module->getAttributes() as $attribute) {
            $array[$attribute] = $record->$attribute;
        }

        return $array;
    }
}
