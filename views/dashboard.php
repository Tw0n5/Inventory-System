<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Inventory App - Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="/public/style.css">
</head>
<body>
    <div class="dashboard-wrapper">
        <header class="header">
            <div class="header-left"><i class="fas fa-bars"></i>INVENTORY APP</div>
            <div class="header-right">
                <div class="user-avatar">O</div><span>Owner</span>
                <a href="/" class="logout-btn">Logout</a>
            </div>
        </header>

        <nav class="sidebar">
            <a href="#" class="sidebar-item active"><i class="fas fa-desktop"></i>Units</a>
            <a href="#" class="sidebar-item"><i class="fas fa-users"></i>Persons</a>
            <a href="#" class="sidebar-item"><i class="fas fa-file-contract"></i>Reports</a>
            <a href="#" class="sidebar-item"><i class="fas fa-cog"></i>Settings</a>
        </nav>

        <main class="main-content">
            <div class="table-container">
                <div class="table-header">
                    <div class="table-title">All units</div>
                    <div class="table-controls"><i class="fas fa-search"></i><i class="fas fa-plus"></i></div>
                </div>
                <table>
                    <thead>
                        <tr>
                            <th style="width:40px;"></th>
                            <th>Status</th><th>Serial</th><th>Type</th><th>Name</th><th>Assigned to</th><th>From</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $units = InventoryModel::getAllUnits();

                            $metrics = InventoryModel::getMetrics();?>
                        <?php foreach($units as $unit): ?>
                            <tr>
                                <td><i class="fas fa-wrench" style="color: #bdc3c7;"></i></td>
                                
                                <td>
                                    <span class="status-badge status-<?= strtolower($unit['Status'] ?? 'unknown') ?>">
                                        <?= htmlspecialchars($unit['Status'] ?? 'N/A') ?>
                                    </span>
                                </td>
                                
                                <td>
                                    <?= htmlspecialchars($unit['Processor'] ?? '-') ?> 
                                    <small style="color: #7f8c8d; display: block;"><?= htmlspecialchars($unit['Storage'] ?? '') ?></small>
                                </td>
                                
                                <td>
                                    <div class="type-container">
                                        <?php if (!empty($unit['Processor'])): ?>
                                            <i class="fas fa-desktop type-icon"></i>Computer
                                        <?php else: ?>
                                            <i class="fas fa-tv type-icon"></i>Monitor
                                        <?php endif; ?>
                                    </div>
                                </td>
                                
                                <td><?= htmlspecialchars($unit['Model'] ?? 'Generic Device') ?></td>
                                
                                <td><?= htmlspecialchars($unit['Assigned to'] ?? '-') ?></td>
                                
                                <td><strong><?= htmlspecialchars($unit['Memory'] ?? '-') ?></strong></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <aside class="stats-container">
                <?php foreach($metrics as $name => $metric): 
                    $offset = 215 - (215 * $metric['percentage']) / 100;
                ?>
                    <div class="stat-card">
                        <div class="stat-type" style="text-transform: capitalize;"><?= $name ?></div>
                        <div class="progress-circle">
                            <svg viewBox="0 0 80 80">
                                <circle class="bg-circle" cx="40" cy="40" r="36" />
                                <circle class="fg-circle" cx="40" cy="40" r="36" style="stroke-dasharray: 215; stroke-dashoffset: <?= $offset ?>;"/>
                            </svg>
                            <div class="progress-text"><?= $metric['percentage'] ?>%</div>
                        </div>
                        <div class="stat-label-box"><div class="stat-label">Taken</div></div>
                        <div class="stat-detail"><span>Available</span><span class="stat-detail-value"><?= $metric['available'] ?> pcs</span></div>
                        <div class="stat-detail"><span>Broken</span><span class="stat-detail-value"><?= $metric['broken'] ?> pcs</span></div>
                        <div class="stat-detail"><span>Deprecated</span><span class="stat-detail-value"><?= $metric['deprecated'] ?> pcs</span></div>
                    </div>
                <?php endforeach; ?>
            </aside>
        </main>
    </div>
</body>
</html>