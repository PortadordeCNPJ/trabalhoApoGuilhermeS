<?php

$erros = $_SESSION['erros_frete'] ?? [];
$sucesso = $_SESSION['sucesso_frete'] ?? null;

unset($_SESSION['erros_frete'], $_SESSION['sucesso_frete']);

$transportadores = $dados['transportadores'] ?? [];
$enderecos = $dados['enderecos'] ?? [];
$produtos = $dados['produtos'] ?? [];

function escaparFrete($valor): string
{
    return htmlspecialchars((string) $valor, ENT_QUOTES, 'UTF-8');
}
?>

<link rel="stylesheet" href="./assets/css/fretes.css">

<main class="tt-freight">
    <div class="tt-freight-form-container">
        <header class="tt-freight-header">
            <div>
                <span class="tt-freight-eyebrow">TRANSPTECH / OPERAÇÕES</span>
                <h1>Cadastro de fretes</h1>
                <p>Organize suas entregas em um só lugar.</p>
            </div>
        </header>

        <?php if (!empty($sucesso)): ?>
            <div class="tt-freight-alert success">
                <?= escaparFrete($sucesso) ?>
            </div>
        <?php endif; ?>

        <?php if (!empty($erros)): ?>
            <div class="tt-freight-alert error">
                <strong>Não foi possível cadastrar o frete:</strong>
                <ul>
                    <?php foreach ($erros as $erro): ?>
                        <li><?= escaparFrete($erro) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <form
            action="index.php?pagina=freteController"
            method="POST"
            class="tt-freight-form">

            <section class="tt-freight-card">

                <div class="tt-freight-section-title">
                    <span>01</span>
                    <div>
                        <h2>Informações da entrega</h2>
                        <p>Defina quem realizará o transporte e o trajeto.</p>
                    </div>
                </div>

                <div class="tt-freight-grid">

                    <div class="tt-freight-field">
                        <label for="transportador_id">Transportador</label>

                        <select name="transportador_id" id="transportador_id" required>
                            <option value="">Selecione um transportador</option>

                            <?php foreach ($transportadores as $transportador): ?>
                                <option value="<?= escaparFrete($transportador['id_transportador']) ?>">
                                    <?= escaparFrete($transportador['nome']) ?>
                                    — <?= escaparFrete($transportador['tipo_veiculo']) ?>
                                    (<?= escaparFrete($transportador['placa']) ?>)
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="tt-freight-field">
                        <label for="data_frete">Data do frete</label>
                        <input
                            type="date"
                            name="data_frete"
                            id="data_frete"
                            value="<?= date('Y-m-d') ?>"
                            required>
                    </div>

                    <div class="tt-freight-field">
                        <label for="endereco_origem_id">Endereço de origem</label>

                        <select name="endereco_origem_id" id="endereco_origem_id" required>
                            <option value="">Selecione a origem</option>

                            <?php foreach ($enderecos as $endereco): ?>
                                <option value="<?= escaparFrete($endereco['id_endereco']) ?>">
                                    <?= escaparFrete($endereco['identificacao']) ?>
                                    — <?= escaparFrete($endereco['cidade']) ?>/<?= escaparFrete($endereco['estado']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="tt-freight-field">
                        <label for="endereco_destino_id">Endereço de destino</label>

                        <select name="endereco_destino_id" id="endereco_destino_id" required>
                            <option value="">Selecione o destino</option>

                            <?php foreach ($enderecos as $endereco): ?>
                                <option value="<?= escaparFrete($endereco['id_endereco']) ?>">
                                    <?= escaparFrete($endereco['identificacao']) ?>
                                    — <?= escaparFrete($endereco['cidade']) ?>/<?= escaparFrete($endereco['estado']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="tt-freight-field">
                        <label for="valor_frete">Valor do frete (R$)</label>
                        <input
                            type="number"
                            name="valor_frete"
                            id="valor_frete"
                            min="0"
                            step="0.01"
                            placeholder="Ex.: 150.00"
                            required>
                    </div>

                </div>
            </section>

            <section class="tt-freight-card">

                <div class="tt-freight-section-title">
                    <span>02</span>
                    <div>
                        <h2>Produtos transportados</h2>
                        <p>Adicione os produtos e suas respectivas quantidades.</p>
                    </div>
                </div>

                <div id="tt-product-rows">

                    <div class="tt-product-row">
                        <div class="tt-freight-field">
                            <label>Produto</label>

                            <select name="produtos[0][id_produto]" required>
                                <option value="">Selecione um produto</option>

                                <?php foreach ($produtos as $produto): ?>
                                    <option
                                        value="<?= escaparFrete($produto['id_produto']) ?>"
                                        data-estoque="<?= escaparFrete($produto['quantidade_estoque']) ?>">
                                        <?= escaparFrete($produto['nome']) ?>
                                        — Estoque: <?= escaparFrete($produto['quantidade_estoque']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="tt-freight-field">
                            <label>Quantidade</label>
                            <input
                                type="number"
                                name="produtos[0][quantidade]"
                                min="1"
                                step="1"
                                placeholder="Quantidade"
                                required>
                        </div>
                    </div>

                </div>

                <button type="button" id="tt-add-product" class="tt-freight-add">
                    + Adicionar outro produto
                </button>

            </section>

            <section class="tt-freight-card">

                <div class="tt-freight-section-title">
                    <span>03</span>
                    <div>
                        <h2>Observações</h2>
                        <p>Informações adicionais sobre a operação.</p>
                    </div>
                </div>

                <div class="tt-freight-field">
                    <label for="observacoes">Observações (opcional)</label>
                    <textarea
                        name="observacoes"
                        id="observacoes"
                        rows="4"
                        placeholder="Adicione informações importantes sobre este frete..."></textarea>
                </div>

            </section>

            <div class="tt-freight-actions">
                <button type="reset" class="tt-freight-reset">
                    Limpar formulário
                </button>

                <button type="submit" class="tt-freight-submit">
                    Cadastrar frete
                </button>
            </div>

        </form>

        <section class="tt-freight-card tt-freight-list">

            <div class="tt-freight-section-title">
                <span>04</span>
                <div>
                    <h2>Fretes cadastrados</h2>
                    <p>Acompanhe as operações registradas no sistema.</p>
                </div>
            </div>

            <?php if (empty($fretes)): ?>

                <p class="tt-freight-empty">
                    Nenhum frete cadastrado até o momento.
                </p>

            <?php else: ?>

                <div class="tt-freight-table-wrapper">
                    <table class="tt-freight-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Transportador</th>
                                <th>Origem</th>
                                <th>Destino</th>
                                <th>Produtos</th>
                                <th>Data</th>
                                <th>Valor</th>
                                <th>Status</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php foreach ($fretes as $frete): ?>
                                <tr>
                                    <td>#<?= escaparFrete($frete['id_frete']) ?></td>
                                    <td><?= escaparFrete($frete['transportador']) ?></td>
                                    <td><?= escaparFrete($frete['origem']) ?></td>
                                    <td><?= escaparFrete($frete['destino']) ?></td>
                                    <td><?= escaparFrete($frete['produtos'] ?? '—') ?></td>
                                    <td>
                                        <?= date('d/m/Y', strtotime($frete['data_frete'])) ?>
                                    </td>
                                    <td>
                                        R$ <?= number_format((float) $frete['valor_frete'], 2, ',', '.') ?>
                                    </td>
                                    <td>
                                        <span class="tt-freight-status">
                                            <?= escaparFrete($frete['status']) ?>
                                        </span>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

            <?php endif; ?>

        </section>
    </div>
</main>