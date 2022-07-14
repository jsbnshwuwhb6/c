# 最小网络记事本

这是具有附加功能的优秀 [pereorga/minimalist-web-notepad](https://github.com/pereorga/minimalist-web-notepad) 的一个分支 - 附加代码确实增加了大小，因此不是极简主义，但仍然最小压缩和压缩时为 10kb。如果你想要真正的极简主义，那么 pereorga 的实现不到 3kb，而且还没有缩小！密码功能是通过向文本文件中添加标题行来实现的，该标题行未显示在注释上**请注意，这不会加密内容，只是限制访问**。唯一的服务器要求是启用了 mod_rewrite 的 Apache 网络服务器或启用了 ngx_http_rewrite_module 和 PHP 的 nginx 网络服务器。

![编辑截图](https://raw.github.com/domOrielton/minimal-web-notepad/screenshots/mn_edit.png)

为 [pereorga's](https://github.com/pereorga/minimalist-web-notepad) 添加了功能：

 - 查看带有超链接 URL 的注释选项（对移动设备非常有用）
 - 带有只读访问选项的密码保护
 - 仅查看链接
 - 显示上次保存的笔记时间
 - 复制笔记 url，只查看 url 和笔记文本到剪贴板
 - 以无衬线或单色字体查看注释
 - 下载笔记的能力
 - 可用笔记列表
 - 如果需要，打开和关闭功能以减小页面大小

请参阅 http://note.rf.gd/ 或 http://note.rf.gd/some-note-name-here 上的演示。该演示没有 https，因此您将在浏览器中看到密码警告 - *请勿*将其用于测试以外的任何内容。

截图
------------

**查看模式下的注释**

![查看截图](https://raw.github.com/domOrielton/minimal-web-notepad/screenshots/mn_view.png)

**移动兼容性的响应菜单**

![手机菜单截图](https://raw.github.com/domOrielton/minimal-web-notepad/screenshots/mn_mobile_menu_expanded.png) ![手机菜单截图](https://raw.github.com/domOrielton/最小网络记事本/屏幕截图/mn_mobile_menu.png）

**单字体**

![单声道显示截图](https://raw.github.com/domOrielton/minimal-web-notepad/screenshots/mn_mono.png)

**密码保护**

![密码保护截图](https://raw.github.com/domOrielton/minimal-web-notepad/screenshots/mn_password.png)

**受保护笔记的密码提示**

![密码提示截图](https://raw.github.com/domOrielton/minimal-web-notepad/screenshots/mn_password_prompt.png)

“以只读方式查看”链接显示注释文本，没有其他内容

**复制到剪贴板的链接**

![复制截图](https://raw.github.com/domOrielton/minimal-web-notepad/screenshots/mn_copy.png)

**注意列表** - 通常只用于不公开的 URL，尽管该页面受密码保护

![笔记列表截图](https://raw.github.com/domOrielton/minimal-web-notepad/screenshots/mn_notelist.png)

如果您不希望显示笔记列表，则在 index.php 的顶部将 $allow_noteslist 参数设置为 false 或将 `notelist.php` 重命名为其他名称。笔记列表页面的密码在 `notelist.php` 的顶部 - Protect\with('modules/protect_form.php', 'change the password here');

**替代编辑视图**

还有一个替代编辑视图，可以通过在注释后添加 ?simple 来访问，例如/快速？简单。我个人觉得这个视图对于在我的手机上添加非常快速的笔记非常有用 - 它在页面顶部有一个小的编辑区域，当你输入文本并点击换行符时，它会将它添加到笔记中并将其移动到视图占据页面的其余部分。此视图部分将 URL 显示为可点击的链接。您不能在此视图上设置密码，但它确实尊重它们。

![复制截图](https://raw.github.com/domOrielton/minimal-web-notepad/screenshots/mn_simple.png)

安装
------------

只要启用了 mod_rewrite 并且允许 Web 服务器写入 `_notes` 数据目录，就不需要进行任何配置。此数据目录在 `config.php` 中设置，因此如果您想将其更改为原始 pereorga/minimalist-web-notepad 版本使用的文件夹，请在此处更改。所有笔记都存储为文本文件，因此运行 Apache（或 Nginx）的服务器就足够了，不需要数据库。

如果笔记没有保存，那么请检查 `_notes` 目录的权限 - 0755 或 744 应该是所需要的。

![权限截图](https://raw.github.com/domOrielton/minimal-web-notepad/screenshots/mn_permissions.png)

还有一个 `setup.php` 页面，可用于检查 `_notes` 目录是否存在并可以写入。如果您在保存笔记时遇到困难，可能值得删除 `_notes` 目录，然后转到 `setup.php` 页面来创建文件夹。如果一切正常，那么您可以根据需要删除 `setup.php` 文件。

在某些情况下，`config.php` 中的 $base_url 变量需要替换为您安装的硬编码 URL 路径。如果是这种情况，只需将 `config.php` 中以 `$base_url = dirname('//'` 开头的行替换为 `$base_url ='http://actualURL.com/notes'` 将 actualURL.com/notes 替换为与您的安装相关的任何内容。

### 在阿帕奇上

您可能需要启用 mod_rewrite 并在站点配置中设置 `.htaccess` 文件。
请参阅 [如何为 Apache 设置 mod_rewrite](https://www.digitalocean.com/community/tutorials/how-to-set-up-mod_rewrite-for-apache-on-ubuntu-14-04)。

## 在 nginx 上

在 nginx 上，您需要确保正确配置 nginx.conf 以确保应用程序按预期工作。
请检查 nginx.conf.example 文件或[查看无密码问题](https://github.com/domOrielton/minimal-web-notepad/issues/4)。 示例文件归功于 [eonegh](https://github.com/eonegh)。