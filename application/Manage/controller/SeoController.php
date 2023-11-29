<?php
namespace app\Manage\controller;

use app\Manage\model\WebsiteLanguage;
use app\Manage\model\ArticleCategoryModel;
use app\Manage\model\ArticleModel;
use app\Manage\model\PageCategoryModel;
use app\Manage\model\PageModel;
use think\Controller;
use think\Session;
use think\Config;

class SeoController extends BaseController
{
    public function tkd()
    {
        $model = $this->request->param('model', 'PageModel', 'htmlspecialchars');
        $this->assign('model', $model);

        $btnlist = [
            'PageModel'             =>  '单页',
            'PageCategoryModel'     =>  '单页分类',
            'ArticleModel'          =>  '文章',
            'ArticleCategoryModel'  =>  '文章分类',
        ];
        $this->assign('btn', $btnlist);

        switch ($model) {
            case 'PageModel':
                $list = PageModel::where(['language_id' => $this->language_id, 'status' => PageModel::STATUS_ACTIVE])->paginate(Config::get('PAGE_NUM'));
                $this->assign('list', $list);
                break;
            case 'PageCategoryModel':
                $list = PageCategoryModel::where(['language_id' => $this->language_id, 'status' => PageCategoryModel::STATUS_ACTIVE])->paginate(Config::get('PAGE_NUM'));
                $this->assign('list', $list);
                break;
            case 'ArticleModel':
                $list = ArticleModel::where(['language_id' => $this->language_id, 'status' => ArticleModel::STATUS_ACTIVE])->paginate(Config::get('PAGE_NUM'));
                $this->assign('list', $list);
                break;
            case 'ArticleCategoryModel':
                $list = ArticleCategoryModel::where(['language_id' => $this->language_id, 'status' => ArticleCategoryModel::STATUS_ACTIVE])->paginate(Config::get('PAGE_NUM'));
                $this->assign('list', $list);
                break;
        }

        return view();
    }

    public function tkd_edit()
    {
        if ($this->request->isPost()) {
            $post = $this->request->post();
            $data = array();
            if ($post['seo_id']) {
                foreach ($post['seo_id'] as $k => $v) {
                    $data[$v] = ['id' => $v, 'seo_title' => $post['seo_title'][$k], 'seo_keyword' => $post['seo_keyword'][$k], 'seo_description' => $post['seo_description'][$k]];
                }
            }
            $save_data = $data[$post['id']];
            $save_data['language_id'] = $this->language_id;
            switch ($post['model']) {
                case 'PageModel':
                    $model = PageModel::get($post['id']);
                    if ($model->save($save_data)) {
                        echo json_encode(['code' => 1, 'msg' => '操作成功']);
                        exit;
                    } else {
                        echo json_encode(['code' => 0, 'msg' => '编辑失败']);
                        exit;
                    }
                    break;
                case 'PageCategoryModel':
                    $model = PageCategoryModel::get($post['id']);
                    if ($model->save($save_data)) {
                        echo json_encode(['code' => 1, 'msg' => '操作成功']);
                        exit;
                    } else {
                        echo json_encode(['code' => 0, 'msg' => '编辑失败']);
                        exit;
                    }
                    break;
                case 'ArticleModel':
                    $model = ArticleModel::get($post['id']);
                    if ($model->save($save_data)) {
                        echo json_encode(['code' => 1, 'msg' => '操作成功']);
                        exit;
                    } else {
                        echo json_encode(['code' => 0, 'msg' => '编辑失败']);
                        exit;
                    }
                    break;
                case 'ArticleCategoryModel':
                    $model = ArticleCategoryModel::get($post['id']);
                    if ($model->save($save_data)) {
                        echo json_encode(['code' => 1, 'msg' => '操作成功']);
                        exit;
                    } else {
                        echo json_encode(['code' => 0, 'msg' => '编辑失败']);
                        exit;
                    }
                    break;
                default:
                    echo json_encode(['code' => 0, 'msg' => '异常操作']);
                    exit;
                    break;
            }
        } else {
            echo json_encode(['code' => 0, 'msg' => '异常操作']);
            exit;
        }
    }

