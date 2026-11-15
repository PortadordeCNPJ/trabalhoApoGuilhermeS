<section class="tt-freight-card tt-report-card">

    <div class="tt-freight-section-title">
        <span>05</span>
        <div>
            <h2>Relatório de fretes</h2>
            <p>Selecione uma data para exportar os fretes cadastrados.</p>
        </div>
    </div>

    <div class="tt-report-content">

        <div class="tt-freight-field">
            <label for="data_relatorio">Data do relatório</label>

            <input
                type="date"
                id="data_relatorio"
                value="<?= date('Y-m-d') ?>"
                required>
        </div>

        <button
            type="button"
            id="btn-baixar-relatorio"
            class="tt-report-button">

            <i class="bi bi-file-earmark-spreadsheet"></i>
            Baixar relatório

        </button>

    </div>

    <p id="relatorio-mensagem" class="tt-report-message"></p>

</section>