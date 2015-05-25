<?php
class MyCActiveRecord extends CActiveRecord {

    protected $defaultColumnValues = array();

    public function __construct($scenario='insert') {
        parent::__construct($scenario);

        foreach($this->defaultColumnValues as $columnName => $columnDefaultValue) {
            $this->$columnName = null;
        }
    }


    public function insert($attributes=null) {

        foreach($this->getAttributes() as $columnName => $columnValue) {
            if ($columnValue === null && isset($this->defaultColumnValues[$columnName])) {
                $this->$columnName = $this->defaultColumnValues[$columnName];
            }
        }

        return parent::insert($attributes);

    }

}