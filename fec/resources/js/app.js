import './bootstrap';

const clockElement = document.getElementById('clock');

async function updateTime() {
    try {
        clockElement.disabled = true;
        clockElement.textContent = "Loading...";

        const response = await fetch('https://worldtimeapi.org/api/timezone/UTC');

        if (!response.ok) throw new Error('API request failed');
        const data = await response.json();
        const datetime = new Date(data.datetime);

        const hours = String(datetime.getHours()).padStart(2, '0');
        const minutes = String(datetime.getMinutes()).padStart(2, '0');
        const seconds = String(datetime.getSeconds()).padStart(2, '0');

        clockElement.textContent = `${hours}:${minutes}:${seconds}`;
    } catch (error) {
        clockElement.textContent = "Click to retry";
        console.error('Error:', error);
    } finally {
        clockElement.disabled = false;
    }
}

clockElement.addEventListener('click', updateTime);