<?php if (!empty($_SESSION['sucesso_usuario'])): ?>

    <div class="tt-alert-success">
        <?= htmlspecialchars($_SESSION['sucesso_usuario']) ?>
    </div>

    <?php unset($_SESSION['sucesso_usuario']); ?>

<?php endif; ?>


<?php if (!empty($_SESSION['erros_usuario'])): ?>

    <div class="tt-alert-error">

        <?php foreach ($_SESSION['erros_usuario'] as $erro): ?>

            <p><?= htmlspecialchars($erro) ?></p>

        <?php endforeach; ?>

    </div>

    <?php unset($_SESSION['erros_usuario']); ?>

<?php endif; ?>

<div class="tt-user-register">

  <div class="tt-user-register__header">
    <span class="tt-user-register__eyebrow">
      TRANSPTECH / ADMINISTRAÇÃO
    </span>

    <h1>Cadastrar usuário</h1>

    <p>
      Preencha os dados abaixo para adicionar um novo usuário ao sistema.
    </p>
  </div>

  <form
    class="tt-user-register__form"
    action="index.php?pagina=usuarioController"
    method="POST">

    <div class="tt-user-register__field">
      <label for="nome">Nome completo</label>

      <input
        type="text"
        id="nome"
        name="nome"
        placeholder="Digite o nome completo"
        autocomplete="name"
        required>
    </div>

    <div class="tt-user-register__field">
      <label for="email">E-mail</label>

      <input
        type="email"
        id="email"
        name="email"
        placeholder="exemplo@email.com"
        autocomplete="email"
        required>
    </div>

    <div class="tt-user-register__field">
      <label for="senha">Senha</label>

      <input
        type="password"
        id="senha"
        name="senha"
        placeholder="Crie uma senha"
        autocomplete="new-password"
        minlength="8"
        required>

      <small>Utilize pelo menos 8 caracteres.</small>
    </div>
    <div class="tt-user-register__field">
      <label for="tipo_usuario">Tipo de usuário</label>

      <select
        id="tipo_usuario"
        name="tipo_usuario"
        class="tt-user-register__select"
        required>
        <option value="" selected disabled>Selecione o tipo de usuário</option>
        <option value="motorista">Motorista</option>
        <option value="usuario">Usuário comum</option>
      </select>
    </div>

    <div class="tt-user-register__actions">
      <button type="reset" class="tt-user-register__button tt-user-register__button--secondary">
        Limpar
      </button>

      <button type="submit" class="tt-user-register__button tt-user-register__button--primary">
        Cadastrar usuário
      </button>
    </div>

  </form>

</div>