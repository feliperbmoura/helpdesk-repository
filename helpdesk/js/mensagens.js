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
            confirmButtonColor: '#667eea'
        });
    },

    // Login - usuario Inativo

    usuarioInativo(){
        return Swal.fire({
            icon: 'warning',
            title: 'Usuario Inativo',
            text: 'Sua conta está inativa. Entre em contato com o administrador',
            confirmButtonText: 'OK',
            confirmButtonColor: '#667eea'
        })
    },

    /**
     *  // sucesso genérico
     * @param {string} titulo
     * @param {string} texto
     * 
     */

    sucesso(titulo = 'Sucesso!', texto = 'Opereção realizada com sucesso.'){
        return Swal.fire({
            icon: 'success',
            title: titulo,
            text: texto,
            confirmButtonText: 'OK',
            confirmButtonColor: '#28a745'
        });
    },

    /**
     * // Erro generico
     * @param {string} titulo
     * @param {string} texto
     */

    erro(titulo = 'Erro!', texto = 'Ocorreu um erro. Tente novamente.'){
        return Swal.fire({
            icon: 'error',
            title: titulo,
            text: texto,
            confirmButtonText: 'OK',
            confirmButtonColor: '#dc3545'
        });
    },

    /**
     * // Aviso generico
     * @param {string} titulo
     * @param {string} texto
     */

    aviso(titulo = 'Atenção', texto = ''){
        return Swal.fire({
            icon: 'warning',
            title: titulo,
            text: texto,
            confirmButtonText: 'OK',
            confirmButtonColor: '#ffc107'
        });
    },

    /**
     * 
     * // confirmação (ex: antes de excluir)
     * 
     * @param {string} titulo
     * @param {string} texto
     * @param {string} textoConfirmar
     * @param {string} textoCancelar
     * 
     */

    confirmar(titulo = 'Confirmar', texto = 'Essa ação não pode ser desfeita.', textoConfirmar = 'Sim, confirmar', textoCancelar = 'Cancelar'){
        return Swal.fire({
            icon: 'question',
            title: titulo,
            text: texto,
            showCancelButton: true,
            confirmButtonText: textoConfirmar,
            cancelButtonText: textoCancelar,
            confirmButtonColor: '#dc3545',
            cancelButtonColor: '#6c757d'
        });
    },

    // Exibe mensagem de retorno do login conforme parâmentro da URL
    // USO: Mensagens.exibirRetornoLogin()
    // ELE RECURPERA A SESSÂO e não retorma o tipo do erro na URL, ou seja ele nao utiliza get
    exibirRetornoLogin(){
        if (!window.LOGIN_FLASH) return;

        const { tipo, codigo } = window.LOGIN_FLASH;

        if(codigo === 'login_invalido'){
            this.loginDadosIncorretos();
        }

        if(codigo === 'usuario_inativo'){
            this.usuarioInativo();
        }

        if(codigo === 'csrf_invalido'){
            this.erro(
                'Sessão expirada',
                'Sua sessão expirou. Recarregue a pagina e tente novamente.'
            );
        }
    }
};