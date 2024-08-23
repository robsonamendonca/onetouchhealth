<?php 
//require_once './usuarios.php';
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Desafio OneTouchHealth</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.4/css/dataTables.bootstrap5.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.4/jquery-confirm.min.css">

</head>
<body >
    <div class="container mt-5">
        <h1>Listar Usuários</h1>

        <span id="message-success"></span>
        <button type="button" class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#novoUsuario">
          Adicionar Usuário
        </button>

        <table id="tabelaUsuarios" class="table table-light table-striped table-hover display" style="width:100%">
            <thead class="table-dark">
                <tr>
                    <th>Id</th>
                    <th>Nome</th>
                    <th>E-mail</th> 
                    <th>Apagar?</th>                   
                </tr>
            </thead>

        </table>
    </div>

    <div class="modal fade" id="novoUsuario" tabindex="-1" aria-labelledby="novoUsuarioLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="novoUsuarioLabel">Adicionar novo usuário:</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" class="row g-3 needs-validation" novalidate>
                <div class="modal-body">    
                    <div class="col-md-12">
                        <label for="nome" class="form-label">Nome</label>
                        <input type="text" class="form-control" name="nome" id="nome" value="" required>
                        <div class="invalid-feedback">
                            Informe seu nome.
                        </div>
                    </div>
                    <div class="col-md-12">
                        <label for="email" class="form-label">E-mail</label>
                        <div class="input-group has-validation">
                        <span class="input-group-text" id="inputGroupPrepend">@</span>
                        <input type="email" class="form-control" name="email" id="email" aria-describedby="inputGroupPrepend" required>
                        <div class="invalid-feedback">
                            Informe seu e-mail.
                        </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <span id="message-error"></span>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="btnCancelar">Cancelar</button>
                    <button class="btn btn-dark" type="submit" value="Salvar">Salvar</button>
                </div>
            </form>    
        </div>
    </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/2.1.4/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.1.4/js/dataTables.bootstrap5.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.4/jquery-confirm.min.js"></script>
    
    <script src="./assets/javascript.js"></script> 
</body>
</html>