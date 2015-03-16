<?php
class MobileForm extends CFormModel {
    public $mobile;
    public function rules() {
        return array(
            array('mobile', 'ext.CMobileValidator'),
        );
    }

}