<form id="salary-form">
    <input type="text" name="user_name" placeholder="Nome do Usuário" required>
    <input type="number" name="days_worked" placeholder="Dias Trabalhados" required>
    <input type="number" step="0.01" name="hourly_rate" placeholder="Valor por Hora" required>
    <input type="number" name="hours_consumed" placeholder="Horas Consumidas" required>
    <button type="submit">Cadastrar</button>
</form>
<table id="salary-table">
    <thead>
        <tr>
            <th>Nome do Usuário</th>
            <th>Dias Trabalhados</th>
            <th>Horas Consumidas</th>
            <th>Total em R$</th>
        </tr>
    </thead>
    <tbody></tbody>
</table>
<script>
document.addEventListener('DOMContentLoaded', function() {
    loadSalaries(); // Carregar salários ao iniciar a página

    // Função de cadastro ou atualização
    document.getElementById('salary-form').addEventListener('submit', async (e) => {
        e.preventDefault();
        const formData = new FormData(e.target);
        const data = {
            user_name: formData.get('user_name'),
            days_worked: formData.get('days_worked'),
            hourly_rate: formData.get('hourly_rate'),
            hours_consumed: formData.get('hours_consumed')
        };

        // Verifica se estamos atualizando ou criando um novo registro
        const salaryId = e.target.dataset.salaryId;

        let method = 'POST';
        let url = '/api/salaries';
        if (salaryId) {
            method = 'PUT'; // Se salaryId existir, estamos atualizando
            url = `/api/salaries/${salaryId}`;
        }

        const response = await fetch(url, {
            method: method,
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(data)
        });

        const result = await response.json();

        if (response.ok) {
            alert(salaryId ? 'Salário atualizado com sucesso!' : 'Salário cadastrado com sucesso!');
            e.target.reset(); // Reseta o formulário
            e.target.removeAttribute('data-salary-id'); // Remove o id de atualização
            loadSalaries(); // Recarrega a tabela
        } else {
            alert('Erro: ' + result.message);
        }
    });
});

    // Função para carregar os salários e preencher a tabela
    async function loadSalaries() {
        const response = await fetch('/api/salaries');
        const salaries = await response.json();
        
        const tableBody = document.querySelector('#salary-table tbody');
        tableBody.innerHTML = ''; // Limpa a tabela antes de preencher
        
        salaries.forEach(salary => {
            const row = document.createElement('tr');
            row.innerHTML = `
                <td>${salary.user_name}</td>
                <td>${salary.days_worked}</td>
                <td>${salary.hours_consumed}</td>
                <td>R$ ${salary.total}</td>
                <td>
                    <button onclick="editSalaryForm(${salary.id})">Editar</button>
                    <button onclick="deleteSalary(${salary.id})">Excluir</button>
                </td>
            `;
            tableBody.appendChild(row);
        });
    }

    // Função para editar salário
    function editSalaryForm(id) {
        fetch(`/api/salaries/${id}`)
            .then(response => response.json())
            .then(salary => {
                document.querySelector('[name="user_name"]').value = salary.user_name;
                document.querySelector('[name="days_worked"]').value = salary.days_worked;
                document.querySelector('[name="hourly_rate"]').value = salary.hourly_rate;
                document.querySelector('[name="hours_consumed"]').value = salary.hours_consumed;

                // Define o id do salário a ser atualizado no dataset do formulário
                document.getElementById('salary-form').setAttribute('data-salary-id', id);
            });
    }

    // Função para deletar salário
    async function deleteSalary(id) {
        const confirmDelete = confirm('Tem certeza que deseja excluir este salário?');

        if (confirmDelete) {
            const response = await fetch(`/api/salaries/${id}`, {
                method: 'DELETE',
            });

            if (response.ok) {
                alert('Salário excluído com sucesso!');
                loadSalaries(); // Recarregar os dados na tabela
            } else {
                alert('Erro ao excluir salário.');
            }
        }
    }


</script>