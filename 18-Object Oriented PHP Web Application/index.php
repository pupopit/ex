<?php
// Database configuration
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "forum";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Base Member Class
class Member {
    protected $username;
    protected $email;

    public function __construct($username, $email) {
        $this->username = $username;
        $this->email = $email;
    }

    public function login() {
        return "$this->username has logged in.";
    }

    public function logout() {
        return "$this->username has logged out.";
    }

    public function createPost($title, $content) {
        global $conn;
        $stmt = $conn->prepare("INSERT INTO posts (title, content, author) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $title, $content, $this->username);
        $stmt->execute();
        $stmt->close();
        return "$this->username created a post titled '$title'.";
    }

    public function editProfile($newEmail) {
        $this->email = $newEmail;
        return "$this->username updated their profile with email: $this->email.";
    }

    public function showProfile() {
        return "Username: $this->username, Email: $this->email";
    }
}

// Administrator Class extending Member
class Administrator extends Member {

    public function createForum($forumName) {
        global $conn;
        $stmt = $conn->prepare("INSERT INTO forums (name) VALUES (?)");
        $stmt->bind_param("s", $forumName);
        $stmt->execute();
        $stmt->close();
        return "Forum '$forumName' has been created by $this->username.";
    }

    public function deleteForum($forumId) {
        global $conn;
        $stmt = $conn->prepare("DELETE FROM forums WHERE id = ?");
        $stmt->bind_param("i", $forumId);
        $stmt->execute();
        $stmt->close();
        return "Forum with ID $forumId has been deleted by $this->username.";
    }

    public function banMember($memberUsername) {
        return "$this->username banned the member: $memberUsername.";
    }

    // Overriding the login method
    public function login() {
        return "Administrator $this->username has logged in with elevated privileges.";
    }

    // Overriding the logout method
    public function logout() {
        return "Administrator $this->username has logged out with elevated privileges.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Forum Application</title>
</head>
<body>
    <h1>Welcome to the Forum</h1>

    <form method="post" action="">
        <h2>Create Post</h2>
        <label>Title:</label>
        <input type="text" name="title" required><br>
        <label>Content:</label>
        <textarea name="content" required></textarea><br>
        <button type="submit" name="createPost">Create Post</button>
    </form>

    <form method="post" action="">
        <h2>Create Forum (Admin Only)</h2>
        <label>Forum Name:</label>
        <input type="text" name="forumName" required><br>
        <button type="submit" name="createForum">Create Forum</button>
    </form>

    <?php
    session_start();

    if (!isset($_SESSION['user'])) {
        $_SESSION['user'] = new Member("JohnDoe", "john@example.com");
        $_SESSION['admin'] = new Administrator("AdminJane", "admin@example.com");
    }

    $user = $_SESSION['user'];
    $admin = $_SESSION['admin'];

    if (isset($_POST['createPost'])) {
        echo $user->createPost($_POST['title'], $_POST['content']);
    }

    if (isset($_POST['createForum'])) {
        echo $admin->createForum($_POST['forumName']);
    }
    ?>

</body>
</html>