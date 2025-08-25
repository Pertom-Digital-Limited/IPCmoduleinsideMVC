<?php
require_once __DIR__ . '/../core/controller.php';
require_once __DIR__ . '/../models/athlete.php';
require_once __DIR__ . '/../models/sport.php';

class AthleteController extends Controller {
    private $athleteModel;
    private $sportModel;

    public function __construct() {
        $this->athleteModel = new Athlete();
        $this->sportModel   = new Sport();
    }

    // Show list of IPC athletes
    public function index() {
        $athletes = $this->athleteModel->getAll();
        $this->view('athlete/index', ['athletes' => $athletes]);
    }

    // Show registration form
    public function create() {
        $sports = $this->sportModel->getAll();
        $this->view('athlete/create', [
            'errors' => [],
            'old'    => [],
            'sports' => $sports
        ]);
    }

    // Handle Registration form submission
    public function store() {
        // Check if POST request
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("Location: /ipctask1/index.php?controller=athlete&action=create");
            exit;
        }

        $errors = [];
        $data = [
            'givenName'        => trim($_POST['givenName'] ?? ''),
            'familyName'       => trim($_POST['familyName'] ?? ''),
            'dateOfBirth'      => trim($_POST['dateOfBirth'] ?? ''),
            'sport_id'         => trim($_POST['sport_id'] ?? ''),
            'personalBestTime' => trim($_POST['personalBestTime'] ?? ''),
        ];

        // Validation
        if (empty($data['givenName'])) {
            $errors['givenName'] = "Given name is required.";
        } elseif (strlen($data['givenName']) < 3) {
            $errors['givenName'] = "Given name must be at least 3 characters.";
        }

        if (empty($data['familyName'])) {
            $errors['familyName'] = "Family name is required.";
        } elseif (strlen($data['familyName']) < 3) {
            $errors['familyName'] = "Family name must be at least 3 characters.";
        }

        if (empty($data['dateOfBirth'])) {
            $errors['dateOfBirth'] = "Date of birth is required.";
        } else {
            $dobTimestamp = strtotime($data['dateOfBirth']);
            if ($dobTimestamp === false) {
                $errors['dateOfBirth'] = "Invalid date format.";
            } else {
                $age = (int)((time() - $dobTimestamp) / (365*24*60*60));
                if ($age < 12) {
                    $errors['dateOfBirth'] = "Athlete must be at least 12 years old.";
                }
            }
        }

        if (empty($data['sport_id'])) {
            $errors['sport_id'] = "Please select a sport.";
        }

        if (empty($data['personalBestTime'])) {
            $errors['personalBestTime'] = "Personal best time is required.";
        } elseif (!preg_match('/^\d{1,2}:\d{2}:\d{2}$/', $data['personalBestTime'])) {
            $errors['personalBestTime'] = "Time must be in hh:mm:ss format (e.g., 01:23:45).";
        }

        // Insert or show form again
        if (empty($errors)) {
            try {
                $this->athleteModel->insert($data);
                header("Location: /ipctask1/index.php?controller=athlete&action=index");
                exit;
            } catch (Exception $e) {
                $errors['database'] = "Failed to save athlete. Please try again.";
                $sports = $this->sportModel->getAll();
                $this->view('athlete/create', [
                    'errors' => $errors,
                    'old'    => $data,
                    'sports' => $sports
                ]);
            }
        } else {
            $sports = $this->sportModel->getAll();
            $this->view('athlete/create', [
                'errors' => $errors,
                'old'    => $data,
                'sports' => $sports
            ]);
        }
    }
}