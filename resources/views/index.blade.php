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
                    <h5 class="card-title">Exibindo {{ $clientes->count() }} 
                        clientes de {{ $clientes->total() }} ({{ $clientes->firstItem() }} a 
                        {{ $clientes->lastItem()}})
                    </h5>
                    <table class="table table-hover">
                        <thead>
                            <th scope="col">#</th>
                            <th scope="col">Nome</th>
                            <th scope="col">Sobrenome</th>
                            <th scope="col">E-mail</th>
                        </thead>
                        <tbody>
                        @foreach($clientes as $cliente) <!--Foreach preenche a tabela com os dados de cada cliente-->
                            <tr>
                                <td>{{ $cliente->id }}</td>
                                <td>{{ $cliente->nome }}</td>
                                <td>{{ $cliente->sobrenome }}</td>
                                <td>{{ $cliente->email }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="card-footer">
                    {{ $clientes-> links() }} <!--Cria vários links para a paginação -->
                </div>
            </div>
        </div>
        <!-- Exibe informações contidas dentro do array de clientes -->
        <!-- <?php var_dump($clientes) ?> -->
        <script src="{{asset('js/app.js')}}" type="text/javascript"></script>
    </body>
</html>
