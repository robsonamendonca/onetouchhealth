$(document).ready(function () {
    $('#tabelaUsuarios').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": {
            "url": "lista-usuarios.php",
            "type": "POST"
        },
        "language": {
            "url": "assets/Portuguese-Brasil.json"
        }
    });

    // Fetch all the forms we want to apply custom Bootstrap validation styles to
    var forms = document.querySelectorAll('.needs-validation')

    var btnAdicionarUsuario = document.querySelector('.btn-add-user');
    var btnCancelar = document.getElementById('btnCancelar');
    var btnFechar = document.querySelector('.btn-close');

    // Loop over them and prevent submission
    Array.prototype.slice.call(forms)
        .forEach(function (form) {
            form.addEventListener('submit', async function (event) {
                document.getElementById('message-error').innerHTML = "";
                document.getElementById('message-success').innerHTML = "";

                if (!form.checkValidity()) {
                    event.preventDefault()
                    event.stopPropagation()
                } else {
                    event.preventDefault()
                    const formData = new FormData(form);

                    const postData = await fetch("insere-usuario.php", {
                        method: "POST",
                        body: formData
                    });

                    const result = await postData.json()
                    if (result['status']) {
                        document.getElementById('message-error').innerHTML = "";
                        document.getElementById('message-success').innerHTML = `<div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>Info:</strong> ${result['message']}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>`;
                        form.classList.remove('was-validated')
                        form.reset();
                        btnFechar.click();
                        tabelaUsuarios = $('#tabelaUsuarios').DataTable();
                        tabelaUsuarios.draw();
                    } else {
                        document.getElementById('message-error').innerHTML = `<div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <strong>Atenção!</strong> ${result['message']}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>`;
                        form.classList.remove('was-validated')
                    }
                }

                form.classList.add('was-validated')
            }, false)
        })


    btnAdicionarUsuario.addEventListener('click', function () {
        resetForm(forms);
    })


    btnCancelar.addEventListener('click', function () {
        resetForm(forms);
    })

    btnFechar.addEventListener('click', function () {
        resetForm(forms);
    })


});


function resetForm(forms) {
    Array.prototype.slice.call(forms)
        .forEach(function (form) {
            form.classList.remove('was-validated')
            form.reset();
        })
}

async function deletarUsuario(id) {
    if (id) {
        // if(!confirm("Deseja realmente apagar o registro: "+id+", do banco de dados?")){
        //     return false;
        // }
        $.confirm({
            title: 'Apagar?',
            content: "Deseja realmente apagar o registro: " + id + ", do banco de dados?",
            type: 'red',
            typeAnimated: true,
            buttons: {
                tryAgain: {
                    text: 'Confirmar',
                    btnClass: 'btn-red',
                    action: async function () {
                        const postData = await fetch("deleta-usuario.php?id=" + id);
                        const result = await postData.json()
                        if (result['status']) {
                            document.getElementById('message-error').innerHTML = "";
                            document.getElementById('message-success').innerHTML = `<div class="alert alert-success alert-dismissible fade show" role="alert">
                                <strong>Info:</strong> ${result['message']}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>`;
                            tabelaUsuarios = $('#tabelaUsuarios').DataTable();
                            tabelaUsuarios.draw();
                        } else {
                            document.getElementById('message-error').innerHTML = "";
                            document.getElementById('message-success').innerHTML = `<div class="alert alert-warning alert-dismissible fade show" role="alert">
                                <strong>Atenção!</strong> ${result['message']}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>`;
                        }

                    }
                },
                close: {
                    text: 'Cancelar',
                    action: function () {

                    }
                }
            }
        });

    }

}
