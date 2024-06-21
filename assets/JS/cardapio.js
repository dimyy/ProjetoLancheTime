document.addEventListener('DOMContentLoaded', function () {
    var adicionarButtons = document.querySelectorAll('.adicionar-carrinho');

    adicionarButtons.forEach(function (button) {
        button.addEventListener('click', function () {
            var quantidadeInput = this.closest('tr').querySelector('.quantidade');
            var produtoIdInput = this.closest('tr').querySelector('.produto_id');
            var quantidade = quantidadeInput.value;
            var produtoId = produtoIdInput.value;

            var formData = new FormData();
            formData.append('action', 'adicionar');
            formData.append('quantidade', quantidade);
            formData.append('produto_id', produtoId);

            fetch('cardapio.php', {
                method: 'POST',
                body: formData
            })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        showPopup(data.message, data.redirect);
                    } else {
                        showPopup(data.message);
                    }
                })
                .catch(error => {
                    console.error('Erro:', error);
                    showPopup('Erro ao adicionar produto ao carrinho.');
                });
        });
    });
});

function showPopup(message, redirectUrl = null) {
    var popup = document.getElementById('popup');
    var popupMessage = document.getElementById('popup-message');
    var popupOk = document.getElementById('popup-ok');
    
    popupMessage.innerText = message;

    if (redirectUrl) {
        popupOk.style.display = 'inline-block';
        popupOk.onclick = function () {
            window.location.href = redirectUrl;
        };
    } else {
        popupOk.style.display = 'none';
    }

    popup.style.display = 'block';

    popupOk.onclick = function () {
        popup.style.display = 'none';
    };
}
