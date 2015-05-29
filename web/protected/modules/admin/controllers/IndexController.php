<?php
class IndexController extends CController {

    public $subTitle = '主页';

    public $layout = 'common';

    public function actionIndex() {
        $this->render('index');
    }

    public function actionTree() {
        echo json_encode(array(
                array(
                    'id' => '1', 'text' => '主播管理', 'children' => array(
                        array('id' => '2','text' => '新增主播', 'url' => '/moderator/addHome'),
                        array('id' => '3', 'text' => '已通过主播', 'url' => '/moderator/list'),
                    ),
                ),
                array('id' => '4', 'text' => '主播统计', 'name' => 'moderatorStatistics', 'url' => '/statistics/moderator')
            )
        );
    }
}