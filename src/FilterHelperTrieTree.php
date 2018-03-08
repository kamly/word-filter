<?php
/**
 * 过滤器助手
 * getResTrie 提供trie-tree对象;
 */

require_once './src/TrieTree.php';

class FilterHelperTrieTree
{

    // trie-tree对象
    private static $_trie = null;
    // 字典树的更新时间
    private static $_mtime = null;


    /**
     * 防止初始化
     */
    private function __construct()
    {
    }


    /**
     * 防止克隆对象
     */
    private function __clone()
    {
    }


    /**
     * 提供trie-tree对象
     *
     * @param $tree_file 字典树文件路径
     * @param $new_mtime 当前调用时字典树的更新时间
     * @return null
     */
    static public function get_trie($tree_file, $new_mtime)
    {

        if (is_null(self::$_mtime)) {
            self::$_mtime = $new_mtime;
        }

        // 获取最新的 trie-tree 对象
        if (($new_mtime != self::$_mtime) || is_null(self::$_trie)) {
            self::$_trie = unserialize(gzinflate(file_get_contents($tree_file)));
            self::$_mtime = $new_mtime;

            // 输出字典文件重载时间
            echo date('Y-m-d H:i:s') . "\ttree reload success!\n";
        }

        return self::$_trie;
    }
}