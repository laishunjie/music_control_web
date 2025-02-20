1.下载安装PHP8.1以上并部署
2.导入到apache
3.当前文件夹运行php -S 电脑IP:8090 server.php
4.浏览器运行http://电脑IP/music/remote.html
上一曲: Ctrl + ←
下一曲: Ctrl + →
播放/暂停: Ctrl + ↓
音量增加:Ctrl+F4
音量减少:Ctrl+F6

### **如何修改绑定？**
修改 `server.php` 中的键位代码即可：

// 示例：改为 Ctrl+↑ 和 Ctrl+↓
const HOTKEYS = [
    'vol_up'    => '^{UP}',     // Ctrl + ↑
    'vol_down'  => '^{DOWN}'    // Ctrl + ↓
];

### **常用键位代码表**
| 功能         | 代码          | 说明                  |
|--------------|--------------|-----------------------|
| Ctrl         | `^`          | 控制键                |
| Alt          | `%`          | 替代键                |
| Shift        | `+`          | 上档键                |
| F1-F12       | `{F1}`-`{F12}` | 功能键                |
| 方向键       | `{UP}`, `{DOWN}`, `{LEFT}`, `{RIGHT}` | 上下左右 |
