<?php
require_once __DIR__ . '/../core/Controller.php';
require_once __DIR__ . '/../models/Athlete.php';

class AthleteController extends Controller {
    private $athleteModel;

    public function __construct() {
        $this->athleteModel = new Athlete();
    }

    // Show list of IPC athletes
    public function index() {
        $athletes = $this->athleteModel->getAll();
        $this->view('athlete/index', ['athletes' => $athletes]);
    }

    // Show registration form
    public function create() {
        $this->view('athlete/create', ['errors' => [], 'old' => []]);
    }

    // Handle Registration form submission
    public function store() {
        $errors = [];
        $data = [
            'givenName' => trim($_POST['givenName'] ?? ''),
            'familyName' => trim($_POST['familyName'] ?? ''),
            'dateOfBirth' => trim($_POST['dateOfBirth'] ?? ''),
            'sport' => trim($_POST['sport'] ?? ''),
            'personalBestTime' => trim($_POST['personalBestTime'] ?? ''),
        ];

        // Manual validation of atleast 3 characters for names
        if (strlen($data['givenName']) < 3) {
            $errors['givenName'] = "Given name must be at least 3 characters.";
        }
        if (strlen($data['familyName']) < 3) {
            $errors['familyName'] = "Family name must be at least 3 characters.";
        }
        // Age ≥ 12 manual validation from the date of registration
        $dobTimestamp = strtotime($data['dateOfBirth']);
        $age = (int)((time() - $dobTimestamp) / (365*24*60*60));
        if ($age < 12) {
            $errors['dateOfBirth'] = "Athlete must be at least 12 years old.";
        }
        // Time format hh:mm:ss
        if (!preg_match('/^\d{1,2}:\d{2}:\d{2}$/', $data['personalBestTime'])) {
            $errors['personalBestTime'] = "Time must be in hh:mm:ss format.";
        }

        if (empty($errors)) {
            $this->athleteModel->insert($data);
            header("Location: /");
            exit;
        } else {
            $this->view('athlete/create', ['errors' => $errors, 'old' => $data]);
        }
    }
}
