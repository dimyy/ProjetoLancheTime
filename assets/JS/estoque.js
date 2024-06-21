document.getElementById('add-item-form').addEventListener('submit', function(event) {
    event.preventDefault();

    var formData = new FormData(this);

    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'process.php', true);
    xhr.onload = function () {
        if (xhr.status === 200) {
            try {
                var response = JSON.parse(xhr.responseText);
                if (response.status === 'success') {
                    showConfirmPopup();
                } else {
                    alert('Erro ao adicionar item: ' + response.message);
                }
            } catch (e) {
                alert('Erro inesperado: ' + xhr.responseText);
            }
        } else {
            alert('Erro ao adicionar item.');
        }
    };
    xhr.send(formData);
});

function showConfirmPopup() {
    var popup = document.getElementById("confirm-popup");
    popup.classList.add("show");

    document.getElementById("confirm-ok-button").addEventListener('click', function() {
        popup.classList.remove("show");
    });

    document.getElementById("confirm-cancel-button").addEventListener('click', function() {
        popup.classList.remove("show");
    });
}
