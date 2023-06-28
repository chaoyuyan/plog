function edit_log($file) {//传递文件路径过来编辑
    $json_str = file_get_contents($file);
    $json = json_decode($json_str);
    $title = $json->title;
    $content = $json->content;

    echo "<form method='post' action=''>";
    echo "Title: <input type='text' name='title' value='$title'><br>";
    echo "Content: <textarea name='content'>$content</textarea><br>";
    echo "<input type='hidden' name='file' value='$file'>";
    echo "<input type='submit' name='submit' value='Save'>";
    echo "</form>";
}

if (isset($_POST['submit'])) {
    $file = $_POST['file'];
    $title = $_POST['title'];
    $content = $_POST['content'];

    $json = array(
        'title' => $title,
        'content' => $content
    );

    $log = fopen($file, "w");
    fwrite($log, json_encode($json));
    fclose($log);
}
