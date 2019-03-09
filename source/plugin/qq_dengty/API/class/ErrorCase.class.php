<?php
/* PHP SDK
 * @version 2.0.0
 * @author connect@qq.com
 * @copyright ? 2013, Tencent Corporation. All rights reserved.
 */

require_once(CLASS_PATH."Recorder.class.php");

/*
 * @brief ErrorCase�࣬����쳣
 * */
class ErrorCase{
    private $errorMsg;

    public function __construct(){
        $this->errorMsg = array(
            "20001" => "<h2>�����ļ��𻵻��޷���ȡ��������ִ��intall</h2>",
            "30001" => "<h2>The state does not match. You may be a victim of CSRF.</h2>",
            "50001" => "<h2>�����Ƿ������޷�����httpsЭ��</h2>����δ����curl֧��,�볢�Կ���curl֧�֣�����web�����������������δ���������ϵ����"
        );
    }

    /**
     * showError
     * ��ʾ������Ϣ
     * @param int $code    �������
     * @param string $description ������Ϣ����ѡ��
     */
    public function showError($code, $description = '$'){
        $recorder = new Recorder();
        /* if(! $recorder->readInc("errorReport")){
             die();//die quietly
         }*/


        echo "<meta charset=\"UTF-8\">";
        if($description == "$"){
            die($this->errorMsg[$code]);
        }else{
            echo "<h3>error:</h3>$code";
            echo "<h3>msg  :</h3>$description";
            exit();
        }
    }
    public function showTips($code, $description = '$'){
    }
}
