

# php 敏感词过滤

## 环境

- ubnutu
- php 7.16
- swoole

## 部署

```

# 日志文件
mkdir logs
chown www:www logs


# 配置文件
vim src/config.php
<?php
$config = [
    'dict' => './dict/dict.txt',
    'blackword' => './dict/blackword.tree',
    'port' => 9002,
    'ip' => '0.0.0.0'
];


php reloadDictTrieTree.php # 加载数据字典对象


# 启动方法1：启动swoole服务
php httpServerTrieTree.php 


# 启动方法2：挂载swoole服务
nohup php ./httpServerTrieTree.php  &>> ./logs/nohup.log & 
```

## 使用

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

## 注意

- 敏感词库更新之后，执行 `php reloadDictTrieTree.php` ，即可更新数据字典对象

- 使用 [字典树算法](https://github.com/AbelZhou/PHP-TrieTree) 

- 使用 [swoole](https://www.swoole.com/) 单独封装服务。

- 使用的[参考词库](https://github.com/kejiaren/sensitive-word)



