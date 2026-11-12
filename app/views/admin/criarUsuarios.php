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


  <section class="tt-users-list">

    <div class="tt-users-list__header">
      <div>
        <span class="tt-users-list__eyebrow">
          TRANSPTECH / ADMINISTRAÇÃO
        </span>

        <h2>Usuários cadastrados</h2>

        <p>Gerencie e consulte os usuários do sistema.</p>
      </div>

      <span class="tt-users-list__count">
        <?= count($usuarios) ?> usuário(s)
      </span>
    </div>

    <div class="tt-users-list__table-wrapper">

      <table class="tt-users-list__table">

        <thead>
          <tr>
            <th>ID</th>
            <th>Nome</th>
            <th>E-mail</th>
            <th>Tipo</th>
            <th>Data de cadastro</th>
          </tr>
        </thead>

        <tbody>

          <?php if (empty($usuarios)): ?>

            <tr>
              <td colspan="5" class="tt-users-list__empty">
                Nenhum usuário cadastrado.
              </td>
            </tr>

          <?php else: ?>

            <?php foreach ($usuarios as $usuario): ?>

              <tr>
                <td>
                  <?= htmlspecialchars((string) $usuario['id_usuario']) ?>
                </td>

                <td>
                  <strong>
                    <?= htmlspecialchars($usuario['nome']) ?>
                  </strong>
                </td>

                <td>
                  <?= htmlspecialchars($usuario['email']) ?>
                </td>

                <td>
                  <span class="tt-users-list__badge">
                    <?= htmlspecialchars($usuario['tipo_usuario']) ?>
                  </span>
                </td>

                <td>
                  <?= !empty($usuario['criado_em'])
                    ? date('d/m/Y H:i', strtotime($usuario['criado_em']))
                    : 'Não informado' ?>
                </td>
              </tr>

            <?php endforeach; ?>

          <?php endif; ?>

        </tbody>

      </table>

    </div>

  </section>


</div>