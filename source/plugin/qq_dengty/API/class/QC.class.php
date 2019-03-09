<?php
/* PHP SDK
 * @version 2.0.0
 * @author connect@qq.com
 * @copyright ? 2013, Tencent Corporation. All rights reserved.
 */
require_once(CLASS_PATH."Oauth.class.php");

/*
 * @brief QC�࣬api�ⲿ���󣬵��ýӿ�ȫ�������ڴ˶���
 * */
class QC extends Oauth{
    private $kesArr, $APIMap;

    /**
     * _construct
     *
     * ���췽��
     * @access public
     * @since 5
     * @param string $access_token  access_token value
     * @param string $openid        openid value
     * @return Object QC
     */
    public function __construct($access_token = "", $openid = ""){
        parent::__construct();

        //���access_token��openidΪ�գ����session��ȥȡ��������demoչʾ����
        if($access_token === "" || $openid === ""){
            $this->keysArr = array(
                "oauth_consumer_key" => (int)$this->appid,
                "access_token" => $this->recorder->read("access_token"),
                "openid" => $this->recorder->read("openid")
            );
        }else{
            $this->keysArr = array(
                "oauth_consumer_key" => (int)$this->appid,
                "access_token" => $access_token,
                "openid" => $openid
            );
        }

        //��ʼ��APIMap
        /*
         * ��#��ʾ�Ǳ��룬���򲻴���url(url�в�����ָò���)�� "key" => "val" ��ʾkey���û�ж�����ʹ��Ĭ��ֵval
         * ���� array( baseUrl, argListArr, method)
         */
        $this->APIMap = array(


            /*                       qzone                    */
            "add_blog" => array(
                "https://graph.qq.com/blog/add_one_blog",
                array("title", "format" => "json", "content" => null),
                "POST"
            ),
            "add_topic" => array(
                "https://graph.qq.com/shuoshuo/add_topic",
                array("richtype","richval","con","#lbs_nm","#lbs_x","#lbs_y","format" => "json", "#third_source"),
                "POST"
            ),
            "get_user_info" => array(
                "https://graph.qq.com/user/get_user_info",
                array("format" => "json"),
                "GET"
            ),
            "add_one_blog" => array(
                "https://graph.qq.com/blog/add_one_blog",
                array("title", "content", "format" => "json"),
                "GET"
            ),
            "add_album" => array(
                "https://graph.qq.com/photo/add_album",
                array("albumname", "#albumdesc", "#priv", "format" => "json"),
                "POST"
            ),
            "upload_pic" => array(
                "https://graph.qq.com/photo/upload_pic",
                array("picture", "#photodesc", "#title", "#albumid", "#mobile", "#x", "#y", "#needfeed", "#successnum", "#picnum", "format" => "json"),
                "POST"
            ),
            "list_album" => array(
                "https://graph.qq.com/photo/list_album",
                array("format" => "json")
            ),
            "add_share" => array(
                "https://graph.qq.com/share/add_share",
                array("title", "url", "#comment","#summary","#images","format" => "json","#type","#playurl","#nswb","site","fromurl"),
                "POST"
            ),
            "check_page_fans" => array(
                "https://graph.qq.com/user/check_page_fans",
                array("page_id" => "314416946","format" => "json")
            ),
            /*                    wblog                             */

            "add_t" => array(
                "https://graph.qq.com/t/add_t",
                array("format" => "json", "content","#clientip","#longitude","#compatibleflag"),
                "POST"
            ),
            "add_pic_t" => array(
                "https://graph.qq.com/t/add_pic_t",
                array("content", "pic", "format" => "json", "#clientip", "#longitude", "#latitude", "#syncflag", "#compatiblefalg"),
                "POST"
            ),
            "del_t" => array(
                "https://graph.qq.com/t/del_t",
                array("id", "format" => "json"),
                "POST"
            ),
            "get_repost_list" => array(
                "https://graph.qq.com/t/get_repost_list",
                array("flag", "rootid", "pageflag", "pagetime", "reqnum", "twitterid", "format" => "json")
            ),
            "get_info" => array(
                "https://graph.qq.com/user/get_info",
                array("format" => "json")
            ),
            "get_other_info" => array(
                "https://graph.qq.com/user/get_other_info",
                array("format" => "json", "#name", "fopenid")
            ),
            "get_fanslist" => array(
                "https://graph.qq.com/relation/get_fanslist",
                array("format" => "json", "reqnum", "startindex", "#mode", "#install", "#sex")
            ),
            "get_idollist" => array(
                "https://graph.qq.com/relation/get_idollist",
                array("format" => "json", "reqnum", "startindex", "#mode", "#install")
            ),
            "add_idol" => array(
                "https://graph.qq.com/relation/add_idol",
                array("format" => "json", "#name-1", "#fopenids-1"),
                "POST"
            ),
            "del_idol" => array(
                "https://graph.qq.com/relation/del_idol",
                array("format" => "json", "#name-1", "#fopenid-1"),
                "POST"
            ),
            /*                           pay                          */

            "get_tenpay_addr" => array(
                "https://graph.qq.com/cft_info/get_tenpay_addr",
                array("ver" => 1,"limit" => 5,"offset" => 0,"format" => "json")
            )
        );
    }

