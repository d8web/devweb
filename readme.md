### Dev web sistem

<p>Site com informações dinâmicas em praticamente todas as sessões. Slides com formulário para cadastro de email, sessão sobre o autor, serviços prestados pelo sistema, testemunhas e muito mais. Este projeto foi criado acompanhando o curso de desenvolvimento web da Danki Code, porém toda a estrutura e código criados no curso são antigos, neste repositório criei todo sistema utilizando a estrutura MVC e sistema de rotas bem simples.</p>

<p>Este projeto e foi muito desafiador, vários subsistemas estão integrados dentro deste, aprendi a manipular datas um pouco melhor, fazer formatações de números, máscaras para inputs com Javascript, comunicação assíncrona entre o Javascript e o PHP.</p>

<p>Aqui também temos a parte adminstrativa do sistema, na qual o adminstrador pode gerir os dados de todo o site, adicionar/editar/deletar os slides, serviços, testemunhas, e vários outros sistemas.</p>

<img src=""/>

### Features

- [x] Página Home com informações dinâmicas
- [x] Cadastro de novos usuários com envio de email
- [x] Página de contato
- [x] Blog com páginação, pesquisa e filtro por categorias

- [x] Sistema adminstrativo
- [x] Usuários online
- [x] Gestão de slides
- [x] Gestão de serviços
- [x] Gestão de clientes
- [x] Gestão de produtos
- [x] Gestão de usuários
- [x] Envio de e-mails
- [x] Gestão de imóveis
- [x] Agêndamento de tarefas

### Pré requisitos
Antes de iniciar você precisa ter o [Xampp](https://www.apachefriends.org/pt_br/index.html) instalado na sua máquina, essa ferramenta traz junto de si o PHP e o Mysql. É bom também ter um editor de código como [VSCode](https://code.visualstudio.com/).

Você pode clonar este repositório ou baixar o zip.

Ao descompactar, é necessário rodar o **composer** para instalar as dependências e gerar o *autoload*.

Vá até a pasta do projeto, pelo *prompt/terminal* e execute:
> composer install

O banco de dados com todas as tabelas está dentro da pasta material, você pode importar em sua própria base de dados e testar após fazer as configurações do projeto.

### Configurações do projeto

Todos os arquivos de **configuração** do projeto estão dentro do arquivo *config.php*.

> date_default_timezone_set("America/Sao_Paulo");

> define("APP_NAME",          "Dev LP");
> define("APP_VERSION",       "1.0.0");
> define("BASE_URL",          "http://localhost/pastadoprojeto/public/");

// MYSQL DADOS
> define("MYSQL_SERVER",      "localhost");
> define("MYSQL_DATABASE",    "nomedobanco");
> define("MYSQL_USER",        "usuario");
> define("MYSQL_PASS",        "senha");
> define("MYSQL_CHARSET",     "utf8");

// AES ENCRIPT
> define("AES_KEY",           "muf4YDYMw3KeNv7rFkLFRJhkRwapBDVF");
> define("AES_IV",            "NjWA3sg3vyk6yVk2");

// EMAIL
> define("EMAIL_HOST",        "smtp.gmail.com");
> define("EMAIL_FROM",        "seuemail@provedor.com");
> define("EMAIL_PASS",        "senha");
> define("EMAIL_PORT",        00);

> define("PERMISSIONS",       [ 0 => "normal", 1 => "sub adminstrador", 2 => "adminstrador" ]);

### Tecnologias

Neste projeto foram usadas as seguintes tecnologias

- [PHP](https://www.php.net/)
- [Mysql](https://www.mysql.com/)
- [MPDF](https://mpdf.github.io/)

<hr/>
Criado com muito esforço por <a href="https://github.com/d8web/" target="_blank">Daniel</a>.