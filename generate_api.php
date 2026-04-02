#!/usr/bin/env php
<?php
/**
 * PHP SDK API 类生成器
 * 自动从 api-definitions.json 生成 SDK 代码；PHPDoc 中带树状层级请求/响应字段说明。
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

/**
 * 点分路径建树：segment => [ param|null, children ]
 */
function buildParamTree(array $params): array {
    $tree = [];
    foreach ($params as $p) {
        $name = $p['name'] ?? '';
        $parts = array_values(array_filter(explode('.', $name), function ($x) {
            return $x !== '';
        }));
        if (count($parts) === 0) {
            continue;
        }
        $cur = &$tree;
        foreach ($parts as $i => $part) {
            if (!isset($cur[$part])) {
                $cur[$part] = ['param' => null, 'children' => []];
            }
            if ($i === count($parts) - 1) {
                $cur[$part]['param'] = $p;
            }
            $cur = &$cur[$part]['children'];
        }
    }
    return $tree;
}

/**
 * @return string[] 无前缀的说明行
 */
function formatParamTreeLines(array $tree, string $basePath, int $depth): array {
    $lines = [];
    ksort($tree);
    foreach ($tree as $seg => $node) {
        $path = $basePath === '' ? $seg : ($basePath . '.' . $seg);
        $prefix = str_repeat('  ', 2 + $depth);
        if ($node['param'] !== null) {
            $pp = $node['param'];
            $typ = $pp['type'] ?? 'mixed';
            $req = !empty($pp['required']) ? '必填' : '选填';
            $d = isset($pp['description']) ? trim((string) $pp['description']) : '';
            $descSuffix = $d !== '' ? (': ' . $d) : '';
            $lines[] = $prefix . '- ' . $path . ' (' . $typ . ', ' . $req . ')' . $descSuffix;
        }
        if (!empty($node['children'])) {
            $lines = array_merge($lines, formatParamTreeLines($node['children'], $path, $depth + 1));
        }
    }
    return $lines;
}

function hierarchyDocBlockLines(array $params): array {
    if (empty($params)) {
        return ['    （无）'];
    }
    $tree = buildParamTree($params);
    $lines = formatParamTreeLines($tree, '', 0);
    return $lines ?: ['    （无）'];
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
        $reqLines = hierarchyDocBlockLines($api['requestParams'] ?? []);
        $respLines = hierarchyDocBlockLines($api['responseParams'] ?? []);

        $code .= "\n";
        $code .= "    /**\n";
        $code .= "     * {$doc}\n";
        $code .= "     *\n";
        $code .= "     * 请求体字段（树状层级，与文档点分路径一致）:\n";
        foreach ($reqLines as $L) {
            $code .= "     * {$L}\n";
        }
        $code .= "     *\n";
        $code .= "     * 响应字段（树状层级，对照文档）:\n";
        foreach ($respLines as $L) {
            $code .= "     * {$L}\n";
        }
        $code .= "     *\n";
        $code .= "     * @param array \$data 完整请求体（须包含各层级嵌套结构）\n";
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

    $useBlock = '';
    foreach ($generatedClasses as $modName => $cls) {
        $useBlock .= "use JiuWuFen\\Sdk\\Api\\{$cls};\n";
    }

    $clientCode = preg_replace(
        '/use JiuWuFen\\\\Sdk\\\\Api\\\\.*?;(\nuse JiuWuFen\\\\Sdk\\\\Api\\\\.*?;)*\n/',
        $useBlock,
        $clientCode
    );

    file_put_contents($clientPath, $clientCode);
    echo "✅ 已更新: src/JiuWuFenClient.php\n";
}

echo "\n✨ 所有 API 类生成完成！\n";
