<?php

$erros = $_SESSION['erros_endereco'] ?? [];
$sucesso = $_SESSION['sucesso_endereco'] ?? null;

unset($_SESSION['erros_endereco']);
unset($_SESSION['sucesso_endereco']);

?>

<main class="tt-address">

    <!-- CABEÇALHO -->

    <section class="tt-address__header">

        <div>
            <span class="tt-address__eyebrow">
                GESTÃO LOGÍSTICA
            </span>

            <h1>Cadastro de endereços</h1>

            <p>
                Registre os endereços utilizados nas operações
                de origem e destino dos fretes da TranspTech.
            </p>
        </div>

        <div class="tt-address__header-icon">
            📍
        </div>

    </section>


    <!-- MENSAGEM DE SUCESSO -->

    <?php if ($sucesso): ?>

        <div class="tt-address__alert tt-address__alert--success">

            <strong>
                ✓ <?= htmlspecialchars($sucesso, ENT_QUOTES, 'UTF-8') ?>
            </strong>

        </div>

    <?php endif; ?>


    <!-- MENSAGEM DE ERRO -->

    <?php if (!empty($erros)): ?>

        <div class="tt-address__alert tt-address__alert--error">

            <strong>Verifique as informações:</strong>

            <ul>

                <?php foreach ($erros as $erro): ?>

                    <li>
                        <?= htmlspecialchars($erro, ENT_QUOTES, 'UTF-8') ?>
                    </li>

                <?php endforeach; ?>

            </ul>

        </div>

    <?php endif; ?>


    <!-- FORMULÁRIO -->

    <section class="tt-address__card">

        <div class="tt-address__card-header">

            <div>
                <h2>Informações do endereço</h2>

                <p>
                    Preencha os dados do local que deseja cadastrar.
                </p>
            </div>

            <span class="tt-address__required">
                * Campos obrigatórios
            </span>

        </div>


        <form
            action="index.php?pagina=enderecoController"
            method="POST"
            class="tt-address__form">

            <!-- IDENTIFICAÇÃO -->

            <div class="tt-address__section-title">
                <span>01</span>
                Identificação do endereço
            </div>


            <div class="tt-address__field tt-address__field--full">

                <label for="identificacao">
                    Identificação *
                </label>

                <input
                    type="text"
                    id="identificacao"
                    name="identificacao"
                    placeholder="Ex.: Depósito principal, Empresa Alfa..."
                    maxlength="100"
                    required>

                <small>
                    Utilize um nome que facilite encontrar este endereço
                    posteriormente.
                </small>

            </div>


            <!-- LOCALIZAÇÃO -->

            <div class="tt-address__section-title">
                <span>02</span>
                Localização
            </div>


            <div class="tt-address__field tt-address__field--full">

                <label for="logradouro">
                    Logradouro *
                </label>

                <input
                    type="text"
                    id="logradouro"
                    name="logradouro"
                    placeholder="Rua, Avenida, Rodovia..."
                    maxlength="150"
                    required>

            </div>


            <div class="tt-address__field">

                <label for="numero">
                    Número *
                </label>

                <input
                    type="text"
                    id="numero"
                    name="numero"
                    placeholder="Ex.: 1500 ou S/N"
                    maxlength="20"
                    required>

            </div>


            <div class="tt-address__field">

                <label for="complemento">
                    Complemento
                </label>

                <input
                    type="text"
                    id="complemento"
                    name="complemento"
                    placeholder="Apartamento, bloco, sala..."
                    maxlength="100">

            </div>


            <div class="tt-address__field">

                <label for="bairro">
                    Bairro *
                </label>

                <input
                    type="text"
                    id="bairro"
                    name="bairro"
                    placeholder="Nome do bairro"
                    maxlength="100"
                    required>

            </div>


            <div class="tt-address__field">

                <label for="cidade">
                    Cidade *
                </label>

                <input
                    type="text"
                    id="cidade"
                    name="cidade"
                    placeholder="Nome da cidade"
                    maxlength="100"
                    required>

            </div>


            <div class="tt-address__field">

                <label for="estado">
                    Estado (UF) *
                </label>

                <select
                    id="estado"
                    name="estado"
                    required>

                    <option value="">Selecione o estado</option>

                    <option value="AC">Acre</option>
                    <option value="AL">Alagoas</option>
                    <option value="AP">Amapá</option>
                    <option value="AM">Amazonas</option>
                    <option value="BA">Bahia</option>
                    <option value="CE">Ceará</option>
                    <option value="DF">Distrito Federal</option>
                    <option value="ES">Espírito Santo</option>
                    <option value="GO">Goiás</option>
                    <option value="MA">Maranhão</option>
                    <option value="MT">Mato Grosso</option>
                    <option value="MS">Mato Grosso do Sul</option>
                    <option value="MG">Minas Gerais</option>
                    <option value="PA">Pará</option>
                    <option value="PB">Paraíba</option>
                    <option value="PR">Paraná</option>
                    <option value="PE">Pernambuco</option>
                    <option value="PI">Piauí</option>
                    <option value="RJ">Rio de Janeiro</option>
                    <option value="RN">Rio Grande do Norte</option>
                    <option value="RS">Rio Grande do Sul</option>
                    <option value="RO">Rondônia</option>
                    <option value="RR">Roraima</option>
                    <option value="SC">Santa Catarina</option>
                    <option value="SP">São Paulo</option>
                    <option value="SE">Sergipe</option>
                    <option value="TO">Tocantins</option>

                </select>

            </div>


            <div class="tt-address__field">

                <label for="cep">
                    CEP *
                </label>

                <input
                    type="text"
                    id="cep"
                    name="cep"
                    placeholder="00000-000"
                    maxlength="9"
                    inputmode="numeric"
                    required>

            </div>


            <!-- AÇÕES -->

            <div class="tt-address__actions">

                <button
                    type="reset"
                    class="tt-address__btn-reset">
                    Limpar formulário
                </button>


                <button
                    type="submit"
                    class="tt-address__btn-submit">
                    Cadastrar endereço
                    <span>↗</span>
                </button>

            </div>

        </form>

    </section>


    <p class="tt-address__footer-note">
        TranspTech • Sistema de gerenciamento logístico
    </p>

</main>