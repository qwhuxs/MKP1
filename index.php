<?php
require_once 'LightHTML.php';
require_once 'AddClassCommand.php';
require_once 'RemoveClassCommand.php';
require_once 'SetAttributeCommand.php';
require_once 'VisitorInterface.php';
require_once 'CountVisitor.php';

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

$list->addHook('onCreated', function ($node) {
    echo "✔️ Список був створений.<br>";
});

$item1->addHook('onInserted', function ($node) {
    echo "➕ Пункт 1 доданий до списку.<br>";
});

$item2->addHook('onRemoved', function ($node) {
    echo "❌ Пункт 2 був видалений зі списку.<br>";
});

if (isset($_GET['remove'])) {
    $list->removeChild($item2);
}

$command1 = new AddClassCommand($item1, 'active');
$command1->execute();

$command2 = new SetAttributeCommand($item2, 'data-info', 'другий');
$command2->execute();

$command3 = new RemoveClassCommand($item3, 'highlight');
$command3->execute();

$visitor = new CountVisitor();
$visitor->visit($list);
$counts = $visitor->getResults();

$breadthIterator = new BreadthIterator($list);  
$depthIterator = new DepthIterator($list);     
?>

<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LightHTML – Ітератори</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<div class="container">
    <h1>🧩 LightHTML – Шаблон "Ітератори"</h1>

    <h2>Фактичний HTML:</h2>
    <?= $list->outerHTML() ?>

    <h2>🔍 Підрахунок елементів (Visitor):</h2>
    <ul>
        <?php foreach ($counts as $tag => $count): ?>
            <li><code>&lt;<?= $tag ?>&gt;</code>: <?= $count ?></li>
        <?php endforeach; ?>
    </ul>

    <h2>🌿 DOM у ширину (BreadthIterator):</h2>
    <ul style="font-family: monospace;">
        <?php
        function getNodeLevel($node) {
            $level = 0;
            while ($node = $node->getParent()) {
                $level++;
            }
            return $level;
        }

        foreach ($breadthIterator as $node):
            $level = getNodeLevel($node);
            $indent = str_repeat("&nbsp;&nbsp;&nbsp;", $level);
        ?>
            <li>
                <?= $indent ?>
                <?php if ($node instanceof LightElementNode): ?>
                    📦 <code>&lt;<?= $node->getTagName() ?>&gt;</code>
                <?php elseif ($node instanceof LightTextNode): ?>
                    📝 <em>"<?= htmlspecialchars($node->getText()) ?>"</em>
                <?php endif; ?>
            </li>
        <?php endforeach; ?>
    </ul>

    <h2>🌿 DOM в глибину (DepthIterator):</h2>
<ul style="font-family: monospace;">
    <?php
    $depthIterator->rewind(); 
    while ($depthIterator->valid()):
        $node = $depthIterator->current();
        $level = getNodeLevel($node);
        $indent = str_repeat("&nbsp;&nbsp;&nbsp;", $level);
    ?>
        <li>
            <?= $indent ?>
            <?php if ($node instanceof LightElementNode): ?>
                📦 <code>&lt;<?= $node->getTagName() ?>&gt;</code>
            <?php elseif ($node instanceof LightTextNode): ?>
                📝 <em>"<?= htmlspecialchars($node->getText()) ?>"</em>
            <?php endif; ?>
        </li>
    <?php
        $depthIterator->next();
    endwhile;
    ?>
</ul>

    <h2>📚 Тест getText() і getParent():</h2>
    <p>
        Текст в <code>item1</code>: <strong><?= $item1->getChildren()[0]->getText() ?></strong><br>
        Батько цього текстового вузла: 
        <code>&lt;<?= $item1->getChildren()[0]->getParent()->getTagName() ?>&gt;</code>
    </p>

    <h2>➕ Додати пункт:</h2>
    <button onclick="addListItem()">Додати пункт</button>

    <h2>➖ Видалити елемент:</h2>
    <a href="?remove=1"><button>Видалити другий пункт</button></a>
</div>

<script>
    let counter = 4;
    function addListItem() {
        const ul = document.querySelector('ul.list');
        const li = document.createElement('li');
        li.textContent = `Новий пункт ${counter++}`;
        ul.appendChild(li);
    }
</script>
</body>
</html>
