<!DOCTYPE html>
<html>
<head>
    <title>Register Athlete at International Paralympic Committee</title>
</head>
<body>
    <h2>Register New IPC Athlete</h2>
    <form method="POST" action="/ipctask1/index.php?controller=athlete&action=store">
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
        <select name="sport_id">
            <option value="">-- choose --</option>
            <?php
            $sports = [
                1 => 'athletics track',
                2 => 'swimming', 
                3 => 'cycling',
                4 => 'triathlon'
            ];
            foreach ($sports as $id => $sportName):
                $selected = (isset($old['sport_id']) && $old['sport_id'] == $id) ? 'selected' : '';
            ?>
                <option value="<?= $id ?>" <?= $selected ?>><?= ucfirst($sportName) ?></option>
            <?php endforeach; ?>
        </select>
        <span style="color:red;"><?= $errors['sport_id'] ?? '' ?></span><br><br>

        <label>Personal Best Time (hh:mm:ss):</label><br>
        <input type="text" name="personalBestTime" value="<?= htmlspecialchars($old['personalBestTime'] ?? '') ?>">
        <span style="color:red;"><?= $errors['personalBestTime'] ?? '' ?></span><br><br>

        <button type="submit">Register</button>
    </form>
    <br>
    <a href="/ipctask1/index.php?controller=athlete&action=index">Back to Athlete List</a>
</body>
</html>