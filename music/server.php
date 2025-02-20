<?php
// server.php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

// 增强日志功能
file_put_contents('requests.log', 
    date('[Y-m-d H:i:s]') . " " . 
    $_SERVER['REMOTE_ADDR'] . " " . 
    $_SERVER['REQUEST_METHOD'] . " " . 
    $_SERVER['REQUEST_URI'] . "\n",
    FILE_APPEND
);

const HOTKEYS = [
    'prev'      => '^{LEFT}',
    'next'      => '^{RIGHT}',
    'play'      => '^{DOWN}',
    'vol_up'    => '^{F4}',
    'vol_down'  => '^{F6}'
];

try {
    // 参数验证
    $action = strtolower($_GET['action'] ?? '');
    if (!isset(HOTKEYS[$action])) {
        throw new RuntimeException('无效操作指令', 400);
    }

    // 执行命令并记录详细日志
    $psCmd = "Add-Type -AssemblyName System.Windows.Forms; [Windows.Forms.SendKeys]::SendWait('".HOTKEYS[$action]."');";
    exec("powershell -Command \"$psCmd\" 2>&1", $output, $exitCode);
    
    file_put_contents('commands.log', 
        "[" . date('Y-m-d H:i:s') . "]\n" . 
        "命令: $psCmd\n" . 
        "输出: " . implode("\n", $output) . "\n" .
        "状态码: $exitCode\n\n", 
        FILE_APPEND
    );

    if ($exitCode !== 0) {
        throw new RuntimeException("命令执行失败", 500);
    }

    echo json_encode(['status' => 'success']);
    
} catch (RuntimeException $e) {
    http_response_code($e->getCode());
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}