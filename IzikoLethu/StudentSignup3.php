<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $_SESSION['university'] = $_POST['university'];
    $_SESSION['campus'] = $_POST['campus'];

    header("Location: Process_StudentSignup.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Sign Up</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header class="text-center py-3">
        <div class="container d-flex justify-content-between align-items-center">
            <div class="fw-bold fs-4">
                <a href="HomePage.html"><img src="images/default.png" class="logo"></a>
            </div>
        </div>
    </header>

    <div class="card container vh-50 d-flex justify-content-center align-items-center" style="width: 700px;">
        <form method="POST" class="w-50">
            <h3 class="mb-3 text-center">Sign up</h3>
            <h3 class="mb-3 text-center">Step 3: University & Campus</h3>

            <select id="university" name="university" class="form-select mb-3" required>
                <option value="" disabled selected>Select University</option>
                <?php
                $universities = [
                    "University of Cape Town" => ["Breakwater", "Groote Schuur", "Health Science", "Hiddingh", "Lower", "Middle", "Upper"],
                    "University of Pretoria" => ["Hatfield", "Hillcrest", "Groenkloof", "Illovo", "Prinshof", "Onderstepoort"],
                    "Stellenbosch University" => ["Bellville Park", "Saldanha", "Stellenbosch", "Tygerberg", "Worcester"],
                    "University of the Witwatersrand" => ["Braamfontein", "East", "Parktown", "West"],
                    "University of KwaZulu-Natal" => ["Edgewood", "Howard College", "Medical School", "Pietermaritzburg", "Westville"],
                    "University of Johannesburg" => ["Bunting Road", "Doornfontein", "Kingsway", "Soweto"],
                    "Rhodes University" => ["Makhanda/Grahamstown"],
                    "University of the Western Cape" => ["Bellville", "Mitchell's Plain", "Tygerberg"],
                    "University of Fort Hare" => ["Alice", "East London", "Bhisho"],
                    "University of Limpopo" => ["Turfloop"],
                    "North-West University" => ["Mafikeng", "Potchefstroom", "Vanderbijlpark"],
                    "University of Free State" => ["Bloemfontein", "QwaQwa", "South"],
                    "Cape Peninsula University of Technology" => ["Bellville", "District 6", "Granger Bay", "Groote Schuur", "Mowbary", "Tygerberg", "Wellington"],
                    "Durban University of Technology" => ["City", "Indumiso", "Ritson", "Riverside", "Steve Biko"],
                    "Tshwane University of Technology" => ["Arcadia", "Arts", "eMalahleni", "Ga-Rankuwa", "Soshanguve North", "Soshanguve South", "Mbombela", "Polokwane"],
                    "Vaal University of Technology" => ["Ekurhuleni", "Secunda", "Upington", "Vanderbijlpark"],
                    "Central University of Technology" => ["Bloemfontein", "Welkom"],
                    "Mangosuthu University of Technology" => ["Umlazi"],
                    "Nelson Mandela University" => ["Bird Street", "George", "Missionvale", "North", "Second Avenue", "South", "Ocean Sciences"],
                ];
                foreach ($universities as $uni => $campuses) {
                    $selected = (($_SESSION['university'] ?? '') == $uni) ? 'selected' : '';
                    echo "<option value='$uni' $selected>$uni</option>";
                }
                ?>
            </select>

            <select id="campus" name="campus" class="form-select mb-3" required>
                <option value="" disabled selected>Select Campus</option>
                <?php
                if (!empty($_SESSION['university'])) {
                    $selectedUni = $_SESSION['university'];
                    foreach ($universities[$selectedUni] as $camp) {
                        $selected = (($_SESSION['campus'] ?? '') == $camp) ? 'selected' : '';
                        echo "<option value='$camp' $selected>$camp</option>";
                    }
                }
                ?>
            </select>

            <button type="submit" class="btn btn-ghost w-100">Sign Up</button>
            <p class="mt-3 text-center">
                <a href="StudentSignUp2.php" class="back-link">Back</a>
            </p>
        </form>
    </div>

    <footer class="py-3 mt-3">
        <div class="container">

            <div class="d-flex justify-content-between align-items-center mb-3">

                <div class="fw-bold fs-4">
                    <a><img src="images/default.png" class="logo"></a>
                </div>

                <div>
                    <a href="AboutUs.html" class="me-3 text-decoration-none text-dark">About us</a>
                    <a href="WhatWeOffer.html" class="me-3 text-decoration-none text-dark">What we offer</a>
                    <a href="Landlord.html" class="me-3 text-decoration-none text-dark">Landlord login</a>
                </div>

                <div>
                    <a href="#" class="me-2 text-dark"><i class="bi bi-instagram"></i></a>
                    <a href="#" class="me-2 text-dark"><i class="bi bi-facebook"></i></a>
                    <a href="#" class="text-dark"><i class="bi bi-twitter"></i></a>
                </div>
            </div>

            <div class="text-center small text-muted pt-3">
                <p class="mb-0">
                    &copy; 2024 Your Website. All rights reserved. 
                    <a href="#" class="ms-2 text-decoration-none text-muted">Privacy Policy</a>
                    <a href="#" class="ms-2 text-decoration-none text-muted">Terms of Service</a>
                </p>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const uniSelect = document.getElementById('university');
        const campusSelect = document.getElementById('campus');

        const campuses = {
            "University of Cape Town": ["Breakwater", "Groote Schuur", "Health Science", "Hiddingh", "Lower", "Middle", "Upper"],
            "University of Pretoria": ["Hatfield", "Hillcrest", "Groenkloof", "Illovo", "Prinshof", "Onderstepoort"],
            "Stellenbosch University": ["Bellville Park", "Saldanha", "Stellenbosch", "Tygerberg", "Worcester"],
            "University of the Witwatersrand": ["Braamfontein", "East", "Parktown", "West"],
            "University of KwaZulu-Natal": ["Edgewood", "Howard College", "Medical School", "Pietermaritzburg", "Westville"],
            "University of Johannesburg": ["Bunting Road", "Doornfontein", "Kingsway", "Soweto"],
            "Rhodes University": ["Makhanda/Grahamstown"],
            "University of the Western Cape": ["Bellville", "Mitchell's Plain", "Tygerberg"],
            "University of Fort Hare": ["Alice", "East London", "Bhisho"],
            "University of Limpopo": ["Turfloop"],
            "North-West University": ["Mafikeng", "Potchefstroom", "Vanderbijlpark"],
            "University of Free State": ["Bloemfontein", "QwaQwa", "South"],
            "Cape Peninsula University of Technology": ["Bellville", "District 6", "Granger Bay", "Groote Schuur", "Mowbary", "Tygerberg", "Wellington"],
            "Durban University of Technology": ["City", "Indumiso", "Ritson", "Riverside", "Steve Biko"],
            "Tshwane University of Technology": ["Arcadia", "Arts", "eMalahleni", "Ga-Rankuwa", "Soshanguve North", "Soshanguve South", "Mbombela", "Polokwane"],
            "Vaal University of Technology": ["Ekurhuleni", "Secunda", "Upington", "Vanderbijlpark"],
            "Central University of Technology": ["Bloemfontein", "Welkom"],
            "Mangosuthu University of Technology": ["Umlazi"],
            "Nelson Mandela University": ["Bird Street", "George", "Missionvale", "North", "Second Avenue", "South", "Ocean Sciences"]
        };

        uniSelect.addEventListener('change', function() {
            const selected = this.value;
            campusSelect.innerHTML = '<option value="" disabled selected>Select Campus</option>';
            if (campuses[selected]) {
                campuses[selected].forEach(c => {
                    const opt = document.createElement('option');
                    opt.value = c;
                    opt.textContent = c;
                    campusSelect.appendChild(opt);
                });
                campusSelect.disabled = false;
            }
        });
    </script>
</body>
</html>