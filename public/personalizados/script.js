let sortDirection = 'asc'; // Direção de ordenação inicial

        document.addEventListener('DOMContentLoaded', function() {
            loadSalaries(); // Carregar salários ao iniciar a página

            // Adiciona evento de clique para ordenar pelo nome
            document.getElementById('sort-name').addEventListener('click', () => {
                toggleSortDirection(); // Alterna a direção da ordenação
                loadSalaries(); // Carrega os salários novamente com a nova ordenação
            });

            // Adiciona evento de input para filtrar salários pelo nome
            document.getElementById('filter-name').addEventListener('input', () => {
                loadSalaries(); // Carrega os salários novamente aplicando o filtro
            });

            // Função de cadastro ou atualização
            document.getElementById('salary-form').addEventListener('submit', async (e) => {
                e.preventDefault(); // Evita o comportamento padrão do formulário

                const formData = new FormData(e.target);
                const data = {
                    user_name: formData.get('user_name'),
                    days_worked: formData.get('days_worked'),
                    hourly_rate: formData.get('hourly_rate'),
                    hours_consumed: formData.get('hours_consumed')
                };

                // Verifica se estamos editando (se o dataset tem um ID)
                const salaryId = e.target.getAttribute('data-salary-id');
                let method = 'POST';
                let url = '/api/salaries';

                // Se existe um ID, então é uma atualização
                if (salaryId) {
                    method = 'PUT';
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
                    e.target.removeAttribute('data-salary-id'); // Remove o ID de edição após o envio
                    loadSalaries(); // Recarrega a tabela de salários
                } else {
                    alert('Erro: ' + result.message);
                }
            });
        });

        // Função para carregar os salários e preencher a tabela
        async function loadSalaries() {
            const response = await fetch('/api/salaries');

            if (response.ok) {
                const salaries = await response.json();
                
                if (Array.isArray(salaries)) {
                    const filterValue = document.getElementById('filter-name').value.toLowerCase();
                    const filteredSalaries = salaries.filter(salary => 
                        salary.user_name.toLowerCase().includes(filterValue)
                    );

                    const sortedSalaries = sortSalaries(filteredSalaries, 'user_name', sortDirection);

                    const tableBody = document.querySelector('#salary-table tbody');
                    tableBody.innerHTML = ''; // Limpa a tabela antes de preencher
                    
                    sortedSalaries.forEach(salary => {
                        // Formata o total
                        const totalFormatted = (salary.hourly_rate * salary.hours_consumed).toLocaleString('pt-BR', {
                            style: 'currency',
                            currency: 'BRL'
                        });

                        const row = document.createElement('tr');
                        row.innerHTML = `
                            <td>${salary.user_name}</td>
                            <td>${salary.days_worked}</td>
                            <td>${salary.hours_consumed}</td>
                            <td>${totalFormatted}</td> <!-- Aqui está a formatação -->
                            <td>
                                <button class="btn btn-warning btn-sm" onclick="editSalaryForm(${salary.id})">Editar</button>
                                <button class="btn btn-danger btn-sm" onclick="deleteSalary(${salary.id})">Excluir</button>
                            </td>
                        `;
                        tableBody.appendChild(row);
                    });
                } else {
                    console.error('Erro: A resposta da API não é um array de salários.');
                }
            } else {
                console.error('Erro ao carregar salários: ', response.status);
            }
        }

        // Função para ordenar os salários
        function sortSalaries(salaries, key, direction) {
            return salaries.sort((a, b) => {
                if (a[key] < b[key]) {
                    return direction === 'asc' ? -1 : 1;
                }
                if (a[key] > b[key]) {
                    return direction === 'asc' ? 1 : -1;
                }
                return 0;
            });
        }

        // Função para alternar a direção da ordenação
        function toggleSortDirection() {
            sortDirection = (sortDirection === 'asc') ? 'desc' : 'asc';
        }

        // Função para editar salário
        async function editSalaryForm(id) {
            const response = await fetch(`/api/salaries/${id}`);
            
            if (response.ok) {
                const salary = await response.json();
                
                // Preenche os campos do formulário com os dados a serem editados
                document.querySelector('[name="user_name"]').value = salary.user_name;
                document.querySelector('[name="days_worked"]').value = salary.days_worked;
                document.querySelector('[name="hourly_rate"]').value = salary.hourly_rate;
                document.querySelector('[name="hours_consumed"]').value = salary.hours_consumed;

                // Define o ID do salário a ser atualizado no dataset do formulário
                document.getElementById('salary-form').setAttribute('data-salary-id', id);
            } else {
                alert('Erro ao buscar o salário.');
            }
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