<?php
require_once 'LightHTML.php';

$list = new LightElementNode('ul', 'block', 'pair');
$list->addClass('list');

$item1 = new LightElementNode('li');
$item1->appendChild(new LightTextNode("Перший пункт"));

$item2 = new LightElementNode('li');
$item2->appendChild(new LightTextNode("Другий пункт"));

$item3 = new LightElementNode('li');
$item3->addClass('highlight');
$item3->appendChild(new LightTextNode("Третій пункт"));

$list->appendChild($item1);
$list->appendChild($item2);
$list->appendChild($item3);

if (isset($_GET['remove'])) {
    $list->removeChild($item2);
}
?>

<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <title>LightHTML – Базова версія</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h1>LightHTML – Базова версія</h1>

        <h2>outerHTML:</h2>
        <pre><?= htmlspecialchars($list->outerHTML()) ?></pre>

        <h2>innerHTML:</h2>
        <pre><?= htmlspecialchars($list->innerHTML()) ?></pre>

        <h2>Фактичний HTML:</h2>
        <?= $list->outerHTML() ?>

        <h2>➖ Видалити другий пункт:</h2>
        <a href="?remove=1"><button>Видалити</button></a>
    </div>
</body>
</html>
