<?php

  use Dotenv\Dotenv;

  // Load Composer's autoloader.
  require_once "./vendor/autoload.php";
  $dotenv = Dotenv::createImmutable("./.env");
  $dotenv->safeload();

  /**
   * This class implements a full fledged authentication system with user
   * registration and login. It also stores values onto database and 
   * fetches results from database.
   */
  class NameDetails {

    /**
     *  @var object $conn
     *    To store the connection object.
     */
    private $conn;

    /**
     * Constructor establishes database connection.
     */
    public function __construct() {
      // Fetching Database details from environment variable.
      require __DIR__ . '/vendor/autoload.php';
      $dotenv = Dotenv::createImmutable(__DIR__);
      $dotenv->safeload();
      // Fetching Database details.
      $serverName = $_ENV['SERVERNAME'];
      $userName = $_ENV["USERNAME"];
      $password = $_ENV['PASSWORD'];
      $dbName = $_ENV['DBNAME'];
      try {
        $this->conn = new PDO("mysql:host=$serverName;dbname=$dbName", $userName, $password);
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      }
      // Handling database errors.
      catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
      }
    }

      /**
       * This function redirects to a specfic url.
       * 
       *  @param string $redirectLocation.
       *    Stores the path, where to redirect.
       */
      public function redirect(string $redirectLocation) {
        header("Location: " . $redirectLocation);
      }

      /**
       * This function tests the inputted data and strips off the unnecessary parts.
       * 
       *  @param string $data
       *    Trims data from spaces and slashes, from the passed parameter.
       * 
       *  @return string
       *    Returns the trimmed data in turn.
       */
      public function testInput(string $data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
      }

      /**
       * This function checks for validation of firstName and lastName.
       * 
       *  @param string $data 
       *    Accepts data as parameter and checks for validation on that particular passed parameter.
       * 
       *  @return bool
       *    Returns a boolean type data.
       */
      public function match(string $data) {
          return preg_match("/^[a-zA-Z-' ]*$/", $data);
      }

      /**
       * This function checks whether the input field is empty or not.
       * 
       *  @param string $data
       *    Accepts data as parameter checks whether the passed parameter is empty or not.
       * 
       *  @return bool
       *    Returns a boolean type data.
       */
      public function isEmpty(string $data) {
        return empty($data);
      }

      /**
       * This function accepts phoneno from the user and check for its validation.
       * 
       *  @param string $data
       *    Accepts data as parameter, strips it off from spaces and slashes 
       *    Finally checks for its validation for 13 digit including country code
       *    The function also checks whether the string consists of only numbers or not.
       * 
       *  @return string
       *    Returns a string with an error message.
       */
      public function validating(string $data) {
        $data = trim($data);
        if (!$this->isEmpty($data)) {
          if (preg_match('/^\+91\d{10}$/', $data)) {
            $_SESSION['phone'] = $data;
          } 
          return "Invalid Phone Number";
        } 
        return "Phone Number Can't Be Empty";
      }

      /**
       * This function accepts email from the user and check for its validation.
       * 
       *  @param string $email
       *   Accepts data as parameter and verifies for authentic emailid according 
       *   to sytax and domain and echos a response.
       * 
       *  @return bool
       *    returns boolean.
       */
      public function emailValidate(string $email) {
        // Initializing object of GuzzleHttp.
        $client = new \GuzzleHttp\Client();
        $apikey = $_ENV['APIKEY'];
        // Fetching json response.
        $res = $client->request('GET', "https://emailvalidation.abstractapi.com/v1/?api_key=$apikey&email=$email");
        // Decoding the json response.
        $validationResult = json_decode($res->getBody(), TRUE);
        // If the email is valid, do the following.
        return $validationResult["is_smtp_valid"]["value"];
      }

      /**
       * This function lets the user login on providing correct credentials.
       * 
       *  @param array $loginDetails
       *    Takes the user credentials to log the user in.
       */
      public function login(array $loginDetails) {
        // Accepting login credentials.
        $userEmail = $loginDetails["loginEmail"];
        $userPassword = md5($loginDetails["loginPassword"]);
        // Authenticating login email and password against the database.
        try {
          $statement = $this->conn->prepare("SELECT EmailId, UserRole FROM Registration_Details WHERE EmailId='$userEmail' AND UserPassword='$userPassword'");
          $statement->execute();
          $row = $statement->fetch();
          $role = $row['userRole'];
          // Counting rows fetched by querying through the DB.
          $count = $statement->rowCount();
          // Storing the count in a session variable.
          $_SESSION['count'] = $count;
          // Authenticating for valid credentials.
          if ($count) {
            // Logging in the user on providing valid credentials.
            $_SESSION['logged'] = TRUE;
            $_SESSION['loginemail'] = $userEmail;
            if ($role == 'Admin') {
              $this->redirect("addPlayer.php");
            }
            $this->redirect("index.php");
          } 
          else {
            // Redirecting back to the registration page on providing wrong credentials.
            $this->redirect("registration.php");
          }
        }
        catch (PDOException $e) {
          die("Something went wrong:" . $e->getMessage());
        }
      }

      
      /**
       * This function is used to register a new user.
       *
       *  @param array $userDetails
       *    Takes all user information and registers the user.
       * 
       *  @return mixed
       *    Registers the user onto the system and redirects to the login page on 
       *    successful registration else throws an error message if any error occurs.
       */
      public function register(array $userDetails) {
      // Initialising variable $inputfirstName.
      $inputFirstName = $userDetails["firstName"];
      // Initialising variable $inputlastName.
      $inputLastName = $userDetails["lastName"];
      // Initialising variable $inputPhone.
      $inputPhone = $userDetails["phone"];
      // Initialising variable $inputEmail.
      $inputEmail = $userDetails["regEmail"];
      // Initialising variable $inputPassword.
      $inputPassword = md5($userDetails["userPassword"]);
      // Initialising variable $userRole.
      $userRole = $userDetails["userRole"];
      // isEmpty function call.
      $empty = $this->isEmpty($inputFirstName);
      $empty = $this->isEmpty($inputLastName);
      $empty = $this->isEmpty($inputPhone);
      $empty = $this->isEmpty($inputEmail);
      $empty = $this->isEmpty($inputPassword);
      if (!$empty) {
        // test_input function call.
        $inputFirstName = $this->testInput($inputFirstName);
        // test_input function call.
        $inputLastName = $this->testInput($inputLastName);
        // match function call.
        $fnamecondition = $this->match($inputFirstName);
        // match function call.
        $lnamecondition = $this->match($inputLastName);
      }
      if ($fnamecondition == FALSE || $lnamecondition == FALSE || $empty == TRUE) {
        $this->redirect("registration.php");
      } 
      else {
        // Initialising Session variable fname.
        $_SESSION['fName'] = $inputFirstName;
        // Initialising Session variable lname.
        $_SESSION['lName'] = $inputLastName;
        // Initialising Session variable phone.
        $_SESSION['phone'] = $inputPhone;
        // Initialising Session variable email.
        $_SESSION['email'] = $inputEmail;
        // Initialising Session variable userpassword.
        $_SESSION['userpassword'] = $inputPassword;
        // Initialising Session variable preferredGenres.
        $_SESSION['userRole'] = $userRole;
        $userRole = implode(',', $_SESSION['userRole']);
        // prepare sql and bind parameters
        try {
          $statement = $this->conn->prepare("INSERT INTO Registration_Details (FirstName, LastName, Phone, EmailId, UserPassword, UserRole)
          VALUES (:fname, :lname, :phone, :emailid, :userpassword, :userRole)");
          $statement->bindParam(':fname', $_SESSION['fName']);
          $statement->bindParam(':lname', $_SESSION['lName']);
          $statement->bindParam(':phone', $_SESSION['phone']);
          $statement->bindParam(':emailid', $_SESSION['email']);
          $statement->bindParam(':userpassword', $_SESSION['userpassword']);
          $statement->bindParam(':userRole', $userRole);
          $statement->execute();
          $this->redirect("login.php");
        }
        catch (PDOException $e) {
          die("Something went wrong:" . $e->getMessage());
        }
        
      }
    }

    /**
     * This function is used to fetch data from a specific table.
     *
     *  @param  string $table
     *    Takes the table name from which to fetch the data.
     * 
     *  @return mixed
     *    Returns a PDO statement object on successful execution of query else
     * throws an error message.
     */
    public function showData(string $table) {
      try {
      $statement = $this->conn->query("SELECT * FROM $table");
      return $statement;
      }
      catch (PDOException $e) {
        die("Something went wrong:" . $e->getMessage());
      }
    }
    
    /**
     * This function is used to upload new player details by admin.
     *
     *  @param  array $uploadDetails
     *    Takes all the necessary details for uploading new entries.
     * 
     *  @return mixed
     *    Inserts the data else prints out the error message
     */
    public function upload(array $uploadDetails, string $tableName) {
      try {
        $this->insertQuery($uploadDetails, $tableName);
      }
      catch (PDOException $e) {
        die("Something went wrong:" . $e->getMessage());
      }
    }
    
    /**
     * This function is used to insert new player details onto the system.
     *
     *  @param  array $uploadDetails
     *    Taking all the necessary details for uploading new player information onto 
     *    the database.
     * 
     *  @param string $tableName
     *    Gets the table name on which to insert data
     * 
     *  @return mixed
     *    Inserts the data else prints out the error message.
     */
    public function insertQuery(array $uploadDetails, string $tableName) {
      try {
        $statement = $this->conn->prepare("INSERT INTO $tableName (EmpId, EmpName, EmpType, EmpPoint)
        VALUES (:eid, :ename, :etype, :epoint)");
        $statement->bindParam(':eid', $uploadDetails['empId']);
        $statement->bindParam(':ename', $uploadDetails['empName']);
        $statement->bindParam(':etype', $uploadDetails['empType']);
        $statement->bindParam(':epoint', $uploadDetails['empPoint']);
        $statement->execute();
      } 
      catch (PDOException $e) {
        die("Something went wrong:" . $e->getMessage());
      }
    }
        
    /**
     * This function is used to save the team made by a user.
     *
     *  @param  array $selectedPlayers
     *    Takes the selected player details.
     * 
     *  @return mixed
     *    Inserts the data else prints out the error message.
     */
    public function saveTeam(array $selectedPlayers) {
      try {
        $this->insertQuery($selectedPlayers, "MyTeam");
      }
      catch (PDOException $e) {
        die("Something went wrong:" . $e->getMessage());
      }
    }

  }

?>
