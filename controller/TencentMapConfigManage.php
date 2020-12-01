<?php
/**
 * User: tan
 */

namespace app\lbs\controller;

use app\common\controller\AdminController;
use think\facade\View;
use app\lbs\model\LbsConfigTencentModel;
use app\lbs\model\LbsConfigModel;
use app\lbs\service\LbsConfigTencentService;
use app\lbs\service\LbsConfigService;
use think\facade\Request;

//腾讯地图配置
class TencentMapConfigManage extends AdminController
{
    /**
     *  腾讯地图配置
     * @throws \think\db\exception\DbException
     */
    function index()
    {
        return View::fetch('index');
    }

    /**
     *  获取配置地图API秘钥列表
     * @throws \think\db\exception\DbException
     * @return array
     */
    function getList()
    {
        $where = [];
        $lists = LbsConfigTencentModel::where($where)->order('id', 'DESC')->paginate(20);
        return self::createReturn(true, $lists, '');
    }

    /**
     * 新增配置地图API秘钥
     *
     * @return string|\think\response\Json|\think\response\View
     */
    function configTencentAdd()
    {
        if (Request::isPost()) {
            $data = Request::post();
            $adminManagerService = new LbsConfigTencentService();
            $res = $adminManagerService->addOrEditConfigTencent($data);
            return json($res);
        }
        return View::fetch('edit');
    }

    /**
     * 编辑配置地图API秘钥
     *
     * @return string|\think\response\Json|\think\response\View
     */
    function configTencentEdit()
    {
        if (Request::isPost()) {
            $data = Request::post();
            $LbsConfigTencentService = new LbsConfigTencentService();
            $res = $LbsConfigTencentService->addOrEditConfigTencent($data);
            return json($res);
        }
        $id = Request::param('id');
        return View::fetch('edit',[
            'id' => $id
        ]);
    }

    /**
     * 获取配置地图API秘钥详情
     * @return \think\response\Json|\think\response\View
     */
    function getDetail()
    {
        $LbsConfigTencentModel = new LbsConfigTencentModel();
        $id = Request::param('id');
        $where['id'] = $id;
        $res = $LbsConfigTencentModel->where($where)->find();
        if ($res) {
            return json(self::createReturn(true, $res));
        } else {
            return json(self::createReturn(false, [], '该配置不存在'));
        }
    }

    //配置地图API秘钥删除
    function configTencentDelete()
    {
        $id = Request::param('id', '', 'trim');

        $LbsConfigTencentService = new LbsConfigTencentService();
        $res = $LbsConfigTencentService->deleteConfigTencent($id);
        return json($res);
    }


    /**
     *  获取配置列表
     * @throws \think\db\exception\DbException
     * @return array
     */
    function getKeyconfig()
    {
        $where = [];
        $lists = LbsConfigModel::where($where)->order('id', 'DESC')->paginate(20);
        return self::createReturn(true, $lists, '');
    }

    /**
     * 新增配置
     *
     * @return string|\think\response\Json|\think\response\View
     */
    function configAdd()
    {
        if (Request::isPost()) {
            $data = Request::post();
            $LbsConfigService = new LbsConfigService();
            $res = $LbsConfigService->addOrEditConfig($data);
            return json($res);
        }
        return View::fetch('editKey');
    }

    /**
     * 编辑配置
     *
     * @return string|\think\response\Json|\think\response\View
     */
    function configEdit()
    {
        if (Request::isPost()) {
            $data = Request::post();
            $LbsConfigService = new LbsConfigService();
            $res = $LbsConfigService->addOrEditConfig($data);
            return json($res);
        }
        $id = Request::param('id');
        return View::fetch('editKey',[
            'id' => $id
        ]);
    }

    /**
     * 获取配置详情
     * @return \think\response\Json|\think\response\View
     */
    function getConfigDetail()
    {
        $LbsConfigModel = new LbsConfigModel();
        $id = Request::param('id');
        $where['id'] = $id;
        $res = $LbsConfigModel->where($where)->find();
        if ($res) {
            return json(self::createReturn(true, $res));
        } else {
            return json(self::createReturn(false, [], '该配置不存在'));
        }
    }

    /**
     * 配置删除
     * @return \think\response\Json|\think\response\View
     */
    function configDelete()
    {
        $id = Request::param('id', '', 'trim');
        $LbsConfigService = new LbsConfigService();
        $res = $LbsConfigService->deleteConfig($id);
        return json($res);
    }
}