<!DOCTYPE html>
<html>
<head>
    <title>K-Tech</title>
    <script src="Resources/js/jquery.min.js"></script>
    <script src="Resources/js/jquery-ui.min.js" defer></script>
    <script src="Resources/js/alpine.min.js" defer></script>
    <script src="Resources/js/tailwind.min.js"></script>
    <link rel="stylesheet" href="Resources/css/jquery-ui.min.css">
    <link rel="stylesheet" href="Resources/css/jquery-ui.theme.min.css">
    <link rel="stylesheet" href="Resources/css/jquery-ui.structure.min.css">
</head>
<body>
    <?php
        
        session_start();

        $request = $_SERVER['REQUEST_URI'];
        switch ($request) {
            case '/' :
                require __DIR__ . '/Views/index.php';
                break;
            default:
                http_response_code(404);
                break;
        }
    ?>
    <script src="Resources/js/index.js"></script>
</body>
</html>