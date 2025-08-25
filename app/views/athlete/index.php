<!DOCTYPE html>
<html>
<head>
    <title>List of Athletes at International Paralympic Committee</title>
</head>
<body>
    <h2>Registered Athletes</h2>
    <a href="/ipctask1/index.php?controller=athlete&action=create">Register New Athlete</a>
    <br><br>
    <table border="1" cellpadding="5" cellspacing="0">
        <thead>
            <tr>
                <th>ID</th>
                <th>Given Name</th>
                <th>Family Name</th>
                <th>Date of Birth</th>
                <th>Sport</th>
                <th>Personal Best Time</th>
            </tr>
        </thead>
        <tbody>
            <?php if(!empty($athletes)): ?>
                <?php foreach($athletes as $athlete): ?>
                    <tr>
                        <td><?= $athlete['id'] ?></td>
                        <td><?= htmlspecialchars($athlete['givenName']) ?></td>
                        <td><?= htmlspecialchars($athlete['familyName']) ?></td>
                        <td><?= $athlete['dateOfBirth'] ?></td>
                        <td><?= htmlspecialchars($athlete['sport']) ?></td>
                        <td><?= $athlete['personalBestTime'] ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr><td colspan="6">No athletes registered yet.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</body>
</html>