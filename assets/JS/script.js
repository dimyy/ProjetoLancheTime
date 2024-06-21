function showPopup() {
    var confirmar = confirm("Você só pode visualizar o cardápio se estiver logado. Deseja fazer login?");

    if (confirmar) {
        window.location.href = "login.php";
    } else {
        // Nada a fazer se o usuário cancelar
    }
}

let show = true;
const menuContent = document.querySelector('.content');
const menuToggle = menuContent.querySelector('.menu-toggle');

menuToggle.addEventListener('click', () => {a
    document.body.style.overflow = show ? 'hidden' : 'initial';
    menuContent.classList.toggle('on', show);
    show = !show;
});

function scrollToCategories() {
    const categoriesSection = document.getElementById('categorias');
    categoriesSection.scrollIntoView({ behavior: 'smooth' });
}

document.addEventListener("DOMContentLoaded", function() {
    const sidebarToggle = document.querySelector('.menu-toggle');
    const sidebar = document.querySelector('#sidebar');
    const content = document.querySelector('#content');

    sidebarToggle.addEventListener('click', () => {
        sidebar.classList.toggle('active');
        content.classList.toggle('active');
    });
});

