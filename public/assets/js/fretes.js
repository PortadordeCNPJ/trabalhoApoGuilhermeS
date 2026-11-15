document.addEventListener('DOMContentLoaded', function () {
    const container = document.getElementById('tt-product-rows');
    const addButton = document.getElementById('tt-add-product');

    let productIndex = 1;

    addButton.addEventListener('click', function () {
        const firstRow = container.querySelector('.tt-product-row');
        const newRow = firstRow.cloneNode(true);

        newRow.querySelectorAll('select, input').forEach(function (field) {
            field.name = field.name.replace(
                /produtos\[\d+\]/,
                'produtos[' + productIndex + ']'
            );

            field.value = '';
        });

        const removeButton = document.createElement('button');
        removeButton.type = 'button';
        removeButton.className = 'tt-product-remove';
        removeButton.textContent = 'Remover produto';

        removeButton.addEventListener('click', function () {
            newRow.remove();
        });

        newRow.appendChild(removeButton);
        container.appendChild(newRow);

        productIndex++;
    });
});