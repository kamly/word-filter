<?php


// 设置脚本最大运行内存，根据字典大小调整
ini_set('memory_limit', '2048M');

// 加载助手文件
require_once('./src/FilterHelperTrieTree.php');
require_once('./src/config.php');

// http服务绑定ip,端口
$server = new swoole_http_server($config['ip'], $config['port']);


/**
 * 处理请求
 */
$server->on('Request', function($request, $response) use ($config) {

    // 接收get请求参数
    $content = isset($request->get['content']) ? $request->get['content']: '';

    $arr_ret = array();

    if (!empty($content)) {

        // 清除文件状态缓存
        clearstatcache();

        // 获取请求时，字典树文件的修改时间
        $new_mtime = filemtime($config['blackword']);

        // 获取最新trie-tree对象
        $trie = FilterHelperTrieTree::get_trie($config['blackword'], $new_mtime);

        // 执行查找敏感词
        $stime = microtime(true);
        $arr_ret['data'] = $trie->search($content);
        $etime = microtime(true);

        $arr_ret['time'] = sprintf('%01.6f', $etime - $stime);
        $arr_ret['memory'] = (memory_get_peak_usage() / 1024 / 1024) . 'M';
    } else {
        $arr_ret['data'] = false;
    }

    // 定义http服务信息及响应处理结果
    $response->header('Content-Type', 'Content-Type: application/json;charset=UTF-8');
    $response->end(json_encode($arr_ret));
});

$server->start();