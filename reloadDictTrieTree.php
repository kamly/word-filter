<?php

// 设置内存
ini_set('memory_limit', '2048M');


require_once './src/TrieTree.php';
require_once './src/config.php';


// 初始化 trie
$trie = new TrieTree();

// 加载敏感词库
$handle = fopen($config['dict'], 'r');
while (!feof($handle)) {
    $word = rtrim(fgets($handle));

    if (!empty($word)) {
        $trie->append($word);
    }
}

// 保存对象在文件 
file_put_contents($config['blackword'], gzdeflate(serialize($trie), 5));

// 打印消耗时间+内存
echo (memory_get_usage() / 1024 / 1024) . " M \n";

