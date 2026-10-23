# EasyCMS

轻量级可扩展的开源内容管理系统，基于 ThinkPHP 3.1.3。

# 使用须知
* 程序安装需要使用 "网址/index.php/?s=/install" 的安装路径,此时后台地址"网址/index.php?s=/admin"

* 测试数据在安装后进入后台系统管理下数据库恢复里可以恢复查看， 测试数据的表前缀是默认的easy_，如果在安装时不是直接使用默认的表前缀则不能后台直接恢复测试数据，测试数据默认后台账号密码都是admin 

* 正式使用时建议修改index.php下的APP_DEBUG为FALSE

* 程序基于 ThinkPHP 3.1.3；原版运行于 PHP 5.6，当前版本已在 **PHP 8.3** 实测通过（数据库驱动改用 **mysqli**，不再支持 PHP 7 起已移除的 mysql 扩展）。兼容补丁采用旧版写法，理论上支持 PHP 5.3+，但 PHP 5.6 / 7.x **未做运行验证**

* 在线效果：https://easycms.chenjie.info

>联系邮箱:chenjie@chenjie.info

---

## 环境要求

* 运行环境：PHP 8.3（实测）；需启用 **mysqli**、GD、mbstring 扩展
* 数据库：MySQL 5.x / MariaDB 10.x
* Web 服务器：Nginx / Apache（需支持 PATHINFO，URL 模式为兼容模式）
* 说明：PHP 5.6 / 7.x 语法上兼容但未实测，旧环境使用前请自行验证

## Docker 快速部署（推荐）

仓库已提供 `docker-compose.yml`（PHP 8.3-fpm + Nginx + MariaDB 10.4），适合本地开发、测试与快速体验：

```bash
docker compose up -d --build
```

默认通过非标准端口暴露，避免占用宿主机 80 端口：

| 服务 | 地址 / 账号 |
| --- | --- |
| 前台 | http://localhost:9080/ |
| 后台 | http://localhost:9080/index.php?s=/admin （admin / admin） |
| 安装向导 | http://localhost:9080/index.php?s=/install |
| MySQL | 本机端口 `9306`，root 密码 `root`，业务库 `easycms`（用户 `easycms/easycms`） |

说明：

* 数据库在容器内的连接地址为 `db`，配置见 `App/Conf/config.php`（安装向导会自动生成）。
* 数据库数据保存在 Docker 命名卷 `db_data`，代码目录直接挂载到容器，修改代码即时生效。
* `docker-compose.yml` 中为本地开发/演示用的弱口令，**生产环境请务必修改**。

### 使用域名 + 80 端口（对外访问）

默认的 9080 端口仅用于本地快速体验。若要通过域名（如 `www.example.com`）直接访问 80 端口，需要改两处：

**1. 修改端口映射**

编辑 `docker-compose.yml` 的 nginx 服务，把宿主机端口从 `9080` 改为 `80`：

```yaml
  nginx:
    image: nginx:stable
    ports:
      - "80:80"          # 原为 "9080:80"
```

**2. 配置 Nginx 域名（server_name）**

编辑 `docker/nginx/default.conf`，将 `server_name` 从 `_`（匹配所有）改为你的域名：

```nginx
server {
    listen        80;
    server_name   www.example.com example.com;   # 多个域名用空格分隔
    root          /var/www;
    index         index.html index.php;
    # 其余 fastcgi / 伪静态配置保持不变
}
```

随后重启服务使配置生效：

```bash
docker compose up -d
```

**3. 域名解析**

将域名的 A 记录解析到运行服务器的公网 IP，并在服务器/云厂商安全组放行 **80** 端口（如需 HTTPS 再放行 443）。

完成后即可通过 `http://www.example.com/` 访问前台、`http://www.example.com/index.php?s=/admin` 访问后台。

> 补充：
> * 一台主机部署多个站点时，建议改用独立的 Nginx 配置或反向代理容器（如 traefik / nginx-proxy），为每个域名分配独立 server 块，而不是共用本仓库的单一 `default.conf`。
> * 生产环境建议在前端再配置 HTTPS（可用 certbot 或网关层终止 TLS），并同步修改数据库密码、关闭 `APP_DEBUG`。

### 已有测试数据（跳过安装向导）

若不使用安装向导，可直接导入仓库自带的演示备份 `Data/20250211-115201-1.sql.gz` 到 `easycms` 库，并将 `App/Conf/config.php` 的数据库连接指向对应库即可；导入后用 admin/admin 登录。

## 目录说明

* `App/` 应用代码（Index 前台 / Admin 后台 / Install 安装 / Member 会员）
* `ThinkPHP/` 框架核心（已做 PHP 8.3 兼容处理）
* `Public/`、`Uploads/` 静态资源与用户上传
* `Data/` 数据库备份目录
* `docker/` PHP 镜像与 Nginx 站点配置

[![Powered by DartNode](https://dartnode.com/branding/DN-Open-Source-sm.png)](https://dartnode.com "Powered by DartNode - Free VPS for Open Source")
