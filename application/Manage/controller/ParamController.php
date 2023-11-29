<?php
namespace app\Manage\controller;

use think\Controller;

class ParamController extends BaseController
{
    public function web()
    {
        $filename = APP_PATH . 'web.php';
        if ($this->request->isPost()) {
            $post = $this->request->post();
            if ($post) {
                $arr = "<?php return [\r\n";
                foreach ($post as $k => $v) {
                    $arr .= "    '" . $k . "'  =>  '" . $v . "',\r\n";
                }
                $arr .= "]; ?>";
                $configfile = fopen($filename, "w") or die("Unable to open file!");
                fwrite($configfile, $arr);
                fclose($configfile);
            }
            echo json_encode(['code' => 1, 'msg' => '保存成功']);
        } else {
            // 参数
            if (file_exists($filename)) {
                $web_params = include($filename);
            }
            $this->assign('info', $web_params);

            return view();
        }
    }
}
