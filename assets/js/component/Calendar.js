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
        },
        dateClick: (info) => {
            const event = {
                title: '',
                start: info.date,
                end: info.date
            };

            calendar.addEvent(event);
        }
    });

    calendar.render();

    loadEvents(calendar, JSON.parse(calendarEl.dataset.events).event);
});

function loadEvents(calendar, events) {
    calendar.addEvent(events);
  //  events.forEach();
}

function save(event) {
    fetch(`${location.pathname}/save`, { method: "POST", body: JSON.stringify({ event }) }).then(() => {
        // TODO
    })
}