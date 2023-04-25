<?php
if (session_id() == '')
    session_start();

if (!isset($_SESSION['usersData']))
    $_SESSION['usersData'] = require 'data/usersData.php';

if (!isset($_SESSION['user'])) {
    $_SESSION['page'] = 'login';
    header('Location: index.php');
}

$userData = $_SESSION['usersData'][$_SESSION['user']];

$name = $userData['name'];
$surname = $userData['surname'];
$dateOfBirth = $userData['dateOfBirth'];
$description = $userData['description'];
$pathToImage = $userData['imagePath'];

if ($pathToImage === '') {
    $pathToImage = 'images/usersAvatars/empty-photo.jpg';
}

$target_dir = "images/";
$target_file = $target_dir . basename($_FILES["userPic"]["name"]);
move_uploaded_file($_FILES["userPic"]["tmp_name"],
    $_SERVER['DOCUMENT_ROOT'] . dirname($_SERVER['PHP_SELF']) . "/" . $target_file)
?>

<?php
if (isset($_SESSION['profileEditError'])) {
    echo '<div class="error-message">' . $_SESSION['profileEditError'] . '</div>';
    unset($_SESSION['profileEditError']);
}
?>
<form action="profileHandler.php" method="post" enctype="multipart/form-data" class="profile-form">
    <div class="profile-wrapper">
        <div class="image-container">
            <img id="user-avatar" src="<?php echo $pathToImage; ?>"/> <br/>

            <input class="input-button upload-button" type="file" value="Upload" name="userAvatar">
        </div>
        <div class="user-data-container">
            <div class="nameRow">
                <div class="input-with-label">
                    <p>Name</p><br/>
                    <input type="text" placeholder="Name"
                           name="name" required="required"
                           onblur="this.value = this.value.trim();"
                           value="<?php echo $name; ?>"
                    >
                </div>
                <div class="input-with-label">
                    <p>Surname</p><br/>
                    <input type="text" placeholder="Surname"
                           name="surname" required="required"
                           onblur="this.value = this.value.trim();"
                           value="<?php echo $surname; ?>"
                    >
                </div>
                <div class="input-with-label">
                    <p>Date of birth</p><br/>
                    <input type="date" placeholder="Date"
                           name="dateOfBirth" required="required"
                           value="<?php echo $dateOfBirth; ?>"
                    >
                </div>
            </div>
            <div class="description">
                <div class="input-with-label">
                    <p>Description</p>
                    <textarea type="text" placeholder="Description" name="description" required="required"
                              onblur="this.value = this.value.trim();" style="resize: none;"
                    ><?php echo $description; ?></textarea>
                </div>
            </div>
            <input class="save-data-button" type="submit" value="Зберегти">
        </div>
    </div>
</form>

