<?php
declare(strict_types=1);

namespace app\admin\controller;

use Exception;
use think\Request;
use app\common\model\Node;
use app\common\model\User;
use app\common\model\UserLevel;

/**
 * 区块链节点控制器
 * @author imxieke <oss@live.hk>
 */
class NodeController extends AdminBaseController
{
    /**
     * 后台首页
     * @return string
     * @throws Exception
     */
    public function index(): string
    {
        return $this->fetch();
    }

    /**
     * 区块链节点列表
     *
     * @author imxieke <oss@live.hk>
     * @return mixed
     */
    public function lists(Request $request, Node $model)
    {
        $lists = $model->limit(10)->select();
        $param = $request->param();
        $data = $model->limit(10)
            ->paginate([
                'list_rows' => $this->admin['admin_list_rows'],
                'var_page' => 'page',
                'query' => $request->get(),
            ]);
        // 关键词，排序等赋值
        $this->assign($request->get());
        // \var_dump($lists);
        // exit;
        $this->assign([
            'data' => $data,
            'page' => $data->render(),
            'total' => $data->total(),
            'user_level_list' => UserLevel::select(),
            'status_list' => User::STATUS_LIST,
        ]);
        return $this->fetch();
    }

    /**
     * 编辑节点信息
     *
     * @return mixed
     */
    public function edit()
    {
        $id = request()->param('id');
        $this->assign([
            'id' => $id,
            'node' => Node::findOrempty($id)->toArray(),
            'user_level_list' => UserLevel::select(),
            'chain_lists' => Node::CHAIN_LISTS,
        ]);
        return $this->fetch();
    }
}