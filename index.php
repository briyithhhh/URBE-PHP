<?php

session_start();

class User {
  public $name;
  public $lastname;
  public $dni;
  public $math;
  public $physics;
  public $programming;

  public function __construct($name, $lastname, $dni, $math, $physics, $programming) {
    $this->name = $name;
    $this->lastname = $lastname;
    $this->dni = $dni;
    $this->math = $math;
    $this->physics = $physics;
    $this->programming = $programming;
  }
}

if (!isset($_SESSION['users'])) {
  $_SESSION['users'] = [];
}

$users = $_SESSION['users'];

function addUser($name, $lastname, $dni, $math, $physics, $programming, &$users) {
  $users[] = new User($name, $lastname, $dni, $math, $physics, $programming);
}

function displayUsers($users) {
  echo "<table>";
  echo "<tr>";
  echo "<th>Name</th>";
  echo "<th>Last Name</th>";
  echo "<th>DNI</th>";
  echo "<th>Math</th>";
  echo "<th>Physics</th>";
  echo "<th>Programming</th>";
  echo "</tr>";
  foreach ($users as $user) {
    echo "<tr>";
    echo "<td>" . $user->name . "</td>";
    echo "<td>" . $user->lastname . "</td>";
    echo "<td>" . $user->dni . "</td>";
    echo "<td>" . $user->math . "</td>";
    echo "<td>" . $user->physics . "</td>";
    echo "<td>" . $user->programming . "</td>";
    echo "</tr>";
  }
  echo "</table>";
}

if (isset($_POST['submit'])) {
  $name = $_POST['name'];
  $lastname = $_POST['lastname'];
  $dni = $_POST['dni'];
  $math = $_POST['math'];
  $physics = $_POST['physics'];
  $programming = $_POST['programming'];

  addUser($name, $lastname, $dni, $math, $physics, $programming, $users);
  $_SESSION['users'] = $users;
 
   // Unset the values of $_POST to reset the form
   unset($_POST['name']);
   unset($_POST['lastname']);
   unset($_POST['dni']);
   unset($_POST['math']);
   unset($_POST['physics']);
   unset($_POST['programming']);
  // Redirect the user back to the form page
  header("Location: " . $_SERVER['PHP_SELF']);
  exit;
}

$mathMax = 0;
$physicsMax = 0;
$programmingMax = 0;
$numLessThan10 = 0;
$numMoreThan10 = 0;
$numAllMoreThan10 = 0;
$numTwoMoreThan10 = 0;
$numOneMoreThan10 = 0;
$gpaSum = 0;

foreach ($users as $user) {
  $math = $user->math;
  $physics = $user->physics;
  $programming = $user->programming;
  $gpa = ($math + $physics + $programming) / 3;

  $gpaSum += $gpa;

  if ($math > $mathMax) {
      $mathMax = $math;
  }
  if ($physics > $physicsMax) {
      $physicsMax = $physics;
  }
  if ($programming > $programmingMax) {
      $programmingMax = $programming;
  }

  if ($gpa < 10) {
      $numLessThan10++;
  } else {
      $numMoreThan10++;
  }

  if ($math >= 10 && $physics >= 10 && $programming >= 10) {
      $numAllMoreThan10++;
  }

  if ($math >= 10 && $physics >= 10 || $math >= 10 && $programming >= 10 || $physics >= 10 && $programming >= 10) {
      $numTwoMoreThan10++;
  }

  if ($math >= 10 || $physics >= 10 || $programming >= 10) {
      $numOneMoreThan10++;
  }
}

$gpaAvg = 0;

if (count($users) > 0) {
  $gpaAvg = $gpaSum / count($users);
}

echo "Nota promedio de todos los estudiantes: " . $gpaAvg . "<br>";
echo "Estudiantes aprobados: " . $numLessThan10 . "<br>";
echo "Estudiantes reprobados: " . $numMoreThan10 . "<br>";
echo "Estudiantes con todas las materias aprobadas: " . $numAllMoreThan10 . "<br>";
echo "Estudiantes con 2 aprobadas: " . $numTwoMoreThan10 . "<br>";
echo "Estudiantes con 1 aprobada: " . $numOneMoreThan10 . "<br>";
echo "Nota maxima en Matematicas: " . $mathMax . "<br>";
echo "Nota maxima en Fisica: " . $physicsMax . "<br>";
echo "Nota maxima en Programacion: " . $programmingMax . "<br><br><br>";

?>

<form method="post">
  <label for="name">Name:</label>
  <input type="text" min="3" max="14" name="name" id="name" required>
  <br>
  <label for="lastname">Last Name:</label>
  <input type="text" min="3" max="14" name="lastname" id="lastname" required>
  <br>
  <label for="dni">DNI:</label>
  <input type="number" name="dni" id="dni" min="1" max="99999999" required>
  <br>
  <label for="math">Math:</label>
  <input type="number" name="math" min="0" max="20" id="math" required>
  <br>
  <label for="physics">Physics:</label>
  <input type="number" name="physics" min="0" max="20" id="physics" required>
  <br>
  <label for="programming">Programming:</label>
  <input type="number" name="programming" min="0" max="20" id="programming" required>
  <br>
  <input type="submit" name="submit" value="Submit">
</form>
<br>
<?php

  displayUsers($users);

?>