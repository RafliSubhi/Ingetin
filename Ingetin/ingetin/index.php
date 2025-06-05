<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: auth/login.php");
    exit;
}
require_once 'includes/header.php';
require_once 'function/tasks.php';
require_once 'function/savings.php';

$tasks = getAllTasksByUser($username);
$savings = getAllSavings();
$total_tasks = count($tasks);
$completed_tasks = count(array_filter($tasks, fn($task) => $task['status'] === 'completed'));
$total_savings = count($savings);
$completed_savings = count(array_filter($savings, fn($saving) => $saving['status'] === 'completed'));
$calendar_events = [];
foreach ($tasks as $task) {
    if (!empty($task['deadline'])) {
        $calendar_events[] = [
            'title' => $task['title'],
            'start' => date('Y-m-d', strtotime($task['deadline'])),
            'color' => $task['status'] === 'completed' ? '#10b981' : '#3b82f6',
            'extendedProps' => [
                'description' => $task['description'] ?? ''
            ]
        ];
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inget!n - Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/main.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        * { 
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }
        
        body {
            font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
            background-color: #f9fafb;
            color: #111827;
            line-height: 1.5;
        }
        
        /* Header Styles */
        .dashboard-header {
            background: linear-gradient(135deg, #2563eb, #1d4ed8);
            color: white;
            padding: 2rem 1rem;
            border-radius: 0 0 1rem 1rem;
            text-align: center;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        
        .header-stats {
            display: flex;
            flex-wrap: wrap;
            gap: 1rem;
            justify-content: center;
            margin-top: 1.5rem;
        }
        
        .stat-badge {
            background: rgba(255,255,255,0.15);
            backdrop-filter: blur(6px);
            padding: 1rem;
            border-radius: 1rem;
            display: flex;
            flex-direction: column;
            align-items: center;
            min-width: 120px;
            text-decoration: none;
            color: white;
            transition: transform 0.2s;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        
        .stat-badge:hover {
            transform: scale(1.05);
            background: rgba(255,255,255,0.2);
        }
        
        .stat-value {
            font-size: 1.5rem;
            font-weight: bold;
            margin-bottom: 0.25rem;
        }
        
        /* Main Container */
        .dashboard-container {
            max-width: 1024px;
            margin: 0 auto;
            padding: 1rem;
        }
        
        .dashboard-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }
        
        /* Card Styles */
        .card {
            background: white;
            border-radius: 0.75rem;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
            overflow: hidden;
            transition: transform 0.2s, box-shadow 0.2s;
        }
        
        .card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }
        
        .card-header {
            background: #f1f5f9;
            padding: 1rem;
            font-weight: 600;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid #e5e7eb;
        }
        
        .card-header a {
            color: #3b82f6;
            text-decoration: none;
            font-size: 0.875rem;
            font-weight: 500;
        }
        
        .card-header a:hover {
            text-decoration: underline;
        }
        
        .card-body {
            padding: 1rem;
        }
        
        .list-group-item {
            padding: 0.75rem 0;
            border-bottom: 1px solid #e5e7eb;
        }
        
        .list-group-item:last-child {
            border-bottom: none;
        }
        
        /* Badge Styles */
        .badge {
            padding: 0.35rem 0.75rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 500;
            display: inline-block;
        }
        
        .badge-primary { background: #3b82f6; color: white; }
        .badge-accent { background: #ef4444; color: white; }
        .badge-secondary { background: #6b7280; color: white; }
        
        /* Progress Bar */
        .progress {
            background: #e5e7eb;
            border-radius: 1rem;
            height: 0.5rem;
            overflow: hidden;
            margin-top: 0.5rem;
        }
        
        .progress-bar {
            background: #6366f1;
            height: 100%;
            transition: width 0.3s ease;
        }
        
        /* Empty State */
        .empty-state {
            text-align: center;
            color: #6b7280;
            padding: 1.5rem;
        }
        
        /* Calendar Styles */
        .calendar-container {
            margin-top: 2rem;
            background: white;
            border-radius: 0.75rem;
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
            overflow: hidden;
        }
        
        .fc-header-toolbar {
            padding: 1rem;
            margin-bottom: 0 !important;
            background: #f8fafc;
            border-bottom: 1px solid #e2e8f0;
        }
        
        .fc-toolbar-title {
            font-weight: 600;
            color: #1e293b;
            font-size: 1.1rem;
        }
        
        .fc-button {
            background-color: #4f46e5 !important;
            border: none !important;
            border-radius: 6px !important;
            padding: 0.5rem 0.75rem !important;
            text-transform: capitalize !important;
            box-shadow: none !important;
            font-size: 0.875rem !important;
            transition: background-color 0.2s !important;
        }
        
        .fc-button:hover {
            background-color: #4338ca !important;
        }
        
        .fc-button:active, .fc-button:focus {
            box-shadow: none !important;
        }
        
        .fc-view-harness {
            background: white;
            border-radius: 0 0 0.75rem 0.75rem;
        }
        
        .fc-col-header-cell {
            background: #f8fafc;
            padding: 0.5rem 0;
        }
        
        .fc-col-header-cell-cushion {
            color: #475569;
            font-weight: 500;
            text-decoration: none !important;
            font-size: 0.8rem;
            padding: 0.25rem !important;
        }
        
        .fc-daygrid-day {
            border-color: #e2e8f0 !important;
        }
        
        .fc-daygrid-day-number {
            color: #475569;
            font-weight: 500;
            padding: 4px 6px !important;
            font-size: 0.85rem;
        }
        
        .fc-event {
            border: none !important;
            border-radius: 4px !important;
            padding: 2px 4px !important;
            font-size: 0.75rem !important;
            cursor: pointer !important;
            margin: 1px 2px !important;
        }
        
        .fc-event:hover {
            opacity: 0.9;
        }
        
        .fc-day-today {
            background-color: #f0f9ff !important;
        }
        
        .fc-daygrid-event-harness {
            margin-top: 1px !important;
        }
        
        /* Mobile Responsive Styles */
        @media (max-width: 768px) {
            .dashboard-header {
                padding: 1.5rem 0.5rem;
                border-radius: 0;
            }
            
            .header-stats {
                gap: 0.75rem;
                margin-top: 1rem;
            }
            
            .stat-badge {
                min-width: calc(50% - 0.75rem);
                padding: 0.75rem;
                flex: 1 0 calc(50% - 0.75rem);
            }
            
            .stat-value {
                font-size: 1.25rem;
            }
            
            .dashboard-grid {
                grid-template-columns: 1fr;
                gap: 1rem;
            }
            
            /* Calendar Mobile Styles */
            .calendar-container {
                margin: 1rem -0.5rem;
                border-radius: 0;
                box-shadow: none;
            }
            
            .fc-header-toolbar {
                flex-direction: column;
                align-items: stretch;
                padding: 0.75rem;
                gap: 0.5rem;
            }
            
            .fc-toolbar-title {
                font-size: 1rem;
                margin: 0;
                order: -1;
            }
            
            .fc-toolbar-chunk {
                display: flex;
                justify-content: space-between;
            }
            
            .fc-button {
                padding: 0.4rem 0.6rem !important;
                font-size: 0.75rem !important;
            }
            
            .fc-col-header-cell-cushion {
                font-size: 0.7rem;
                padding: 0.1rem !important;
            }
            
            .fc-daygrid-day-number {
                font-size: 0.7rem;
            }
            
            .fc-event {
                font-size: 0.6rem !important;
                padding: 1px 2px !important;
            }
            
            .fc .fc-toolbar {
                display: flex;
                flex-direction: column;
                gap: 0.5rem;
            }
            
            .fc-toolbar-chunk:last-child {
                order: -1;
            }
        }
        
        @media (max-width: 480px) {
            .stat-badge {
                min-width: calc(50% - 0.5rem);
                padding: 0.5rem;
            }
            
            .stat-value {
                font-size: 1.1rem;
            }
            
            .fc-toolbar-chunk {
                flex-wrap: wrap;
                justify-content: center;
                gap: 0.25rem;
            }
            
            .fc-button {
                padding: 0.3rem 0.5rem !important;
            }
        }
    </style>
</head>
<body>
    <div class="dashboard-header">
        <h1>Inget!n</h1>
        <p>Ringkasan aktivitas dan pencapaian Anda</p>
        <div class="header-stats">
            <a href="tasks.php" class="stat-badge">
                <div class="stat-value"><?= $total_tasks ?></div>
                <div>Total Tugas</div>
            </a>
            <a href="tasks.php" class="stat-badge">
                <div class="stat-value"><?= $completed_tasks ?></div>
                <div>Tugas Selesai</div>
            </a>
            <a href="savings.php" class="stat-badge">
                <div class="stat-value"><?= $total_savings ?></div>
                <div>Total Tabungan</div>
            </a>
            <a href="savings.php" class="stat-badge">
                <div class="stat-value"><?= $completed_savings ?></div>
                <div>Tabungan Selesai</div>
            </a>
        </div>
    </div>

    <div class="dashboard-container">
        <div class="dashboard-grid">
            <div class="card">
                <div class="card-header">
                    <span><i class="fas fa-tasks"></i> Tugas Terdekat</span>
                    <a href="tasks.php">Lihat Semua</a>
                </div>
                <div class="card-body">
                    <?php 
                    $upcoming_tasks = array_filter($tasks, fn($task) => $task['status'] !== 'completed');
                    usort($upcoming_tasks, fn($a, $b) => strtotime($a['deadline']) - strtotime($b['deadline']));
                    
                    if ($upcoming_tasks): ?>
                        <?php foreach (array_slice($upcoming_tasks, 0, 5) as $task): 
                            $days_left = floor((strtotime($task['deadline']) - time()) / 86400);
                            $badge_class = $days_left < 0 ? 'badge-accent' : ($days_left < 3 ? 'badge-primary' : 'badge-secondary');
                        ?>
                            <div class="list-group-item">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div>
                                        <strong><?= htmlspecialchars($task['title']) ?></strong>
                                        <div style="font-size: 0.85rem; color: #6b7280; margin-top: 0.25rem;">
                                            <i class="far fa-calendar-alt"></i> <?= date('d M Y', strtotime($task['deadline'])) ?> —
                                            <?= $days_left >= 0 ? "$days_left hari lagi" : "Ayo kerjakan!" ?>
                                        </div>
                                    </div>
                                  <span class="badge <?= $badge_class ?>">
    <?= $task['status'] === 'not_started' ? 'Belum' : ucfirst($task['status']) ?>
</span>

                                </div>
                                <?php if (!empty($task['description'])): ?>
                                    <div style="font-size: 0.8rem; color: #6b7280; margin-top: 0.25rem;">
                                        <?= htmlspecialchars(substr($task['description'], 0, 50)) ?><?= strlen($task['description']) > 50 ? '...' : '' ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="empty-state">
                            <i class="far fa-check-circle" style="font-size: 2rem; margin-bottom: 0.5rem;"></i>
                            <p>Tidak ada tugas yang akan datang</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <span><i class="fas fa-piggy-bank"></i> Tabungan Aktif</span>
                    <a href="savings.php">Lihat Semua</a>
                </div>
                <div class="card-body">
                    <?php 
                    $active_savings = array_filter($savings, fn($s) => $s['status'] !== 'completed');
                    usort($active_savings, fn($a, $b) => strtotime($a['target_date']) - strtotime($b['target_date']));
                    
                    if ($active_savings): ?>
                        <?php foreach (array_slice($active_savings, 0, 5) as $saving): 
                            $progress = ($saving['current_amount'] / $saving['target_amount']) * 100;
                            $days_left = floor((strtotime($saving['target_date']) - time()) / 86400);
                        ?>
                            <div class="list-group-item">
                                <div class="d-flex justify-content-between align-items-start">
                                    <strong><?= htmlspecialchars($saving['purpose']) ?></strong>
                                    <small style="color: #6b7280;"><?= $days_left >= 0 ? "$days_left hari lagi" : "terlewat" ?></small>
                                </div>
                                <div class="progress">
                                    <div class="progress-bar" style="width: <?= $progress ?>%"></div>
                                </div>
                                <div style="font-size: 0.85rem; color: #6b7280; margin-top: 0.25rem;">
                                    Rp <?= number_format($saving['current_amount'], 0, ',', '.') ?> / Rp <?= number_format($saving['target_amount'], 0, ',', '.') ?>
                                    <span style="float: right;"><?= round($progress, 1) ?>%</span>
                                </div>
                                <div style="font-size: 0.8rem; color: #6b7280;">
                                    <i class="far fa-calendar-alt"></i> <?= date('d M Y', strtotime($saving['target_date'])) ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="empty-state">
                            <i class="far fa-check-circle" style="font-size: 2rem; margin-bottom: 0.5rem;"></i>
                            <p>Tidak ada tabungan aktif</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Calendar Section -->
        <div class="calendar-container">
            <div id="calendar"></div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const calendarEl = document.getElementById('calendar');
        const calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            headerToolbar: {
                left: 'prev,next',
                center: 'title',
                right: 'today'
            },
            events: <?= json_encode($calendar_events) ?>,
            height: 'auto',
            aspectRatio: window.innerWidth < 768 ? 1 : 1.5,
            dayMaxEvents: window.innerWidth < 768 ? 1 : true,
            eventDisplay: 'block',
            eventTimeFormat: { 
                hour: '2-digit',
                minute: '2-digit',
                hour12: false
            },
            eventDidMount: function(info) {
                // Add tooltip with description
                if (info.event.extendedProps.description) {
                    new bootstrap.Tooltip(info.el, {
                        title: info.event.extendedProps.description,
                        placement: 'top',
                        trigger: 'hover',
                        container: 'body'
                    });
                }
            },
            viewDidMount: function(view) {
                // Adjust view for mobile
                if (window.innerWidth < 768) {
                    calendar.setOption('headerToolbar', {
                        left: 'prev',
                        center: 'title',
                        right: 'next'
                    });
                }
            }
        });
        calendar.render();
        
        // Handle window resize
        function handleResize() {
            if (window.innerWidth < 768) {
                calendar.setOption('aspectRatio', 1);
                calendar.setOption('dayMaxEvents', 1);
                calendar.setOption('headerToolbar', {
                    left: 'prev',
                    center: 'title',
                    right: 'next'
                });
            } else {
                calendar.setOption('aspectRatio', 1.5);
                calendar.setOption('dayMaxEvents', true);
                calendar.setOption('headerToolbar', {
                    left: 'prev,next',
                    center: 'title',
                    right: 'today'
                });
            }
            calendar.updateSize();
        }
        
        window.addEventListener('resize', handleResize);
        
        // Initialize tooltips
        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltipTriggerList.map(function(tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    });
    </script>
    <?php require_once 'includes/messages.php'; ?>
    <?php require_once 'includes/footer.php'; ?>
</body>
</html>