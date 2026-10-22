<div class="tt-login">
    <form class="tt-login__form" action="/transpTech/public/index.php?pagina=UsuarioLogin" method="POST">

        <div class="tt-login__header">
            <span class="tt-login__brand">TRANSP<span>TECH</span></span>
            <h1 class="tt-login__title">Bem-vindo de volta</h1>
            <p class="tt-login__subtitle">
                Entre na sua conta para continuar.
            </p>
        </div>

        <div class="tt-login__field">
            <label for="floatingInput">E-mail</label>
            <input
                type="email"
                name="email"
                id="floatingInput"
                placeholder="seu@email.com"
                autocomplete="email"
                required
            >
        </div>

        <div class="tt-login__field">
            <label for="floatingPassword">Senha</label>
            <input
                type="password"
                name="senha"
                id="floatingPassword"
                placeholder="Digite sua senha"
                autocomplete="current-password"
                required
            >
        </div>

        <div class="tt-login__options">
            <label class="tt-login__remember" for="checkDefault">
                <input
                    type="checkbox"
                    name="lembrar"
                    value="1"
                    id="checkDefault"
                >
                <span>Manter conectado</span>
            </label>
        </div>

        <button class="tt-login__button" type="submit">
            Entrar na conta
        </button>

        <p class="tt-login__footer">
            © 2026 TranspTech. Todos os direitos reservados.
        </p>

    </form>
</div>