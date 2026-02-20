<?php
// 子比主题页面模板模块代码
/**
 * 将文件数组导入为WordPress页面模板
 * 
 * @param array $pages_files_list 包含完整服务器路径的PHP文件数组
 * @param bool $overwrite 是否覆盖已存在的模板文件
 * @return array 导入结果信息
 */
function import_wp_page_templates($pages_files_list = [], $overwrite = false)
{
    $results = [
        'success' => [],
        'skipped' => [],
        'errors' => [],
        'summary' => [
            'total' => count($pages_files_list),
            'imported' => 0,
            'skipped' => 0,
            'failed' => 0
        ]
    ];

    // 获取子主题目录
    $child_theme_dir = get_stylesheet_directory();

    // 遍历文件列表并导入
    foreach ($pages_files_list as $file_path) {
        // 确保文件存在且可读
        if (! file_exists($file_path) || ! is_readable($file_path)) {
            $results['errors'][] = "文件不存在或不可读: {$file_path}";
            $results['summary']['failed']++;
            continue;
        }

        // 获取文件名和目标路径
        $file_name = basename($file_path);
        $target_path = trailingslashit($child_theme_dir) . $file_name;

        // 检查文件是否已存在
        if (file_exists($target_path) && ! $overwrite) {
            $results['skipped'][] = $file_name;
            $results['summary']['skipped']++;
            continue;
        }

        // 检查文件是否是PHP文件
        if (pathinfo($file_name, PATHINFO_EXTENSION) !== 'php') {
            $results['errors'][] = "文件不是PHP文件: {$file_name}";
            $results['summary']['failed']++;
            continue;
        }

        // 尝试读取模板名称
        $template_name = extract_template_name($file_path);

        // 复制文件
        if (copy($file_path, $target_path)) {
            $results['success'][] = [
                'file' => $file_name,
                'template_name' => $template_name ?: '未指定'
            ];
            $results['summary']['imported']++;
        } else {
            $results['errors'][] = "无法复制文件: {$file_name}";
            $results['summary']['failed']++;
        }
    }

    // 刷新主题缓存
    wp_clean_themes_cache();

    return $results;
}

/**
 * 从PHP文件中提取模板名称
 * 
 * @param string $file_path PHP文件路径
 * @return string|false 模板名称或false
 */
function extract_template_name($file_path)
{
    if (! file_exists($file_path)) {
        return false;
    }

    $content = @file_get_contents($file_path);
    if (preg_match('/Template Name:(.*)$/mi', $content, $matches)) {
        return trim($matches[1]);
    }

    return false;
}


$pages_files_list = array();

$result = import_wp_page_templates($pages_files_list);
