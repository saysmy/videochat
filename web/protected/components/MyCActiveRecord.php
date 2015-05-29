<?php
class MyCActiveRecord extends CActiveRecord {

    protected $defaultColumnValues = array();

    public function insert($attributes=null) {

        foreach($this->getAttributes() as $columnName => $columnValue) {
            if ($columnValue === null && isset($this->defaultColumnValues[$columnName])) {
                $this->$columnName = $this->defaultColumnValues[$columnName];
            }
        }

        return parent::insert($attributes);

    }

    public function getSingleErrorMsg() {
        return current(current($this->getErrors()));
    }

}