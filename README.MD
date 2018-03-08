

# 敏感词过滤

## 环境

ubnutu
php 7.16
swoole

## 配置

```
<?php
$config = [
    'dict' => './dict/dict.txt',
    'blackword' => './dict/blackword.tree',
    'port' => 9002,
    'ip' => '0.0.0.0'
];
```


## 执行


```
php reloadDictTrieTree.php # 加载数据字典对象
> 467.73580169678 M

php httpServerTrieTree.php # 启动swoole服务
```

访问 http://xxx.xxx.xxx.xxx:9002/?content=今晚约炮哦，sm

```
{
    "data": {
        "8e338ee8919dff35298f5d75485a78d4": {
            "word": "xx",
            "data": [],
            "count": 1
        },
        "ed79acb0cd3d7f8320c53c7798335ef0": {
            "word": "xx",
            "data": [],
            "count": 1
        }
    },
    "time": "0.000061",
    "memory": "1200.0737609863M"
}
```

> 敏感词库更新之后，执行 `php reloadDictTrieTree.php` ，即可更新数据字典对象


使用 [算法](https://github.com/AbelZhou/PHP-TrieTree) ，使用swoole单独封装服务。


[词库-参考](https://github.com/kejiaren/sensitive-word)

