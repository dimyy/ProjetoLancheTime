const carrinhoItens = document.getElementById('carrinho-itens');
const carrinhoTotal = document.getElementById('carrinho-total');
let total = 0;

// Esta função é chamada quando o botão "pedir agora" é clicado.
function showPopup(nome, preco) {
    addToCart(nome, preco);
}

function addToCart(nome, preco) {
    const item = document.createElement('li');
    item.textContent = `${nome} - R$${preco.toFixed(2)}`;
    carrinhoItens.appendChild(item);

    total += preco;
    carrinhoTotal.textContent = total.toFixed(2);
}

// Exemplo de como adicionar itens ao carrinho
showPopup('Palha Italiana', 2.00);
showPopup('Beijinho', 2.00);
showPopup('Pé de Moleque', 3.50);
