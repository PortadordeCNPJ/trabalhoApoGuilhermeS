
document.addEventListener('DOMContentLoaded', function () {

    const botao = document.getElementById('btn-baixar-relatorio');
    const campoData = document.getElementById('data_relatorio');
    const mensagem = document.getElementById('relatorio-mensagem');

    if (!botao || !campoData || !mensagem) {
        return;
    }

    botao.addEventListener('click', async function () {

        const data = campoData.value;

        if (!data) {
            mensagem.textContent = 'Selecione uma data para continuar.';
            return;
        }

        botao.disabled = true;
        mensagem.textContent = 'Gerando relatório...';

        try {

            const resposta = await fetch(
                `index.php?pagina=relatorioFrete&data=${encodeURIComponent(data)}`
            );

            if (!resposta.ok) {
                const erro = await resposta.json();
                throw new Error(erro.mensagem || 'Não foi possível gerar o relatório.');
            }

            const arquivo = await resposta.blob();

            const url = URL.createObjectURL(arquivo);

            const link = document.createElement('a');

            link.href = url;
            link.download = `relatorio-fretes-${data}.csv`;

            document.body.appendChild(link);
            link.click();

            link.remove();
            URL.revokeObjectURL(url);

            mensagem.textContent = 'Relatório baixado com sucesso!';

        } catch (erro) {

            mensagem.textContent = erro.message;

        } finally {

            botao.disabled = false;

        }

    });

});
