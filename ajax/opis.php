<?
session_start();
use Opis\JsonSchema\{
    Validator,
    ValidationResult,
    Errors\ErrorFormatter,
    SchemaLoader
};

require '../vendor/autoload.php';

if(isset($_POST)){

    require_once '../config/db_connect.php';

    $username = $_POST['username'];

    $query = "SELECT * FROM users WHERE username = ?";
    $stmt = $conn->prepare($query);
    $stmt->execute([
        $username,
        $password
    ]);
    $arr_result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $data = json_encode($arr_result, JSON_NUMERIC_CHECK);
    $json = json_decode($data);

    // Create a new validator
    $validator = new Validator();

    // Register our schema
    $validator->resolver()->registerFile(
        'http://localhost/schema/users.json', 
        __DIR__.'/schema/users.json'
    );

    /** @var ValidationResult $result */
    $result = $validator->validate($json,'http://localhost/schema/users.json');

    if ($result->isValid()) {
        // echo "Valid", PHP_EOL;
        header('Content-Type: application/json');
        echo $data;
    } else {
        // Print errors
        //print_r((new ErrorFormatter())->format($result->error()));
        echo `<script>alert('`. (new ErrorFormatter())->format($result->error()) .`')</script>`;
    }
}