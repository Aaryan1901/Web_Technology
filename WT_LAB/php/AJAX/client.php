<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AJAX CRUD Operations</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
        }
        /* Apply box-sizing: border-box to all elements inside the container */
        *,
        *::before,
        *::after {
            box-sizing: border-box;
        }

        .container {
            width: 80%;
            max-width: 800px;
            margin: 50px auto;
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            color: #333;
        }

        input[type="text"], input[type="email"], input[type="submit"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .button {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 10px;
            cursor: pointer;
            font-size: 16px;
        }
        .button:hover {
            background-color: #45a049;
        }
        .data-container {
            margin-top: 20px;
            background-color: #f9f9f9;
            padding: 15px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        .data-container ul {
            list-style-type: none;
            padding: 0;
        }
        .data-container li {
            padding: 8px;
            background-color: #fff;
            margin-bottom: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        .button-delete {
            background-color: #f44336;
            color: white;
            border: none;
            padding: 5px 10px;
            cursor: pointer;
            font-size: 12px;
        }
        .button-update {
            background-color: #ffa500;
            color: white;
            border: none;
            padding: 5px 10px;
            cursor: pointer;
            font-size: 12px;
        }
        .button-update:hover, .button-delete:hover {
            opacity: 0.8;
        }
    </style>
    <script>
        // Function to save data via AJAX (Create)
        function saveData() {
            var name = document.getElementById("name").value;
            var email = document.getElementById("email").value;

            // Check if the name and email are empty
            if (name == "" || email == "") {
                alert("Please fill in both name and email!");
                return;
            }

            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    alert("Data saved successfully!");
                    document.getElementById("name").value = ''; // Clear the input
                    document.getElementById("email").value = '';
                    loadData(); // Reload data after saving
                }
            };

            // Send AJAX request to save the data
            xhttp.open("POST", "ajax.php", true);
            xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhttp.send("action=save&name=" + name + "&email=" + email);
        }

        // Function to load saved data via AJAX (Read)
        function loadData() {
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    document.getElementById("savedData").innerHTML = this.responseText;
                }
            };

            // Send AJAX request to retrieve data
            xhttp.open("GET", "ajax.php?action=load", true);
            xhttp.send();
        }

        // Function to update a user's data
        function updateData(id) {
            var name = document.getElementById("name-" + id).value;
            var email = document.getElementById("email-" + id).value;

            if (name == "" || email == "") {
                alert("Please fill in both name and email!");
                return;
            }

            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    alert("Data updated successfully!");
                    loadData(); // Reload data after updating
                }
            };

            // Send AJAX request to update the data
            xhttp.open("POST", "ajax.php", true);
            xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhttp.send("action=update&id=" + id + "&name=" + name + "&email=" + email);
        }

        // Function to delete a user
        function deleteData(id) {
            if (confirm("Are you sure you want to delete this user?")) {
                var xhttp = new XMLHttpRequest();
                xhttp.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        alert("User deleted successfully!");
                        loadData(); // Reload data after deletion
                    }
                };

                // Send AJAX request to delete the data
                xhttp.open("POST", "ajax.php", true);
                xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                xhttp.send("action=delete&id=" + id);
            }
        }

        // Load data when page is loaded
        window.onload = loadData;
    </script>
</head>
<body>

    <div class="container">
        <h1>AJAX CRUD Operations</h1>

        <!-- Form to save data -->
        <input type="text" id="name" placeholder="Enter name">
        <input type="email" id="email" placeholder="Enter email">
        <input type="submit" value="Save Data" class="button" onclick="saveData()">

        <!-- Display saved data -->
        <div class="data-container">
            <h3>Saved Data:</h3>
            <div id="savedData">Loading...</div>
        </div>
    </div>

</body>
</html>