    // 添加
    public function sitemap()
    {
        if ($this->request->isPost()) {
            $site_url = $_SERVER['HTTP_HOST'];
            $url = array();
            $language = WebsiteLanguage::all(['is_avail' => WebsiteLanguage::AVIAIL_ACTIVE])->toArray();
            if (!empty($language)) {
                foreach ($language as $k => $v) {
                    if ($v['is_default'] == 1) {
                        $language_flag = '';
                    } else {
                        $language_flag = '/' . $v['abbreviation'];
                    }
                    $url[] = ['loc' => $site_url . $language_flag . '/index', 'priority' => 1];
                    $url[] = ['loc' => $site_url . $language_flag . '/inquiry', 'priority' => 0.7];
                    // 文章分类
                    $newsCategory = ArticleCategoryModel::all(['language_id'=>$v['id'], 'status'=>ArticleCategoryModel::STATUS_ACTIVE])->toArray();
                    foreach ($newsCategory as $knc => $vnc) {
                        $url[] = ['loc' => $site_url . $language_flag . '/news/' . $vnc['slug'], 'priority' => 0.7];
                    }
                    // 文章
                    $news = ArticleModel::all(['language_id'=>$v['id'], 'status'=>ArticleModel::STATUS_ACTIVE])->toArray();
                    foreach ($news as $kn => $vn) {
                        $url[] = ['loc' => $site_url . $language_flag . '/news/' . $vn['slug'] . '.html', 'priority' => 0.7];
                    }
                    $url[] = ['loc' => $site_url . $language_flag . '/news', 'priority' => 0.7];
                    // 单页
                    $page = PageModel::all(['language_id'=>$v['id'], 'status'=>PageModel::STATUS_ACTIVE])->toArray();
                    foreach ($page as $kp => $vp) {
                        $url[] = ['loc' => $site_url . $language_flag . '/' . $vp['slug'], 'priority' => 0.8];
                    }
                }

                //这行很重要，php默认输出text/html格式的文件，所
                header('Content-Type: text/xml');
                //以这里明确告诉浏览器输出的格式为xml,不然浏览器显示不出xml的格式
                $sitemap = $url; //这里要按照sitemap的格式构造出xml的文件,urlset url loc是规定必须有的标签
                $xml_wrapper = <<<EOF
<?xml version='1.0' encoding='utf-8'?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
</urlset>
EOF;

                // $xml = simplexml_load_string($xml_wrapper);
                $xml = new \SimpleXMLElement($xml_wrapper);

                foreach ($sitemap as $data) {
                    $item = $xml->addChild('url'); //使用addChild添加节点
                    if (is_array($data)) {
                        foreach ($data as $key => $row) {
                            $node = $item->addChild($key, $row);
                        }
                        $node3 = $item->addChild('lastmod', date("Y-m-d"));
                        $node4 = $item->addChild('changefreq', 'weekly');
                    }
                }
                $xml_content = $xml->asXML(); //用asXML方法输出xml，默认只构造不输出。
                $myfile = fopen("sitemap.xml", "w");
                fwrite($myfile, $xml_content);
                fclose($myfile);

                echo json_encode(['code' => 1, 'msg' => '更新成功']);
                exit;
            } else {
                echo json_encode(['code' => 0, 'msg' => '更新失败']);
                exit;
            }
        } else {
            $filename = 'sitemap.xml';
            $atime = date('Y-m-d H:i:s', filemtime($filename));
            $this->assign('atime', $atime);

            $website['domain'] = 'http://' . $_SERVER['HTTP_HOST'];
            $website['sitemap'] = 'http://' . $_SERVER['HTTP_HOST'] . '/sitemap.xml';
            $this->assign('website', $website);

            return view();
        }
    }
}