    //������Ӧapi
    private function _applyAPI($arr, $argsList, $baseUrl, $method){
        $pre = "#";
        $keysArr = $this->keysArr;

        $optionArgList = array();//һЩ����ѡ�������ѡһ������
        foreach($argsList as $key => $val){
            $tmpKey = $key;
            $tmpVal = $val;

            if(!is_string($key)){
                $tmpKey = $val;

                if(strpos($val,$pre) === 0){
                    $tmpVal = $pre;
                    $tmpKey = substr($tmpKey,1);
                    if(preg_match("/-(\d$)/", $tmpKey, $res)){
                        $tmpKey = str_replace($res[0], "", $tmpKey);
                        $optionArgList[$res[1]][] = $tmpKey;
                    }
                }else{
                    $tmpVal = null;
                }
            }

            //-----���û��������Ӧ�Ĳ���
            if(!isset($arr[$tmpKey]) || $arr[$tmpKey] === ""){

                if($tmpVal == $pre){//��ʹ��Ĭ�ϵ�ֵ
                    continue;
                }else if($tmpVal){
                    $arr[$tmpKey] = $tmpVal;
                }else{
                    if($v = $_FILES[$tmpKey]){

                        $filename = dirname($v['tmp_name'])."/".$v['name'];
                        move_uploaded_file($v['tmp_name'], $filename);
                        $arr[$tmpKey] = "@$filename";

                    }else{
                        $this->error->showError("api���ò�������","δ�������$tmpKey");
                    }
                }
            }

            $keysArr[$tmpKey] = $arr[$tmpKey];
        }
        //���ѡ���������һ������
        foreach($optionArgList as $val){
            $n = 0;
            foreach($val as $v){
                if(in_array($v, array_keys($keysArr))){
                    $n ++;
                }
            }

            if(! $n){
                $str = implode(",",$val);
                $this->error->showError("api���ò�������",$str."����һ��");
            }
        }

        if($method == "POST"){
            if($baseUrl == "https://graph.qq.com/blog/add_one_blog") $response = $this->urlUtils->post($baseUrl, $keysArr, 1);
            else $response = $this->urlUtils->post($baseUrl, $keysArr, 0);
        }else if($method == "GET"){
            $response = $this->urlUtils->get($baseUrl, $keysArr);
        }

        return $response;

    }

    /**
     * _call
     * ħ����������api����ת��
     * @param string $name    ���õķ�������
     * @param array $arg      �����б�����
     * @since 5.0
     * @return array          ���ӵ��ý������
     */
    public function __call($name,$arg){
        //���APIMap��������Ӧ��api
        if(empty($this->APIMap[$name])){
            $this->error->showError("api�������ƴ���","�����ڵ�API: <span style='color:red;'>$name</span>");
        }

        //��APIMap��ȡapi��Ӧ����
        $baseUrl = $this->APIMap[$name][0];
        $argsList = $this->APIMap[$name][1];
        $method = isset($this->APIMap[$name][2]) ? $this->APIMap[$name][2] : "GET";

        if(empty($arg)){
            $arg[0] = null;
        }

        //����get_tenpay_addr�����⴦��php json_decode��\xA312�����ַ�֧�ֲ���
        if($name != "get_tenpay_addr"){
            $response = json_decode($this->_applyAPI($arg[0], $argsList, $baseUrl, $method));
            $responseArr = $this->objToArr($response);
        }else{
            $responseArr = $this->simple_json_parser($this->_applyAPI($arg[0], $argsList, $baseUrl, $method));
        }


        //��鷵��ret�ж�api�Ƿ�ɹ�����
        if($responseArr['ret'] == 0){
            return $responseArr;
        }else{
            $this->error->showError($response->ret, $response->msg);
        }

    }

    //php ��������ת��
    private function objToArr($obj){
        if(!is_object($obj) && !is_array($obj)) {
            return $obj;
        }
        $arr = array();
        foreach($obj as $k => $v){
            $arr[$k] = $this->objToArr($v);
        }
        return $arr;
    }


    /**
     * get_access_token
     * ���access_token
     * @param void
     * @since 5.0
     * @return string ����access_token
     */
    public function get_access_token(){
        return $this->recorder->read("access_token");
    }

    //��ʵ��json��php����ת������
    private function simple_json_parser($json){
        $json = str_replace("{","",str_replace("}","", $json));
        $jsonValue = explode(",", $json);
        $arr = array();
        foreach($jsonValue as $v){
            $jValue = explode(":", $v);
            $arr[str_replace('"',"", $jValue[0])] = (str_replace('"', "", $jValue[1]));
        }
        return $arr;
    }
}
