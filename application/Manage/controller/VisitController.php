<?php
namespace app\Manage\controller;

use app\Manage\model\VisitorModel;
use app\Manage\model\VisitorLogModel;
use think\Controller;
use think\Session;
use think\Config;
use think\Db;

class VisitController extends BaseController
{
    public function index()
    {
        $start_time = $this->request->param('start', date('Y-m-d'), 'htmlspecialchars');
        $this->assign('start', $start_time);
        $end_time = $this->request->param('end', date('Y-m-d'), 'htmlspecialchars');
        $this->assign('end', $end_time);

        $visitor = new VisitorModel();
        $visitorlog = new VisitorLogModel();
        $where['created_at'] = [['egt', strtotime($start_time)], ['lt', strtotime('+1 day', strtotime($end_time))]];
        $data['pv'] = $visitorlog->where($where)->count();
        $data['uv'] = $visitor->where($where)->count();
        $data['clientIp'] = $visitorlog->where($where)->distinct(true)->field(['client_ip'])->count();
        $data['average'] = round($data['pv'] / max(1, $data['uv']), 2);
        $this->assign('data', $data);
        
        $log = VisitorLogModel::all($where)->toArray();
        $res = array();
        if ($log) {
            foreach ($log as $k => $v) {
                if ($start_time == $end_time) {
                    $h = date('H',$v['created_at']);
                    $res[$h] = isset($res[$h]) ? $res[$h] : 0;
                    $res[$h] += 1;
                    $flag = ':00';
                } else {
                    $h = date('Y-m-d',$v['created_at']);
                    $res[$h] = isset($res[$h]) ? $res[$h] : 0;
                    $res[$h] += 1;
                    $flag = '';
                }
            }
            $visit = $this->myArrToString($res, $flag);
        } else {
            $visit = "[]";
        }

        $resCount = count($res);
        if ($resCount == 0) {
            $highData = "{gt:1,lt:2,color: 'rgba(0, 180, 0, 0.5)'}";
            $shadowData = '{xAxis: 1}';
        } else {
            $highData = '';
            for ($i = 0; $i < $resCount; $i = $i + 2) { 
                $highData .= '{gt: ' . ($i + 1) . ', lt: ' . ($i + 2) . ', color: "rgba(0, 180, 0, 0.5)"},';
            }

            $shadowData = '';
            for ($j = 0; $j < $resCount; $j ++) { 
                $shadowData .= '{xAxis: ' . ($j + 1) . '},';
            }
        }
        $this->assign('visit', $visit);
        $this->assign('highData', $highData);
        $this->assign('shadow', $shadow);

        Session::set(Config::get('BACK_URL'), $this->request->url(), 'manage');
        return view();
    }

    public function area()
    {
        $start_time = $this->request->param('start', date('Y-m-d'), 'htmlspecialchars');
        $this->assign('start', $start_time);
        $end_time = $this->request->param('end', date('Y-m-d'), 'htmlspecialchars');
        $this->assign('end', $end_time);

        $visitor = new VisitorModel();
        $visitorlog = new VisitorLogModel();
        $where['created_at'] = [['egt', strtotime($start_time)], ['lt', strtotime('+1 day', strtotime($end_time))]];
        $log = VisitorLogModel::all($where)->toArray();

        $query = $visitorlog->get_country_log($start_time, $end_time);
        $this->assign('country', $query);

        $area = array();
        foreach ($log as $k => $v) {
            $offset_area = $v['country'];
            $area[$offset_area] = isset($area[$offset_area]) ? $area[$offset_area] : 0;
            $area[$offset_area] += 1;
        }
        if ($area) {
            $areaX = $this->myValToString(array_keys($area), "'");
            $areaY = $this->myValToString(array_values($area));
        } else {
            $areaX = "[]";
            $areaY = "[]";
        }
        $this->assign('area', $area);
        $this->assign('areaX', $areaX);
        $this->assign('areaY', $areaY);

        Session::set(Config::get('BACK_URL'), $this->request->url(), 'manage');
        return view();
    }

    public function area_more()
    {
        $start_time = $this->request->param('start', date('Y-m-d'), 'htmlspecialchars');
        $this->assign('start', $start_time);
        $end_time = $this->request->param('end', date('Y-m-d'), 'htmlspecialchars');
        $this->assign('end', $end_time);

        $visitorlog = new VisitorLogModel();
        $where['created_at'] = [['egt', strtotime($start_time)], ['lt', strtotime('+1 day', strtotime($end_time))]];
        $list = Db::name("visitor_log")->where($where)->field("country, count(country) as 'csum'")->group('country')->order('csum desc')->paginate(Config::get('PAGE_NUM'));

        $this->assign('list', $list);
        return view();
    }

    public function source()
    {
        $start_time = $this->request->param('start', date('Y-m-d'), 'htmlspecialchars');
        $this->assign('start', $start_time);
        $end_time = $this->request->param('end', date('Y-m-d'), 'htmlspecialchars');
        $this->assign('end', $end_time);
        $visitorlog = new VisitorLogModel();
        $where['created_at'] = [['egt', strtotime($start_time)], ['lt', strtotime('+1 day', strtotime($end_time))]];

        // 来源网址
        $query = $visitorlog->get_source_web($start_time, $end_time);
        $this->assign('query', $query);

        // 浏览器分布
        $agent = $visitorlog->get_source_browser($start_time, $end_time);
        $count = array_sum(array_column($agent, 'asum'));
        $this->assign('agent', $this->myArrToJson($agent, $count));

        // 访问终端 900px
        $min_width = $visitorlog->where($where)->where(['screen_width' => ['lt', 900]])->count();
        $max_width = $visitorlog->where($where)->where(['screen_width' => ['egt', 900]])->count();
        $sum = $min_width + $max_width == 0 ? 1 : $min_width + $max_width;
        $this->assign('min_width', round($min_width / $sum * 100));
        $this->assign('max_width', round($max_width / $sum * 100));

        Session::set(Config::get('BACK_URL'), $this->request->url(), 'manage');
        return view();
    }

    public function source_more()
    {
        $start_time = $this->request->param('start', date('Y-m-d'), 'htmlspecialchars');
        $this->assign('start', $start_time);
        $end_time = $this->request->param('end', date('Y-m-d'), 'htmlspecialchars');
        $this->assign('end', $end_time);

        $visitorlog = new VisitorLogModel();
        $where['created_at'] = [['egt', strtotime($start_time)], ['lt', strtotime('+1 day', strtotime($end_time))]];
        $list = Db::name("visitor_log")->where($where)->field("referrer, count(referrer) as 'rsums'")->group('referrer')->order('rsums desc')->paginate(Config::get('PAGE_NUM'));

        $this->assign('list', $list);
        return view();
    }

    public function myArrToString($arr, $flag = "")
    {
        $str = '';
        foreach ($arr as $ka => $va) {
            $str .= ',["' . $ka . $flag . '", '. $va . ']';
        }
        $str .= ']';
        $str = '[' . substr($str, 1);

        return $str;
    }

    public function myValToString($arr, $flag = "")
    {
        $str = '';
        foreach ($arr as $va) {
            $str .= ',' . $flag . '' . $va . '' . $flag;
        }
        $str .= ']';
        $str = '[' . substr($str, 1);

        return $str;
    }

    public function myArrToJson($arr, $sum)
    {
        $json = '';
        foreach ($arr as $ka => $va) {
            $json .= '{value:' . $va['asum'] / $sum * 10000 . ',name:"' . $va['user_agent'] . '"},';
        }

        return $json;
    }
}
