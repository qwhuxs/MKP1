<?php
require_once 'LightHTML.php';
require_once 'AddClassCommand.php';
require_once 'RemoveClassCommand.php';
require_once 'SetAttributeCommand.php';
require_once 'VisitorInterface.php';
require_once 'CountVisitor.php';
require_once 'DepthIterator.php';

// Створення списку та елементів
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

// Обробники подій
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

$walker = new DepthIterator($list);

// Стейт для елементів
class ElementState {
    private $state;
    public function __construct($state = "inactive") {
        $this->state = $state;
    }
    public function setState($state) {
        $this->state = $state;
    }
    public function getState() {
        return $this->state;
    }
}

$itemState = new ElementState();

?>

<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LightHTML – Шаблон "Стейт"</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<div class="container">
    <h1>🧩 LightHTML – Шаблон "Стейт"</h1>

    <h2>Фактичний HTML:</h2>
    <?= $list->outerHTML() ?>

    <h2>🔍 Підрахунок елементів:</h2>
    <ul>
        <?php foreach ($counts as $tag => $count): ?>
            <li><code>&lt;<?= $tag ?>&gt;</code>: <?= $count ?></li>
        <?php endforeach; ?>
    </ul>

    <h2>🌿 DOM у глибину:</h2>
    <ul>
        <?php foreach ($walker as $node): ?>
            <?php if ($node instanceof LightElementNode): ?>
                <li><code><?= $node->getTagName() ?></code></li>
            <?php endif; ?>
        <?php endforeach; ?>
    </ul>

    <h2>➕ Додати пункт:</h2>
    <button onclick="addListItem()">Додати пункт</button>

    <h2>➖ Видалити елемент:</h2>
    <a href="?remove=1"><button>Видалити другий пункт</button></a>

    <h2>🔄 Змінити стан елемента:</h2>
    <p>Текущий стан: <span id="state"><?= $itemState->getState() ?></span></p>
    <button onclick="changeState()">Перемкнути стан</button>

</div>

<script>
    let counter = 4;
    function addListItem() {
        const ul = document.querySelector('ul.list');
        const li = document.createElement('li');
        li.textContent = `Новий пункт ${counter++}`;
        ul.appendChild(li);
    }

    function changeState() {
        const stateSpan = document.getElementById('state');
        if (stateSpan.textContent === "inactive") {
            stateSpan.textContent = "active";
            stateSpan.style.color = "green";
        } else {
            stateSpan.textContent = "inactive";
            stateSpan.style.color = "red";
        }
    }
</script>
</body>
</html>
