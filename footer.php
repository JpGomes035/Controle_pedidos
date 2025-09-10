<style>
    .versao {
        position: fixed;
        bottom: 10px;
        right: 10px;
        background: linear-gradient(to bottom, #b3e0e0, #d9d9d9);
        padding: 5px 10px;
        border: 1px solid black;
        font-weight: bold;
        border-radius: 2px;
        max-width: 150px;
        text-align: center;
        color: black;
    }

    .joao {
        color: Black;
        transition: color 0.3s ease-in-out;
    }

    .joao:hover {
        color: white;
    }

    /* Estilizando a barra de rolagem */
    ::-webkit-scrollbar {
        width: 7px;
        /* Largura da barra de rolagem */
    }

    /* Estilizando o "thumb" (o indicador da posição atual na barra de rolagem) */
    ::-webkit-scrollbar-thumb {
        background-color: #1a1a1a;
        /* Cor do "thumb" */
        border-radius: 6px;
        /* Borda arredondada do "thumb" */
    }

    /* Estilizando a alça da barra de rolagem (a parte clicável fora do "thumb") */
    ::-webkit-scrollbar-track {
        background-color: #f1f1f1;
        /* Cor da alça da barra de rolagem */
    }

    /* Estilo para o ícone */
    .hide-icon {
        cursor: pointer;
    }
</style>
<script src="js/bootstrap.js"></script>
<script>
    var url = window.location.href;
    var navMenu = document.querySelector('#menu');
    var nomeUrl = url.split('/')[6];
    var nomeArquivo = nomeUrl.split('.php')[0]

    if (nomeArquivo === "cadastrar_produto") {
        navMenu.children[1].classList.add("active");
    } else if (nomeArquivo === 'listar_produtos') {
        navMenu.children[2].classList.add("active");
    } else if (nomeArquivo === 'cadastrar_categoria') {
        navMenu.children[3].classList.add("active");
    } else if (nomeArquivo === 'cadastrar_fornecedor') {
        navMenu.children[4].classList.add("active");
    } else if (nomeArquivo === 'cadastrar_usuario') {
        navMenu.children[5].classList.add("active");
    } else if (nomeArquivo === 'aprovar_usuario') {
        navMenu.children[6].classList.add("active");
    }

    var alerta = document.querySelector('#alerta');
    if (alerta) {
        var fadeEffect = setInterval(function() {
            if (!alerta.style.opacity) {
                alerta.style.opacity = 1;
            }
            if (alerta.style.opacity > 0) {
                alerta.style.opacity -= 0.3;
            } else {
                clearInterval(fadeEffect);
                alerta.style.display = "none";
            }
        }, 500);
    }
</script>


<div class="versao">
    V: 1.0
    <br>
    <span class="hide-icon">X</span> <!-- Ícone para ocultar -->
</div>
<!-- Inserido na versão 1.7.x, ocultar versão na interface-->
<script>
    // Obtém a referência para o ícone e a div que queremos ocultar
    const hideIcon = document.querySelector('.hide-icon');
    const divVersao = document.querySelector('.versao');

    // Adiciona um evento de clique ao ícone
    hideIcon.addEventListener('click', function() {
        // Oculta a div
        divVersao.style.display = 'none';
    });
</script>
</div>