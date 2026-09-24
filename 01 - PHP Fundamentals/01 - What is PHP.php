<!-- PHP - PHP: Hypertext Preprocessor
it s a widely used, open-source, server-side scripting language specifically designed for web development


Server-Side Execution: Unlike HTML, CSS, or JavaScript which execute in the user's browser, PHP code executes entirely on the server. The end-user never sees the raw PHP code, only the final HTML result.

Cross-Platform Compatibility: PHP runs on all major operating systems—including Linux, Windows, Unix, and macOS—and works natively with major web servers like Apache, Nginx, and IIS.

Database Support: It connects effortlessly to almost all modern database management systems, most notably MySQL, PostgreSQL, Oracle, and MongoDB

Dynamic Web Pages: Generating live content that updates based on who is logged in, the time of day, or user inputs.

Form Data Handling: Collecting information securely from user-submitted web forms, validating inputs, and saving them to databases

Session Management: Tracking user authentication and keeping users logged in across multiple pages.

File & Data Manipulation: Creating, reading, modifying, and closing files directly on the server. It can also encrypt data or output custom file types like images, JSON, and PDFs
 -->
<?php
$name = "Monu Giri";
?>
<!DOCTYPE html>
<html>
<body>
<h1><?php echo $name; ?></h1>
<h1><?=$name?></h1>
</body>
</html>