<?php

$erros = $_SESSION['erros_produto'] ?? [];
$sucesso = $_SESSION['sucesso_produto'] ?? null;
$dados = $_SESSION['dados_produto'] ?? [];

unset(
    $_SESSION['erros_produto'],
    $_SESSION['sucesso_produto'],
    $_SESSION['dados_produto']
);

function escaparProduto($valor): string
{
    return htmlspecialchars(
        (string) ($valor ?? ''),
        ENT_QUOTES,
        'UTF-8'
    );
}
?>
<link rel="stylesheet" type="text/css" href="./assets/css/transptech.css">
<link rel="stylesheet" href="assets/css/produtos.css">

<div class="tt-products">

    <header class="tt-products__header">
        <div>
            <span class="tt-products__eyebrow">TRANSPTECH / ESTOQUE</span>
            <h1 class="tt-products__title">Cadastro de produtos</h1>
            <p class="tt-products__subtitle">
                Gerencie os produtos utilizados nas entregas.
            </p>
        </div>
    </header>

    <?php if ($sucesso): ?>
        <div class="tt-products__alert tt-products__alert--success">
            <?= escaparProduto($sucesso) ?>
        </div>
    <?php endif; ?>

    <?php if ($erros): ?>
        <div class="tt-products__alert tt-products__alert--error">
            <ul>
                <?php foreach ($erros as $erro): ?>
                    <li><?= escaparProduto($erro) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <section class="tt-products__panel">
        <div class="tt-products__section-heading">
            <h2>Novo produto</h2>
            <span>Preencha os dados abaixo</span>
        </div>

        <form
            class="tt-products__form"
            action="index.php?pagina=produtoController"
            method="POST"
        >
            <div class="tt-products__field tt-products__field--full">
                <label for="produto-nome">Nome do produto *</label>
                <input
                    type="text"
                    id="produto-nome"
                    name="nome"
                    maxlength="150"
                    value="<?= escaparProduto($dados['nome'] ?? '') ?>"
                    placeholder="Ex.: Caixa de papelão"
                    required
                >
            </div>

            <div class="tt-products__field tt-products__field--full">
                <label for="produto-descricao">Descrição</label>
                <textarea
                    id="produto-descricao"
                    name="descricao"
                    rows="3"
                    placeholder="Descreva o produto..."
                ><?= escaparProduto($dados['descricao'] ?? '') ?></textarea>
            </div>

            <div class="tt-products__field">
                <label for="produto-peso">Peso (kg) *</label>
                <input
                    type="number"
                    id="produto-peso"
                    name="peso"
                    min="0.001"
                    step="0.001"
                    value="<?= escaparProduto($dados['peso'] ?? '') ?>"
                    placeholder="Ex.: 2.500"
                    required
                >
            </div>

            <div class="tt-products__field">
                <label for="produto-valor">Valor (R$) *</label>
                <input
                    type="number"
                    id="produto-valor"
                    name="valor"
                    min="0"
                    step="0.01"
                    value="<?= escaparProduto($dados['valor'] ?? '') ?>"
                    placeholder="Ex.: 149.90"
                    required
                >
            </div>

            <div class="tt-products__field">
                <label for="produto-quantidade">
                    Quantidade em estoque *
                </label>
                <input
                    type="number"
                    id="produto-quantidade"
                    name="quantidade_estoque"
                    min="0"
                    step="1"
                    value="<?= escaparProduto($dados['quantidade_estoque'] ?? '0') ?>"
                    placeholder="Ex.: 50"
                    required
                >
            </div>

            <div class="tt-products__actions tt-products__field--full">
                <button type="reset" class="tt-products__button tt-products__button--secondary">
                    Limpar
                </button>

                <button type="submit" class="tt-products__button tt-products__button--primary">
                    Cadastrar produto
                </button>
            </div>
        </form>
    </section>

    <section class="tt-products__panel">
        <div class="tt-products__section-heading">
            <h2>Produtos cadastrados</h2>
            <span><?= count($produtos) ?> registro(s)</span>
        </div>

        <div class="tt-products__table-wrapper">
            <table class="tt-products__table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Produto</th>
                        <th>Peso</th>
                        <th>Valor</th>
                        <th>Estoque</th>
                    </tr>
                </thead>

                <tbody>
                    <?php if (empty($produtos)): ?>
                        <tr>
                            <td colspan="5" class="tt-products__empty">
                                Nenhum produto cadastrado ainda.
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($produtos as $produto): ?>
                            <tr>
                                <td><?= escaparProduto($produto['id_produto']) ?></td>
                                <td>
                                    <strong>
                                        <?= escaparProduto($produto['nome']) ?>
                                    </strong>
                                    <small>
                                        <?= escaparProduto($produto['descricao']) ?>
                                    </small>
                                </td>
                                <td>
                                    <?= escaparProduto($produto['peso']) ?> kg
                                </td>
                                <td>
                                    R$ <?= number_format(
                                        (float) $produto['valor'],
                                        2,
                                        ',',
                                        '.'
                                    ) ?>
                                </td>
                                <td>
                                    <?= escaparProduto(
                                        $produto['quantidade_estoque']
                                    ) ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </section>

</div>
