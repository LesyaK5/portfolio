// получаем список зарегистрированных клиентов для проверки, чтобы новый логин не совпал с другими
async function getLogins(URL) {
    let response = await fetch(URL);
    if (response.ok) {
        let json = await response.json();
        // let json = await response.text();
        return json;
    }
}

async function main() {
    let message = '';
    let logins = await getLogins('../server/getLogins.php');
    let userName = document.querySelector('#regForm-firstName');
    let errorBox = document.querySelector('.reg-message');
    userName.addEventListener('input', () => {
        if (userName.value.length === 0) {
            message = '';   
        }
        else if (logins.indexOf(userName.value.toLowerCase()) != -1) {
            message = 'Логин занят';   
            errorBox.style.color = 'red';
        } else {
            message = 'Логин свободен';
            errorBox.style.color = 'green';
        }
        errorBox.style.display = 'block';
        errorBox.textContent = message;
    })
}


main();