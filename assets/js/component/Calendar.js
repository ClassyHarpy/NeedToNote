document.addEventListener('DOMContentLoaded', () => {
    const calendarEl = document.getElementById('calendar');

    const calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        selectable: true,
        select: (info) => {
            const title = prompt('Title:');

            if (title) {
                const event = { title, start: info.start, end: info.end, allDay: info.allDay }

                calendar.addEvent(event);
                save(event);
            }
        }
    });

    calendar.render();

    loadEvents(calendar, JSON.parse(calendarEl.dataset.events));
});

function loadEvents(calendar, events) {
    events.forEach((event) =>
        calendar.addEvent(event)
    );
}

function save(event) {
    fetch(`${location.pathname}/save`, { method: "POST", body: JSON.stringify({ event }) }).then(() => {
        // TODO
    })
}