<!DOCTYPE html>
<html>
<head>
    <title>Register Athlete at International Paralympic Comnittee</title>
</head>
<body>
    <h2>Register New Athlete</h2>
    <form method="POST" action="index.php?controller=athlete&action=create" method="post">
        <label>Given Name:</label><br>
        <input type="text" name="givenName" value="<?= htmlspecialchars($old['givenName'] ?? '') ?>">
        <span style="color:red;"><?= $errors['givenName'] ?? '' ?></span><br><br>

        <label>Family Name:</label><br>
        <input type="text" name="familyName" value="<?= htmlspecialchars($old['familyName'] ?? '') ?>">
        <span style="color:red;"><?= $errors['familyName'] ?? '' ?></span><br><br>

        <label>Date of Birth:</label><br>
        <input type="date" name="dateOfBirth" value="<?= htmlspecialchars($old['dateOfBirth'] ?? '') ?>">
        <span style="color:red;"><?= $errors['dateOfBirth'] ?? '' ?></span><br><br>

        <label>Sport:</label><br>
        <select name="sport">
            <?php
            $sports = [
        1 => 'athletics track',
        2 => 'swimming',
        3 => 'cycling',
        4 => 'triathlon'
    ];
            foreach ($sports as $sport):
                $selected = (isset($old['sport']) && $old['sport'] == $sport) ? 'selected' : '';
            ?>
                <option value="<?= $sport ?>" <?= $selected ?>><?= ucfirst($sport) ?></option>
            <?php endforeach; ?>
        </select><br><br>

        <label>Personal Best Time (hh:mm:ss):</label><br>
        <input type="text" name="personalBestTime" value="<?= htmlspecialchars($old['personalBestTime'] ?? '') ?>">
        <span style="color:red;"><?= $errors['personalBestTime'] ?? '' ?></span><br><br>

        <button type="submit">Register</button>
    </form>
    <br>
    <a href="/">Back to Athlete List</a>
</body>
</html>
