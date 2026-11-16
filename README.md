🚚 TranspTech

A TranspTech é um sistema de gerenciamento logístico desenvolvido com o objetivo de facilitar e organizar o controle de entregas e operações de transporte. A plataforma permite gerenciar produtos, endereços, transportadores e fretes, centralizando as principais informações em um único ambiente.

O sistema também conta com diferentes níveis de acesso para administradores, usuários e motoristas, permitindo que cada perfil tenha acesso às funcionalidades correspondentes às suas responsabilidades.

Nosso objetivo é oferecer uma solução prática, organizada e intuitiva, contribuindo para tornar os processos logísticos mais eficientes e facilitar o acompanhamento das entregas.

-------------------------------------------------------------------------------------------------------------------------------------------------------------------------
Recomendaçoes:

Use o SQL dentro de public/assets/sql/transp_tech.sql (Aqui estao todas as tabelas já possuem pelo menos um insert)

O email de administrador é guilherme@transptech.com e senha 123. Com ele é possivel criar novos usuários e ter acesso ao menu admin.

-------------------------------------------------------------------------------------------------------------------------------------------------------------------------

1 - Para usar esse código é necessário utilizar o composer. Primeiro instale o composer na sua maquina, com este link: https://getcomposer.org/download/

3 - Em extensões na direita dentro do VsCode, baixar a extensão do Composer.

4 - Após instalar o composer, para implementar ele no seu projeto abra um terminal dentro do VsCode. No terminal digite "composer init" e precione enter até o final.

5 - Agora com o composer no projeto, em um novo terminal ou no mesmo já utilizado, digite "composer dump-autoload -o" isso irá fazer com que o composer recarregue para ser usado.

6 - Configurações necessárias para o funcionamento: 
    
    6.1 - Dentro do arquivo "composer.json", dentro de "psr-4" deve ser inserido "app\\":"app/" a baixo da primeira linha: 
    "psr-4": {
        "GuilhermeMuller2\\ApiTransparencia\\": "src/",
        "app\\":"app/"
    }

7 - Maneira de utilizar o composer:

    7.1 - Para facilitar o carregamento das páginas, foi utilizado o "../vendor/autoload.php", esse é um arquivo que faz o carregamento das páginas de maneira mais rápida, por isso ela tem que ficar na raiz do projeto (index.php) nesse caso.
