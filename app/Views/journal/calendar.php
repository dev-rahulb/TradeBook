<?= $this->extend('layout/main_layout') ?>
<?= $this->section('content') ?>

<!-- FullCalendar CSS -->
<link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.css" rel="stylesheet">

<div class="container-fluid px-4 mt-4">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h2>📆 Trading Journal Calendar</h2>
    <a href="<?= base_url('journal/create') ?>" class="btn btn-primary">+ Add Entry</a>
  </div>

  <div class="card shadow-sm p-4">
    <div id="calendar"></div>
  </div>
</div>

<!-- FullCalendar JS -->
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>

<script>
  document.addEventListener('DOMContentLoaded', function () {
    var calendarEl = document.getElementById('calendar');

    var calendar = new FullCalendar.Calendar(calendarEl, {
      initialView: 'dayGridMonth',
      height: 'auto',
      headerToolbar: {
        left: 'prev,next today',
        center: 'title',
        right: ''
      },
      events: <?= json_encode($calendarEvents) ?>,
      eventClick: function(info) {
        const date = info.event.startStr;
        window.location.href = "<?= base_url('journal/dayView') ?>/" + date;
      },
    });

    calendar.render();
  });
</script>

<?= $this->endSection() ?>
