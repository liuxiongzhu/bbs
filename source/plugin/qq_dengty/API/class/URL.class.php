<?php
/* PHP SDK
 * @version 2.0.0
 * @author connect@qq.com
 * @copyright ? 2013, Tencent Corporation. All rights reserved.
 */

require_once(CLASS_PATH."ErrorCase.class.php");

/*
 * @brief url��װ�࣬�����õ�url���������װ��һ��
 * */
class URL{
    private $error;

    public function __construct(){
        $this->error = new ErrorCase();
    }

    /**
     * combineURL
     * ƴ��url
     * @param string $baseURL   ���ڵ�url
     * @param array  $keysArr   �����б�����
     * @return string           ����ƴ�ӵ�url
     */
    public function combineURL($baseURL,$keysArr){
        $combined = $baseURL."?";
        $valueArr = array();

        foreach($keysArr as $key => $val){
            $valueArr[] = "$key=$val";
        }

        $keyStr = implode("&",$valueArr);
        $combined .= ($keyStr);

        return $combined;
    }

    /**
     * get_contents
     * ������ͨ��get����������
     * @param string $url       �����url,ƴ�Ӻ��
     * @return string           ���󷵻ص�����
     */
    public function get_contents($url){
        if (ini_get("allow_url_fopen") == "1") {
            $response = file_get_contents($url);
        }else{
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
            curl_setopt($ch, CURLOPT_URL, $url);
            $response =  curl_exec($ch);
            curl_close($ch);
        }

        //-------����Ϊ��
        if(empty($response)){
            $this->error->showError("50001");
        }

        return $response;
    }

    /**
     * get
     * get��ʽ������Դ
     * @param string $url     ���ڵ�baseUrl
     * @param array $keysArr  �����б�����
     * @return string         ���ص���Դ����
     */
    public function get($url, $keysArr){
        $combined = $this->combineURL($url, $keysArr);
        return $this->get_contents($combined);
    }

    /**
     * post
     * post��ʽ������Դ
     * @param string $url       ���ڵ�baseUrl
     * @param array $keysArr    ����Ĳ����б�
     * @param int $flag         ��־λ
     * @return string           ���ص���Դ����
     */
    public function post($url, $keysArr, $flag = 0){

        $ch = curl_init();
        if(! $flag) curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $keysArr);
        curl_setopt($ch, CURLOPT_URL, $url);
        $ret = curl_exec($ch);

        curl_close($ch);
        return $ret;
    }
}
