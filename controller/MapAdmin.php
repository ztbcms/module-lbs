<?php
/**
 * User: tan
 * Date: 2019/12/26
 * Time: 13:45
 */

namespace app\lbs\controller;

use app\common\controller\AdminController;
use think\facade\View;
use app\lbs\service\TencentMapService;
use think\facade\Request;

//腾讯地图示例

class MapAdmin extends AdminController
{
    /**
     * 示例页面
     */
    function demo()
    {
        return View::fetch('demo');
    }


    /**
     * 选点返回数据
     */
    function select_address_tencent()
    {
        $service = new TencentMapService();
        $key = $service->getKey()['data'];
        return View::fetch('select_address_tencent',['key'=>$key]);
    }

    /**
     * 选点返回数据
     */
    function select_address_tencentV2()
    {
        $service = new TencentMapService();
        $key = $service->getKey()['data'];
        return View::fetch('select_address_tencentV2',['key'=>$key]);
    }

    /**
     * 通过地址解析坐标
     * @param string $address 地址
     * @param string $region  指定地址所属城市
     * @return array
     *
     */
    function geocoder_address_tencent(){
        $service = new TencentMapService();
        $address = Request::param('address');
        $region = Request::param('region');
        $res = $service->geocoder_address($address, $region);
        return json($res);
    }

    /**
     * 通过坐标逆解析地址
     * @param string $location 坐标
     * @return array
     */
    function geocoder_location_tencent(){
        $service = new TencentMapService();
        $location = Request::param('location');
        $res = $service->geocoder_location($location);
        return json($res);
    }

    /**
     * 通过IP解析地址
     * @param string $location 坐标
     * @return array
     */
    function geocoder_ip_tencent(){
        $service = new TencentMapService();
        $ip = Request::param('ip');
        $res = $service->geocoder_ip($ip);
        return json($res);
    }
}