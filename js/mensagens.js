// Modelo de mensgens com SweetAlert2
// Uso> Mensagens.LoginDadosIncorretos(), Mensagens.usuarioInativo(), etc.

const Mensagens = {
    

    // login - Dados Incorretos ( email ou senha)

    loginDadosIncorretos(){
        return Swal.fire({
            icon: 'error',
            title: 'Dados Incorretos',
            text: 'E-mail ou senha inválidos. Verifique e tente novamente',
            confirmButtonText: 'OK',
            confirmButtonColor: '$667eea'
        });
    },

    // Login - usuario Inativo

    usuarioInativo(){
        return Swal.fire({
            icon: 'Warning',
            title: 'Usuario Inativo',
            text: 'Sua conta está inativa. Entre em contato com o administrador',
            confirmButtonText: 'OK',
            conirmButtonColor: '#667eea'
        })
    },
}