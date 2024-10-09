
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Salários</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    
    <style>
        /* Seu estilo personalizado, se necessário */
    </style>
</head>
<body>

    <!-- Seu formulário de cadastro -->
    <div class="container mt-5">
        <h1 align="center">Cadastro de Salários</h1>

        <form id="salary-form" class="mb-4">
            <div class="row">
                <div class="col-5 mb-3">
                    <label for="user_name" class="form-label">Nome </label>
                    <input type="text" name="user_name" class="form-control" placeholder="Nome do Usuário">
                </div>
                <div class="col-2 mb-3">
                    <label for="days_worked" class="form-label">Dias Trabalhados</label>
                    <input type="number" name="days_worked" class="form-control" placeholder="Dias Trabalhados">
                </div>
                <div class="col-2 mb-3">
                    <label for="hourly_rate" class="form-label">Valor Hora</label>
                    <input type="text" name="hourly_rate" class="form-control" placeholder="Valor da Hora">
                </div>
                <div class="col-3 mb-3">
                    <label for="hours_consumed" class="form-label">Horas Consumidas</label>
                    <input type="number" name="hours_consumed" class="form-control" placeholder="Horas Consumidas">
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Salvar</button>
        </form>

        <!-- Filtro por Nome -->
        <div class="mb-3">
            <label for="filter-name" class="form-label">Filtrar por Nome</label>
            <input type="text" id="filter-name" class="form-control" placeholder="Digite o nome do usuário">
        </div>

        <!-- Tabela de salários -->
        <table class="table table-hover" id="salary-table">
            <thead>
                <tr>
                <th id="sort-name" style="cursor: pointer;">Nome do Usuário</th>
                    <th>Dias Trabalhados</th>
                    <th>Horas Consumidas</th>
                    <th id="sort-total" style="cursor: pointer;">Total (R$)</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <!-- As linhas serão preenchidas dinamicamente -->
            </tbody>
        </table>
    </div>

    <!-- Bootstrap JavaScript and dependencies (Popper.js) -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
   
    <!-- JavaScript -->
   <script src="{{asset('personalizados/script.js')}}"></script>
   
</body>
</html>
