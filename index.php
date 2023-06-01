<?php
$correct_password = "123"; // 设置正确的密码

// 显示表单
function display_content_form() {
    echo "<form method='post' action=''>";
    echo "Password: <input type='password' name='password'><br>";
    echo "Title: <input type='text' name='title'><br>";
    echo "Content: <textarea name='content'></textarea><br>";
    echo "<input type='submit' name='submit' value='Submit'>";
    echo "</form>";
}

// 显示日志文件标题
function display_logs() {
    $log_files = glob("log/*.txt");
    foreach ($log_files as $file) {
        $title = basename($file, ".txt");
       echo "<a href='#' onclick='loadLog(\"$file\", \"$title\")'>$title</a><br>";


    }

}

// 处理表单提交
if (isset($_POST['submit'])) {
    $password = $_POST['password'];
    if ($password == $correct_password) {
        $title = $_POST['title'];
        $content = $_POST['content'];

        // 将标题和内容转换为UTF-8编码格式
      //  $title = mb_convert_encoding($title, 'UTF-8', 'auto');
		$title = iconv('UTF-8', 'GBK', $title);
        $content = mb_convert_encoding($content, 'UTF-8', 'auto');

        // 创建日志文件
        $log = fopen("log/{$title}.txt", "w");
        fwrite($log, $content);
        fclose($log);
    } else {
        echo "Incorrect password";
    }
}

// 显示表单和日志文件标题
//display_content_form();
//display_logs();
?>
<html>
<head>
<title>php blog</title>

 <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
</head>
<body>
<div class="container">
<div> <?php display_content_form(); ?></div>
<div> <?php display_logs(); ?></div>
<div id='logTitle'></div>
<div id='logContent'></div>
</div>


<script>
// JavaScript函数，用于异步加载txt文件并显示在div中
function loadLog(file, title) {
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            var content = this.responseText;
            // 将内容转换为HTML实体，以防止XSS攻击
            content = content.replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;');
            // 显示内容
            document.getElementById('logContent').innerHTML = content;
        }
    };
    xhr.open('GET', file, true);
    xhr.send();
    // 显示标题
    document.getElementById('logTitle').innerHTML = title;
}
</script>
<style>
input[type="text"], input[type="password"], textarea {
  border: none;
  border-bottom: 1px solid #ccc;
  font-size: 16px;
  padding: 10px;
  width: 100%;
}

input[type="submit"] {
  background-color: #007bff;
  border: none;
  color: #fff;
  cursor: pointer;
  font-size: 16px;
  padding: 10px 20px;
  transition: background-color 0.3s ease;
}

input[type="submit"]:hover {
  background-color: #0062cc;
}
a {
  color: #007bff;
  font-size: 18px;
  text-decoration: none;
}

a:hover {
  text-decoration: underline;
}
#logContent {
  background-color: #fff;
  border: 1px solid #ccc;
  font-size: 16px;
  padding: 10px;
  margin-top: 10px;
}
body {
  background-color: #f8f9fa;
  color: #333;
  font-family: Arial, sans-serif;
  font-size: 16px;
  line-height: 1.5;
}

.container {
  max-width: 800px;
  margin: 0 auto;
  padding: 20px;
}

   

</style>
</body>
</html>
