<?php
class CMobileValidator extends CValidator {

    public $allowEmpty = false;

    private $preg = '/^[1][3-8]+\d{9}$/i';

    protected function validateAttribute($object, $attribute) {
        $mobile = $object->$attribute;
        if (!$mobile && $this->allowEmpty) {
            return;
        }
        if (!preg_match($this->preg, $mobile)) {
            $this->addError($object, $attribute, '手机号码格式不正确');
        }
    }
}