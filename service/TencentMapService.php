<?php
/**
 * User: tan
 */

namespace app\lbs\service;

use app\common\service\BaseService;
use app\lbs\model\LbsConfigModel;
use app\lbs\model\LbsConfigTencentModel;
use app\lbs\model\LbsAddressInfoModel;
use app\lbs\model\LbsLocationInfoModel;
use app\lbs\model\LbsIpInfoModel;
use GuzzleHttp\Client;

class TencentMapService extends BaseService
{
    //地址解析
    protected static $address = "https://apis.map.qq.com/ws/geocoder/v1/";
    //逆地址解析
    protected static $location = "https://apis.map.qq.com/ws/geocoder/v1/";
    //IP地址解析
    protected static $ip = "https://apis.map.qq.com/ws/location/v1/ip";

    /**
     * @return Client
     */
    function _getHttpClient()
    {
        return new Client([
            // Base URI is used with relative requests
            'base_uri' => '',
            // You can set any number of default request options.
            'timeout' => 5,
        ]);
    }

    /**
     * 获取key
     * @return mixed
     */
    function getKey()
    {
        $LbsConfigTencentModel = new LbsConfigTencentModel();
        $configs = $LbsConfigTencentModel->select();
        $index = rand(0, count($configs) - 1);
        return self::createReturn(true, $configs[$index]['key']);
    }

    /**
     * 通过地址获取坐标
     * @param string $address 地址（注：地址中请包含城市名称，否则会影响解析效果）
     * @param string $region 指定地址所属城市，可以不填
     * @return array 返回示例：
    {
        code: 200
        data: {
            address: "广东省广州市海珠区"
            city: "广州市"
            district: "海珠区"
            lat: "23.08331"
            lng: "113.3172"
            province: "广东省"
            street: ""
        }
        msg: ""
        status: true
        url: ""
    }
     *
     */
    function geocoder_address($address, $region = '')
    {
        //条件判断
        if (empty($address)) {
            return self::createReturn(false, null, '地址不能为空');
        }
        $url = self::$address.'?address='.trim($address);
        if (!empty($region)) {
            $url .= '&region='.$region;
        }
        $url .= '&key='.$this->getKey()['data'];
        //检查数据库是否存在
        $checkData = self::checkAddressData($address);
        if ($checkData) {
            return self::createReturn(true, $checkData);
        }

        //发出请求
        $http = $this->_getHttpClient();
        $reponse = $http->get($url, []);
        $body = (string) $reponse->getBody();
        $body = json_decode($body, true);
        //检查是否请求数据成功
        if ($body['status'] != 0) {
            return self::createReturn(false, null, $body['message']);
        }
        $result = $body['result'];
        $data['lat'] = $result['location']['lat'];//纬度
        $data['lng'] = $result['location']['lng'];//经度
        $data['address'] = $address;//地址
        $data['region'] = $region;//指定地址所属城市
        $data['province'] = $result['address_components']['province'];//省份
        $data['city'] = $result['address_components']['city'];//城市
        $data['district'] = $result['address_components']['district'];//地区
        $data['street'] = $result['address_components']['street'];//街道
        $data['street_number'] = $result['address_components']['street_number'];//门牌，可能为空字串
        $data['create_time'] = date('Y-m-d H:i:s');
        $LbsAddressInfoModel = new LbsAddressInfoModel();
        $res = $LbsAddressInfoModel->insert($data);
        if (!$res) {
            return self::createReturn(false, null, '查询失败,请稍后重试');
        }
        return self::createReturn(true, $data);
    }

    /**
     * 通过坐标获取地址
     * @param string $location 坐标值 例如23.08331,113.3172
     * @return array 返回示例：
    {
        code: 200
        data: {
            address: "广东省广州市海珠区敦丰路"
            city: "广州市"
            district: "海珠区"
            lat: "23.08331"
            lng: "113.3172"
            province: "广东省"
            street: "敦丰路"
        }
        msg: ""
        status: true
        url: ""
    }
     *
     */
    function geocoder_location($location)
    {
        if (empty($location)) {
            return self::createReturn(false, null, '经纬度不能为空');
        }
        $url = self::$location.'?location='.trim($location);
        $url .= '&key='.$this->getKey()['data'];

        //检查数据库是否存在
        $checkData = self::checkLocationData($location);
        if ($checkData) {
            return self::createReturn(true, $checkData);
        }
        //发出请求
        $http = $this->_getHttpClient();
        $reponse = $http->get($url, []);
        $body = (string) $reponse->getBody();
        $body = json_decode($body, true);
        //检查是否请求数据成功
        if ($body['status'] != 0) {
            return self::createReturn(false, null, $body['message']);
        }
        $result = $body['result'];
        $data['lat'] = $result['location']['lat'];//纬度
        $data['lng'] = $result['location']['lng'];//经度
        $data['address'] = $result['address'];//地址
        $data['province'] = $result['address_component']['province'];//省份
        $data['city'] = $result['address_component']['city'];//城市
        $data['district'] = $result['address_component']['district'];//地区
        $data['street'] = $result['address_component']['street'];//街道
        $data['street_number'] = $result['address_component']['street_number'];//门牌，可能为空字串
        $data['create_time'] = date('Y-m-d H:i:s');
        $LbsLocationInfoModel = new LbsLocationInfoModel();
        $res = $LbsLocationInfoModel->insert($data);
        if (!$res) {
            return self::createReturn(false, null, '查询失败,请稍后重试');
        }
        return self::createReturn(true, $data);
    }

