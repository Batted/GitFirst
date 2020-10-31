<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <link href="css/style.css" rel="stylesheet" type="text/css" />
    <!-- подключение css -->
    <script src="script.js"></script>
    <link href="img/favicon.ico" rel="shortcut icon" type="image/x-icon" />
    <!-- иконка -->
    <title> Soulmate </title>
</head>

<body>
    <div id="page-wrap">
        <!--Прикрепление футера к низу-->
        <?php require_once __DIR__.DIRECTORY_SEPARATOR.'header.php'; ?>
        <div class="contact">
            <?php
            if (isset($_SESSION['Message']) && !empty($_SESSION['Message'])) : ?>
                <p class="ERPauth"> <?= $_SESSION['Message'] ?></p>
            <?php endif;
            unset($_SESSION['Message']);
            ?>
        </div>
        <center>
            <div id="menu">
                <img src="img/anime.gif" aling="bottom">
                    Разделы
                <hr />
            </div>
            <div id="menuhrefs">
                <a href="index.php">
                    Главная
                </a>
                <a href="feedback.php">
                    Обратная связь
                </a>
            </div>
        </center>
        <div id="container">
            <div class="grid">
                <div class="grid-item">
                    <img src="img/sea.gif" alt="Изображение" title="Изображение" />
                </div>
                <div class="grid-item">
                    <img src="img/flower.jpg" alt="Изображение" title="Изображение" />
                    <h2>Генетики выяснили, как подсолнух поворачивается к Солнцу</h2>
                    <p>Подсолнухи обладают удивительным умением постоянно "смотреть" на Солнце благодаря мутации,
                        поменявшей работу их "внутренних часов" таким образом, что они крайне необычно дирижируют
                        ростом его клеток, заставляя соцветие вращаться с востока на запад в светлое время суток,
                        говорится в статье, опубликованной в журнале
                        <a href="https://science.sciencemag.org/content/353/6299/587" target="_blank" alt="Статья про подсолнухи" title="Статья про подсолнухи">Science</a>.</p>
                </div>
                <div class="grid-item">
                    <img src="img/mountains.jpg" alt="Изображение" title="Изображение" />
                    <blockquote>"Лучше гор могут быть только горы"<cite>- В.Высоцкий.</cite></blockquote>
                </div>
            </div>
            <center>
                <div class="clear">
                    <div id="main_soc_block">
                        <div id="main_soc_block_in">
                            <h3>Внимание!!!</h3>
                            <p><ins><em>Не</em></ins> обижайте котиков.</p>
                        </div>
                    </div>
                </div>
            </center>
        </div>
    </div>
    <?php require_once __DIR__.DIRECTORY_SEPARATOR.'footer.php'; //Директория?>
    
</body>
</html>