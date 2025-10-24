<?php

$dbPath = __DIR__ . '/banco.sqlite';
$pdo = new PDO('sqlite:' . $dbPath);
$videoList = $pdo->query("SELECT * FROM videos")->fetchAll(PDO::FETCH_ASSOC);

//foreach ($videoList as $video) {
//    echo $video['id'] . " - " . $video['url'] . " - " . $video['title'] . ";\n";
//}
//exit;

?>
<?php require_once 'cabecalho-html.php'; ?>

    <ul class="videos__container">
        <?php foreach ($videoList as $video) : ?>
            <?php if (!is_null($video['url']) && str_starts_with($video['url'], 'http')) : ?>
                <li class="videos__item">
                    <iframe width="100%" height="72%" src="<?= $video['url']; ?>"
                        title="YouTube video player"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                        allowfullscreen></iframe>
                    <div class="descricao-video">
                        <img src="public/img/logo.png" alt="logo canal alura">
                        <h3><?= $video['title']; ?></h3>
                        <div class="acoes-video">
                            <a href="/editar-video?id=<?= $video['id']; ?>">Editar</a>
                            <a href="/remover-video?id=<?= $video['id'] ?>">Excluir</a>
                        </div>
                    </div>
                </li>
            <?php endif; ?>
        <?php endforeach; ?>
    </ul>

<?php require_once 'rodape-html.php'; ?>