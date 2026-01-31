console.log("Ok!")

const addQueryForm = document.getElementById('addQueryForm');
const btnAddSubmit = document.getElementById('btn-add-submit');


addQueryForm.addEventListener('submit', (e) => {
    e.preventDefault();
    
    btnAddSubmit.textContent = 'Сохранение...';
    btnAddSubmit.disabled = true;

    fetch('index.php', {
        method: 'POST',
        body: new FormData(addQueryForm)
    })
    .then((response) => response.json())
    .then((data) => {

        // Создание таблицы
        let tableHtml = '<table class="table">';

        // Генерация шапки (берём ключи из самого первого объекта)
        if (data.length > 0) {
            tableHtml += '<thead class="table-secondary"><tr>';
            const firstItem = data[0];
            for (let key in firstItem) {
                tableHtml += `<th scope="col">${key}</th>`;
            }
            tableHtml += '</tr></thead>';
        }

        // Тело таблицы
        tableHtml += '<tbody>';
        Object.values(data).forEach((arr) => {
            tableHtml += '<tr>';
            for (let key in arr) {
                const value = arr[key] ?? '-'; 
                tableHtml += `<td>${value}</td>`;
            }
            tableHtml += '</tr>';
        });
        tableHtml += '</tbody></table>';

        // Выводим на страницу
        document.getElementById('table-container').innerHTML = tableHtml;        


        btnAddSubmit.textContent = 'Сохранить';
        btnAddSubmit.disabled = false;
        addQueryForm.reset(); 
    })
    .catch(error => {
        console.error('Ошибка:', error);
        btnAddSubmit.disabled = false;
        btnAddSubmit.textContent = 'Ошибка';
    });
});

// SELECT * FROM movies LIMIT 3;








   














// Генерация списка ====================================================
//======================================================================
// С помошью Object.entries(data) - превращает массив в key => value, Object.values(data) - только значения
// const container = document.getElementById('movie-list');
// let html = '<ul>';

// Object.entries(data).forEach(([key, value]) => {  
//     html += `<li><strong>${key}:</strong> ${value}</li>`;
// });


// html += '</ul>';
// container.innerHTML = html;


// Двойной for
// const container = document.getElementById('movie-list');
// let html = '<ul>';

// data.forEach(arr => {  
//     for (let key in arr) {
//         const value = [arr[key]]
//         html += `<li><strong>${key}:</strong> ${value}</li>`;
//     }
// });

// html += '</ul>';
// container.innerHTML = html;