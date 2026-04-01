#!/usr/bin/env php
<?php
/**
 * PHP SDK API 类生成器
 * 自动从 api-definitions.json 生成 SDK 代码。
 */

$baseDir = __DIR__ . '/src/Api';
$apiDefinitionsPath = __DIR__ . '/../tools/api-definitions.json';

if (!file_exists($apiDefinitionsPath)) {
    echo "❌ 找不到 API 定义文件: {$apiDefinitionsPath}\n";
    exit(1);
}

$apiDefinitions = json_decode(file_get_contents($apiDefinitionsPath), true);
$modules = $apiDefinitions['modules'] ?? [];

function toCamelCase($string) {
    if (empty($string)) return '';
    $words = explode('-', $string);
    $camelCase = $words[0];
    for ($i = 1; $i < count($words); $i++) {
        $camelCase .= ucfirst($words[$i]);
    }
    return $camelCase;
}

function generateApiClass($moduleName, $apis)
{
    $className = ucfirst($moduleName) . "Api";
    
    $code = "<?php\n\n";
    $code .= "namespace JiuWuFen\\Sdk\\Api;\n\n";
    $code .= "use JiuWuFen\\Sdk\\JiuWuFenClient;\n";
    $code .= "use JiuWuFen\\Sdk\\Exception\\ApiException;\n\n";
    $code .= "/**\n";
    $code .= " * " . ucfirst($moduleName) . " API\n";
    $code .= " *\n";
    $code .= " * @package JiuWuFen\\Sdk\\Api\n";
    $code .= " */\n";
    $code .= "class {$className}\n";
    $code .= "{\n";
    $code .= "    /**\n";
    $code .= "     * @var JiuWuFenClient 客户端实例\n";
    $code .= "     */\n";
    $code .= "    private JiuWuFenClient \$client;\n\n";
    $code .= "    /**\n";
    $code .= "     * 构造函数\n";
    $code .= "     *\n";
    $code .= "     * @param JiuWuFenClient \$client\n";
    $code .= "     */\n";
    $code .= "    public function __construct(JiuWuFenClient \$client)\n";
    $code .= "    {\n";
    $code .= "        \$this->client = \$client;\n";
    $code .= "    }\n";
    
    foreach ($apis as $api) {
        $methodName = toCamelCase($api['id']);
        $path = $api['path'];
        $doc = !empty($api['description']) ? $api['description'] : $api['name'];
        
        $code .= "\n";
        $code .= "    /**\n";
        $code .= "     * {$doc}\n";
        $code .= "     *\n";
        $code .= "     * @param array \$data 请求数据\n";
        $code .= "     * @return array 响应数据\n";
        $code .= "     * @throws ApiException\n";
        $code .= "     */\n";
        $code .= "    public function {$methodName}(array \$data = []): array\n";
        $code .= "    {\n";
        $code .= "        return \$this->client->request('{$path}', \$data);\n";
        $code .= "    }\n";
    }
    
    $code .= "}\n";
    
    return $code;
}

// 清理旧的 API 文件
if (is_dir($baseDir)) {
    foreach (glob($baseDir . '/*.php') as $oldFile) {
        unlink($oldFile);
    }
}
if (!is_dir($baseDir)) {
    mkdir($baseDir, 0755, true);
}

echo "开始生成 PHP SDK API 类...\n";

$generatedClasses = [];

foreach ($modules as $moduleName => $apis) {
    if (empty($moduleName)) continue;
    
    $className = ucfirst($moduleName) . 'Api';
    $code = generateApiClass($moduleName, $apis);
    $filePath = $baseDir . '/' . $className . '.php';
    
    file_put_contents($filePath, $code);
    echo "✅ 生成: Api/{$className}.php\n";
    $generatedClasses[$moduleName] = $className;
}

// 更新 JiuWuFenClient.php 的 API 注册
$clientPath = __DIR__ . '/src/JiuWuFenClient.php';
if (file_exists($clientPath)) {
    $clientCode = file_get_contents($clientPath);

    // 重建 use 声明块
    $useBlock = '';
    foreach ($generatedClasses as $modName => $cls) {
        $useBlock .= "use JiuWuFen\\Sdk\\Api\\{$cls};\n";
    }

    // 重建属性声明
    $propBlock = '';
    foreach ($generatedClasses as $modName => $cls) {
        $varName = lcfirst($cls);
        $propBlock .= "    private {$cls} \${$varName};\n";
    }

    // 重建初始化代码
    $initBlock = '';
    foreach ($generatedClasses as $modName => $cls) {
        $varName = lcfirst($cls);
        $initBlock .= "        \$this->{$varName} = new {$cls}(\$this);\n";
    }

    // 重建 getter 方法
    $getterBlock = '';
    foreach ($generatedClasses as $modName => $cls) {
        $varName = lcfirst($cls);
        $getterBlock .= "\n    public function get{$cls}(): {$cls}\n    {\n        return \$this->{$varName};\n    }\n";
    }

    // 替换 use 导入块（从第一个 Api use 到 use JiuWuFen\Sdk\Exception）
    $clientCode = preg_replace(
        '/use JiuWuFen\\\\Sdk\\\\Api\\\\.*?;(\nuse JiuWuFen\\\\Sdk\\\\Api\\\\.*?;)*\n/',
        $useBlock,
        $clientCode
    );

    file_put_contents($clientPath, $clientCode);
    echo "✅ 已更新: src/JiuWuFenClient.php\n";
}

echo "\n✨ 所有 API 类生成完成！\n";
