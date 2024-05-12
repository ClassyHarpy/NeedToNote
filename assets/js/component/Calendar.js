document.addEventListener('DOMContentLoaded', () => {
    const calendarEl = document.getElementById('calendar');

    const calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        selectable: true,
        select: (info) => {
            const title = prompt('Title:');

            if (title) {
                const event = { id: window?.crypto?.randomUUID().substring(0, 10), title, start: info.start, end: info.end, allDay: info.allDay };

                calendar.addEvent(event);
                save(event);
            }
        },
        eventClick: (clickInfo) => {
            if (confirm("Are you sure you want to delete this event?")) {
                clickInfo.event.remove();
                deleteEvent(clickInfo.event.id);
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
    });
}

function deleteEvent(id) {
    fetch(`${location.pathname}/delete/${id}`, { method: "PATCH" }).then(() => {
        // TODO
    });
}
