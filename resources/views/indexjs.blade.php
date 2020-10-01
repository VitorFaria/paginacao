<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link href="{{ asset('css/app.css' )}}" rel="stylesheet">
        <title>Paginação</title>
        <style>
            body{
                padding: 20px;
            }
            /*
            .container{
                margin-top: 20px;
            }
            */
        </style>     
    </head>
    <body>
        <div class="container">
            <div class="card text-center">
                <div class="card-header">
                    Tabela de clientes
                </div>
                <div class="card-body">
                    <h5 class="card-title" id="cardTitle">

                    </h5>
                    <table class="table table-hover" id="tabelaClientes">
                        <thead>
                            <th scope="col">#</th>
                            <th scope="col">Nome</th>
                            <th scope="col">Sobrenome</th>
                            <th scope="col">E-mail</th>
                        </thead>
                        <tbody>
                    
                        </tbody>
                    </table>
                </div>
                <div class="card-footer">
                    <nav id="paginator">
                        <ul class="pagination">
                <!--
                          <li class="page-item disabled">
                            <a class="page-link" href="#" tabindex="-1">Previous</a>
                          </li>
                          <li class="page-item"><a class="page-link" href="#">1</a></li>
                          <li class="page-item active">
                            <a class="page-link" href="#">2</a>
                          </li>
                          <li class="page-item"><a class="page-link" href="#">3</a></li>
                          <li class="page-item">
                            <a class="page-link" href="#">Next</a>
                          </li>
                -->
                        </ul>
                      </nav>
                </div>
            </div>
        </div>
        <script src="{{asset('js/app.js')}}" type="text/javascript"></script>
        
        <script type="text/javascript">
            
            // -- Monta a linha --

            // Função que monta a linha, passando um parâmetro. Parâmetro pego na linha 71, no data.data[i]
            function montarLinha(cliente){
                // Retorna a tabela pré montada com os dados do cliente
                return '<tr>' + 
                    '<td>' + cliente.id + '</td>' + // Pega o id do cliente
                    '<td>' + cliente.nome + '</td>'+ // Pega o nome do cliente
                    '<td>' + cliente.sobrenome + '</td>' + // Pega o sobrenome do cliente
                    '<td>' + cliente.email + '</td>' + // Pega o email do cliente
                '</tr>'
            }

            // -- Monta a tabela --

            function montarTabela(data){ // Função monta a tabela passando o parâmetro data, que é o nome do array
                
                // Pega o id da tabela, dentro do tbody, dentro da tr, remove o que tiver dentro da table
                $('#tabelaClientes>tbody>tr').remove();

                // For percorre o array data
                // data.data.length = nome do array era data. Para acessar os clientes era data tbm, por isso data.data
                for (i = 0;i < data.data.length; i++){
                    //console.log(data.data[i]); // Testou no console se mostrou os dados dos clientes
                    s = montarLinha(data.data[i]); // variável s recebe a função montarLinha passando o parâmetro dos dados dos clientes
                    $('#tabelaClientes>tbody').append(s); // Comando Jquery, pega o id da tabela, dentro do tbody, adiciona a linha
                }
            }

            // -- Configura o ícone 'Anterior' da paginação --

            // Pega o item anterior, o ícone 'Anterior' na paginação e passa o parâmetro do total de clientes
            function getItemAnterior(data){ 
                i = data.current_page - 1; // Adiciona +1 para quando clicar em próximo, ele vá para a página anterior

                if (data.current_page == 1) // Se a página atual for igual a 1, o ícone 'Anterior' não aparece
                    s = '<li class="page-item disabled">';

                else // Do contrário, fica aparecendo o ícone 'Anterior'
                    s = '<li class="page-item">'; 
                    s += '<a class="page-link" ' + ' pagina=" ' + i + ' "href="javacript:void(0);" tabindex="-1">Anterior</a>';
                    return s;

            }

            // -- Configura os ícones da paginação --

            function getItem(data, i){ // Função que pega o item, passando o total de clientes e o indice
                
                // OBS: current_page e total utilizado nas funções foi pego direto do console quando pegou os dados do json
                // Faz a verificação, se o i for igual a posição da página atual, var s recebe a classe que deixa o link como ativo
                if (i == data.current_page)
                    s = '<li class="page-item active">';
                
                else // Do contrário, os links são preenchidos normalmente sem estar marcado como ativo
                    s = '<li class="page-item">';
                    s += '<a class="page-link" ' + ' pagina=" ' + i + ' " href="javacript:void(0);">' + i + '</a></li>';
                    return s;
            }

            // -- Configura o ícone 'Próximo' da paginação --

            // Pega o próximo item, o ícone 'Próximo' na paginação e passa o total de clientes como parâmetro
            function getItemProximo(data){ 
                i = data.current_page + 1; // Adiciona +1 para quando clicar em próximo, ele vá para a próxima página

                // Se a página atual for igual a último página, o ícone 'Próximo' não aparece
                if (data.current_page == data.last_page)
                    s = '<li class="page-item disabled">';

                else // Do contrário, fica aparecendo o ícone 'Próximo'
                    s = '<li class="page-item">';
                    s += '<a class="page-link" ' + ' pagina=" ' + i + ' " href="javacript:void(0);">Próximo</a>';
                    return s;
            }

            // -- Monta a paginação --

            // Função que monta a paginação, passando um parâmetro que vai pegar o total de clientes cadastrados
            function montarPaginator(data){ 
                $('#paginator>ul>li').remove(); 

                // Utiliza a função append() e jquery e adiciona o ícone 'Anterior'
                $('#paginator>ul').append(getItemAnterior(data));  


                /* Faz algumas verificações para que a paginação fique mostrando valores de 10 em 10 e conforme
                   for selecionando os números pra frente ou para trás ele identique que tem que mostrar novos 
                   números. EX: Selecionou o número 7. Ele deve mostrar como se o 7 ficasse no centro, na posicao
                   5, desse jeito: 2 3 4 5 6 7 8 9 10 11 -- Desse jeito, tem 5 nums antes do 7 e 4 dps, com 7 no centro
                */
                // Para alterar a qtde de páginas que quer mostrar, é só alterar o valor de n para um valor X
                n = 10; // N é o numero de páginas que serão mostradas na barra de paginação. Nesse caso, será mostrado 10 páginas
                var testa = data.current_page - n/2; // Variável criada para testar a lógica dos valores
                if(data.current_page - n/2 <= 1)
                    inicio = 1;
                else if (data.last_page - data.current_page < n)
                    inicio = data.last_page - n + 1;
                else
                    inicio = data.current_page - n/2;
                    console.log(data.current_page);
                    console.log(data.last_page);
                    console.log(testa); // Console log só para testar a lógica dos valores

                // Define o início e o fim para separar a paginação e mostrar apenas os 10 primeiros elementos
                fim = inicio + n - 1;
                for (i = inicio; i<= fim; i++){ // For percorre o total de clientes. data.total = 1000
                    s = getItem(data, i); // Variável recebe uma função que passa o total de clientes e o i que é o indice
                    $('#paginator>ul').append(s); // Usa jquery, pegando o id criado para a paginação, adicionando o s
                  
                    //console.log(s);
                }
                // Utiliza a função append() e jquery e adiciona o ícone 'Próximo'
                $('#paginator>ul').append(getItemProximo(data)); 
               
                
            }

            // -- Carrega os clientes na tabela com a paginação montada --
         
            function carregarClientes(pagina){ // Função que carrega os clientes
                // Pega dados da rota /json. Laravel espera receber a page, que recebe pagina, resp recebe os dados dos clientes
                $.get( '/json', {page: pagina}, function(resp) { 
                    console.log(resp);
                    montarTabela(resp); // Função montarTabela recebe o parâmetro dos dados dos 10 primeiros clientes
                    montarPaginator(resp); // Função montarPaginator recebe o parâmetro dos dados dos 10 primeiros clientes
                    
                    // Função jquery para habilitar o click nos ícones das páginas. 
                    // Ele habilita o click dentro do a, no momento em que clica, ele chama o a + o atributo dentro dele, que é a pagina 
                    /* OBS: Essa função de click tem que ser colocada logo após a tabela e o paginator estiverem prontos
                       e forem carregados, do contrário, se colocar a função em outro local, ela não vai funcionar
                    */
                    $('#paginator>ul>li>a').click(function(){ 
                        carregarClientes( $(this).attr('pagina') ); 
                    });
                    $('#cardTitle').html('Exibindo ' + resp.per_page + ' clientes de ' + resp.total + 
                    ' ( ' + resp.from + ' a ' + resp.to + ' )' );
                });
            }

            // Chama a função automatica do JQUERY para carregar tudo

            // Quando todo o conteúdo for carregado, essa função executa automaticamente
            $(function(){
                carregarClientes(); // Chama a função carregarClientes passando o parâmetro 1, para carregar desde o primeiro cliente
            });
        </script>
    </body>
</html>
