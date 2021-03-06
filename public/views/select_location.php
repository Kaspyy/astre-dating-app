<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <link
            href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap"
            rel="stylesheet"
    />
    <title>Location | Astre</title>
    <link rel="stylesheet" href="public/css/style.css"/>
</head>
<body>
<div class="edit-profile-screen-background">
    <nav class="navbar">
        <h2>LOCATION</h2>
        <a href="/edit_profile" class="done-button">Done</a>
    </nav>
    <div class="select-gender-settings-screen">
        <form action="updateUserLocation" method="post">
                <input type="text" class="input-field" name="location" value="<?=$userLocation->getLocation();?>">
            <button class="btn" id="selectButton" type="submit">Update</button>
        </form>
    </div>
</div>
</div>
<script
        src="https://kit.fontawesome.com/8a50b84207.js"
        crossorigin="anonymous"
></script>
</body>
</html>
