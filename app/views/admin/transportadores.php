
<?php
$erros = $_SESSION['erros_transportador'] ?? [];
$sucesso = $_SESSION['sucesso_transportador'] ?? null;

unset($_SESSION['erros_transportador']);
unset($_SESSION['sucesso_transportador']);
?>

<main class="tt-transport">

    <section class="tt-transport__header">
        <div>
            <span class="tt-transport__eyebrow">
                GESTÃO LOGÍSTICA
            </span>

            <h1>Cadastro de transportadores</h1>

            <p>
                Cadastre motoristas e empresas responsáveis
                pelas operações de transporte da TranspTech.
            </p>
        </div>

        <div class="tt-transport__header-icon">
            🚚
        </div>
    </section>

    <?php if ($sucesso): ?>
        <div class="tt-transport__alert tt-transport__alert--success">
            <?= htmlspecialchars($sucesso, ENT_QUOTES, 'UTF-8') ?>
        </div>
    <?php endif; ?>

    <?php if (!empty($erros)): ?>
        <div class="tt-transport__alert tt-transport__alert--error">
            <strong>Não foi possível realizar o cadastro:</strong>

            <ul>
                <?php foreach ($erros as $erro): ?>
                    <li>
                        <?= htmlspecialchars($erro, ENT_QUOTES, 'UTF-8') ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <section class="tt-transport__card">

        <div class="tt-transport__card-header">
            <div>
                <h2>Informações do transportador</h2>
                <p>Preencha os dados para registrar um novo transportador.</p>
            </div>

            <span class="tt-transport__required">
                * Campos obrigatórios
            </span>
        </div>

        <form
            action="index.php?pagina=transportadorController"
            method="POST"
            class="tt-transport__form"
        >

            <div class="tt-transport__section-title">
                <span>01</span>
                Dados pessoais ou empresariais
            </div>

            <div class="tt-transport__field tt-transport__field--full">
                <label for="nome">Nome completo / Razão social *</label>

                <input
                    type="text"
                    id="nome"
                    name="nome"
                    placeholder="Ex.: João da Silva ou Transportes Silva LTDA"
                    maxlength="150"
                    required
                >
            </div>

            <div class="tt-transport__field">
                <label for="documento">CPF / CNPJ *</label>

                <input
                    type="text"
                    id="documento"
                    name="documento"
                    placeholder="Digite somente os números"
                    maxlength="18"
                    required
                >
            </div>

            <div class="tt-transport__field">
                <label for="telefone">Telefone com DDD *</label>

                <input
                    type="tel"
                    id="telefone"
                    name="telefone"
                    placeholder="(45) 99999-9999"
                    maxlength="15"
                    required
                >
            </div>

            <div class="tt-transport__section-title">
                <span>02</span>
                Informações do veículo
            </div>

            <div class="tt-transport__field">
                <label for="tipo_veiculo">Tipo de veículo *</label>

                <select
                    id="tipo_veiculo"
                    name="tipo_veiculo"
                    required
                >
                    <option value="">Selecione o veículo</option>
                    <option value="Moto">Motocicleta</option>
                    <option value="Carro">Carro</option>
                    <option value="Van">Van</option>
                    <option value="Caminhão">Caminhão</option>
                    <option value="Carreta">Carreta</option>
                    <option value="Outro">Outro</option>
                </select>
            </div>

            <div class="tt-transport__field">
                <label for="placa">Placa do veículo *</label>

                <input
                    type="text"
                    id="placa"
                    name="placa"
                    placeholder="ABC1D23"
                    maxlength="7"
                    required
                >
            </div>

            <div class="tt-transport__section-title">
                <span>03</span>
                Situação do cadastro
            </div>

            <label class="tt-transport__toggle">
                <input
                    type="checkbox"
                    name="ativo"
                    value="1"
                    checked
                >

                <span class="tt-transport__toggle-box"></span>

                <span class="tt-transport__toggle-text">
                    <strong>Transportador ativo</strong>
                    <small>
                        Permitir que este transportador seja selecionado
                        nas operações de frete.
                    </small>
                </span>
            </label>

            <div class="tt-transport__actions">

                <button type="reset" class="tt-transport__btn-reset">
                    Limpar formulário
                </button>

                <button type="submit" class="tt-transport__btn-submit">
                    Cadastrar transportador
                    <span>↗</span>
                </button>

            </div>

        </form>

    </section>

    <p class="tt-transport__footer-note">
        TranspTech • Sistema de gerenciamento logístico
    </p>

</main>
