<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Placement Registration Form</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }
        .container {
            width: 60%;
            margin: auto;
            background: #fff;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        h1 {
            text-align: center;
        }
        .form-group {
            margin: 15px 0;
        }
        label {
            display: block;
            margin-bottom: 5px;
        }
        input, select, button {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        button {
            background: #007bff;
            color: white;
            border: none;
            cursor: pointer;
        }
        button:hover {
            background: #0056b3;
        }
        .error {
            color: red;
            font-size: 14px;
        }
        .success {
            color: green;
            font-size: 16px;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Placement Registration Form</h1>
        <?php
        $errors = [];
        $success = "";
        $name = $email = $phone = $dob = $roll = $cgpa = "";

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Validate Name (Alphabets and spaces only)
            $name = $_POST['name'];
            if (!preg_match('/^[a-zA-Z ]+$/', $name)) {
                $errors['name'] = "Name must contain only alphabets and spaces.";
            }

            // Validate Email
            $email = $_POST['email'];
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors['email'] = "Invalid email format.";
            }

            // Validate Phone Number (10 digits only)
            $phone = $_POST['phone'];
            if (!preg_match('/^[0-9]{10}$/', $phone)) {
                $errors['phone'] = "Phone number must be 10 digits.";
            }

            // Validate Date of Birth (YYYY-MM-DD)
            $dob = $_POST['dob'];
            if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $dob)) {
                $errors['dob'] = "Date of Birth must be in YYYY-MM-DD format.";
            }

            // Validate Roll Number (Alphanumeric)
            $roll = $_POST['roll'];
            if (!preg_match('/^[a-zA-Z0-9]+$/', $roll)) {
                $errors['roll'] = "Roll number must be alphanumeric.";
            }

            // Validate CGPA (Decimal between 0.0 to 10.0)
            $cgpa = $_POST['cgpa'];
            if (!preg_match('/^(10(\.0)?|[0-9](\.[0-9])?)$/', $cgpa)) {
                $errors['cgpa'] = "CGPA must be a valid decimal between 0.0 and 10.0.";
            }

            // Success message
            if (empty($errors)) {
                $success = "Registration Successful!";
                $name = $email = $phone = $dob = $roll = $cgpa = "";
            }
        }
        ?>
        <?php if ($success): ?>
            <div class="success"><?= $success ?></div>
        <?php endif; ?>
        <form method="POST">
            <div class="form-group">
                <label for="name">Full Name:</label>
                <input type="text" id="name" name="name" value="<?= htmlspecialchars($name) ?>">
                <?php if (isset($errors['name'])): ?><div class="error"><?= $errors['name'] ?></div><?php endif; ?>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="text" id="email" name="email" value="<?= htmlspecialchars($email) ?>">
                <?php if (isset($errors['email'])): ?><div class="error"><?= $errors['email'] ?></div><?php endif; ?>
            </div>
            <div class="form-group">
                <label for="phone">Phone Number:</label>
                <input type="text" id="phone" name="phone" value="<?= htmlspecialchars($phone) ?>">
                <?php if (isset($errors['phone'])): ?><div class="error"><?= $errors['phone'] ?></div><?php endif; ?>
            </div>
            <div class="form-group">
                <label for="dob">Date of Birth:</label>
                <input type="text" id="dob" name="dob" placeholder="YYYY-MM-DD" value="<?= htmlspecialchars($dob) ?>">
                <?php if (isset($errors['dob'])): ?><div class="error"><?= $errors['dob'] ?></div><?php endif; ?>
            </div>
            <div class="form-group">
                <label for="roll">Roll Number:</label>
                <input type="text" id="roll" name="roll" value="<?= htmlspecialchars($roll) ?>">
                <?php if (isset($errors['roll'])): ?><div class="error"><?= $errors['roll'] ?></div><?php endif; ?>
            </div>
            <div class="form-group">
                <label for="cgpa">CGPA:</label>
                <input type="text" id="cgpa" name="cgpa" value="<?= htmlspecialchars($cgpa) ?>">
                <?php if (isset($errors['cgpa'])): ?><div class="error"><?= $errors['cgpa'] ?></div><?php endif; ?>
            </div>
            <button type="submit">Register</button>
        </form>
    </div>
</body>
</html>