    /**
     * 通过IP获取地址
     * @param string $location ip值 例如61.135.17.68
     * @return array 返回示例：
    {
        code: 200
        data: {
            address: "广东省广州市海珠区"
            city: "广州市"
            district: "海珠区"
            lat: "23.08331"
            lng: "113.3172"
            province: "广东省"
        }
        msg: ""
        status: true
        url: ""
    }
     */
    function geocoder_ip($ip)
    {
        if (empty($ip)) {
            return self::createReturn(false, null, 'IP不能为空');
        }
        $url = self::$ip.'?ip='.$ip;
        $url .= '&key='.$this->getKey()['data'];

        //检查数据库是否存在
        $checkData = self::checkIpData($ip);
        if ($checkData) {
            $checkData['address'] = $checkData['procince'].$checkData['city'].$checkData['region'];
            return self::createReturn(true, $checkData);
        }

        //发出请求
        $http = $this->_getHttpClient();
        $reponse = $http->get($url, []);
        $body = (string) $reponse->getBody();
        $body = json_decode($body, true);
        //检查数据请求是否成功
        if ($body['status'] != 0) {
            return self::createReturn(false, null, $body['message']);
        }

        $result = $body['result'];
        $data['lat'] = $result['location']['lat'];//纬度
        $data['lng'] = $result['location']['lng'];//经度
        $data['nation'] = $result['ad_info']['nation'];//省份
        $data['province'] = $result['ad_info']['province'];//省份
        $data['city'] = $result['ad_info']['city'];//城市
        $data['district'] = $result['ad_info']['district'];//地区
        $data['create_time'] = date('Y-m-d H:i:s');
        $data['ip'] = $ip;
        $LbsIpInfoModel = new LbsIpInfoModel ();
        $res = $LbsIpInfoModel->insert($data);
        if (!$res) {
            return self::createReturn(false, null, '查询失败,请稍后重试');
        }
        $data['address'] = $data['nation'].$data['province'].$data['city'].$data['district'];
        return self::createReturn(true, $data);
    }

    /**
     * 检测坐标是否存在
     * @return mixed
     */
    static function checkLocationData($location)
    {
        $location = explode(',', $location);
        $where = [];
        $where['lat'] = $location[0];
        $where['lng'] = $location[1];
        $LbsLocationInfoModel = new LbsLocationInfoModel();
        $checkData = $LbsLocationInfoModel->where($where)->field('lat,lng,address,province,city,district,street,create_time')->find();
        if ($checkData) {
            //检测坐标是否过期
            if (self::check_create_time($checkData['create_time'])) {
                return $checkData;
            } else {
                $checkData->delete();
                return false;
            }
        } else {
            return false;
        }
    }

    /**
     * 检测地址是否存在
     * @return mixed
     */
    static function checkAddressData($address)
    {
        $where = [];
        $where['address'] = $address;
        $LbsAddressInfoModel = new LbsAddressInfoModel();
        $checkData = $LbsAddressInfoModel->where($where)->field('lat,lng,address,province,city,district,street,create_time')->find();
        if($checkData){
            //检测地址是否过期
            if(self::check_create_time($checkData['create_time']))
            {
                return $checkData;
            }else{
                $checkData->delete();
                return false;
            }
        }else{
            return false;
        }
    }

    /**
     * 检测IP是否存在
     * @return mixed
     */
    static function checkIpData($ip)
    {
        $where = [];
        $where['ip'] = $ip;
        $LbsIpInfoModel = new LbsIpInfoModel();
        $checkData = $LbsIpInfoModel->where($where)->field('lat,lng,province,city,district,create_time')->find();
        if($checkData){
            //检测IP是否过期
            if(self::check_create_time($checkData['create_time']) === false)
            {
                return $checkData;
            }else{
                $checkData->delete();
                return false;
            }
        }else{
            return false;
        }
    }

    /**
     * 检查是否过期
     * @param  array $findres  查询到的地址信息数组
     * @return mixed 返回true 过期/ false 未过期
     */
    static function check_create_time($create_time){
        $create_time = strtotime($create_time);
        $nowtime = time();
        //获取配置信息
        $time = LbsConfigModel::where('key','time')->value('value');//地址缓存更新时间(天)
        if(!$time) return true;//如果time等于0，则重新获取数据
        $endTime = $time * 24 * 3600 + $create_time;
        if($nowtime < $endTime){
            return false;
        }else{
            return true;
        }
    }

}