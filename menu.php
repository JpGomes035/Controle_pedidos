<?php
include_once('conexao.php');
include_once('password.php');
?>
<!DOCTYPE html>
<html lang="en">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@200;300&display=swap" rel="stylesheet">

<head>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background: linear-gradient(to bottom, #2a9d8f, #264653);
            color: #333;
            font-weight: bold;
        }

        #menu {
            width: 100%;
            background: #2a9d8f;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            position: fixed;
            top: 0;
            z-index: 1000;
            display: flex;
            justify-content: space-between;
            padding: 10px 20px;
        }

        .nav-menu {
            position: relative;
            margin: 0;
            padding: 0;
        }

        .nav-item.nav-link {
            text-decoration: none;
            color: #333;
            padding: 10px 15px;
            font-weight: 500;
            transition: color 0.3s, background-color 0.3s;
            border-radius: 4px;
        }

        .nav-item.nav-link:hover {
            color: #fff;
            background-color: #007bff;
        }

        .submenu {
            display: none;
            position: absolute;
            top: 100%;
            left: 0;
            background-color: #fff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 4px;
            padding: 10px 0;
            z-index: 999;
        }

        .nav-menu:hover .submenu {
            display: block;
        }

        .submenu a {
            display: block;
            color: #333;
            text-decoration: none;
            padding: 10px 20px;
            font-size: 14px;
            transition: color 0.3s, background-color 0.3s;
        }

        .submenu a:hover {
            color: #fff;
            background-color: #007bff;
        }

        .toggle-btn {
            background-color: #333;
            color: #fff;
            border: none;
            padding: 8px 12px;
            font-size: 14px;
            cursor: pointer;
            border-radius: 5px;
            position: fixed;
            top: 10px;
            right: 10px;
        }

        .toggle-btn:hover {
            background-color: #555;
        }

        @media (max-width: 768px) {
            #menu {
                flex-direction: column;
                align-items: center;
            }

            .nav-menu {
                width: 100%;
                text-align: left;
            }

            .submenu {
                position: static;
                box-shadow: none;
                border-radius: 0;
                padding: 0;
            }

            .submenu a {
                padding: 10px;
                border-top: 1px solid #ddd;
            }
        }

        @media (max-width: 480px) {
            .nav-item.nav-link {
                font-size: 14px;
            }

            .toggle-btn {
                font-size: 12px;
                padding: 6px 10px;
            }
        }
    </style>
</head>
<body>
    <div class="menu menu-print">
        <nav id="menu" class="nav nav-pills nav-fill">
        <div class="nav-menu">
                <a class="nav-item nav-link listar-menu" href="#">
                </a>
            </div>  
        <div class="nav-menu">
                <a class="nav-item nav-link listar-menu" href="#">
                    <i class="fa fa-box" aria-hidden="true"></i> Produtos
                </a>
                <div class="submenu">
                    <a href="cadastrar_produto.php">Cadastrar</a>
                    <a href="listar_produtos.php">Listar</a>
                    <a href="cadastrar_categoria.php">Categoria</a>
                    <a href="cadastrar_fornecedor.php">Fornecedores</a>
                    <a href="cadastrar_cliente.php">Clientes</a>
                </div>
            </div>
            <div class="nav-menu">
                <a class="nav-item nav-link listar-menu" href="#">
                    <i class="fa fa-bars" aria-hidden="true"></i> Geral
                </a>
                <div class="submenu">
                    <a href="cadastrar_banco.php">Banco</a>
                    <a href="cadastrar_formpag.php">Forma de Pagamento</a>
                    <a href="estoque_baixo.php">Sugestão de compra</a>
                    <a href="email/index.php">Enviar E-mail</a>
                    <a href="painel.php">Painel</a>
                </div>
            </div>
            <div class="nav-menu">
                <a class="nav-item nav-link listar-menu" href="#">
                    <i class="fa fa-user-circle" aria-hidden="true"></i> Perfil
                </a>
                <div class="submenu">
                    <a href="perfil.php">Perfil da empresa</a>
                    <a href="cadastrar_setor.php">Cadastrar Setor</a>
                </div>
            </div>
            <div class="nav-menu">
                <a class="nav-item nav-link listar-menu" href="#">
                    <i class="fa fa-barcode" aria-hidden="true"></i> Pedidos
                </a>
                <div class="submenu">
                    <a href="pedido/pedido_compra.php">Compra</a>
                    <a href="pedido/pedido.php">Venda</a>
                    <a href="lista_pedido_compras.php">Listagem pedidos Compra</a>
                    <a href="lista_pedidos.php">Listagem pedidos Venda</a>
                    <a href="sair.php">Sair</a>
                </div>
            </div>
            <div class="nav-menu">
                <a class="nav-item nav-link listar-menu" href="#">
                </a>
            </div>
    </div>
    </nav>
    <br>
    </div>
</body>
<script>
    let inatividadeTimeout;

    function iniciarTemporizadorInatividade() {
        inatividadeTimeout = setTimeout(realizarLogoff, 600000);
    }

    function resetarTemporizadorInatividade() {
        clearTimeout(inatividadeTimeout);
        iniciarTemporizadorInatividade();
    }

    function realizarLogoff() {
        window.location.href = "sair.php";
    }

    document.addEventListener('mousemove', resetarTemporizadorInatividade);
    document.addEventListener('keydown', resetarTemporizadorInatividade);

    iniciarTemporizadorInatividade();
</script>
<?php include_once('footer.php'); ?>

</html>